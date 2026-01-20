<div x-data="{
        init() {
            const lightbox = new PhotoSwipeLightbox({
                gallery: '#gallery-{{ $uuid ??'' }}',
                children: 'a',
                showHideAnimationType: 'fade',
                pswpModule: PhotoSwipe
            });

            lightbox.init();
        }
    }"
>
    <div class="grid grid-cols-1" id="gallery-{{ $uuid }}">
        @foreach($documentRowData as $i=>$item)
            <div class="border border-dashed rounded px-3 py-2 mb-3">
                <div class="flex justify-between gap-x-4 align-middle items-center">
                    <div class="w-16">
                        <a
                            class="carousel-item"
                            href="{{ asset($item['file'] ??'') }}"
                            target="_blank"
                            data-pswp-width="200"
                            data-pswp-height="200"
                        >
                            <img
                                src="{{ asset($item['file'] ??'') }}"
                                class="object-cover hover:opacity-70 h-10"
                                style="image-rendering: pixelated;"
                                onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)"
                            />
                        </a>
                    </div>
                    <div class="w-3/4">
                        <input type="text"
                               wire:model="documents.{{ $attributes->get('type') }}.{{ $i }}.name"
                               class="form-control"
                        />
                    </div>
                    <div>
                        <div class="flex gap-3">
                            <div>
                                <button onclick="window.open('{{ asset($item['file'] ??'') }}','_blank')"
                                        type="button"
                                        class="btn normal-case !inline-flex lg:tooltip lg:tooltip-top btn-circle btn-primary text-white btn-sm"
                                        data-tip="Download"
                                >
                                   <span class="block">
                                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                                    </svg>
                                   </span>
                                </button>
                            </div>
                            <div>
                                <x-mary-button icon="o-trash"
                                               class="btn btn-circle btn-error text-white btn-sm"
                                               tooltip="Remove"
                                               spinner="removeDocumentItem({{$i}},'{{ $attributes->get('type') }}')"
                                               wire:click.prevent="removeDocumentItem({{$i}},'{{ $attributes->get('type') }}')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
