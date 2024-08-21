@section('title','Setting | Scripts - Third Party')
<div>
    <div wire:ignore>
        {!! AdminBreadCrumb::Load(['title'=>trans('Third Party Code'),'menu'=>[ ['name'=>trans('Settings')],['name'=>trans('Scripts')],['name'=>trans('Third Party'),'active'=>true] ]]) !!}
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <!--begin::Form-->
                <form class="form" wire:submit.prevent="save">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-3">
                            <!--begin::Tab pane-->
                            <div class="tab-pane active show" id="kt_builder_main" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Google Analytics Code')}}</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <x-forms.code-mirror wire:model.defer="request.google_analytics_code" />
                                    </div>
                                </div>
                                <!--end::Row-->
                                <div class="row mb-5">
                                    <label class="col-lg-3 col-form-label text-lg-end  pt-3">Status:</label>
                                    <div class="col-lg-9 col-xl-7 pt-3">
                                        <label class="form-check form-check-custom form-check-solid form-switch">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{isset($request['google_analytics_status']) && $request['google_analytics_status']?'checked':''}}
                                                   onchange="@this.set('request.google_analytics_status',this.checked)"
                                            >
                                            <span class="form-check-label text-muted">{{isset($request['google_analytics_status']) && $request['google_analytics_status']?'Enable':'Disable'}}</span>
                                        </label>
                                        <div class="form-text text-muted">Enable Google Analytics Code</div>
                                    </div>
                                </div>

                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Third Party Code')}}</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <x-forms.code-mirror wire:model.defer="request.third_party_code" />
                                    </div>
                                </div>
                                <!--end::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end  pt-3">Status:</label>
                                    <div class="col-lg-9 col-xl-7 pt-3">
                                        <label class="form-check form-check-custom form-check-solid form-switch">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{isset($request['third_party_status']) && $request['third_party_status']?'checked':''}}
                                                   onchange="@this.set('request.third_party_status',this.checked)"
                                            >
                                            <span class="form-check-label text-muted">{{isset($request['third_party_status']) && $request['third_party_status']?'Enable':'Disable'}}</span>
                                        </label>
                                        <div class="form-text text-muted">Enable Third Party Code</div>
                                    </div>
                                </div>
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
                                {!! AdminTheme::Spinner() !!}
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
