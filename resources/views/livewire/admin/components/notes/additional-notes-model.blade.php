<div>
    <x-admin.theme.modal wire:model="noteModal"
                         title="Additional Notes"
                         description="Here you can add or update additional notes"
                         size="modal-xl"
    >
       <x-slot:body>
           <div class="row">
               <div class="col-md-4 border-end mb-3 mb-md-0 order-2 order-md-1">
                   <div>
                       <div class="px-2 py-3 border">
                           <div class="d-flex justify-content-between align-items-center">
                              <div>
                                  <span class="fs-6 fw-bold">
                                        Recent Notes
                                  </span><br>
                                  <span class="fs-7">
                                      Showing the list of recent notes
                                  </span>
                              </div>
                               <div>
                                   @if(Arr::has($request,'id'))
                                       <button class="btn btn-sm btn-success btn-icon rounded-pill"
                                               wire:click.prevent="NewRequest"
                                               data-bs-target="tooltip"
                                               data-bs-title="New Note"
                                               title="New Note"
                                       >
                                           <i class="fa fa-plus"></i>
                                       </button>
                                   @endif
                               </div>
                           </div>
                       </div>
                       <div class="px-2 py-3 border overflow-y-scroll" style="max-height:300px">
                           <ul class="list-group add-note-group">
                               @forelse($data as $item)
                                   <li class="list-group-item {{ Arr::has($request,'id') && $request['id'] == $item->id?'active':'' }}">
                                       <a href="javascript:void(0)"
                                          class="custom-link-hover w-75"
                                          wire:click.prevent="openEditNote({{ $item->id }})"
                                       >
                                           {{ $item->getNoteTitle(25) }}
                                       </a>
                                       <span class="float-end">
                                           <a class="text-danger"
                                              href="javascript:void(0)"
                                              wire:confirm="Are you sure? you want to delete this note!"
                                              wire:click.prevent="destroy({{ $item->id }})"
                                           >
                                               <i class="fa fa fa-xmark text-danger"></i>
                                           </a>
                                       </span>
                                   </li>
                               @empty
                                   <li class="list-group-item">
                                       No Notes
                                   </li>
                               @endforelse
                           </ul>
                       </div>
                       <div class="text-center">
                           @if($data->total()>$limit)
                               <x-admin.theme.button type="button"
                                                     label="Load More"
                                                     color="light"
                                                     class="btn-sm rounded-pill"
                                                     spinner="loadMore"
                                                     wire:click.prevent="loadMore"
                               />
                           @endif
                       </div>
                   </div>
               </div>
               <div class="col-md-8 order-1 order-md-2">
                   <div class="py-3 px-2 border">
                       <div class="d-flex justify-content-between align-items-center">
                           <div class="fs-6 fw-bold">
                               {{ Arr::has($request,'id')?'Edit':'New' }} Note
                           </div>
                       </div>
                   </div>
                   <form wire:submit.prevent="saveNote">
                       <div class="px-2 py-3 border">
                           @if(checkData($request['claim_id']))
                               <div class="form-group mb-3">
                                   <label class="form-label">Claim</label>
                                   <input class="form-control"
                                          value="{{ FilterHelper::displayClaimNoteTitle($request['claim_id'] ??null) ??'' }}"
                                          disabled
                                   />
                               </div>
                           @endif
                           <x-input.text wire:model="request.title"
                                         label="Title"
                           />
                           <x-input.text-area wire:model="request.note"
                                              label="Note"
                                              class="form-control bg-white border "
                                              rows="6"
                           />
                           <x-admin.theme.button type="submit"
                                                 color="primary"
                                                 class="btn-sm"
                                                 label="Save"
                                                 spinner="saveNote(false)"
                           />
                           <x-admin.theme.button color="secondary"
                                                 class="btn-sm"
                                                 label="Save & Close"
                                                 spinner="saveNote(true)"
                                                 type="button"
                                                 wire:click.prevent="saveNote(true)"
                           />
                       </div>
                   </form>
               </div>
           </div>
       </x-slot:body>
    </x-admin.theme.modal>
</div>

@assets
<style>
    .add-note-group .active a{
        color: white!important;
    }
    .add-note-btn-remove{
        color: red!important;
    }
</style>
@endassets
