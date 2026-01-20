<button type="submit" class="btn btn-{{ $data['bg'] ??'primary' }} {{ $data['class'] ??'' }} me-2">
    <span class="indicator-label" wire:loading.remove wire:target="{{$data['target'] ??'save'}}">{{$data['label'] ??'Save'}}</span>
    <span class="indicator-progress" wire:loading wire:target="{{$data['target'] ??'save'}}">
         {!! $data['loading'] ??'Saving...<span class="spinner-border spinner-border-sm align-middle ms-2"></span>' !!}
    </span>
</button>
