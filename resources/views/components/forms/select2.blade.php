<div
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
        $($refs.select)
        .not('.select2-hidden-accessible')
        .select2({
            @if($attributes->has('dropdownParent'))
                dropdownParent: $('{{$attributes->get('dropdownParent')}}')
            @endif
        });

        @if($attributes->has('multiple'))
          $($refs.select).on('select2:select', function (evt) {
                const element = evt.params.data.element;
                const $element = $(element);
                $element.detach();
                $(this).append($element);
                $(this).trigger('change');
          });
        @endif

        $($refs.select).on('select2:select select2:unselect', (event) => {
           @if($attributes->has('multiple'))
              model = Array.from(event.target.options)
                    .filter(option => option.selected)
                    .map(option => option.value);
             @else
              model = event.params.data.id;
           @endif

        });

        $watch('model', (value) => {
            $($refs.select).val(value).trigger('change');
        });


    "
    wire:ignore
>
    <select x-ref="select"
        {{ $attributes->merge(['class' => $attributes->has('multiple') ? 'select2Livewire' : 'form-select']) }}
    >
        {{ $slot }}
    </select>
</div>
