<?php

namespace App\Helpers\Imports;

use App\Helpers\Admin\BackendHelper;
use App\Models\Customer;
use App\Models\ImportClaim;
use App\Models\ImportClaimHistory;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use App\Models\InsuranceWorkedBy;
use App\Models\User;
use App\Rules\ClaimClientCheckRule;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportHelper
{
    public ?ImportClaim $importClaim;

    public ?User $user;

    public array $importErrors = [];

    public int $imported = 0;

    public int $total = 0;

    protected array $validationAttributes = [

    ];

    public array $importedClaimsIds = [];

    protected function rules():array
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

//            'Claim Status'=>'nullable',
//            'EOB DL'=>'nullable',
//            'Team worked'=>'nullable',
//            'Follow-Up Status'=>'nullable',
//            'Status Description'=>'max:255',
//            'Enter Additional Notes here'=>'max:10000',
//            'Claim Action'=>'max:255',
//            'COF'=>'max:255',
//            'NXT FLUP DT'=>'nullable',
//            'Worked By'=>'max:255',
//            'Worked Dt'=>'nullable',
        ];
    }

    public function __construct($importClaim)
    {
        $this->importClaim = $importClaim;
        $this->user = Auth::user();
    }

    public function ImportLeads():array
    {

            try
            {
                $path = $this->importClaim->getFilePath();
                $collection = (new FastExcel)->import($path);

                $this->total = count($collection);
            }
            catch (\Exception $exception)
            {
                return [
                    'success'=>false,
                    'message'=>"File can't be imported",
                ];
            }

            $claimHistory = ImportClaimHistory::create([
                'parent_id'=>$this->importClaim->id,
            ]);

            foreach ($collection as $i=>$item)
            {

                $item['Client ID'] = $this->importClaim->client_id ??null;

                $item['TOTAL $$'] = $item['TOTAL $$'] === '' ? null : $item['TOTAL $$'];

                $validator = Validator::make($item,$this->rules());
                if ($validator->fails())
                {
                    $this->importErrors[] = [
                        'row'=>$i+1,
                        'name'=>$item['INS Name'] ??'--',
                        'errors'=>$validator->errors()->all(),
                    ];
                    continue;
                }

                $result = $this->ImportItem($item,$claimHistory);

                if ($result['success'])
                {
                    $this->imported ++;
                }
                else{
                    $this->importErrors[] = [
                        'row'=>$i+1,
                        'name'=>$item['INS Name'] ??'--',
                        'errors'=>[$result['message']],
                    ];
                }

            }

            if (checkData($this->importClaim->client_id))
            {
                InsuranceClaim::where('customer_id',$this->importClaim->client_id)
                    ->whereNotIn('id',$this->importedClaimsIds)
                    ->delete();
            }

            $claimHistory->fill([
                'total'=>$this->total,
                'imported'=>$this->imported,
                'errors'=>BackendHelper::JsonEncode($this->importErrors),
                'status'=>1,
            ]);

            $claimHistory->save();


            $this->importClaim->status = 1;
            $this->importClaim->save();

            return [
                'success'=>true,
                'message'=>'Imported Successfully',
            ];
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
            // Log the exception if needed
            // Log::error($exception->getMessage());
            return null;
        }
    }

    public function ImportItem($item,$importHistory): array
    {
        try
        {
            $isNewClaim = false;

            $customer = Customer::find($item['Client ID']);

            $claimStatus = InsuranceClaimStatus::where('name','LIKE',$item['Claim Status'])->first();

            $eobDl = InsuranceEobDl::where('name','LIKE',$item['EOB DL'])->first();

            $team = InsuranceWorkedBy::where('name','LIKE',$item['Team worked'])->first();

            $followUp = InsuranceFollowUp::where('name','LIKE',$item['Follow-Up Status'])->first();

            $data = [
                'customer_id'=>$customer->id ??null,
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
                $customer->id,
                $data
            );

            if (!$insuranceClaim)
            {
//                $isNewClaim = true;

                $insuranceClaim = new InsuranceClaim();
                $insuranceClaim->fill($data);
                $insuranceClaim->save();

                $this->createOrUpdateAnswers(
                    $insuranceClaim,
                    $item,
                    $claimStatus,
                    true
                );

            }
//            else
//            {
//                // For Old Record
//                (new ImportLogHelper($data,$insuranceClaim,$importHistory,'old'))->processLog();
//                $insuranceClaim->fill(Arr::except($data,'follow_up_status'));
//            }

            $this->importedClaimsIds[] = $insuranceClaim->id;

            // For Import Record
            (new ImportLogHelper($data,$insuranceClaim,$importHistory,'import',$item))->processLog();

            // For Merged Record
            (new ImportLogHelper($data,$insuranceClaim,$importHistory,'merged'))->processLog();

            return [
                'success'=>true,
                'message'=>'imported',
            ];
        }
        catch (\Exception $exception)
        {
            \Log::error($exception->getMessage());

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

    public function findInsuranceClaim($customer_id,$data = []):null|InsuranceClaim
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

}
