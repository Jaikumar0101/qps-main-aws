<?php

namespace App\Livewire\Admin\InsuranceClaim;

use App\Models\InsuranceClaim;
use App\Models\User;
use Livewire\Component;

class ClaimViewPage extends Component
{
    public $claim_id;
    public InsuranceClaim $insuranceClaim;

    public User $adminUser;

    public function mount()
    {
        $this->adminUser = User::find(auth()->user()->id);
        $this->insuranceClaim = InsuranceClaim::withTrashed()->where('id',$this->claim_id)->first();

        if (!checkData($this->insuranceClaim))
        {
            return redirect()->route('admin::insurance-claim:list')->with('error','Invalid claim');
        }

    }

    public function render()
    {
        return view('livewire.admin.insurance-claim.claim-view-page');
    }

}
