@section('title','Contact | Mails')
<div>
    {!!
        AdminBreadCrumb::Load([
        'title'=>trans('Support'),
        'menu'=>[ ['name'=>trans('Support'),'active'=>true] ]
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
                            <div class="min-w-100px">
                                <x-forms.select2 wire:model.live="status" class="form-select-sm">
                                    <option value="">All </option>
                                    <option value="0">Unseen</option>
                                    <option value="1">Seen</option>
                                </x-forms.select2>
                            </div>
                            <div>
                                <button type="button"
                                        class="btn btn-sm btn-primary"
                                        wire:click.prevent="exportData"
                                >
                                    <span wire:loading wire:target="exportData"><span class="spinner-border spinner-border-sm me-2"></span></span>Export
                                </button>
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
                                                        <option value="email">Email</option>
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
                            <div class="">
                                <button type="button"
                                        class="btn btn-sm btn-success"
                                        wire:click.prevent="OpenAddEditModal"
                                        wire:loading.attr="disabled"
                                >
                                    + Create
                                </button>
                            </div>
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
                            <th class="min-w-125px">Email</th>
                            <th class="min-w-125px">Subject</th>
                            <th class="min-w-125px">Message</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-125px">Actions</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody >
                        @forelse($data as $item)
                            <tr>
                                <td>{{$item->id ??''}}</td>
                                <td>{{$item->fullName() ??''}}</td>
                                <td>{{$item->email ??''}}</td>
                                <td class="small text-wrap">{{$item->subject ??''}}</td>
                                <td class="small text-wrap">
                                    {{Str::limit($item->message,110) ??''}}
                                </td>
                                <td>
                                    @if($item->status) <span class="badge badge-primary">Seen</span> @else <span class="badge badge-danger">Unseen</span> @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-4">
                                        <a class="btn btn-sm btn-icon btn-light-primary"
                                           wire:click.prevent="OpenAddEditModal({{$item->id}})"
                                           wire:dirty.attr="disabled"
                                           wire:target="OpenAddEditModal({{$item->id}})"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="btn btn-sm btn-icon btn-light-danger"
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
        <div class="modal-dialog modal-lg">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="exampleModalLabel1">{{Arr::has($request,'id')?'':'New'}} Support Message</h5>
                        <p class="small">Here you can edit the details of support</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin:Form-->
                    <form class="form" wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <!--begin::Input group-->
                                <!--begin::Label-->
                                <label class="form-label">
                                    First Name
                                </label>
                                <!--end::Label-->
                                <input type="text"
                                       wire:model="request.first_name"
                                       maxlength="255"
                                       class="form-control @error('request.first_name') is-invalid @enderror"
                                      {{Arr::has($request,'id')?'':'readonly'}}
                                />
                                @error('request.first_name') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-6 mb-3">
                                <!--begin::Label-->
                                <label class="form-label">
                                    Last Name
                                </label>
                                <!--end::Label-->
                                <input type="text"
                                       wire:model="request.last_name"
                                       maxlength="255"
                                       class="form-control @error('request.last_name') is-invalid @enderror"
                                      {{Arr::has($request,'id')?'':'readonly'}}
                                />
                                @error('request.last_name') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <div class="mb-3">
                            <!--begin::Label-->
                            <label class="form-label">
                                Email
                            </label>
                            <!--end::Label-->
                            <input type="text"
                                   wire:model="request.email"
                                   maxlength="255"
                                   class="form-control @error('request.email') is-invalid @enderror"
                                {{Arr::has($request,'id')?'':'readonly'}}
                            />
                            @error('request.email') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-3">
                            <!--begin::Label-->
                            <label class="form-label">
                                Phone
                            </label>
                            <!--end::Label-->
                            <input type="text"
                                   wire:model="request.phone"
                                   maxlength="255"
                                   class="form-control @error('request.phone') is-invalid @enderror"
                                {{Arr::has($request,'id')?'':'readonly'}}
                            />
                            @error('request.phone') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-3">
                            <!--begin::Label-->
                            <label class="form-label">
                                Subject
                            </label>
                            <!--end::Label-->
                            <textarea wire:model="request.subject"
                                   class="form-control @error('request.subject') is-invalid @enderror"
                            ></textarea>
                            @error('request.subject') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-3">
                            <!--begin::Label-->
                            <label class="form-label">
                                Subject
                            </label>
                            <!--end::Label-->
                            <textarea wire:model="request.message"
                                    class="form-control @error('request.message') is-invalid @enderror"
                                      rows="6"
                            ></textarea>
                            @error('request.message') <div class="invalid-feedback">{{$message ??''}}</div> @enderror
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center mt-2">
                            <button type="reset" class="btn btn-light-dark me-3" data-bs-dismiss="modal">Close</button>
                            @if(Arr::has($request,'status') && $request['status'] == 0)
                                <button type="button" class="btn btn-primary" wire:click.prevent="MarkSeen" wire:loading.attr="disabled">
                                    <span class="indicator-label" wire:loading.remove wire:target="MarkSeen"> Mark As Seen</span>
                                        <span class="indicator-progress" wire:loading wire:target="MarkSeen">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            @endif

                            <button type="submit"  class="btn btn-primary">
                                <span class="indicator-label" wire:loading.remove wire:target="save">Submit</span>
                                <span class="indicator-progress" wire:loading wire:target="save">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
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
