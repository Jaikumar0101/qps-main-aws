@section('title','Post Collection')
<div>
    <div>
        {!!
            AdminBreadCrumb::Load([
            'title'=>checkData($collection_id)?'Edit Post Collection':'New Post Collection',
            'menu'=>[ ['name'=>trans('Post Collection'),'url'=>'#'],['name'=>checkData($collection_id)?'Edit':'Add','active'=>true] ]
             ])
        !!}
    </div>
    <form wire:submit.prevent="{{isset($collection_id)?'Save':'Submit'}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <x-input.text wire:model="request.title" label="Title" />
                        <x-input.text-area wire:model="request.description" label="Description" />
                        <div class="form-group mb-3">
                            <label class="form-label">Collection Posts</label>
                            <x-forms.select2-ajax wire:model="postItems"
                                                  data-url="{{ route('select2::ajax:posts') }}"
                                                  multiple
                            >
                                @foreach(\App\Models\BlogPost::getInOrder($postItems) as $item)
                                    <option value="{{ $item->id }}"> {{ $item->title ??'' }}</option>
                                @endforeach
                            </x-forms.select2-ajax>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <!--begin::Footer-->
                    <div class="card-footer py-8">
                        <div class="">
                            {!! AdminTheme::Spinner(['target'=>(isset($collection_id)?'Save':'Submit'),'label'=>'Save Collection']) !!}
                        </div>
                    </div>
                    <!--end::Footer-->
                    <hr>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
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
            </div>
        </div>
    </form>
</div>
