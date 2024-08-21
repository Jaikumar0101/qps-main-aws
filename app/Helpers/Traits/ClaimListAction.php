<?php

namespace App\Helpers\Traits;

use App\Models\ClaimAssign;
use App\Models\ClientAssign;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;

trait ClaimListAction
{
    public array $currentPageItems = [];

    public array $selected = [];

    public bool $rowSelection = false;

    public function updateSelectionRow($claim_id,$checked = false): void
    {
        $claim_id = (int) $claim_id;

        if ($checked)
        {
            if (!in_array($claim_id,$this->selected))
            {
                $this->selected[] = $claim_id;
            }
        }
        else
        {
            if (in_array($claim_id,$this->selected))
            {
                $temp = $this->selected;
                $key = array_search($claim_id,$temp);
                Arr::forget($temp,$key);

                $this->selected = array_values($temp);
            }
        }
    }

    #[On('resetSelectedRows')]
    public function resetSelectedRows():void
    {
        $this->selected = [];
        $this->dispatch('resetSelectedRowsCheckbox');
    }

    public function OpenAssignModal():void
    {
        $this->dispatch('openClaimAssignModal',$this->selected);
    }

    public function unAssignSelectedClaims(): void
    {
        foreach ($this->selected as $item)
        {

            ClaimAssign::where('claim_id',$item)->delete();

        }

        $this->resetSelectedRows();
    }

    public function OpenClaimAssignModal($claim_id = null):void
    {
        $this->dispatch('openClaimTeamModal',claim_id:$claim_id);
    }

    public function toggleCurrentPageItems($check = false):void
    {
        if ($check)
        {
            $mergedArray = array_merge($this->selected, $this->currentPageItems);
            $this->selected = array_unique($mergedArray);
        }
        else
        {
            $temp = array_diff($this->selected, $this->currentPageItems);
            $this->selected = $temp;
        }
    }

    public function updateTaskSubject(): void
    {
        $this->request['task_subject'] = "Pt Id:{$this->request['patent_id']} Pt Name: {$this->request['patent_name']} DOS:"
            .$this->formatDateForNote($this->request['dos'])
            ." Amnt:".currency($this->request['total'] ??0)
            ."Ins Name: {$this->request['ins_name']}";
    }

//    public function updateTaskNote(): void
//    {
//        $content = "";
//
//        foreach ($this->editModal->answers as $i=>$row)
//        {
//            $case = $i+1;
//            $content .="{$row->question} ".($this->request['a_'.$case] ??'')."; ";
//        }
//
//        $this->request['task_note'] = $content;
//    }

    public function formatDateForNote(mixed $dos): string
    {
        try {
            return Carbon::createFromDate($dos)->format('m/d/Y');
        }
        catch (\Exception $exception)
        {
            return "";
        }
    }

}
