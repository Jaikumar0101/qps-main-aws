<div>
    {!! AdminBreadCrumb::Load(['title'=>(checkData($customer_id)?'Edit':'New')." Client",'menu'=>[ ['name'=>trans('Clients'),'url'=>route('admin::customers:list')],['name'=>checkData($customer_id)?trans('Edit'):trans('Add'),'active'=>true] ]]) !!}


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form wire:submit.prevent="{{ checkData($customer_id)?'Save':'Submit' }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <x-input.text wire:model="request.first_name"
                                              label="Doctor's Name"
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.text wire:model="request.last_name"
                                              label="Dental Office Name"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-input.text wire:model="request.email"
                                              label="Email"
                                />
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone</label>
                                    <x-forms.country-mobile-input wire:model="request.phone"
                                                                  class="form-control"
                                                                  country="US"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <x-input.text-area wire:model="request.address"
                                                   label="Address"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.tax_id"
                                              label="Tax ID"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.npi_number"
                                              label="NPI Number"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-input.text wire:model="request.practice_management_software"
                                              label="Practice Management Software"
                                />
                            </div>
                            <div class="col-md-12">
                                <x-input.select wire:model="request.status"
                                                label="Status"
                                >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </x-input.select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            {!! AdminTheme::Spinner(['target'=>(checkData($customer_id)?'Save':'Submit'),'label'=>'Save Client','bg'=>'success']) !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
