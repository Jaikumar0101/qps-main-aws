<div class="w-full"
     wire:ignore
     x-data="{
         model: @entangle($attributes->wire('model')) || [],
         monthSelector: null,
         updateData(data) {
             if (this.monthSelector) {
                 this.monthSelector.multipleSelect('uncheckAll');
                 this.monthSelector.multipleSelect('setSelects', data);
             }
         }
     }"
     x-init="
         this.monthSelector = $($refs.multipleSelect);
         this.monthSelector.multipleSelect({
             placeholder: '{{ $attributes->get('placeholder') ?? 'Select' }}',
             filter: true,
             filterPlaceholder: 'Search',
             onClose: () => {
                 let selectedOptions = this.monthSelector.find(':selected');
                 let selectedValues = [];
                 selectedOptions.each((i, el) => {
                     selectedValues.push($(el).val());
                 });
                 @this.set('{{ $attributes->wire('model') }}', selectedValues);
             }
         });
         this.monthSelector.multipleSelect('setSelects', model);

         @if($attributes->has('updateMethod'))
             window.addEventListener('{{ $attributes->get('updateMethod') }}', (e) => {
                 this.updateData(e.detail.data);
             });
         @else
             window.addEventListener('resetFilterMultiChoice', (e) => {
                 this.updateData(e.detail.data);
             });
         @endif
     ">
    @if($attributes->has('label'))
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1 {{ $attributes->get('labelClass') ?? 'fs-8 fw-bold' }}">
            {{ $attributes->get('label') }}
        </label>
    @endif
    <div class="{{ $attributes->get('class') }}">
        <select class="min-w-150px w-100 p-0 form-select"
                x-ref="multipleSelect"
                multiple
                wire:key="{{ md5($attributes->wire('model') ?? uniqid()) }}">
            @foreach($options as $option)
                <option value="{{ data_get($option, $optionValue, $option[$optionValue] ?? '') }}"
                        {{ in_array(data_get($option, $optionValue), (array) $attributes->wire('model'), true) ? 'selected' : '' }}>
                    {{ data_get($option, $optionLabel, $option[$optionLabel] ?? '') }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@once
    @assets
    <style>
        .ms-choice {
            min-height: calc(1.5em + 1.1rem + 2px);
            font-size: .95rem;
            border-radius: .425rem;
        }
        .ms-choice span {
            line-height: 1.5;
            padding: .55rem .75rem;
            cursor: pointer;
        }
        .ms-drop {
            width: 100%;
        }
    </style>
    @endassets
@endonce
