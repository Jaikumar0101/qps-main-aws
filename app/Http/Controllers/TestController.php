<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceClaimStatusQuestion;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class TestController extends Controller
{
    public function Index()
    {
        return view('frontend.test');
    }

    public function Submit(Request $request)
    {
        $errors = [];

        $request->validate([
            'file' => 'required',
        ]);

        $collections = (new FastExcel)->import($request->file('file'));

        foreach ($collections->where('INS Name','!=',null) as $i=>$item)
        {
           $check =  $this->createClaim($item);

           if (!$check['success'])
           {
               $errors[] = [
                   'index'=>$i,
                   'data'=>$check,
               ];
           }
        }

        dd($errors);
    }

    protected function createClaim($item)
    {
        try
        {
            $name = explode(', ',$item['SUB NAME']);

            $customer = Customer::create([
                'first_name'=>$name[0] ??'',
                'last_name'=>$name[1] ??'',
                'email'=>null,
                'phone'=>$item['INS Ph No'] ??'',
                'dob'=>$this->formatDate($item['DOB']),
                'dos'=>$this->formatDate($item['DOS']),
                'address'=>null,
                'status'=>1,
            ]);

            $claimStatus = InsuranceClaimStatus::where('name','LIKE',$item['Claim Status'])->first();

            $eobDl = InsuranceEobDl::where('name','LIKE',$item['EOB DL'])->first();

            $team = InsuranceEobDl::where('name','LIKE',$item['Team worked'])->first();

            $followUp = InsuranceFollowUp::where('name','LIKE',$item['Follow-Up Status'])->first();

            $insuranceClaim = InsuranceClaim::create([
                'customer_id'=>$customer->id ??null,
                'ins_name'=>$item['INS Name'] ??null,
                'ins_phone'=>$item['INS Ph No'] ??null,
                'sub_id'=>$item['SUB ID'] ??null,
                'sub_name'=>$item['SUB NAME'] ??null,
                'patent_id'=>$item['Patient ID'] ??null,
                'patent_name'=>$item['PATIENT NAME'] ??null,
                'dob'=>$customer->dob ??null,
                'dos'=>$customer->dos ??'',
                'sent'=>$this->formatDate($item['SENT']),
                'total'=>$item['TOTAL $$'] ??0,
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
            ]);

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

            return [
                'success'=>true,
            ];
        }
        catch (\Exception $exception)
        {
            return [
                'success'=>false,
                'error'=>$exception->getMessage(),
            ];
        }

    }

    public function formatDate($date = null)
    {
        try
        {
            return checkData($date) && $date!="None"?Carbon::parse($date)->format('Y-m-d'):null;
        }
        catch (\Exception $exception)
        {
            return null;
        }
    }
}
