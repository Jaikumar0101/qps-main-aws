<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card"
                 x-data="{
                    filter:@entangle('filter'),
                    search:'',
                    changeFilter:function(filter){
                      this.filter = filter;
                    },
                    setSearch:function(){
                       $wire.search = this.search;
                    }
                 }"
                 x-cloak
            >
                <div class="card-header px-3">
                    <div class="card-title">
                        <div>
                            <div class="position-relative">
                                <input type="search"
                                       placeholder="Search by name or email"
                                       class="form-control rounded-pill min-w-lg-300px"
                                       wire:model.live="search"
                                />
                                <div class="position-absolute"
                                     style="top: 50%;right: 5px;transform: translateY(-50%);"
                                >
                                    <button class="btn btn-sm btn-icon {{ checkData($search)?'btn-danger':'btn-primary' }} rounded-pill"
                                            wire:click.prevent="resetSearch"
                                    >
                                        <span wire:loading wire:target="search">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>
                                        @if(checkData($search))
                                            <span wire:loading.remove wire:target="search">
                                                <i class="fa fa-xmark"></i>
                                            </span>
                                        @else
                                            <span wire:loading.remove wire:target="search">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        @if(count($selectedPeople)>0)
                            <div class="d-flex gap-3 me-3">
                                <button class="btn btn-sm btn-success rounded-pill"
                                        type="button"
                                        wire:click.prevent="assignMultiplePeople"
                                        wire:loading.attr="disabled"
                                >
                                   <i class="fa fa-user-check me-1"></i> Assign
                                </button>
                                <button class="btn btn-sm btn-danger rounded-pill"
                                        type="button"
                                        onclick="@this.set('selectedPeople',[])"
                                >
                                    <i class="fa fa-xmark me-1"></i> Remove
                                </button>
                            </div>
                        @endif
                        <div class="flex btn-people-group">
                            <button type="button" :class="filter?'':'active'"
                                    @click="changeFilter(false)"
                            >
                                <i class="fa fa-users"></i>
                            </button>
                            <button type="button" :class="filter?'active':''"
                                    @click="changeFilter(true)"
                            >
                                <i class="fa fa-industry"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="px-3 py-2" x-show="filter">
                    <div
                        x-data="{
                            model: @entangle('selectedCompanies'),
                            companies:@js($companies),
                            changeTag:function(tags){
                               this.model = tags;
                               $wire.$refresh()
                            }
                        }"
                        x-init="
                           new Tagify($refs.input,{
                                placeholder:'Search company',
                                enforceWhitelist: true,
                                skipInvalid: true,
                                dropdown: {
                                    closeOnSelect: false,
                                    enabled: 0,
                               },
                               whitelist: companies,
                           });
                           $($refs.input).on('change',function () {
                                let tagsArr = [];
                                try
                                {
                                    const tags = JSON.parse($(this).val());
                                    for(let i =0; i<tags.length; i++)
                                    {
                                        tagsArr.push(tags[i]['value']);
                                    }
                                }
                                catch(e){ console.log(e.message); }
                                finally{ changeTag(tagsArr)  }
                            });
                        "
                        wire:ignore
                    >
                        <input x-ref="input"  class="form-control ps-2"  />
                    </div>
                </div>
                <div class="card-body py-2 px-3">
                    @forelse($data as $item)
                        <div class="border rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-3 align-items-center">
                                    <div >
                                        <input type="checkbox"
                                               class="form-check-input form-check-sm"
                                               value="{{$item->id}}"
                                               wire:model.live="selectedPeople"
                                               wire:key="_check_assign_user_{{ $item->id }}"
                                        />
                                    </div>
                                    <div>
                                        <img src="{{ $item->avatarUrl() }}" class="rounded-circle h-45px w-45px object-fit-cover" />
                                    </div>
                                    <div class="text-wrap">
                                        <b>{{ $item->fullName() }}</b><br>
                                        <span class="text-black-50">{{ $item->email ??'' }}</span><br>
                                        <div class="d-flex flex-wrap">
                                            @if(checkData($item->company))
                                                <div>
                                                    <i class="fa fa-building me-1"></i><span>{{ $item->company ??'' }}</span> &nbsp;&nbsp;-&nbsp;&nbsp;
                                                </div>
                                            @endif
                                            <div>
                                               <i class="fa fa-user-check"></i> <span>{{ $item->roleName() ??$item->userType() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-success rounded-pill"
                                            wire:key="_user_assign_{{ $item->id }}"
                                            wire:click.prevent="assignUser({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                    >
                                      <span wire:loading wire:target="assignUser({{ $item->id }})">
                                          <span class="spinner-border spinner-border-sm me-1"></span>
                                      </span>  Assign
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">
                            No data available
                        </p>
                    @endforelse
                </div>
                <div class="card-footer">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="fs-6 fw-normal">
                            <span class="fw-bold">Assigned People</span><br>
                            <span class="fs-8">Showing the list of members who assigned to project</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="btn btn-light-danger btn-sm rounded-pill"
                                wire:confirm="Are you sure! you want to reset team people?"
                                wire:click.prevent="resetAssignedTeam"
                                wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="resetAssignedTeam">
                                <i class="fa fa-history me-1"></i>
                            </span>
                            <span wire:loading wire:target="resetAssignedTeam">
                                <i class="spinner-border spinner-border-sm me-1"></i>
                            </span>
                            Reset Team
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($assignedUsers as $item)
                        <div class="border rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-3 align-items-center">
                                    <div>
                                        <img src="{{ $item->avatarUrl() }}" class="rounded-circle h-45px w-45px object-fit-cover" />
                                    </div>
                                    <div class="text-wrap">
                                        <b>{{ $item->fullName() }}</b><br>
                                        <span class="text-black-50">{{ $item->email ??'' }}</span><br>
                                        <div class="d-flex flex-wrap">
                                            @if(checkData($item->company))
                                                <div>
                                                    <i class="fa fa-building me-1"></i><span>{{ $item->company ??'' }}</span> &nbsp;&nbsp;-&nbsp;&nbsp;
                                                </div>
                                            @endif
                                            <div>
                                                <i class="fa fa-user-check"></i> <span>{{ $item->roleName() ??$item->userType() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-warning rounded-pill"
                                            wire:key="_user_remove_{{ $item->id }}"
                                            wire:click.prevent="removeAssignedUser({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                    >
                                      <span wire:loading wire:target="removeAssignedUser({{ $item->id }})">
                                          <span class="spinner-border spinner-border-sm me-1"></span>
                                      </span>  Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">
                            No people assigned
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@assets
<style>
    .btn-people-group{
        border: 1px solid var(--bs-primary);
        border-radius: 20px;
        overflow: hidden;
    }
    .btn-people-group button{
        background-color: transparent;
        border: none;
        padding: 8px 12px;
        text-align: center;
        justify-items: center;
    }
    .btn-people-group button.active{
        background-color: var(--bs-primary);
    }
    .btn-people-group button i{
        color: var(--bs-primary);
    }
    .btn-people-group button.active i{
        color: white;
    }
</style>
@endassets
