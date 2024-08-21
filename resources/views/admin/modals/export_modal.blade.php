<div class="modal fade modal-close-out" id="exportDataModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabelCloseOut" style="display: none;" aria-hidden="true" wire:ignore.self>
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

@push('scripts')
    <script data-navigate-once>
        window.addEventListener('OpenExportModal',()=>{ $("#exportDataModal").modal('show'); })
    </script>
@endpush
