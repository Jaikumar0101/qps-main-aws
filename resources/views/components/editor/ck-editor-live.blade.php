<div
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
            ClassicEditor
                .create($refs.input,{
                     extraPlugins: [Timestamp],
                     ckfinder: {
                        uploadUrl:window.route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
                        openerMethod: 'popup',
                        options: {
                            resourceType: 'Images',
                        }
                    }
                })
                .then( editor => {
                      editor.setData(model);
                      editor.model.document.on('change:data', (evt, data) => {
                         model=editor.getData();
                     });
                } )
                .catch( err => {
                    console.error( err.stack );
                } );
    "
    wire:ignore
>
    <textarea x-ref="input" {{ $attributes->merge(['class' => 'form-control']) }}></textarea>
</div>
