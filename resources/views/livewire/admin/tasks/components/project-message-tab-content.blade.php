<div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header px-4 py-2">
                    <div class="card-title">
                        <h3 class="fs-6 fw-normal">
                            <span class="fw-bold">Categories</span>
                        </h3>
                    </div>
                </div>
                <div class="card-body px-2 py-2">
                    <ul class="list-group task-list-group">
                        <li class="list-group-item mb-2 border rounded {{ $selectedCategory == null?'current':'' }}">
                            <div class="d-flex justify-content-between">
                                <div wire:click.prevent="changeCurrentList" class="task-list-title">
                                    All Messages
                                </div>
                                <div class="text-end">
                                    {{ $totalCount ??0 }}
                                </div>
                            </div>
                        </li>
                        @foreach([] as $category)
                            <li class="list-group-item mb-2 border rounded {{ $selectedCategory == $category->id?'current':'' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="task-list-title" wire:click.prevent="changeCurrentList({{ $category->id }})">
                                        {{ $category->name ??'' }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            {{-- Message Box --}}
            <div class="card {{ $editMessage?'d-none':'' }}">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="fs-6 fw-normal">
                            <span class="fw-bold">Messages List</span><br>
                            <span class="fs-8">Showing the list of messages</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <x-admin.theme.button icon="fa fa-plus"
                                              color="primary"
                                              class="btn-sm rounded-pill"
                                              label="Add a Message"
                                              wire:click.prevent="openAddEditMessageModal"
                                              wire:loading.attr="disabled"
                        />
                    </div>
                </div>
                <div class="card-body">
                    @forelse($data as $item)
                        <div>
                            <div class="p-5 mt-2 rounded bg-light-primary text-dark fw-semibold text-start" data-kt-element="message-text">
                                <div class="d-flex justify-content-between gap-2">
                                    <div class="d-flex gap-3 align-items-center">
                                        <div>
                                            <img src="{{ $item->user->avatarUrl() }}" class="rounded-circle h-45px w-45px object-fit-cover" />
                                        </div>
                                        <div class="text-wrap">
                                            <div class="d-flex gap-2">
                                                <span><b>{{ $item->user->fullName() }}</b></span>
                                                <div class="d-flex flex-wrap">
                                                    @if(checkData($item->user->company))
                                                        <div>
                                                            <i class="fa fa-building me-1"></i><span>{{ $item->user->company ??'' }}</span> &nbsp;&nbsp;-&nbsp;&nbsp;
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <i class="fa fa-user-check"></i> <span>{{ $item->user->roleName() ??$item->user->userType() }}</span>
                                                    </div>
                                                </div>
                                                <span>&nbsp;-&nbsp;Posted {{ $item->postDate() }}</span>
                                            </div>
                                            <span class="text-black-50">{{ $item->user->email ??'' }}</span>
                                        </div>
                                    </div>
                                    <div>
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
                                                        $wire.openAddEditMessageModal(id);
                                                    },
                                                    deleteMessage:function(id){
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
                                                              $wire.destroy(id)
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
                                                <div  class="menu menu-sub show menu-sub-dropdown menu-column py-3 menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                           class="menu-link px-3"
                                                           @click="openEditModal('{{ $item->id }}')"
                                                        >Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                           class="menu-link px-3"
                                                           @click="deleteMessage('{{ $item->id }}')"
                                                        >Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="px-3 py-2">
                                    <span><b>{{ $item->subject ??'' }}</b></span>
                                    <div class="my-2">
                                        {!! $item->content ??'' !!}
                                    </div>
                                    <div class="my-2">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($item->getFiles() as $file)
                                                <div class="h-125px w-150px  text-center align-items-center border border-dashed border-dark p-3 rounded-3">
                                                    <p>
                                                        {{ $file['name'] ??'' }}
                                                    </p>
                                                    <a href="{{ asset($file['file'] ??'') }}"
                                                       target="_blank"
                                                       class="btn btn-icon btn-primary rounded-pill">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">
                            No message found
                        </p>
                    @endforelse
                </div>
                <div class="card-footer">
                    {{ $data->links() }}
                </div>
            </div>
            {{-- Message Add --}}
            <div class="{{ $editMessage?'':'d-none' }}">
               <form wire:submit.prevent="Submit">
                   <div class="card">
                       <div class="card-header">
                           <div class="card-title">
                               <h3 class="fs-6 fw-normal">
                                   <span class="fw-bold">Post a New Message</span><br>
                                   <span class="fs-8">Here you can change the message details</span>
                               </h3>
                           </div>
                           <div class="card-toolbar">
                               <button type="button"
                                       class="btn btn-sm btn-light-dark rounded-pill"
                                       wire:click.prevent="backToMessage"
                                       wire:loading.attr="disabled"
                               >
                                   <i class="fa fa-arrow-left"></i> Back to Messages
                               </button>
                           </div>
                       </div>
                       <div class="card-body">
                           <x-input.text wire:model="request.subject"
                                         label="Subject"
                           />
                           <div class="form-group mb-3">
                               <label class="form-label">Message Detail</label>
                               <x-editor.c-k-editor5 wire:model="request.content"
                                                     data-update="addMessageTextEditor"
                               />
                           </div>
                           <div class="form-group mt-3 mb-3">
                               <label class="form-label">Files</label>
                               <div class="row">
                                   <div class="col-md-5">
                                       <x-admin.forms.file-pond-multiple  folder="doc/"
                                                                          accept="application/*,image/*,video/*"
                                                                          type="files"
                                       />
                                   </div>
                                   <div class="col-md-7">
                                       @foreach($request['files'] as $i=>$item)
                                           <div class="row mb-2">
                                               <div class="col-md-5">
                                                   <input type="text"
                                                          wire:model="request.files.{{ $i }}.name"
                                                          class="form-control form-control-sm"
                                                   />
                                               </div>
                                               <div class="col-md-4">
                                                   <div class="d-flex gap-3">
                                                       <button type="button"
                                                               class="btn btn-sm btn-icon btn-primary rounded-pill"
                                                               onclick="window.open('{{ asset($item['file'] ??'') }}','_blank')"
                                                       >
                                                           <i class="fa fa-download"></i>
                                                       </button>
                                                       <button type="button"
                                                               class="btn btn-sm btn-icon btn-danger rounded-pill"
                                                               wire:click.prevent="removeDocumentItem({{$i}},'files')"
                                                               wire:loading.attr="disabled"
                                                       >
                                                           <i class="fa fa-xmark"></i>
                                                       </button>
                                                   </div>
                                               </div>
                                           </div>
                                       @endforeach
                                   </div>
                               </div>
                           </div>
                           <div class="form-group mb-5">
                               <label class="form-label">Tags</label>
                               <x-forms.tag wire:model="request.tags"
                                            label="Tags"
                               />
                           </div>
                           <x-admin.forms.toggle-switch wire:model="request.notified"
                                                        :checked="(bool) $request['notified']"
                                                        label="Notify with email"
                                                        value="1"
                           />
                       </div>
                       <div class="card-footer">
                           <x-admin.theme.button label="Post Message"
                                                 color="success"
                                                 spinner="Submit"
                                                 type="submit"
                           />
                           <x-admin.theme.button label="Cancel"
                                                 type="button"
                                                 wire:click.prevent="backToMessage"
                                                 wire:loading.attr="disabled"
                           />
                       </div>
                   </div>
               </form>
            </div>
        </div>
    </div>
</div>
