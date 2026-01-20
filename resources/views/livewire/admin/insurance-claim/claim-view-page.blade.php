@section('title','Claim | Information')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Claim Information'),
            'menu'=>[ ['name'=>trans('Clients')],['name'=>trans('Information'),'active'=>true] ],
             ])
        !!}
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row">
                <div class="col-md-12 mb-10">
                    <div class="card"
                         x-data="{
                            show:false,
                            toggleShow:function(){
                               this.show = !this.show;
                            }
                         }"
                         x-cloak
                    >
                        <div class="card-header">
                            <div class="card-title">
                                <h3>
                                     {{ $insuranceClaim->code() }} <br>
                                    <span class="small">{{ $insuranceClaim->patent_name ??($insuranceClaim->ins_name ??'') }}</span>
                                </h3>
                            </div>
                            <div class="card-toolbar gap-3">
                                <button class="btn btn-icon btn-sm btn-light-primary"
                                        type="button"
                                        @click="toggleShow"
                                >
                                    <i class="fa" x-bind:class="show?'fa-angle-up':'fa-angle-down'"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" x-show="show">
                            <div class="row ">
                                <div class="col-md-12">
                                    <x-input.text type="text"
                                                  label="Client Name"
                                                  value="{{ $insuranceClaim->customer->fullName() }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="INS Name"
                                                  value="{{ $insuranceClaim->ins_name ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="INS Phone"
                                                  value="{{ $insuranceClaim->ins_phone ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="SUB ID"
                                                  value="{{ $insuranceClaim->sub_id ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="SUB Name"
                                                  value="{{ $insuranceClaim->sub_name ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Patient ID"
                                                  value="{{ $insuranceClaim->patent_id ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Patient Name"
                                                  value="{{ $insuranceClaim->patent_name ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="DOB"
                                                  value="{{ display_date_format($insuranceClaim->dob ??'') ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="DOS"
                                                  value="{{ display_date_format($insuranceClaim->dos ??'') ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="SENT"
                                                  value="{{ display_date_format($insuranceClaim->sent ??'') ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Total"
                                                  value="{{ currency($insuranceClaim->total ??0) }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="No of Days"
                                                  value="{{ $insuranceClaim->days ??''  }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Days - R"
                                                  value="{{ $insuranceClaim->days_r ??''  }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Prov-Name"
                                                  value="{{ $insuranceClaim->prov_nm ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Location"
                                                  value="{{ $insuranceClaim->location ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-4">
                                    <x-input.text type="text"
                                                  label="Claim Status"
                                                  value="{{ $insuranceClaim->claim_status?->name ??'' }}"
                                                  readonly
                                    />
                                </div>

                                <div class="col-md-12">
                                    <x-input.text type="text"
                                                  label="Status Description"
                                                  value="{{ $insuranceClaim->status_description ??'' }}"
                                                  readonly
                                    />
                                </div>

                                @foreach($insuranceClaim->answers as $item)
                                    <div class="col-md-12">
                                        <x-input.text-area label="{{ $item->question ??'' }}"
                                                           value="{{ $item->answer ??'' }}"
                                                           readonly
                                        />
                                    </div>
                                @endforeach
                                <div class="col-md-12">
                                    <x-input.text-area label="Additional Notes"
                                                       value="{{ $insuranceClaim->note ??'' }}"
                                                       readonly
                                    />
                                </div>
                                <div class="col-md-12">
                                    <x-input.text label="Claim Action"
                                                  value="{{ $insuranceClaim->claim_action ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text label="Claim on File"
                                                  value="{{ $insuranceClaim->cof ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text label="Next/Followup Date"
                                                  value="{{ display_date_format($insuranceClaim->nxt_flup_dt ??'') }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text label="EOB Downloaded"
                                                  value="{{ $insuranceClaim->eob_dl ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text label="Team Worked"
                                                  value="{{ $insuranceClaim->teamModal?->name ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text label="Worked By"
                                                  value="{{ $insuranceClaim->worked_by ??'' }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <x-input.text label="Worked Date"
                                                  value="{{ display_date_format($insuranceClaim->worked_dt ??null) }}"
                                                  readonly
                                    />
                                </div>
                                <div class="col-md-12">
                                    <x-input.text label="Follow-Up Status"
                                                  value="{{ $insuranceClaim->followUpModal?->name ??'' }}"
                                                  readonly
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <livewire:admin.components.merge-history-timeline :claim_id="$insuranceClaim->id" />
        </div>
    </div>
</div>
