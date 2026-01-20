
<div class="wrapper sidebar-collapse">
    <div class="sidebar">
        <div class="d-flex align-items-center justify-items-center">
           <a href="{{ route('admin::dashboard') }}" wire:navigate>
               <div class="px-3 py-2 mb-5 w-55px">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47.5 47.5" id="q"><defs><clipPath id="a"><path d="M0 38h38V0H0v38Z"></path></clipPath></defs><g clip-path="url(#a)" transform="matrix(1.25 0 0 -1.25 0 47.5)"><path fill="#3b88c3" d="M37 5a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v28a4 4 0 0 0 4 4h28a4 4 0 0 0 4-4V5Z"></path><path fill="#fff" d="M24.088 15.07c.526 1.179.744 2.542.744 3.969 0 3.689-1.954 7.131-5.829 7.131-3.876 0-5.83-3.379-5.83-7.131 0-3.782 1.892-7.132 5.83-7.132a9.96 9.96 0 0 1 1.983.218l-1.115 1.085c-.342.31-.59.806-.59 1.24 0 1.209.838 2.232 2.109 2.232.434 0 .805-.155 1.178-.403l1.52-1.209Zm.371-6.077c-1.519-.868-3.348-1.364-5.456-1.364-6.295 0-10.666 4.992-10.666 11.41 0 6.449 4.34 11.41 10.666 11.41 6.231 0 10.665-5.116 10.665-11.41 0-2.729-.713-5.209-2.078-7.162l1.768-1.52c.589-.527 1.085-1.023 1.085-1.891 0-1.085-1.085-1.954-2.138-1.954-.684 0-1.24.28-2.078.993l-1.768 1.488z"></path></g></svg>
               </div>
           </a>
            <div class="sb-text-none fs-6 text-white">
                {{ config('settings.site_name') }}
            </div>
        </div>
        <div class="sb-item-list">
            @foreach($menus as $menu)
                @if(Arr::has($menu,'url'))
                    @if(Arr::has($menu,'submenu') && count($menu['submenu'])>0)
                        <div class="sb-item sb-menu {{ $menu['active'] == $segment1?'active':'' }}">
                            <span class="sb-icon">{!! $menu['icon'] ??'' !!}</span><span class="sb-text sb-text-none ps-1">{{ $menu['name'] ??'' }}</span>
                            <div class="sb-submenu">
                                @foreach($menu['submenu'] as $subMenu)
                                    @if(Arr::has($subMenu,'submenu') && count($subMenu['submenu'])>0)
                                        <div class="sb-item sb-menu {{ $menu['active'] == $segment1 && $subMenu['active'] == $segment2?'active':'' }}">
                                            <i class="sb-icon fa fa-chevron-right"></i><span class="sb-text">{{ $subMenu['name'] ??'' }}</span>
                                            <div class="sb-submenu">
                                                @foreach($subMenu['submenu'] as $supMenu)
                                                    <a href="{{ $supMenu['url'] ??'' }}" wire:navigate>
                                                       <div class="sb-item {{ $menu['active'] == $segment1 && $subMenu['active'] == $segment2 && $supMenu['active'] == $segment3?'active':'' }}">
                                                           <i class="sb-icon fa fa-address-card"></i>
                                                           <span class="sb-text">{{ $supMenu['name'] ??'' }}</span>
                                                       </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ $subMenu['url'] ??'' }}" wire:navigate>
                                            <div class="sb-item {{ $menu['active'] == $segment1 &&$subMenu['active'] == $segment2?'active':'' }}">
                                                    <i class="sb-icon fa fa-chevron-right"></i>
                                                    <span class="sb-text">{{ $subMenu['name'] ??'' }}</span>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu['url'] ??'' }}"
                           wire:navigate
                        >
                            <div class="sb-item {{ $menu['active'] == $segment1?'active':'' }}">
                                   <span class="sb-icon"
                                         data-bs-toggle="tooltip"
                                         data-bs-placement="right"
                                         data-bs-title="{{ $menu['name'] ??'' }}"
                                   >{!! $menu['icon'] ??'' !!}</span>
                                    <span class="sb-text sb-text-none">{{ $menu['name'] ??'' }}</span>
                            </div>
                        </a>
                    @endif
                @else
{{--                    <!--begin:Menu item-->--}}
{{--                    <div class="menu-item pt-5 sb-heading">--}}
{{--                        <!--begin:Menu content-->--}}
{{--                        <div class="menu-content">--}}
{{--                            <span class="menu-heading fw-bold text-uppercase fs-7">{{ $menu['name'] ??'' }}</span>--}}
{{--                        </div>--}}
{{--                        <!--end:Menu content-->--}}
{{--                    </div>--}}
{{--                    <!--end:Menu item-->--}}
                @endif
            @endforeach
            <div class="btn-toggle-sidebar sb-item"><i class="sb-icon fa fa-angle-double-left"></i><span class="sb-text">Collapse Sidebar</span><i class="sb-icon fa fa-angle-double-right"></i></div>
        </div>
    </div>
    <div class="main"></div>
</div>
