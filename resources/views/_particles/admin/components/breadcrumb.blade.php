<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6" wire:ignore>
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container {{ Arr::has($data,'full-width')?'container-fluid':'container-xxl' }} d-flex flex-stack">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ $data['title'] ??'' }}</h1>
            <!--end::Title-->
            @if(Arr::has($data,'menu') && count($data['menu'])>0)
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin::dashboard') }}" wire:navigate class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    @foreach($data['menu'] as $i=>$item)
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
            @if(Arr::has($data,'actions'))
                @foreach($data['actions'] as $item)
                    <!--begin::Secondary button-->
                    <a href="{{ $item['url'] ??'#' }}" wire:navigate class="btn btn-sm fw-bold btn-{{ $item['theme'] ??'primary' }}">{!! $item['icon'] ??'' !!} {{ $item['name'] ??'' }}</a>
                    <!--end::Secondary button-->
                @endforeach
            @endif
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->

