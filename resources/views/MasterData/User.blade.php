a{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Users Management')
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
                @include('template.header')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Users Management
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "Rahmad"))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    {{-- <a href="/user/new" class="btn btn-sm btn-primary w-80px"
                                        style="background-color:#008CB4; padding: 7px 30px 7px 30px">
                                        New</a> --}}
                                    {{-- <button class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_user" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        New</button> --}}
                                    <button class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_user_new" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        New</button>

                                    <!--begin::Wrapper-->
                                    {{-- <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                            id="kt_menu_6155ac804a1c2">
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
                                                <button type="submit"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_import"
                                                    id="kt_toolbar_import">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                                </button>
                                                <button type="submit"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_export"
                                                    id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                                </button>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div> --}}
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
                        <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Panel-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">
                                    
                                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" aria-selected="true" href="#kt_panel_view_1"
                                                style="font-size:14px;">User Wika</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                        
                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_panel_view_2" style="font-size:14px;">User Customer Wika</a>
                                        </li>
                                        <!--end:::Tab item -->

                                    </ul>

                                </div>
                                <!--end::Panel-->
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-3 ">
                            <div id="tab-content" class="tab-content">
                                
                                <!--begin::Panel-->
                                <div class="tab-pane fade show active" id="kt_panel_view_1" role="tabpanel">
                                    <!--begin::Table-->
                                    <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="user_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto px-4">No.</th>
                                                {{-- <th class="min-w-auto">Nip</th> --}}
                                                <th class="min-w-auto">Name</th>
                                                <th class="min-w-auto">Username</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Role</th>
                                                <th class="min-w-auto text-center">Is Active</th>
                                                <th class="min-w-auto">Nomor Kontak</th>
                                                @if (auth()->user()->check_administrator)
                                                    <th class="text-center">
                                                        Action
                                                    </th>
                                                @endif
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        @php
                                            // $companies = $companies->reverse();
                                            $no = 1;
                                        @endphp
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($users as $user)
                                            @if (!Auth::user()->can('csi'))
                                                <tr>

                                                    <!--begin::No-->
                                                    <td class="px-4">
                                                        {{ $no++ }}
                                                    </td>
                                                    <!--end::No-->

                                                    <!--begin::NIP-->
                                                    {{-- <td>
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="text-hover-primary text-gray-600">{{ $user->nip }}</a>
                                                    </td> --}}
                                                    <!--end::NIP-->

                                                    <!--begin::Ketua tender-->
                                                    <td>
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="text-hover-primary text-gray-600">{{ $user->name }}</a>
                                                    </td>
                                                    <!--end::Ketua tender-->

                                                    <!--begin::Ketua tender-->
                                                    <td>
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="text-hover-primary text-gray-600">{{ $user->email }}</a>
                                                    </td>
                                                    <!--end::Ketua tender-->

                                                    <!--begin::unit-->
                                                    <td>
                                                        @php
                                                            $unit_kerja_user = str_contains($user->unit_kerja, ",") ? collect(explode(",", $user->unit_kerja)) : collect($user->unit_kerja);
                                                        @endphp
                                                        {{-- {{ $user->unit_kerja ?? '-' }} --}}
                                                        @foreach ($unit_kerja_user as $item)
                                                            {{ $item }}
                                                        @endforeach
                                                        {{-- {{ $unit_kerja_user ?? '-' }} --}}
                                                    </td>
                                                    <!--end::unit-->

                                                    <!--begin::Role-->
                                                    <td>
                                                        @if (!$user->check_administrator &&
                                                            !$user->check_admin_kontrak &&
                                                            !$user->check_user_sales &&
                                                            !$user->check_user_mobile &&
                                                            !$user->check_user_ska_skt &&
                                                            !$user->check_team_proyek)
                                                            <span class="text-danger">Belum ditentukan</span>
                                                        @endif
                                                        @if ($user->check_administrator)
                                                            - Administrator <br>
                                                        @endif
                                                        @if ($user->check_admin_kontrak)
                                                            - Admin Kontrak <br>
                                                        @endif
                                                        @if ($user->check_user_sales)
                                                            - User Sales <br>
                                                        @endif
                                                        @if ($user->check_team_proyek)
                                                            - Team Proyek <br>
                                                        @endif
                                                        @if ($user->check_user_mobile)
                                                            - Mobile <br>
                                                        @endif
                                                        @if ($user->check_user_ska_skt)
                                                            - SKA SKT <br>
                                                        @endif
                                                    </td>
                                                    <!--end::Role-->

                                                    <!--begin::Created at-->
                                                    <td class="text-center">
                                                        <p class="fs-6 badge {{ $user->is_active == true ? 'badge-light-success' : 'badge-light-danger' }}">
                                                            {{ $user->is_active == true ? 'yes' : '* No' }}
                                                        </p>
                                                    </td>
                                                    <!--end::Created at-->

                                                    <!--begin::Email-->
                                                    <td class="px-4">
                                                        {{ $user->no_hp ?? '-' }}
                                                    </td>
                                                    <!--end::Email-->

                                                    @if (auth()->user()->check_administrator)
                                                        <!--begin::Action-->
                                                        <td class="text-center">
                                                            <!--begin::Button-->
                                                            <button data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_delete{{ $user->id }}"
                                                                id="modal-delete"
                                                                class="btn btn-sm btn-light btn-active-primary">Delete
                                                            </button>
                                                            </form>
                                                            <!--end::Button-->
                                                        </td>
                                                        <!--end::Action-->
                                                    @endif
                                                </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Panel-->

                                <!--begin::Panel-->
                                <div class="tab-pane fade" id="kt_panel_view_2" role="tabpanel">
                                    <!--begin::Table-->
                                    <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="user_table_2">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto px-4">No.</th>
                                                {{-- <th class="min-w-auto">Nip</th> --}}
                                                <th class="min-w-auto">Name</th>
                                                <th class="min-w-auto">Username</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Role</th>
                                                <th class="min-w-auto text-center">Is Active</th>
                                                <th class="min-w-auto">Nomor Kontak</th>
                                                @if (auth()->user()->check_administrator)
                                                    <th class="text-center">
                                                        Action
                                                    </th>
                                                @endif
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        @php
                                            // $companies = $companies->reverse();
                                            $no = 1;
                                        @endphp
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($users as $user)
                                            @if (Auth::user()->can('csi'))
                                                <tr>

                                                    <!--begin::No-->
                                                    <td class="px-4">
                                                        {{ $no++ }}
                                                    </td>
                                                    <!--end::No-->

                                                    <!--begin::NIP-->
                                                    {{-- <td>
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="text-hover-primary text-gray-600">{{ $user->nip }}</a>
                                                    </td> --}}
                                                    <!--end::NIP-->

                                                    <!--begin::Ketua tender-->
                                                    <td>
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="text-hover-primary text-gray-600">{{ $user->name }}</a>
                                                    </td>
                                                    <!--end::Ketua tender-->

                                                    <!--begin::Ketua tender-->
                                                    <td>
                                                        <a href="/user/view/{{ $user->id }}"
                                                            class="text-hover-primary text-gray-600">{{ $user->email }}</a>
                                                    </td>
                                                    <!--end::Ketua tender-->

                                                    <!--begin::unit-->
                                                    <td>
                                                        @php
                                                            $unit_kerja_user = str_contains($user->unit_kerja, ",") ? collect(explode(",", $user->unit_kerja)) : collect($user->unit_kerja);
                                                        @endphp
                                                        {{-- {{ $user->unit_kerja ?? '-' }} --}}
                                                        @foreach ($unit_kerja_user as $item)
                                                            {{ $item }}
                                                        @endforeach
                                                        {{-- {{ $unit_kerja_user ?? '-' }} --}}
                                                    </td>
                                                    <!--end::unit-->

                                                    <!--begin::Role-->
                                                    <td>
                                                        @if (!$user->check_administrator &&
                                                            !$user->check_admin_kontrak &&
                                                            !$user->check_user_sales &&
                                                            !$user->check_team_proyek)
                                                            <span class="text-danger">Belum ditentukan</span>
                                                        @endif
                                                        @if ($user->check_administrator)
                                                            - Administrator <br>
                                                        @endif
                                                        @if ($user->check_admin_kontrak)
                                                            - Admin Kontrak <br>
                                                        @endif
                                                        @if ($user->check_user_sales)
                                                            - User Sales <br>
                                                        @endif
                                                        @if ($user->check_team_proyek)
                                                            - Team Proyek <br>
                                                        @endif
                                                    </td>
                                                    <!--end::Role-->

                                                    <!--begin::Created at-->
                                                    <td class="text-center">
                                                        <p class="fs-6 badge {{ $user->is_active == true ? 'badge-light-success' : 'badge-light-danger' }}">
                                                            {{ $user->is_active == true ? 'yes' : '* No' }}
                                                        </p>
                                                    </td>
                                                    <!--end::Created at-->

                                                    <!--begin::Email-->
                                                    <td class="px-4">
                                                        {{ $user->no_hp ?? '-' }}
                                                    </td>
                                                    <!--end::Email-->

                                                    @if (auth()->user()->check_administrator)
                                                        <!--begin::Action-->
                                                        <td class="text-center">
                                                            <!--begin::Button-->
                                                            <button data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_delete{{ $user->id }}"
                                                                id="modal-delete"
                                                                class="btn btn-sm btn-light btn-active-primary">Delete
                                                            </button>
                                                            </form>
                                                            <!--end::Button-->
                                                        </td>
                                                        <!--end::Action-->
                                                    @endif
                                                </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Panel-->

                            </div>
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

    <!--begin::Modal New User-->
    <form action="/user/save" method="post" enctype="multipart/form-data">
        @csrf
        
        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create_user" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New User</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-lg"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
                        
                        <!--begin::Get Modal JS-->
                        <input type="hidden" class="modal-name" name="modal-name">
                        <!--end::Get Modal JS-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Name</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" id="name-user" name="name-user" class="form-control form-control-solid" 
                                    value="{{ old('name-user') }}" placeholder="Name" style="cursor: context-menu"/>
                                    @error('name-user')
                                    <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Email</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="email" class="form-control form-control-solid" 
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Email" style="cursor: context-menu"/>
                                    @error('email')
                                    <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Phone Number</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" 
                                    id="phone-number" name="phone-number" value="{{ old('phone-number') }}" placeholder="Phone Number" style="cursor: context-menu"/>
                                    @error('phone-number')
                                    <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                        <span>NIP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" 
                                    id="nip" name="nip" value="{{ old("nip") }}" placeholder="NIP" onfocusout="getNip(this)"/>
                                    <!--end::Input-->
                                </div>
                                @error('nip')
                                    <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                @enderror
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Options-->
                        <br>
                        <div class="d-flex" style="flex-direction: row">
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6 ms-4 align-middle">
                                <input class="form-check-input" type="checkbox" value="" id="administrator" name="administrator" />
                                <span class="form-check-label me-8 required"><b>Administrator</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="user-sales" name="user-sales" />
                                <span class="form-check-label me-8 required"><b>User Sales</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="team-proyek" name="team-proyek" />
                                <span class="form-check-label me-8 required"><b>Team Proyek</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="admin-kontrak" name="admin-kontrak" />
                                <span class="form-check-label me-8 required"><b>Admin Kontrak</b></span>
                            </label>
                            <!--end::Options-->
                        </div>
                        <br>
                        <br>
                        <!--end::Options-->
                        
                        <!--begin:: D-flex -->
                        <div class="col-6">
                            <select name="unit-kerja" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja" data-select2-id="select2-data-4-1hgp" tabindex="-1" aria-hidden="true">
                                <option data-select2-id="select2-data-6-c3oy"></option>
                                @foreach ($unit_kerjas as $unitKerja)
                                <option value="{{$unitKerja->divcode}}" data-select2-id="{{$unitKerja->divcode}}">{{$unitKerja->unit_kerja}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <!--end:: D-flex -->

                        <!--begin::Row Kanan+Kiri-->
                        {{-- <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Address Line 1</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" name="AddressLine1"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Address Line 2</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" name="AddressLine2"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div> --}}
                        <!--End::Row Kanan+Kiri-->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                style="background-color:#008CB4">Save</button>
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    <!--end::Modal New User-->

    <form action="/user/role/save" method="post" enctype="multipart/form-data">
        @csrf
        
        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create_user_new" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New User</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-lg"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
                        
                        <!--begin::Get Modal JS-->
                        <input type="hidden" class="modal-name" name="modal-name">
                        <!--end::Get Modal JS-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Name Pegawai</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="nip-pegawai" name="nip"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilh Pegawai"
                                        tabindex="-1" aria-hidden="true">
                                        <option value=""></option>
                                        @foreach ($pegawai_all as $pegawai)
                                            <option value="{{ $pegawai->nip }}">{{ $pegawai->nip }} - {{ $pegawai->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Options-->
                        <br>
                        <label class="fs-6 fw-bold form-label mt-3">Aplikasi</label>
                        <div class="d-flex flex-row">
                            {{-- <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6 ms-4 align-middle">
                                <input class="form-check-input" type="checkbox" value="" id="administrator" name="administrator" />
                                <span class="form-check-label me-8 required"><b>Super Admin</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="user-sales" name="user-sales" />
                                <span class="form-check-label me-8 required"><b>CRM</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="user-csi" name="user-csi" />
                                <span class="form-check-label me-8 required"><b>CSI</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="admin-kontrak" name="admin-kontrak" />
                                <span class="form-check-label me-8 required"><b>CCM</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="mobile" name="mobile" />
                                <span class="form-check-label me-8 required"><b>Mobile</b></span>
                            </label>
                            <!--end::Options-->
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                                <input class="form-check-input" type="checkbox" value="" id="ska-skt" name="ska-skt" />
                                <span class="form-check-label me-8 required"><b>SKA SKT</b></span>
                            </label>
                            <!--end::Options--> --}}

                            @foreach ($collectAplikasi as $aplikasi)
                                @php
                                    switch ($aplikasi->kode_aplikasi) {
                                        case 'SUPER':
                                            $namaInput = "administrator";
                                            // $isChecked = $user->check_administrator ? "checked" : "";
                                            break;
                                        case 'CRM':
                                            $namaInput = "user-sales";
                                            // $isChecked = $user->check_user_sales ? "checked" : "";
                                            break;
                                        case 'CCM':
                                            $namaInput = "admin-kontrak";
                                            // $isChecked = $user->check_admin_kontrak ? "checked" : "";
                                            break;
                                        case 'CSI':
                                            $namaInput = "user-csi";
                                            // $isChecked = $user->check_user_csi ? "checked" : "";
                                            break;
                                        case 'MOB':
                                            $namaInput = "mobile";
                                            // $isChecked = $user->check_user_mobile ? "checked" : "";
                                            break;
                                        
                                        default:
                                            $namaInput = "";
                                            // $isChecked = "";
                                            break;
                                    }
                                @endphp
                                <!-- begin:: Form Input Administrator -->
                                <div class="form-check me-12">
                                    <input class="form-check-input" type="checkbox"
                                        value="{{ $aplikasi->nama_aplikasi }}"
                                        name="aplikasi[]" id="aplikasi">
                                    <label class="form-check-label"
                                        for="{{ $namaInput }}">
                                        {{ $aplikasi->nama_aplikasi }}
                                    </label>
                                </div>
                                <!-- end:: Form Input Administrator -->                                                                        
                            @endforeach
                        </div>
                        <br>
                        <br>
                        <!--end::Options-->
                        
                        <!--begin:: D-flex -->
                        <div class="row">
                            <select name="unit-kerja" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja" data-select2-id="select2-data-4-1hgp" tabindex="-1" aria-hidden="true">
                                <option data-select2-id="select2-data-6-c3oy"></option>
                                @foreach ($unit_kerjas as $unitKerja)
                                <option value="{{$unitKerja->divcode}}" data-select2-id="{{$unitKerja->divcode}}">{{$unitKerja->unit_kerja}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <!--end:: D-flex -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                style="background-color:#008CB4">Save</button>
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>

    {{-- begin::modal DELETE --}}
    @foreach ($users as $user)
        <form action="/user/delete/{{ $user->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $user->name }}</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-primary">Delete</button>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    {{-- end::modal DELETE --}}

@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#user_table').DataTable( {
                dom: '<"float-start"f><"#user_table"t>rtip',
                // dom: 'frtip',
                pageLength : 50,
                // ordering : false,
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ]
            } );

            $("#nip-pegawai").select2({
                dropdownParent: $("#kt_modal_create_user_new")
            });
        } );
    </script>
    <!--end::Data Tables-->

    <script>
        async function getNip(e){
            const data = e.value;
            let namaElt = document.getElementById("name-user")
            let emailElt = document.getElementById("email")
            let phoneElt = document.getElementById("phone-number")
            await fetch(`/testing-user/${data}`, {
                method: 'GET',
            }).then((result)=>{
                return result.json();
            }).then((data)=>{
                if(data.status == true){
                    document.getElementById("name-user").value = data.data.name
                    document.getElementById("email").value = data.data.email
                    document.getElementById("phone-number").value = data.data.phone
                }else{
                    document.getElementById("name-user").value = ""
                    document.getElementById("email").value = ""
                    document.getElementById("phone-number").value = ""
                }
            }).catch((err)=>{
                console.log(err)
            })
            // console.log(data, namaElt, emailElt, phoneElt)
        }
    </script>
    
    <script>
        function copyPassword(elt) {
            const pwGenerated = document.querySelector("#pw-generated");
            var r = document.createRange();
            r.selectNode(pwGenerated);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(r);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            elt.innerHTML = `
			<i class='bi bi-clipboard-check text-dark'></i>
			`;
        }
    </script>
@endsection
