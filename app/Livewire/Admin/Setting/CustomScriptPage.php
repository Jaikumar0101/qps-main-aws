<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;

class CustomScriptPage extends Component
{
    public mixed $customCss, $customJs;

    public function mount()
    {
        $this->customCss = file_get_contents(public_path('css/custom.css'));
        $this->customJs = file_get_contents(public_path('js/custom.js'));
    }

    public function render()
    {
        return view('livewire.admin.setting.custom-script-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function saveCustomCss()
    {
        file_put_contents(public_path('css/custom.css'),$this->customCss);
        $this->dispatch('SetMessage',
            type:'success',
            message:'Css Updated Successfully',
        );
    }

    public function saveCustomJs() {
        file_put_contents(public_path('js/custom.js'),$this->customJs);
        $this->dispatch('SetMessage',
            type:'success',
            message:'Js Updated Successfully',
        );
    }


}
