<div>
    <x-admin.theme.modal title="Bulk Update"
                         description="Note: Only selected field values will be updated"
                         wire:model="editModal"
    >
        <x-slot:body>
            <table class="table-borderless w-100 gx-5 gy-5 gs-5">
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.claim_status.update"
                            />
                            <label class="form-check-label text-black">Claim Status</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.claim_status.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            @foreach(\App\Models\InsuranceClaimStatus::where('status',1)->get() as $status)
                                <option value="{{ $status->id }}"> {{ $status->name ??'' }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.follow_up_status.update"
                            />
                            <label class="form-check-label text-black">Follow-up Status</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.follow_up_status.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            @foreach(\App\Models\InsuranceFollowUp::where('status',1)->get() as $status)
                                <option value="{{ $status->id }}"> {{ $status->name ??'' }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.eob_dl.update"
                            />
                            <label class="form-check-label text-black">EOB Downloaded</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.eob_dl.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            @foreach(\App\Models\InsuranceFollowUp::where('status',1)->get() as $status)
                                <option value="{{ $status->id }}"> {{ $status->name ??'' }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.team_worked.update"
                            />
                            <label class="form-check-label text-black">Worked By</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.team_worked.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            @foreach(\App\Models\InsuranceWorkedBy::where('status',1)->get() as $item)
                                <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.cof.update"
                            />
                            <label class="form-check-label text-black">COF</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.cof.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.nxt_flup_dt.update"
                            />
                            <label class="form-check-label text-black">Next/Followup Date</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <x-forms.date-picker wire:model="request.nxt_flup_dt.value"
                                             data-format="YYYY-MM-DD"
                                             data-parent-class=""
                                             class="form-control-sm"
                        />
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.worked_dt.update"
                            />
                            <label class="form-check-label text-black">Worked Date</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <x-forms.date-picker wire:model="request.worked_dt.value"
                                             data-format="YYYY-MM-DD"
                                             data-parent-class=""
                                             class="form-control-sm"
                        />
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.method.update"
                            />
                            <label class="form-check-label text-black">Method</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.method.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            @foreach(\App\Models\InsuranceClaim::METHOD_TYPES as $item)
                                <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.pms_note.update"
                            />
                            <label class="form-check-label text-black">PMS Note</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <select wire:model="request.pms_note.value"
                                class="form-select form-select-sm"
                        >
                            <option value="">Select Option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </td>
                </tr>
                <tr class="justify-items-center">
                    <td class="pb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="1"
                                   wire:model="request.note.update"
                            />
                            <label class="form-check-label text-black">Enter Additional Notes Here</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="pb-4">
                        <textarea class="form-control" rows="3" wire:model="request.note.value" ></textarea>
                    </td>
                </tr>
            </table>
        </x-slot:body>
        <x-slot:footer>
            <x-admin.theme.button label="Save"
                                  wire:click.prevent="save"
                                  spinner="save"
                                  color="primary"
            />
            <x-admin.theme.button label="Close"
                                  color="dark"
                                  class="ms-2"
                                  @click="$wire.editModal = false"
            />
        </x-slot:footer>
    </x-admin.theme.modal>
</div>
