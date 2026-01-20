<?php

namespace App\Livewire\Admin\Tasks\Components;

use App\Helpers\Quick\QuickConstants;
use App\Models\QuickProjectCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryListContent extends Component
{
    use QuickConstants;
    public $selectedCategory;
    public function mount()
    {
        $this->selectedCategory = QuickProjectCategory::where('parent_id',null)
            ->orderBy('position','asc')
            ->first();
    }
    #[On('Quick::category:render')]
    public function render()
    {
        $data = QuickProjectCategory::where('parent_id',null)
            ->orderBy('position','asc')
            ->get();

        return view('livewire.admin.tasks.components.category-list-content',compact('data'));
    }

    public function OpenSettingModal():void
    {
        $this->redirect(route('admin::tasks:category.sort'),navigate: true);
    }

    public function changeSelectedCategory($id = null): void
    {
        $this->selectedCategory = QuickProjectCategory::find($id);

        $this->dispatch($this->eventRenderMethods['projectChangeCategory'],
            category_id:$this->selectedCategory?->id ??null
        );
    }

    public function openAddEditCategory($id = null): void
    {
        $this->dispatch($this->eventRenderMethods['categoryAddEditMethod'],category_id:$id);
    }

    public function destroy($id = null):void
    {
        $check = QuickProjectCategory::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }
}
