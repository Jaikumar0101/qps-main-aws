<div class="mb-3">
    <label class="form-label">{{ $attributes->get('label') ??'' }}</label>
    <textarea class="form-control @error($attributes->wire('model')->value()) is-invalid @enderror"
        {!! $attributes->merge($attributes->getAttributes()) !!}
    ></textarea>
    @error($attributes->wire('model')->value())
    <div class="invalid-feedback"> {{$message}} </div>
    @enderror
</div>
