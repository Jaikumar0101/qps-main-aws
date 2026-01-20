@section('title','Project & Tasks')
<div>

    <div>
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">

                <div class="card mb-5">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $pageTitle ??'' }}
                        </div>
                    </div>
                </div>

                <div class="row">
                   <div class="col-md-4">
                       <livewire:admin.tasks.components.category-list-content wire:key="projectCategoryList" />
                   </div>
                    <div class="col-md-8">
                        <livewire:admin.tasks.components.project-list-content wire:key="projectCategoryList" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
