@section('title','Project Category Reorder')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Category Reorder'),
            'menu'=>[ ['name'=>trans('Project')],['name'=>trans('Category')],['name'=>trans('Reorder'),'active'=>true] ],
             ])
        !!}
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Main Category</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group"  wire:sortable="updateParentOrder">
                                @foreach($data as $item)
                                    <li class="list-group-item" wire:sortable.item="{{ $item->id }}" wire:key="task-{{ $item->id }}" >
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="py-3">
                                                <span class="pe-2 sort-handler" wire:sortable.handle>
                                                    <i class="ki-duotone ki-abstract-14">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span> {{ $item->name ??'' }}
                                            </div>
                                            @if($item->children()->exists())
                                                <div>
                                                    <button class="btn btn-icon btn-sm btn-primary"
                                                            wire:click.prevent="openChildModal({{ $item->id }})"
                                                            wire:loading.attr="disabled"
                                                    >
                                                        <i class="ki-duotone ki-data">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sub categories for {{ $selectedCategory?->name ??'--' }}</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" wire:sortable="updateChildOrder">
                                @foreach($subData as $item)
                                    <li class="list-group-item" wire:sortable.item="{{ $item->id }}" wire:key="task-{{ $item->id }}" >
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="py-3">
                                                <span class="pe-2 sort-handler" wire:sortable.handle>
                                                    <i class="ki-duotone ki-abstract-14">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span> {{ $item->name ??'' }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@assets
    <style>
        .sort-handler:hover{
            cursor: move;
        }
    </style>
@endassets
