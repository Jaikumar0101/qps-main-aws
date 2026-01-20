<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        myEditor:null
    }"
    x-init="
           myEditor =  CKEDITOR.replace($refs.input,{
               removePlugins: ['exportpdf,autosave','save'],
               height: {{$attributes->has('data-height')?$attributes->get('data-height'):400}},
               filebrowserImageBrowseUrl: window.route_prefix + '?type=Images',
               filebrowserImageUploadUrl: window.route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
               filebrowserBrowseUrl: window.route_prefix + '?type=Files',
               filebrowserUploadUrl: window.route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
               autosave: { autoLoad: false,messageType : 'no'},
            });
            myEditor.on('change',function (){ model = myEditor.getData(); })
            @if($attributes->has('data-change'))
             window.addEventListener('{{ $attributes->get('data-change') }}',({detail:{data}})=>{
                myEditor.setData(data);
            })
            @endif
    "
    wire:ignore
>
    <textarea x-ref="input" {{ $attributes->merge(['class' => 'form-control']) }}></textarea>
</div>
