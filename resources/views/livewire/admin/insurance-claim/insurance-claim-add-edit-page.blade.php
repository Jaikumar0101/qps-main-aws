<div>
    {!! AdminBreadCrumb::Load(['title'=>(checkData($claim_id)?'Edit':'New')." Insurance Claim",'menu'=>[ ['name'=>trans('Claim'),'url'=>route('admin::insurance-claim:list')],['name'=>checkData($claim_id)?trans('Edit'):trans('Add'),'active'=>true] ],'actions'=>[ ['name'=>'Back To List','url'=>$backUrl] ] ]) !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form wire:submit.prevent="{{ checkData($claim_id)?'Save':'Submit' }}">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Select Customer</label>
                            <x-forms.select2 wire:model.live="request.customer_id" disabled>
                                <option value="">Select Option</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $customer->id == $request['customer_id']?'selected':'' }}> {{ $customer->id }} - {{ $customer->last_name ??'' }}</option>
                                @endforeach
                            </x-forms.select2>
                        </div>
                        <div class="row">
                              <div class="col-md-4">
                                  <x-input.text wire:model="request.ins_name"
                                                label="INS Name"
                                                :disabled="true"
                                  />
                              </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.ins_phone"
                                              label="INS Phone"
                                                :disabled="true"
                                />
                            </div>

                            <div class="col-md-4">
                                <x-input.text wire:model="request.sub_id"
                                              label="SUB ID"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.sub_name"
                                              label="SUB Name"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.patent_id"
                                              label="Patent ID"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.patent_name"
                                              label="Patent Name"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-forms.date-picker wire:model="request.dob"
                                                     data-label="DOB"
                                                     data-format="YYYY-MM-DD"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-forms.date-picker wire:model="request.dos"
                                                     data-label="DOS"
                                                     data-format="YYYY-MM-DD"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-forms.date-picker wire:model="request.sent"
                                                     data-label="Sent"
                                                     data-format="YYYY-MM-DD"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.total"
                                              label="Total"
                                              type="number"
                                              step="any"
                                              min="0"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.days"
                                              label="Days"
                                              type="number"
                                              min="0"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.days_r"
                                              label="Days-R"
                                              type="number"
                                              min="0"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.prov_nm"
                                              label="Prov Nm"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.location"
                                              label="Location"
                                                :disabled="true"
                                />
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Claim Status</label>
                                    <x-forms.select2 wire:model.live="request.claim_status">
                                        <option value="">Select Option</option>
                                        @foreach(\App\Models\InsuranceClaimStatus::where('status',1)->get() as $status)
                                            <option value="{{ $status->id }}" {{ $status->id == $request['claim_status']?'selected':'' }}> {{ $status->name ??'' }}</option>
                                        @endforeach
                                    </x-forms.select2>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <x-input.text wire:model="request.status_description"
                                              label="Status Description"
                                              readonly
                                              :disabled="true"
                                />
                            </div>
                            <div class="col-md-12">
                                @foreach($questionAnswers as $i=>$item)
                                    <x-input.text-area wire:model="questionAnswers.{{$i}}.answer"
                                                       label="{{ $item['question']  ??'' }}"
                                    />
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <x-input.text-area wire:model="request.note"
                                                   label="Enter Additional Notes Here"
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.text wire:model="request.claim_action"
                                              label="Claim Action"
                                              readonly
                                              :disabled="true"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-input.select wire:model="request.cof"
                                                label="COF"
                                >
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </x-input.select>
                            </div>
                            <div class="col-md-6">
                                <x-forms.date-picker wire:model="request.nxt_flup_dt"
                                                     data-label="NXT FLUP DT"
                                                     data-format="YYYY-MM-DD"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-input.select wire:model="request.eob_dl"
                                                label="EOB DL"
                                >
                                    <option value="">Select Option</option>
                                    @foreach(\App\Models\InsuranceEobDl::where('status',1)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                            <div class="col-md-6">
                                <x-input.select wire:model="request.team_worked"
                                                label="Team Worked"
                                >
                                    <option value="">Select Option</option>
                                    @foreach(\App\Models\InsuranceWorkedBy::where('status',1)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                            <div class="col-md-6">
                                <x-input.text wire:model="request.worked_by"
                                              label="Worked By"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.date-picker wire:model="request.worked_dt"
                                                     data-label="Work DT"
                                                     data-format="YYYY-MM-DD"
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.select wire:model="request.follow_up_status"
                                                label="Follow-Up Status"
                                >
                                    <option value="">Select Option</option>
                                    @foreach(\App\Models\InsuranceFollowUp::where('status',1)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer position-sticky bottom-0 bg-white">
                        <div class="text-center">
                            {!! AdminTheme::Spinner(['target'=>(checkData($claim_id)?'Save':'Submit'),'label'=>'Save Claim','bg'=>'success']) !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
