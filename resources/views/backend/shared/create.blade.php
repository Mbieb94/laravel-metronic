@extends('skeleton')

@section('content')
    <div class="card card-bordered">
        <div class="card-header ribbon ribbon-end">
            <div class="ribbon-label bg-primary">{{ ucwords(str_replace(['.', '_'],' ',request()->route()->getName())) }}
            </div>
            <div class="card-title">{{ ucwords(str_replace(['.', '_'],' ',request()->route()->getName())) }}</div>
        </div>
        <div class="card-body">
            @php
                $fieldRequired = [];
            @endphp
            <form action="{{ url(Request::segment(1)) }}" method="POST" id="formValidate" enctype="multipart/form-data">
                @csrf
                @foreach ($forms as $form)
                    @if (isset($form['hidden']) && $form['hidden'] == true)
                        @continue
                    @endif
                    @php
                        if ($form['required']) {
                            $fieldRequired[$form['name']] = __($form['label']);
                        }
                    @endphp
                    <div class="mb-8 form-group row">
                        <div class="col-xl-2 col-lg-2 col-form-label text-end">
                            <label
                                class="{{ isset($form['required']) && $form['required'] == true ? 'required' : '' }} form-label">{{ __($form['label']) }}</label>
                        </div>
                        @component('_forms.' . $form['type'] . '.input', ['data' => $form])
                        @endcomponent
                    </div>
                @endforeach
                <input name="xsubmit" value="1" type="hidden">
            </form>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ __(url(Request::segment(1))) }}" type="button" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>
                {{ __('Cancel') }}
            </a>
            <div class="d-flex">
                <button type="button" id="kt_btn_1" class="btn btn-success btn-submit me-3" data-xsubmit="1">
                    <i class="fas fa-save"></i>
                    <span class="indicator-label">{{ __('Submit and Leave') }}</span>
                    <span class="indicator-progress">{{ __('Please wait') }} ...
                        <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                </button>
                <button type="button" id="kt_btn_1" class="btn btn-primary btn-submit" data-xsubmit="2">
                    <i class="fas fa-save"></i>
                    <span class="indicator-label">{{ __('Submit and Stay') }}</span>
                    <span class="indicator-progress">{{ __('Please wait') }} ...
                        <span class="align-middle spinner-border spinner-border-sm ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
    <input type="hidden" id="filed-required" value='@json($fieldRequired)'>
@endsection
@section('customjs')
    <script src="{{ asset('assets/plugins/global/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/components/form-validation.js') }}"></script>
@endsection
