<div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header px-4 py-2">
                    <div class="card-title">
                        <h3 class="fs-6 fw-normal">
                            <span class="fw-bold">Task List</span><br>
                            <span class="fs-8">Showing the task category</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <x-admin.theme.button icon="fa fa-plus"
                                              color="success"
                                              class="btn-sm rounded-pill"
                                              label="Add"
                                              wire:click.prevent="openAddEditTaskModal"
                                              wire:loading.attr="disabled"
                        />
                    </div>
                </div>
                <div class="card-body px-2 py-2">
                    <ul class="list-group task-list-group">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="w-100">
                                <li class="list-group-item mb-2 border rounded {{ $selectedCategory == null?'current':'' }}">
                                    <div class="d-flex justify-content-between">
                                        <div wire:click.prevent="changeCurrentList" class="task-list-title">
                                            All Lists
                                        </div>
                                        <div class="text-end">
                                            {{ $totalCount ??0 }}
                                        </div>
                                    </div>
                                </li>
                            </div>
                            <div style="visibility: hidden">
                                <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end h-auto w-auto"
                                        type="button"
                                >
                                    <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </button>
                            </div>
                        </div>
                        @foreach($categories as $category)
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div class="w-100">
                                    <li class="list-group-item mb-2 border rounded {{ $selectedCategory == $category->id?'current':'' }}">
                                        <div class="d-flex justify-content-between align-items-center gap-2">
                                            <div class="task-list-title text-wrap" wire:click.prevent="changeCurrentList({{ $category->id }})">
                                                {{ $category->name ??'' }}
                                            </div>
                                            <div class="d-flex gap-3 align-items-center">
                                            <span>
                                                {{ $category->tasks()->count() }}
                                            </span>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div>
                                    <div class="task-list-actions">
                                        <div
                                            x-data="{
                                                    open: false,
                                                    toggle() {
                                                        if (this.open) {
                                                            return this.close()
                                                        }

                                                        this.$refs.button.focus()

                                                        this.open = true
                                                    },
                                                    close(focusAfter) {
                                                        if (! this.open) return

                                                        this.open = false

                                                        focusAfter && focusAfter.focus()
                                                    },
                                                    openEditModal:function(id){
                                                        this.open = false;
                                                        $wire.openAddEditTaskModal(id);
                                                    },
                                                    deleteTaskList:function(id){
                                                         this.open = false;
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
                                                              $wire.destroyTaskList(id)
                                                            }
                                                        });
                                                    }
                                                }"
                                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                            x-id="['dropdown-button']"
                                            class="position-relative"
                                        >
                                            <!-- Button -->
                                            <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end h-auto w-auto"
                                                    x-ref="button"
                                                    x-on:click="toggle()"
                                                    :aria-expanded="open"
                                                    :aria-controls="$id('dropdown-button')"
                                                    type="button"
                                            >
                                                <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </button>

                                            <!-- Panel -->
                                            <div
                                                x-ref="panel"
                                                x-show="open"
                                                x-transition.origin.top.left
                                                x-on:click.outside="close($refs.button)"
                                                :id="$id('dropdown-button')"
                                                style="display: none;"
                                                class="position-absolute left-0 mt-2 w-40px rounded-md bg-white shadow-md z-10"
                                            >
                                                <div  class="menu menu-sub show menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Actions</div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator mb-3 opacity-75"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                           class="menu-link px-3"
                                                           @click="openEditModal('{{ $category->id }}')"
                                                        >Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                           class="menu-link px-3"
                                                           @click="deleteTaskList('{{ $category->id }}')"
                                                        >Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
                <div class="card-header px-4 py-2 border-top">
                    <div class="card-title">
                        <h3 class="fs-6 fw-normal">
                            <span class="fw-bold">Completed Tasks List</span>
                        </h3>
                    </div>
                </div>
                <div class="card-body px-2 py-2">
                    <ul class="list-group task-list-group">
                        @forelse($completedCategories as $category)
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div class="w-100">
                                    <li class="list-group-item mb-2 border rounded {{ $selectedCategory == $category->id?'current':'' }}">
                                        <div class="d-flex justify-content-between align-items-center gap-2">
                                            <div class="task-list-title text-wrap text-decoration-line-through" wire:click.prevent="changeCurrentList({{ $category->id }})">
                                                {{ $category->name ??'' }}
                                            </div>
                                            <div class="d-flex gap-3 align-items-center">
                                            <span>
                                                {{ $category->tasks()->count() }}
                                            </span>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div>
                                    <div class="task-list-actions">
                                        <div
                                            x-data="{
                                                    open: false,
                                                    toggle() {
                                                        if (this.open) {
                                                            return this.close()
                                                        }

                                                        this.$refs.button.focus()

                                                        this.open = true
                                                    },
                                                    close(focusAfter) {
                                                        if (! this.open) return

                                                        this.open = false

                                                        focusAfter && focusAfter.focus()
                                                    },
                                                    openEditModal:function(id){
                                                        this.open = false;
                                                        $wire.openAddEditTaskModal(id);
                                                    },
                                                    deleteTaskList:function(id){
                                                         this.open = false;
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
                                                              $wire.destroyTaskList(id)
                                                            }
                                                        });
                                                    }
                                                }"
                                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                            x-id="['dropdown-button']"
                                            class="position-relative"
                                        >
                                            <!-- Button -->
                                            <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end h-auto w-auto"
                                                    x-ref="button"
                                                    x-on:click="toggle()"
                                                    :aria-expanded="open"
                                                    :aria-controls="$id('dropdown-button')"
                                                    type="button"
                                            >
                                                <i class="ki-duotone ki-dots-square fs-1 text-gray-400 me-n1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </button>

                                            <!-- Panel -->
                                            <div
                                                x-ref="panel"
                                                x-show="open"
                                                x-transition.origin.top.left
                                                x-on:click.outside="close($refs.button)"
                                                :id="$id('dropdown-button')"
                                                style="display: none;"
                                                class="position-absolute left-0 mt-2 w-40px rounded-md bg-white shadow-md z-10"
                                            >
                                                <div  class="menu menu-sub show menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Actions</div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator mb-3 opacity-75"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                           class="menu-link px-3"
                                                           @click="openEditModal('{{ $category->id }}')"
                                                        >Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                           class="menu-link px-3"
                                                           @click="deleteTaskList('{{ $category->id }}')"
                                                        >Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <li class="list-group-item  border rounded">
                                No data found
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="fs-6 fw-normal">
                            <span class="fw-bold">Todo</span><br>
                            <span class="fs-8">Showing the all the todo activity</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <x-admin.theme.button icon="fa fa-plus"
                                              color="primary"
                                              class="btn-sm rounded-pill"
                                              label="Add Todo"
                                              wire:click.prevent="openAddEditTaskMainModal"
                                              wire:loading.attr="disabled"
                        />
                    </div>
                </div>
                <div class="card-body"
                     x-data="{
                        editInline:@entangle('editInlineTask'),
                        request:@entangle('request'),
                        toggleMore:function(id){
                           $wire.toggleMore(id);
                        }
                     }"
                     x-cloak
                >
                    @if($data->count()>0)
                        <ul class="list-group">
                            @foreach($data as $item)
                                <li class="list-group-item rounded-3 mb-3 border">
                                    <div class="d-flex gap-2">
                                        <div>
                                            <button type="button"
                                                    class="btn btn-icon {{ $item->is_completed?'btn-light-success':'btn-light' }} btn-sm rounded-pill"
                                                    wire:click.prevent="markAsCompleted({{ $item->id }})"
                                                    wire:loading.attr="disabled"
                                            >
                                                <i class="fa fa-check fs-6"></i>
                                            </button>
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <div>
                                                   <span class="{{ $item->is_completed?'text-decoration-line-through':'' }}">
                                                        {{ Str::limit($item->name ??'',100) }}
                                                   </span>
                                                    <a href="javascript:void(0)"
                                                       class="fs-8 ms-3"
                                                       @click="toggleMore('{{ $item->id }}')"
                                                       wire:key="_task_todo_{{ $item->id }}"
                                                    >
                                                <span x-show="editInline == true && request.id && request.id == '{{ $item->id }}'">
                                                    Less
                                                </span>
                                                        <span x-show="editInline == false || (request.id == 'undefined' || request.id != '{{ $item->id }}')">
                                                    More
                                                </span>
                                                    </a>
                                                    &nbsp;&nbsp;
                                                    <a href="javascript:void(0)"
                                                       class="text-decoration-none text-black-50"
                                                       @click=""
                                                    >
                                                        {{ $item->displayDate() ??'mm/dd/yy' }} - {{ $item->displayDate(false) ??'mm/dd/yy' }}
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm btn-icon btn-light-danger rounded-pill"
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
                                                          @this.destroyTask('{{$item->id}}')
                                                        }
                                                    });
                                                   "
                                                    >
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @if($editInlineTask && Arr::has($request,'id') && $request['id'] == $item->id)
                                    <div class="my-2">
                                        <div class="border border-dashed bg-light px-4 py-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fs-7">
                                                    Todo Title
                                                </label>
                                                <input type="text"
                                                       class="form-control form-control-sm"
                                                       wire:model="request.name"
                                                       maxlength="255"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fs-7">
                                                            Start Date
                                                        </label>
                                                        <input type="date"
                                                               class="form-control form-control-sm"
                                                               wire:model="request.start_date"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fs-7">
                                                            End Date
                                                        </label>
                                                        <input type="date"
                                                               class="form-control form-control-sm"
                                                               wire:model="request.end_date"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fs-7">
                                                    Provide a detailed description for the task (optional)
                                                </label>
                                                <textarea wire:model="request.content"
                                                          class="custom-text-editor"
                                                ></textarea>
                                            </div>
                                            <div class="d-flex gap-3">
                                                <x-admin.theme.button label="Save"
                                                                      class="btn-sm"
                                                                      color="primary"
                                                                      wire:click.prevent="SaveTask"
                                                                      spinner="SaveTask"
                                                />
                                                <x-admin.theme.button label="Cancel"
                                                                      color="dark"
                                                                      class="btn-sm"
                                                                      wire:click.prevent="closeTaskInline"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-0">
                            No data found
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-admin.theme.modal wire:model="editModel"
                         title="{{ Arr::has($categoryRequest,'id')?'Edit':'New' }} Task List"
    >
        <x-slot:body>
            <form wire:submit.prevent="Submit">
                <x-input.text wire:model="categoryRequest.name"
                              label="Name"
                />
                <x-input.text-area wire:model="categoryRequest.description"
                                   label="Description"
                />
                <div class="row">
                    <div class="col-md-6">
                        <x-input.select wire:model="categoryRequest.status"
                                        label="Status"
                        >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-input.select>
                    </div>
                    <div class="col-md-6">
                        <x-input.text wire:model="categoryRequest.position"
                                      label="Position"
                                      type="number"
                                      min="0"
                                      max="5000"
                        />
                    </div>
                </div>
                <div class="my-3 text-center ">
                    <x-admin.theme.button label="Submit"
                                          color="primary"
                                          class="me-3"
                                          spinner="Submit"
                    />
                    <x-admin.theme.button label="Cancel"
                                          @click="$wire.editModel = false"
                                          type="button"

                    />
                </div>
            </form>
        </x-slot:body>
    </x-admin.theme.modal>

    <x-admin.theme.modal wire:model="taskModel"
                         title="{{ Arr::has($request,'id')?'Edit':'New' }} Todo"
                         size="modal-lg"
    >
        <x-slot:body>
            <form wire:submit.prevent="SaveTask">
                <x-input.select wire:model="request.parent_id"
                                label="Task List"
                >
                    <option value="">Select Option</option>
                    @foreach(\App\Models\QuickTaskCategory::all()  as $item)
                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                    @endforeach
                </x-input.select>
                <x-input.text wire:model="request.name"
                              label="Title"
                />
{{--                <x-input.text-area wire:model="request.subject"--}}
{{--                                   label="Subject"--}}
{{--                />--}}
                <div x-data="{
                       fpInstance:null,
                       startDate:@entangle('request.start_date'),
                       endDate: @entangle('request.end_date'),
                    }"
                     x-init="
                      fpInstance = flatpickr('#startDateTask, #endDateTask', {
                           enableTime: false,
                           dateFormat: 'Y-m-d',
                           altInput: true,
                           altFormat:'m-d-Y',
                           mode: 'range',
                           plugins: [
                              rangePlugin({ input: '#endDateTask'}),
                           ],
                           onClose: function(selectedDates, dateStr, instance) {
                                startDate = selectedDates[0] ? instance.formatDate(selectedDates[0], 'Y-m-d') : null;
                                endDate = selectedDates[1] ? instance.formatDate(selectedDates[1], 'Y-m-d') : null;
                           }
                       });

                       window.addEventListener('clearFlatPickerTaskRange',()=>{
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
                                   id="startDateTask"
                                   readonly
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="text"
                                   class="form-control modal-date-picker"
                                   id="endDateTask"
                                   readonly
                            />
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="fs-7">Provide a detailed description for the task (optional)</label>
                    <textarea wire:model="request.content"
                              class="custom-text-editor"
                    ></textarea>
                </div>
                <div class="my-3 text-center ">
                    <x-admin.theme.button label="Save"
                                          color="primary"
                                          class="me-3"
                                          spinner="SaveTask"
                    />
                    <x-admin.theme.button label="Cancel"
                                          @click="$wire.taskModel = false"
                                          type="button"

                    />
                </div>
            </form>
        </x-slot:body>
    </x-admin.theme.modal>
</div>


@assets
<style>
    .task-list-group li{
        transition: 0.1s linear;
        font-size: 12px;
    }
    .task-list-group li.current{
        border-left: 3px solid var(--bg-site-blue-seconday) !important;
    }
    .task-list-group li.current .task-list-title{
        font-weight: bold;
    }
    .task-list-group li .task-list-title:hover{
        cursor: pointer;
        font-weight: bold;
    }

    .task-container{
        border: 1px dashed #f2f2f2;
    }

    .task-header{
        border-bottom: 1px solid #f2f2f2;
        padding: 10px 20px;
    }
    .task-body{
        padding: 10px 20px;

    }
    .z-10{
        z-index: 99;
    }
    .custom-text-editor{
        width: 100%;
        min-height: 200px;
        border: 1px solid #f2f2f2;
        padding: 20px 10px;
    }
    .custom-text-editor:focus{
        outline: none;
        border: 1px solid #f2f2f2!important;
    }
    /*.task-list-actions{*/
    /*    display: none!important;*/
    /*}*/
    /*.list-group-item:hover .task-list-actions{*/
    /*    display: block!important;*/
    /*}*/
</style>
@endassets
