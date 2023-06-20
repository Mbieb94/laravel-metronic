@extends('auth/login')

@section('form')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="text-center mb-11">
        <h1 class="text-dark fw-bolder mb-3">{{ __('Request Password') }}</h1>
        <div class="text-gray-500 fw-semibold fs-6">{{ __('Make sure the e-mail address is correct!') }}</div>
    </div>
    @if(session('success'))
    <div class="alert alert-primary d-flex align-items-center p-5 mb-3">
        <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
            <h4 class="mb-1 text-primary">{{ __('Email Sent') }}</h4>
            <span>{{ __('Please check email to continue the process') }}</span>
        </div>
    </div>
    @endif
    <div class="fv-row mb-7 form-floating">
        <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value="{{ old('email') }}"/>
        <label for="floatingInput">Email address</label>
    </div>

    <div class="d-grid mb-5">
        <button type="submit" id="kt_forgot_password_submit" class="btn btn-primary">
            <span class="indicator-label">Send request</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
</form>
@endsection
