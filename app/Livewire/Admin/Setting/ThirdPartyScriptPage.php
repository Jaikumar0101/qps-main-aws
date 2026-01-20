<?php

namespace App\Livewire\Admin\Setting;

use App\Helpers\Admin\SettingHelper;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Livewire\Component;

class ThirdPartyScriptPage extends Component
{
    public array $request = [];

    public function mount():void
    {
        $this->EditRequest();
    }

    public function render()
    {
        return view('livewire.admin.setting.third-party-script-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save():void
    {
        SettingHelper::createOrUpdateSetting($this->request);
        $this->dispatch('SweetMessage',
            type:'success',
            title:trans('Third Party Scripts'),
            message:trans('Updated Successfully')
        );
    }

    protected function EditRequest():void
    {
        $this->request = Setting::getByKeys([
            'google_analytics_code',
            'google_analytics_status',

            'third_party_code',
            'third_party_status',
        ]);

        $requiredFields = [
            'google_analytics_code',
            'third_party_code',
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
