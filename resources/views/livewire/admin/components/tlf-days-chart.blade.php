<div>

    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <!--begin::Charts Widget 3-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Insurance Vs TFL Days Chart</span>
                        <span class="text-muted fw-semibold fs-7">Showing the insurance claims status</span>
                    </h3>
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <div class="ms-2">
                            <button class="btn btn-sm btn-primary"
                                    wire:click.prevent="Export"
                                    wire:loading.attr="disabled"
                            >
                                        <span wire:loading  wire:target="Export">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>
                                <span wire:loading.remove wire:target="Export">Export</span>
                            </button>
                        </div>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body p-3">
                    <table class="table table-bordered gs-7 gx-5">
                        <tr>
                            <th>Insurance Claim</th>
                            <th>TLF Days</th>
                        </tr>
                        @forelse($data as $item)
                            <tr>
                                <td>
                                    {{ $item->ins_name ??'' }}
                                </td>
                                <td>
                                    {{ $item->days ??'0' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No data available</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Charts Widget 3-->
        </div>
    </div>
    <!--end::Row-->

    <div class="modal fade modal-close-out" id="exportDataModalTLF" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabelCloseOut" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelCloseOut">Export Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @isset($exportFiles)
                        <p class="text-small">
                            <b>Note:</b> After Downloading File will remove automatically
                        </p>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Download</th>
                            </thead>
                            <tbody>
                            @forelse ($exportFiles as $i=>$item)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$item['name']}}</td>
                                    <td>
                                        @if ($item['removed'])
                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-danger">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" wire:click.prevent="DownloadFile('{{$i}}')" class="btn btn-sm btn-icon btn-dark">
                                                <div wire:loading wire:target="DownloadFile('{{$i}}')"><i class="fa fa-spin fa-spinner"></i></div>
                                                <div wire:loading.remove wire:target="DownloadFile('{{$i}}')"><i class="fa fa-download"></i></div>
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" align="center">No files exported</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    @endisset
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
    window.addEventListener('OpenExportModalTLF',()=>{ $("#exportDataModalTLF").modal('show'); })
</script>
@endscript


