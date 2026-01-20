<div>
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <div class="d-flex">
                    <!--begin::Search-->
                    <div class="position-relative">
                        <input type="text" wire:model.live="search"
                               class="form-control form-control-sm"
                               placeholder="Search"
                        />
                        <div class="position-absolute {{ checkData($search)?'':'d-none' }}" style="top: 50%;right:10px;transform: translateY(-50%)">
                            <a class="cursor-pointer" onclick="@this.set('search',null)">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ms-3 me-2">
                        <span class="btn btn-sm bg-light-primary ">{{ $data->total() }} Records</span>
                    </div>
                    <div class="ms-3 me-2">
                        <span class="btn btn-sm bg-light-primary ">{{ currency($totalOfClaims) }}</span>
                    </div>
                    <!--end::Search-->
                    <div>
                                <span class="small ms-2 pt-2" wire:loading>
                                    <span class="spinner-border spinner-border-sm"></span>
                                </span>
                    </div>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    @can('claim::update')
                        <div class="me-3">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="flexSwitchDefault"
                                       onchange="@this.set('editFields',this.checked)"
                                    {{ $editFields?'checked':'' }}
                                />
                                <label class="form-check-label" for="flexSwitchDefault">
                                    Edit Fields
                                </label>
                            </div>
                        </div>
                    @endcan
                    <div>
                        <!--begin::Trigger button-->
                        <button id="kt_drawer_filter_button" class="btn btn-sm btn-flex btn-secondary fw-bold">
                            <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="filter-text">Filter</span>
                        </button>
                        <!--end::Trigger button-->
                    </div>
                </div>
            </div>
        </div>

        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-0"
             x-data="{
                         editable:@entangle('editFields'),
                         currentRow:null,
                         model:@entangle('request'),
                         modelValue:null,
                         showRow:@entangle('isRowOpen'),
                         processing:@entangle('isProcessing'),
                         setModalValue:function(value,row,field){
                            this.modelValue = value;
                            this.currentRow = row;
                            this.editField = field;
                         },
                         saveFiledValue:function(row,field,value){

                         },
                         openRowSection:function(id){
                            this.processing = false;
                            if(this.showRow == id)
                            {
                               this.showRow = null;
                            }
                            else{  @this.openRowSection(id); }
                         },
                         saveModal:function(row){
                            this.processing = true;
                            @this.saveModalValue(row,this.model);
                         },
                         claimStatusUpdated:function(){
                            @this.claimStatusUpdated();
                         }
                     }"
             x-init="
                         window.addEventListener('setModalValue',({detail:{value,row,field}})=>{
                             setModalValue(value,row,field);
                         })
                     "
             x-cloak
        >
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-bordered"
                       x-bind:class="editable?'gx-0 gy-0':'gy-2 gx-3'"
                >
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="fw-semibold fs-8 text-gray-800"
                        x-bind:class="editable?'ins_table_head':''"
                    >
                        <th></th>
{{--                        <x-admin.claims.table-header-element--}}
{{--                            class="min-w-75px"--}}
{{--                            element="id"--}}
{{--                            label="ID"--}}
{{--                            currentOrder="{{ $filter['orderBy'] }}"--}}
{{--                            currentSort="{{ $filter['sortBy'] }}"--}}
{{--                        />--}}
                        <x-admin.claims.table-header-element
                            class=""
                            element="ins_name"
                            label="INS Name"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="ins_phone"
                            label="INS Ph No"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="sub_name"
                            label="SUB NAME"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="sub_id"
                            label="SUB ID"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="patent_id"
                            label="Patient ID"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="patent_name"
                            label="Patient Name"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="dob"
                            label="DOB"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="dos"
                            label="DOS"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <x-admin.claims.table-header-element
                            class=""
                            element="total"
                            label="Total"
                            currentOrder="{{ $filter['orderBy'] }}"
                            currentSort="{{ $filter['sortBy'] }}"
                        />
                        <th class="text-end min-w-50px" colspan="2">Actions</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    @forelse($data as $item)
                        <tr class="{{ in_array($item->follow_up_status,$closedStatus)?'bg-success text-white activeTag':'' }} fs-8 border-bottom border-dashed border-secondary"

                        >
                            <td x-bind:class="editable?'p-0':'ps-2 pe-2'">
                                <div x-bind:class="editable?'p-2':'p-0'">
                                    <a href="javascript:void(0)"
                                       @click="openRowSection('{{ $item->id }}')"
                                       class="fs-8"
                                    >
                                        <i class="fa text-black-50 fs-8 fw-bold"
                                           x-bind:class="showRow == '{{ $item->id }}'?'fa-minus':'fa-plus'"
                                        ></i>
                                    </a>
                                </div>
                            </td>
{{--                            <td class="w-20px text-nowrap">--}}
{{--                                <div x-bind:class="editable?'p-2':''">--}}
{{--                                    <a href="{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}"--}}
{{--                                       class="text-decoration-none text-dark"--}}
{{--                                    >--}}
{{--                                        {{$item->code() ??''}}--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </td>--}}
                            <td>
                                <div x-bind:class="editable?'p-2':''"
                                >
                                    <a :href="editable?'javascript:void(0)':'{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}'"
                                       class="text-decoration-none text-dark"
                                    >
                                        {{$item->ins_name ??''}}
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{$item->ins_phone ??''}}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{$item->sub_name ??''}}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{$item->sub_id ??''}}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{$item->patent_id ??''}}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{$item->patent_name ??''}}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{ display_date_format($item->dob ??null) ??'' }}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{ display_date_format($item->dos ??null) ??''}}
                                </div>
                            </td>
                            <td>
                                <div x-bind:class="editable?'p-2':''">
                                    {{ currency($item->total ??0) }}
                                </div>
                            </td>

                            <td class="text-end"
                                x-bind:class="editable?'p-2':''"
                                colspan="2"
                            >
                                <div class="d-flex justify-content-end">
                                    @can('claim::update')
                                        <a class="btn btn-sm btn-icon btn-light-primary fs-10"
                                           href="{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}"
                                           wire:navigate
                                           data-bs-toggle="tooltip"
                                           data-bs-original-title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Base Row -->
                        <tr class="fs-8 border-bottom border-dashed border-secondary edit-row"
                            x-show="showRow == '{{ $item->id }}'"
                            x-bind:class="editable?'mk-table-th-p-2':''"
                        >
                            <td></td>
                            <th>
                                Sent on:
                            </th>
                            <td>
                                {{ display_date_format($item->sent ??null) ??''}}
                            </td>
                            <th>No of Days:</th>
                            <td>
                                {{ $item->days ??'' }}
                            </td>
                            <th>Days - R:</th>
                            <td>
                                {{ $item->days_r ??'' }}
                            </td>
                            <th>
                                Prov-Name:
                            </th>
                            <td>
                                {{$item->prov_nm ??''}}
                            </td>
                            <th>Location:</th>
                            <td colspan="2">
                                {{$item->location ??''}}
                            </td>
                        </tr>
                        <!-- Base Row Ends -->

                        <!-- Claim Status Row -->
                        <tr class="fs-8 border-bottom border-dashed border-secondary edit-row"
                            x-show="showRow == '{{ $item->id }}'"
                            x-bind:class="editable?'mk-table-th-only-p-2':''"
                        >
                            <td></td>
                            <th>
                                Claim Status:
                            </th>
                            <td>
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{$item->claimStatusModal?->name ??''}}
                                </div>
                                <div x-show="editable">
                                    <select class="fs-8"
                                            x-model="model.claim_status"
                                            x-on:change="claimStatusUpdated"
                                    >
                                        <option value="">Select</option>
                                        @foreach($claimStatusList as $status)
                                            <option value="{{ $status->id }}">{{ $status->name ??'' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <th>
                                Status Description:
                            </th>
                            <td colspan="3"
                                x-bind:class="editable?'p-2':''"
                            >
                                {{ $item->status_description ??'' }}
                            </td>
                            <th>
                                Claim Action:
                            </th>
                            <td colspan="4"
                                x-bind:class="editable?'p-2':''"
                            >
                                {{ $item->claim_action ??'' }}
                            </td>
                        </tr>
                        <!-- Claim Status Row Ends -->

                        <!-- Question & Answers Row -->
                        @if($item->answers()->count()>0)
                            <tr class="fs-8 border-bottom border-dashed border-secondary edit-row"
                                x-show="showRow == '{{ $item->id }}'"
                                x-bind:class="editable?'mk-table-th-only-p-2':''"
                            >
                                <td></td>
                                @foreach($item->answers as $qi=>$row)
                                    <th class="text-danger">
                                        {{ $row->question ??'' }}
                                    </th>
                                    <td>
                                        <div x-show="!editable">
                                            {{ $row->answer ??'' }}
                                        </div>
                                        <div x-show="editable">
                                            <input type="text"
                                                   x-model="model.a_{{$qi + 1}}"
                                                   class="fs-8 h-100 w-100"
                                            >
                                        </div>
                                    </td>
                                @endforeach
                                <td colspan="{{ max((5 - $item->answers()->count())*2,1) + 1 }}"></td>
                            </tr>
                        @endif
                        <!-- Question & Answers Row Ends -->

                        <!-- Additional Notes & Follow--Up Row -->
                        <tr class="fs-8 border-bottom border-dashed border-secondary edit-row"
                            x-show="showRow == '{{ $item->id }}'"
                            x-bind:class="editable?'mk-table-th-only-p-2':''"
                        >
                            <td></td>
                            <th>
                                Additional Notes:
                            </th>
                            <td colspan="5">
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{$item->note ??''}}
                                </div>
                                <div x-show="editable">
                                            <textarea class="fs-8 w-100 h-100"
                                                      x-model="model.note"
                                            ></textarea>
                                </div>
                            </td>
                            <th>
                                Followup Status:
                            </th>
                            <td colspan="4" >
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{$item->followUpModal?->name ??''}}
                                </div>
                                <div x-show="editable">
                                    <select class="fs-8"
                                            x-model="model.follow_up_status"
                                    >
                                        <option value="">Select</option>
                                        @foreach($followList as $row)
                                            <option value="{{ $row->id }}">{{ $row->name ??'' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- Additional Notes & Follow--Up Row Ends -->

                        <!-- Final Row -->
                        <tr class="fs-8 border-bottom border-dashed border-secondary edit-row"
                            x-show="showRow == '{{ $item->id }}'"
                            x-bind:class="editable?'mk-table-th-only-p-2':''"
                        >
                            <td></td>
                            <th>
                                Claim on File:
                            </th>
                            <td>
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{$item->cof ??''}}
                                </div>
                                <div x-show="editable">
                                    <select class="fs-8"
                                            x-model="model.cof"
                                    >
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </td>
                            <th>
                                Next/Followup Date:
                            </th>
                            <td>
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{ display_date_format($item->nxt_flup_dt ??null) ??''}}
                                </div>
                                <div x-show="editable">
                                    <input type="date"
                                           class="fs-8"
                                           x-model="model.nxt_flup_dt"
                                    />
                                </div>
                            </td>
                            <th>
                                EOB Downloaded:
                            </th>
                            <td>
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{$item->eobDlModal?->name ??''}}
                                </div>
                                <div x-show="editable">
                                    <select class="fs-8"
                                            x-model="model.eob_dl"
                                    >
                                        <option value="">Select</option>
                                        @foreach($eobList as $row)
                                            <option value="{{ $row->id }}">{{ $row->name ??'' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <th>
                                Worked By:
                            </th>
                            <td>
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{$item->worked_by ??''}}
                                </div>
                                <div x-show="editable">
                                    <input type="text"
                                           x-model="model.worked_by"
                                           class="fs-8 w-100"
                                    />
                                </div>
                            </td>
                            <th>
                                Worked Date:
                            </th>
                            <td colspan="2">
                                <div x-show="!editable"
                                     x-bind:class="editable?'p-2':''"
                                >
                                    {{ display_date_format($item->worked_dt ??null) ??''}}
                                </div>
                                <div x-show="editable">
                                    <input type="date"
                                           class="fs-8"
                                           x-model="model.worked_dt"
                                    />
                                </div>
                            </td>
                        </tr>
                        <!-- Final Row Ends -->

                        <!-- Action Row -->
                        <tr class="fs-8 edit-row"
                            x-show="editable && showRow == '{{ $item->id }}'"
                            style="border-bottom: 3px solid #3e96ff"
                        >
                            <td colspan="12" class="gap-5 text-center p-2">
                                <button class="btn btn-sm btn-primary"
                                        @click="saveModal({{ $item->id }})"
                                >
                                    <span x-show="processing" class="spinner-border spinner-border-sm me-2"></span>Save
                                </button>
                                <button class="btn btn-sm btn-dark"
                                        @click="openRowSection({{ $item->id }})"
                                >
                                    Close
                                </button>
                            </td>
                        </tr>
                        <!-- Action Row Ends -->
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">No data available</td>
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
            <div class="d-flex justify-content-between">
                <div>
                    <select wire:model.live="filter.perPage"
                            class="form-select form-select-sm bg-transparent"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    {{$data->links() ??''}}
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    @include('_particles.admin.components.claim-filter-sidebar')
</div>


@assets
<style>
    .activeTag td a{
        color: white!important;
    }
    .m-select .placeholder{
        cursor: pointer!important;
    }
    .cp-row .col-md-3,.cp-row .col-md-4,.cp-row .col-md-6{
        padding: 0!important;
        padding-left: 1.25rem!important;
        padding-right: 0.85rem!important;
        padding-bottom: 0.25rem!important;
    }
    .cp-row .col-form-label{
        font-size: 0.85rem!important;
        padding: 0.25rem!important;
        padding-left: 0!important;
    }
    .ins_table_head th{
        padding:.5rem!important;
    }
    .mk-table-th-p-2 td,.mk-table-th-p-2 th{
        padding:.5rem!important;
    }
    .mk-table-th-only-p-2 th{
        padding:.5rem!important;
    }
    .edit-row{
        background-color: #DCDCDC!important;
    }
</style>
@endassets
