<?php

namespace App\Livewire\Admin\Profile;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfilePage extends Component
{
    public $user_id;
    public $request,$passwordRequest;
    public $countries = [],$states = [],$cities = [];
    protected $validationAttributes = [
        'request.salutation'=>'salutation',
        'request.name'=>'name',
        'request.last_name'=>'last_name',
        'request.email'=>'email',
        'request.phone'=>'phone',

        'passwordRequest.old_password'=>'old password',
        'passwordRequest.password'=>'new password',
    ];

    public function mount():void
    {
        $this->GetRequest();
        $this->countries = Country::where('status',1)
            ->orderBy('name','asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.profile.profile-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save():void
    {
        $this->validate([
            'request.salutation'=>'required|max:50',
            'request.name'=>'required|max:255',
            'request.last_name'=>'max:255',
            'request.email'=>'required|max:255|email|unique:users,email,'.$this->user_id,
            'request.phone'=>'numeric|digits:10',
        ]);
        $this->update($this->request);
    }

    protected function update($data = []):void
    {
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
                ]));
                $this->dispatch('SetMessage',type:'success',message:'Updated successfully');
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function changePassword():void
    {
        $this->validate([
            'passwordRequest.old_password'=>['required',new MatchOldPassword()],
            'passwordRequest.password'=>'required|min:4|confirmed'
        ]);
        $password = Hash::make($this->passwordRequest['password']);
        User::where('id',$this->user_id)
            ->update(['password' => $password]);
        $this->passwordRequest = [
            'old_password'=>null,
            'password'=>null,
            'password_confirmation'=>null,
        ];
        $this->dispatch('SetMessage',type:'success',message:'Password changed successfully');

    }

    protected function GetRequest():void
    {
        $this->user_id = auth()->user()->id;
        $User = User::find($this->user_id);
        $this->request = $User->only([
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
        ]);
        $this->passwordRequest = [
            'old_password'=>null,
            'password'=>null,
            'password_confirmation'=>null,
        ];
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

}
