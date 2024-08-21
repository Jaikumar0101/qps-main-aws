<?php

namespace App\Livewire\Admin\Setting;

use App\Helpers\Admin\SettingHelper;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class WebsiteSettingPage extends Component
{
    public array $request = [];

    public function mount()
    {
        $this->EditRequest();
    }

    public function render()
    {
        return view('livewire.admin.setting.website-setting-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save():void
    {
        SettingHelper::createOrUpdateSetting($this->request);
        update_env([
            "APP_ENV"=>$this->request['app_env'],
            "APP_URL"=>$this->request['app_url'],
            "APP_DEBUG"=>$this->request['app_env'] === "local"?"true":"false",
            "DEBUGBAR_ENABLED"=> $this->request['app_debug']==1?"true":"false",
            "APP_TIMEZONE"=>$this->request['app_timezone']
        ]);

        $this->dispatch('SweetMessage',type:'success',title:'General Settings',message:'Updated Successfully');
    }

    protected function EditRequest():void
    {
        $this->request = Setting::getByKeys([
            'app_env',
            'app_url',
            'app_debug',
            'app_timezone',
            'https_redirect',
        ]);
        $requiredFields = [
            'app_env',
            'https_redirect',
            'app_timezone',
        ];
        foreach ($requiredFields as $field)
        {
            if(!Arr::has($this->request,$field))
            {
                $this->request[$field] = null;
            }
        }
    }
}
