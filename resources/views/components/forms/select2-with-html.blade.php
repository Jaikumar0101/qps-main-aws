<div
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
        $($refs.select)
            .not('.select2-hidden-accessible')
            .select2({
                templateResult: function (item) {
                    return formatSelect2Html(item);
                },
             @if($attributes->has('dropdownParent'))
             dropdownParent: $('{{$attributes->get('dropdownParent')}}')
             @endif
            });
        $($refs.select).on('select2:select', (event) => {
             if (event.target.hasAttribute('multiple')) { model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value); }
             else { model = event.params.data.id }
        });
        $($refs.select).on('select2:unselect', (event) => {
             if (event.target.hasAttribute('multiple')) { model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value); }
             else { model = event.params.data.id }
        });
        $watch('model', (value) => {
            $($refs.select).val(value).trigger('change');
        });
    "
    wire:ignore
>
    <select x-ref="select" {{ $attributes->merge(['class' => 'form-select select2Livewire']) }} >
        {{ $slot }}
    </select>
</div>


@once
    @push('scripts')
        <script>
            const formatSelect2Html = (item) => {
                if (!item.id) {
                    return item.text;
                }
                const htmlData =  item.element.getAttribute('data-html');
                const span = $("<span>", {
                    text: " " + item.text
                });
                span.prepend(htmlData);
                return span;
            }
        </script>
    @endpush
@endonce
