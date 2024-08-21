<div class="form-group mb-3"
     x-data="{
        model: @entangle($attributes->wire('model')),
        inputRange:$($refs.rangeSelector),
        min:'{{ $attributes->get('min') ??0 }}',
        max:'{{ $attributes->get('max') ??0 }}',
     }"
     x-init="
          inputRange.ionRangeSlider({
              type:'double',
              grid:true,
              skin:'round',
              min:min,
              max:max,
              from:min,
              to:max,
              prettify_enabled:true,
              prettify_separator:',',
              postfix:'{{ $attributes->get('prefix') ??'' }}',
              onChange: function(data) {
                  // Update Alpine.js model when the slider value changes
                  model = [
                     data.from,
                     data.to,
                  ];
                  //console.log('Model updated to:', model);  // Debug log
              }
          });
            window.addEventListener('resetFilterMultiChoice',({detail:{data}})=>{
                    inputRange.data('ionRangeSlider').update({
                         from:min,
                         to:max
                    });
            })
     "
     wire:ignore
>
    <label class="form-label fs-8">{{ $attributes->get('label') ??'' }}</label>
    <input type="range"
           x-ref="rangeSelector"
    />
</div>

