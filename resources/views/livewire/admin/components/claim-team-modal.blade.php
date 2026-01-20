<div>
    <div class="modal fade modal-close-out"
         id="assignTeamModal"
         tabindex="-1"
         data-bs-backdrop="static"
         wire:ignore.self
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span>{{ $insuranceClaim?->ins_name ??null }}</span><br>
                        <span class="small">{{ $insuranceClaim?->patent_name ??null }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="Submit">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-5 border-end">
                                <div class="p-3">
                                    <div class="mb-5">
                                        <input type="search"
                                               wire:model.live="search"
                                               class="form-control"
                                               placeholder="Search"
                                        />
                                    </div>
                                    @forelse($data as $item)
                                        <div class="d-flex justify-content-between align-middle justify-items-center">
                                            <div class="d-flex gap-3">
                                                <div>
                                                    <img src="{{ $item->avatarUrl() }}" height="45" width="45" class="rounded-full" />
                                                </div>
                                                <div>
                                                    <b>{{ $item->fullName() ??'' }}</b><br>
                                                    <span class="text-black-50">{{ $item->email ??'--' }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                @if(in_array($item->id,$selectedUsers))
                                                    <button class="btn btn-sm btn-light-danger"
                                                            wire:click.prevent="removeUser({{ $item->id }})"
                                                            wire:loading.attr="disabled"
                                                    >
                                                        Remove access
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-light-primary"
                                                            wire:click.prevent="assignUser({{ $item->id }})"
                                                            wire:loading.attr="disabled"
                                                    >
                                                        Assign
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="my-3 border border-dashed"></div>
                                    @empty
                                        <p class="my-3">No members</p>
                                    @endforelse
                                    <div class="mt-3">
                                        {{ $data->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h3 class="col-form-label">Selected Team Members</h3>
                                <div class="p-3 row gap-4">
                                    @foreach(\App\Models\User::getInOrder($selectedUsers,true) as $item)
                                        <div class="d-flex justify-content-between align-middle justify-items-center">
                                            <div class="d-flex gap-3">
                                                <div>
                                                    <img src="{{ $item->avatarUrl() }}" height="45" width="45" class="rounded-full" />
                                                </div>
                                                <div>
                                                    <b>{{ $item->fullName() ??'' }}</b><br>
                                                    <span class="text-black-50">{{ $item->email ??'--' }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-light-danger"
                                                        wire:click.prevent="removeUser({{ $item->id }})"
                                                        wire:loading.attr="disabled"
                                                >
                                                    Remove access
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="Submit">
                            <span wire:loading.remove wire:target="Submit">Save</span>
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
    window.addEventListener('openClaimTeamAssignModal',()=>{
        $('#assignTeamModal').modal('show');
    })
    window.addEventListener('hideClaimTeamAssignModal',()=>{
        $('#assignTeamModal').modal('hide');
    })
</script>
@endscript
