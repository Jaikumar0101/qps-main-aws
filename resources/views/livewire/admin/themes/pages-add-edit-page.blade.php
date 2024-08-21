@section('title','Theme | Pages - '.(isset($page_id) && $page_id!==""?trans('Edit'):trans('Add')))
<div>
    {!! AdminBreadCrumb::Load(['title'=>"Theme Page",'menu'=>[
        ['name'=>trans('Theme'),'url'=>'#'],
        ['name'=>'Page','url'=>route('admin::theme:pages.list')],
        ['name'=>(isset($page_id) && $page_id!==""?trans('Edit'):trans('Add')),'active'=>true]
     ]]) !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form wire:submit.prevent="{{isset($page_id)?'Save':'Submit'}}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="form-group mb-3">
                                    <label class="form-label">{{trans('Title')}}</label>
                                    <input type="text"
                                           wire:model="request.name"
                                           wire:change="generateSlug"
                                           class="form-control @error('request.name') is-invalid @enderror"
                                           autocomplete="off"
                                           placeholder=""
                                    />
                                    @error('request.name') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="form-group mb-3">
                                    <div class="d-flex flex-wrap">
                                        <label class="">{{trans('Permalink:')}}</label>
                                        <div class="ms-2">
                                            <a class="text-primary text-decoration-underline">
                                                            <span>
                                                                {{ config('settings.app_base_url') }}
                                                            </span>
                                                <span class="fw-bold">
                                                                {{ $request['slug'] ??'' }}
                                                            </span>
                                            </a>
                                        </div>
                                        <div class="ms-2">
                                            @if($editSlug)
                                                <button class="btn btn-primary btn-sm py-1 px-2" style="font-size: 11px;" wire:click.prevent="SaveSlug">
                                                    Ok
                                                </button>
                                                <button class="btn btn-white btn-sm py-1 px-2" style="font-size: 11px;" wire:click.prevent="EditSlug(false)">
                                                    Cancel
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-sm py-1 px-2" style="font-size: 11px;" wire:click.prevent="EditSlug">
                                                    Edit
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="{{ $editSlug?'':'d-none' }} mt-2">
                                        <input type="text"
                                               wire:model="slug"
                                               class="form-control @error('slug') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                        />
                                    </div>
                                    @error('request.slug') <div class="text-danger small">{{$message}}</div> @enderror
                                </div>
                                <!--end::Row-->


                                <!--begin::Row-->
                                <div class="form-group mb-3">
                                    <label class="form-label">{{trans('Content')}}</label>
                                    <x-editor.c-k-editor5 wire:model="request.content" />
                                </div>
                                <!--end::Row-->
                            </div>
                        </div>

                        <div class="card rounded" x-data="{open:false}">
                            <div class="card-header pb-2">
                                <span class="card-title">Search Engine Optimize</span>
                                <div class="card-toolbar">
                                    <div>
                                        <a class="btn btn-primary btn-sm btn-icon text-white"
                                           data-bs-toggle="tooltip"
                                           data-bs-title="Edit"
                                           x-on:click="open = !(open)"
                                        >
                                               <span x-show="!open">
                                                   <i class="fa fa-edit"></i>
                                               </span>
                                            <span x-show="open">
                                                <i class="fa fa-minus"></i>
                                               </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <h5 style="color: #1a0dab" class="mb-0 pb-0">{{ Str::limit($metaRequest['title'] ??($request['title'] ??''),110) }}</h5>
                                    <a href="{{ config('settings.app_base_url') }}{{ $request['slug'] ??'' }}"
                                       class="small"
                                       target="_blank"
                                       style="color: #006621"
                                    >{{ config('settings.app_base_url') }}{{ $request['slug'] ??'' }}</a>
                                    <p>
                                        {{ Str::limit($metaRequest['description'] ??($request['description'] ??''),160) }}
                                    </p>
                                </div>
                                <div x-show="open" class="mt-5">
                                    <!--begin::Row-->
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{trans('Meta Title')}}</label>
                                        <input type="text"
                                               wire:model.live="metaRequest.title"
                                               class="form-control @error('metaRequest.title') is-invalid @enderror"
                                               autocomplete="off"
                                               placeholder=""
                                               maxlength="110"
                                        />
                                        @error('metaRequest.title') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{trans('Meta Description')}}</label>
                                        <textarea wire:model.live="metaRequest.description"
                                                  class="form-control @error('metaRequest.description') is-invalid @enderror"
                                                  maxlength="160"
                                        ></textarea>
                                        @error('metaRequest.description') <div class="invalid-feedback">{{$message}}</div> @enderror
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="form-group mb-3">
                                        <label class="form-label">{{trans('Meta Keywords')}}</label>
                                        <x-forms.tag wire:model="metaRequest.keywords" />
                                        @error('metaRequest.keywords') <div class="text-danger small">{{$message}}</div> @enderror
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="mb-10">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <x-input.form-file-upload wire:model.live="metaRequest.os_image" data-label="{{ trans('Meta Os Image') }}" />
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="avatar avatar-xl position-relative">
                                                        @if(checkData($metaRequest['os_image']))
                                                            <img src="{{ checkData($metaRequest['os_image'])?asset($metaRequest['os_image']):'/assets/images/default/user.png' }}" alt="Avatar" class="rounded">
                                                            <a href="javascript:void(0)"
                                                               x-on:click="@this.set('metaRequest.os_image',null)"
                                                               class="cursor-pointer position-absolute "
                                                               style="top: 2px;right:5px"
                                                            >
                                                                <i class="fa fa-close"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @error('metaRequest.os_image') <div class="text-danger small">{{$message}}</div> @enderror
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <!--begin::Footer-->
                            <div class="card-footer py-8">
                                <div class="">
                                    {!! AdminTheme::Spinner(['target'=>(isset($page_id)?'Save':'Submit'),'label'=>'Save Page']) !!}
                                </div>
                            </div>
                            <!--end::Footer-->
                            <hr>
                            <div class="card-body py-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--begin::Row-->
                                        <div class="form-group mb-2">
                                            <label class="form-label">{{trans('Status')}}</label>
                                            <select  wire:model="request.status" class="form-select @error('request.status') is-invalid @enderror">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            @error('request.status') <div class="invalid-feedback">{{$message}}</div> @enderror
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <div class="col-md-6">
                                        <!--begin::Row-->
                                        <div class="form-group mb-2">
                                            <label class="form-label">{{trans('Authentication')}}</label>
                                            <select  wire:model="request.authenticate" class="form-select @error('request.authenticate') is-invalid @enderror">
                                                <option value="1">On</option>
                                                <option value="0">Off</option>
                                            </select>
                                            @error('request.authenticate') <div class="invalid-feedback">{{$message}}</div> @enderror
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                </div>
            </form>
        </div>
    </div>

</div>
