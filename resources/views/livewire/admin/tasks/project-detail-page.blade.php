@section('title',$project->name ??'')
<div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="card mb-5">
                <div class="card-header">
                    <div class="card-title">
                        {{ $pageTitle ??'' }}
                    </div>
                </div>
            </div>

            <div x-data="{
                        currentTab:@entangle('currentTab'),
                        changeTab:function(tab){
                           this.currentTab = tab;
                        }
                     }"
                 x-cloak
            >
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-toolbar gap-4">
                            <button type="button"
                                    class="btn btn-sm rounded-pill"
                                    :class="currentTab == 'tasks'?'btn-primary':'btn-light'"
                                    @click="changeTab('tasks')"
                            >
                                List
                            </button>
                            <button type="button"
                                    class="btn btn-sm rounded-pill"
                                    :class="currentTab == 'message'?'btn-primary':'btn-light'"
                                    @click="changeTab('message')"
                            >
                                Messages
                            </button>
                            <button type="button"
                                    class="btn btn-sm rounded-pill"
                                    :class="currentTab == 'people'?'btn-primary':'btn-light'"
                                    @click="changeTab('people')"
                            >
                                People
                            </button>
                            <button type="button"
                                    class="btn btn-sm rounded-pill"
                                    :class="currentTab == 'dashboard'?'btn-primary':'btn-light'"
                                    @click="changeTab('dashboard')"
                            >
                                Dashboard
                            </button>
                            <button type="button"
                                    class="btn btn-sm rounded-pill"
                                    :class="currentTab == 'settings'?'btn-primary':'btn-light'"
                                    @click="changeTab('settings')"
                            >
                                Settings
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div x-show="currentTab == 'tasks'">
                        <livewire:admin.tasks.components.project-task-tab-content :project="$project" />
                    </div>
                    <div x-show="currentTab == 'message'">
                        <livewire:admin.tasks.components.project-message-tab-content :project="$project" />
                    </div>
                    <div x-show="currentTab == 'people'">
                        <livewire:admin.tasks.components.project-people-tab-content :project="$project" />
                    </div>
                    <div x-show="currentTab == 'dashboard'">
                        <livewire:admin.tasks.components.project-dashboard-tab-content :project="$project" />
                    </div>
                    <div x-show="currentTab == 'settings'">
                        <form wire:submit.prevent="saveSetting">
                            <div class="card position-relative">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="fs-6 fw-normal">
                                            <span class="fw-bold">Project Setting</span><br>
                                            <span class="fs-8">Here you can change project details & options</span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <x-input.text wire:model="request.name"
                                                          label="Project Name"
                                            />
                                            <x-input.text-area wire:model="request.description"
                                                               label="Description"
                                            />
                                            <x-input.text wire:model="request.company"
                                                          label="Company"
                                            />
                                            <div x-data="{
                                                   fpInstance:null,
                                                   startDate:@entangle('request.start_date'),
                                                   endDate: @entangle('request.end_date'),
                                                }"
                                                                             x-init="
                                                  fpInstance = flatpickr('#startDate, #endDate', {
                                                       enableTime: false,
                                                       dateFormat: 'Y-m-d',
                                                       altInput: true,
                                                       altFormat:'m-d-Y',
                                                       defaultDate: ['{{ $request['start_date'] ??'' }}', '{{ $request['end_date'] ??'' }}'],
                                                       mode: 'range',
                                                       plugins: [
                                                          rangePlugin({ input: '#endDate'}),
                                                       ],
                                                       onClose: function(selectedDates, dateStr, instance) {
                                                              startDate = selectedDates[0] ??null;
                                                              endDate = selectedDates[1] ??null;
                                                       }
                                                   });

                                                   window.addEventListener('clearFlatPickerRange',()=>{
                                                       fpInstance.clear()
                                                   })
                                                "
                                                                             wire:ignore
                                                                        >
                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label class="form-label">Start Date</label>
                                                                                    <input type="text"
                                                                                           class="form-control modal-date-picker"
                                                                                           id="startDate"
                                                                                           readonly
                                                                                    />
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <label class="form-label">End Date</label>
                                                                                    <input type="text"
                                                                                           class="form-control modal-date-picker"
                                                                                           id="endDate"
                                                                                           readonly
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                            <div class="mb-3 form-group">
                                                <label class="form-label">Tags</label>
                                                <x-forms.tag wire:model="request.tags"
                                                             label="Tags"
                                                             value="{{ $request['tags'] ??'' }}"
                                                />
                                            </div>
{{--                                            <div class="form-group mb-3">--}}
{{--                                                <label class="form-label">About Project</label>--}}
{{--                                                <x-editor.c-k-editor5 wire:model="request.content" />--}}
{{--                                            </div>--}}
                                        </div>
                                        <div class="col-md-5">
                                            <x-input.select wire:model="settingRequest.default_tab"
                                                            label="Default Tab"
                                            >
                                                @foreach(\App\Helpers\Quick\QuickTaskHelper::PROJECT_TABS as $key=>$item)
                                                    <option value="{{ $key }}">{{ $item ??'' }}</option>
                                                @endforeach
                                            </x-input.select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer position-sticky bottom-0 bg-white">
                                    <x-admin.theme.button label="Save Setting"
                                                          spinner="saveSetting"
                                                          color="primary"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@assets
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/plugins/rangePlugin.js"></script>
@endassets

