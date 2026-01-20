<?php

namespace App\Livewire\Admin\Customers;

use App\Helpers\ClaimHelper;
use App\Models\Customer;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use App\Models\InsuranceWorkedBy;
use Livewire\Component;
use Livewire\WithPagination;

class CustomersViewPage extends Component
{
    public $backUrl;

    public $customer_id;
    public $customer;

    public $chartData = [], $chartLabels = [];

    public $rowData = [];

    public function mount()
    {
        $this->backUrl = back()->getTargetUrl();
        $this->customer = Customer::find($this->customer_id);
        if (!$this->customer)
        {
            return redirect()->route('admin::customers:list')->with('error','Invalid Client');
        }

        $this->rowData = [
            'total_amount'=>InsuranceClaim::where('customer_id',$this->customer->id)->sum('total'),
            'total_claims'=>InsuranceClaim::where('customer_id',$this->customer->id)->count(),
            'closed_claims'=>InsuranceClaim::where('customer_id',$this->customer->id)->whereIn('follow_up_status',ClaimHelper::closedFollowUp())->count(),
        ];

        $this->chartData = $this->getMonthlyChartData();

    }

    public function render()
    {
        return view('livewire.admin.customers.customers-view-page');
    }

    public function getMonthlyChartData():array
    {
        $data = [
            'months' =>  [],
            'data'=>[]
        ];
        for($i = 7; $i>=0; $i--)
        {
            $data['months'] [] =  now()->subMonthsWithoutOverflow($i)->format('M');
            $data['data'][]   = InsuranceClaim::where('customer_id',$this->customer->id)
                ->whereDate('created_at','>=', now()->subMonthsWithoutOverflow($i)->firstOfMonth()->format('Y-m-d'))
                ->whereDate('created_at','<=', now()->subMonthsWithoutOverflow($i)->lastOfMonth()->format('Y-m-d'))
                ->count();
        }
        return $data;
    }

}
