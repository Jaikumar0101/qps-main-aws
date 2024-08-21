<div
    x-data="{
        parentIndex:{{$attributes->get('parentIndex')}},
        uploadFile:FilePond.create($refs.input),
        FileID:null
    }"
    x-init="() => {
        uploadFile.setOptions({
            instantUpload: true,
            allowFileTypeValidation:'{!! $attributes->has('allowFileTypeValidation') !!}',
            server: {
                    headers:{ 'X-CSRF-TOKEN':'{!! csrf_token() !!}', 'folder':'{!! $attributes->has('folder')?$attributes->get('folder'):'images/' !!}'},
                    process:{
                        url : '{{ $attributes->has('data-upload-url')?$attributes->get('data-upload-url'):'/api/admin/upload' }}',
                        method:'POST',
                        onload:(response) => {
                            const responseData = JSON.parse(response);
                            if(responseData.success){  @this.addImageToSlider(parentIndex,responseData.data.url);  }
                            else{ toastr.error(responseData.message) }
                        },
                        onerror: (response) => {  const responseData = JSON.parse(response); if(!responseData.success){  toastr.error(responseData.message)  }  },
                    } ,
                    revert: (filename, load) => {
                            try{ removeFileByID(FileID); model = null; }
                            catch(e){ console.log(e.message); }
                            finally{ load(); }
                     },
            },
        });
        this.addEventListener('{{$attributes->has('data-remove')?$attributes->get('data-remove'):'removeUploadedFile'}}', e => {
            uploadFile.removeFiles();
        });
    }
    "
    wire:ignore
>
    <input type="file"
           x-ref="input"
           class="filepond"
           name="pic"
           @if($attributes->has('accept')) accept="{{$attributes->get('accept') ??''}}" @endif
    />
</div>

@once
    @push('scripts')
        <script data-navigate-track>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
        </script>
    @endpush
@endonce
