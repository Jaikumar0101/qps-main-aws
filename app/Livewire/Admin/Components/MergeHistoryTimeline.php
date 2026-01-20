<?php

namespace App\Livewire\Admin\Components;

use App\Models\ClaimHistoryLog;
use Livewire\Component;

class MergeHistoryTimeline extends Component
{
    public $claim_id;

    public $limit = 12;

    public $perPage = 12;
    public $totalCount = 0;

    public $data = [];

    public $claimLog;

    public function mount()
    {
        $data = ClaimHistoryLog::query()
            ->where('parent_id',$this->claim_id)
            ->orderBy('id','desc');

        $this->totalCount = $data->count();

        $this->data = $data->limit($this->limit)->get();
    }

    public function render()
    {
        return view('livewire.admin.components.merge-history-timeline');
    }

    public function loadMore()
    {
        $newData = ClaimHistoryLog::where('parent_id',$this->claim_id)
            ->orderBy('id','desc')
            ->skip($this->perPage)
            ->limit($this->limit)
            ->get();

       $this->data =  $this->data->merge($newData);

        $this->perPage += $this->limit;
    }

    public function OpenDetailModal($id)
    {
        $this->claimLog = ClaimHistoryLog::find($id);

        if ($this->claimLog)
        {
            $this->dispatch('OpenDetailModal');
        }
    }
}
