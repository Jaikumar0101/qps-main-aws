<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminsListPage extends Component
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
            $data = User::where('user_type','!=','user')
                ->where(function ($q){
                    $q->orWhere('id','like',$this->search)
                        ->orWhere('name','like',"{$this->search}%")
                        ->orWhere('name','like',"%{$this->search}%")
                        ->orWhere('email','like',"%{$this->search}%");
                })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = User::where('user_type','!=','user')
                ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.users.admins-list-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function resetFilter():void
    {
        $this->requestFilter =  $this->filter = [
            'sortBy'=>'id',
            'orderBy'=>'desc',
            'perPage'=>10
        ];
    }

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function destroy($id = null):void
    {
        $check = User::find($id);
        if ($check)
        {
            if ($check->id == auth()->user()->id)
            {
                $this->dispatch('SetMessage',type:'error',message:'You not allowed to deleted own account');
            }
            else
            {
                $check->delete();
                $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
            }
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
