<div class="form-group mb-3">
    <!--begin::Switch-->
    <label class="form-check form-switch form-check-custom form-check-solid">
        <input type="checkbox"
               {{ $attributes->merge(['class'=>'form-check-input']) }}
               checked="{{ $checked }}"
        />
        <span class="form-check-label fw-semibold text-muted">
            {{ $label ??'' }}
        </span>
    </label>
    <!--end::Switch-->
</div>
