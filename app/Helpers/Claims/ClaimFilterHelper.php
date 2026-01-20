<?php

namespace App\Helpers\Claims;

use App\Helpers\ClaimHelper;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use App\Models\InsuranceWorkedBy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class ClaimFilterHelper
{

    public static array $filterKeysLabels = [
        'ins_name'=>"INS Name",
        'prov_nm'=>"Provider Name",
        'eob_dl'=>'EOB Downloaded',
        'location'=>'Location',
        'days'=>'No. of Days',
        'dob'=>'Date of Birth',
        'cof'=>'COF',
        'dos'=>'Date Of Service',
        'total'=>'Total Amount',
        'nxt_flup_dt'=>'Next/Followup Date',
        'worked_by'=>'Worked By',
        'worked_dt'=>'Worked Date',
        'claim_status'=>"Claim Status",
        'follow_up_status'=>"Follow-up Status",
        'method'=>"Method",
        'ques_bulk_sep'=>'Bulk/Sep:',
    ];

    public static array $filterOptions = [
        'ins_name'=>[
            'equal',
            'select',
        ],
        'claim_status'=>[
            'select',
        ],
       'follow_up_status'=>[
           'select',
       ],
        'location'=>[
            'equal',
            'select',
        ],
        'days'=>[
            'equal',
            'greaterThan',
            'lessThan',
            'range',
        ],
        'dob'=>[
            'date',
            'date_range',
        ],
        'cof'=>[
            'select',
        ],
        'prov_nm'=>[
            'equal',
            'select',
        ],
        'eob_dl'=>[
            'equal',
            'select',
        ],
        'dos'=>[
            'date',
            'date_range',
        ],
        'total'=>[
            'equal',
            'greaterThan',
            'lessThan',
            'range',
        ],
        'nxt_flup_dt'=>[
            'date',
            'date_range',
        ],
        'worked_by'=>[
            'select',
        ],
        'method'=>[
            'select',
        ],
        'worked_dt'=>[
            'date',
            'date_range',
        ],
        'ques_bulk_sep'=>[
            'select'
        ]
    ];

    public static array $filterLabels = [
        'like'=>'%Like%',
        'like_after'=>'Like%',
        'like_before'=>'%Like',
        'equal'=>'Equal to',
        'greaterThan'=>'Greater than',
        'lessThan'=>'Less than',
        'select'=>'Selected Values',
        'date'=>'Date',
        'date_range'=>'Date Range',
        'range'=>'Range',
    ];

    public static array $filterDefaultValues = [
        'like'=>null,
        'like_after'=>null,
        'like_before'=>null,
        'equal'=>null,
        'greaterThan'=>null,
        'lessThan'=>null,
        'select'=>[],
        'date'=>null,
        'date_range'=>[
            'from'=>null,
            'to'=>null,
        ],
        'range'=>[
            'from'=>null,
            'to'=>null,
        ],
    ];

    public static function getFilterSession()
    {
        if (Session::has('qps_filter_data'))
        {
            return Session::get('qps_filter_data');
        }
        return [];
    }

    public static function newFilterItem(): array
    {
        return [
            'type'=>'ins_name',
            'filter'=>null,
            'value'=>null,
        ];
    }

    public static function getFilterDefaultValue($key = "equal")
    {
        return self::$filterDefaultValues[$key] ??null;
    }

    public static function getFilterLabel($key = "equal")
    {
        return self::$filterLabels[$key] ??'equal';
    }

    public static function filterKeysLabel($key = 'ins_name'):mixed
    {
        return self::$filterKeysLabels[$key] ??'Ins Name';
    }

    public static function getFilterOptions($key = 'ins_name'):array
    {
        return self::$filterOptions[$key];
    }

    public static function getClaimsData($adminUser, $key = "ins_name", $withFilterData = true , $customer = false):array
    {
        if ($key == "ques_bulk_sep") {
            $data = InsuranceClaimAnswer::where('question', 'Bulk/Sep:')
                ->distinct('answer')
                ->pluck('answer')
                ->filter(function ($item) {
                    return $item !== null && $item != "" && str_replace(' ','',$item) != "";
                })->map(function ($item) {
                    return (string)$item;
                })->toArray();

            $data = Arr::collapse([
                [null],
                $data,
            ]);
            return Arr::map($data,function ($item){
                return [
                    'key'=>$item ??'',
                    'label'=>$item ??'All Other'
                ];
            });
        }


       $data =  ClaimHelper::dateSuggestions($adminUser,$key, $customer);

       $data = Arr::collapse([
           [null],
           $data
       ]);

       if (!$withFilterData)
       {
           return $data;
       }

       switch ($key)
       {
           case "eob_dl":
               return Arr::map($data,function ($item){
                   return [
                       'key'=>$item ??'',
                       'label'=>InsuranceEobDl::getName($item,'All Other')
                   ];
               });
           case "claim_status":
               return Arr::map($data,function ($item){
                   return [
                       'key'=>$item ??'',
                       'label'=>InsuranceClaimStatus::getName($item,'All Other')
                   ];
               });
           case "follow_up_status":
               return Arr::map($data,function ($item){
                   return [
                       'key'=>$item ??'',
                       'label'=>InsuranceFollowUp::getName($item,'All Other')
                   ];
               });
           case "worked_by":
               return Arr::map($data,function ($item){
                   return [
                       'key'=>$item ??'',
                       'label'=>$item ??'All Other',
                   ];
               });
           case "method":
               return Arr::map(InsuranceClaim::METHOD_TYPES,function ($item){
                   return [
                       'key'=>$item ??'',
                       'label'=>ucfirst($item)
                   ];
               });
           default:
               return Arr::map($data,function ($item){
                   return [
                       'key'=>$item ??'',
                       'label'=>$item ??'All Other'
                   ];
               });
       }
    }

    public static function saveFilter(mixed $otherFilters):void
    {
        Session::put('qps_filter_data',$otherFilters);
    }

    public static function displayClaimNoteTitle($claim_id = null): ?string
    {
        $claim = InsuranceClaim::find($claim_id);

        if(checkData($claim))
        {
           return "Pt Id:{$claim->patent_id} Pt Name: {$claim->patent_name} DOS:"
            .display_date_format($claim->dos)
            ." Amnt:".currency($claim->total ??0)
            ."Ins Name: {$claim->ins_name}";
        }

        return null;
    }
}
