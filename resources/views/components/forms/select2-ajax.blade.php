<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        parentId:'{{ Str::random(8) }}',
        options:{
                 @if($attributes->has('data-placeholder')) placeholder: '{{$attributes->get('data-placeholder')}}',@endif
                 @if($attributes->has('data-clear'))  allowClear: true, @endif
                 @if($attributes->has('data-url'))
                 ajax: {
                   delay: 250,
                   url: '{{$attributes->get('data-url')}}',
                   data: function (params) {
                      @if($attributes->has('data-prams'))
                        return {
                            ...{ search: params.term },
                            ...{!! $attributes->get('data-prams') !!}
                        };
                      @else
                       return {
                           search: params.term,
                       };
                      @endif
                   },
                   processResults: function (data) {
                       return {
                           results: data.data
                       };
                   }
                 },
               @endif
            },
    }"
    x-init="
        $($refs.select)
            .not('.select2-hidden-accessible')
            .select2(options);

             @if($attributes->has('multiple'))
              $($refs.select).on('select2:select', function (evt) {

                    const selectedData = evt.params.data;
                    const $select = $(this);

                    // Get the current array of selected option values
                    let selectedValues = $select.val() || [];

                    // Remove the selected option from the array if it already exists
                    selectedValues = selectedValues.filter(value => value != selectedData.id);

                    // Add the selected option to the end of the array
                    selectedValues.push(selectedData.id);

                    // Fetch all available options
                    const $options = $select.find('option');

                    // Append options back to the Select2 dropdown in the order of selectedValues
                    selectedValues.forEach(value => {
                          const $option = $options.filter(`[value='${value}']`);
                          $select.append($option);
                    });

                    // Update the Select2 element with the reordered selected options
                    $select.val(selectedValues).trigger('change');

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

        setTimeout(()=>{
           $($refs.select).wrap(window.wrapEle);
           options.dropdownParent = $($refs.select).parent();
           $($refs.select).select2(options);
        },200)

        $watch('model', (value) => {
          $($refs.select).val(value).trigger('change');
        });
    "
    wire:ignore
>
    <select x-ref="select"
        {{ $attributes->merge(['class' => $attributes->has('multiple')?'select2Livewire select2Ajax':'form-select select2Ajax']) }}
    >
        {{ $slot }}
    </select>
</div>
