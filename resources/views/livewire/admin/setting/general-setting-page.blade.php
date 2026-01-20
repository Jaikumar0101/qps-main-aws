@section('title','Setting | General')
<div>
    <div wire:ignore>
        {!! AdminBreadCrumb::Load(['title'=>trans('General Settings'),'menu'=>[ ['name'=>trans('Settings')],['name'=>trans('General'),'active'=>true] ]]) !!}
    </div>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <!--begin::Header-->
                <div class="card-header pt-4">
                    <!--begin::Tabs-->
                    <ul class="nav nav-pills fw-semibold border-transparent flex-nowrap" role="tablist" id="kt_layout_builder_tabs" wire:ignore>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_builder_main" role="tab" aria-selected="true">{{trans('Main')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_header" role="tab" aria-selected="false" tabindex="-1">{{trans('Logo')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_toolbar" role="tab" aria-selected="false" tabindex="-1">{{trans('Company')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_page_title" role="tab" aria-selected="false" tabindex="-1">{{trans('Social Links')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_footer" role="tab" aria-selected="false" tabindex="-1">{{trans('Footer')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_aside" role="tab" aria-selected="false" tabindex="-1">{{trans('Backend')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_builder_content" role="tab" aria-selected="false" tabindex="-1">{{trans('Other')}}</a>
                        </li>
                    </ul>
                    <!--end::Tabs-->
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
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Site Name')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.site_name"
                                               class="form-control form-check-sm @error('request.site_name') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.site_name') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Site Description')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                    <textarea wire:model="request.site_description"
                                              class="form-control form-check-sm @error('request.site_description') is-invalid @enderror"
                                              rows="5"
                                    ></textarea>
                                        @error('request.site_description') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Title')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.site_title"
                                               class="form-control form-check-sm @error('request.site_title') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.site_title') <div class="invalid-feedback" >{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Meta Title')}} <br> <span class="small">({{trans('Max 110 characters')}})</span></label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.meta_title"
                                               class="form-control form-check-sm @error('request.meta_title') is-invalid @enderror"
                                               autocomplete="off"
                                               maxlength="110"
                                        />
                                        @error('request.meta_title') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Meta Description')}} <br> <span class="small">({{trans('Max 160 characters')}})</label>
                                    <div class="col-lg-9 col-xl-4">
                                    <textarea wire:model="request.meta_description"
                                              class="form-control form-check-sm @error('request.meta_description') is-invalid @enderror"
                                              placeholder=""
                                              maxlength="160"
                                              rows="5"
                                    ></textarea>
                                        @error('request.meta_description') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Meta Tags')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <x-forms.tag wire:model="request.meta_tags" value="{{ $request['meta_tags'] ??'' }}" />
                                        @error('request.meta_tags') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->
                            <!--begin::Tab pane-->
                            <div class="tab-pane" id="kt_builder_header" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Site Logo')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.site_logo" folder="logo/"></x-forms.filepond>
                                        @error('request.site_logo') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['site_logo']) && $request['site_logo']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['site_logo'])}}" height="75">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Site Logo 2')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.site_logo_2" folder="logo/"></x-forms.filepond>
                                        @error('request.site_logo_2') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['site_logo_2']) && $request['site_logo_2']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['site_logo_2'])}}" height="75">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Site Mobile Logo')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.site_mobile_logo" folder="logo/"></x-forms.filepond>
                                        @error('request.site_mobile_logo') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['site_mobile_logo']) && $request['site_mobile_logo']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['site_mobile_logo'])}}" height="75">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Site Favicon')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.site_favicon" folder="logo/"></x-forms.filepond>
                                        @error('request.site_favicon') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['site_favicon']) && $request['site_favicon']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['site_favicon'])}}" height="50">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Meta Os Image')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.meta_os_image" folder="images/"></x-forms.filepond>
                                        @error('request.meta_os_image') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['meta_os_image']) && $request['meta_os_image']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['meta_os_image'])}}" class="h-75px">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->
                            <!--begin::Tab pane-->
                            <div class="tab-pane" id="kt_builder_toolbar" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Name')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.company_name"
                                               class="form-control form-check-sm @error('request.company_name') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.company_name') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Email')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="email"
                                               wire:model="request.company_email"
                                               class="form-control form-check-sm @error('request.company_email') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.company_email') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Phone')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="tel"
                                               wire:model="request.company_phone"
                                               class="form-control form-check-sm @error('request.company_phone') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.company_phone') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('About')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                    <textarea
                                        wire:model="request.company_about"
                                        class="form-control form-check-sm @error('request.company_about') is-invalid @enderror"
                                        autocomplete="off"
                                        placeholder=""
                                    ></textarea>
                                        @error('request.company_about') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Address')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                    <textarea
                                        wire:model="request.company_address"
                                        class="form-control form-check-sm @error('request.company_address') is-invalid @enderror"
                                        autocomplete="off"
                                        placeholder=""
                                    ></textarea>
                                        @error('request.company_address') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->
                            <!--begin::Tab pane-->
                            <div class="tab-pane" id="kt_builder_page_title" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Facebook')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.fb_link"
                                               class="form-control form-check-sm @error('request.fb_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.fb_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Twitter')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.twitter_link"
                                               class="form-control form-check-sm @error('request.twitter_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.twitter_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Instagram')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.instagram_link"
                                               class="form-control form-check-sm @error('request.instagram_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.instagram_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Pinterest')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.pinterest_link"
                                               class="form-control form-check-sm @error('request.pinterest_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.pinterest_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('LinkedIn')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.linked_in_link"
                                               class="form-control form-check-sm @error('request.linked_in_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.linked_in_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Youtube')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.youtube_link"
                                               class="form-control form-check-sm @error('request.youtube_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.youtube_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Google Plus')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.google_plus_link"
                                               class="form-control form-check-sm @error('request.google_plus_link') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                        @error('request.google_plus_link') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->

                            <!--begin::Tab pane-->
                            <div class="tab-pane" id="kt_builder_footer" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Footer Logo')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.footer_logo" folder="logo/"></x-forms.filepond>
                                        @error('request.footer_logo') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['footer_logo']) && $request['footer_logo']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['footer_logo'])}}" height="75">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Footer Description')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                    <textarea wire:model="request.footer_description"
                                              class="form-control form-check-sm @error('request.footer_description') is-invalid @enderror"
                                              placeholder=""
                                    ></textarea>
                                        @error('request.footer_description') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Tab pane-->

                            <!--begin::Tab pane-->
                            <div class="tab-pane" id="kt_builder_aside" role="tabpanel" wire:ignore.self>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Admin Dashboard Logo')}}</label>
                                    <div class="col-lg-5 col-xl-4">
                                        <x-forms.filepond wire:model.live="request.admin_logo" folder="logo/"></x-forms.filepond>
                                        @error('request.admin_logo') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    @if(isset($request['admin_logo']) && $request['admin_logo']!=="")
                                        <div class="col-lg-4 col-xl-5">
                                            <img src="{{asset($request['admin_logo'])}}" height="100" class="min-w-100px">
                                        </div>
                                    @endif
                                </div>
                                <!--end::Row-->

                            </div>
                            <!--end::Tab pane-->

                            <!--begin::Tab pane-->
                            <div class="tab-pane" id="kt_builder_content" role="tabpanel" wire:ignore.self>

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Website Base URL')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="text"
                                               wire:model="request.app_base_url"
                                               class="form-control @error('request.app_base_url') is-invalid @enderror"
                                        />
                                        @error('request.app_base_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Editor Layout')}}</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <x-forms.select2 wire:model="request.editor_layout">
                                            <option value="ck-editor-4">CK-Editor 4</option>
                                            <option value="ck-editor-5">CK-Editor 5</option>
                                            <option value="tiny-ymc">Tiny YMC</option>
                                            <option value="quill-editor">Quill Rich Text Editor</option>
                                        </x-forms.select2>
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-form-label text-lg-end">{{trans('Image Captcha')}}</label>
                                    <div class="col-lg-9 col-xl-4 pt-3">
                                        <label class="form-check form-check-custom form-check-solid form-switch">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="true"
                                                   {{isset($request['captcha']) && $request['captcha']?'checked':''}}
                                                   onchange="@this.set('request.captcha',this.checked)"
                                            >
                                            <span class="form-check-label text-muted">{{isset($request['captcha']) && $request['captcha']?'Enable':'Disable'}}</span>
                                        </label>
                                        <div class="form-text text-muted">Enable Captcha</div>
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
