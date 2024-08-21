@section('title','EOB DL')
<div>
    {!!
          AdminBreadCrumb::Load([
          'title'=>trans('EOB DL Table'),
          'menu'=>[ ['name'=>trans('EOB DL'),'url'=>'#'],['name'=>trans('List'),'active'=>true] ]
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
                        <table class="table gs-7 gy-7 gx-7">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <th class="min-w-125px">ID</th>
                                <th class="min-w-125px">Name</th>
                                <th class="min-w-125px">Status</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{$item->id ??''}}</td>
                                    <td>{{$item->name ??''}}</td>
                                    <td>
                                        <label class="form-check form-check-custom form-check-solid form-switch form-switch-sm ">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{$item->status?'checked':''}}
                                                   onchange="@this.updateStatus('{{$item->id}}',this.checked)"
                                            >
                                        </label>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-4">
                                            <a class="btn btn-icon btn-sm btn-light-primary"
                                               wire:click.prevent="OpenAddEditModal({{$item->id}})"
                                               wire:dirty.attr="disabled"
                                               wire:target="OpenAddEditModal({{$item->id}})"
                                               data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a class="btn btn-icon btn-sm btn-light-danger"
                                               href="javascript:void(0);"
                                               data-bs-toggle="tooltip"
                                               data-bs-original-title="Delete"
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
                                            >
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
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
    <div class="modal fade" id="addEditModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" wire:ignore.self>
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-3">
                    <div>
                        <h5 class="modal-title" id="exampleModalLabel1">{{Arr::has($request,'id')?'Edit':'New'}} EOB DL</h5>
                        <p class="small">Here you can edit the details of eob dl</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--begin::Modal header-->
                <!--begin:Form-->
                <form class="form" wire:submit.prevent="save">
                    <!--begin::Modal body-->
                    <div class="modal-body">
                        <x-input.text wire:model="request.name"
                                      label="Name"
                        />
                        <x-input.text wire:model="request.position"
                                      label="Position"
                                      type="number"
                                      min="0"
                                      max="5000"
                        />
                        <x-input.select wire:model="request.status"
                                        label="Status"
                        >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-input.select>
                    </div>
                    <!--end::Modal body-->
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-primary me-3">
                            <span class="indicator-label" wire:loading.remove wire:target="save">Submit</span>
                            <span class="indicator-progress" wire:loading wire:target="save">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                        </button>
                        <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
                <!--end:Form-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Target-->

</div>

@script
<script>
    window.addEventListener('OpenAddEditModal',()=>{ $("#addEditModal").modal('show'); })
</script>
@endscript

