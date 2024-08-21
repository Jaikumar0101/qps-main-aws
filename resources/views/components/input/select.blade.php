<div>
    <!--begin::Row-->
    <div class="{{ $attributes->get('data-class') ??'mb-3' }}">
        <label class="form-label">{{ $attributes->get('label') ??'' }}</label>
        <select class="form-select @error($attributes->wire('model')->value()) is-invalid @enderror"
            {!! $attributes->merge($attributes->getAttributes()) !!}
        >
            {{ $slot ??'' }}
        </select>
        @error($attributes->wire('model')->value())
            <div class="invalid-feedback"> {{$message}} </div>
        @enderror
    </div>
    <!--end::Row-->
</div>
