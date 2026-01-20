<?php

namespace App\Helpers;

use App\Helpers\Role\RoleHelper;
use App\Models\InsuranceClaim;
use App\Models\InsuranceFollowUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClaimHelper {

    const FOLLOW_UP_STATUS = [
        'Claim Closed in PMS',
        'Closed by QPS',
    ];

    public static function closedFollowUp()
    {
        return InsuranceFollowUp::whereIn('name',self::FOLLOW_UP_STATUS)->pluck('id')->toArray();
    }
    public static function getFilterKeys():array
    {
        return [
            'location'=>[],
            'days'=>[],
            'dob'=>[],
            'cof'=>[],
            'ins_name'=>[],
            'prov_nm'=>[],
            'eob_dl'=>[],
            'dos'=>null,
            'total'=>null,
            'total_amount'=>[],
            'nxt_flup_dt'=>null,
            'worked_by'=>[],
            'worked_dt'=>null,
        ];
    }

    public static function dateSuggestions($user,$type = "dos", $customer = false):array
    {
        switch ($type)
        {
            case "dos";
             $data = RoleHelper::getClaims($user,'',true,DB::raw('YEAR(dos) as dos_year'));
             if ($customer){
                 $data->where('customer_id',$customer);
             }
             return $data->distinct('dos_year')->pluck('dos_year')
                 ->filter(function ($item) {
                     return $item !== null;
                 })->map(function ($item){
                     return (string)$item;
                 })->toArray();
             case "dob":
                 $data = RoleHelper::getClaims($user,'',true,DB::raw('YEAR(dob) as dob_year'));
                 if ($customer){
                     $data->where('customer_id',$customer);
                 }
                 return $data->distinct('dob_year')->pluck('dob_year')
                     ->filter(function ($item) {
                         return $item !== null;
                     })->map(function ($item){
                         return (string)$item;
                     })->toArray();
            default:
                $data = RoleHelper::getClaims($user,'',true,$type);
                if ($customer){
                    $data->where('customer_id',$customer);
                }
                return $data->distinct($type)->pluck($type)
                    ->filter(function ($item) {
                        return $item !== null && trim($item) !== '';
                    })->map(function ($item){
                        return (string)$item;
                    })->toArray();
        }
    }


    public static function mapClaimExportFiled(InsuranceClaim $ranking):array
    {
        return [
            'ID'=>$ranking->code(),
            'INS Name'=>$ranking->ins_name ??'',
            'INS Phone'=>$ranking->ins_phone ??'',
            'SUB Name'=>$ranking->sub_name ??'',
            'SUB ID'=>$ranking->sub_id ??'',
            'Patient ID'=>$ranking->patent_id ??'',
            'Patient Name'=>$ranking->patent_name ??'',
            'DOB'=>$ranking->dob ??'',
            'DOS'=>$ranking->dos ??'',
            'SENT'=>$ranking->sent ??'',
            'Total'=>$ranking->total ??'',
            'Days'=>$ranking->days ??'',
            'Days-R'=>$ranking->days_r ??'',
            'PROV NM'=>$ranking->prov_nm ??'',
            'Location'=>$ranking->location ??'',
            'Claim Status'=>$ranking->claimStatusModal?->name ??'',
            'Status Description'=>$ranking->status_description ??'',
            'Q1'=>$ranking->answers?->first()?->question ??'',
            'A1'=>$ranking->answers?->first()?->answer ??'',
            'Q2'=>$ranking->answers->skip(1)?->first()?->question ??'',
            'A2'=>$ranking->answers->skip(1)?->first()?->answer ??'',
            'Q3'=>$ranking->answers->skip(2)?->first()?->question ??'',
            'A3'=>$ranking->answers->skip(2)?->first()?->answer ??'',
            'Q4'=>$ranking->answers->skip(3)?->first()?->question ??'',
            'A4'=>$ranking->answers->skip(3)?->first()?->answer ??'',
            'Q5'=>$ranking->answers->skip(4)?->first()?->question ??'',
            'A5'=>$ranking->answers->skip(4)?->first()?->answer ??'',
            'Enter Additional Notes here'=>$ranking->note ??'',
            'Claim Action'=>$ranking->claim_action ??'',
            'COF'=>$ranking->cof ??'',
            'NXT FLUP DT'=>$ranking->nxt_flup_dt ??'',
            'EOB DL'=>$ranking->eobDlModal?->name ??'',
            'Team Worked'=>$ranking->teamModal?->name ??'',
            'Worked By'=>$ranking->worked_by ??'',
            'Worked DT'=>$ranking->worked_dt ??'',
            'Follow-Up Status'=>$ranking->followUpModal?->name ??'',
        ];
    }

}
