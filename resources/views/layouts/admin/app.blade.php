<!DOCTYPE html>

<html lang="en" >
<head>
    <base href="">
    <title>Admin | @yield('title','Dashboard')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <link href="{{ asset('assets/backend/assets/css/custom.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <!-- Latest compiled and minified CSS -->
    {{-- <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.css" /> --}}
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@2.2.0/dist/multiple-select.min.css">
    <script src="https://unpkg.com/multiple-select@2.2.0/dist/multiple-select.min.js"></script>

    @stack('head')
    @livewireStyles

    <!-- Filepond stylesheet -->
    <link href="{{asset('assets/filepond/dist/filepond.css')}}" rel="stylesheet">
    <link href="{{asset('assets/codemirror/codemirror.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/codemirror/codemirror.min.js')}}"></script>

    @if(config('settings.editor_layout') == "quill-editor")
        <link rel="stylesheet" href="{{ asset('assets/backend/assets/vendor/libs/quill/typography.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/backend/assets/vendor/libs/quill/katex.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/backend/assets/vendor/libs/quill/editor.css') }}" />
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>


    <style>
        .ck-powered-by-balloon{
            display: none!important;
        }
        .tox-notifications-container{
            display: none!important;
        }
        .ms-choice>span.placeholder {
            color: black;
        }
        .ms-choice .placeholder {
            background-color: transparent;
        }
        .custom-link-hover{
            color: #333333;
        }
        .custom-link-hover:hover{
            color: var(--bg-site-blue);
        }
    </style>

</head>

<body id="kt_app_body"
      data-kt-app-layout="dark-sidebar"
      data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true"
      data-kt-app-sidebar-fixed="true"
      data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true"
      data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true"
      data-kt-app-toolbar-enabled="true"
      class="app-default"
      data-kt-app-sidebar-minimize="on"
>

<script data-navigate-once>
    var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
</script>

<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        <x-admin.navbar />
        <!--end::Header-->
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            <x-admin.sidebar />
            <!--end::Sidebar-->
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    @yield('content',$slot ??'')
                </div>
                <!--end::Content wrapper-->
                <!--begin::Footer-->
                @include('_particles.admin.footer')
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->

<livewire:admin.components.notes.additional-notes-model />


{{--@persist('modal')--}}
{{--    <livewire:admin.modal.video-play-modal />--}}
{{--@endpersist--}}

@livewireScripts

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/backend/assets/plugins/global/plugins.bundle.js') }}" data-navigate-once></script>
<script src="{{ asset('assets/backend/assets/js/scripts.bundle.js') }}" data-navigate-once></script>
<!--end::Global Javascript Bundle-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js" data-navigate-once></script>

<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js" data-navigate-once></script>


@yield('footer')

<script data-navigate-once>
    document.addEventListener('livewire:navigated', () => {
        KTComponents.init();
        KTThemeMode.init();
        KTAppSidebar.init();

        KTMenu.init = function() {
            KTMenu.createInstances();
            KTMenu.initHandlers();
        }
        KTMenu.init()
    });
</script>

{{--<script data-navigate-once>--}}
{{--    document.addEventListener('livewire:load', () => {--}}
{{--        function updateKtMenu() {--}}
{{--            // Destroy all KTMenu instances--}}
{{--            var elements = document.querySelectorAll('[data-kt-menu="true"]');--}}
{{--            if (elements && elements.length > 0) {--}}
{{--                for (var i = 0, len = elements.length; i < len; i++) {--}}
{{--                    var menu = KTMenu.getInstance(elements[i]);--}}
{{--                    if (menu) {--}}
{{--                        menu.destroy();--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}

{{--            // Re-initialize KTMenu instances--}}
{{--            KTMenu.createInstances();--}}

{{--            // Update data-kt-menu-trigger attribute on new elements--}}
{{--            var newElements = document.querySelectorAll('[data-kt-menu="true"]:not([data-kt-menu-trigger])');--}}
{{--            if (newElements && newElements.length > 0) {--}}
{{--                for (var i = 0, len = newElements.length; i < len; i++) {--}}
{{--                    var newElement = newElements[i];--}}
{{--                    var parentElement = newElement.closest('[data-kt-menu="true"]');--}}
{{--                    if (parentElement) {--}}
{{--                        newElement.setAttribute('data-kt-menu-trigger', 'true');--}}
{{--                        KTMenu.getInstance(parentElement).update();--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}

{{--        // Call updateKtMenu on Livewire commit--}}
{{--        Livewire.hook('commit', ({ snapshot, effect }) => {--}}
{{--            updateKtMenu();--}}
{{--        });--}}

{{--        // Call updateKtMenu on Livewire element update--}}
{{--        Livewire.hook('element.updated', ({ component, el }) => {--}}
{{--            updateKtMenu();--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

<script data-navigate-once>
    var KK_Updated = false;

    function updateKtMenu()
    {
        if(!KK_Updated)
        {
            setTimeout(()=>{
                KTMenu.init()
                KK_Updated = false;
            },200)
        }
        KK_Updated = true;
    }
</script>

<script data-navigate-once>
    document.addEventListener('livewire:init', () => {

        // Livewire.hook('commit', ({succeed}) => {
        //     succeed(({ snapshot, effect }) => {
        //         updateKtMenu()
        //     })
        // });

        Livewire.hook('morph.updated', ({ el, component }) => {
             updateKtMenu()
        })

        Livewire.hook('element.init', ({ component, el }) => {
            updateKtMenu()
        })
    });
</script>

<!--For Filepond -->
<script src="{{asset('assets/filepond/dist/filepond.js')}}" data-navigate-once></script>
<script src="{{asset('assets/filepond/dist/filepond-plugin-file-validate-type.js')}}" data-navigate-once></script>
<!--For Filepond Ends-->

<!--For Editor -->
<script src="{{asset('assets/ckeditor/build/ckeditor.js')}}" data-navigate-once></script>
@switch(config('settings.editor_layout'))
    @case('tiny-ymc')
        <script src="https://cdn.tiny.cloud/1/gviiyo6zf65gzk15hbknqc8czs7tlepzcrilsupte6qsc4vf/tinymce/6/tinymce.min.js"  referrerpolicy="origin" data-navigate-track></script>
        {{--        <script src="{{asset('assets/TinyYMC/tinymce.min.js')}}" data-navigate-track></script>--}}
        @break
    @case('quill-editor')
        <script src="/assets/backend/assets/vendor/libs/quill/katex.js" data-navigate-track></script>
        <script src="/assets/backend/assets/vendor/libs/quill/quill.js" data-navigate-track></script>
        @break
    @default
@endswitch
<!--For Editor Ends-->


<script data-navigate-once>
    {!! File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
</script>

<!-- Latest compiled and minified JavaScript -->
{{-- <script src="https://unpkg.com/multiple-select@1.7.0/dist/multiple-select.min.js" data-navigate-once></script> --}}

<script src="{{ asset('assets/backend/assets/js/custom/apps/chat/chat.js') }}" data-navigate-once></script>

<!--For Select2 Ends-->
@stack('scripts')

<script data-navigate-once>
    window.route_prefix = "/admin/file-manager"
    document.addEventListener('livewire:navigated', () => {
        // FilePond.registerPlugin(FilePondPluginFileValidateType);
    })
    function removeFileByID(fileId = null)
    {
        if(fileId!==null)
        {
            $.ajax({
                method:'POST',
                url:'/api/admin/revert',
                data:{ 'file_id':fileId,'_token':$('meta[name="csrf-token"]').attr('content') },
                dataType:'JSON',
                success: function(response){ console.log(response)  }
            });
        }
    }
</script>

<script data-navigate-once>
    const site_settings = {
        'name':@json(config('settings.site_name'))
    }
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toastr-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    window.addEventListener('SetMessage', ({detail: {type, message, close, offCanvasHide}}) => {
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
        if(typeof close!='undefined'){
            $('.modal').modal('hide');
        }
        if(typeof offCanvasHide!="undefined")
        {
            let openedCanvas =  bootstrap.Offcanvas.getInstance(document.getElementById(offCanvasHide));
            openedCanvas.hide()
        }
    })
    @if(session()->has('message'))
    toastr.success(@json(session()->get('message')),site_settings.name)
    @endif
    @if(session()->has('error'))
    toastr.error(@json(session()->get('error')),site_settings.name)
    @endif
    @if($errors->any())
    @foreach($errors->all() as $error)
    toastr.error("{{$error}}",@json(config('settings.site_name','Error')));
    @endforeach
    @endif
    window.addEventListener('SweetMessage',({detail:{type,title,message,url = false}})=>{
        switch (type) {
            case 'success':
                if(url)
                {
                    Swal.fire({
                        title:title,
                        text: message,
                        icon: "success",
                        buttonsStyling: false,
                        showCancelButton: true,
                        cancelButtonText:'Back To List',
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton:  "btn btn-success",
                        }
                    }).then((event) => {
                        if(!event.isConfirmed){
                            window.location.href = url;
                        }

                    });
                }
                else{
                    Swal.fire({
                        title:title,
                        text: message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
                break;
            default:
                Swal.fire({
                    title:title,
                    text:message,
                    icon:'error'
                });
                break;
        }
    })
    window.addEventListener('OpenUrlNewTab',({detail:{url}})=>{
        window.open(url,'_blank');
    })
</script>
<script>
    $(function(){
        // toggle sidebar collapse
        $('.btn-toggle-sidebar').on('click', function(){
            $('.wrapper').toggleClass('sidebar-collapse');
        });
        // mark sidebar item as active when clicked
        $('.sb-item').on('click', function(){
            if ($(this).hasClass('btn-toggle-sidebar')) {
                return; // already actived
            }
            $(this).siblings().removeClass('active');
            $(this).siblings().find('.sb-item').removeClass('active');
            $(this).addClass('active');
        })
    });
    function dispatchEventCall(name = ''){
        const event = new CustomEvent(name);
        window.dispatchEvent(event);
    }
</script>
</body>
</html>
