<?php

namespace App\Livewire\Admin\Dashboard;

use App\Helpers\ClaimHelper;
use App\Models\Customer;
use App\Models\InsuranceClaim;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class MainDashboardPage extends Component
{
    public $rowData = [];
    public $chartData = [];
    public $pieCharData = [];

    public ?User $adminUser;

    public function mount()
    {
        $this->adminUser = User::find(auth()->user()->id);

        $this->rowData = [
            'claims'=>$this->getClaimsCount(),
            'customers'=>$this->getClientsCount(),
            'total'=>$this->getClaimTotalCount(),
            'completed'=>$this->getClaimsCount(true),
        ];

        $this->chartData = $this->getMonthlyChartData();
        $this->generatePieChartData();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.main-dashboard-page')
            ->layout('layouts.admin.app');
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
            $data['data'][]   = InsuranceClaim::whereDate('created_at','>=', now()->subMonthsWithoutOverflow($i)->firstOfMonth()->format('Y-m-d'))
                ->whereDate('created_at','<=', now()->subMonthsWithoutOverflow($i)->lastOfMonth()->format('Y-m-d'))
                ->count();
        }
        return $data;
    }

    private function generatePieChartData(): void
    {
        $this->pieCharData['labels'] = [];
        $this->pieCharData['data'] = [];

        for ($i = 4;$i>=0;$i--)
        {
            $date = now()->subYears($i);
            $this->pieCharData['labels'][] = $date->copy()->format('Y');
            $this->pieCharData['data'][] = InsuranceClaim::whereIn('follow_up_status',ClaimHelper::closedFollowUp())
                ->whereYear('created_at',$date->format('Y'))
                ->sum('total');
        }

    }

    private function getClaimsCount($approved = false):int
    {
        $data = InsuranceClaim::query();

        if ($approved)
        {
            $data->whereIn('follow_up_status',ClaimHelper::closedFollowUp());
        }

        if ($this->adminUser->canAccess('claim::access'))
        {
            return $data->count();
        }

        $data->whereHas('assigns',function ($q){
            $q->where('user_id',$this->adminUser->id);
        });

        return $data->count();
    }

    private function getClientsCount(): int
    {
        $data = Customer::query();

        if ($this->adminUser->canAccess('client::assign'))
        {
            return $data->count();
        }

        $data->whereHas('assigns',function ($q){
            $q->where('user_id',$this->adminUser->id);
        });

        return $data->count();
    }

    private function getClaimTotalCount()
    {
        $data = InsuranceClaim::query();

        if ($this->adminUser->canAccess('claim::access'))
        {
            return $data->sum('total');
        }

        $data->whereHas('assigns',function ($q){
            $q->where('user_id',$this->adminUser->id);
        });

        return $data->sum('total');
    }

}
