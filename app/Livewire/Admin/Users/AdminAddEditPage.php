<?php

namespace App\Livewire\Admin\Users;

use App\Helpers\Admin\BackendHelper;
use App\Helpers\Role\RoleHelper;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminAddEditPage extends Component
{
    public $user_id;
    public string $pageTitle;
    public array $request = [];
    public mixed $countries = [],$states = [],$cities = [];

    public $userRoles = [];

    protected array $validationAttributes = [
        'request.role_id'=>'role',
        'request.salutation'=>'salutation',
        'request.name'=>'name',
        'request.last_name'=>'last_name',
        'request.email'=>'email',
        'request.phone'=>'phone',
        'request.password'=>'password',
    ];

    public function mount():void
    {
        $this->userRoles = UserRole::all();

        if (checkData($this->user_id))
        {
            $user = User::where('user_type','!=','user')
                ->where('id',$this->user_id)
                ->first();
            $user?$this->EditRequest($user):redirect()->route('admin::users:admin.list')->with('error','Invalid Admin Id');
        }
        else
        {
            $this->NewRequest();
        }
        $this->countries = Country::where('status',1)->orderBy('name','asc')->get();


    }

    public function render()
    {
        $this->pageTitle = checkData($this->user_id)?trans('Edit Admin'):trans('New Admin');
        return view('livewire.admin.users.admin-add-edit-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function Submit():void
    {
        $this->validate([
            'request.role_id'=>'required',
            'request.salutation'=>'max:50',
            'request.name'=>'required|max:255',
            'request.last_name'=>'max:255',
            'request.email'=>'required|max:255|email|unique:users,email',
            'request.phone'=>'numeric|digits:10|nullable',
            'request.password'=>'required|min:4|max:16|confirmed',
        ]);
        $this->updatedRequestRoleId();
        $this->Create($this->request);
    }

    protected function Create($data = [])
    {
        $data['password'] = Hash::make($data['password']);
        try {

            $data['roles'] = BackendHelper::JsonEncode($data['roles']);

            $user = User::create(Arr::only($data,[
                'role_id',
                'user_type',
                'roles',
                'salutation',
                'name',
                'last_name',
                'email',
                'phone',
                'company',
                'country',
                'state',
                'city',
                'address',
                'avatar',
                'password',
                'registration_ip',
                'ip_check',
                'ip_allowed',
                'status',
            ]));
            $this->user_id = $user->id;

            $this->EditRequest($user);

            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Team Member',
                message:'Created successfully',
                url:route('admin::users:admin.list')
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
        $rules = [
            'request.role_id'=>'required',
            'request.salutation'=>'max:50',
            'request.name'=>'required|max:255',
            'request.last_name'=>'max:255',
            'request.email'=>'required|max:255|email|unique:users,email,'.$this->user_id,
            'request.phone'=>'numeric|digits:10|nullable',
        ];
        if (Arr::has($this->request,'password') && $this->request['password']!=="")
        {
            $rules['request.password'] = 'required|min:4|max:16|confirmed';
        }
        $this->validate($rules);
        $this->updatedRequestRoleId();

        $this->Update($this->request);
    }

    protected function Update($data = [])
    {
        if (Arr::has($data,'password') && $data['password']!=="")
        {
            $data['password'] = Hash::make($data['password']);
        }
        else{ Arr::forget($data,'password');  }
        try
        {
            $data['roles'] = BackendHelper::JsonEncode($data['roles']);

            User::where('id',$this->user_id)
                ->update(Arr::only($data,[
                    'role_id',
                    'user_type',
                    'roles',
                    'salutation',
                    'name',
                    'last_name',
                    'email',
                    'phone',
                    'company',
                    'country',
                    'state',
                    'city',
                    'address',
                    'avatar',
                    'password',
                    'registration_ip',
                    'ip_check',
                    'ip_allowed',
                    'status',
                ]));
            Arr::forget($this->request,['password','password_confirmation']);
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Team Member',
                message:'Updated successfully',
                url:route('admin::users:admin.list')
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
        $this->pageTitle = trans("New");
        $this->request = [
            'role_id'=>null,
            'user_type'=>'sub_admin',
            'roles'=>[],
            'salutation'=>null,
            'name'=>null,
            'last_name'=>null,
            'email'=>null,
            'phone'=>null,
            'company'=>null,
            'country'=>null,
            'state'=>null,
            'city'=>null,
            'address'=>null,
            'avatar'=>null,
            'password'=>null,
            'registration_ip'=>request()->ip(),
            'ip_check'=>0,
            'ip_allowed'=>null,
            'status'=>1,
        ];
    }

    protected function EditRequest($user):void
    {
        $this->pageTitle = trans("Edit");

        $this->request = $user->only([
            'role_id',
            'user_type',
            'roles',
            'salutation',
            'name',
            'last_name',
            'email',
            'phone',
            'company',
            'country',
            'state',
            'city',
            'address',
            'avatar',
            'ip_check',
            'ip_allowed',
            'status',
        ]);

        if (isset($this->request['country']))
        {
            $this->states = State::where([
                'country_id'=>$this->request['country'],
                'status'=>1
            ])->get();
        }
        if (isset($this->request['state']))
        {
            $this->cities = City::where([
                'state_id'=>$this->request['state'],
                'status'=>1
            ])->get();
        }

        $this->request['roles'] = BackendHelper::JsonDecode($this->request['roles']);

    }

    public function updatedRequestCountry()
    {
        $this->states = State::where([
            'country_id'=>$this->request['country'],
            'status'=>1
        ])->get();
        $this->request['state'] = null;
        $this->request['city'] = null;
    }

    public function updatedRequestState()
    {
        $this->cities = City::where([
            'state_id'=>$this->request['state'],
            'status'=>1
        ])->get();
    }

    public function selectAllRoles()
    {
        $keys = array_keys(RoleHelper::getRoles());
        $this->request['roles'] = $keys;
    }

    public function updatedRequestRoleId(): void
    {
        if (checkData($this->request['role_id']))
        {
            $role = UserRole::find($this->request['role_id']);
            if ($role)
            {
                if ($role->name == "Super Admin")
                {
                    $this->request['user_type'] = "admin";
                }
                elseif ($role->name == "Client")
                {
                    $this->request['user_type'] = "manager";
                }
                else{
                    $this->request['user_type'] = "sub_admin";
                }
            }
        }
        else
        {
            $this->request['user_type'] = "sub_admin";
        }
    }
}
