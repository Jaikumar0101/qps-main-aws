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
         monthSelector = $($refs.multipleSelect);
         monthSelector.multipleSelect({
             placeholder: '{{ $attributes->get('placeholder') ?? 'Select' }}',
             filter: true,
             filterPlaceholder: 'Search',
             onClose: function() {
                 let selectedOptions = monthSelector.find(':selected');
                 let selectedMonths = [];
                 selectedOptions.each(function() {
                     selectedMonths.push($(this).val());
                 });
                 @this.set('{{ $attributes->wire('model') }}', selectedMonths);
             }
         });
         monthSelector.multipleSelect('setSelects', model);

         @if($attributes->has('updateMethod'))
             window.addEventListener('{{ $attributes->get('updateMethod') }}', (e) => {
                 updateData(e.detail.data);
             });
         @else
             window.addEventListener('resetFilterMultiChoice', (e) => {
                 updateData(e.detail.data);
             });
         @endif
     ">
    @if($attributes->has('label'))
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1 {{ $attributes->get('labelClass') ?? 'fs-8 fw-bold' }}">
            {{ $attributes->get('label') }}
        </label>
    @endif
    <div class="{{ $attributes->get('class') }}">
        <select class="min-w-150px w-100 p-0 form-select" {{-- Add form-select for Tailwind styling --}}
                x-ref="multipleSelect"
                multiple>
            @foreach($options as $option)
                <option value="{{ $option[$optionValue] }}">{{ $option[$optionLabel] }}</option>
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
