<?php

namespace App\Livewire\Admin\Blog;

use App\Models\BlogCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPage extends Component
{

    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search,$exportFiles = [];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {
        if (isset($this->search) && $this->search!=="")
        {
            $data = BlogCategory::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = BlogCategory::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.blog.category-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFilter():void
    {
        $this->requestFilter = $this->filter = [
            'sortBy'=>'id',
            'orderBy'=>'desc',
            'perPage'=>10
        ];
    }

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function updateStatus($id = null , $status = false):void
    {
        $check = BlogCategory::find($id);
        if ($check)
        {
            $check->status = $status?1:0;
            $check->save();
        }
    }

    public function destroy($id = null):void
    {
        $check = BlogCategory::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }


}
