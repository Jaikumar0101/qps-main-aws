@section('title','Administrator | Roles')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
                'title'=>trans('Admin Roles'),
                'menu'=>[ ['name'=>trans('Team')],['name'=>trans('Roles'),'active'=>true] ],
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
                            <div>
                                <a href="javascript:void(0)"
                                   class="btn btn-sm btn-primary"
                                   wire:click.prevent="openAddEditModal"
                                   wire:loading.attr="disabled"
                                >
                                    Create
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table gs-7 gy-7 gx-7 ">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200 ">
                                <th class="min-w-125px">ID</th>
                                <th class="min-w-125px">Name</th>
                                <th class="min-w-125px">Description</th>
                                <th class="min-w-125px">Client</th>
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
                                    <td>
                                        {{ $item->name ??'' }}
                                    </td>
                                    <td>
                                        {{ Str::limit($item->description ??'',65) }}
                                    </td>
                                    <td>
                                        @if($item->status) <span class="badge badge-primary">Yes</span> @else <span class="badge badge-dark">No</span> @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-4">
                                            <a class="btn btn-icon btn-sm btn-light-primary"
                                               wire:click.prevent="openAddEditModal({{ $item->id }})"
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

    <div class="modal fade modal-close-out"
         id="addEditModal"
         tabindex="-1"
         data-bs-backdrop="static"
         wire:ignore.self
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ Arr::has($request,'id')?'Edit':"New" }} Role Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="Submit">

                    <div class="modal-body">
                        <x-input.text wire:model="request.name"
                                      label="Name"
                        />
                        <x-input.text-area wire:model="request.description"
                                           label="Description"
                        />
                        <div class="form-group mb-5">
                            <label class="col-form-label">Roles</label>
                            <x-forms.select2 wire:model="request.roles" multiple class="form-control">
                                @foreach(\App\Helpers\Role\RoleHelper::getRoles() as $key=>$role)
                                    <option value="{{ $key }}">{{ $role['name'] ??'' }}</option>
                                @endforeach
                            </x-forms.select2>
                        </div>
                        <x-input.select wire:model="request.status"
                                        label="Role is for client"
                        >
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-input.select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-primary"
                        >
                            <span wire:loading wire:target="Submit" class="spinner-border spinner-border-sm me-2"></span>Save
                        </button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@script
<script>
    window.addEventListener('OpenAddEditModal',()=>{
        $('#addEditModal').modal('show');
    })
</script>
@endscript
