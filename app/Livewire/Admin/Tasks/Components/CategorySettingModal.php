<?php

namespace App\Livewire\Admin\Tasks\Components;

use App\Helpers\Quick\QuickConstants;
use App\Models\QuickProjectCategory;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;

class CategorySettingModal extends Component
{
    use QuickConstants;

    public $editModal = false;

    public $request = [];
    public $parentCategories = [];

    protected $validationAttributes = [
        'request.name'=>'name',
        'request.description'=>'description',
        'request.position'=>'position'
    ];

    protected $rules = [
        'request.name'=>'required|max:255',
        'request.description'=>'max:500',
        'request.position'=>'required|numeric|min:0'
    ];

    public function mount()
    {
        $this->getParentCategories();
        $this->NewRequest();
    }
    public function render()
    {
        return view('livewire.admin.tasks.components.category-setting-modal');
    }

    public function Save()
    {
        $this->validate($this->rules);

        if(Arr::has($this->request,'id'))
        {
            $check = QuickProjectCategory::find($this->request['id']);
            $check->fill($this->request);
            $check->save();
            $this->editModal = false;
            $this->dispatch('SetMessage',type:'success',message:'Updated successfully');
        }
        else
        {
            QuickProjectCategory::create($this->request);
            $this->editModal = false;
            $this->dispatch('SetMessage',type:'success',message:'Created successfully');
        }
        $this->dispatch($this->eventRenderMethods['categoryListRenderMethod']);
    }

    #[On('Quick::category:add-edit')]
    public function openAddEditModal($category_id = null):void
    {
        $this->getParentCategories();
        if (checkData($category_id))
        {
            $check = QuickProjectCategory::find($category_id);
            if ($check)
            {
                $this->EditRequest($check);
                $this->editModal = true;
            }
        }
        else
        {
            $this->NewRequest();
            $this->editModal = true;
        }
    }

    protected function EditRequest($check):void
    {
        $this->request = $check->only([
            'id',
            'parent_id',
            'name',
            'description',
            'position',
            'status',
        ]);
    }
    protected function NewRequest(): void
    {
        $this->request = [
            'parent_id'=>null,
            'name'=>null,
            'description'=>null,
            'position'=>0,
            'status'=>1,
        ];
    }

    protected function getParentCategories():void
    {
        $this->parentCategories = QuickProjectCategory::select(['id','name','position'])
            ->where('parent_id',null)
            ->orderBy('position','asc')
            ->get();
    }

}
