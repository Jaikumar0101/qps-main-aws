<?php

namespace App\Helpers\Admin;

use App\Models\InsuranceClaim;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InsuranceClaimHelper
{
    public User $adminUser;

    public ?string $search;

    public array $filter;

    public $withTrashed;

    public array $selectedStatus = [];
    public array $selectedClaimStatus = [];

    public array $selectedCustomers = [];

    public array $claimFilter = [];

    public mixed $totalOfClaims = 0;

    public function __construct(
        $adminUser,
        $claimFilter,
        $withTrashed,
        $filter,
        $search,
        $selectedCustomers = [],
        $selectedClaimStatus  = [],
        $selectedStatus = [],
    )
    {
        $this->adminUser = $adminUser;
        $this->claimFilter = $claimFilter;
        $this->withTrashed = $withTrashed;
        $this->filter = $filter;
        $this->search = $search;
        $this->selectedCustomers = $selectedCustomers;
        $this->selectedClaimStatus = $selectedClaimStatus;
        $this->selectedStatus = $selectedStatus;
    }

    public function getClaims(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $data = InsuranceClaim::query();

        if ($this->withTrashed)
        {
            $data->withTrashed();
        }

        if(!$this->adminUser->canAccess('claim::access'))
        {
            $data->whereHas('assigns',function ($q){
                $q->where('user_id',$this->adminUser->id);
            });
        }

        if (count($this->selectedStatus)>0)
        {
            $data->whereIn('follow_up_status',$this->selectedStatus);
        }

        if (count($this->selectedClaimStatus)>0)
        {
            $data->whereIn('claim_status',$this->selectedClaimStatus);
        }

        if (count($this->selectedCustomers)>0)
        {
            $data->whereIn('customer_id',$this->selectedCustomers);
        }

        if (count($this->claimFilter['eob_dl'])>0)
        {
            $data->whereIn('eob_dl',$this->claimFilter['eob_dl']);
        }

        if (count($this->claimFilter['dob'])>0)
        {
            $data->whereIn(DB::raw('YEAR(dob)'),$this->claimFilter['dob']);
        }

        if (checkData($this->claimFilter['dos']))
        {
            $dates = explode(' to ',$this->claimFilter['dos']);

            if (count($dates)>0 &&  isset($dates[1]))
            {
                $data->where(function ($q) use ($dates){
                    $q->whereDate('dos','>=',$dates[0])
                        ->whereDate('dos','<=',$dates[1]);
                });
            }
        }

        if (checkData($this->claimFilter['nxt_flup_dt']))
        {
            $dates = explode(' to ',$this->claimFilter['nxt_flup_dt']);

            if (count($dates)>0 &&  isset($dates[1]))
            {
                $data->where(function ($q) use ($dates){
                    $q->whereDate('nxt_flup_dt','>=',$dates[0])
                        ->whereDate('nxt_flup_dt','<=',$dates[1]);
                });
            }
        }

        if (checkData($this->claimFilter['worked_dt']))
        {
            $dates = explode(' to ',$this->claimFilter['worked_dt']);

            if (count($dates)>0 &&  isset($dates[1]))
            {
                $data->where(function ($q) use ($dates){
                    $q->whereDate('worked_dt','>=',$dates[0])
                        ->whereDate('worked_dt','<=',$dates[1]);
                });
            }
        }

        if (count($this->claimFilter['cof'])>0)
        {
            $data->whereIn('cof',$this->claimFilter['cof']);
        }

        if (checkData($this->claimFilter['days']) && gettype($this->claimFilter['days']) == "array" && count($this->claimFilter['days'])>0)
        {
            $data->where('days','>=',$this->claimFilter['days'][0] ??0)
                ->where('days','<=',$this->claimFilter['days'][1] ??0);
        }

        if (count($this->claimFilter['location'])>0)
        {
            $data->whereIn('location',$this->claimFilter['location']);
        }

        if (count($this->claimFilter['worked_by'])>0)
        {
            $data->whereIn('worked_by',$this->claimFilter['worked_by']);
        }

        if (checkData($this->claimFilter['total']) && gettype($this->claimFilter['total']) == "array" && count($this->claimFilter['total'])>0)
        {
            $data->where('total','>=',$this->claimFilter['total'][0] ??0)
                ->where('total','<=',$this->claimFilter['total'][1] ??0);
        }

        if (count($this->claimFilter['ins_name'])>0)
        {
            $data->whereIn('ins_name',$this->claimFilter['ins_name']);
        }

        if (count($this->claimFilter['prov_nm'])>0)
        {
            $data->whereIn('prov_nm',$this->claimFilter['prov_nm']);
        }

        if (isset($this->claimFilter['total_amount']) && count($this->claimFilter['total_amount'])>0)
        {
            $data->whereIn('total',$this->claimFilter['total_amount']);
        }

        if (checkData($this->search))
        {
            $data->where(function ($q) {
                $q->orWhere('id', 'like', $this->search)
                    ->orWhere('ins_name', 'like', "%{$this->search}%")
                    ->orWhere('dos', 'like', "%{$this->search}%")
                    ->orWhere('patent_name', 'like', "%{$this->search}%")
                    ->orWhere(function ($qs){
                        $qs->whereHas('claimStatusModal',function ($status){
                            $status->where('name','LIKE',"%{$this->search}%");
                        });
                    });
            });
        }

        $this->totalOfClaims = $data->sum('total');

        return $data->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->paginate($this->filter['perPage']);

    }

}
