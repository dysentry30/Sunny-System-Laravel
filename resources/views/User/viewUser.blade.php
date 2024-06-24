{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Lihat User')
{{-- End::Title --}}
<link rel="stylesheet" href="{{ asset('datatables/jquery.dataTables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('datatables/buttons.dataTables.min.css') }}" />
<!--begin::Main-->
@section('content')

    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->


                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::form-->
                    <!--begin::Toolbar-->
                    <form action="/user/update" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user-id" id="user-id" value="{{ $user->id }}">
                        <div class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Lihat User
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button type="button" onclick="onSave(this)" class="btn btn-sm btn-primary" id="customer_new_save"
                                        style="background-color:#008CB4;">
                                        Save</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button onclick="document.location.reload()" type="reset"
                                        class="btn btn-sm btn-light btn-active-danger pe-3 mx-2" id="cancel-button">
                                        Discard <i class="bi bi-x"></i></button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    @if (Auth::user()->can('super-admin') || Auth::user()->can('admin-crm'))
                                        <a href="/user" class="btn btn-sm btn-light btn-active-primary ms-3"
                                            id="customer_new_close">
                                            Close</a>
                                    @else
                                        <a href="/dashboard" class="btn btn-sm btn-light btn-active-primary ms-3"
                                            id="customer_new_close">
                                            Close</a>
                                    @endif
                                    <!--end::Button-->


                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Toolbar-->



                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-fluid">
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="row g-7">
                                    <!--begin::Contact groups-->
                                    <div class="col-lg-6 col-xl-3">
                                        <!--begin::Contact group wrapper-->
                                        <div class="card card-flush">

                                            <!--begin::Card body-->
                                            <div class="card-body pt-5">

                                                <!--begin::Input group Name-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                        <span class="required">NIP</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                            <i class="bi bi-search"></i>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <input type="text" id="nip" name="nip"
                                                            class="form-control form-control-solid ps-12"
                                                            value="{{ $user->nip }}" placeholder="NIP" readonly />
                                                    </div>
                                                    @error('nip')
                                                        <h6 class="text-danger">{{ $message }}</h6>
                                                    @enderror
                                                    <!--end::Input-->

                                                    <!--begin::Input group Name-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Name</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" id="name-user" name="name-user"
                                                            class="form-control form-control-solid"
                                                            value="{{ $user->name }}" placeholder="Name" readonly />
                                                        @error('name-user')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group Name-->

                                                    <!--begin::Input group Email-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Email</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="email" class="form-control form-control-solid"
                                                            id="email" name="email" value="{{ $user->email }}"
                                                            placeholder="Email" readonly />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group Email-->

                                                    <!--begin::Input group Phone-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Phone Number</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid"
                                                            id="phone-number" name="phone-number"
                                                            value="{{ $user->no_hp }}" placeholder="Phone Number"
                                                            readonly />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group Phone-->

                                                    <!--begin::Input group TTD-->
                                                    {{-- <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Upload Tanda Tangan</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="file" accept="image/jpg,image/jpeg" class="form-control form-control-solid"
                                                            id="upload-ttd" name="upload-ttd" placeholder="Upload Tanda Tangan" />
                                                        <!--end::Input-->
                                                        @if (!empty($user->file_ttd))
                                                            <small>File TTD view:</small><br>
                                                            <img src="{{asset("/file-ttd/$user->file_ttd")}}" alt="File TTD" class="img-fluid img-thumbnail">
                                                        @endif
                                                    </div> --}}
                                                    <!--end::Input group TTD-->

                                                    <!--begin::Input group is Active-->
                                                    @if (Auth::user()->can('super-admin') || Auth::user()->can('admin-crm'))
                                                        <div class="form-check me-12">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                {{ $user->is_active == 1 ? 'checked' : '' }}
                                                                name="is-active" id="is-active">
                                                            <!--end::Input-->
                                                            <label class="form-check-label">
                                                                <span class="">Is Active</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                    <!--end::Input group is Active-->

                                                    <!--begin::Input group Address 2-->
                                                    {{-- <div class="fv-row mb-7" style="margin-top:10px;">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                        <span>Alamat</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <textarea class="form-control form-control-solid" name="alamat">{{ $user->alamat }}</textarea> --}}
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->

                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contact group wrapper-->
                                    </div>
                                    <!--end::Contact groups-->

                                    <!--begin::Content-->
                                    <div class="col-xl-9">
                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                            <!--begin::Card body-->
                                            <div class="card-body pt-5">
                                                <!--begin:::Tabs-->
                                                <ul
                                                    class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                                    @if (Auth::user()->can('super-admin') || Auth::user()->can('admin-crm'))
                                                        <!--begin:::Tab item Informasi Perusahaan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4 active required"
                                                                data-bs-toggle="tab" href="#kt_user_view_overview_tab"
                                                                style="font-size:14px;">HAK AKSES &nbsp;</a>
                                                        </li>
                                                        <!--end:::Tab item Informasi Perusahaan-->

                                                        <!--begin:::Tab item Informasi Perusahaan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_user_password"
                                                                style="font-size:14px;">RESET PASSWORD</a>
                                                        </li>
                                                        <!--end:::Tab item Informasi Perusahaan-->
                                                    @else
                                                        <!--begin:::Tab item Informasi Perusahaan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary active pb-4"
                                                                data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_user_password"
                                                                style="font-size:14px;">RESET PASSWORD</a>
                                                        </li>
                                                        <!--end:::Tab item Informasi Perusahaan-->
                                                    @endif


                                                </ul>
                                                <!--end:::Tabs-->

                                                <!--begin:::Tab content -->
                                                <div class="tab-content" id="myTabContent">

                                                    @if (Auth::user()->can('super-admin') || Auth::user()->can('admin-crm'))
                                                        <!--begin:::Tab pane Hak Akses-->
                                                        <div class="tab-pane fade show active"
                                                            id="kt_user_view_overview_tab" role="tabpanel">

                                                            <p><b>Aplikasi</b></p>
                                                            <!--begin::Row-->
                                                            <div class="d-flex flex-row h-50px">
                                                                <!-- begin:: Form Input Group -->
                                                                @if (Auth::user()->can('super-admin'))
                                                                    <!-- begin:: Form Input Administrator -->
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value=""
                                                                            {{ $user->check_administrator == 1 ? 'checked' : '' }}
                                                                            name="administrator" id="administrator">
                                                                        <label class="form-check-label"
                                                                            for="administrator">
                                                                            Super Admin
                                                                        </label>
                                                                    </div>
                                                                    <!-- end:: Form Input Administrator -->

                                                                    <!-- begin:: Form Input User Sales -->
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value=""
                                                                            {{ $user->check_user_sales == 1 ? 'checked' : '' }}
                                                                            name="user-sales" id="user-sales">
                                                                        <label class="form-check-label" for="user-sales">
                                                                            CRM
                                                                        </label>
                                                                    </div>
                                                                    <!-- end:: Form Input Admin Kontrak -->

                                                                    <!-- begin:: Form Input Admin Kontrak -->
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value=""
                                                                            {{ $user->check_admin_kontrak == 1 ? 'checked' : '' }}
                                                                            name="admin-kontrak" id="admin-kontrak">
                                                                        <label class="form-check-label"
                                                                            for="admin-kontrak">
                                                                            CCM
                                                                        </label>
                                                                    </div>
                                                                    <!-- end:: Form Input Admin Kontrak -->

                                                                    <!-- begin:: Form Input Team Proyek -->
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value=""
                                                                            {{ $user->check_user_csi == 1 ? 'checked' : '' }}
                                                                            name="user-csi" id="user-csi">
                                                                        <label class="form-check-label" for="user-csi">
                                                                            CSI
                                                                        </label>
                                                                    </div>
                                                                    <!-- end:: Form Input Team Proyek -->
                                                                @endif

                                                                <!-- end:: Form Input Group -->
                                                            </div>
                                                            <!--end::Row-->
                                                            <hr>
                                                            <br>
                                                            <p><b>Role</b></p>
                                                            <div class="d-flex flex-row h-50px">
                                                                <!-- begin:: Form Input Group -->
                                                                @if (Auth::user()->can('super-admin'))
                                                                    <!-- begin:: Form Input Administrator -->
                                                                    <div class="form-check me-12">
                                                                        <input class="role form-check-input" type="checkbox"
                                                                            value="admin"
                                                                            {{ $user->role_admin == 1 ? 'checked' : '' }}
                                                                            name="role_admin" id="role_admin" onchange="checkAplikasi(this)">
                                                                        <label class="form-check-label" for="role_admin">
                                                                            Admin
                                                                        </label>
                                                                    </div>
                                                                    <!-- end:: Form Input Administrator -->
                                                                    @cannot('csi')
                                                                        <!-- begin:: Form Input User Sales -->
                                                                        <div class="form-check me-12">
                                                                            <input class="role form-check-input" type="checkbox"
                                                                                value="user"
                                                                                {{ $user->role_user == 1 ? 'checked' : '' }}
                                                                                name="role_user" id="role_user" onchange="checkAplikasi(this)">
                                                                            <label class="form-check-label" for="role_user">
                                                                                User
                                                                            </label>
                                                                        </div>
                                                                        <!-- end:: Form Input Admin Kontrak -->

                                                                        <!-- begin:: Form Input Admin Kontrak -->
                                                                        <div class="form-check me-12">
                                                                            <input class="role form-check-input" type="checkbox"
                                                                                value="approver"
                                                                                {{ $user->role_approver == 1 ? 'checked' : '' }}
                                                                                name="role_approver" id="role_approver" onchange="checkAplikasi(this)">
                                                                            <label class="form-check-label"
                                                                                for="role_approver">
                                                                                Approver
                                                                            </label>
                                                                        </div>
                                                                        <!-- end:: Form Input Admin Kontrak -->
                                                                        @can('super-admin')
                                                                            <!-- begin:: Form Input Admin Kontrak -->
                                                                            <div class="form-check me-12">
                                                                                <input class="role form-check-input" type="checkbox"
                                                                                    value="unlock"
                                                                                    {{ $user->is_unlock == 1 ? 'checked' : '' }}
                                                                                    name="role_unlock" id="role_unlock" onchange="checkAplikasi(this)">
                                                                                <label class="form-check-label"
                                                                                    for="role_unlock">
                                                                                    Unlock
                                                                                </label>
                                                                            </div>
                                                                            <!-- end:: Form Input Admin Kontrak -->
                                                                        @endcan

                                                                        @can('super-admin')
                                                                            <!-- begin:: Form Input Team Proyek -->
                                                                            <div class="form-check me-12">
                                                                                <input class="role form-check-input" type="checkbox"
                                                                                    value="risk"
                                                                                    {{ $user->role_risk == 1 ? 'checked' : '' }}
                                                                                    name="role_risk" id="role_risk" onchange="checkAplikasi(this)">
                                                                                <label class="form-check-label" for="role_risk">
                                                                                    Risk
                                                                                </label>
                                                                            </div>
                                                                            <!-- end:: Form Input Team Proyek -->
                                                                        @endcan
                                                                    @endcannot
                                                                @endif

                                                                <!-- end:: Form Input Group -->
                                                            </div>
                                                            <hr>
                                                            <br>

                                                            <!--begin:: D-flex -->
                                                            <div class="d-flex flex-column">
                                                                {{-- <select name="unit-kerja"
                                                                    class="form-select form-select-solid"
                                                                    data-control="select2" data-hide-search="true"
                                                                    data-placeholder="Unit Kerja" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <option data-select2-id="select2-data-6-c3oy"></option>
                                                                    @isset($user->unit_kerja)
                                                                        @foreach ($unit_kerjas as $unitKerja)
                                                                            @if ($user->unit_kerja == $unitKerja->divcode)
                                                                                <option value="{{ $unitKerja->divcode }}"
                                                                                    selected
                                                                                    data-select2-id="{{ $unitKerja->divcode }}">
                                                                                    {{ $unitKerja->unit_kerja }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($unit_kerjas as $unitKerja)
                                                                            <option value="{{ $unitKerja->divcode }}"
                                                                                data-select2-id="{{ $unitKerja->divcode }}">
                                                                                {{ $unitKerja->unit_kerja }}</option>
                                                                        @endforeach
                                                                    @endisset
                                                                </select> --}}

                                                                <h3 class="" id="HeadDetail"
                                                                    style="font-size:16px;">
                                                                    Set Unit-Kerja
                                                                    {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_pic">+</a> --}}
                                                                </h3>
                                                                <br>

                                                                <!--Begin :: Dropdown DOP -->
                                                                <div class="row">
                                                                    <div class="col" id="list-dop">
                                                                        @php
                                                                            $list_unit_kerja = str_contains($user->unit_kerja, ',') ? collect(explode(',', $user->unit_kerja)) : $user->unit_kerja;
                                                                            // dd($list_unit_kerja);
                                                                            if ($user->check_admin_kontrak) {
                                                                                $dops = $dops->where('dop', '!=', 'EA'); 
                                                                            }
                                                                        @endphp
                                                                        @foreach ($dops as $dop)
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <p><b>{{ $dop->dop }}</b></p>
                                                                                <button type="button"
                                                                                    onclick="selectAllUnitKerja(this)"
                                                                                    data-dop="{{ $dop->dop }}"
                                                                                    class="btn btn-link btn-sm">Select
                                                                                    all</button>
                                                                            </div>
                                                                            <div class=""
                                                                                style="display: grid; grid-template-rows: repeat(1, 1fr); grid-template-columns: repeat(5, 1fr); row-gap: 1rem;">
                                                                                @php
                                                                                    $dop->UnitKerjas = $dop->UnitKerjas->whereNotIn('divcode', ['B', 'C', 'D', '8']);
                                                                                @endphp
                                                                                @foreach ($dop->UnitKerjas as $unit_kerja)
                                                                                    <div
                                                                                        class="form-check me-3 d-flex align-items-center">
                                                                                        @php
                                                                                            // dd($list_unit_kerja);
                                                                                            $is_unit_kerja_choosen = $list_unit_kerja instanceof \Illuminate\Support\Collection ? $list_unit_kerja->contains($unit_kerja->divcode) : $list_unit_kerja == $unit_kerja->divcode;
                                                                                            // dd($is_unit_kerja_choosen);
                                                                                        @endphp
                                                                                        @if ($is_unit_kerja_choosen)
                                                                                            <input
                                                                                                class="unit-kerja-checkbox form-check-input me-2"
                                                                                                style="width: 1.5rem;height: 1.5rem;border-radius:3px;"
                                                                                                type="checkbox"
                                                                                                data-dop="{{ $dop->dop }}"
                                                                                                value="{{ $unit_kerja->divcode }}"
                                                                                                checked name="unit-kerja[]"
                                                                                                id="{{ $unit_kerja->divcode }}" 
                                                                                                onchange="checkAplikasi(this)">
                                                                                        @else
                                                                                            <input
                                                                                                class="unit-kerja-checkbox form-check-input me-2"
                                                                                                style="width: 1.5rem;height: 1.5rem;border-radius:3px;"
                                                                                                type="checkbox"
                                                                                                data-dop="{{ $dop->dop }}"
                                                                                                value="{{ $unit_kerja->divcode }}"
                                                                                                name="unit-kerja[]"
                                                                                                id="{{ $unit_kerja->divcode }}"
                                                                                                onchange="checkAplikasi(this)">
                                                                                        @endif
                                                                                        <label class="form-check-label"
                                                                                            for="{{ $unit_kerja->divcode }}">
                                                                                            <small>{{ $unit_kerja->unit_kerja }}</small>
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                            <br>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <!--End :: Dropdown DOP -->
                                                            </div>

                                                        </div>
                                                        <!--end:::Tab pane Hak Akses-->
                                                    @endif
                                                    <!--end:: D-flex -->


                                                    <!--Begin :: Reset Password -->
                                                    {{-- @if (Auth::user()->can('super-admin') || !Auth::user()->can('admin-crm'))
                                                            <div class="tab-pane fade show active" id="kt_user_view_overview_user_password" role="tabpanel">
                                                            @else
                                                                <div class="tab-pane fade" id="kt_user_view_overview_user_password" role="tabpanel">
                                                        @endif

                                                        <form action="/user/password/reset" autocomplete="off" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{ $user->id }}" name="id-user">
                                                            <div class="input-group input-group-sm">
                                                                <label class="input-group-text required" for="old-password">Old Password:</label>
                                                                <input type="password" name="old-password" onchange="checkCurrentPassword(this)"
                                                                    class="form-control" required>
                                                                <button class="btn btn-sm btn-secondary input-group-text" type="button"
                                                                    onclick="seePassword(this)"><i class="bi bi-eye-slash-fill fs-3"></i></button>
                                                            </div>
                                                            <div class="input-group input-group-sm my-3">
                                                                <label class="input-group-text required" for="new-password">New Password:</label>
                                                                <input type="password" name="new-password" class="form-control" required disabled>
                                                                <button class="btn btn-sm btn-secondary input-group-text" type="button"
                                                                    onclick="seePassword(this)"><i class="bi bi-eye-slash-fill fs-3"></i></button>
                                                            </div>
                                                            <div class="input-group input-group-sm mb-4">
                                                                <label class="input-group-text required" for="confirm-password">Confirm Password:</label>
                                                                <input type="password" name="confirm-password" onkeyup="confirmPassword(this)"
                                                                    class="form-control" required disabled>
                                                                <button class="btn btn-sm btn-secondary input-group-text" type="button"
                                                                    onclick="seePassword(this)"><i class="bi bi-eye-slash-fill fs-3"></i></button>
                                                            </div>
                                                            <div class="" style="position: relative; width: max-content;" data-bs-toggle="tooltip"
                                                                data-bs-title="Silahkan isi field di atas untuk bisa mengganti password">
                                                                <input type="submit" name="password-reset" class="btn btn-sm btn-active-primary text-white"
                                                                    style="background-color: #008CB4;" value="Reset Password" disabled />
                                                            </div>
                                                        </form> --}}
                                                    {{-- @if ($user->check_administrator == false)
                                                        @endif
                                                        @if ($user->check_administrator == true)
                                                        <form action="/user/password/reset" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{ $user->id }}" name="id-user">
                                                            <input type="hidden" value="" id="socket-id" name="socket-id">
                                                            <button type="submit" name="password-reset" class="btn btn-sm btn-active-primary text-white"
                                                            style="background-color: #008CB4;">Reset Password By Request</button>
                                                        </form>
                                                        @endif --}}
                                                    <!--End :: Reset Password -->

                                                    <!--Begin::Table List Proyek-->
                                                    <div class="overflow-auto table-list-proyek {{ $user->check_admin_kontrak && $user->role_user ? "" : "d-none" }}" id="table-list-proyek">
                                                        <!--begin::Table Proyek-->
                                                        <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-2" id="proyeks-ccm">
                                                             <!--begin::Table head-->
                                                             <thead>
                                                                 <!--begin::Table row-->
                                                                 <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase text-sm gs-0">
                                                                    <th class="min-w-auto ps-3">Kode Proyek</th>
                                                                    <th class="w-20">Nama Proyek</th>
                                                                    <th class="min-w-auto">Unit Kerja</th>
                                                                    <th class="min-w-auto">Selected</th>
                                                                 </tr>
                                                                 <!--end::Table row-->
                                                             </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-800">
                                                            </tbody>
                                                            <!--end::Table body-->

                                                        </table>
                                                        <!--end::Table Proyek-->
                                                        <input type="hidden" id="listProyek" name="list-proyek" value="">
                                                    </div>
                                                    <!--End::Table List Proyek-->

                                                </div>
                                                <!--end:::Tab content -->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Contacts App- Edit Contact-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->
                    </form>
                </div>
                <!--End::Content-->
            </div>
            <!--end::Wrapper-->

        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

@endsection

@section('js-script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        const user = {!! json_encode($user->toArray()) !!};
        const unitKerja = user.unit_kerja.includes(",") ? user.unit_kerja.split(",") : user.unit_kerja;
        const proyeks = user.proyeks_selected != null ? JSON.parse(user.proyeks_selected) : null;
        let selectedRows = {};
        if (proyeks != null) {
            newData = proyeks.forEach(function(proyek){
                selectedRows[proyek] = true
            });
        }
        const configDataTable = {};
        // configDataTable.pagingType ="simple"
        configDataTable.processing = true
        configDataTable.serverSide = true
        configDataTable.destroy = true
        configDataTable.search = false
        configDataTable.paging = false
        configDataTable.dom = '<"float-start me-3"f><"#example"t>rtip'


        document.addEventListener("DOMContentLoaded", () => {
            if (user.check_admin_kontrak && user.role_user) {
                console.log(configDataTable);
                configDataTable.ajax = {
                    dataType: "JSON",
                    cache: false,
                    contentType: "application/json; charset=utf-8",
                    url:"{{ url('/user/get-proyek-datatable?divcode=') }}"+JSON.stringify(unitKerja),
                    type: "GET"
                },
                configDataTable.columns = [ 
                    {
                        data: 'profit_center',
                        className: 'align-midle text-center'
                    },
                    {
                        data: 'proyek_name',
                        className: 'align-midle'
                    },
                    {
                        data: 'unit_kerja.unit_kerja',
                        className: 'align-midle text-center'
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            let selected = "";
                            if(proyeks != null){
                                selected = proyeks.indexOf(data.profit_center) !== -1 ? "checked" : "";
                            }
                            return `<input class="row-checkbox form-check-input mt-0" type="checkbox" name="proyeks[]" data-id="${data.profit_center}" value="${data.profit_center}"`+ (selected == "checked" || selectedRows[row.profit_center] ? 'checked' : '') +">"
                        },
                        className: 'align-midle text-center'
                    },
                ];
                const dataTable = $('#proyeks-ccm').DataTable(configDataTable);

                // Menangani perubahan status checkbox
                $('#proyeks-ccm tbody').on('change', '.row-checkbox', function() {
                    let rowId = $(this).data('id');
                    if (this.checked) {
                        selectedRows[rowId] = this.checked;
                    }else{
                        delete selectedRows[rowId]
                    }
                });

                // Menangani event draw.dt untuk mempertahankan status checkbox setelah redraw DataTable
                dataTable.on('draw.dt', function() {
                    for (let rowId in selectedRows) {
                        $('input.row-checkbox[data-id="' + rowId + '"]').prop('checked', selectedRows[rowId]);
                    }
                });
            }
        });

        function onSave(elt){
            const eltInputHidden = document.querySelector('#listProyek');
            // const listChecklistElt = document.querySelectorAll("[class*='row-checkbox']:checked");
            // const collectChecked = [];
            // if (listChecklistElt.length > 0) {
            //     listChecklistElt.forEach(function(checked){
            //         collectChecked.push(checked.value);
            //     });
            // }
            // const convertArraySelected = Object.keys(selectedRows);

            // if (collectChecked.length < 1 && convertArraySelected.length > 0) {
            //     eltInputHidden.value = JSON.stringify(convertArraySelected);
            // }else{

            // }
            const convertArraySelected = Object.keys(selectedRows);
            eltInputHidden.value = JSON.stringify(convertArraySelected);
            elt.form.submit();
        }

        async function checkCurrentPassword(e) {
            const password = e.value;
            const idUser = e.parentElement.parentElement.querySelector("input[name='id-user']").value;
            const token = "{{ csrf_token() }}";
            const formData = new FormData();
            formData.append("_token", token);
            formData.append("id_user", idUser);
            formData.append("password", password);
            const checkCurrentPasswordRes = await fetch("/check-current-password", {
                method: "POST",
                header: {
                    "Content-Type": "application/json",
                },
                body: formData,
            }).then(res => res.json());
            if (checkCurrentPasswordRes.status == "success") {
                e.classList.add("is-valid");
                e.classList.remove("is-invalid");
                const inputs = e.parentElement.parentElement.querySelectorAll(
                    "input:not([name='password-reset'], [name='_token'], [name='id-user'])");
                inputs.forEach(input => {
                    if (input.hasAttribute("disabled")) {
                        input.removeAttribute("disabled");
                    } else {
                        input.setAttribute("disabled", "");
                    }
                });
            } else {
                e.classList.remove("is-valid");
                e.classList.add("is-invalid");
                e.focus();
            }
        }

        function seePassword(e) {
            const input = e.parentElement.querySelector("input");
            const icon = e.querySelector("i");
            if (input.getAttribute("type") == "password") {
                input.setAttribute("type", "text");
                icon.classList.add("bi-eye-fill");
                icon.classList.remove("bi-eye-slash-fill");
            } else {
                input.setAttribute("type", "password");
                icon.classList.remove("bi-eye-fill");
                icon.classList.add("bi-eye-slash-fill");
            }
        }

        function confirmPassword(e) {
            const password = e.value;
            const submitBtn = e.parentElement.parentElement.querySelector("input[name='password-reset']");
            const newPasswordElt = e.parentElement.parentElement.querySelector("input[name='new-password']");
            if (password == newPasswordElt.value) {
                submitBtn.removeAttribute("disabled");
                e.classList.add("is-valid");
                e.classList.remove("is-invalid");
                new bootstrap.Tooltip(submitBtn.parentElement).disable();
            } else {
                submitBtn.setAttribute("disabled", "");
                e.classList.remove("is-valid");
                e.classList.add("is-invalid");
                new bootstrap.Tooltip(submitBtn.parentElement).enabled();
            }
        }

        function selectAllUnitKerja(e) {
            const dop = e.getAttribute("data-dop");
            const inputCheckUnitKerjas = document.querySelectorAll(`input[data-dop="${dop}"]`);
            inputCheckUnitKerjas.forEach(input => {
                input.checked = true;
            });
        }

        function highlight(e) {
            const element = e.querySelector("border");
            const elementI = e.querySelector("i");
            const elementSmall = e.querySelector("small");
            e.classList.add("border-primary");
            elementI.classList.add("text-primary");
            elementSmall.classList.add("text-primary");
        }

        function getImage(e) {
            e.preventDefault();
            e.stopPropagation();
            // console.log(e.dataTransfer.files);
        }

        function cancelImage(e) {
            const element = e;
            const elementI = e.querySelector("i");
            const elementSmall = e.querySelector("small");
            e.classList.remove("border-primary");
            elementI.classList.remove("text-primary");
            elementSmall.classList.remove("text-primary");
        }

        function checkAplikasi(elt) {
            const eltAplikasiCCM = document.querySelector('#admin-kontrak');
            const eltRoleUser = document.querySelector('#role_user');
            const eltRoleAll = document.querySelectorAll("[class*='role']:checked");

            if ((eltRoleAll.length > 1 && eltRoleAll[0].value == "admin" && eltRoleAll[1].value != "unlock")) {
                elt.checked = false;
                return alert('error', "Role tidak dapat dipilih lebih dari 1");
            }
            
            if (eltAplikasiCCM.checked && eltRoleUser.checked) {
                const collectInput = [...document.querySelectorAll("[class*='unit-kerja-checkbox']:checked")];
                const arrDivcode = [];
                const filterInputChecked = collectInput.map(function(element){
                    return arrDivcode.push(element.value);
                });

                const divTableHide = document.querySelector('#table-list-proyek');
                divTableHide.classList.remove('d-none');
                configDataTable.ajax = {
                    url:"{{ url('/user/get-proyek-datatable?divcode=') }}"+JSON.stringify(arrDivcode),
                    type: "GET"
                },
                configDataTable.columns = [ 
                    {
                        data: 'profit_center',
                        className: 'align-midle text-center'
                    },
                    {
                        data: 'proyek_name',
                        className: 'align-midle'
                    },
                    {
                        data: 'unit_kerja.unit_kerja',
                        className: 'align-midle text-center'
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `<input class="form-check-input mt-0" type="checkbox" name="proyeks[]" value="${data.profit_center}"`+ (selectedRows[row.profit_center] ? 'checked' : '') +">"
                        },
                        className: 'align-midle text-center'
                    },
                ];

                const dataTable = $('#proyeks-ccm').DataTable(configDataTable);
                // Menangani perubahan status checkbox
                $('#proyeks-ccm tbody').on('change', '.row-checkbox', function() {
                    let rowId = $(this).data('id');
                    if (this.checked) {
                        selectedRows[rowId] = this.checked;
                    }else{
                        delete selectedRows[rowId]
                    }
                });

                // Menangani event draw.dt untuk mempertahankan status checkbox setelah redraw DataTable
                dataTable.on('draw.dt', function() {
                    for (let rowId in selectedRows) {
                        $('input.row-checkbox[data-id="' + rowId + '"]').prop('checked', selectedRows[rowId]);
                    }
                });
            }else{
                const divTableHide = document.querySelector('#table-list-proyek');
                divTableHide.classList.add('d-none');
            }
        }
    </script>
@endsection
