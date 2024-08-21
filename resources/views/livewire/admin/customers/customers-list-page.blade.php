@section('title','Clients | List')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Clients Table'),
            'menu'=>[ ['name'=>trans('Clients')],['name'=>trans('List'),'active'=>true] ],
             ])
        !!}
    </div>
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
                            @can('client::add')
                            <div>
                                <a href="{{ route('admin::customers:add') }}"
                                   wire:navigate
                                   class="btn btn-sm btn-primary"
                                >
                                    Create
                                </a>
                            </div>
                            @endcan
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
                                <x-admin.claims.table-header-element
                                    class="min-w-75px"
                                    element="id"
                                    label="ID"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                <x-admin.claims.table-header-element
                                    class="min-w-125px"
                                    element="first_name"
                                    label="Doctor's Name"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                <x-admin.claims.table-header-element
                                    class="min-w-125px"
                                    element="last_name"
                                    label="Dental Office Name"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                <x-admin.claims.table-header-element
                                    class="min-w-125px"
                                    element="email"
                                    label="Email"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                <th class="min-w-120px">
                                    Last Merge Date
                                </th>
                                <x-admin.claims.table-header-element
                                    class="min-w-125px"
                                    element="status"
                                    label="Status"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />

                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>
                                        @can('client::view')
                                            <a href="{{ route('admin::customers:view',['customer_id'=>$item->id]) }}">
                                                {{$item->id ??''}}
                                            </a>
                                        @else
                                            {{$item->id ??''}}
                                        @endcan
                                    </td>
                                    <td>
                                        @can('client::view')
                                            <a href="{{ route('admin::customers:view',['customer_id'=>$item->id]) }}">
                                                {{$item->fullName() ??''}}
                                            </a>
                                        @else
                                            {{$item->fullName() ??''}}
                                        @endcan
                                    </td>
                                    <td>{{$item->last_name ??''}}</td>
                                    <td>{{$item->email ??''}}</td>
                                    <td>
                                        {{ $item->getLastMergeDate('d/m/Y') ??'--' }}
                                    </td>
                                    <td>
                                        @if($item->status) <span class="badge badge-primary">Active</span> @else <span class="badge badge-danger">Inactive</span> @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-4">
{{--                                            <button class="btn btn-danger" wire:click.prevent="deleteCustomerClaims({{ $item->id }})">--}}
{{--                                                DeleteClaims--}}
{{--                                            </button>--}}
                                            @can('claim::export')
                                                <button type="button"
                                                        class="btn btn-sm btn-info"
                                                        wire:click.prevent="exportClaims({{ $item->id }})"
                                                >
                                                    <span wire:loading wire:target="exportClaims({{ $item->id }})"><span class="spinner-border spinner-border-sm me-2"></span></span>Export
                                                </button>
                                            @endcan
                                            @can('client::view')
                                            <a class="btn btn-icon btn-sm btn-dark"
                                               href="{{ route('admin::customers:view',['customer_id'=>$item->id]) }}"
                                               wire:navigate
                                               data-bs-toggle="tooltip"
                                               data-bs-original-title="View"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @endcan
                                            @can('client::update')
                                            <a class="btn btn-icon btn-sm btn-primary"
                                               href="{{ route('admin::customers:edit',['customer_id'=>$item->id]) }}"
                                               wire:navigate
                                               data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @endcan
                                            @can('client::delete')
                                            <a class="btn btn-icon btn-sm btn-danger"
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
                                            @endcan
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
                    <div class="d-flex justify-content-between">
                        <div>
                            <select wire:model.live="filter.perPage"
                                    class="form-select form-select-sm bg-transparent"
                            >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            {{$data->links() ??''}}
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>

    @include('admin.modals.export_modal')

</div>


