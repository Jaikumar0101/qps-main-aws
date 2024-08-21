<?php

namespace App\Livewire\Admin\Setting;

use App\Helpers\Admin\SettingHelper;
use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Component;

class MailSettingPage extends Component
{
    public $request = [];

    public function mount():void
    {
        $this->EditRequest();
    }

    public function render()
    {
        return view('livewire.admin.setting.mail-setting-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save():void
    {
        SettingHelper::createOrUpdateSetting($this->request);
        update_env([
            'MAIL_HOST'=>Str::replace(' ','',$this->request['mail_host']),
            'MAIL_PORT'=>Str::replace(' ','',$this->request['mail_port']),
            'MAIL_USERNAME'=>Str::replace(' ','',$this->request['mail_username']),
            'MAIL_PASSWORD'=>Str::replace(' ','',$this->request['mail_password']),
            'MAIL_ENCRYPTION'=>Str::replace(' ','',$this->request['mail_encryption']),
            'MAIL_FROM_ADDRESS'=>Str::replace(' ','',$this->request['mail_address']),
        ]);

        $this->dispatch('SweetMessage',
            type:'success',
            title:trans('Mail Settings'),
            message:trans('Updated Successfully')
    );
    }

    protected function EditRequest():void
    {
        $this->request = Setting::getByKeys([
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_address',
        ]);

    }
}
