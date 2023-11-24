<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.0
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href=""/>
		<title>{{ env('APP_NAME') }} | {{ ucwords(str_replace(['_'], ' ', request()->segment(1))) }}</title>
		<meta charset="utf-8" />
        <meta name="token" content="{{ session('bearer_token') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="hosturl" content="{{ url('') }}">
        <meta name="assets" content="{{ asset('') }}">
        <meta name="urlupload" content="{{ url('api/file_upload') }}">
        <meta name="deletefile" content="{{ url('api/delete_file') }}">
        <meta name="language" content="{{ App::getLocale() == 'id' ? 'id-ID' : 'en-US' }}">
		
        <meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		{{-- <meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" /> --}}
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		@yield('meta')
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
        @include('metronic/css')
        @yield('customcss')
	</head>
	<!--end::Head-->
    <script src="{{ asset('assets/js/custom/theme-handler.js') }}"></script>
	<!--begin::Body-->
	<body 
        @if (session('success')) notification_success="true"
        notification_message="{{ session('success') }}" @endif
        @if (session('warning')) notification_warning="true"
        notification_message="{{ session('warning') }}" @endif
        @if (session('info')) notification_info="true"
        notification_message="{{ session('info') }}" @endif
        @if (count($errors) > 0) notification_error="true"
        notification_data="{{ json_encode($errors->all()) }}" @endif
        id="kt_app_body" 
        data-kt-app-header-fixed="true" 
        data-kt-app-header-fixed-mobile="true" 
        data-kt-app-sidebar-enabled="true" 
        data-kt-app-sidebar-fixed="true" 
        data-kt-app-sidebar-hoverable="true" 
        data-kt-app-sidebar-push-header="true" 
        data-kt-app-sidebar-push-toolbar="true" 
        data-kt-app-sidebar-push-footer="true" 
        class="app-default">

        <div class="app-page-loader page-loader-logo d-block app-page-loader-bo">
            <div class="d-flex align-items-center justify-content-center flex-column h-100">
                <img alt="Logo" class="max-h-100px logo-spinner" src="{{ asset('assets/media/logos/default-small.svg') }}"
                    width="70">
                <div class="spinner-border text-primary mt-5" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
            </div>
        </div>
		<!--begin::Theme mode setup on page load-->
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				@include('_components/header')
				<!--end::Header-->
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Sidebar-->
					@include('_components/sidebar')
					<!--end::Sidebar-->
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_toolbar" class="app-toolbar pt-2 pt-lg-10">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
									<!--begin::Toolbar wrapper-->
									<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
										<!--begin::Page title-->
                                        @section('segments')
                                        <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                                            <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">
                                                {{ __(strtoupper(str_replace('_', ' ', request()->segment(1)))) }}</h1>
                                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                                                <li class="breadcrumb-item text-muted">
                                                    <i class="fas fa-home"></i>
                                                </li>
                                                @foreach (request()->segments() as $segment)
                                                    @if (is_numeric($segment))
                                                        @continue
                                                    @endif
                                                    <li class="breadcrumb-item">
                                                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                                    </li>
                                                    <li class="breadcrumb-item text-muted">
                                                        @if ($loop->first)
                                                            <a href="{{ url(request()->segment(1)) }}"
                                                                class="text-hover-primary">{{ __(ucwords(str_replace('_', ' ', $segment))) }}</a>
                                                        @else
                                                            {{ __(ucwords(str_replace('_', ' ', $segment))) }}
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @show
										<div class="d-flex align-items-center gap-2 gap-lg-3">
											@yield('toolbar')
										</div>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									@section('content')@show
								</div>
							</div>
						</div>
						<div id="kt_app_footer" class="app-footer">
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<div class="text-dark order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2023&copy;</span>
									<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
								</div>
								<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
									<li class="menu-item">
										<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
									</li>
									<li class="menu-item">
										<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
									</li>
									<li class="menu-item">
										<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-outline ki-arrow-up"></i>
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		@include('metronic/javascript')
        @yield('customjs')
        <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
	</body>
	<!--end::Body-->
</html>