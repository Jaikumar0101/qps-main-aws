<div>
    <div x-data="{
                drawerStatus: @entangle('drawer'),
                drawerEl:$refs.kt_drawer,
                openModal:function(c = false){
                    let drawer = KTDrawer.getInstance(this.drawerEl);
                    drawer.show();
                    if(c){ this.drawerStatus = true; }
                },
                closeModal:function(c = false){
                    let drawer = KTDrawer.getInstance(this.drawerEl);
                    drawer.hide();
                    if(c){ this.drawerStatus = false; }
                },
            }"

            x-init="
                $watch('drawerStatus', value => {
                    if (value) {
                       openModal();
                    } else {
                       closeModal();
                    }
                })

                // let drawer = KTDrawer.getInstance(drawerEl);
                //   drawer.on('kt.drawer.hide', function() {
                //       this.drawerStatus = false;
                //   });

            "
         wire:ignore.self
>
        <!--begin::Drawer-->
        <div
            x-ref="kt_drawer"
            id="kt_drawer_op"
            class="bg-white"
            data-kt-drawer="true"
            data-kt-drawer-activate="true"
            data-kt-drawer-toggle="#kt_drawer_filter_button"
            data-kt-drawer-close="#kt_drawer_example_permanent_close"
            data-kt-drawer-overlay="true"
            data-kt-drawer-permanent="true"
            data-kt-drawer-width="{default:'300px', 'md': '500px'}"
            wire:ignore.self
        >
            <div class="card rounded-0 w-100">
                <!--begin::Card header-->
                <div class="card-header pe-5">
                    <!--begin::Title-->
                    <div class="card-title">
                        <i class="fa fa-filter fs-5 me-3"></i> Filter
                    </div>
                    <!--end::Title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Close-->
                        <button class="btn btn-sm btn-icon btn-active-light-primary"
                                @click.prevent="closeModal(true)"
                        >
                            <i class="fa fa-xmark"></i>
                        </button>
                        <!--end::Close-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <div class="card-body hover-scroll-overlay-y">

                    @forelse($otherFilters as $key=>$item)
                        <div class="card border rounded mb-3 position-relative">
                            <div class="card-body px-3 py-2">
                                <div class="row gy-2">
                                    <div class="col-md-6">
                                        <select class="form-select form-select-sm"
                                                wire:model.live="otherFilters.{{$key}}.type"
                                                wire:change="updateFilterType({{ $key }})"
                                        >
                                            @foreach(FilterHelper::$filterKeysLabels as $i=>$row)
                                                <option value="{{ $i ??'' }}">{{ $row ??'' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select form-select-sm"
                                                wire:model.live="otherFilters.{{$key}}.filter"
                                                wire:change="updateFilterValue({{ $key }})"
                                        >
                                            <option>--</option>
                                            @foreach(FilterHelper::getFilterOptions($item['type']) as $row)
                                                <option value="{{ $row ??'' }}">{{ FilterHelper::getFilterLabel($row) ??'' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        @switch($item['filter'])
                                            @case('like')
                                            @case('like_after')
                                            @case('like_before')
                                            @case('equal')
                                                <input type="text" wire:model="otherFilters.{{$key}}.value" class="form-control form-control-sm" />
                                                @break
                                            @case('greaterThan')
                                            @case('lessThan')
                                                <input type="number" step="any" wire:model="otherFilters.{{$key}}.value" class="form-control form-control-sm" />
                                                @break
                                            @case('date')
                                                <input type="date"
                                                       wire:model="otherFilters.{{$key}}.value"
                                                       class="form-control form-control-sm"
                                                       pattern="^(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])-\d{4}$"
                                                />
                                                @break
                                            @case('date_range')
                                                <div class="row"
                                                    x-data="{
                                                        from: $wire.otherFilters[{{$key}}].value?.from || '',
                                                        to: $wire.otherFilters[{{$key}}].value?.to || '',
                                                        updateValues() {
                                                            $wire.set('otherFilters.{{$key}}.value.from', this.from);
                                                            $wire.set('otherFilters.{{$key}}.value.to', this.to);
                                                        }
                                                    }"
                                                >
                                                    <div class="col-md-6">
                                                        <input type="date"
                                                               x-model="from"
                                                               @input="updateValues"
                                                               class="form-control form-control-sm"
                                                               placeholder="From"
                                                        />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="date"
                                                               x-model="to"
                                                               @input="updateValues"
                                                               class="form-control form-control-sm"
                                                               placeholder="To"
                                                        />
                                                    </div>
                                                </div>
                                                @break
                                            @case('range')
                                                <div class="row"
                                                    x-data="{
                                                        from: $wire.otherFilters[{{$key}}].value?.from || '',
                                                        to: $wire.otherFilters[{{$key}}].value?.to || '',
                                                        updateValues() {
                                                            $wire.set('otherFilters.{{$key}}.value.from', this.from);
                                                            $wire.set('otherFilters.{{$key}}.value.to', this.to);
                                                        }
                                                    }"
                                                >
                                                    <div class="col-md-6">
                                                        <input type="number"
                                                               step="any"
                                                               x-model="from"
                                                               @input="updateValues"
                                                               class="form-control form-control-sm"
                                                               placeholder="From"
                                                        />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number"
                                                               step="any"
                                                               x-model="to"
                                                               @input="updateValues"
                                                               class="form-control form-control-sm"
                                                               placeholder="To"
                                                        />
                                                    </div>
                                                </div>
                                                @break
                                            @case('select')
                                                <x-admin.filters.multi-option-select wire:model="otherFilters.{{ $key }}.value"
                                                                                    :options="FilterHelper::getClaimsData($adminUser,$item['type'])"
                                                />
                                                @break
                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute" style="top: -20px;right: -20px">
                                <button type="button"
                                        class="btn btn-circle btn-sm btn-light-danger btn-icon" style="padding: 0!important;"
                                        wire:click.prevent="destroyFilerItem({{ $key }})"
                                        wire:loading.attr="disabled"
                                >
                                    <i class="fa fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="card border border-dashed rounded mb-3">
                            <div class="card-body text-center">
                                No filters
                            </div>
                        </div>
                    @endforelse
                    <div class="text-end">
                        <x-admin.theme.button label="Add"
                                              icon="fa fa-plus"
                                              color="success"
                                              spinner="addNewFilter"
                                              wire:click.prevent="addNewFilter"
                                              wire:loading.attr="disabled"
                        />
                    </div>
                </div>
                <!--end::Card body-->
                <div class="card-footer">
                    <!--begin::Dismiss button-->
                    <button class="btn btn-primary"
                            type="button"
                            wire:click.prevent="applyFilter"
                            wire:loading.attr="disabled"
                    >
                        Apply Filter
                    </button>
                    <!--end::Dismiss button-->
                    <!--begin::Dismiss button-->
                    <button class="btn btn-light-dark"
                            type="button"
                            wire:click.prevent="resetFilter"
                            wire:loading.attr="disabled"
                    >
                        Reset Filter
                    </button>
                    <!--end::Dismiss button-->
                </div>
            </div>
        </div>
        <!--end::Drawer-->
    </div>
</div>

