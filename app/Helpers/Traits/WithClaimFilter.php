<?php

namespace App\Helpers\Traits;

use App\Helpers\Claims\ClaimFilterHelper;
use Livewire\Attributes\On;

trait WithClaimFilter
{
    public array $customFilter = [];

    public function bootMyTrait():void
    {
        $this->customFilter = ClaimFilterHelper::getFilterSession();
    }

    public function openFilterSidebar():void
    {
        $this->dispatch('openFilterSidebar');
    }

    #[On('setFilterValue')]
    public function setFilterValue($data = []): void
    {
        $this->filter = $data;
    }

    #[On('setCustomFilterValue')]
    public function setCustomFilterValue($data = []):void
    {
        $this->customFilter = $data;
    }

}
