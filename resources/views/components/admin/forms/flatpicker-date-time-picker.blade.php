<div class="{{ $attributes->get('data-class') ??'mb-3' }}">
    <div
        x-data="{
        model: @entangle($attributes->wire('model')),
        dateTimePicker:$($refs.dateTimePicker)
    }"
        x-init="
            dateTimePicker.flatpickr({
                enableTime: true,
                dateFormat: '{{$attributes->get('format') ??'Y-m-d H:i:s'}}',
                time_24hr: true,
                defaultDate: model,
                position:'auto',
            });
            dateTimePicker.on('change',function(){ model = $(this).val() })
    "
        wire:ignore
    >
        <div class="form-group">
            <label class="form-label">{{ $attributes->get('data-label') ??'' }}</label>
            <input x-ref="dateTimePicker"
                   {{ $attributes->merge(['class' => 'form-control form-control-solid']) }}
                   placeholder="{{ $attributes->get('placeholder') }}"
            />
        </div>
    </div>
    @if($attributes->has('data-error'))
        @error($attributes->get('data-error'))
        <div class="text-danger small px-2"> {{$message}} </div>
        @enderror
    @endif
</div>

