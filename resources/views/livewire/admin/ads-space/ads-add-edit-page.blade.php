@section('title','Ads')
<div>
    <div>
        {!!
            AdminBreadCrumb::Load([
            'title'=>checkData($ads_id)?'Edit Advertisement':'New Advertisement',
            'menu'=>[ ['name'=>trans('Advertisement'),'url'=>'#'],['name'=>checkData($ads_id)?'Edit':'Add','active'=>true] ]
             ])
        !!}
    </div>
    <form wire:submit.prevent="{{isset($ads_id)?'Save':'Submit'}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <x-input.text wire:model="request.key"
                                      label="Key"
                        />
                        <x-input.text wire:model="request.name"
                                      label="Name"
                        />
                        <x-input.text wire:model="request.url"
                                      label="Url"
                        />

                        <x-input.select wire:model.live="request.type"
                                        label="Type"
                        >
                            <option value="image">Image</option>
                            <option value="embed">Embed Code</option>
                        </x-input.select>
                        <div class="row {{ $request['type'] == "image"?'':'d-none' }}">
                            <div class="col-md-7 mb-3 ">
                                <x-input.form-file-upload
                                    wire:model.live="request.image"
                                    data-label="Image"
                                    data-error="request.image"
                                />
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="position-relative" style="width: fit-content">
                                    @if(checkData($request['image']))
                                        <img src="{{ asset($request['image']) }}" height="100" width="100" class="img-thumbnail" />
                                        <div class="position-absolute top-0" style="right: 0">
                                            <button type="button" class="btn btn-danger p-1 rounded-0" onclick="@this.set('request.image',null)">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </div>
                                    @else
                                        <img src="{{ asset('assets/images/default/no-upload.png') }}" height="100"  />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3 {{ $request['type'] == "image"?'d-none':'' }}">
                            <label class="col-form-label">Code</label>
                            <x-forms.code-mirror wire:model="request.embed_code" />
                        </div>
                        <x-input.text type="number" min="0" max="5000" wire:model="request.position" label="Position" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <!--begin::Footer-->
                    <div class="card-footer py-8">
                        <div class="">
                            {!! AdminTheme::Spinner(['target'=>(isset($ads_id)?'Save':'Submit'),'label'=>'Save']) !!}
                        </div>
                    </div>
                    <!--end::Footer-->
                    <hr>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <!--begin::Row-->
                                <div class="form-group">
                                    <label class="form-label">{{trans('Display Type')}}</label>
                                    <select  wire:model="request.type" class="form-select @error('request.type') is-invalid @enderror">
                                        <option value="image">Image</option>
                                        <option value="embed">Embed Code</option>
                                    </select>
                                    @error('request.type') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--end::Row-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Row-->
                                <div class="form-group mb-2">
                                    <label class="form-label">{{trans('Expire Date')}}</label>
                                    <input type="date"
                                           wire:model="request.expire_at"
                                           class="form-control @error('request.expire_at') is-invalid @enderror"
                                    />
                                    @error('request.expire_at') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--end::Row-->
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-12">
                                <!--begin::Row-->
                                <div class="form-group mb-3">
                                    <label class="form-label">{{trans('Location')}}</label>
                                    <select  wire:model="request.location" class="form-select @error('request.location') is-invalid @enderror">
                                        <option value="home-page">Home Page</option>
                                    </select>
                                    @error('request.location') <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--end::Row-->
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    Open in new tab
                                </label>
                                <label class="form-check form-check-custom form-check-solid form-switch">
                                    <span>{{ $request['open_new_tab']?'Enable':'Disable' }}</span>
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value="1"
                                           onchange="@this.set('request.open_new_tab',this.checked)"
                                    />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
