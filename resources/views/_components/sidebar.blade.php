<div id="kt_app_sidebar" class="app-sidebar flex-column mt-lg-4 ps-2 pe-2 ps-lg-7 pe-lg-4" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo flex-shrink-0 d-none d-md-flex flex-center align-items-center" id="kt_app_sidebar_logo">
        <a href="{{ url('home') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/demo55.svg') }}" class="h-25px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
            <img alt="Logo" src="{{ asset('assets/media/logos/demo55-dark.svg') }}" class="h-25px theme-dark-show" />
        </a>
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-1"></i>
            </div>
        </div>
    </div>
    <div class="app-sidebar-menu flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-rounded menu-sub-indention fw-bold px-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a href="{{ url('home') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-category fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboards</span>
                        <span class="menu-arrow"></span>
                    </a>
                </div>
                
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('USER MANAGEMENT') }}</span>
                    </div>
                </div>

                <div class="menu-item" title="Data Master - User" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                    <a href="{{ url('user') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-user fs-2"></i>
                        </span>
                        <span class="menu-title">{{ __('Users') }}</span>
                        <span class="menu-arrow"></span>
                    </a>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-setting-2 fs-2"></i>
                        </span>
                        <span class="menu-title">{{ __('Role Management') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ url('roles') }}" title="Data Master - User" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-list"></span>
                                </span>
                                <span class="menu-title">{{ __('User Role') }}</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ url('priveleges') }}" title="Data Master - User" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-list"></span>
                                </span>
                                <span class="menu-title">{{ __('Privileges') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('PARAMETERS') }}</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a href="{{ url('sysparams') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-setting-4 fs-2"></i>
                        </span>
                        <span class="menu-title">{{ __('System Parameters') }}</span>
                        <span class="menu-arrow"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="app-sidebar-footer d-flex align-items-center px-8 pb-10" id="kt_app_sidebar_footer">
    </div>
</div>