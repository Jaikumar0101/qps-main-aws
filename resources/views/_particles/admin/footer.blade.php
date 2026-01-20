<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">&copy; {{date('Y')}} made with ❤️ by </span>
            <a href="javascript:void(0)" class="text-gray-800 text-hover-primary">{{config('settings.site_name','My APP')}}</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link px-2">
                    Page Load : <b>&nbsp;&nbsp;{{ round((microtime(true) - LARAVEL_START),2) }}s</b>
                </a>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>
