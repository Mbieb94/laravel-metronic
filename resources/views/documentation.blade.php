@extends('skeleton')

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card card-flush h-md-100">
            <div class="pt-6 card-body">
                <div class="py-5">
                    <div class="p-10 border rounded d-flex flex-column flex-md-row">
                        <ul class="flex-row mb-3 border-0 nav nav-tabs nav-pills flex-md-column me-5 mb-md-0 fs-6 min-w-lg-200px"
                            role="tablist">
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-success active" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_4" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ki-duotone ki-icons/duotune/general/gen001.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('Master Data') }}</span>
                                        <span class="fs-7">{{ __('Role Management') }}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_5" aria-selected="false" role="tab" tabindex="-1">
                                    <i class="ki-duotone ki-icons/duotune/general/gen003.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('Master Data') }}</span>
                                        <span class="fs-7">{{ __('Users') }}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-danger" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_6" aria-selected="true" role="tab">
                                    <i class="ki-duotone ki-icons/duotune/general/gen017.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('Master Data') }}</span>
                                        <span class="fs-7">{{ __('Sysparams') }}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-secondary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_7" aria-selected="true" role="tab">
                                    <i class="ki-duotone ki-icons/duotune/general/gen017.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('App') }}</span>
                                        <span class="fs-7">{{ __('Assets') }}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-warning" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_8" aria-selected="true" role="tab">
                                    <i class="ki-duotone ki-icons/duotune/general/gen017.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('App') }}</span>
                                        <span class="fs-7">{{ __('Cost Centre') }}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_9" aria-selected="true" role="tab">
                                    <i class="ki-duotone ki-icons/duotune/general/gen017.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('App') }}</span>
                                        <span class="fs-7">{{ __('Plant Code') }}</span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item w-100" role="presentation">
                                <a class="nav-link w-100 btn btn-flex btn-active-light-primary" data-bs-toggle="tab"
                                    href="#kt_vtab_pane_10" aria-selected="true" role="tab">
                                    <i class="ki-duotone ki-icons/duotune/general/gen017.svg fs-2 text-primary"></i> <span
                                        class="d-flex flex-column align-items-start">
                                        <span class="fs-4 fw-bold">{{ __('App') }}</span>
                                        <span class="fs-7">{{ __('Asset Class') }}</span>
                                    </span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content w-100" id="myTabContent">
                            <div class="tab-pane fade active show" id="kt_vtab_pane_4" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - Role Management (e-asseting).pdf') }}"
                                    class="w-100" height="500"></iframe>
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_5" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - User (e-asseting).pdf') }}" class="w-100"
                                    height="500"></iframe>
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_6" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - Sysparams (e-asseting).pdf') }}"
                                    class="w-100" height="500"></iframe>
                            </div>

                            <div class="tab-pane fade" id="kt_vtab_pane_7" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - Assets (e-asseting).pdf') }}"
                                    class="w-100" height="500"></iframe>
                            </div>
                            <div class="tab-pane fade" id="kt_vtab_pane_8" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - costCentre (e-asseting).pdf') }}"
                                    class="w-100" height="500"></iframe>
                            </div>
                            <div class="tab-pane fade" id="kt_vtab_pane_9" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - Plant Code (e-asseting).pdf') }}"
                                    class="w-100" height="500"></iframe>
                            </div>
                            <div class="tab-pane fade" id="kt_vtab_pane_10" role="tabpanel">
                                <iframe src="{{ url('documentations/User Guide - Asset Class (e-asseting).pdf') }}"
                                    class="w-100" height="500"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
