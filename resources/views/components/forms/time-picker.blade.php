<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        timePicker:$($refs.timePicker)
    }"
    x-init="
            timePicker.flatpickr({
                    noCalendar: true,
                    enableTime: true,
                    dateFormat: 'H:i',
                    time_24hr: true,
                });
            if(model == null)
            {
               timePicker.val('')
            }
            timePicker.on('change',function(){ model = $(this).val() })
    "
    wire:ignore
>
    <div class="form-group mb-10">
        <label class="form-label">{!! $attributes->get('data-label') ??'' !!}</label>
        <input x-ref="timePicker"
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


