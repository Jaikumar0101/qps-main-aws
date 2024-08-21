<div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3>
                        Merged History<br>
                        <span class="small">Showing the import history when the claim is updated.</span>
                    </h3>
                </div>
            </div>
            <div class="card-body pt-5">
                <!--begin::Timeline-->
                <div class="timeline-label">
                    @forelse($data as $item)
                        <!--begin::Item-->
                        <div class="timeline-item">
                            <!--begin::Label-->
                            <div class="timeline-label fw-bold text-gray-800 fs-6">{{ get_time_by_format($item->created_at,'H:i') }}</div>
                            <!--end::Label-->
                            <!--begin::Badge-->
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-{{ $item->colorType() }} fs-1"></i>
                            </div>
                            <!--end::Badge-->
                            <!--begin::Content-->
                            <div class="timeline-content d-flex gap-3">
                                <a href="javascript:void(0)"
                                   wire:click.prevent="OpenDetailModal({{ $item->id }})"
                                >
                                    @switch($item->type)
                                        @case("old")
                                            <span class="fw-bold text-gray-800 ps-3">Record before merged at {{ get_time_by_format($item->created_at) }}</span>
                                            @break
                                        @case("import")
                                            <span class="fw-bold text-gray-800 ps-3">Excel record for import at {{ get_time_by_format($item->created_at) }}</span>
                                            @break
                                        @default
                                            <span class="fw-bold text-gray-800 ps-3">Record after merged at {{ get_time_by_format($item->created_at) }}</span>
                                    @endswitch
                                </a>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                    @empty
                        <p class="text-center py-4">
                            No history recorded
                        </p>
                    @endforelse
                </div>
                <!--end::Timeline-->
            </div>
            @if($totalCount > $perPage)
                <div class="card-footer">
                    <div class="text-center">
                        <button class="btn btn-primary"
                                wire:click.prevent="loadMore"
                                type="button"
                        >
                            <span wire:loading.remove wire:target="loadMore">Load More</span>
                            <span wire:loading wire:target="loadMore" class="spinner-border spinner-border-sm"></span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade modal-close-out" id="claimDataModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabelCloseOut" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    @if($claimLog)
                        <h5 class="modal-title" id="exampleModalLabelCloseOut">
                            History Detail <br>
                            @switch($claimLog->type)
                                @case("old")
                                    <span class="text-gray-800 fs-8">Record before merged at {{ get_time_by_format($claimLog->created_at) }}</span>
                                    @break
                                @case("import")
                                    <span class="text-gray-800 fs-8">Excel record for import at {{ get_time_by_format($claimLog->created_at) }}</span>
                                    @break
                                @default
                                    <span class="text-gray-800 fs-8">Record after merged at {{ get_time_by_format($claimLog->created_at) }}</span>
                            @endswitch
                        </h5>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($claimLog)
                        <div class="row ">
                            <div class="col-md-12">
                                <x-input.text type="text"
                                              label="Client Name"
                                              value="{{ $claimLog->customer->fullName() }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="INS Name"
                                              value="{{ $claimLog->ins_name ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="INS Phone"
                                              value="{{ $claimLog->ins_phone ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="SUB ID"
                                              value="{{ $claimLog->sub_id ??'' }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="SUB Name"
                                              value="{{ $claimLog->sub_name ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Patient ID"
                                              value="{{ $claimLog->patent_id ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Patient Name"
                                              value="{{ $claimLog->patent_name ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="DOB"
                                              value="{{ get_date_by_format($claimLog->dob ??'') }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="DOS"
                                              value="{{ get_date_by_format($claimLog->dos ??'') }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="SENT"
                                              value="{{ get_date_by_format($claimLog->sent ??'') }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Total"
                                              value="{{ currency($claimLog->total ??0) }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="No of Days"
                                              value="{{ $claimLog->days ??''  }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Days - R"
                                              value="{{ $claimLog->days_r ??''  }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Prov-Name"
                                              value="{{ $claimLog->prov_nm ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Location"
                                              value="{{ $claimLog->location ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text type="text"
                                              label="Claim Status"
                                              value="{{ $claimLog->claim_status?->name ??'' }}"
                                              readonly
                                />
                            </div>

                            <div class="col-md-12">
                                <x-input.text type="text"
                                              label="Status Description"
                                              value="{{ $claimLog->status_description ??'' }}"
                                              readonly
                                />
                            </div>

                            @foreach($claimLog->answers as $item)
                                <div class="col-md-12">
                                    <x-input.text-area label="{{ $item->question ??'' }}"
                                                       value="{{ $item->answer ??'' }}"
                                                       readonly
                                    />
                                </div>
                            @endforeach
                            <div class="col-md-12">
                                <x-input.text-area label="Additional Notes"
                                                   value="{{ $claimLog->note ??'' }}"
                                                   readonly
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.text label="Claim Action"
                                              value="{{ $claimLog->claim_action ??'' }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text label="Claim on File"
                                              value="{{ $claimLog->cof ??'' }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text label="Next/Followup Date"
                                              value="{{ get_date_by_format($claimLog->nxt_flup_dt ??'') }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text label="EOB Downloaded"
                                              value="{{ $claimLog->eob_dl ??'' }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text label="Team Worked"
                                              value="{{ $claimLog->teamModal?->name ??'' }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text label="Worked By"
                                              value="{{ $claimLog->worked_by ??'' }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text label="Worked Date"
                                              value="{{ get_date_by_format($claimLog->worked_dt ??null) }}"
                                              readonly
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.text label="Follow-Up Status"
                                              value="{{ $claimLog->followUpModal?->name ??'' }}"
                                              readonly
                                />
                            </div>
                        </div>
                    @endif
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
    window.addEventListener('OpenDetailModal',()=>{
        $("#claimDataModal").modal('show')
    })
</script>
@endscript
