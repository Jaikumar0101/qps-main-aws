@section('title','Blog | Posts')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Blog Posts'),
            'menu'=>[ ['name'=>trans('Blog')],['name'=>trans('Posts'),'active'=>true] ]
             ])
        !!}
    </div>
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
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
                    <a href="{{ route('admin::blog:posts.add') }}" wire:navigate class="btn btn-primary me-2">
                        <i class="fa fa-plus me-2"></i> Add New Post
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
                                        <option value="title">Title</option>
                                        <option value="post_date">Post Date</option>
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
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body table-responsive-md">
            <!--begin::Table-->
            <table class="table table-striped table-bordered">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr>
                    <th class="min-w-125px">ID</th>
                    <th class="min-w-125px">Title</th>
                    <th class="min-w-125px">Category</th>
                    <th class="min-w-125px">Read Time</th>
                    <th class="min-w-125px">Date</th>
                    <th class="min-w-125px">Last Modified</th>
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
                        <td>{{$item->title ??''}}</td>
                        <td>
                            @foreach($item->categories as $category)
                                <span class="badge bg-label-dark">{{$category->name ??''}}</span>
                            @endforeach
                        </td>
                        <td>
                            {{ $item->time_to_read ??'' }}
                        </td>
                        <td>
                            {{ $item->displayPostDate('d M, Y') }}
                        </td>
                        <td>
                            {{ BackendHelper::getTime('d M, Y @ g:i A',$item->updated_at) }}
                        </td>
                        <td>
                            @if($item->status) <span class="badge bg-primary">Active</span> @else <span class="badge bg-danger">Inactive</span> @endif
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
                                           href="{{ route('admin::blog:posts.edit',['post_id'=>$item->id]) }}"
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


