<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        phoneInput:null,
    }"
    x-init="
        phoneInput = intlTelInput($refs.tel, {
                initialCountry: '{{ $attributes->get('country') ??'IN' }}',
                showSelectedDialCode:true,
                showFlags:true,
                geoIpLookup: function(callback) {
                     fetch('https://ipapi.co/json')
                    .then(function(res) { return res.json(); })
                    .then(function(data) { callback(data.country_code); })
                    .catch(function() { callback(); });
                },
                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.19/js/utils.js',

        })
        $($refs.tel).on('countrychange change',function (){
                let countryData = phoneInput.getSelectedCountryData();
                let number  = phoneInput.getNumber();
                let isValid = phoneInput.isValidNumber();
                model = number;
        })
         phoneInput.setNumber(model ??'');
    "
    wire:ignore
>
    <input x-ref="tel"
           id="international-phone"
        {{ $attributes->merge(['class' => '']) }}
    />
</div>

@assets
<style>
    .iti {
        width: 100%;
        display: block;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css" />
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
@endassets
