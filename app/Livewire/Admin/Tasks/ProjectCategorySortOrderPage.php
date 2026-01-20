<?php

namespace App\Livewire\Admin\Tasks;

use App\Models\QuickProjectCategory;
use Livewire\Component;

class ProjectCategorySortOrderPage extends Component
{
    public $selectedCategory;
    public function render()
    {
        $data = QuickProjectCategory::where('parent_id',null)
            ->orderBy('position','asc')
            ->get();

        if ($this->selectedCategory)
        {
            $subData = QuickProjectCategory::where('parent_id',$this->selectedCategory->id)
                ->orderBy('position','asc')
                ->get();
        }
        else
        {
            $subData = [];
        }
        return view('livewire.admin.tasks.project-category-sort-order-page',compact('data','subData'));
    }

    public function updateParentOrder($order)
    {
        foreach ($order as $orderItem)
        {
            QuickProjectCategory::where('id',$orderItem['value'])->update([
                'position'=>$orderItem['order']
            ]);
        }
    }

    public function updateChildOrder($order)
    {
        foreach ($order as $orderItem)
        {
            QuickProjectCategory::where('id',$orderItem['value'])->update([
                'position'=>$orderItem['order']
            ]);
        }
    }

    public function openChildModal($id = null):void
    {
        $this->selectedCategory = QuickProjectCategory::find($id);
    }
}
