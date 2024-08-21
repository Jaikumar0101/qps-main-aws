@section('title','Setting | Scripts - Custom JS & CSS')
<div>
    <div wire:ignore>
        {!! AdminBreadCrumb::Load(['title'=>trans('Custom CSS & JS'),'menu'=>[ ['name'=>trans('Settings')],['name'=>trans('Scripts')],['name'=>trans('Custom')] ]]) !!}
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card mb-3">
                <!--begin::Header-->
                <div class="card-header card-header-stretch overflow-auto">
                    <!--begin::Tabs-->
                    <ul class="nav nav-stretch nav-line-tabs fw-semibold border-transparent flex-nowrap" role="tablist" id="kt_layout_builder_tabs" wire:ignore>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_builder_main" role="tab" aria-selected="true">{{trans('Custom CSS')}}</a>
                        </li>
                    </ul>
                    <!--end::Tabs-->
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form class="form" wire:submit.prevent="saveCustomCss">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-3">
                            <!--begin::Tab pane-->
                            <div class="tab-pane active show" id="kt_builder_main" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="mb-10">
                                    <x-forms.code-mirror wire:model.defer="customCss" />
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer py-8">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-9 d-flex">
                                {!! AdminTheme::Spinner(['target'=>'saveCustomCss']) !!}
                            </div>
                        </div>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
            <div class="card">
                <!--begin::Header-->
                <div class="card-header card-header-stretch overflow-auto">
                    <!--begin::Tabs-->
                    <ul class="nav nav-stretch nav-line-tabs fw-semibold border-transparent flex-nowrap" role="tablist" id="kt_layout_builder_tabs_script" wire:ignore>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_builder_script" role="tab" aria-selected="true">{{trans('Custom JS')}}</a>
                        </li>
                    </ul>
                    <!--end::Tabs-->
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form class="form" wire:submit.prevent="saveCustomJs">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-3">
                            <!--begin::Tab pane-->
                            <div class="tab-pane active show" id="kt_builder_script" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="mb-10">
                                    <x-forms.code-mirror wire:model.defer="customJs" />
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer py-8">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-9 d-flex">
                                {!! AdminTheme::Spinner(['target'=>'saveCustomJs']) !!}
                            </div>
                        </div>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>

</div>
