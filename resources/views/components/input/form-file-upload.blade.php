<div class="form-group {{ $attributes->get('data-parent-class') ??'mb-3' }}"
     x-data="{ id: $id('text-input'),model: @entangle($attributes->wire('model')) }"
     x-init="
            $($refs.inputTextLfm).on('change',function(){
                model = $($refs.inputTextLfm).val()
            })
            $($refs.lfmButton).filemanager('image', {prefix: '/admin/file-manager'})
     "
     wire:ignore
>
    @if($attributes->has('data-label'))
        <label class="form-label">{{ $attributes->get('data-label') ??'' }}</label>
    @endif
    <div class="input-group">
        <input type="text"
               x-ref="inputTextLfm"
               :id="id"
               class="form-control @if($attributes->has('data-error')) @error($attributes->get('data-error')) is-invalid @enderror @endif {{ $attributes->get('data-class') ??'' }}"
            {!! $attributes->merge($attributes->getAttributes()) !!}
        >
        <button x-ref="lfmButton" x-on:click="" type="button" class="btn btn-primary btn-sm lfm" :data-input="id" data-preview="holder">
            <i class="fa fa-image"></i>&nbsp;&nbsp;Browse
        </button>
        @if($attributes->has('data-error'))
            @error($attributes->get('data-error'))
            <div class="invalid-feedback"> {{$message}} </div>
            @enderror
        @endif
    </div>
</div>
