<?php

namespace App\Helpers\Imports;

use App\Models\Customer;
use App\Models\ImportClaim;
use App\Models\ImportClaimRevertHistory;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use App\Models\InsuranceWorkedBy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NewImportHelper
{

    public ?ImportClaim $importClaim;

    public ?User $user;

    public ?Customer $customer;

    public function __construct(ImportClaim $claim,User $user)
    {
        $this->importClaim = $claim;
        $this->user = $user;
        $this->customer = $claim->client;
    }

    public function ImportItem($item,$importHistory): array
    {
        try
        {

            $claimStatus = InsuranceClaimStatus::where('name','LIKE',$item['Claim Status'] ??'')->first();

            $eobDl = InsuranceEobDl::where('name','LIKE',$item['EOB DL'] ??'')->first();

            $team = InsuranceWorkedBy::where('name','LIKE',$item['Team worked'] ??'')->first();

            $followUp = InsuranceFollowUp::where('name','LIKE',$item['Follow-Up Status'] ??'')->first();

            $data = [
                'customer_id'=>$this->customer->id ??null,
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

            $insuranceClaim = $this->findInsuranceClaim(
                $this->customer->id,
                $data
            );

            if (!$insuranceClaim)
            {
                $insuranceClaim = new InsuranceClaim();
                $insuranceClaim->fill($data);
                $insuranceClaim->save();

                $this->createOrUpdateAnswers(
                    $insuranceClaim,
                    $item,
                    $claimStatus,
                    true
                );

                ImportClaimRevertHistory::create([
                    'import_claim_id'=>$this->importClaim->id,
                    'claim_id'=>$insuranceClaim->id,
                    'type'=>ImportClaimRevertHistory::TYPE_ADDED,
                    'is_reverted'=>0,
                ]);

                // For New Import Record
                (new ImportLogHelper($data,$insuranceClaim,$importHistory,'import',$item))->processLog();

            }
            else
            {
                ImportClaimRevertHistory::create([
                    'import_claim_id'=>$this->importClaim->id,
                    'claim_id'=>$insuranceClaim->id,
                    'type'=>ImportClaimRevertHistory::TYPE_UPDATED,
                    'is_reverted'=>0,
                ]);

                // For Merged Record
                // (new ImportLogHelper($data,$insuranceClaim,$importHistory,'merged'))->processLog();

            }

            $claimID = $insuranceClaim->id;

            return [
                'success'=>true,
                'message'=>'imported',
                'id'=>$claimID,
            ];
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());

            return [
                'success'=>false,
                'message'=>$exception->getMessage(),
            ];
        }
    }

    public function createOrUpdateAnswers(
        $insuranceClaim,
        $item,
        $claimStatus,
        $isNew = false,
    ):void
    {

        if ($isNew)
        {
            if ($claimStatus && $claimStatus->questions()->exists())
            {
                foreach ($claimStatus->questions as $i=>$question)
                {
                    $label = "A". $i+1;

                    InsuranceClaimAnswer::create([
                        'claim_id'=>$insuranceClaim->id,
                        'question_id'=>$question->id,
                        'question'=>$question->title ??'',
                        'answer'=>$item[$label] ??null,
                    ]);
                }
            }
        }
        else {

            $ids = [];

            if ($claimStatus && $claimStatus->questions()->exists())
            {
                foreach ($claimStatus->questions as $i=>$question)
                {
                    $label = "A". $i+1;

                    $check = InsuranceClaimAnswer::where([
                        'claim_id'=>$insuranceClaim->id,
                        'question_id'=>$question->id,
                    ])->first();

                    if (!$check)
                    {
                        $check = new InsuranceClaimAnswer();
                    }

                    $check->fill([
                        'claim_id'=>$insuranceClaim->id,
                        'question_id'=>$question->id,
                        'question'=>$question->title ??'',
                        'answer'=>$item[$label] ??null,
                    ]);

                    $check->save();

                    $ids[] = $check->id;

                }

                InsuranceClaimAnswer::where([
                    'claim_id'=>$insuranceClaim->id,
                ])->whereNotIn('id',$ids)->delete();
            }
        }

    }

    public function findInsuranceClaim($customer_id, $data = []):null|InsuranceClaim
    {
       if (!$this->user->canAccess('claim::import'))
       {
           return InsuranceClaim::where([
                   'customer_id'=>$customer_id,
                   'ins_name'=>$data['ins_name'],
                   'patent_name'=>$data['patent_name'],
                   'dob'=>$data['dob'],
                   'dos'=>$data['dos'],
                   'total'=>$data['total'],
               ])
               ->whereHas('assigns',function ($q){
                   $q->where('user_id',$this->user->id);
               })->first();
       }
       
        return InsuranceClaim::where([
            'customer_id'=>$customer_id,
            'ins_name'=>$data['ins_name'],
            'patent_name'=>$data['patent_name'],
            'dob'=>$data['dob'],
            'dos'=>$data['dos'],
            'total'=>$data['total'],
        ])->first();
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