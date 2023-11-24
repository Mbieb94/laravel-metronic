<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme
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
	<head>
		<title>{{ env('APP_NAME') }} | {{ ucwords(str_replace(['_'], ' ', request()->segment(1))) }}</title>
        <base href="" />
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
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

        @yield('meta')
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
        @include('metronic/css')
        @yield('customcss')
        <script src="{{ asset('assets/js/custom/theme-handler.js') }}"></script>
	</head>
	<!--end::Head-->
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
        id="kt_app_body" data-kt-app-layout="light-header" data-kt-app-header-fixed="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<div class="app-page-loader page-loader-logo d-block">
            <div class="d-flex align-items-center justify-content-center flex-column h-100">
                <img alt="Logo" class="max-h-100px logo-spinner" src="{{ asset('assets/media/logos/default-small.svg') }}"
                    width="70">
                <div class="spinner-border text-primary mt-5" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
            </div>
        </div>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header">
					<!--begin::Header container-->
					@include('_components/header')
					<!--end::Header container-->
				</div>
				<!--end::Header-->
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
                            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                                <!--begin::Toolbar container-->
                                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                                    @section('segments')
                                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                        <h1
                                            class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0 speech-text">
                                            {{ __(strtoupper(str_replace('_', ' ', request()->segment(1)))) }}</h1>
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
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
                                @section('toolbar')
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    </div>
                                @show
                                </div>
                                <!--end::Toolbar container-->
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Content-->
                            <div id="kt_app_content" class="app-content flex-column-fluid">
                                <!--begin::Content container-->
                                @section('content')
                                @show
                                <!--end::Content container-->
                            </div>
                            <!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						@include('_components/footer')
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		@include('metronic/javascript')
        @yield('customjs')
        <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
	</body>
	<!--end::Body-->
</html>