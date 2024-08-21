<div>
    <div class="modal fade modal-close-out"
         id="assignModal"
         tabindex="-1"
         data-bs-backdrop="static"
         wire:ignore.self
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Claims</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <form wire:submit.prevent="Submit">
                   <div class="modal-body">
                       <x-forms.select2 wire:model="selectedUsers"
                                        multiple
                                        class="form-control"
                       >
                           @foreach($users as $user)
                               <option value="{{ $user->id }}">{{ $user->fullName() }} - {{ $user->email ??'' }}</option>
                           @endforeach
                       </x-forms.select2>
                       @error('selectedUsers') <span class="text-danger">{{ $message }}</span> @enderror
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">
                           <span wire:loading.remove wire:target="Submit">Submit</span>
                           <span wire:loading wire:target="Submit">
                               <span class="spinner-border spinner-border-sm"></span>
                           </span>
                       </button>
                   </div>
               </form>
            </div>
        </div>
    </div>

</div>

@script
<script>
    window.addEventListener('openAssignModal',()=>{
        $('#assignModal').modal('show');
    })
</script>
@endscript
