@section('title','Blog | Post - '.(isset($post_id) && $post_id!==""?trans('Edit'):trans('Add')))
<div>
    {!! AdminBreadCrumb::Load(['title'=>"Blog Post",'menu'=>[
        ['name'=>trans('Blog'),'url'=>'#'],
        ['name'=>'Posts','url'=>route('admin::blog:posts')],
        ['name'=>(isset($post_id) && $post_id!==""?trans('Edit'):trans('Add')),'active'=>true]
     ]]) !!}

    <div >
        <form wire:submit.prevent="{{isset($post_id)?'Save':'Submit'}}">
           <div class="row">
               <div class="col-md-8">
                   <div class="card mb-3">
                       <div class="card-body">
                           <!--begin::Row-->
                           <div class="form-group mb-3">
                               <label class="form-label">{{trans('Title')}}</label>
                               <input type="text"
                                      wire:model="request.title"
                                      wire:change="generateSlug"
                                      class="form-control @error('request.title') is-invalid @enderror"
                                      autocomplete="off"
                                      placeholder=""
                               />
                               @error('request.title') <div class="invalid-feedback">{{$message}}</div> @enderror
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
                               <textarea wire:model="request.desc"
                                         class="form-control @error('request.desc') is-invalid @enderror"
                                         maxlength="500"
                               ></textarea>
                               @error('request.desc') <div class="invalid-feedback">{{$message}}</div> @enderror
                           </div>
                           <!--end::Row-->

                           <!--begin::Row-->
                           <div class="mb-3">
                               <div class="form-group">
                                   <div class="row">
                                       <div class="col-md-7">
                                           <x-input.form-file-upload wire:model.live="request.image" data-label="Thumbnail" />
                                       </div>
                                       <div class="col-md-5">
                                           <div class="avatar avatar-xl position-relative">
                                               @if(checkData($request['image']))
                                                   <img src="{{ checkData($request['image'])?asset($request['image']):'/assets/images/default/user.png' }}" alt="Avatar" class="rounded">
                                                   <a href="javascript:void(0)"
                                                      x-on:click="@this.set('request.image',null)"
                                                      class="cursor-pointer position-absolute "
                                                      style="top: 2px;right:5px"
                                                   >
                                                       <i class="fa fa-close"></i>
                                                   </a>
                                               @endif
                                           </div>
                                       </div>
                                   </div>
                                   @error('request.image') <div class="text-danger small">{{$message}}</div> @enderror
                               </div>
                           </div>
                           <!--end::Row-->

                           <!--begin::Row-->
                           <div class="form-group mb-3">
                               <label class="form-label">{{trans('Content')}}</label>
                               @switch(config('settings.editor_layout'))
                                   @case('ck-editor-5')
                                       <x-editor.c-k-editor5 wire:model="request.content" />
                                       @break
                                   @case('tiny-ymc')
                                       <x-editor.tiny-ymc wire:model="request.content" data-height="700"  />
                                       @break
                                   @case('quill-editor')
                                       <x-editor.quill-editor wire:model="request.content" >{!! $request['content'] ??'' !!}</x-editor.quill-editor>
                                       @break
                                   @default
                                       <x-forms.editor wire:model="request.content" data-height="700" />
                               @endswitch
                           </div>
                           <!--end::Row-->
                       </div>
                   </div>

                   <div class="card rounded mb-3">
                       <div class="card-header pb-2">
                           <div class="d-flex justify-content-between">
                               <span class="card-title">Video Format</span>
                               <div class="card-action">
                                   <label class="form-check form-check-custom form-check-solid form-switch">
                                       <input class="form-check-input"
                                              type="checkbox"
                                              value="1"
                                              onchange="@this.set('request.format',this.checked)"
                                       />
                                   </label>
                               </div>
                           </div>
                       </div>
                       <div class="card-body {{ $request['format']?'':'d-none' }}">
                           <div class="row mb-3">
                               <div class="col-md-5">
                                   <label class="col-form-label">Upload Thumbnail Video</label>
                                   <x-forms.filepond wire:model.live="request.video_url" />
                               </div>
                               <div class="col-md-7">

                               </div>
                           </div>
                           <x-input.text-area wire:model="request.video_embed" label="Embed Video" />
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
                               {!! AdminTheme::Spinner(['target'=>(isset($post_id)?'Save':'Submit'),'label'=>'Save Post']) !!}
                           </div>
                       </div>
                       <!--end::Footer-->
                       <hr>
                       <div class="card-body py-2">
                           <div class="row">
                               <div class="col-md-6">
                                   <!--begin::Row-->
                                   <div class="form-group mb-2">
                                       <label class="form-label">{{trans('Post Date')}}</label>
                                       <input type="date"
                                              wire:model="request.post_date"
                                              class="form-control @error('request.post_date') is-invalid @enderror"
                                       />
                                       @error('request.post_date') <div class="invalid-feedback">{{$message}}</div> @enderror
                                   </div>
                                   <!--end::Row-->
                               </div>
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
                           </div>
                       </div>
                       <hr>
                       <div class="card-body py-2">
                           <x-input.select wire:model.live="request.read_time_format"
                                           label="Read Time Format"
                           >
                               <option value="0">Automatic</option>
                               <option value="1">Custom</option>
                           </x-input.select>
                           <div class="{{ $request['read_time_format']?'':'d-none' }}" >
                               <x-input.text type="number"
                                             wire:model="request.read_time"
                                             label="Read Time (Min)"
                               />
                           </div>
                       </div>
                       <hr>
                       <div class="card-body py-2">
                           <!--begin::Row-->
                           <div class="form-group mb-3">
                               <label class="form-label">{{trans('Main Category')}}</label>
                               <x-forms.select2 wire:model="request.category" class="form-select-sm">
                                   <option value="">Select Option</option>
                                   @foreach(\App\Models\BlogCategory::orderBy('position')->get() as $category)
                                       <option value="{{$category->id}}"> {{$category->name ??''}}</option>
                                   @endforeach
                               </x-forms.select2>
                               @error('request.category') <div class="text-danger small">{{$message}}</div> @enderror
                           </div>
                           <!--end::Row-->
                           <!--begin::Row-->
                           <div class="form-group mb-3">
                               <label class="form-label">{{trans('Other Categories')}}</label>
                               <x-forms.select2 wire:model.live="postCategoryRequest" multiple class="form-select-sm">
                                   @foreach(\App\Models\BlogCategory::getInOrder($postCategoryRequest) as $category)
                                       <option value="{{$category->id}}"> {{$category->name ??''}}</option>
                                   @endforeach
                               </x-forms.select2>
                               @error('postCategoryRequest') <div class="text-danger small">{{$message}}</div> @enderror
                           </div>
                           <!--end::Row-->
                           <!--begin::Row-->
                           <div class="form-group mb-3">
                               <label class="form-label">{{trans('Tags')}}</label>
                               <x-forms.tag wire:model.live="postTagRequest" value="{{ $postTagRequest ??'' }}" />
                               @error('postTagRequest') <div class="text-danger small">{{$message}}</div> @enderror
                           </div>
                           <!--end::Row-->
                       </div>
                   </div>
               </div>
           </div>
        </form>
    </div>

</div>
