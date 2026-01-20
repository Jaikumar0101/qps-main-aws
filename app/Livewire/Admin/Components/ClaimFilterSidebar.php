<?php

namespace App\Livewire\Admin\Components;

use App\Helpers\Claims\ClaimFilterHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ClaimFilterSidebar extends Component
{
    public $parentRenderMethod = "parentRenderMethod";
    public $drawer = false;

    public $filter = [];
    public $otherFilters = [];

    public $data = [];

    public $adminUser;

    public function mount():void
    {
        $this->adminUser = Auth::user();
        $this->data = ClaimFilterHelper::getFilterOptions();
    }

    public function render()
    {
        return view('livewire.admin.components.claim-filter-sidebar');
    }

    #[On('openFilterSidebar')]
    public function openFilterSidebar():void
    {
        $this->drawer = true;
    }

    public function addNewFilter():void
    {
        $this->otherFilters[] = ClaimFilterHelper::newFilterItem();
    }

    public function updateFilterType($key = null): void
    {
        if (Arr::has($this->otherFilters,$key))
        {
            $this->otherFilters[$key]['filter'] = null;
        }
    }

    public function updateFilterValue($key = null): void
    {
        if (Arr::has($this->otherFilters,$key))
        {
            $this->otherFilters[$key]['value'] = ClaimFilterHelper::getFilterDefaultValue($this->otherFilters[$key]['filter']);
        }
    }

    public function applyFilter():void
    {
        ClaimFilterHelper::saveFilter($this->otherFilters);
        $this->dispatch('setCustomFilterValue',data:$this->otherFilters);
        $this->drawer = false;
    }

    public function resetFilter(): void
    {
        $this->otherFilters = [];
    }
    public function destroyFilerItem($key = null): void
    {
        if (Arr::has($this->otherFilters,$key))
        {
            $temp = $this->otherFilters;
            Arr::forget($temp,$key);
            $this->otherFilters = array_values($temp);
        }
    }
}
