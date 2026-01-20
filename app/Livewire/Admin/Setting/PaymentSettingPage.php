<?php

namespace App\Livewire\Admin\Setting;

use App\Helpers\Admin\SettingHelper;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class PaymentSettingPage extends Component
{
    public $request = [];

    public function mount():void
    {
        $this->EditRequest();
    }


    public function render()
    {
        return view('livewire.admin.setting.payment-setting-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save():void
    {
        SettingHelper::createOrUpdateSetting($this->request);
        update_env([
            'RAZORPAY_KEY'=>Str::replace(' ','',$this->request['rozarpay_key'] ??''),
            'RAZORPAY_SECRET'=>Str::replace(' ','',$this->request['rozarpay_secret'] ??''),

            'PAYPAL_MODE'=>Str::replace(' ','',$this->request['paypal_account_type'] ??''),
            'PAYPAL_LIVE_APP_ID'=>Str::replace(' ','',$this->request['paypal_live_app_id'] ??''),
            'PAYPAL_LIVE_CLIENT_ID'=>Str::replace(' ','',$this->request['paypal_live_client_id'] ??''),
            'PAYPAL_LIVE_CLIENT_SECRET'=>Str::replace(' ','',$this->request['paypal_live_client_secret'] ??''),
            'PAYPAL_SANDBOX_CLIENT_ID'=>Str::replace(' ','',$this->request['paypal_client_id'] ??''),
            'PAYPAL_SANDBOX_CLIENT_SECRET'=>Str::replace(' ','',$this->request['paypal_client_secret'] ??''),

            'STRIPE_KEY'=>Str::replace(' ','',$this->request['stripe_key'] ??''),
            'STRIPE_SECRET'=>Str::replace(' ','',$this->request['stripe_secret'] ??''),

            'PAYTM_MERCHANT_ID'=>Str::replace(' ','',$this->request['paytm_merchant_id'] ??''),
            'PAYTM_MERCHANT_KEY'=>Str::replace(' ','',$this->request['paytm_merchant_key'] ??''),
            'PAYTM_MERCHANT_WEBSITE'=>Str::replace(' ','',$this->request['paytm_merchant_website'] ??''),
            'PAYTM_CHANNEL'=>Str::replace(' ','',$this->request['paytm_channel'] ??''),
            'PAYTM_INDUSTRY_TYPE'=>Str::replace(' ','',$this->request['paytm_industry_type'] ??''),

        ]);

        $this->dispatchBrowserEvent('SweetMessage',[
            'type'=>'success',
            'title'=>trans('Payment Settings'),
            'message'=>trans('Updated Successfully')
        ]);
    }

    protected function EditRequest():void
    {
        $this->request = Setting::getByKeys([
            'rozarpay_key',
            'rozarpay_secret',
            'rozarpay_active',

            'paypal_account_type',
            'paypal_live_app_id',
            'paypal_live_client_id',
            'paypal_live_client_secret',
            'paypal_client_id',
            'paypal_client_secret',
            'paypal_active',

            'stripe_key',
            'stripe_secret',
            'stripe_active',

            'paytm_merchant_id',
            'paytm_merchant_key',
            'paytm_merchant_website',
            'paytm_channel',
            'paytm_industry_type',
            'paytm_active'

        ]);

        $requiredFields = [
            'rozarpay_key',
            'rozarpay_secret',

            'paypal_account_type',
            'paypal_live_app_id',
            'paypal_live_client_id',
            'paypal_live_client_secret',
            'paypal_client_id',
            'paypal_client_secret',

            'stripe_key',
            'stripe_secret',

            'paytm_merchant_id',
            'paytm_merchant_key',
            'paytm_merchant_website',
            'paytm_channel',
            'paytm_industry_type',
        ];
        foreach ($requiredFields as $field)
        {
            if(!Arr::has($this->request,$field))
            {
                $this->request[$field] = "";
            }
        }

    }
}
