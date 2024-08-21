@section('title','User | '.(isset($user_id) && $user_id!==""?trans('Edit'):trans('Add')))
<div>
    {!! AdminBreadCrumb::Load(['title'=>$pageTitle,'menu'=>[ ['name'=>trans('Users'),'url'=>route('admin::users:list')],['name'=>isset($user_id)?trans('Edit'):trans('Add'),'active'=>true] ]]) !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <!--begin::Form-->
                <form class="form" wire:submit.prevent="{{isset($user_id)?'Save':'Submit'}}">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-3">
                            <!--begin::Tab pane-->
                            <div class="tab-pane active show" id="kt_builder_main" role="tabpanel" wire:ignore.self>

                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Avatar')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <x-forms.filepond wire:model.live="request.avatar" folder="avatar" allowFileTypeValidation="true" accept="images/*"  />
                                            </div>
                                            <div class="col-md-5">
                                                <div class="position-relative " style="width: fit-content">
                                                    <img src="{{ checkData($request['avatar'])?asset($request['avatar']):'/assets/images/default/user.png' }}" alt="Avatar" class="rounded w-100px">
                                                    @if(checkData($request['avatar']))
                                                        <a href="javascript:void(0)"
                                                           x-on:click="@this.set('request.avatar',null)"
                                                           class="cursor-pointer position-absolute "
                                                           style="top: 2px;right:5px"
                                                        >
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @error('request.avatar') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Salutation')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <x-forms.select2  wire:model="request.salutation"
                                        >
                                            <option value="">Choose Option</option>
                                            <option value="Mr." {{ $request['salutation'] == "Mr."?'selected':'' }} >Mr.</option>
                                            <option value="Ms." {{ $request['salutation'] == "Ms."?'selected':'' }}>Ms.</option>
                                            <option value="Mrs." {{ $request['salutation'] == "Mrs."?'selected':'' }}>Mrs.</option>
                                        </x-forms.select2>
                                        @error('request.salutation') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('First Name')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.name"
                                               class="form-control form-check-sm @error('request.name') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.name') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Last Name')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.last_name"
                                               class="form-control form-check-sm @error('request.last_name') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.last_name') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Email')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="email"
                                               wire:model="request.email"
                                               class="form-control form-check-sm @error('request.email') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.email') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Phone')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="number"
                                               wire:model="request.phone"
                                               class="form-control form-check-sm @error('request.phone') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                               step="0"
                                        />
                                        @error('request.phone') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Password')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="password"
                                               wire:model="request.password"
                                               class="form-control form-check-sm @error('request.password') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.password') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Retype Password')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.password_confirmation"
                                               class="form-control form-check-sm @error('request.password_confirmation') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.password_confirmation') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Country')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <x-forms.select2  wire:model.live="request.country">
                                            <option value="">Choose Option</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}"  {{ checkData($request['country']) && $request['country'] == $country->id?'selected':'' }}>{{$country->nicename ??''}}</option>
                                            @endforeach
                                        </x-forms.select2>
                                        @error('request.country') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('State')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.state"
                                               class="form-control form-check-sm @error('request.state') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.state') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('City')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.city"
                                               class="form-control form-check-sm @error('request.city') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.city') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Address')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                            <textarea wire:model="request.address"
                                                      class="form-control form-check-sm @error('request.address') is-invalid @enderror min-h-150px"
                                                      maxlength="500"
                                            ></textarea>
                                        @error('request.address') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Status')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select  wire:model="request.status" class="form-control form-select @error('request.status') is-invalid @enderror">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('request.status') <div class="invalid-feedback">{{$message}}</div> @enderror
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
                                {!! AdminTheme::Spinner(['target'=>(isset($user_id)?'Save':'Submit')]) !!}
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
