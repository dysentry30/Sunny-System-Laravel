{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Lihat User')
{{-- End::Title --}}

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
                                    <button type="submit" class="btn btn-sm btn-primary" id="customer_new_save"
                                        style="background-color:#008CB4;">
                                        Save</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-danger ms-3" onclick="document.location.reload()" style="display: none;" id="cancel-button">
                                        Cancel</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    @if (Auth::user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
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
                                                            class="form-control form-control-solid ps-12" value="{{ $user->nip }}"
                                                            placeholder="NIP" />
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
                                                        class="form-control form-control-solid" value="{{ $user->name }}"
                                                        placeholder="Name" />
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
                                                        placeholder="Email" />
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
                                                        id="phone-number" name="phone-number" value="{{ $user->no_hp }}"
                                                        placeholder="Phone Number" />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group Phone-->

                                                <!--begin::Input group is Active-->
                                                @if (str_contains(Auth::user()->name, "(PIC)")) 
                                                    <div class="form-check me-12">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input" type="checkbox" value="" {{ $user->is_active == 1 ? 'checked' : '' }} 
                                                        name="is-active" id="is-active">
                                                        <!--end::Input-->
                                                        <label class="form-check-label">
                                                            <span class="">Is Active</span>
                                                        </label>
                                                    </div>
                                                @else
                                                    <div class="form-check me-12">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input" type="checkbox" value=""
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
                                                    @if (str_contains(auth()->user()->name, "(PIC)"))
                                                        <!--begin:::Tab item Informasi Perusahaan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4 active required"
                                                                data-bs-toggle="tab" href="#kt_user_view_overview_tab"
                                                                style="font-size:14px;">HAK AKSES &nbsp;</a>
                                                        </li>
                                                        <!--end:::Tab item Informasi Perusahaan-->
                                                    
                                                        <!--begin:::Tab item Informasi Perusahaan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_user_password"
                                                                style="font-size:14px;">RESET PASSWORD</a>
                                                        </li>
                                                        <!--end:::Tab item Informasi Perusahaan-->
                                                    @else 
                                                    
                                                        <!--begin:::Tab item Informasi Perusahaan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary active pb-4" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_user_password"
                                                                style="font-size:14px;">RESET PASSWORD</a>
                                                        </li>
                                                        <!--end:::Tab item Informasi Perusahaan-->
                                                    @endif


                                                </ul>
                                                <!--end:::Tabs-->

                                                <!--begin:::Tab content -->
                                                <div class="tab-content" id="myTabContent">

                                                    @if (str_contains(auth()->user()->name, "(PIC)"))
                                                        <!--begin:::Tab pane Hak Akses-->
                                                        <div class="tab-pane fade show active" id="kt_user_view_overview_tab"
                                                            role="tabpanel">

                                                            <!--begin::Row-->
                                                            <div class="d-flex flex-row h-50px">
                                                                {{-- begin:: Form Input Group --}}

                                                                @if (Auth::user()->check_administrator)
                                                                    {{-- begin:: Form Input Administrator --}}
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value=""
                                                                            {{ $user->check_administrator == 1 ? 'checked' : '' }}
                                                                            name="administrator" id="administrator">
                                                                        <label class="form-check-label" for="administrator">
                                                                            Administrator
                                                                        </label>
                                                                    </div>
                                                                    {{-- end:: Form Input Administrator --}}

                                                                    {{-- begin:: Form Input Admin Kontrak --}}
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value=""
                                                                            {{ $user->check_admin_kontrak == 1 ? 'checked' : '' }}
                                                                            name="admin-kontrak" id="admin-kontrak">
                                                                        <label class="form-check-label" for="admin-kontrak">
                                                                            Admin Kontrak
                                                                        </label>
                                                                    </div>
                                                                    {{-- end:: Form Input Admin Kontrak --}}

                                                                    {{-- begin:: Form Input Team Proyek --}}
                                                                    <div class="form-check me-12">
                                                                        <input class="form-check-input" type="checkbox"
                                                                        value=""
                                                                        {{ $user->check_team_proyek == 1 ? 'checked' : '' }}
                                                                        name="team-proyek" id="team-proyek">
                                                                        <label class="form-check-label" for="team-proyek">
                                                                            Team Proyek
                                                                        </label>
                                                                    </div>
                                                                    {{-- end:: Form Input Team Proyek --}}
                                                                @endif
                                                                {{-- begin:: Form Input User Sales --}}
                                                                <div class="form-check me-12">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value=""
                                                                        {{ $user->check_user_sales == 1 ? 'checked' : '' }}
                                                                        name="user-sales" id="user-sales">
                                                                    <label class="form-check-label" for="user-sales">
                                                                        User Sales
                                                                    </label>
                                                                </div>
                                                                {{-- end:: Form Input Admin Kontrak --}}

                                                                {{-- end:: Form Input Group --}}
                                                            </div>
                                                            <!--end::Row-->
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
                                                                            $list_unit_kerja = str_contains($user->unit_kerja, ",") ? collect(explode(",", $user->unit_kerja)) : $user->unit_kerja;
                                                                            // dd($list_unit_kerja);
                                                                        @endphp
                                                                        @foreach ($dops as $dop)
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <p><b>{{$dop->dop}}</b></p>
                                                                                <button type="button" onclick="selectAllUnitKerja(this)" data-dop="{{$dop->dop}}" class="btn btn-link btn-sm">Select all</button>
                                                                            </div>
                                                                            <div class="" style="display: grid; grid-template-rows: repeat(1, 1fr); grid-template-columns: repeat(5, 1fr); row-gap: 1rem;">
                                                                                @php
                                                                                    $dop->UnitKerjas = $dop->UnitKerjas->whereNotIn("divcode", ["B", "C", "D", "8"])
                                                                                @endphp
                                                                                @foreach ($dop->UnitKerjas as $unit_kerja)
                                                                                    <div class="form-check me-3 d-flex align-items-center">
                                                                                        @php
                                                                                            // dd($list_unit_kerja);
                                                                                            $is_unit_kerja_choosen =  $list_unit_kerja instanceof \Illuminate\Support\Collection ? $list_unit_kerja->contains($unit_kerja->divcode) : $list_unit_kerja == $unit_kerja->divcode;
                                                                                            // dd($is_unit_kerja_choosen);
                                                                                        @endphp
                                                                                        @if ($is_unit_kerja_choosen)
                                                                                            <input class="form-check-input me-2" style="width: 1.5rem;height: 1.5rem;border-radius:3px;" type="checkbox"
                                                                                                data-dop="{{$dop->dop}}"
                                                                                                value="{{$unit_kerja->divcode}}" checked
                                                                                                name="unit-kerja[]" id="{{$unit_kerja->divcode}}">
                                                                                        @else 
                                                                                            <input class="form-check-input me-2" style="width: 1.5rem;height: 1.5rem;border-radius:3px;" type="checkbox"
                                                                                                data-dop="{{$dop->dop}}"
                                                                                                value="{{$unit_kerja->divcode}}"
                                                                                                name="unit-kerja[]" id="{{$unit_kerja->divcode}}">
                                                                                        @endif
                                                                                        <label class="form-check-label" for="{{$unit_kerja->divcode}}">
                                                                                            <small>{{$unit_kerja->unit_kerja}}</small>
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
                                                </form>
                                                <!--end:: D-flex -->
                                                    
                                                    
                                                <!--Begin :: Reset Password -->
                                                @if (!str_contains(auth()->user()->name, "(PIC)"))
                                                    <div class="tab-pane fade show active" id="kt_user_view_overview_user_password" role="tabpanel">
                                                @else 
                                                    <div class="tab-pane fade" id="kt_user_view_overview_user_password" role="tabpanel">
                                                @endif
                                                    
                                                    <form action="/user/password/reset" autocomplete="off" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $user->id }}" name="id-user">
                                                        {{-- <input type="hidden" value="" id="socket-id" name="socket-id"> --}}
                                                        <div class="input-group input-group-sm">
                                                            <label class="input-group-text required" for="old-password">Old Password:</label>
                                                            <input type="password" name="old-password" onchange="checkCurrentPassword(this)" class="form-control" required>
                                                            <button class="btn btn-sm btn-secondary input-group-text" type="button" onclick="seePassword(this)"><i class="bi bi-eye-slash-fill fs-3"></i></button>
                                                        </div>
                                                        <div class="input-group input-group-sm my-3">
                                                            <label class="input-group-text required" for="new-password">New Password:</label>
                                                            <input type="password" name="new-password" class="form-control" required disabled>
                                                            <button class="btn btn-sm btn-secondary input-group-text" type="button" onclick="seePassword(this)"><i class="bi bi-eye-slash-fill fs-3"></i></button>
                                                        </div>
                                                        <div class="input-group input-group-sm mb-4">
                                                            <label class="input-group-text required" for="confirm-password">Confirm Password:</label>
                                                            <input type="password" name="confirm-password" onkeyup="confirmPassword(this)" class="form-control" required disabled>
                                                            <button class="btn btn-sm btn-secondary input-group-text" type="button" onclick="seePassword(this)"><i class="bi bi-eye-slash-fill fs-3"></i></button>
                                                        </div>
                                                        <div class="" style="position: relative; width: max-content;" data-bs-toggle="tooltip" data-bs-title="Silahkan isi field di atas untuk bisa mengganti password">
                                                            <input type="submit" name="password-reset" class="btn btn-sm btn-active-primary text-white"
                                                            style="background-color: #008CB4;" value="Reset Password" disabled/>
                                                        </div>
                                                    </form>
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

                                                </div>
                                                <!--End :: Reset Password -->
                                                
            </div>
            <!--end:::Tab content-->
        </div>
    </div>
</div>
</div>
</div>
</div>
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

    </div>
    <!--end::Content-->

    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--begin::Modal-->
    <!--begin::Modal - Create App-->
    <!--end::Modal - Create App-->

@endsection

@section('js-script')
    <script>
        async function checkCurrentPassword(e) {
            const password = e.value;
            const idUser = e.parentElement.parentElement.querySelector("input[name='id-user']").value;
            const token = "{{csrf_token()}}";
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
            if(checkCurrentPasswordRes.status == "success") {
                e.classList.add("is-valid");
                e.classList.remove("is-invalid");
                const inputs = e.parentElement.parentElement.querySelectorAll("input:not([name='password-reset'], [name='_token'], [name='id-user'])");
                inputs.forEach(input => {
                    if(input.hasAttribute("disabled")) {
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
            if(input.getAttribute("type") == "password") {
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
            if(password == newPasswordElt.value) {
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
    </script>
@endsection