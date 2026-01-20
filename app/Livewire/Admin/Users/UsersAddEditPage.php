<?php

namespace App\Livewire\Admin\Users;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UsersAddEditPage extends Component
{
    public $user_id;
    public string $pageTitle = "New User";
    public array $request = [];
    public mixed $countries = [];

    protected array $validationAttributes = [
        'request.salutation'=>'salutation',
        'request.name'=>'name',
        'request.last_name'=>'last_name',
        'request.email'=>'email',
        'request.phone'=>'phone',
        'request.password'=>'password',
    ];

    protected function rules():array
    {
        return [
            'request.salutation'=>'required|max:50',
            'request.name'=>'required|max:255',
            'request.last_name'=>'max:255',
            'request.email'=>'required|max:255|email|unique:users,email,'.$this->user_id ??0,
            'request.phone'=>'numeric|digits:10',
            'request.password'=>'required|min:4|max:16|confirmed',
        ];
    }

    public function mount():void
    {
        if (isset($this->user_id) && $this->user_id!=="")
        {
            $user = User::where('user_type','user')
                ->where('id',$this->user_id)
                ->first();
            $user?$this->EditRequest($user):redirect()->route('admin::users:list')->with('error','Invalid User Id');
        }
        else
        {
            $this->NewRequest();
        }
        $this->countries = Country::where('status',1)->orderBy('name','asc')->get();
    }

    public function render()
    {
        return view('livewire.admin.users.users-add-edit-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function Submit():void
    {
        $this->validate($this->rules());
        $this->Create($this->request);
    }
    protected function Create($data = [])
    {
        $data['password'] = Hash::make($data['password']);
        try {
            $user = User::create(Arr::only($data,[
                'salutation',
                'name',
                'last_name',
                'email',
                'phone',
                'country',
                'state',
                'city',
                'address',
                'avatar',
                'password',
                'registration_ip',
                'status',
            ]));
            $this->user_id = $user->id;
            $this->EditRequest($user);
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New User',
                message:'Created successfully',
                url:route('admin::users:list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    public function Save():void
    {
        if (!Arr::has($this->request,'password') || $this->request['password'] == "")
        {
            $this->validate(Arr::except($this->rules(),'request.password'));
        }
        else{ $this->validate($this->rules()); }
        $this->Update($this->request);
    }

    protected function Update($data = [])
    {
        if (Arr::has($data,'password') && $data['password']!=="")
        {
            $data['password'] = Hash::make($data['password']);
        }
        else{ Arr::forget($data,'password');  }
        try {
            User::where('id',$this->user_id)
                ->update(Arr::only($data,[
                    'salutation',
                    'name',
                    'last_name',
                    'email',
                    'phone',
                    'country',
                    'state',
                    'city',
                    'address',
                    'avatar',
                    'password',
                    'registration_ip',
                    'status',
                ]));
            Arr::forget($this->request,['password','password_confirmation']);
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit User',
                message:'Updated successfully',
                url:route('admin::users:list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    protected function NewRequest():void
    {
        $this->pageTitle = trans("New User");
        $this->request = [
            'salutation'=>null,
            'name'=>null,
            'last_name'=>null,
            'email'=>null,
            'phone'=>null,
            'country'=>null,
            'state'=>null,
            'city'=>null,
            'address'=>null,
            'avatar'=>null,
            'password'=>null,
            'registration_ip'=>request()->ip(),
            'status'=>1,
        ];
    }

    protected function EditRequest($user):void
    {
        $this->pageTitle = trans("Edit User");
        $this->request = $user->only([
            'salutation',
            'name',
            'last_name',
            'email',
            'phone',
            'country',
            'state',
            'city',
            'address',
            'avatar',
            'status',
        ]);
    }

}
