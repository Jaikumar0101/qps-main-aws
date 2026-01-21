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
                                             class="min-w-250px"
                                             label="Select Client"
                >
                    @foreach($userCustomers as $item)
                        <option value="{{ $item->id }}">{{ $item->last_name ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
                <x-forms.multi-choice-dropdown wire:model.live="selectedCustomers"
                         placeholder="Select Client"
                         class="min-w-250px"
                         label="Select Client"
                         :options="$userCustomers"
                         option-label="last_name"
                         option-value="id"
                />
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
                            @can('claim::archived')
                                <div class="me-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="flexSwitchWithTrashed"
                                               onchange="@this.set('withTrashed',this.checked)"
                                            {{ $withTrashed?'checked':'' }}
                                        />
                                        <label class="form-check-label" for="flexSwitchWithTrashed">
                                            Archived
                                        </label>
                                    </div>
                                </div>
                                |
                            @endcan
                            @can('claim::assign')
                                <div class="me-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="flexSwitchDefaultAssign"
                                               onchange="@this.set('rowSelection',this.checked)"
                                            {{ $rowSelection?'checked':'' }}
                                        />
                                        <label class="form-check-label" for="flexSwitchDefaultAssign">
                                            Bulk Action
                                        </label>
                                    </div>
                                </div>
                                |
                            @endcan
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
                            @can('claim::import')
                                <div>
                                    <a class="btn btn-sm btn-primary"
                                       href="{{ route('admin::insurance-claim:import') }}"
                                       wire:navigate
                                    >
                                        <i class="fa fa-file-excel me-2"></i>Import
                                    </a>
                                </div>
                            @endcan
                            <div>
                                <!--begin::Trigger button-->
                                <button class="btn btn-sm btn-flex btn-secondary fw-bold"
                                        wire:click.prevent="openFilterSidebar"
                                        wire:loading.attr="disabled"
                                >
                                    <div>
                                        <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <span class="filter-text">Filter</span>
                                </button>
                                <!--end::Trigger button-->

                                <!--begin::Trigger button-->
                                <button id="kt_drawer_filter_button" class="btn btn-sm btn-flex btn-secondary fw-bold d-none">
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
                @can('claim::assign')
                    <div class="px-8 py-2 {{ $rowSelection?'':'d-none' }}">
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="d-flex gap-3">
                                        <button class="btn btn-sm btn-light active">
                                            {{ count($selected) }} Selected
                                        </button>
                                        @can('claim::archived')
                                            <button class="btn btn-sm btn-danger btn-outline-danger"
                                                wire:loading.attr="disabled"
                                                {{ count($selected)>0?'':'disabled' }}
                                                x-on:click="
                                                    Swal.fire({
                                                          title: 'Are you sure?',
                                                          text: 'Once deleted, you will not be able to recover this record but you can recover records if moved to trash !',
                                                          icon: 'warning',
                                                          showCancelButton: true,
                                                          showDenyButton: true,
                                                          confirmButtonText: 'Yes, delete it!',
                                                          cancelButtonText: 'No',
                                                          denyButtonText: 'Move to trash',
                                                          customClass: {
                                                            confirmButton: 'btn btn-danger',
                                                            cancelButton: 'btn btn-secondary',
                                                            denyButton: 'btn btn-info'
                                                          },
                                                          buttonsStyling: false,
                                                          allowEnterKey: false,
                                                          preConfirm: () => {
                                                          @can('claim::delete')
                                                                return true
                                                          @else
                                                                Swal.showValidationMessage('You do not have permission to delete this record')
                                                                return false
                                                          @endcan
                                                            },
                                                        }).then((event) => {
                                                          if (event.isConfirmed) {
                                                                $wire.permanentlyRemoveRecords();
                                                          } else if (event.isDenied) {
                                                                $wire.moveRecordsToTrashed();
                                                          } else {}
                                                        });
                                                   "
                                        >
                                            Delete Records
                                        </button>
                                        @endcan
                                        @can('claim::update')
                                            <button class="btn btn-sm btn-outline btn-outline-dark"
                                                    wire:click.prevent="openBulkFieldUpdateModal"
                                                    wire:loading.attr="disabled"
                                                   {{ count($selected)>0?'':'disabled' }}
                                            >
                                                Bulk Update
                                            </button>
                                        @endcan
                                        @can('claim::restore')
                                            @if($withTrashed)
                                                <button class="btn btn-sm btn-success"
                                                        wire:click.prevent="restoreRecords"
                                                        wire:loading.attr="disabled"
                                                >
                                                    <i class="fa fa-history pe-2"></i> Restore
                                                </button>
                                            @endif
                                        @endcan
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-dark"
                                            wire:click.prevent="OpenAssignModal"
                                            wire:loading.attr="disabled"
                                        {{ count($selected)>0?'':'disabled' }}
                                    ><i class="fa fa-users me-1"></i>Assign</button>
                                    <button class="btn btn-sm btn-warning"
                                            wire:click.prevent="unAssignSelectedClaims"
                                            wire:loading.attr="disabled"
                                            wire:confirm="Are you sure you want to continue to unassign ?"
                                        {{ count($selected)>0?'':'disabled' }}
                                    ><i class="fa fa-user-xmark me-1"></i>UnAssign</button>
                                    <button class="btn btn-sm btn-danger"
                                            wire:click.prevent="resetSelectedRows"
                                            wire:loading.attr="disabled"
                                        {{ count($selected)>0?'':'disabled' }}
                                    ><i class="fa fa-xmark me-1"></i>Remove Selected</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-0"
                     x-data="{
                         rowSelection:@entangle('rowSelection'),
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
                            this.updateClaimPMS();
                         },
                         updateClaimPMS:function(){
                             this.model.pms_note = 'No';
                         },
                         updateTask:function() {
                               @this.updateTaskSubject()
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
                        <table class="table table-bordered"
                               x-bind:class="editable?'gx-0 gy-0':'gy-2 gx-3'"
                        >
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="fw-semibold fs-8 text-gray-800"
                                x-bind:class="editable?'ins_table_head':''"
                            >
                                <th x-bind:class="editable?'p-0':'ps-2 pe-2'">
                                    <div x-show="rowSelection">
                                        <input type="checkbox"
                                               class="form-check-input cs-checkbox"
                                               wire:change="toggleCurrentPageItems($event.target.checked)"
                                        />
                                    </div>
                                </th>
{{--                                <x-admin.claims.table-header-element--}}
{{--                                    class="min-w-75px"--}}
{{--                                    element="id"--}}
{{--                                    label="ID"--}}
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
                                    element="created_at"
                                    label="Merge Date"
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
                                <x-admin.claims.table-header-element
                                    class=""
                                    element="claim_status"
                                    label="Claim Status"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                <x-admin.claims.table-header-element
                                    class=""
                                    element="follow_up_status"
                                    label="Follow-up Status"
                                    currentOrder="{{ $filter['orderBy'] }}"
                                    currentSort="{{ $filter['sortBy'] }}"
                                />
                                @can('claim::assign')
                                    <th class="">
                                        <i class="fa fa-users me-1"></i>Assigned
                                    </th>
                                    <th class="text-end min-w-50px">Actions</th>
                                @else
                                    <th class="text-end min-w-50px" colspan="2">Actions</th>
                                @endcan
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            @forelse($data as $item)
                                <tr class="{{  $item->trashed()?'bg-warning text-white':(in_array($item->follow_up_status,$closedStatus)?'bg-success text-white activeTag':'') }} fs-8 border-bottom border-dashed border-secondary"

                                >
                                    <td x-bind:class="editable?'p-0':'ps-2 pe-2'">

                                        <div x-show="rowSelection">
                                            <input type="checkbox"
                                                   class="form-check-input cs-checkbox"
                                                   wire:key="rowSelection_{{ $item->id }}"
                                                   wire:model="selected"
                                                   value="{{ $item->id }}"
                                            />
                                        </div>

                                        <div x-show="!rowSelection">
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
                                        </div>

                                    </td>
{{--                                    <td class="w-20px text-nowrap">--}}
{{--                                        <div x-bind:class="editable?'p-2':''">--}}
{{--                                            <a href="{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}"--}}
{{--                                               class="text-decoration-none text-dark"--}}
{{--                                            >--}}
{{--                                                {{$item->code() ??''}}--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
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
                                            {{$item->patent_name ??''}}
                                        </div>
                                    </td>
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            {{ display_date_format($item->dob ??null) ??''}}
                                        </div>
                                    </td>
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            {{ display_date_format($item->dos ??null) ??''}}
                                        </div>
                                    </td>
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            {{ get_date_by_format($item->created_at,'m/d/Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            {{ currency($item->total ??0) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            {{ $item->claimStatusModal?->name ??'' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div x-bind:class="editable?'p-2':''">
                                            {{ $item->followUpModal?->name ??'' }}
                                        </div>
                                    </td>
                                    @can('claim::assign')
                                        <td class="nowrap">
                                            <x-admin.claims.team-row-tag
                                                :claim="$item"
                                            />
                                        </td>
                                        <td class="text-end"
                                            x-bind:class="editable?'p-2':''"
                                        >
                                            <div class="d-flex justify-content-end gap-3">
                                                @can('claim::update')
                                                    <a class="btn btn-sm btn-icon btn-info fs-10"
                                                       href="{{ route('admin::insurance-claim:view',['claim_id'=>$item->id]) }}"
                                                       wire:navigate
                                                       data-bs-toggle="tooltip"
                                                       data-bs-original-title="View"
                                                    >
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-primary fs-10"
                                                       href="{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}"
                                                       wire:navigate
                                                       data-bs-toggle="tooltip"
                                                       data-bs-original-title="Edit"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    @if($item->trashed() && Gate::allows('claim::archived'))
                                                        <a class="btn btn-sm btn-icon btn-success fs-10"
                                                           href="javascript:void(0)"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-original-title="Recover from archived"
                                                           wire:click.prevent="recoverArchiveLead({{ $item->id }})"
                                                           wire:loading.attr="disabled"
                                                           wire:key="recover_btn_{{ $item->id }}"
                                                        >
                                                            <span wire:loading.remove wire:target="recoverArchiveLead({{ $item->id }})">
                                                                <i class="fa fa-history"></i>
                                                            </span>
                                                            <span wire:loading wire:target="recoverArchiveLead({{ $item->id }})">
                                                                <span class="spinner-border spinner-border-sm"></span>
                                                            </span>
                                                        </a>
                                                    @elseif(!$item->trashed() && Gate::allows('claim::restore'))
                                                        <a class="btn btn-sm btn-icon btn-warning fs-10"
                                                           href="javascript:void(0)"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-original-title="Move to archived"
                                                           wire:click.prevent="moveLeadToArchive({{ $item->id }})"
                                                           wire:loading.attr="disabled"
                                                           wire:key="archived_btn_{{ $item->id }}"
                                                        >
                                                        <span wire:loading.remove wire:target="moveLeadToArchive({{ $item->id }})">
                                                            <i class="bi bi-archive"></i>
                                                        </span>
                                                            <span wire:loading wire:target="moveLeadToArchive({{ $item->id }})">
                                                            <span class="spinner-border spinner-border-sm"></span>
                                                        </span>
                                                        </a>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    @else
                                        <td class="text-end"
                                            colspan="2"
                                            x-bind:class="editable?'p-2':''"
                                        >
                                            <div class="d-flex justify-content-end gap-3">
                                                @can('claim::update')
                                                    <a class="btn btn-sm btn-icon btn-info fs-10"
                                                       href="{{ route('admin::insurance-claim:view',['claim_id'=>$item->id]) }}"
                                                       wire:navigate
                                                       data-bs-toggle="tooltip"
                                                       data-bs-original-title="View"
                                                    >
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-icon btn-primary fs-10"
                                                       href="{{ route('admin::insurance-claim:edit',['claim_id'=>$item->id]) }}"
                                                       wire:navigate
                                                       data-bs-toggle="tooltip"
                                                       data-bs-original-title="Edit"
                                                    >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    @if($item->trashed() && Gate::allows('claim::archived'))
                                                        <a class="btn btn-sm btn-icon btn-success fs-10"
                                                           href="javascript:void(0)"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-original-title="Recover from archived"
                                                           wire:click.prevent="recoverArchiveLead({{ $item->id }})"
                                                           wire:loading.attr="disabled"
                                                           wire:key="recover_btn_{{ $item->id }}"
                                                        >
                                                            <span wire:loading.remove wire:target="recoverArchiveLead({{ $item->id }})">
                                                                <i class="fa fa-history"></i>
                                                            </span>
                                                            <span wire:loading wire:target="recoverArchiveLead({{ $item->id }})">
                                                                <span class="spinner-border spinner-border-sm"></span>
                                                            </span>
                                                        </a>
                                                    @elseif(!$item->trashed() && Gate::allows('claim::restore'))
                                                        <a class="btn btn-sm btn-icon btn-warning fs-10"
                                                           href="javascript:void(0)"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-original-title="Move to archived"
                                                           wire:click.prevent="moveLeadToArchive({{ $item->id }})"
                                                           wire:loading.attr="disabled"
                                                           wire:key="archived_btn_{{ $item->id }}"
                                                        >
                                                        <span wire:loading.remove wire:target="moveLeadToArchive({{ $item->id }})">
                                                            <i class="bi bi-archive"></i>
                                                        </span>
                                                            <span wire:loading wire:target="moveLeadToArchive({{ $item->id }})">
                                                            <span class="spinner-border spinner-border-sm"></span>
                                                        </span>
                                                        </a>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    @endcan
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
                                    <td colspan="4">
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
                                    <td colspan="6"
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
                                        <td colspan="{{ max((5 - $item->answers()->count())*2,1) + 3 }}"></td>
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
                                            @foreach($item->userNotes as $noteItem)
                                                <br>{{ $noteItem->note ??'' }}&nbsp;&nbsp; ( {{ $noteItem->user?->fullName() ??'--' }}  {{ get_date_by_format($noteItem->created_at,'m/d/Y - H:i') }} )
                                            @endforeach
                                        </div>
                                        <div x-show="editable" class="mb-2">
                                            <textarea class="fs-8 w-100 h-100"
                                                      x-model="model.note"
                                            ></textarea>
                                            @if($editModal && $editModal->id == $item->id)
                                                @foreach($notes as $nIndex=>$noteItem)
                                                    <div class="row my-2 gy-2 gx-2">
                                                        @if(Arr::has($noteItem,'id'))
                                                            <div class="col-7">
                                                                {{ \App\Models\User::displayUserName($noteItem['user_id']) }}
                                                            </div>
                                                            <div class="col-5">
                                                                {{ get_date_by_format($noteItem['created_at'] ??null,'m/d/Y - H:i') }}
                                                            </div>
                                                        @else
                                                            <div class="col-7">
                                                                {{ $adminUser->fullName() }}
                                                            </div>
                                                            <div class="col-5">
                                                                --
                                                            </div>
                                                        @endif
                                                        <div class="col-10">
                                                        <textarea class="fs-8 w-100 h-100"
                                                                  wire:model="notes.{{ $nIndex }}.note"
                                                        ></textarea>
                                                        </div>
                                                        <div class="col-2">
                                                            <x-admin.theme.button icon="fa fa-trash"
                                                                                  color="danger"
                                                                                  class="btn-icon btn-sm rounded-pill"
                                                                                  wire:click.prevent="removeClaimNote({{ $nIndex }})"
                                                                                  wire:loading.attr="disabled"
                                                            />
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <x-admin.theme.button label="Add"
                                                                  icon="fa fa-add"
                                                                  color="success"
                                                                  class="btn-sm p-0 px-2 py-1"
                                                                  wire:click.prevent="addNewClaimNote"
                                                                  wire:loading.attr="disabled"
                                            />
                                        </div>
                                    </td>
                                    <th>
                                        Followup Status:
                                    </th>
                                    <td colspan="2">
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
                                    <th>
                                        PMS Note:
                                    </th>
                                    <td>
                                        <div x-show="!editable"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->pms_note ??''}}
                                        </div>
                                        <div x-show="editable">
                                            <select class="fs-8"
                                                    x-model="model.pms_note"
                                            >
                                                <option value="">Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </td>
                                    <th>
                                        Method:
                                    </th>
                                    <td>
                                        <div x-show="!editable"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{ ucfirst($item->method ??'') }}
                                        </div>
                                        <div x-show="editable">
                                            <select class="fs-8"
                                                    x-model="model.method"
                                            >
                                                <option value="">Select</option>
                                                <option value="call">Call</option>
                                                <option value="portal">Portal</option>
                                                <option value="both">Both</option>
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
                                    <td colspan="4">
                                        <div x-show="!editable"
                                             x-bind:class="editable?'p-2':''"
                                        >

                                            {{ display_date_format($item->worked_dt ??null) ??''}}
                                        </div>
                                        <div x-show="editable">
                                            <input type="date"
                                                   class="fs-8"
                                                   x-model="model.worked_dt"
                                                   x-on:change="updateClaimPMS()"
                                            />
                                        </div>
                                    </td>
                                </tr>
                                <!-- Final Row Ends -->

                                <!-- Task Row -->
                                <tr class="fs-8 border-bottom border-dashed border-secondary edit-row"
                                    x-show="showRow == '{{ $item->id }}'"
                                    x-bind:class="editable?'mk-table-th-only-p-2':''"
                                >
                                    <td></td>
                                    <th>
                                        Task Subject
                                    </th>
                                    <td colspan="3">
                                        <div x-show="!editable"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->task_subject ??''}}
                                        </div>
                                        <div x-show="editable">
                                            <textarea class="fs-8 w-100"
                                                      x-model="model.task_subject"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <th>
                                        Task Detail
                                    </th>
                                    <td colspan="2">
                                        <div x-show="!editable"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->task_note ??''}}
                                        </div>
                                        <div x-show="editable">
                                            <textarea class="fs-8 w-100"
                                                     x-model="model.task_note"
                                            ></textarea>
                                        </div>
                                    </td>
                                    <th colspan="2">
                                        What we need from you/Reason
                                    </th>
                                    <td colspan="4">
                                        <div x-show="!editable"
                                             x-bind:class="editable?'p-2':''"
                                        >
                                            {{$item->task_reason ??''}}
                                        </div>
                                        <div x-show="editable">
                                            <textarea class="fs-8 w-100"
                                                     x-model="model.task_reason"
                                            ></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Task Row Ends -->

                                <!-- Action Row -->
                                <tr class="fs-8 edit-row"
                                    x-show="editable && showRow == '{{ $item->id }}'"
                                    style="border-bottom: 3px solid #3e96ff"
                                >
                                    <td colspan="14" class="gap-5 text-center p-2">
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
        </div>
    </div>

    @include('admin.modals.export_modal')

    <livewire:admin.components.claim-filter-sidebar  :filter="$filter"
                                                     :other-filters="$customFilter"
                                                     parent-render-method="parentRenderMethod"
    />
    <livewire:admin.components.claim-assign-modal parent-render-method="parentRenderMethod" />
    <livewire:admin.components.claim-team-modal parent-render-method="parentRenderMethod" />
    <livewire:admin.components.claim-bulk-update-modal parent-render-method="parentRenderMethod" />

</div>

@script
<script>
    window.addEventListener('resetSelectedRowsCheckbox',()=>{
        document.querySelectorAll('.cs-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    })
</script>
@endscript

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
