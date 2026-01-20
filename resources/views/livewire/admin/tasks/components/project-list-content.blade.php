<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fs-6 fw-normal">
                    <span class="fw-bold">Projects - {{ $selectedCategory?->name ??'Unresolved' }}</span><br>
                    <span class="fs-8"> Showing the list of projects</span>
                </h3>
            </div>
            <div class="card-toolbar gap-3">
                <div>
                    <input type="search"
                           placeholder="Search"
                           wire:model.live="search"
                           class="form-control form-select-sm"
                    />
                </div>
                <div>
                    <select class="form-select form-select-sm"
                            wire:model.live="filter.status"
                    >
                        <option value="">All</option>
                        @foreach(\App\Models\QuickProject::$statusList as $row)
                            <option value="{{ $row ??'' }}">{{ $row ??'' }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-sm btn-success rounded-pill"
                        wire:click.prevent="openAddEditModal"
                        wire:loading.attr="disabled"
                >
                    + Add Project
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th></th>
                            <th>Project Name</th>
                            <th>Owner</th>
                            <th>Company</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Tags</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse($data as $item)
                          <tr>
                              <td></td>
                              <td>{{ $item->name ??'' }}</td>
                              <td>{{ $item->user?->fullName() ??'' }}</td>
                              <td>{{ $item->company ??'' }}</td>
                              <td>{{ $item->displayDate() }}</td>
                              <td>{{ $item->displayDate('end_date') }}</td>
                              <td>
                                  <div class="flex flex-wrap gap-2">
                                      @foreach($item->getTags() as $tag)
                                          <span class="badge badge-secondary">{{ $tag ??'' }}</span>
                                      @endforeach
                                  </div>
                              </td>
                              <td class="text-end gap-3">
                                  <a href="{{ route('admin::tasks:project.detail',['code'=>encryptOrderId($item->id)]) }}"
                                     wire:navigate
                                     class="btn btn-sm btn-primary btn-icon rounded-pill me-2"
                                  >
                                      <i class="fa fa-edit"></i>
                                  </a>
                                  <a class="btn btn-sm btn-danger btn-icon rounded-pill"
                                     href="javascript:void(0);"
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
                                      <i class="fa fa-trash"></i>
                                  </a>
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="12" class="text-center">No projects</td>
                          </tr>
                      @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <x-admin.theme.modal wire:model="editModal"
                         title="New Project"
                         description="Here you can add the details about your project"
                         size="modal-lg"
    >
        <x-slot:body>
            <form wire:submit.prevent="Submit">
                <x-input.text  wire:model="request.name"
                               label="Name"
                />
                <x-input.text-area wire:model="request.description"
                                   label="Description"
                />
                <x-input.text wire:model="request.company"
                              label="Company"
                />
                <x-input.select wire:model="request.category_id"
                                label="Category"
                >
                    <option>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name ??'' }}</option>
                         @if($category->children()->exists())
                             @foreach($category->children->sortBy('position') as $subCategory)
                                 <option value="{{ $subCategory->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $subCategory->name ??'' }}</option>
                             @endforeach
                         @endif
                    @endforeach
                </x-input.select>
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
                    />
                </div>
                <div class="my-4 text-center">
                    <x-admin.theme.button type="submit"
                                          label="Save Project"
                                          spinner="Submit"
                                          color="primary"
                                          class="me-3"
                    />
                    <x-admin.theme.button type="button"
                                          label="Close"
                                          color="dark"
                                          class="ml-2"
                                          @click="$wire.editModal = false"
                    />
                </div>
            </form>
        </x-slot:body>
    </x-admin.theme.modal>
</div>

@assets
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/plugins/rangePlugin.js"></script>
@endassets
