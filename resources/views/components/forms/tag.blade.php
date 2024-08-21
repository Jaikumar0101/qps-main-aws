<div
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
       new Tagify($refs.input);
       $($refs.input).on('change',function () {
            let tagsArr = [];
            try
            {
                const tags = JSON.parse($(this).val());
                for(let i =0; i<tags.length; i++)
                {
                    tagsArr.push(tags[i]['value']);
                }
            }
            catch(e){ console.log(e.message); }
            finally{ model = tagsArr.join(',') ;  }
        });
    "
    wire:ignore
>
    <input x-ref="input"  {{ $attributes->merge(['class' => 'form-control ps-2']) }} />
</div>
