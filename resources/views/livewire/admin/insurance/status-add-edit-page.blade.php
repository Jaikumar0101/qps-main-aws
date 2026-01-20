<div>
    {!! AdminBreadCrumb::Load(['title'=>(checkData($status_id)?'Edit':'New')." Status",'menu'=>[ ['name'=>trans('Status'),'url'=>route('admin::insurance-grouping:status.list')],['name'=>checkData($status_id)?trans('Edit'):trans('Add'),'active'=>true] ]]) !!}


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form wire:submit.prevent="{{ checkData($status_id)?'Save':'Submit' }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <x-input.text wire:model="request.name"
                                              label="Name"
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.text-area wire:model="request.description"
                                                   label="Action"
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.text-area wire:model="request.note"
                                                   label="Note"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-input.select wire:model="request.status"
                                                label="Status"
                                >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </x-input.select>
                            </div>
                            <div class="col-md-6">
                                <x-input.text wire:model="request.position"
                                              min="0"
                                              max="5000"
                                              label="Position"
                                              type="number"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            {!! AdminTheme::Spinner(['target'=>(checkData($status_id)?'Save':'Submit'),'label'=>'Save Status','bg'=>'success']) !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
