<?php

namespace App\Livewire\Admin\Users;

use App\Helpers\Admin\BackendHelper;
use App\Models\UserRole;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class AdminRolePage extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $validationAttributes = [
        'request.name'=>'name',
        'request.description'=>'description',
    ];
    protected $rules = [
        'request.name'=>'required|max:255',
        'request.description'=>'max:500',
    ];

    public $request = [];

    public $search;

    public $perPage = 10;

    public function mount()
    {
        $this->NewRequest();
    }

    public function render()
    {
        $data = UserRole::query();

        if (checkData($this->search))
        {
            $data->where('name','Like',"%{$this->search}%");
        }

        $data = $data->paginate($this->perPage);

        return view('livewire.admin.users.admin-role-page',compact('data'));
    }

    public function Submit(): void
    {
        $this->validate($this->rules);
        $this->createOrUpdate($this->request);
    }

    protected function createOrUpdate($data = []): void
    {
        try
        {
            $data['roles'] = BackendHelper::JsonEncode($data['roles']);

            if (Arr::has($data,'id'))
            {
                $check = UserRole::find($data['id']);
                $message = "Updated successfully";
            }
            else
            {
                $check = new UserRole();
                $message = "Added successfully";
            }

            $check->fill(Arr::except($data,'id'));
            $check->save();

            $this->NewRequest();
            $this->dispatch('SetMessage',
                type:'success',
                message:$message,
                close:true,
            );

        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage(),
            );
        }
    }

    public function openAddEditModal($id = null):void
    {
        if (checkData($id))
        {
            $check = UserRole::find($id);
            if ($check)
            {
                $this->EditRequest($check);
                $this->dispatch('OpenAddEditModal');
            }
        }
        else
        {
            $this->NewRequest();
            $this->dispatch('OpenAddEditModal');
        }
    }

    protected function NewRequest():void
    {
        $this->request = [
            'name'=>null,
            'description'=>null,
            'roles'=>[],
            'status'=>0,
        ];
    }

    protected function EditRequest($check):void
    {
        $this->request = $check->only([
            'id',
            'name',
            'description',
            'roles',
            'status',
        ]);

        $this->request['roles'] = BackendHelper::JsonDecode($this->request['roles']);
    }

    public function destroy($id = null): void
    {
        $check = UserRole::find($id);

        if ($check)
        {
            $check->forceDelete();
            $this->dispatch('SetMessage',
                type:'success',
                message:'Deleted successfully',
            );
        }
    }

}
