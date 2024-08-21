<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                <!--begin::Form-->
                <form class="form w-100"  wire:submit.prevent="Submit">
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Administrator Login</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Login options-->
                    <div class="row g-3 mb-9">
{{--                        <!--begin::Col-->--}}
{{--                        <div class="col-md-12">--}}
{{--                            <!--begin::Google link=-->--}}
{{--                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">--}}
{{--                                <img alt="Logo" src="{{ asset('assets/backend/assets/media/svg/brand-logos/google-icon.svg') }}" class="h-15px me-3" />Sign in with Google</a>--}}
{{--                            <!--end::Google link=-->--}}
{{--                        </div>--}}
{{--                        <!--end::Col-->--}}
{{--                        <!--begin::Col-->--}}
{{--                        <div class="col-md-6">--}}
{{--                            <!--begin::Google link=-->--}}
{{--                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">--}}
{{--                                <img alt="Logo" src="{{ asset('assets/backend/assets/media/svg/brand-logos/apple-black.svg') }}" class="theme-light-show h-15px me-3" />--}}
{{--                                <img alt="Logo" src="{{ asset('assets/backend/assets/media/svg/brand-logos/apple-black-dark.svg') }}" class="theme-dark-show h-15px me-3" />Sign in with Apple</a>--}}
{{--                            <!--end::Google link=-->--}}
{{--                        </div>--}}
{{--                        <!--end::Col-->--}}
                    </div>
                    <!--end::Login options-->
{{--                    <!--begin::Separator-->--}}
{{--                    <div class="separator separator-content my-14">--}}
{{--                        <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>--}}
{{--                    </div>--}}
{{--                    <!--end::Separator-->--}}
                    <!--begin::Input group=-->
                    <div class="fv-row mb-5">
                        <!--begin::Email-->
                        <input type="text"
                               placeholder="Email"
                               name="email"
                               autocomplete="off"
                               class="form-control bg-transparent @error('request.email') is-invalid @enderror"
                               wire:model="request.email"
                        />
                        <!--end::Email-->
                        @error('request.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-5">
                        <!--begin::Password-->
                        <input type="password"
                               placeholder="Password"
                               name="password"
                               autocomplete="off"
                               wire:model="request.password"
                               class="form-control bg-transparent @error('request.password') is-invalid @enderror"
                        />
                        <!--end::Password-->
                        @error('request.password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <!--end::Input group=-->
                    @if(config('settings.captcha'))
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-5 pb-2 pb-lg-0 order-lg-2">
                                    {!! captcha_img('flat') !!}
                                </div>
                                <div class="col-md-7 order-lg-1">
                                    <input type="text" id="captcha-input" placeholder="Captcha" wire:model="request.captcha" class="form-control bg-transparent @error('request.captcha') is-invalid @enderror" />
                                    @error('request.captcha') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input cursor-pointer" type="checkbox" id="remember-me" wire:model="remember" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <!--begin::Link-->
                        <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit"
                                class="btn btn-primary"
                        >
                            <!--begin::Indicator label-->
                            <span class="indicator-label" wire:loading.remove wire:target="Submit">Sign In</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress" wire:loading wire:target="Submit">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Form-->
        <!--begin::Footer-->
        <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
            <!--begin::Languages-->
            <div class="me-10">
                <!--begin::Toggle-->
                <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                    <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('assets/backend/assets/media/flags/united-states.svg') }}" alt="" />
                    <span data-kt-element="current-lang-name" class="me-1">English</span>
                    <span class="d-flex flex-center rotate-180">
									<i class="ki-duotone ki-down fs-5 text-muted m-0"></i>
								</span>
                </button>
                <!--end::Toggle-->
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
										<span class="symbol symbol-20px me-4">
											<img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/backend/assets/media/flags/united-states.svg') }}" alt="" />
										</span>
                            <span data-kt-element="lang-name">English</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Languages-->
            <!--begin::Links-->
            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                <a href="{{ route('frontend::contact') }}" target="_blank">Contact Us</a>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Body-->
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ asset('assets/backend/assets/media/misc/auth-bg.png') }})">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
            <!--begin::Logo-->
            <div class="bg-white rounded-3">
                <a href="{{ route('frontend::home') }}" class="mb-0 mb-lg-12">
                    <img alt="Logo" src="{{ asset(config('settings.site_logo')) }}" class="h-60px h-lg-75px" />
                </a>
            </div>
            <!--end::Logo-->
            <!--begin::Image-->
            <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('assets/backend/assets/media/misc/auth-screens.png') }}" alt="" />
            <!--end::Image-->
            <!--begin::Title-->
            <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                {{ config('settings.site_name') }}
            </h1>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="d-none d-lg-block text-white fs-base text-center">
                {{ config('settings.site_description') }}
            </div>
            <!--end::Text-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->
