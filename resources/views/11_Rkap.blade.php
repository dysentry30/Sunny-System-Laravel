{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Group RKAP')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')


    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @extends('template.header')
                <!--end::Header-->


                <!--begin::Delete Alert -->
                {{-- <div class="alert alert-success" role="alert">
						Delete Success !
					</div> --}}
                <!--end::Delete Alert -->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Group RKAP
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 7px 30px 7px 30px">
                                        New</a>

                                    <!--begin::Wrapper-->
                                    <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6155ac804a1c2">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bolder">Choose actions:</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="">
                                                <!--begin::Item-->
                                                <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_import"  id="kt_toolbar_import">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                                </button>
                                                <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_export"  id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                                </button>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Wrapper-->


                                </div>
                                <!--end::Actions-->
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        {{-- <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                fill="black" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Proyek" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->

                        </div> --}}
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body py-10">
                            @if (auth()->user()->check_administrator)

                                @foreach ($unitkerjas as $unitKerja)
                                    <p>
                                        <a class="#" data-bs-toggle="collapse"
                                            href="#collapseRKAP{{ $unitKerja->divcode }}" role="button"
                                            aria-expanded="false" aria-controls="collapseRKAP{{ $unitKerja->divcode }}">
                                            {{ $unitKerja->unit_kerja }}
                                        </a>

                                    </p>
                                    <div class="collapse bg-dark" id="collapseRKAP{{ $unitKerja->divcode }}">
                                        <ul class="list-group list-group-flush">
                                            @if (!empty($unitKerja->Users))
                                                @foreach ($unitKerja->Users as $user)
                                                    @if (auth()->user()->check_administrator)
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="list-group-item list-group-item-action text-hover-primary"
                                                            aria-current="true">
                                                            {{ $user->name }}
                                                        </a>
                                                    @else
                                                        <a href="#"
                                                            class="list-group-item list-group-item-action text-hover-primary"
                                                            aria-current="true">
                                                            {{ $user->name }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li class="list-group-item">There is no data</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endforeach
                            @else
                                @php
                                    $unit_kerja = auth()->user()->UnitKerja;
                                @endphp
                                <p>
                                    <a class="#" data-bs-toggle="collapse"
                                        href="#collapseRKAP{{ $unit_kerja->divcode }}" role="button" aria-expanded="false"
                                        aria-controls="collapseRKAP{{ $unit_kerja->divcode }}">
                                        {{ $unit_kerja->unit_kerja }}
                                    </a>
                                </p>

                                <div class="collapse bg-dark" id="collapseRKAP{{ $unit_kerja->divcode }}">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($unit_kerja->Users as $user)
                                            <a href="#"
                                                class="list-group-item list-group-item-action text-hover-primary"
                                                aria-current="true">
                                                {{ $user->name }}
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>

                            @endif


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->


                </div>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
@endsection

