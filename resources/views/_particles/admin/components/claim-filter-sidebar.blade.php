<!--begin::Drawer-->
<div
    id="kt_drawer_example_permanent"
    class="bg-white"
    data-kt-drawer="true"
    data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#kt_drawer_filter_button"
    data-kt-drawer-close="#kt_drawer_example_permanent_close"
    data-kt-drawer-overlay="true"
    data-kt-drawer-permanent="false"
    data-kt-drawer-width="{default:'300px', 'md': '500px'}"
    wire:ignore.self
>
    <!--begin::Card-->
    <div class="card rounded-0 w-100"
         x-data="{
           filterList:[
             'ins name',
             'provider name',
             'claim status',
             'follow up status',
             'eob downloaded',
             'number of days',
             'location',
             'total amount',
             'date of service ( dos )',
             'next followup date',
             'cof',
             'worked by',
             'worked date',
           ],
           searchFilter:'',
           filteredList: [],
           resetSearchFilter:function(){
              this.searchFilter = '';
           },
           filteredList:[],
         }"
         x-init="
           $watch('searchFilter', function(value){
               if(searchFilter!='')
               {
                  filteredList = filterList.filter(item => item.toLowerCase().includes(searchFilter.toLowerCase()));
                   document.querySelectorAll('[data-search-input]').forEach(el => {
                     if(filteredList.includes(el.getAttribute('data-search-input').toLowerCase())) {
                       el.classList.remove('d-none');
                     } else {
                       el.classList.add('d-none');
                     }
                   });
               }
               else{
                  document.querySelectorAll('[data-search-input]').forEach(el => el.classList.remove('d-none'))
               }
           })
         "
         wire:ignore.self
    >
        <!--begin::Card header-->
        <div class="card-header pe-5">
            <!--begin::Title-->
            <div class="card-title">
                <i class="fa fa-filter fs-5 me-3"></i> Filter
            </div>
            <!--end::Title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-light-primary btn-close" id="kt_drawer_example_permanent_close"></div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <div class="px-5 py-2" wire:ignore>
            <div class="position-relative">
                <input x-model="searchFilter"
                       placeholder="Search Filter Option"
                       type="text"
                       class="form-control form-control-sm pe-4"
                />
                <div class="position-absolute" :class="searchFilter==''?'d-none':''" style="top: 50%;right: 15px;transform: translateY(-50%);">
                    <a href="javascript:void(0)"
                       @click="resetSearchFilter"
                    >
                        <i class="fa fa-xmark"></i>
                    </a>
                </div>
            </div>
        </div>

        <!--begin::Card body-->
        <div class="card-body hover-scroll-overlay-y">
            <div class="mb-3"
                 data-search-input="ins name"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="claimFilter.ins_name"
                                             placeholder="Select INS Name"
                                             class="min-w-50px"
                                             label="Select INS Name"
                >
                    <option value="">#NA</option>
                        @foreach(\App\Helpers\ClaimHelper::dateSuggestions($adminUser,'ins_name') as $item)
                            <option value="{{ $item ??'' }}">{{ $item ??'' }}</option>
                        @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="provider name"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="claimFilter.prov_nm"
                                             placeholder="Select Provider Name"
                                             class="min-w-50px"
                                             label="Select Provider Name"
                >
                    <option value="">#NA</option>
                    @foreach(\App\Helpers\ClaimHelper::dateSuggestions($adminUser,'prov_nm') as $item)
                        <option value="{{ $item ??'' }}">{{ $item ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="claim status"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="selectedClaimStatus"
                                             placeholder="Select Claim Status"
                                             class="min-w-150px"
                                             label="Claim Status"
                >
                    <option value="">#NA</option>
                    @foreach($claimStatusList as $item)
                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="follow up status"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="selectedStatus"
                                             placeholder="Select Follow-Up"
                                             class="min-w-150px"
                                             label="Follow-Up Status"
                >
                    <option value="">#NA</option>
                    @foreach(\App\Models\InsuranceFollowUp::where('status',1)->get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="eob downloaded"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="claimFilter.eob_dl"
                                             placeholder="Select EOB-DL"
                                             class="min-w-150px"
                                             label="EOB Downloaded"
                >
                    <option value="">#NA</option>
                    @foreach(\App\Models\InsuranceEobDl::where('status',1)->get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="number of days"
                 wire:ignore.self
            >
                @php
                    $datsFilterSuggestions = \App\Helpers\ClaimHelper::dateSuggestions($adminUser,'days');
                @endphp
                <x-admin.claims.filter-range-input wire:model.live="claimFilter.days"
                                                   label="Select Days Range"
                                                   min="0"
                                                   max="{{ findMaxInArray($datsFilterSuggestions ??0) }}"

                />
            </div>
            <div class="mb-3"
                 data-search-input="location"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="claimFilter.location"
                                             placeholder="Select Location"
                                             class="min-w-50px"
                                             label="Select Location"
                >
                    <option value="">#NA</option>
                    @foreach(\App\Helpers\ClaimHelper::dateSuggestions($adminUser,'location') as $item)
                        <option value="{{ $item ??'' }}">{{ $item ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="total amount"
                 wire:ignore.self
            >
                <x-admin.claims.filter-tag-input  wire:model.live="claimFilter.total_amount"
                                                  label="Total Amount"
                                                  :suggestions="ClaimHelper::dateSuggestions($adminUser,'total')"
                />
            </div>
            <div class="mb-3"
                 data-search-input="total amount"
                 wire:ignore.self
            >
                @php
                    $totalFilterSuggestions = \App\Helpers\ClaimHelper::dateSuggestions($adminUser,'total');
                @endphp
                <x-admin.claims.filter-range-input wire:model.live="claimFilter.total"
                                                   label="Total Amount Range"
                                                   min="0"
                                                   max="{{ findMaxInArray($totalFilterSuggestions ??0) }}"
                                                   prefix="$"

                />
            </div>
            <div class="mb-3"
                 data-search-input="date of service ( dos )"
                 wire:ignore.self
            >
                <x-admin.claims.filter-date-range-input wire:model.live="claimFilter.dos"
                                                        label="Date Of Service (Range)"
                />
            </div>
            <div class="mb-3"
                 data-search-input="next followup date"
                 wire:ignore.self
            >
                <x-admin.claims.filter-date-range-input wire:model.live="claimFilter.nxt_flup_dt"
                                                        label="Next/Followup Date (Range)"
                />
            </div>
            <div class="mb-3"
                 data-search-input="cof"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="claimFilter.cof"
                                             placeholder="Select COF"
                                             class="min-w-50px"
                                             label="Select COF"
                >
                    <option value="">#NA</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="worked by"
                 wire:ignore.self
            >
                <x-forms.multi-choice-select wire:model.live="claimFilter.worked_by"
                                             placeholder="Select Worked By"
                                             class="min-w-50px"
                                             label="Select Worked By"
                >
                    <option value="">#NA</option>
                    @foreach(\App\Helpers\ClaimHelper::dateSuggestions($adminUser,'worked_by') as $item)
                        <option value="{{ $item ??'' }}">{{ $item ??'' }}</option>
                    @endforeach
                </x-forms.multi-choice-select>
            </div>
            <div class="mb-3"
                 data-search-input="worked date"
                 wire:ignore.self
            >
                <x-admin.claims.filter-date-range-input wire:model.live="claimFilter.worked_dt"
                                                        label="Worked Date (Range)"
                />
            </div>
        </div>
        <!--end::Card body-->
        <div class="card-footer">
            <!--begin::Dismiss button-->
            <button class="btn btn-light-dark"
                    wire:click.prevent="resetClaimFilter"
                    wire:loading.attr="disabled"
                    type="button"
            >
                Reset Filter
            </button>
            <!--end::Dismiss button-->
        </div>
    </div>
    <!--end::Card-->
</div>
<!--end::Drawer-->
