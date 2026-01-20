<?php

namespace App\Helpers\Imports;

use App\Models\Customer;
use App\Models\ImportClaim;
use App\Models\ImportClaimRevertHistory;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use App\Models\InsuranceWorkedBy;
use App\Models\User;
use App\Rules\ClaimClientCheckRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportRevertHelper
{

    public mixed $clientId;
    public ?ImportClaim $importClaim;
    public ?User $user;

    public mixed $updatedTime;

    public $startTime;
    public $endTime;

    public function rules():array
    {
        return [
            "Client ID"=>[
                'required',
                'exists:customers,id',
                new ClaimClientCheckRule($this->user),
            ],
            'INS Name'=>'required|max:255',
            'INS Ph No'=>'max:255',
            'SUB NAME'=>'max:255',
            'SUB ID'=>'max:255',
            'Patient ID'=>'max:255',
            'PATIENT NAME'=>'max:255',
            'DOB'=>'nullable',
            'DOS'=>'nullable',
            'SENT'=>'nullable',
            'TOTAL $$'=>'nullable|numeric',
            'DAYS'=>'max:255',
            'DAYS-R'=>'max:255',
            'Prov Nm'=>'max:255',
            'Location'=>'max:255',
        ];
    }
    public function __construct($importClaim)
    {
        $this->user = Auth::user();
        $this->importClaim = $importClaim;
        $this->updatedTime = Carbon::parse($importClaim->updated_at);
        $this->clientId = $importClaim->client_id;

        // Define the time range for the deleted_at column
        $this->startTime = $this->updatedTime->copy()->subHour()->format('Y-m-d H:i:s');
        $this->endTime = $this->updatedTime->copy()->format('Y-m-d H:i:s');
    }
    public function revert()
    {
        if ($this->importClaim->revertHistory()->exists())
        {

            foreach ($this->importClaim->revertHistory()->where('is_reverted',0)->get() as $item)
            {

                $claim = InsuranceClaim::withTrashed()->where('id',$item->claim_id)->first();

                if ($claim)
                {
                    switch ($item->type)
                    {
                        case ImportClaimRevertHistory::TYPE_ADDED:
                            $claim->forceDelete();
                            break;
                        case ImportClaimRevertHistory::TYPE_UPDATED:
                            break;
                        default:
                            $claim->restore();
                    }
                }

                $item->is_reverted = 1;
                $item->save();

            }

            return [
                'success'=>true,
                'message'=>'Revert successfully',
            ];
        }
        else
        {
            return $this->revertWithOldImport();
        }
    }

    public function revertWithOldImport(): array
    {

        try
        {
            $path = $this->importClaim->getFilePath();
            $collection = (new FastExcel)->import($path);

        }
        catch (\Exception $e)
        {
            return [
                'success'=>false,
                'message'=>"Can't get data from excel file",
            ];
        }

        foreach ($collection as $item)
        {

            $item['Client ID'] = $this->clientId ??null;

            $item['TOTAL $$'] = $item['TOTAL $$'] === '' ? null : $item['TOTAL $$'];

            $validator = Validator::make($item,$this->rules());


            if ($validator->fails())
            {
                continue;
            }


            $data = $this->parseImportData($item);

            $insuranceClaim = $this->findInsuranceClaim(
                $this->clientId,
                $data
            );

            if ($insuranceClaim)
            {
                ImportClaimRevertHistory::create([
                    'import_claim_id'=>$this->importClaim->id,
                    'claim_id'=>$insuranceClaim->id,
                    'type'=>ImportClaimRevertHistory::TYPE_ADDED,
                    'is_reverted'=>1,
                ]);

                $insuranceClaim->forceDelete();
            }
            else
            {
                $insuranceClaim = $this->findInsuranceClaimUpdated(
                    $this->clientId,
                    $data
                );

                if($insuranceClaim)
                {
                    ImportClaimRevertHistory::create([
                        'import_claim_id'=>$this->importClaim->id,
                        'claim_id'=>$insuranceClaim->id,
                        'type'=>ImportClaimRevertHistory::TYPE_UPDATED,
                        'is_reverted'=>1,
                    ]);
                }
            }

        }

        $this->recoverInsuranceClaimWithTrash();

        return [
            'success'=>true,
            'message'=>'Revert successfully',
        ];
    }

    public function parseImportData($item = []):array
    {
        $claimStatus = InsuranceClaimStatus::where('name','LIKE',$item['Claim Status'] ??'')->first();

        $eobDl = InsuranceEobDl::where('name','LIKE',$item['EOB DL'] ??'')->first();

        $team = InsuranceWorkedBy::where('name','LIKE',$item['Team worked'] ??'')->first();

        $followUp = InsuranceFollowUp::where('name','LIKE',$item['Follow-Up Status'] ??'')->first();

        return [
            'customer_id'=>$this->clientId ??null,
            'ins_name'=>excel_trim($item['INS Name'] ??null),
            'ins_phone'=>$item['INS Ph No'] ??null,
            'sub_id'=>$item['SUB ID'] ??null,
            'sub_name'=>$item['SUB NAME'] ??null,
            'patent_id'=>$item['Patient ID'] ??null,
            'patent_name'=>excel_trim($item['PATIENT NAME'] ??null),
            'dob'=>$this->formatDate($item['DOB'] ??null),
            'dos'=>$this->formatDate($item['DOS'] ??null),
            'sent'=>$this->formatDate($item['SENT']),
            'total'=>excel_trim($item['TOTAL $$'] ??0),
            'days'=>$item['DAYS'] ??null,
            'days_r'=>$item['DAYS-R'] ??null,
            'prov_nm'=>$item['Prov Nm'] ??null,
            'location'=>$item['Location'] ??null,
            'claim_status'=>$claimStatus?$claimStatus->id:null,
            'status_description'=>$claimStatus?$claimStatus->note:null,
            'claim_action'=>$claimStatus?$claimStatus->description:null,
            'note'=>$item['Enter Additional Notes here'] ??null,
            'cof'=>$item['COF'],
            'nxt_flup_dt'=>$this->formatDate($item['NXT FLUP DT']),
            'eob_dl'=>$eobDl?$eobDl->id:null,
            'team_worked'=>$team?$team->id:null,
            'worked_by'=>$item['Worked By'] ??null,
            'worked_dt'=>$this->formatDate($item['Worked Dt']),
            'follow_up_status'=>$followUp?$followUp->id:null
        ];
    }

    public function findInsuranceClaim($customer_id,$data = []):null|InsuranceClaim
    {
        return InsuranceClaim::where([
            'customer_id'=>$customer_id,
            'ins_name'=>$data['ins_name'],
            'patent_name'=>$data['patent_name'],
            'dob'=>$data['dob'],
            'dos'=>$data['dos'],
            'total'=>$data['total'],
        ])
        ->where('updated_at', '>=', $this->startTime)
        ->where('updated_at', '<=', $this->endTime)
        ->first();
    }

    public function findInsuranceClaimUpdated($customer_id,$data = []):null|InsuranceClaim
    {
        return InsuranceClaim::where([
            'customer_id'=>$customer_id,
            'ins_name'=>$data['ins_name'],
            'patent_name'=>$data['patent_name'],
            'dob'=>$data['dob'],
            'dos'=>$data['dos'],
            'total'=>$data['total'],
        ])->first();
    }

    public function recoverInsuranceClaimWithTrash(): bool
    {


        // Retrieve the trashed records within the specified time range
        $trashedClaims = InsuranceClaim::onlyTrashed()
            ->where('customer_id', $this->clientId)
            ->where('deleted_at', '>=', $this->startTime) // Ensure deleted_at is greater than or equal to startTime
            ->where('deleted_at', '<=', $this->endTime)   // Ensure deleted_at is less than or equal to endTime
            ->get(); // Get the collection of trashed claims

        // Restore each trashed claim and return true if at least one was restored
        if ($trashedClaims->isNotEmpty()) {
            foreach ($trashedClaims as $item) {

                ImportClaimRevertHistory::create([
                    'import_claim_id'=>$this->importClaim->id,
                    'claim_id'=>$item->id,
                    'type'=>ImportClaimRevertHistory::TYPE_TRASH,
                    'is_reverted'=>1,
                ]);

                $item->restore();
            }
            return true; // At least one record was restored
        }

        return false; // No records were found to restore
    }

    public function formatDate($date = null): ?string
    {
        try
        {
            if (checkData($date) && $date != "None")
            {

                if (gettype($date) == "integer")
                {
                    $time = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                    return Carbon::parse($time)->format('Y-m-d');
                }
                else
                {
                    return Carbon::parse($date)->format('Y-m-d');
                }

            }
            return null;
        }
        catch (\Exception $exception)
        {
            return null;
        }
    }


}

