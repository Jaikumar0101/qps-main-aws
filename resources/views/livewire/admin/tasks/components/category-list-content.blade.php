<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fs-6 fw-normal">
                    <span class="fw-bold">Category</span><br>
                    <span class="fs-8"> Showing the list of project categories</span>
                </h3>
            </div>
            <div class="card-toolbar gap-3">
                <button type="button"
                        class="btn btn-sm btn-icon btn-light-primary rounded-pill"
                        wire:click.prevent="OpenSettingModal"
                        wire:loading.attr="disabled"
                        data-bs-toggle="tooltip"
                        data-bs-title="Reorder Setting"
                >
                    <span class="spinner-border spinner-border-sm" wire:loading wire:target="OpenSettingModal"></span>
                    <span wire:loading.remove wire:target="OpenSettingModal"><i class="fa fa-cog"></i></span>
                </button>
                <button type="button"
                        class="btn btn-sm btn-icon btn-light-success rounded-pill"
                        wire:click.prevent="openAddEditCategory(null)"
                        wire:loading.attr="disabled"
                        data-bs-toggle="tooltip"
                        data-bs-title="Add Category"
                >
                    <span class="spinner-border spinner-border-sm" wire:loading wire:target="openAddEditCategory(null)"></span>
                    <span wire:loading.remove wire:target="openAddEditCategory(null)"><i class="fa fa-plus"></i></span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group gap-2" x-cloak>
                @forelse($data as $item)
                    @if($item->children()->exists())
                        <li class="list-group-item w-100 border"
                            x-data="{
                              open:true,
                              toggleOpen:function(){
                                 this.open = !this.open;
                              }
                            }"
                        >
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="javascript:void(0)"
                                       class="text-dark {{ $selectedCategory?->id == $item->id?'fw-bold':'' }}"
                                       @click.prevent="toggleOpen"
                                    >
                                        <i class="fa fs-8 me-2" :class="open?'fa-angle-up':'fa-angle-down'"></i>{{ $item->name ??''}}
                                    </a>
                                </div>
                                <div class="d-flex gap-3">
                                    <button type="button"
                                            class="btn p-0 btn-sm btn-icon btn-light-warning"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Projects"
                                            wire:click.prevent="changeSelectedCategory({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                    >
                                        {{ $item->projects()->count() ??0 }}
                                    </button>
                                    <button type="button"
                                            class="btn p-0 btn-sm btn-icon btn-light-primary"
                                            wire:click.prevent="openAddEditCategory({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Edit"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button"
                                            class="btn p-0 btn-sm btn-icon btn-light-danger"
                                            wire:confirm="Are you sure? you want to delete this category!"
                                            wire:click.prevent="destroy({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Delete"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <ul class="list-group gap-2 mt-2" x-show="open">
                                @foreach($item->children->sortBy('position') as $subItem)
                                    <li class="list-group-item w-100 border me-0 pe-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="{{ $selectedCategory?->id == $subItem->id?'fw-bold':'' }}">
                                                {{ $subItem->name ??''}}
                                            </div>
                                            <div class="d-flex gap-3">
                                                <button type="button"
                                                        class="btn p-0 btn-sm btn-icon btn-light-warning"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Projects"
                                                        wire:click.prevent="changeSelectedCategory({{ $subItem->id }})"
                                                        wire:loading.attr="disabled"
                                                >
                                                    {{ $subItem->projects()->count() ??0 }}
                                                </button>
                                                <button type="button"
                                                        class="btn p-0 btn-sm btn-icon btn-light-primary"
                                                        wire:click.prevent="openAddEditCategory({{ $subItem->id }})"
                                                        wire:loading.attr="disabled"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Edit"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                        class="btn p-0 btn-sm btn-icon btn-light-danger"
                                                        wire:confirm="Are you sure? you want to delete this category!"
                                                        wire:click.prevent="destroy({{ $subItem->id }})"
                                                        wire:loading.attr="disabled"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Delete"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="list-group-item w-100 border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="{{ $selectedCategory?->id == $item->id?'fw-bold':'' }}">
                                    {{ $item->name ??''}}
                                </div>
                                <div class="d-flex gap-3">
                                    <button type="button"
                                            class="btn p-0 btn-sm btn-icon btn-light-warning"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Projects"
                                            wire:click.prevent="changeSelectedCategory({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                    >
                                        {{ $item->projects()->count() ??0 }}
                                    </button>
                                    <button type="button"
                                            class="btn p-0 btn-sm btn-icon btn-light-primary"
                                            wire:click.prevent="openAddEditCategory({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Edit"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button"
                                            class="btn p-0 btn-sm btn-icon btn-light-danger"
                                            wire:confirm="Are you sure? you want to delete this category!"
                                            wire:click.prevent="destroy({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Delete"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endif
                @empty
                @endforelse
                <li class="list-group-item w-100 border">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="{{ $selectedCategory?->id == null?'fw-bold':'' }}">
                            Unresolved
                        </div>
                        <div class="d-flex gap-3">
                            <button type="button"
                                    class="btn p-0 btn-sm btn-icon btn-light-warning"
                                    data-bs-toggle="tooltip"
                                    data-bs-title="Projects"
                                    wire:click.prevent="changeSelectedCategory"
                                    wire:loading.attr="disabled"
                            >
                                {{  \App\Models\QuickProject::where('category_id',null)->count() ??0 }}
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <livewire:admin.tasks.components.category-setting-modal />
</div>