</div>

{{--<div class="authentication-wrapper authentication-cover authentication-bg d-none">--}}
{{--    <div class="authentication-inner row">--}}
{{--        <!-- /Left Text -->--}}
{{--        <div class="d-none d-lg-flex col-lg-7 p-0">--}}
{{--            <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">--}}
{{--                <img--}}
{{--                    src="{{ asset('assets/backend/assets/img/illustrations/auth-login-illustration-light.png') }}"--}}
{{--                    alt="auth-login-cover"--}}
{{--                    class="img-fluid my-5 auth-illustration"--}}
{{--                    data-app-light-img="illustrations/auth-login-illustration-light.png"--}}
{{--                    data-app-dark-img="illustrations/auth-login-illustration-dark.png" />--}}

{{--                <img--}}
{{--                    src="{{ asset('assets/backend/assets/img/illustrations/bg-shape-image-light.png') }}"--}}
{{--                    alt="auth-login-cover"--}}
{{--                    class="platform-bg"--}}
{{--                    data-app-light-img="illustrations/bg-shape-image-light.png"--}}
{{--                    data-app-dark-img="illustrations/bg-shape-image-dark.png" />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /Left Text -->--}}

{{--        <!-- Login -->--}}
{{--        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">--}}
{{--            <div class="w-px-400 mx-auto">--}}
{{--                <!-- Logo -->--}}
{{--                <div class="app-brand mb-4">--}}
{{--                    <a href="{{ route('frontend::home') }}" class="app-brand-link gap-2">--}}
{{--                        <img src="{{ asset(config('settings.site_logo')) }}" height="35" />--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <!-- /Logo -->--}}
{{--                <h3 class="mb-1">Welcome to {{ config('settings.site_name') }}! 👋</h3>--}}
{{--                <p class="mb-4">Please sign-in to your account and start the adventure</p>--}}

{{--                <form class="mb-3" wire:submit.prevent="Submit">--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="email" class="form-label">Email or Username</label>--}}
{{--                        <input wire:model="request.email"--}}
{{--                               type="text"--}}
{{--                               class="form-control @error('request.email') is-invalid @enderror"--}}
{{--                               id="email"--}}
{{--                               name="email-username"--}}
{{--                               placeholder="Enter your email or username"--}}
{{--                               autofocus--}}
{{--                        />--}}
{{--                        @error('request.email') <div class="invalid-feedback">{{ $message }}</div> @enderror--}}
{{--                    </div>--}}
{{--                    <div class="mb-3 form-password-toggle">--}}
{{--                        <div class="d-flex justify-content-between">--}}
{{--                            <label class="form-label" for="password">Password</label>--}}
{{--                            <a href="{{ route('password.request') }}">--}}
{{--                                <small>Forgot Password?</small>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="input-group input-group-merge">--}}
{{--                            <input--}}
{{--                                type="password"--}}
{{--                                id="password"--}}
{{--                                class="form-control @error('request.password') is-invalid @enderror"--}}
{{--                                name="password"--}}
{{--                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"--}}
{{--                                aria-describedby="password"--}}
{{--                                wire:model="request.password"--}}
{{--                            />--}}
{{--                            <span class="input-group-text cursor-pointer" wire:ignore><i class="ti ti-eye-off"></i></span>--}}
{{--                            @error('request.password') <div class="invalid-feedback">{{ $message }}</div> @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @if(config('settings.captcha'))--}}
{{--                        <div class="mb-3">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-5 pt-3 pb-2 pb-lg-0 order-lg-2">--}}
{{--                                    {!! captcha_img('flat') !!}--}}
{{--                                </div>--}}
{{--                                <div class="col-md-7 order-lg-1">--}}
{{--                                    <label for="captcha-input" class="form-label">Captcha</label>--}}
{{--                                    <input type="text" id="captcha-input" wire:model="request.captcha" class="form-control @error('request.captcha') is-invalid @enderror" />--}}
{{--                                    @error('request.captcha') <div class="invalid-feedback">{{ $message }}</div> @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <div class="mb-3">--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="remember-me" wire:model="remember" />--}}
{{--                            <label class="form-check-label" for="remember-me"> Remember Me </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <button class="btn btn-primary d-grid w-100">--}}
{{--                        <div class="flex">--}}
{{--                            <div class="spinner-border spinner-border-sm me-2"  wire:loading wire:target="Submit"></div>   <span>Sign in</span>--}}
{{--                        </div>--}}
{{--                    </button>--}}
{{--                </form>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /Login -->--}}
{{--    </div>--}}
{{--</div>--}}
