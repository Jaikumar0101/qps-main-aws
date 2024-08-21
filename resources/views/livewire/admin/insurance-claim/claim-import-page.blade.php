@section('title','Leads | Import')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Import Leads'),
            'menu'=>[ ['name'=>trans('Leads')],['name'=>trans('Import'),'active'=>true] ],
            'full-width'=>true
             ])
        !!}
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Uploaded Excel Files</span>
                                <span class="text-muted fw-bold fs-7">Showing the recent files uploads</span>
                            </h3>
                            <div class="card-toolbar gap-3">
                                <a href="{{ asset('uploads/sample/sample-file.xlsx') }}" class="btn btn-primary btn-sm">
                                   <i class="fa fa-file-excel me-1"></i> Sample File
                                </a>
                                <button class="btn btn-success btn-sm"
                                        wire:click.prevent="OpenAddEditModal"
                                >
                                   <i class="fa fa-upload me-1"></i>Upload
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-2">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th>Name</th>
                                        @if(!$staff)
                                            <th class="min-w-150px">Uploaded By</th>
                                        @endif
                                        <th>Client</th>
                                        <th>Status</th>
                                        <th>Upload Time</th>
                                        <th class="min-w-150px text-end">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($data as $item)
                                        <tr>
                                            <td>{{ $item->name ??'' }}</td>
                                            @if(!$staff)
                                                <td>
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="{{ $item->user->avatarUrl() }}" height="45" width="45" class="rounded-circle" />
                                                        </div>
                                                        <div>
                                                            <b>{{ $item->user?->fullName() ??'' }}</b><br>
                                                            <span class="text-gray-800">{{ $item->user->email ??'' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                {{ $item->client?->last_name ??'--' }}
                                            </td>
                                            <td>
                                                @if($item->status)
                                                    <span class="badge badge-primary">Imported</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->getUploadedTime('d M, Y - H:i') }}</td>
                                            <td class="text-end">
                                                @if($item->status)
                                                    <button class="btn btn-info btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-title="View Logs"
                                                            wire:click.prevent="OpenImportModal({{ $item->id }})"
                                                            wire:offline.attr="disabled"
                                                    >
                                                       View Logs
                                                    </button>
                                                @else
                                                    <button class="btn btn-dark btn-sm"
                                                            wire:click.prevent="ImportLead({{ $item->id }})"
                                                            wire:loading.attr="disabled"
                                                    >
                                                        <span wire:loading.remove wire:target="ImportLead({{ $item->id }})">Import File</span>
                                                        <span wire:loading wire:target="ImportLead({{ $item->id }})"><span class="spinner-border spinner-border-sm me-2"></span>Importing</span>
                                                    </button>
                                                @endif

                                                @if(!$staff)
                                                    <a href="{{ asset($item->file ??'') }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-icon btn-success"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-title="Download"
                                                    >
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <button class="btn btn-icon btn-danger btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-title="Delete"
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
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade modal-close-out" id="addEditModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabelCloseOut" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelCloseOut">Import Excel Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="SaveImportHistory">
                    <div class="modal-body">
                        <x-input.text wire:model.defer="request.name"
                                      label="Name*"
                        />
                        <div class="form-group mb-5">
                            <label class="col-form-label">Select Client</label>
                            <x-forms.select2 wire:model="request.client_id">
                                <option value="">Select option</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id ??'' }}">{{ $client->last_name ??'' }}</option>
                                @endforeach
                            </x-forms.select2>
                        </div>
                        <div class="form-group mb-5">
                            <label class="col-form-label">Excel File*</label>
                            <x-forms.filepond folder="doc/"
                                              wire:model="request.file"
                                              accept="{{ implode(',',[
                                                     'application/vnd.ms-excel',
                                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                    'text/csv'
                                                ]) }}"
                                              allowFileTypeValidation
                            />
                            @error('request.file') <div class="p-1 text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <x-input.text-area wire:model.defer="request.note"
                                           label="Note"
                                           rows="3"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <div wire:loading.remove wire:target="SaveImportHistory">Save</div>
                            <div wire:loading wire:target="SaveImportHistory">
                                <div class="spinner-border spinner-border-sm"></div>
                            </div>
                        </button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-close-out" id="ImportErrorsModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Import Excel Errors</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 450px;overflow-y: scroll">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-4 gy-4 border">
                        <tr class="fw-bolder text-muted">
                            <th class="min-w-50px">Row</th>
                            <th class="min-w-200px">Contact Name</th>
                            <th class="min-w-200px">Error</th>
                        </tr>
                        @forelse($importErrors as $item)
                            <tr>
                                <td>{{ $item['row'] ??'' }}</td>
                                <td class="fs-7">
                                    {{ $item['name'] ??'' }}
                                </td>
                                <td class="fs-7">
                                    <div class="overflow-y-scroll">
                                        <div>
                                            @foreach($item['errors'] as $errorItem)
                                                @if(gettype($errorItem) == "array")
                                                    @foreach($errorItem as $subItem)
                                                        <span>- {{ $subItem ??'' }}</span><br>
                                                    @endforeach
                                                @else
                                                    <span>- {{ $errorItem ??'' }}</span><br>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No errors</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@script
    <script>
        window.addEventListener('OpenAddEditModal',()=>{ $("#addEditModal").modal('show'); })
        window.addEventListener('OpenImportModal',()=>{ $("#ImportErrorsModal").modal('show'); })
    </script>
@endscript
