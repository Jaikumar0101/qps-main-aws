<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public array $request = [];
    public bool $remember = false;
    protected array $validationAttributes = [
        'request.email'=>'email',
        'request.password'=>'password',
        'request.captcha'=>'captcha'
    ];

    protected function rules():array
    {
        if (config('settings.captcha'))
        {
            return [
                'request.email'=>'required|email|exists:users,email|max:255',
                'request.password'=>'required|min:4|max:16',
                'request.captcha'=>'required|captcha'
            ];
        }
        return [
            'request.email'=>'required|email|exists:users,email|max:255',
            'request.password'=>'required|min:4|max:16',
        ];
    }

    public function mount()
    {
        $this->NewRequest();
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }

    public function Submit()
    {
        $this->validate($this->rules());
        $check = Auth::attempt(\Arr::only($this->request,['email','password']),$this->remember);
        if ($check)
        {
            $this->redirect(route('admin::dashboard'));
        }
        else
        {
            $this->dispatch('SetMessage',type:"error",message:"Password is wrong");
        }
    }

    private function NewRequest()
    {
        $this->request = [
            'email'=>null,
            'password'=>null,
            'captcha'=>null
        ];
    }


}
