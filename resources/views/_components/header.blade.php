<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch flex-stack mt-lg-8" id="kt_app_header_container">
        <!--begin::Sidebar toggle-->
        <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
            <!--begin::Logo image-->
            <a href="#">
                <img alt="Logo" src="{{ asset('assets/media/logos/demo55-small.svg') }}" class="h-25px theme-light-show" />
                <img alt="Logo" src="{{ asset('assets/media/logos/demo55-small-dark.svg') }}" class="h-25px theme-dark-show" />
            </a>
            <!--end::Logo image-->
        </div>
        <!--end::Sidebar toggle-->
        <!--begin::Navbar-->
        <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
            @section('left-bar')
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">
                {{-- <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0 speech-text">{{ __(strtoupper(str_replace('_', ' ', request()->segment(1)))) }}</h1> --}}
                {{-- <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">
                    {{ __(strtoupper(str_replace('_', ' ', request()->segment(1)))) }}
                </h1> --}}
            </div>
            @show
            <div class="app-navbar-item d-flex align-items-stretch me-1 me-lg-0">
            @section('right-bar')
            <div class="">
                <!--begin::User info-->
                <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-overflow="true" data-kt-menu-placement="top-end">
                    <!--begin::Name-->
                    <div class="d-flex flex-column align-items-start justify-content-center me-3">
                        <span class="text-gray-500 fs-8 fw-semibold">Hello</span>
                        <a href="#" class="text-gray-800 fs-7 fw-bold text-hover-primary">{{ ucwords(Auth::user()->fullname) }}</a>
                    </div>
                    <div class="d-flex flex-center cursor-pointer symbol symbol-circle symbol-40px">
                        <img src="{{ Auth::getImage() }}" alt="image" />
                    </div>
                    <!--end::Name-->
                </div>
                <!--end::User info-->
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                <img alt="Logo" src="{{ Auth::getImage() }}" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">{{ ucwords(Auth::user()->fullname) }}
                                <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span></div>
                                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{ url('user/profile') }}" class="px-5 menu-link">{{ __('My Profile') }}</a>
                    </div>
                    <!--end::Menu item-->
                    <div class="px-5 menu-item">
                        <a href="{{ url('user/update_profile') }}" class="px-5 menu-link">{{ __('Update Profile') }}</a>
                    </div>
                    <div class="px-5 menu-item">
                        <a href="{{ url('user/reset_password') }}" class="px-5 menu-link">{{ __('Update Password') }}</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                        <a href="#" class="menu-link px-5">
                            <span class="menu-title position-relative">Mode
                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                            </span></span>
                        </a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-outline ki-night-day fs-2"></i>
                                    </span>
                                    <span class="menu-title">Light</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-outline ki-moon fs-2"></i>
                                    </span>
                                    <span class="menu-title">Dark</span>
                                </a>
                            </div>
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-outline ki-screen fs-2"></i>
                                    </span>
                                    <span class="menu-title">System</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
                        <?php
                            $flags = [
                                'en' => 'assets/media/flags/united-states.svg',
                                'id' => 'assets/media/flags/indonesia.svg',
                            ];
                        ?>
                        <a href="#" class="menu-link px-5">
                            <span class="menu-title position-relative">Language
                            <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ strtoupper(App::getLocale()) }}
                            <img class="w-15px h-15px rounded-1 ms-2" src="{{ asset($flags[App::getLocale()]) }}" alt="" /></span></span>
                        </a>
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            @foreach (Config::get('languages') as $lang => $language)
                            <div class="menu-item px-3">
                                <a href="{{ url('lang', $lang) }}" class="menu-link d-flex px-5 {{ $lang == App::getLocale() ? 'active' : '' }}">
                                <span class="symbol symbol-20px me-4">
                                    <img class="rounded-1" src="{{ asset($flags[$lang]) }}" alt="" />
                                </span>{{ $language }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <form action="{{ url('logout') }}" class="px-5 menu-item" id="logout-form" method="POST">
                        @method('POST')
                        @csrf
                        <a class="px-5 menu-link" onclick="$('#logout-form').submit()">{{ __('Sign Out') }}</a>
                    </form>
                </div>
            </div>
            @show
            </div>
        </div>
    </div>
</div>