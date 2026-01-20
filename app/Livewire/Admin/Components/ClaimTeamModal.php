<?php

namespace App\Livewire\Admin\Components;

use App\Models\ClaimAssign;
use App\Models\ClientAssign;
use App\Models\InsuranceClaim;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimTeamModal extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public ?InsuranceClaim $insuranceClaim;
    public $parentRenderMethod;
    public $selectedUsers = [];

    public $teamRoles = [];

    public $search,$perPage = 8;

    public function mount()
    {
        $this->teamRoles = [
            'Client',
            'Team members',
            'Team Leads/SMEs',
        ];
    }

    public function render()
    {
        $data = User::query();

        $data->where('user_type','!=','user');

        $data->whereHas('role',function ($q){
            $q->whereIn('name',$this->teamRoles);
        });

        if (checkData($this->search))
        {
            $data->where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            });
        }

        $data->whereNotIn('id',$this->selectedUsers);

        $data = $data->paginate($this->perPage,['*'],'userAssignPage');

        return view('livewire.admin.components.claim-team-modal',compact('data'));
    }

    #[On('openClaimTeamModal')]
    public function openClaimAssignModal($claim_id = null): void
    {
        $this->insuranceClaim = InsuranceClaim::find($claim_id);
        if (checkData($this->insuranceClaim))
        {
            $this->selectedUsers  = $this->insuranceClaim->assigns()->pluck('user_id')->toArray();
            $this->dispatch('openClaimTeamAssignModal');
            $this->resetPage();
        }
    }

    protected function runParentRenderMethod():void
    {
        if (checkData($this->parentRenderMethod))
        {
            $this->dispatch($this->parentRenderMethod);
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function Submit()
    {
        $ids = [];

        foreach ($this->selectedUsers as $user)
        {
            $check = ClientAssign::where([
                'user_id'=>$user,
                'customer_id'=>$this->insuranceClaim->customer_id,
            ])->first();

            if (!$check && checkData($this->insuranceClaim->customer_id))
            {
                ClientAssign::create([
                    'user_id'=>$user,
                    'customer_id'=>$this->insuranceClaim->customer_id,
                ]);
            }

            $assignCheck = ClaimAssign::where([
                'user_id'=>$user,
                'claim_id'=>$this->insuranceClaim->id,
            ])->first();

            if (!$assignCheck)
            {
               $assignCheck = ClaimAssign::create([
                    'user_id'=>$user,
                    'claim_id'=>$this->insuranceClaim->id,
                ]);
            }
            $ids[] = $assignCheck->id;
        }

        ClaimAssign::where([
            'claim_id'=>$this->insuranceClaim->id,
        ])->whereNotIn('id',$ids)->delete();

        $this->runParentRenderMethod();
        $this->dispatch('hideClaimTeamAssignModal');

    }

    public function assignUser($id = null): void
    {
        if (!in_array($id, $this->selectedUsers)) {
            $this->selectedUsers[] = $id;
        }
    }

    public function removeUser($id = null): void
    {
        $index = array_search($id, $this->selectedUsers);
        if ($index !== false) {
            unset($this->selectedUsers[$index]);
        }
    }

}
