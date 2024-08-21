@section('title','Insurance Claims')

@php
    $menuData = [
         'title'=>trans('Insurance Claims Table'),
         'menu'=>[ ['name'=>trans('Insurance Claims'),'url'=>'#'],['name'=>trans('List'),'active'=>true] ],
         'full-width'=>true,
    ];
@endphp

<div>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container {{ Arr::has($menuData,'full-width')?'container-fluid':'container-xxl' }} d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3" wire:ignore>
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ $menuData['title'] ??'' }}</h1>
                <!--end::Title-->
                @if(Arr::has($menuData,'menu') && count($menuData['menu'])>0)
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin::dashboard') }}" wire:navigate class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        @foreach($menuData['menu'] as $i=>$item)
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            @if(Arr::has($item,'active'))
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">{{$item['name'] ??''}}</li>
                                <!--end::Item-->
                            @else
                                @if(Arr::has($item,'url'))
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{$item['url']}}" wire:navigate class="text-muted text-hover-primary">{{$item['name'] ??''}}</a>
                                    </li>
                                    <!--end::Item-->
                                @else
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">{{$item['name'] ??''}}</li>
                                    <!--end::Item-->
                                @endif
                            @endif
                        @endforeach
                    </ul>
                    <!--end::Breadcrumb-->
                @endif
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <x-forms.multi-choice-select wire:model.live="selectedCustomers"
                                             placeholder="Select Client"
                                             class="min-w-150px form-control form-control-sm m-select"
                >
                    @foreach($userCustomers as $item)
                        <option value="{{ $item->id }}">{{ $item->fullName() ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
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
                            <!--end::Search-->
                            <div>
                                <span class="small ms-2 pt-2" wire:loading wire:target="search">Searching...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            @can('claim::update')
                                <div>
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
                                <x-forms.multi-choice-select wire:model.live="selectedClaimStatus"
                                                             placeholder="Select Claim Status"
                                                             class="min-w-150px form-control form-control-sm m-select"
                                >
                                    @foreach($claimStatusList as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                                    @endforeach
                                </x-forms.multi-choice-select>
                            </div>
                            <div>
                                <x-forms.multi-choice-select wire:model.live="selectedStatus"
                                                             placeholder="Select Follow-Up"
                                                             class="min-w-150px form-control form-control-sm m-select"
                                >
                                    @foreach(\App\Models\InsuranceFollowUp::where('status',1)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                                    @endforeach
                                </x-forms.multi-choice-select>
                            </div>
                            @can('claim::export')
                                <div>
                                    <button type="button"
                                            class="btn btn-sm btn-light-primary"
                                            wire:click.prevent="exportData"
                                    >
                                        <span wire:loading wire:target="exportData"><span class="spinner-border spinner-border-sm me-2"></span></span>Export
                                    </button>
                                </div>
                            @endcan
                            @can('claim::add')
                                <div>
                                    <a href="{{ route('admin::insurance-claim:add') }}"
                                       wire:navigate
                                       class="btn btn-sm btn-primary"
                                    >
                                        Create Claim
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-0"
                     x-data="{
                         editable:@entangle('editFields'),
                         editField:null,
                         currentRow:null,
                         model:@entangle('editModal'),
                         modelValue:null,
                         showRow:null,
                         toggleEditable:function(row,field = 'ins_name'){

                             if(this.editable && (row != this.currentRow || this.editField != field))
                             {
                                  this.saveFiledValue(this.currentRow,this.editField,this.modelValue);
                                  @this.findFiledValue(row,field);
                             }
                         },
                         removeEditable:function(){

                                 this.saveFiledValue(this.currentRow,this.editField,this.modelValue);

                                 this.editField = null;
                                 this.currentRow = null;
                         },
                         setModalValue:function(value,row,field){
                            this.modelValue = value;
                            this.currentRow = row;
                            this.editField = field;
                         },
                         saveFiledValue:function(row,field,value){
                             @this.saveFieldValue(row,field,value);
                         },
                         openRowSection:function(id){
                            if(this.showRow == id){
                               this.showRow = null;
                            }
                            else{
                               this.showRow = id;
                            }
                         },
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
                        <table class="table table-bordered gs-5"
                               x-bind:class="editable?'gx-0 gy-0':'gy-3 gx-5'"
                               @click.away="removeEditable"
                        >
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="fw-semibold fs-8 text-gray-800">
                                <th></th>
                                <x-admin.claims.table-header-element
                                    class="min-w-75px"
                                    element="id"
                                    label="ID"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                {{--                                <x-admin.claims.table-header-element--}}
                                {{--                                    class="min-w-75px"--}}
                                {{--                                    element="customer_id"--}}
                                {{--                                    label="Client"--}}
                                {{--                                    currentOrder="{{ $filter['orderBy'] }}"--}}
                                {{--                                    currentSort="{{ $filter['sortBy'] }}"--}}
                                {{--                                />--}}
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
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            @forelse($data as $item)
                                <tr class="{{ in_array($item->follow_up_status,$closedStatus)?'bg-success text-white activeTag':'' }} fs-8 border-bottom border-dashed border-secondary"

                                >
                                    <td>
                                        <div x-bind:class="editable?'px-4 py-2':''">
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
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            <a href="{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}"
                                               class="text-decoration-none text-dark"
                                            >
                                                {{$item->code() ??''}}
                                            </a>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','ins_name')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'ins_name'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            <a :href="editable?'javascript:void(0)':'{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}'"
                                               class="text-decoration-none text-dark"
                                            >
                                                {{$item->ins_name ??''}}
                                            </a>
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'ins_name')">
                                            <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                      rows="3"
                                                      x-model="modelValue"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','ins_phone')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'ins_phone'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->ins_phone ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'ins_phone')">
                                            <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                      rows="3"
                                                      x-model="modelValue"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','sub_name')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'sub_name'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->sub_name ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'sub_name')">
                                            <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                      rows="3"
                                                      x-model="modelValue"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','sub_id')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'sub_id'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->sub_id ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'sub_id')">
                                            <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                      rows="3"
                                                      x-model="modelValue"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','patent_id')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'patent_id'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->patent_id ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'patent_id')">
                                            <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                      rows="3"
                                                      x-model="modelValue"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','patent_name')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'patent_name'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->patent_name ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'patent_name')">
                                            <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                      rows="3"
                                                      x-model="modelValue"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','dob')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'dob'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->dob ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'dob')">
                                            <input type="date"
                                                   class="form-control rounded-0 fs-8"
                                                   x-model="modelValue"
                                            />
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','dos')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'dos'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->dos ??''}}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'dos')">
                                            <input type="date"
                                                   class="form-control rounded-0 fs-8"
                                                   x-model="modelValue"
                                            />
                                        </div>
                                    </td>
                                    <td @click="toggleEditable('{{ $item->id }}','total')" >
                                        <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'total'))"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{ currency($item->total ??0) }}
                                        </div>
                                        <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'total')">
                                            <input type="number"
                                                   class="form-control rounded-0 fs-8"
                                                   x-model="modelValue"
                                                   min="0"
                                                   step="any"
                                            />
                                        </div>
                                    </td>

                                    <td class="text-end"
                                        x-bind:class="editable?'p-2':''"
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
                                            @can('claim::delete')
                                                <a class="btn btn-icon btn-sm btn-light-danger fs-10 ms-3"
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
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                <tr class="fs-8 border-bottom border-dashed border-secondary"
                                    x-show="showRow == '{{ $item->id }}'"
                                >
                                    <td colspan="12" class="p-0">
                                        <div class="card bg-light-primary">
                                            <div class="card-body p-0">
                                                <table class="table table-bordered gs-5 gy-3 gx-5">
                                                    <tr>
                                                        <th>
                                                            SENT:
                                                        </th>
                                                        <td
                                                            {{--                                                            @click="toggleEditable('{{ $item->id }}','sent')"--}}
                                                        >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'sent'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->sent ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'sent')">
                                                                <input type="date"
                                                                       class="form-control rounded-0 fs-8"
                                                                       x-model="modelValue"
                                                                />
                                                            </div>
                                                        </td>
                                                        <th>Days:</th>
                                                        <td
                                                            {{--                                                            @click="toggleEditable('{{ $item->id }}','days')"--}}
                                                        >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'days'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->days ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'days')">
                                                                <input type="number"
                                                                       class="form-control rounded-0 fs-8"
                                                                       x-model="modelValue"
                                                                       min="0"
                                                                />
                                                            </div>
                                                        </td>
                                                        <th>Days-R:</th>
                                                        <td
                                                            {{--                                                            @click="toggleEditable('{{ $item->id }}','days_r')" --}}
                                                        >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'days_r'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->days_r ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'days_r')">
                                                                <input type="number"
                                                                       class="form-control rounded-0 fs-8"
                                                                       x-model="modelValue"
                                                                       min="0"
                                                                />
                                                            </div>
                                                        </td>
                                                        <th>
                                                            PROV-NM:
                                                        </th>
                                                        <td
                                                            {{--                                                            @click="toggleEditable('{{ $item->id }}','prov_nm')"--}}
                                                        >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'prov_nm'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->prov_nm ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'prov_nm')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>
                                                        <th>Location:</th>
                                                        <td
                                                            {{--                                                            @click="toggleEditable('{{ $item->id }}','location')"--}}
                                                        >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'location'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->location ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'location')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Claim Status:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','claim_status')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'claim_status'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->claimStatusModal?->name ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'claim_status')">
                                                                <select class="form-select rounded-0 fs-8 min-w-200px"
                                                                        x-model="modelValue"
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
                                                        <td>
                                                            {{ $item->status_description ??'' }}
                                                        </td>
                                                        <th>
                                                            Claim Action:
                                                        </th>
                                                        <td>
                                                            {{ $item->claim_action ??'' }}
                                                        </td>
                                                        <th>
                                                            Enter Additional Notes here:
                                                        </th>
                                                        <td colspan="3" @click="toggleEditable('{{ $item->id }}','note')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'note'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->note ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'note')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            {{ $item->answers?->first()?->question ??'' }}
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','a_1')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'a_1'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->answers?->first()?->answer ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'a_1')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>
                                                        <th>
                                                            {{ $item->answers->skip(1)?->first()?->question ??'' }}
                                                        </th>
                                                        <td  @click="toggleEditable('{{ $item->id }}','a_2')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'a_2'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->answers->skip(1)?->first()?->answer ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'a_2')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>

                                                        <th>
                                                            {{ $item->answers->skip(2)?->first()?->question ??'' }}
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','a_3')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'a_3'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->answers->skip(2)?->first()?->answer ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'a_3')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>

                                                        <th>
                                                            {{ $item->answers->skip(3)?->first()?->question ??'' }}
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','a_4')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'a_4'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->answers->skip(3)?->first()?->answer ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'a_4')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>

                                                        <th>
                                                            {{ $item->answers->skip(4)?->first()?->question ??'' }}
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','a_5')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'a_5'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{ $item->answers->skip(4)?->first()?->answer ??'' }}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'a_5')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            COF:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','cof')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'cof'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->cof ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'cof')">
                                                                <select class="form-select rounded-0 fs-8 min-w-200px"
                                                                        x-model="modelValue"
                                                                >
                                                                    <option value="">Select</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <th>
                                                            NXT FLUP DT:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','nxt_flup_dt')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'nxt_flup_dt'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->nxt_flup_dt ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'nxt_flup_dt')">
                                                                <input type="date"
                                                                       class="form-control rounded-0 fs-8"
                                                                       x-model="modelValue"
                                                                />
                                                            </div>
                                                        </td>
                                                        <th>
                                                            EOB DL:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','eob_dl')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'eob_dl'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->eobDlModal?->name ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'eob_dl')">
                                                                <select class="form-select rounded-0 fs-8 min-w-200px"
                                                                        x-model="modelValue"
                                                                >
                                                                    <option value="">Select</option>
                                                                    @foreach($eobList as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name ??'' }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <th>
                                                            Follow-Up Status
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','follow_up_status')" colspan="3" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'follow_up_status'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->followUpModal?->name ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'follow_up_status')">
                                                                <select class="form-select rounded-0 fs-8 min-w-200px"
                                                                        x-model="modelValue"
                                                                >
                                                                    <option value="">Select</option>
                                                                    @foreach($followList as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name ??'' }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Team Worked:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','team_worked')">
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'team_worked'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->teamModal?->name ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'team_worked')">
                                                                <select class="form-select rounded-0 fs-8 min-w-200px"
                                                                        x-model="modelValue"
                                                                >
                                                                    <option value="">Select</option>
                                                                    @foreach($teamList as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name ??'' }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <th>
                                                            Worked By:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','worked_by')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'worked_by'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->worked_by ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'worked_by')">
                                                                <textarea class="form-control rounded-0 min-w-200px fs-8"
                                                                          rows="3"
                                                                          x-model="modelValue"
                                                                ></textarea>
                                                            </div>
                                                        </td>
                                                        <th>
                                                            Worked DT:
                                                        </th>
                                                        <td @click="toggleEditable('{{ $item->id }}','worked_dt')" >
                                                            <div x-show="(editable == false || (currentRow != '{{ $item->id }}' || editField != 'worked_dt'))"
                                                                 x-bind:class="editable?'p-2':''"
                                                            >
                                                                {{$item->worked_dt ??''}}
                                                            </div>
                                                            <div x-show="(editable == true && currentRow == '{{ $item->id }}' && editField == 'worked_dt')">
                                                                <input type="date"
                                                                       class="form-control rounded-0 fs-8"
                                                                       x-model="modelValue"
                                                                />
                                                            </div>
                                                        </td>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
        </div>
    </div>

    @include('admin.modals.export_modal')
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
</style>
@endassets
