<div>

    {!! AdminBreadCrumb::Load(['title'=>trans('User Profile'),'menu'=>[ ['name'=>trans('User Profile')],['name'=>trans('Profile'),'active'=>true] ]]) !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <div class="card mb-5 mb-xxl-8">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ auth()->user()->avatarUrl()  }}" alt="image">
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->fullName() }}</a>
                                        <a href="#">
                                            <i class="ki-duotone ki-verify fs-1 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>{{ auth()->user()->roleName() ??auth()->user()->userType() }}</a>
                                        @if(auth()->user()->getCountry()->exists())
                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>{{ auth()->user()->getCountry?->nicename ??'' }}</a>
                                        @endif
                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>{{ auth()->user()->email ??'' }}</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                                <!--begin::Actions-->
                                <div class="d-flex my-4 d-none">
                                    <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                                        <i class="ki-duotone ki-check fs-3 d-none"></i>
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Follow</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </a>
                                    <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">Hire Me</a>
                                    <!--begin::Menu-->
                                    <div class="me-0">
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                            <!--begin::Heading-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Create Invoice</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link flex-stack px-3">Create Payment
                                                    <span class="ms-2" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-bs-original-title="Specify a target name for future usage and reference" data-kt-initialized="1">
																			<i class="ki-duotone ki-information fs-6">
																				<span class="path1"></span>
																				<span class="path2"></span>
																				<span class="path3"></span>
																			</i>
																		</span></a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Generate Bill</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">Subscription</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Plans</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Billing</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Statements</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator my-2"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content px-3">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications">
                                                                <!--end::Input-->
                                                                <!--end::Label-->
                                                                <span class="form-check-label text-muted fs-6">Recuring</span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3 my-1">
                                                <a href="#" class="menu-link px-3">Settings</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$" data-kt-initialized="1">
                                                    <div x-data="{ time: '', updateTime() { this.time = new Date().toLocaleTimeString(); } }" x-init="updateTime(); setInterval(() => updateTime(), 1000)">
                                                        <div x-text="time">--:--:--</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-400">
                                                {{ now()->format('d M, Y') }}
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Progress-->
                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3 d-none">
                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                        <span class="fw-semibold fs-6 text-gray-400">Profile Compleation</span>
                                        <span class="fw-bold fs-6">50%</span>
                                    </div>
                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" wire:ignore>
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active"
                               data-bs-toggle="tab"
                               data-bs-target="#navs-pills-top-home"
                               href="javascript:void(0)"
                            >Overview</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5"
                               data-bs-toggle="tab"
                               data-bs-target="#navs-pills-top-messages"
                               href="javascript:void(0)"
                            >Change Password</a>
                        </li>
                        <!--end::Nav item-->
                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="nav-align-top mb-4">
                        <div class="tab-content bg-transparent shadow-none  p-0">
                            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel" wire:ignore.self>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-5">
                                        <!-- About User -->
                                        <div class="card mb-4">
                                            <div class="card-header border-0 pt-5">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">Profile Overview</span>
                                                    <span class="text-muted fw-semibold fs-7">Showing your profile details</span>
                                                </h3>
                                                <!--end::Title-->
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-4 mt-3">
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-user text-heading"></i
                                                        ><span class="fw-medium mx-2 text-heading">Full Name:</span> <span>{{ auth()->user()->fullName() }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-check text-heading"></i
                                                        ><span class="fw-medium mx-2 text-heading">Status:</span> <span>{{ auth()->user()->status?'Active':'Inactive' }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-crown text-heading"></i
                                                        ><span class="fw-medium mx-2 text-heading">Role:</span> <span>{{ auth()->user()->roleName() ??auth()->user()->userType() }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-flag text-heading"></i
                                                        ><span class="fw-medium mx-2 text-heading">Country:</span> <span>{{ auth()->user()->getCountry->name ??'' }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-file-description text-heading"></i
                                                        ><span class="fw-medium mx-2 text-heading">Languages:</span> <span>English</span>
                                                    </li>
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">Contact:</span>
                                                        <span>{{ auth()->user()->phone ??'--' }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center mb-3">
                                                        <i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">Email:</span>
                                                        <span>{{ auth()->user()->email ??'--' }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--/ About User -->
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7">
                                        <form wire:submit.prevent="save">
                                            <!--begin::Feeds Widget 1-->
                                            <div class="card mb-4">
                                                <div class="card-header border-0 pt-5">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold fs-3 mb-1">Manage Profile</span>
                                                        <span class="text-muted fw-semibold fs-7">Here you can change your profile details</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">{{ trans('Avatar') }}</label>
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-7">
                                                                <x-forms.filepond wire:model="request.avatar"
                                                                                  folder="avatar"
                                                                                  allowFileTypeValidation="true"
                                                                                  accept="images/*"
                                                                />
                                                                @error('request.avatar') <div class="text-danger small">{{$message}}</div> @enderror
                                                            </div>
                                                            <div class="col-md-12 col-lg-5">
                                                                <div class="position-relative" style="max-width: 100px;">
                                                                    <img src="{{isset($request['avatar']) && $request['avatar']!==""?asset($request['avatar']):'/assets/images/default/user.png'}}" class="img-thumbnail" height="100" />
                                                                    <div class="position-absolute top-0" style="right: 0">
                                                                        @if(isset($request['avatar']) && $request['avatar']!=="")
                                                                            <!--begin::Remove-->
                                                                            <a onclick="@this.set('request.avatar',null)" class="px-2 py-1 bg-dark text-white text-decoration-none cursor-pointer"
                                                                               data-bs-toggle="tooltip"
                                                                               title=""
                                                                               data-bs-original-title="Remove avatar"
                                                                            >
                                                                                &times;
                                                                            </a>
                                                                            <!--end::Remove-->
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--begin::Row-->
                                                    <x-input.select  wire:model="request.salutation"
                                                                     label="Salutation"
                                                    >
                                                        <option value="">Choose Option</option>
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Ms.">Ms.</option>
                                                        <option value="Mrs.">Mrs.</option>
                                                    </x-input.select>
                                                    <!--end::Row-->
                                                    <!--begin::Row-->
                                                    <x-input.text wire:model="request.name" label="{{ trans('First Name') }}" />
                                                    <!--end::Row-->
                                                    <!--begin::Row-->
                                                    <x-input.text wire:model="request.last_name" label="{{trans('Last Name')}}" />
                                                    <!--end::Row-->
                                                    <!--begin::Row-->
                                                    <x-input.text type="email" wire:model="request.email" label="{{trans('Email')}}"  />
                                                    <!--begin::Row-->
                                                    <x-input.text type="number" wire:model="request.phone" label="{{trans('Phone')}}"  />
                                                    <!--end::Row-->
                                                    <!--begin::Row-->
                                                    <div class="form-group mb-3">
                                                        <label class="col-form-label">{{trans('Country')}}</label>
                                                        <x-forms.select2  wire:model.live="request.country" >
                                                            <option value="">Choose Option</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->id}}" {{ checkData($request['country']) && $request['country'] == $country->id?'selected':'' }}>{{$country->nicename ??''}}</option>
                                                            @endforeach
                                                        </x-forms.select2>
                                                        @error('request.country') <div class="text-danger small">{{$message}}</div> @enderror
                                                    </div>
                                                    <!--end::Row-->
                                                    <!--begin::Row-->
                                                    <div class="form-group mb-3">
                                                        <x-input.text-area wire:model="request.address" label="{{ trans('Address') }}" />
                                                    </div>
                                                    <!--end::Row-->
                                                </div>
                                                <!--end::Body-->
                                                <div class="card-footer offset-3">
                                                    {!! AdminTheme::Spinner() !!}
                                                </div>
                                            </div>
                                            <!--end::Feeds Widget 1-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel" wire:ignore.self>
                                <form wire:submit.prevent="changePassword">
                                    <!--begin::Feeds Widget 1-->
                                    <div class="card mb-4">
                                        <div class="card-header border-0 pt-5">
                                            <!--begin::Title-->
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold fs-3 mb-1">Change Password</span>
                                                <span class="text-muted fw-semibold fs-7">Here you can change your password</span>
                                            </h3>
                                            <!--end::Title-->
                                        </div>
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <!--begin::Row-->
                                            <div class="mb-3">
                                                <label class="col-form-label">{{trans('Old Password')}}</label>
                                                <input type="password"
                                                       wire:model="passwordRequest.old_password"
                                                       class="form-control form-check-sm @error('passwordRequest.old_password') is-invalid @enderror"
                                                       autocomplete="off"
                                                       placeholder=""
                                                />
                                                @error('passwordRequest.old_password') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <div class="mb-3">
                                                <label class="col-form-label">{{trans('New Password')}}</label>
                                                <input type="password"
                                                       wire:model="passwordRequest.password"
                                                       class="form-control form-check-sm @error('passwordRequest.password') is-invalid @enderror"
                                                       autocomplete="off"
                                                       placeholder=""
                                                />
                                                @error('passwordRequest.password') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <div class="mb-3">
                                                <label class="col-form-label">{{trans('Retype Password')}}</label>
                                                <input type="text"
                                                       wire:model="passwordRequest.password_confirmation"
                                                       class="form-control form-check-sm @error('passwordRequest.password_confirmation') is-invalid @enderror"
                                                       autocomplete="off"
                                                       placeholder=""
                                                />
                                                @error('passwordRequest.password_confirmation') <div class="invalid-feedback">{{$message}}</div> @enderror
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Body-->
                                        <div class="card-footer offset-3">
                                            {!! AdminTheme::Spinner(['target'=>'changePassword','label'=>trans('Change Password')]) !!}
                                        </div>
                                    </div>
                                    <!--end::Feeds Widget 1-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

</div>

