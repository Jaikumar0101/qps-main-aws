<th class="min-w-50px {{ $class ??'' }}"
>
    <a wire:click.prevent="changeSortBy('{{ $element }}')"
       href="javascript:void(0)"
       class="text-dark"
    >
        @if($currentSort == $element)
            <i class="fa fa-fw {{ $currentOrder == "desc"?'fa-sort-down':'fa-sort-up' }} cursor-pointer"></i>
        @else
            <i class="fa fa-fw fa-sort cursor-pointer"></i>
        @endif
        {!! $label ??'' !!}
    </a>
</th>
