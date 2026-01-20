<div
    x-data="{
         model: @entangle($attributes->wire('model')),
    }"

>
    <label class="form-check form-check-custom form-check-solid form-switch">
        {{ $attributes->has('prefixLabel') ??'' }}
        <input class="form-check-input"
               type="checkbox"
               x-model="model"
               value="{{ $attributes->has('value')?$attributes->get('value'):1 }}"
        />
        {{ $attributes->has('label') ??'' }}
    </label>
</div>
