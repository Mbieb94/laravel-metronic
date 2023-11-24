<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Page</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <meta name="language" content="{{ App::getLocale() == 'id' ? 'id-ID' : 'en-US' }}">
    @include('metronic/css')

    <script src="{{ asset('assets/js/custom/theme-handler.js') }}"></script>
    <style>
        body {
            background-image: url('assets/media/auth/bg1.jpg');
        }

        [data-theme="dark"] body {
            background-image: url('assets/media/auth/bg1-dark.jpg');
        }
    </style>
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>body { background-image: url('assets/media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg10-dark.jpeg'); }</style>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency.png" alt="" />
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency-dark.png" alt="" />
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7 speech-text">Fast, Efficient and Productive</h1>
                    <div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
                    <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
                    <br />and provides some background information about
                    <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
                    <br />work following this is a transcript of the interview.</div>
                </div>
            </div>
            
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <div class="d-flex flex-center flex-column-fluid pb-15 pb-lg-20">
                            @section('form')
                            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                                action="{{ url('login') }}" method="POST">
                                @method('POST')
                                @csrf
                                <div class="text-center mb-11">
                                    <h1 class="mb-3 text-dark fw-bolder speech-text">Sign In</h1>
                                    <div class="text-gray-500 fw-semibold fs-6 speech-text" id="speech-text">Saya adalah manusia robot</div>
                                </div>
                                <div class="mb-5 fv-row form-floating">
                                    <input type="text" placeholder="login" name="login" autocomplete="off"
                                        class="bg-transparent form-control" value="{{ old('login') }}" />
                                    <label for="floatingInput">Username / Email address</label>
                                </div>
                                <div class="mb-5 fv-row form-floating">
                                    <input type="password" placeholder="Password" name="password" autocomplete="off"
                                        class="bg-transparent form-control" />
                                    <label for="floatingInput">Password</label>
                                </div>
                                <div class="flex-wrap gap-3 mb-8 d-flex flex-stack fs-base fw-semibold">
                                    <div class="block mt-4">
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember_me">
                                            <span
                                                class="text-gray-700 form-check-label fw-semibold fs-base ms-1">{{ __('Remember me') }}</span>
                                        </label>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    <a href="{{ url('forgot-password') }}" class="link-primary">Forgot Password ?</a>
                                </div>
                                <div class="mb-10 d-grid">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                        <span class="indicator-label">Sign In</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                            @show
                        </div>
                        <div class="d-flex flex-stack">
                            <div class="me-10">
                                <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="assets/media/flags/united-states.svg" alt="" />
                                    <span data-kt-element="current-lang-name" class="me-1">English</span>
                                    <span class="svg-icon svg-icon-5 svg-icon-muted rotate-180 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </button>
                                
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">English</span>
                                        </a>
                                    </div>
                                    
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                            <span class="symbol symbol-20px me-4">
                                                <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/indonesia.svg" alt="" />
                                            </span>
                                            <span data-kt-element="lang-name">Indonesia</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <a href="../../demo1/dist/pages/team.html" target="_blank">Terms</a>
                                <a href="../../demo1/dist/pages/pricing/column.html" target="_blank">Plans</a>
                                <a href="../../demo1/dist/pages/contact.html" target="_blank">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('metronic/javascript')
    <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    @yield('js')
</body>

</html>
