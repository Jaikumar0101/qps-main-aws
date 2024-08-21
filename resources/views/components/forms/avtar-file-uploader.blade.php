<div
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    wire:ignore
>
    <!--begin::Image input-->
    <div class="image-input image-input-outline" data-kt-image-input="true"
         style="background-image: url('{{ $attributes->has('data-image')?$attributes->get('data-image'):'/assets/images/default/user.png' }}')">
        <!--begin::Preview existing avatar-->
        <div class="image-input-wrapper {{ $attributes->has('data-class')?$attributes->get('data-class'):'w-125px h-125px' }}"
             @if($attributes->wire('model') !== null) style="background-image: url('{{$attributes->wire('model')}}');" @endif ></div>
        <!--end::Preview existing avatar-->
        <!--begin::Label-->
        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
               data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
               data-bs-original-title="Change {{ $attributes->has('data-title')?$attributes->get('data-title'):'avatar' }}">
            <i class="bi bi-pencil-fill fs-7"></i>
            <!--begin::Inputs-->
            <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" onchange="uploadFile($(this))">
            <input type="hidden" name="avatar_remove">
            <!--end::Inputs-->
        </label>
        <!--end::Label-->
        <!--begin::Cancel-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
              data-bs-original-title="Cancel {{ $attributes->has('data-title')?$attributes->get('data-title'):'avatar' }}">
            <i class="bi bi-x fs-2"></i>
        </span>
        <!--end::Cancel-->
        <!--begin::Remove-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
              data-bs-original-title="Remove {{ $attributes->has('data-title')?$attributes->get('data-title'):'avatar' }}">
            <i class="bi bi-x fs-2"></i>
        </span>
        <!--end::Remove-->
    </div>
    <!--end::Image input-->
    <!--begin::Hint-->
    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
    <!--end::Hint-->
</div>
