<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        myEditor:null
    }"
    x-init="
         myEditor = new Quill($refs.input, {
            placeholder: 'Type Something...',
            modules: {
              formula: false,
              toolbar:[
                  [{ 'font': [] }],
{{--                  [{ 'size': ['small', false, 'large', 'huge'] }],--}}
                  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                  ['bold', 'italic', 'underline', 'strike'],
                  ['blockquote'],
                  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                  [{ 'align': [] }],
{{--                  [{ 'color': [] }, { 'background': [] }],--}}
                  ['link', 'image', 'video'],
               ]
            },
            theme: 'snow'
         });
{{--         myEditor.setContents(myEditor.clipboard.convert(model), 'silent')--}}
         myEditor.on('text-change', function () {
             model = $refs.input.innerHTML
         });
    "
    wire:ignore
>
    <div x-ref="input">{{ $slot ??'' }}</div>
</div>
