<div class="w-full"
    wire:ignore
    x-data="{
        model: @entangle($attributes->wire('model')) || [],
        monthSelector:$($refs.multipleSelect),
        updateData:function(data){
            this.monthSelector.multipleSelect('uncheckAll');
            this.monthSelector.multipleSelect('setSelects',data)
        }
     }"
    x-init="
         monthSelector.multipleSelect({
                placeholder:'{{ $attributes->get('placeholder') ??'Select' }}',
                filter: true,
                filterPlaceholder: 'Search',
                onClose: function(view) {
                    let selectedOptions = monthSelector.find(':selected');
                    let selectedMonths = [];
                    selectedOptions.each(function() {
                        selectedMonths.push($(this).val());
                    });
                    model = selectedMonths;
                },
            });

        monthSelector.multipleSelect('setSelects',model)

        @if($attributes->has('updateMethod'))
                window.addEventListener('{{ $attributes->get('updateMethod') }}',({detail:{data}})=>{
                    updateData(data)
                })
        @else
                window.addEventListener('resetFilterMultiChoice',({detail:{data}})=>{
                    updateData(data)
                })
        @endif
     ">
    @if($attributes->has('label'))
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1 {{ $attributes->get('labelClass') ??'fs-8' }} fw-bold">
        {{ $attributes->get('label') ??'' }}
    </label>
    @endif
    <div class="{{ $attributes->get('class') }}">
        <select class="min-w-150px w-100 p-0"
            x-ref="multipleSelect"
            multiple>
            @foreach($options as $option)
                <option value="{{ $option[$optionValue] ?? '' }}">{{ $option[$optionLabel] ?? '' }}</option>
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
