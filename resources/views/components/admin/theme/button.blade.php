@if($link)
    <a {{ $attributes->merge(['class'=>$class]) }}
       href="{{ $link ??'' }}"
    >
        @if($spinner)
            <span class="spinner-border spinner-border-sm align-middle mr-2" wire:loading wire:target="{{ $spinner }}"></span>
            <span wire:loading.remove wire:target="{{ $spinner }}" class=" me-1">{!! checkData($icon)?('<i class="'.$icon.'"></i>'):'' !!}</span>
        @else
            {!! checkData($icon)?('<i class="'.$icon.' me-1"></i>'):'' !!}
        @endif
        {{ $label ??'' }}
    </a>
@else
    <button {{ $attributes->merge(['class'=>$class]) }} >
        @if($spinner)
            <span class="spinner-border spinner-border-sm align-middle mr-2" wire:loading wire:target="{{ $spinner }}"></span>
            <span wire:loading.remove wire:target="{{ $spinner }}" class=" me-1">{!! checkData($icon)?('<i class="'.$icon.'"></i>'):'' !!}</span>
        @else
            {!! checkData($icon)?('<i class="'.$icon.' me-1"></i>'):'' !!}
        @endif
        {{ $label ??'' }}
    </button>
@endif

