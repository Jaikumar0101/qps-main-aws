<div>
    <div class="d-flex gap-1 flex-wrap people-row">
        @foreach($claim->users as $i=>$user)
            <div x-data="{ open: false }" @click.away="open = false" class="people-tag">
                <a href="javascript:void(0)"
                   @click="open = ! open"
                   x-ref="button"
                >
                    <img src="{{ $user->avatarUrl() }}" class="rounded-circle" height="25" width="25"  alt="{{ $user->fullName() }}"/>
                </a>
                <div x-show="open" x-anchor="$refs.button" class="bg-white p-2 border rounded-2">
                    <div class="d-flex justify-content-between gap-4">
                        <div>
                            <p class="mb-0">
                                <b>{{ $user->fullName() }}</b><br>
                                <span class="text-black-50">{{ $user->email ??'' }}</span>
                            </p>
                        </div>
                        <div>
                            <span class="bg-dark p-1 rounded text-white text-sm" style="height: fit-content">{{ $user->roleName() ??$user->userType() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="bg-white rounded-circle d-flex justify-content-center align-items-center text-center people-add-tag" style="width: 25px;height: 25px"
             @click="$wire.OpenClaimAssignModal('{{ $claim->id }}')"
        >
            <i class="fa fa-plus"></i>
        </div>
    </div>

</div>


@assets
<style>
    .people-add-tag{
        border: 1px solid #dee2e6!important;
        cursor: pointer;
        transition: 0.3s ease-in;
    }
    .people-add-tag:hover{
        box-shadow: 0 0 3px 0.005em black;
    }
</style>
@endassets
