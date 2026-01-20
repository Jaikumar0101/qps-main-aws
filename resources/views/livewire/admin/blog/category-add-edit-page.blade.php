@section('title','Blog | Category')
<div>
    {!! AdminBreadCrumb::Load(['title'=>"Blog Category",'menu'=>[ ['name'=>trans('Blog'),'url'=>'#'],['name'=>'Category'],['name'=>checkData($category_id)?'Edit':'Add','active'=>true] ]]) !!}
    <div>
        <form wire:submit.prevent="{{ checkData($category_id)?'Save':'Submit' }}">
            <div class="row">
                <div class="col-md-9">
                        <div class="card rounded mb-3">
                            <div class="card-body">
                                    <!--begin::Tab pane-->
                                    <div>

                                        <!--begin::Row-->
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{trans('Name')}}</label>
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
                                            <label class="form-label">{{trans('Description')}}</label>
                                            <textarea wire:model="request.description"
                                                      class="form-control @error('request.description') is-invalid @enderror"
                                            ></textarea>
                                            @error('request.description') <div class="invalid-feedback">{{$message}}</div> @enderror
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="mb-10">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <x-input.form-file-upload wire:model.live="request.icon" data-label="Icon" />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="avatar avatar-xl position-relative">
                                                            @if(checkData($request['icon']))
                                                                <img src="{{ checkData($request['icon'])?asset($request['icon']):'/assets/images/default/user.png' }}" alt="Avatar" class="rounded">
                                                                <a href="javascript:void(0)"
                                                                   x-on:click="@this.set('request.icon',null)"
                                                                   class="cursor-pointer position-absolute "
                                                                   style="top: 2px;right:5px"
                                                                >
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('request.icon') <div class="text-danger small">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="mb-10">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <x-input.form-file-upload wire:model.live="request.thumbnail" data-label="Thumbnail" />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="avatar avatar-xl position-relative">
                                                            @if(checkData($request['thumbnail']))
                                                                <img src="{{ checkData($request['thumbnail'])?asset($request['thumbnail']):'/assets/images/default/user.png' }}" alt="Avatar" class="rounded">
                                                                <a href="javascript:void(0)"
                                                                   x-on:click="@this.set('request.thumbnail',null)"
                                                                   class="cursor-pointer position-absolute "
                                                                   style="top: 2px;right:5px"
                                                                >
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('request.thumbnail') <div class="text-danger small">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="form-group mb-3 d-none">
                                            <label class="form-label">{{trans('Position')}}</label>
                                            <input type="number"
                                                   wire:model="request.position"
                                                   class="form-control @error('request.position') is-invalid @enderror"
                                                   autocomplete="off"
                                                   min="0"
                                                   max="5000"
                                            />
                                            @error('request.position') <div class="invalid-feedback">{{$message}}</div> @enderror
                                        </div>
                                        <!--end::Row-->

                                    </div>
                            </div>
                        </div>
                    <div class="card rounded" x-data="{open:false}">
                        <div class="card-header pb-2">
                            <div class="d-flex justify-content-between">
                                <span class="card-title">Search Engine Optimize</span>
                                <div class="card-action">
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
                                    <label class="form-label">{{trans('Meta Title')}} (Max: 110 Words)</label>
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
                                    <label class="form-label">{{trans('Meta Description')}} (Max: 160 Words)</label>
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
                                    <x-forms.tag wire:model="metaRequest.keywords" value="{{ $metaRequest['keywords'] ??'' }}" />
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
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-footer border-bottom">
                            {!! AdminTheme::Spinner(['target'=>checkData($category_id)?'Save':'Submit']) !!}
                        </div>
                        <div class="card-body">
                            <!--begin::Row-->
                            <div class="form-group mb-3">
                                <label class="form-label">{{trans('Status')}}</label>
                                <select  wire:model="request.status" class="form-select @error('request.status') is-invalid @enderror">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('request.status') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                            <!--end::Row-->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        function confirm_delete(category_id)
        {
            if(confirm("Are you sure you want to delete this record"))
            {
                @this.destroy(category_id);
            }
        }
    </script>
@endpush
