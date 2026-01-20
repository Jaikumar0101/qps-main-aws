@section('title','Setting | Website')
<div>
    <div wire:ignore>
        {!! AdminBreadCrumb::Load(['title'=>trans('Website Settings'),'menu'=>[ ['name'=>trans('Settings'),'url'=>'#'],['name'=>trans('Website'),'active'=>true] ]]) !!}
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
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('APP ENV')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select wire:model.lazy="request.app_env"
                                                class="form-select @error('request.app_env') is-invalid @enderror"
                                        >
                                            <option value="local">Local</option>
                                            <option value="production">Production</option>
                                        </select>
                                        @error('request.app_env') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('APP URL')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model.lazy="request.app_url"
                                               class="form-control @error('request.app_url') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.app_url') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('APP TIMEZONE')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <x-forms.select2 wire:model.lazy="request.app_timezone" class="form-select form-select-sm">
                                            @foreach(\App\Models\Country::where('status',1)->get() as $item)
                                                <option value="{{$item->timezone ??''}}">{{$item->timezone ??''}}</option>
                                            @endforeach
                                        </x-forms.select2>
                                        @error('request.app_timezone') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('APP DEBUGBAR')}}</label>
                                    <div class="col-lg-9 col-xl-4 pt-3">
                                        <label class="form-check form-check-custom form-check-solid form-switch">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{isset($request['app_debug']) && $request['app_debug']?'checked':''}}
                                                   onchange="@this.set('request.app_debug',this.checked)"
                                            >
                                            <span class="form-check-label text-muted">{{isset($request['app_debug']) && $request['app_debug']?'Enable':'Disable'}}</span>
                                        </label>
                                        <div class="form-text text-muted">Enable DEBUG Mode</div>
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('HTTPS Redirect')}}</label>
                                    <div class="col-lg-9 col-xl-4 pt-3">
                                        <label class="form-check form-check-custom form-check-solid form-switch">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{isset($request['https_redirect']) && $request['https_redirect']?'checked':''}}
                                                   onchange="@this.set('request.https_redirect',this.checked)"
                                            >
                                            <span class="form-check-label text-muted">{{isset($request['https_redirect']) && $request['https_redirect']?'Enable':'Disable'}}</span>
                                        </label>
                                        <div class="form-text text-muted">Enable HTTPS Redirect</div>
                                    </div>
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
