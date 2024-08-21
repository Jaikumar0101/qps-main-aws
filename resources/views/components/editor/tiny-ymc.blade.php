<div
    x-data="{
        model: @entangle($attributes->wire('model')),
        myEditorId:$refs.input.getAttribute('id')
    }"
    x-init="
        tinymce.init({
           path_absolute :'/',
           height : {{$attributes->has('data-height')?$attributes->get('data-height'):400}},
           selector: 'textarea#' + myEditorId,
           relative_urls: false,
           plugins: ['image','link','media'],
              setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('change', function (e) {
                   model = editor.getContent();
                });
            },
           toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
            file_picker_callback : function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = window.route_prefix + '?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
            cmsURL = cmsURL + '&type=Images';
            } else {
            cmsURL = cmsURL + '&type=Files';
            }

            tinyMCE.activeEditor.windowManager.openUrl({
            url : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : 'yes',
            close_previous : 'no',
            onMessage: (api, message) => {
            callback(message.content);
         },

          });
}

        });
    "
    wire:ignore

>
    <textarea id="editor-{{ Str::random(6) }}" x-ref="input" {{ $attributes->merge(['class' => 'form-control']) }}></textarea>
</div>
