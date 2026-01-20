@section('title','Setting | Mail')
<div>
    <div wire:ignore>
        {!! AdminBreadCrumb::Load(['title'=>trans('Mail Settings'),'menu'=>[ ['name'=>trans('Settings')],['name'=>trans('Mail'),'active'=>true] ]]) !!}
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
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label text-lg-end">{{trans('Mail Host')}}</label>
                            <div class="col-lg-9 col-xl-4">
                                <input type="text"
                                       wire:model="request.mail_host"
                                       class="form-control form-check-sm @error('request.mail_host') is-invalid @enderror"
                                       autocomplete="off"
                                       placeholder=""
                                />
                                @error('request.mail_host') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label text-lg-end">{{trans('Mail UserName')}}</label>
                            <div class="col-lg-9 col-xl-4">
                                <input type="text"
                                       wire:model="request.mail_username"
                                       class="form-control form-check-sm @error('request.mail_username') is-invalid @enderror"
                                       autocomplete="off"
                                       placeholder=""
                                />
                                @error('request.mail_username') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label text-lg-end">{{trans('Mail Password')}}</label>
                            <div class="col-lg-9 col-xl-4">
                                <input type="password"
                                       wire:model="request.mail_password"
                                       class="form-control form-check-sm @error('request.mail_password') is-invalid @enderror"
                                       autocomplete="off"
                                       placeholder=""
                                />
                                @error('request.mail_password') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label text-lg-end">{{trans('Mail Address')}}</label>
                            <div class="col-lg-9 col-xl-4">
                                <input type="text"
                                       wire:model="request.mail_address"
                                       class="form-control form-check-sm @error('request.mail_address') is-invalid @enderror"
                                       autocomplete="off"
                                       placeholder=""
                                />
                                @error('request.mail_address') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label text-lg-end">{{trans('Mail Encryption')}} <br> <span class="small">({{trans('SSL or TLS')}})</span></label>
                            <div class="col-lg-9 col-xl-4">
                                <input type="text"
                                       wire:model="request.mail_encryption"
                                       class="form-control form-check-sm @error('request.mail_encryption') is-invalid @enderror"
                                       autocomplete="off"
                                       placeholder=""
                                />
                                @error('request.mail_encryption') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label text-lg-end">{{trans('Mail Port')}} <br> <span class="small">({{trans('465 or 587')}})</span></label>
                            <div class="col-lg-9 col-xl-4">
                                <input type="text"
                                       wire:model="request.mail_port"
                                       class="form-control form-check-sm @error('request.mail_port') is-invalid @enderror"
                                       autocomplete="off"
                                       placeholder=""
                                />
                                @error('request.mail_port') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                        </div>
                        <!--end::Row-->
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
