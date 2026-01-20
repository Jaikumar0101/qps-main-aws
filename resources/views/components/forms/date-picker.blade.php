<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        datePicker:$($refs.datePicker)
    }"
    x-init="
            datePicker.daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 1901,
                    autoApply:true,
                    drops:'down',
                    maxYear: parseInt(moment().format('YYYY'),12),
                    locale: {
                        format: '{{ $attributes->has('data-format')?$attributes->get('data-format'):'DD-MM-YYYY' }}'
                    },
                });
                if(model == null)
                {
                   datePicker.val('')
                }
             datePicker.on('change',function(){
                model = $(this).val()
             })
    "
    wire:ignore
>
    <div class="{{ $attributes->has('data-parent-class')?$attributes->get('data-parent-class'):'form-group mb-3' }}">
        @if($attributes->has('data-label'))
            <label class="{{ $attributes->has('data-label-class')?$attributes->get('data-label-class'):'form-label' }}">{!! $attributes->get('data-label') ??'' !!}</label>
        @endif
        <input x-ref="datePicker"
               {{ $attributes->merge(['class' => 'form-control ']) }}
               placeholder="{{ $attributes->get('placeholder') }}"
        />
        @if($attributes->has('data-error'))
            @error($attributes->get('data-error'))
            <div class="text-danger small p-1"> {{$message}} </div>
            @enderror
        @endif
    </div>
</div>


