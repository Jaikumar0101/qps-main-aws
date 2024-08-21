<?php

namespace App\Livewire\Admin\Components;

use App\Models\ClaimAssign;
use App\Models\ClientAssign;
use App\Models\InsuranceClaim;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ClaimAssignModal extends Component
{
    public $selectedClaims = [];

    public $users = [];
    public $selectedUsers = [];

    public $parentRenderMethod;

    protected $validationAttributes = [
        'selectedUsers'=>'team members'
    ];
    protected $rules = [
        'selectedUsers'=>'required|array|min:1',
    ];

    public function mount()
    {
        $this->users = User::where('user_type','!=','user')
            ->whereHas('role',function ($q){
                $q->whereIn('name',['Client','Team members']);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.components.claim-assign-modal');
    }

    #[On('openClaimAssignModal')]
    public function openClaimAssignModal($selectedRows = []): void
    {
        $this->selectedUsers = [];
        $this->selectedClaims = $selectedRows;
        $this->dispatch('openAssignModal');
    }

    public function Submit():void
    {
        $this->validate($this->rules);
        try
        {
            $claims = InsuranceClaim::select(['id','customer_id'])->whereIn('id',$this->selectedClaims)
                ->get()
                ->groupBy('customer_id');

            foreach ($this->selectedUsers as $user)
            {
                foreach ($claims as $key=>$items)
                {
                   $check = ClientAssign::where([
                       'user_id'=>$user,
                       'customer_id'=>$key,
                   ])->first();

                   if (!$check)
                   {
                       ClientAssign::create([
                           'user_id'=>$user,
                           'customer_id'=>$key,
                       ]);
                   }

                   foreach ($items as $item)
                   {
                       $check = ClaimAssign::where([
                           'user_id'=>$user,
                           'claim_id'=>$item->id,
                       ])->count();

                       if ($check == 0)
                       {
                           ClaimAssign::create([
                               'user_id'=>$user,
                               'claim_id'=>$item->id,
                           ]);
                       }
                   }

                }
            }
            $this->dispatch('resetSelectedRows');

            if (checkData($this->parentRenderMethod))
            {
                $this->dispatch($this->parentRenderMethod);
            }

            $this->dispatch('SetMessage',type:'success',message:'Assigned successfully',close:true);
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }
}
