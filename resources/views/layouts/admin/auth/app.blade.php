<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <title>Admin | @yield('title','Login')</title>
    <meta charset="utf-8" />
    <meta name="title" content="{{config('setting.meta_title','')}}" />
    <meta name="description" content="{{config('setting.meta_description','')}}" />
    <meta name="keywords" content="{{config('setting.meta_keywords','')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta property="og:type" content="{{config('settings.meta_site_type','article')}}" />
    <meta property="og:title" content="{{config('setting.meta_title','')}}" />
    <meta property="og:url" content="{{config('settings.site_url',url('/'))}}" />
    <meta property="og:site_name" content="{{config('settings.site_name','My App')}}" />
    <link rel="canonical" href="{{url('/')}}" />

    <link rel="icon" href="{{asset(config('settings.site_favicon'))}}" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="{{asset(config('settings.site_favicon'))}}"/>
    <link rel="shortcut icon" href="{{asset(config('settings.site_favicon'))}}" type="image/x-icon"/>

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <link href="{{ asset('assets/backend/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    @yield('header')
    @stack('head')
    @livewireStyles
</head>

<body id="kt_body" class="app-blank">

<script data-navigate-once>
    var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
</script>

<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!-- Content -->
    @yield('content')
    <!-- / Content -->
</div>
<!--end::Root-->

@livewireScripts
@yield('footer')

<!--begin::Javascript-->
<script data-navigate-once>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/backend/assets/plugins/global/plugins.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/backend/assets/js/scripts.bundle.js') }}" data-navigate-once></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/backend/assets/js/custom/authentication/sign-in/general.js') }}" data-navigate-once></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->

@stack('scripts')
<!--end::Javascript-->

<script data-navigate-once>
    const site_settings = {
        'name':@json(config('settings.site_name'))
    }
    toastr.options = {
        maxOpened: 1,
        autoDismiss: true,
        closeButton: $('#closeButton').prop('checked'),
        debug: $('#debugInfo').prop('checked'),
        newestOnTop: $('#newestOnTop').prop('checked'),
        progressBar: $('#progressBar').prop('checked'),
        positionClass: $('#positionGroup input:radio:checked').val() || 'toast-bottom-right',
        preventDuplicates: $('#preventDuplicates').prop('checked'),
        onclick: null,
    };
    window.addEventListener('SetMessage', ({detail: {type, message, close}}) => {
        switch (type) {
            case 'success':
                toastr.success(message,site_settings.name)
                break;
            case 'info':
                toastr.info(message,site_settings.name)
                break;
            default:
                toastr.error(message,site_settings.name)
                break;
        }
        if(typeof close!='undefined'){ $('.modal').modal('hide'); }
    })
</script>
@if($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error("{{$error}}",@json(config('settings.site_name','Error')));
        @endforeach
    </script>
@endif
</body>
</html>
