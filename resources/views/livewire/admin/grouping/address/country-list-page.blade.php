@section('title','Grouping | Countries')
<div>
    {!!
          AdminBreadCrumb::Load([
          'title'=>trans('Country Table'),
          'menu'=>[ ['name'=>trans('Grouping')],['name'=>trans('Address')],['name'=>trans('Counties'),'active'=>true] ]
           ])
      !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <div class="d-flex">
                            <!--begin::Search-->
                            <div class="position-relative">
                                <input type="text" wire:model.live="search"
                                       class="form-control"
                                       placeholder="Search"
                                />
                                <div class="position-absolute {{ checkData($search)?'':'d-none' }}" style="top: 50%;right:10px;transform: translateY(-50%)">
                                    <a class="cursor-pointer" onclick="@this.set('search',null)">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <!--end::Search-->
                            <span class="small ms-2 pt-4" wire:loading wire:target="search">Searching...</span>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <div>
                                <button type="button"
                                        class="btn btn-sm btn-light-primary"
                                        wire:click.prevent="exportData"
                                >
                                    <span wire:loading wire:target="exportData"><span class="spinner-border spinner-border-sm me-2"></span></span>Export
                                </button>
                            </div>
                            <div>
                                <a href="javascript:void(0)"  wire:dirty.attr="disabled" wire:click.prevent="OpenAddEditModal"
                                   class="btn btn-sm btn-primary"
                                >
                                    Create
                                </a>
                            </div>
                            <!--begin::Filter menu-->
                            <div class="m-0">
                                <!--begin::Menu toggle-->
                                <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Filter</a>
                                <!--end::Menu toggle-->
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" wire:ignore.self>
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Form-->
                                    <form class="p-4" wire:submit.prevent="applyFilter">
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="mb-5">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold fs-8">Sort By:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div>
                                                    <select wire:model="requestFilter.sortBy" class="form-select form-select-sm">
                                                        <option value="id">ID</option>
                                                        <option value="name">Name</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-5">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold fs-8">Order By:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div>
                                                    <select wire:model="requestFilter.orderBy" class="form-select form-select-sm">
                                                        <option value="asc">Asc</option>
                                                        <option value="desc">Desc</option>
                                                    </select>
                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-5">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold fs-8">Page Items:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div>
                                                    <select wire:model="requestFilter.perPage" class="form-select">
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="25">25</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end">
                                                <button type="reset"  wire:click.prevent="resetFilter" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1-->
                            </div>
                            <!--end::Filter menu-->
                        </div>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-bordered table-striped">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">ID</th>
                                <th class="min-w-125px">Name</th>
                                <th class="min-w-125px">Timezone</th>
                                <th class="min-w-125px">Abbreviation</th>
                                <th class="min-w-125px">Status</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="">
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id ??''}}</td>
                                    <td>{{$item->nicename ??''}}</td>
                                    <td>{{$item->timezone ??''}}</td>
                                    <td>{{$item->abbreviations ??''}}</td>
                                    <td>
                                        <label class="form-check form-check-custom form-check-solid form-switch form-switch-sm">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{$item->status?'checked':''}}
                                                   onchange="@this.updateStatus('{{$item->id}}',this.checked)"
                                            >
                                        </label>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                           data-kt-menu-trigger="click"
                                           data-kt-menu-placement="bottom-end"
                                        >Actions
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                             data-kt-menu="true"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a wire:click.prevent="OpenAddEditModal({{$item->id}})"
                                                   wire:dirty.attr="disabled"
                                                   wire:target="OpenAddEditModal({{$item->id}})"
                                                   class="menu-link px-3"
                                                   href="javascript:void(0)"
                                                >
                                                    Edit
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a class="menu-link px-3"
                                                   href="javascript:void(0);"
                                                   x-on:click="
                                                   Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: 'Once deleted, you will not be able to recover this record !',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Yes, delete it!',
                                                        cancelButtonText: 'No',
                                                        customClass: {
                                                          confirmButton: 'btn btn-primary',
                                                          cancelButton: 'btn btn-secondary'
                                                        },
                                                        buttonsStyling: false,
                                                    }).then((event) => {
                                                        if(event.isConfirmed){
                                                          @this.destroy('{{$item->id}}')
                                                        }
                                                    });
                                                   "
                                                >Delete</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        {{$data->links() ??''}}
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>

    @include('admin.modals.export_modal')

    <!--begin::Modal - New Target-->
    <div class="offcanvas offcanvas-end"
         id="offcanvasRight"
         data-bs-keyboard="false"
         data-bs-backdrop="true"
         data-bs-scroll="true"
         aria-labelledby="offcanvasRightLabel"
         wire:ignore.self
    >
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">{{ Arr::has($request,'id')?'Edit':'New' }} Country</h5>
            <div wire:ignore>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <form wire:submit.prevent="save">
            <div class="offcanvas-body">
                <div class="mb-3">
                    <!--begin::Label-->
                    <label class="form-label">
                        <span class="required">Name</span>
                    </label>
                    <!--end::Label-->
                    <input type="text"
                           wire:model="request.name"
                           maxlength="255"
                           class="form-control @error('request.name') is-invalid @enderror"
                    />
                    @error('request.name') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        <span class="required">Nice Name</span>
                    </label>
                    <input type="text"
                           wire:model="request.nicename"
                           maxlength="255"
                           class="form-control @error('request.nicename') is-invalid @enderror"
                    />
                    @error('request.nicename') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">ISO</label>
                    <input type="text"
                           wire:model="request.iso"
                           maxlength="255"
                           class="form-control @error('request.iso') is-invalid @enderror"
                    />
                    @error('request.iso') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Timezone</label>
                    <input type="text"
                           wire:model="request.timezone"
                           maxlength="255"
                           class="form-control @error('request.timezone') is-invalid @enderror"
                    />
                    @error('request.timezone') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Abbreviation</label>
                    <input type="text"
                           wire:model="request.abbreviations"
                           maxlength="255"
                           class="form-control @error('request.abbreviations') is-invalid @enderror"
                    />
                    @error('request.abbreviations') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select @error('request.status') is-invalid @enderror" wire:model="request.status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('request.status') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">
                        <span class="indicator-label" wire:loading.remove wire:target="save">Submit</span>
                        <span class="indicator-progress" wire:loading wire:target="save">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    <!--end::Modal - New Target-->
</div>

@push('scripts')
    <script data-navigate-once>
        window.addEventListener('OpenAddEditModal',()=>{
            let offCanvasRight = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
            offCanvasRight.show();
        })
    </script>
@endpush
