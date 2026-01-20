<div>
    {!! AdminBreadCrumb::Load(['title'=>'Status Questions','menu'=>[ ['name'=>trans('Status'),'url'=>route('admin::insurance-grouping:status.list')],['name'=>'Questions','active'=>true] ]]) !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form wire:submit.prevent="Save">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> {{ $insuranceStatus->name ??'' }}</h3>
                    </div>
                    <div class="card-body p-0">
                        @forelse($request as $i=>$item)
                            <div class="border">
                                <div class="border-bottom p-3">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="fs-5 pt-3">Question {{ $i+1 }}</h4>
                                        <div class="text-end">
                                            <button type="button"
                                                    class="btn btn-icon btn-sm btn-danger"
                                                    wire:click.prevent="removeQuestion({{ $i }})"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <x-input.text-area wire:model="request.{{ $i }}.title"
                                                  label="Title"

                                    />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-input.select wire:model="request.{{ $i }}.status"
                                                            label="Status"
                                            >
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </x-input.select>
                                        </div>
                                        <div class="col-md-6">
                                           <x-input.text wire:model="request.{{ $i }}.position"
                                                         type="number"
                                                         label="Position"
                                                         min="0"
                                                         max="5000"
                                           />
                                       </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="pt-3">
                                <p class="text-center">
                                    No questions
                                </p>
                            </div>
                        @endforelse
                        <div class="text-end my-3 p-3">
                            <button class="btn btn-sm btn-primary" type="button" wire:click.prevent="addNewQuestion" wire:loading.attr="disabled">
                                + Add New Question
                            </button>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            {!! AdminTheme::Spinner(['target'=>'Save','label'=>'Save Status','bg'=>'success']) !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
