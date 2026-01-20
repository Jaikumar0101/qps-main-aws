<div x-data="{
        model: @entangle($attributes->wire('model')),
     }"
     x-init="
          // Initialize the multipleSelect plugin
          $($refs.multipleSelect).multipleSelect({
                filter: true,
                placeholder: '{{ $attributes->get('placeholder') ?? 'Select' }}',
                onClose: function(view) {
                    // Get selected options
                    let selectedOptions = $($refs.multipleSelect).find(':selected');
                    let selectedMonths = [];

                    selectedOptions.each(function() {
                        selectedMonths.push($(this).val());
                    });

                    // Update the Alpine model
                    model = selectedMonths;
                },
            });

            // Set the initial selected values
            $($refs.multipleSelect).multipleSelect('setSelects', model || []);

            // Watch for changes in the model and update the select
            $watch('model', (value) => {
                $($refs.multipleSelect).multipleSelect('setSelects', value || []);
            });
     "
     wire:ignore
>
    <select x-ref="multipleSelect"
            class="min-w-150px w-100 p-0"
            multiple
    >
        @foreach($options as $option)
            <option value="{{ $option[$optionValue] ??'' }}">{{ $option[$optionLabel] ??'' }}</option>
        @endforeach
    </select>
</div>
