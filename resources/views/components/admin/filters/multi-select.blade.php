<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        selectAll() {
            // Select all options
            $(this.$refs.select).val(Array.from(this.$refs.select.options).map(option => option.value)).trigger('change');
        },
        removeAll() {
            // Deselect all options
            $(this.$refs.select).val([]).trigger('change');
        },
    }"
    x-init="
        $($refs.select)
        .not('.select2-hidden-accessible')
        .select2({
            @if($attributes->has('dropdownParent'))
                dropdownParent: $('{{$attributes->get('dropdownParent')}}')
            @endif
        });

        $($refs.select).on('select2:select', function (evt) {
            const element = evt.params.data.element;
            const $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger('change');
        });

        $($refs.select).on('select2:select select2:unselect', (event) => {
            model = Array.from(event.target.options)
                    .filter(option => option.selected)
                    .map(option => option.value);
        });

        $watch('model', (value) => {
            $($refs.select).val(value).trigger('change');
        });
    "
    wire:ignore
>
    <select x-ref="select"
            class="select2Livewire form-select form-select-sm"
            multiple
    >
        @foreach($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>

    <div class="mt-2">
        <button type="button" @click="selectAll" class="btn btn-sm btn-primary">Select All</button>
        <button type="button" @click="removeAll" class="btn btn-sm btn-secondary">Remove All</button>
    </div>

</div>
