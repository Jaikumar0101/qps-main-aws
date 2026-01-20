<div class="{{ $attributes->get('data-class') ??'mb-3' }}">
    <div
        x-data="{
            model: @entangle($attributes->wire('model')),
            flatPicker:null,
            dateTimePicker:$($refs.dateTimePicker),
            dateToPicker:$($refs.toDate),
            resetRange:function(){
                this.flatPicker.clear();
                 this.model = null;
            }
        }"
        x-init="
            flatPicker = flatpickr($refs.dateTimePicker,{
                enableTime: false,
                mode:'range',
                dateFormat:'Y-m-d',
                altFormat:'d/m/Y',
                position:'auto',
                plugins: [new rangePlugin({ input:$refs.toDate})]
            });

            dateTimePicker.on('change',function(){
                model = dateTimePicker.val() +' to '+ dateToPicker.val();
            })

            window.addEventListener('resetFilterMultiChoice',()=>{

            })
    "
        wire:ignore
    >
        <div class="form-group">
            <label class="form-label fs-8">{{ $attributes->get('label') ??'' }}</label>
            <div class="position-relative">
                <input x-ref="dateTimePicker"
                       {{ $attributes->merge(['class' => 'form-control form-control-sm']) }}
                       placeholder="{{ $attributes->get('placeholder') }}"
                />
                <div class="position-absolute" style="top: 50%;right: 10px;transform: translateY(-50%)"
                     x-show="model"
                >
                    <a href="javascript:void(0)"
                       @click="resetRange"
                    >
                        <i class="fa fa-xmark fs-6"></i>
                    </a>
                </div>
            </div>
            <input class="d-none" x-ref="toDate" />
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>
@endassets
