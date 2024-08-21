@php
    $menuData = [
         'title'=>trans('Analytics'),
         'menu'=>[ ['name'=>trans('Analytics'),'url'=>'#'],['name'=>trans('Analytics'),'active'=>true] ],
         'full-width'=>true,
    ];
@endphp

<div>

    <div x-data="{
                currentTab:@entangle('currentTab'),
                changeCurrentTab:function(tab){
                  this.currentTab = tab;
                }
         }"
         x-cloak
    >
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container {{ Arr::has($menuData,'full-width')?'container-fluid':'container-xxl' }} d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3" wire:ignore>
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ $menuData['title'] ??'' }}</h1>
                    <!--end::Title-->
                    @if(Arr::has($menuData,'menu') && count($menuData['menu'])>0)
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin::dashboard') }}" wire:navigate class="text-muted text-hover-primary">Home</a>
                            </li>
                            <!--end::Item-->
                            @foreach($menuData['menu'] as $i=>$item)
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                @if(Arr::has($item,'active'))
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">{{$item['name'] ??''}}</li>
                                    <!--end::Item-->
                                @else
                                    @if(Arr::has($item,'url'))
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{$item['url']}}" wire:navigate class="text-muted text-hover-primary">{{$item['name'] ??''}}</a>
                                        </li>
                                        <!--end::Item-->
                                    @else
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">{{$item['name'] ??''}}</li>
                                        <!--end::Item-->
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                        <!--end::Breadcrumb-->
                    @endif
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <button type="button"
                            class="btn btn-sm"
                            :class="currentTab == 'claim_status'?'btn-dark':'btn-light'"
                            @click="changeCurrentTab('claim_status')"
                    >
                        Claim Status
                    </button>
                    <button type="button"
                            class="btn btn-sm"
                            :class="currentTab == 'tlf_status'?'btn-dark':'btn-light'"
                            @click="changeCurrentTab('tlf_status')"
                    >
                        TLF Days
                    </button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row">
                    <div class="col-md-12"
                         x-show="currentTab == 'claim_status'"
                    >
                        <livewire:admin.dashboard.status-bar-chart />
                    </div>
                    <div class="col-md-12"
                         x-show="currentTab == 'tlf_status'"
                    >
                        <livewire:admin.components.tlf-days-chart />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
