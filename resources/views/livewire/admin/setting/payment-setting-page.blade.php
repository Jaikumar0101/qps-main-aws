@section('title','Setting | Payment')
<div>
    <div wire:ignore>
        {!! AdminBreadCrumb::Load(['title'=>trans('Payment Settings'),'menu'=>[ ['name'=>trans('Settings')],['name'=>trans('Payment')] ]]) !!}
    </div>
    <div class="container-fluid">
        <div class="card">
            <!--begin::Header-->
            <div class="card-header card-header-stretch overflow-auto">
                <!--begin::Tabs-->
                <ul class="nav nav-stretch nav-line-tabs fw-semibold border-transparent flex-nowrap" role="tablist" id="kt_layout_builder_tabs" wire:ignore>
                    <li class="nav-item" role="presentation" onclick="changeCustomImage(1)">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_builder_main" role="tab" aria-selected="true">{{trans('RozarPay')}}</a>
                    </li>
                    <li class="nav-item" role="presentation" onclick="changeCustomImage(2)">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_header" role="tab" aria-selected="false" tabindex="-1">{{trans('Paypal')}}</a>
                    </li>
                    <li class="nav-item" role="presentation" onclick="changeCustomImage(3)">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_toolbar" role="tab" aria-selected="false" tabindex="-1">{{trans('Stripe')}}</a>
                    </li>
                    <li class="nav-item" role="presentation" onclick="changeCustomImage(4)">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_page_title" role="tab" aria-selected="false" tabindex="-1">{{trans('Paytm')}}</a>
                    </li>
                </ul>
                <!--end::Tabs-->
                <div class="float-end d-none d-lg-block pt-5" wire:ignore>
                    <img id="customImg" src="{{asset('assets/images/default/payment/Razorpay_logo.svg')}}" class="h-25px">
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="save">
                <!--begin::Body-->
                <div class="card-body">
                    <div class="tab-content pt-3">
                        <!--begin::Tab pane-->
                        <div class="tab-pane active show" id="kt_builder_main" role="tabpanel" wire:ignore.self>
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Key')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.rozarpay_key"
                                           class="form-control form-check-sm @error('request.rozarpay_key') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.rozarpay_key') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Secret')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="password"
                                           wire:model.lazy="request.rozarpay_secret"
                                           class="form-control form-check-sm @error('request.rozarpay_secret') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.rozarpay_secret') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">Status:</label>
                                <div class="col-lg-9 col-xl-4 pt-3">
                                    <label class="form-check form-check-custom form-check-solid form-switch mb-5">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="true"
                                               {{isset($request['rozarpay_active']) && $request['rozarpay_active']?'checked':''}}
                                               onchange="@this.set('request.rozarpay_active',this.checked)"
                                        >
                                        <span class="form-check-label text-muted">{{isset($request['rozarpay_active']) && $request['rozarpay_active']?'Enable':'Disable'}}</span>
                                    </label>
                                    <div class="form-text text-muted">Enable Rozarypay Gateway</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane" id="kt_builder_header" role="tabpanel" wire:ignore.self>
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Paypal Mode')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <select class="form-select @error('request.paypal_account_type') is-invalid @enderror"
                                            wire:model.lazy="request.paypal_account_type"
                                    >
                                        <option value="live">Live</option>
                                        <option value="sandbox">Sandbox</option>
                                    </select>
                                    @error('request.paypal_account_type') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Live Key')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paypal_live_app_id"
                                           class="form-control form-check-sm @error('request.paypal_live_app_id') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paypal_live_app_id') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Live ClientID')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paypal_live_client_id"
                                           class="form-control form-check-sm @error('request.paypal_live_client_id') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""d
                                    />
                                    @error('request.paypal_live_client_id') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Live Secret')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="password"
                                           wire:model.lazy="request.paypal_live_client_secret"
                                           class="form-control form-check-sm @error('request.paypal_live_client_secret') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paypal_live_client_secret') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Sandbox Key')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paypal_client_id"
                                           class="form-control form-check-sm @error('request.paypal_client_id') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paypal_client_id') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Sandbox Secret')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="password"
                                           wire:model.lazy="request.paypal_client_secret"
                                           class="form-control form-check-sm @error('request.paypal_client_secret') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paypal_client_secret') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">Status:</label>
                                <div class="col-lg-9 col-xl-4 pt-3">
                                    <label class="form-check form-check-custom form-check-solid form-switch mb-5">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="true"
                                               {{isset($request['paypal_active']) && $request['paypal_active']?'checked':''}}
                                               onchange="@this.set('request.paypal_active',this.checked)"
                                        >
                                        <span class="form-check-label text-muted">{{isset($request['paypal_active']) && $request['paypal_active']?'Enable':'Disable'}}</span>
                                    </label>
                                    <div class="form-text text-muted">Enable Paypal Gateway</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane" id="kt_builder_toolbar" role="tabpanel" wire:ignore.self>
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Key')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.stripe_key"
                                           class="form-control form-check-sm @error('request.stripe_key') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.stripe_key') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Secret')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="password"
                                           wire:model.lazy="request.stripe_secret"
                                           class="form-control form-check-sm @error('request.stripe_secret') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.stripe_secret') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">Status:</label>
                                <div class="col-lg-9 col-xl-4 pt-3">
                                    <label class="form-check form-check-custom form-check-solid form-switch mb-5">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="true"
                                               {{isset($request['stripe_active']) && $request['stripe_active']?'checked':''}}
                                               onchange="@this.set('request.stripe_active',this.checked)"
                                        >
                                        <span class="form-check-label text-muted">{{isset($request['stripe_active']) && $request['stripe_active']?'Enable':'Disable'}}</span>
                                    </label>
                                    <div class="form-text text-muted">Enable Stripe Gateway</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane" id="kt_builder_page_title" role="tabpanel" wire:ignore.self>
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Merchant ID')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paytm_merchant_id"
                                           class="form-control form-check-sm @error('request.paytm_merchant_id') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paytm_merchant_id') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Merchant Key')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paytm_merchant_key"
                                           class="form-control form-check-sm @error('request.paytm_merchant_key') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paytm_merchant_key') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Merchant Website')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paytm_merchant_website"
                                           class="form-control form-check-sm @error('request.paytm_merchant_website') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paytm_merchant_website') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Paytm Channel')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paytm_channel"
                                           class="form-control form-check-sm @error('request.paytm_channel') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paytm_channel') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">{{trans('Industry Type')}}</label>
                                <div class="col-lg-9 col-xl-4">
                                    <input type="text"
                                           wire:model.lazy="request.paytm_industry_type"
                                           class="form-control form-check-sm @error('request.paytm_industry_type') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.paytm_industry_type') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                            </div>
                            <!--end::Row-->
                            <div class="row mb-10">
                                <label class="col-lg-3 col-form-label text-lg-end">Status:</label>
                                <div class="col-lg-9 col-xl-4 pt-3">
                                    <label class="form-check form-check-custom form-check-solid form-switch mb-5">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="true"
                                               {{isset($request['paytm_active']) && $request['paytm_active']?'checked':''}}
                                               onchange="@this.set('request.paytm_active',this.checked)"
                                        >
                                        <span class="form-check-label text-muted">{{isset($request['paytm_active']) && $request['paytm_active']?'Enable':'Disable'}}</span>
                                    </label>
                                    <div class="form-text text-muted">Enable Paytm Gateway</div>
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

@push('scripts')
    <script>
        function changeCustomImage(type = 1)
        {
            const ImgTag = $('#customImg');
            switch (type)
            {
                case 1:
                    ImgTag.attr('src','/assets/images/default/payment/Razorpay_logo.svg')
                    break;
                case 2:
                    ImgTag.attr('src','/assets/images/default/payment/paypal.png')
                    break;
                case 3:
                    ImgTag.attr('src','/assets/images/default/payment/stripe.webp')
                    break;
                case 4:
                    ImgTag.attr('src','/assets/images/default/payment/paytm.png')
                    break;
            }
        }
    </script>
@endpush
