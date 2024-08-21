@section('title','Ads')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Ads List'),
            'menu'=>[ ['name'=>trans('Ads'),'url'=>'#'],['name'=>trans('List'),'active'=>true] ]
             ])
        !!}
    </div>
    <!--begin::Card-->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <!--begin::Card title-->
                <div class="card-action-title">
                    <div class="d-flex">
                        <!--begin::Search-->
                        <div class="position-relative">
                            <input type="text" wire:model.live="search"
                                   class="form-control"
                                   placeholder="Search"
                            />
                            <div class="position-absolute {{ checkData($search)?'':'d-none' }}" style="top: 25%;right:10px">
                                <a class="cursor-pointer" onclick="@this.set('search',null)">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <!--end::Search-->
                        <span class="small ms-2 mt-2" wire:loading wire:target="search">Searching...</span>
                    </div>
                </div>
                <!--begin::Card title-->
                <div class="card-action-element flex">
                    <!--begin::Export-->
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-label-primary dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                         <span wire:loading wire:target="exportData">
                             <span class="spinner-border me-2"></span>
                         </span>
                            <span wire:loading.remove wire:target="exportData">
                             <i class="ti ti-file-export ti-xs me-2"></i>
                         </span>
                            Export
                        </button>
                        <ul class="dropdown-menu" wire:ignore.self>
                            <li>
                                <a href="javascript:void(0);" class="dt-button dropdown-item buttons-csv buttons-html5" wire:click.prevent="exportData">
                                    <i class="ti ti-file-text scaleX-n1-rtl me-1"></i>Csv
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('admin::ads:add') }}"  wire:navigate class="btn btn-primary me-2">
                        <i class="fa fa-plus me-2"></i> Add New
                    </a>
                    <!--end::Add user-->
                    <div class="btn-group ">
                        <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-filter"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end w-px-300" wire:ignore.self>
                            <form class="p-4" wire:submit.prevent="applyFilter">
                                <div class="mb-3">
                                    <label class="form-label">SortBy:</label>
                                    <select wire:model="requestFilter.sortBy" class="form-select">
                                        <option value="id">ID</option>
                                        <option value="name">Name</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">OrderBy:</label>
                                    <select wire:model="requestFilter.orderBy" class="form-select">
                                        <option value="asc">Asc</option>
                                        <option value="desc">Desc</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">PageItems:</label>
                                    <select wire:model="requestFilter.perPage" class="form-select">
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="flex">
                                    <button type="button" wire:click.prevent="resetFilter" class="btn btn-light waves-effect waves-light me-2">Reset</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Card body-->
        <div class="card-body table-responsive-md">
            <!--begin::Table-->
            <table class="table table-bordered table-striped">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr>
                    <th class="min-w-125px">ID</th>
                    <th class="min-w-125px">Key</th>
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
                        <td>{{$item->key ??''}}</td>
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                           wire:navigate
                                           href="{{ route('admin::ads:edit',['ads_id'=>$item->id]) }}"
                                        >
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                           href="javascript:void(0);"
                                           x-on:click="
                                           Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'Once deleted, you will not be able to recover this record !',
                                                icon: 'warning',
                                                confirmButtonText: 'Yes, delete it!',
                                                customClass: {
                                                  confirmButton: 'btn btn-primary me-3',
                                                  cancelButton: 'btn btn-label-secondary'
                                                },
                                                buttonsStyling: false
                                            }).then((event) => {
                                                if(event.isConfirmed){
                                                  @this.destroy('{{$item->id}}')
                                                }
                                            });
                                           "
                                        >Delete</a>
                                    </li>
                                </ul>
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
        <!--end::Card body-->
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                {{$data->links() ??''}}
            </div>
        </div>
    </div>
    <!--end::Card-->
    @include('admin.modals.export_modal')

</div>

