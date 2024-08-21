<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        dateTimePicker:$($refs.dateTimePicker)
    }"
    x-init="
            dateTimePicker.flatpickr({
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i:s',
                    defaultDate:model
                });
            dateTimePicker.on('change',function(){ model = $(this).val() })
    "
    wire:ignore
>
    <div class="form-group mb-10">
        <label class="form-label">{{ $attributes->get('data-label') ??'' }}</label>
        <input x-ref="dateTimePicker"
               {{ $attributes->merge(['class' => 'form-control form-control-solid']) }}
               placeholder="{{ $attributes->get('placeholder') }}"
        />
        @if($attributes->has('data-error'))
            @error($attributes->get('data-error'))
            <div class="invalid-feedback"> {{$message}} </div>
            @enderror
        @endif
    </div>
</div>


