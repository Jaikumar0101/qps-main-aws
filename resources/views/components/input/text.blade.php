<div class="form-group mb-3">
    <label class="form-label">{{ $attributes->get('label') ??'' }}</label>
    <input class="form-control @error($attributes->wire('model')->value()) is-invalid @enderror"
           {!! $attributes->merge($attributes->getAttributes()) !!}
    />
    @error($attributes->wire('model')->value())
    <div class="invalid-feedback"> {{$message}} </div>
    @enderror
</div>


