@section('title','Administrator | Roles')
<div>
    <div wire:ignore>
        {!!
            AdminBreadCrumb::Load([
            'title'=>trans('Team Member Access'),
            'menu'=>[ ['name'=>trans('Team')],['name'=>trans('Access')],['name'=>trans('List'),'active'=>true] ],
            'actions'=>[ ['name'=>'Back to list','url'=>back()->getTargetUrl()] ]
             ])
        !!}
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card position-relative">
                <div class="position-sticky top-0 bg-white">
                    <div class="card-header border-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">Team Access</span>
                            <span class="text-muted fw-semibold fs-7">Here you can assign claims & clients to team member</span>
                        </h3>
                        <div class="card-toolbar">
                            <div class="d-flex gap-3">
                                <img src="{{ $user->avatarUrl() }}" height="45" width="45" class="rounded-lg" />
                                <div class="pt-2">
                                    <h4 class="fs-6 fw-normal"><b>{{ $user->fullName() }} </b><br> {{ $user->email ??'' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="card-title">
                            <input type="search"
                                   wire:model.live="search"
                                   class="form-control"
                                   placeholder="Search Client"
                            />
                        </div>
                        <div class="card-toolbar gap-3">
{{--                            <button class="btn btn-dark">--}}
{{--                                <i class="fa fa-users me-2"></i>Assign Multiple Clients--}}
{{--                            </button>--}}
                            <button class="btn btn-info"
                                    wire:click.prevent="saveRoleAccess"
                                    wire:loading.attr="disabled"
                            >
                                <span wire:loading wire:target="saveRoleAccess" class="me-2 spinner-border spinner-border-sm"></span>
                                <span>Save Role Access</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="border border-secondary p-4 rounded-3">
                                @forelse($clients as $client)
                                    <div class="d-flex justify-content-between align-middle justify-items-center">
                                        <div class="d-flex gap-3">
                                            <div>
                                                <img src="{{ $client->imageUrl() }}" height="45" width="45" class="rounded-full" />
                                            </div>
                                            <div>
                                                <b>{{ $client->last_name ??'' }}</b><br>
                                                <span class="text-black-50">{{ $client->email ??'--' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            @if(in_array($client->id,$requestClients))
                                                <button class="btn btn-sm btn-light-danger"
                                                        wire:click.prevent="removeClient({{ $client->id }})"
                                                        wire:loading.attr="disabled"
                                                >
                                                    Remove access
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-light-primary"
                                                        wire:click.prevent="assignClient({{ $client->id }})"
                                                        wire:loading.attr="disabled"
                                                >
                                                    Assign
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="my-2 border border-dashed"></div>
                                @empty
                                    <p class="my-3">No clients</p>
                                @endforelse
                                <div class="mt-3 client-pagination">
                                    {{ $clients->links() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="border border-secondary p-4 rounded-3">
                                @forelse(\App\Models\Customer::getInOrder($requestClients) as $item)
                                    <div class="card shadow-none border rounded-0 mb-3"
                                         x-data="{
                                            show:false,
                                            toggleDropdown:function(){
                                               this.show = !this.show;
                                            }
                                         }"
                                         x-cloak
                                    >
                                        <div class="card-header px-3">
                                            <div class="card-title">
                                                <div class="d-flex gap-3">
                                                    <div>
                                                        <img src="{{ $item->imageUrl() }}" height="45" width="45" class="rounded-full" />
                                                    </div>
                                                    <div>
                                                        <b>{{ $item->last_name ??'' }}</b><br>
                                                        <span class="text-black-50">{{ $item->email ??'--' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-toolbar gap-3">
                                                <button class="btn btn-sm btn-light-primary"
                                                >
                                                    {{ $item->leads()->count() ??0 }} Claims
                                                </button>
                                                <button class="btn btn-sm btn-light-danger"
                                                        wire:confirm="Are you sure you want to remove this client access ?"
                                                        wire:click.prevent="removeClient({{ $item->id }})"
                                                        wire:loading.attr="disabled"
                                                >
                                                    Remove access
                                                </button>
                                                <button class="btn btn-icon btn-sm btn-light-primary"
                                                        @click="toggleDropdown"
                                                >
                                                    <i class="fa fa-angle-down" x-show="!show"></i>
                                                    <i class="fa fa-angle-up" x-show="show"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0"
                                             x-show="show"
                                        >
                                            <table class="table table-bordered gs-5" >
                                                <thead>
                                                <tr class="fw-semibold fs-8 text-gray-800">
                                                    <th>ID</th>
                                                    <th>INS Name</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Follow-Up</th>
                                                    <th class="text-end">Assign</th>
                                                </tr>
                                                @foreach($item->leads as $lead)
                                                    <tr class="fs-8 border-bottom border-dashed border-secondary">
                                                        <td>{{ $lead->code() }}</td>
                                                        <td>{{ $lead->ins_name ??'' }}</td>
                                                        <td>{{ currency($lead->total ??0) }}</td>
                                                        <td>
                                                            {{$lead->claimStatusModal?->name ??''}}
                                                        </td>
                                                        <td>
                                                            {{$lead->followUpModal?->name ??''}}
                                                        </td>
                                                        <td class="d-flex justify-content-end">
                                                            @if(Arr::has($request,$item->id) && in_array($lead->id,$request[$item->id]))
                                                                <button class="btn btn-icon btn-sm btn-light-danger fs-10"
                                                                        wire:click.prevent="removeLeadAccess('{{ $item->id }}','{{ $lead->id }}')"
                                                                        wire:loading.attr="disabled"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Remove access"
                                                                >
                                                                    <i class="fa fa-remove"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-icon btn-sm btn-light-primary fs-10 ms-3"
                                                                        wire:click.prevent="addLeadAccess('{{ $item->id }}','{{ $lead->id }}')"
                                                                        wire:loading.attr="disabled"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Assign Lead"
                                                                >
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center mb-0">
                                        No client access
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@assets
<style>
    .client-pagination .d-flex .d-sm-flex{
        display: block!important;
        text-align: center!important;
    }
</style>
@endassets
