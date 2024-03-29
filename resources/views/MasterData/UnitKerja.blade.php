{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Unit Kerja')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Unit kerja
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @php
                            $adminPIC = str_contains(auth()->user()->name, "(PIC)");
                            @endphp

                            @if (auth()->user()->check_administrator || $adminPIC)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 6px">
                                        New</a>

                                    <!--begin::Wrapper-->
                                    <div class="me-4" style="margin-left:10px;">
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
                                            <div class="px-7 py-5">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>
                                                    <label class="form-label" style="margin-left:5px;">
                                                        Export Excel</label><br>
                                                    <i class="bi bi-file-earmark-word"></i>
                                                    <label class="form-label" style="margin-left:5px;">
                                                        Import Excel</label><br>
                                                    <!--end::Label-->
                                                </div>
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
                        <div class="card-header border-0 py-2">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                {{-- <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Unit Kerja" />
                                </div> --}}
                                <!--end::Search-->

                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column" onchange="changes(this)"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option {{ $column == '' ? 'selected' : '' }}></option>
                                        <option value="nomor_unit" {{ $column == 'nomor_unit' ? 'selected' : '' }}>No Unit
                                        </option>
                                        <option value="unit_kerja" {{ $column == 'unit_kerja' ? 'selected' : '' }}>Nama Unit
                                        </option>
                                        <option value="divcode" {{ $column == 'divcode' ? 'selected' : '' }}>Divcode
                                        </option>
                                        <option value="dop" {{ $column == 'dop' ? 'selected' : '' }}>DOP</option>
                                        <option value="company" {{ $column == 'company' ? 'selected' : '' }}>Company
                                        </option>
                                        <option value="divisi" {{ $column == 'divisi' ? 'selected' : '' }}>Divisi</option>
                                        {{-- <option value="is_active" {{$column == "is_active" ? "selected" : ""}}>Is Active</option> --}}

                                    </select>
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="filter"
                                            name="filter" value="{{ $filter }}"
                                            class="form-control form-control-solid ms-2 ps-12 w-auto"
                                            placeholder="Input Filter" />
                                    </div>
                                    <!--end:: Input Filter-->

                                    <span style="display:none" id="select">
                                        <select id="select2" name="filter"
                                            class="form-select form-select-solid select2-hidden-accessible w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Yes/No"
                                            tabindex="-1" aria-hidden="true">
                                            <!--Inner HTML Here-->
                                        </select>
                                    </span>

                                    <script>
                                        let inputHTML =
                                            '<input type="text" data-kt-customer-table-filter="search" id="filter" name="filter" value="{{ $filter }}" class="form-control form-control-solid ms-2" placeholder="Input Filter"/>';
                                        let optionHTML = '<option></option>' +
                                            '<option value="1" {{ $filter == '1' ? 'selected' : '' }}>Yes</option>' +
                                            '<option value="0" {{ $filter == '0' ? 'selected' : '' }}>No</option>';

                                        function changes(e) {
                                            if (e.value == "is_active") {
                                                console.log(e.value);
                                                document.getElementById("filter").style.display = "none";
                                                document.getElementById("select").style.display = "";
                                                document.getElementById("select2").innerHTML = optionHTML;
                                                // window.location.href="/unit-kerja?column=is_active";
                                            } else {
                                                console.log(e.value);
                                                document.getElementById("select").style.display = "none";
                                                document.getElementById("filter").style.display = "";
                                                // document.getElementById("filter").innerHTML = inputHTML;
                                            }
                                        }
                                    </script>

                                    <!--end:: Input Filter-->

                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>
                                    <!--end:: Filter-->

                                    <!--begin:: RESET-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                    <script>
                                        function resetFilter() {
                                            $("#column").select2({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");

                                            $("#filter").text({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER-->

                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-60px text-center">@sortablelink('nomor_unit', 'No.Unit')</th>
                                        <th class="min-w-auto">@sortablelink('unit_kerja', 'Nama Unit')</th>
                                        <th class="min-w-auto">@sortablelink('divcode', 'Divcode')</th>
                                        <th class="min-w-auto">@sortablelink('dop', 'DOP')</th>
                                        <th class="min-w-auto">@sortablelink('company', 'Company')</th>
                                        <th class="min-w-auto">@sortablelink('divisi', 'Divisi PIC')</th>
                                        <th class="min-w-auto">@sortablelink('is_active', 'Is Active')</th>
                                        <th class="min-w-auto">@sortablelink('id_profit_center', 'ID Profit Center')</th>
                                        <th class="min-w-auto">@sortablelink('company_code', 'Company Code')</th>
                                        @if (auth()->user()->check_administrator)
                                            <th class="text-center">Settings</th>
                                            <th class="text-center">Action</th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                {{-- @php
												$proyeks = $proyeks->reverse();
												@endphp --}}

                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($unitkerjas as $unitkerja)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td class="text-center">
                                                {{ $unitkerja->nomor_unit }}
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                <a href="#kt_modal_update_{{$unitkerja->divcode}}" data-bs-toggle="modal" id="click-name"
                                                    class="text-gray-600 text-hover-primary mb-1">{{ $unitkerja->unit_kerja }}</a>
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->divcode }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->dop }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->company }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->divisi }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->is_active == 1 ? 'Yes' : 'No' }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->id_profit_center ?? "-"}}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $unitkerja->company_code ?? "-"}}
                                            </td>
                                            <!--end::Coloumn-->

                                            @if (auth()->user()->check_administrator)
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_unit_kerja{{ $unitkerja->id }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-success">Setting Approval
                                                    </button>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action=-->
                                                <!--begin::Action=-->
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $unitkerja->id }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
                                                    </button>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action=-->

                                                <div class="modal fade" id="kt_modal_unit_kerja{{ $unitkerja->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <form action="/unit-kerja/setting/save"
                                                        id="form-{{ $unitkerja->id }}" method="post"
                                                        onsubmit="return restoreData(this)">
                                                        @csrf
                                                        <input type="hidden" name="id-unit-kerja"
                                                            value="{{ $unitkerja->id }}">
                                                        <!--begin::Modal dialog-->
                                                        <div class="modal-dialog modal-dialog-centered mw-500px">
                                                            <!--begin::Modal content-->
                                                            <div class="modal-content">
                                                                <!--begin::Modal header-->
                                                                <div class="modal-header">
                                                                    <!--begin::Modal title-->
                                                                    <h2 class="fw-normal">Setting Approval untuk
                                                                        <b>{{ $unitkerja->unit_kerja }}</b>
                                                                    </h2>
                                                                    <!--end::Modal title-->
                                                                    <!--begin::Close-->
                                                                    <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                                        data-bs-dismiss="modal">
                                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                                        <span class="svg-icon svg-icon-1">
                                                                            <span class="svg-icon svg-icon-1">
                                                                                <i class="bi bi-x-lg"></i>
                                                                            </span>
                                                                        </span>
                                                                        <!--end::Svg Icon-->
                                                                    </div>
                                                                    <!--end::Close-->
                                                                </div>
                                                                <!--end::Modal header-->
                                                                <!--begin::Modal body-->
                                                                <div class="modal-body py-lg-6 px-lg-6">

                                                                    <!--begin::Input group-->
                                                                    <h6 class="">Metode Approval</h6>
                                                                    <div
                                                                        class="d-flex flex-column h-50px justify-content-evenly">
                                                                        <select name="metode-approval"
                                                                            class="form-select form-select-solid select2-hidden-accessible"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Pilih Metode Approval"
                                                                            tabindex="-1" aria-hidden="true">
                                                                            <option></option>
                                                                            <option value="Paralel"
                                                                                {{ $unitkerja->metode_approval == 'Paralel' ? 'selected' : '' }}>
                                                                                Paralel</option>
                                                                            <option value="Sequence"
                                                                                {{ $unitkerja->metode_approval == 'Sequence' ? 'selected' : '' }}>
                                                                                Sequence</option>
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input group-->

                                                                    {{-- begin:: Input Group --}}
                                                                    <hr>
                                                                    <div
                                                                        class="d-flex flex-column justify-content-between">
                                                                        @if (count($unitkerja->Users) < 1)
                                                                            <div class="text-center">
                                                                                <h6>Data user tidak ditemukan</h6>
                                                                                <a href="/user/new"
                                                                                    class="btn btn-sm btn-active-primary text-white"
                                                                                    style="background-color: #008CB4;">Tambah
                                                                                    User</a>
                                                                            </div>
                                                                        @else
                                                                            @if (count($unitkerja->Users) > 0)
                                                                                <div class="">
                                                                                    <h6>User 1</h6>
                                                                                    <select name="user-1"
                                                                                        onchange="refreshUserData(this)"
                                                                                        class="form-select form-select-solid select2-hidden-accessible select-user"
                                                                                        data-control="select2"
                                                                                        data-hide-search="true"
                                                                                        data-placeholder="Pilih User"
                                                                                        tabindex="-1" aria-hidden="true">
                                                                                        <option></option>
                                                                                        @foreach ($unitkerja->Users as $user)
                                                                                            @if ($unitkerja->user_1 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    selected disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @elseif($unitkerja->user_2 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @elseif($unitkerja->user_3 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @else
                                                                                                <option
                                                                                                    value="{{ $user->id }}">
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @endif
                                                                                            {{-- @foreach ($unitkerja->Users as $user)
                                                                                            @endforeach --}}
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <br>
                                                                            @endif

                                                                            @if (count($unitkerja->Users) > 1)
                                                                                <div class="">
                                                                                    <h6>User 2</h6>
                                                                                    <select name="user-2"
                                                                                        onchange="refreshUserData(this)"
                                                                                        class="form-select form-select-solid select2-hidden-accessible select-user"
                                                                                        data-control="select2"
                                                                                        data-hide-search="true"
                                                                                        data-placeholder="Pilih User"
                                                                                        tabindex="-1" aria-hidden="true">
                                                                                        <option></option>
                                                                                        @foreach ($unitkerja->Users as $user)
                                                                                            @if ($unitkerja->user_1 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @elseif($unitkerja->user_2 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    selected disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @elseif($unitkerja->user_3 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @else
                                                                                                <option
                                                                                                    value="{{ $user->id }}">
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <br>
                                                                            @endif

                                                                            @if (count($unitkerja->Users) > 2)
                                                                                <div class="">
                                                                                    <h6>User 3</h6>
                                                                                    <select name="user-3"
                                                                                        onchange="refreshUserData(this)"
                                                                                        class="form-select form-select-solid select2-hidden-accessible select-user"
                                                                                        data-control="select2"
                                                                                        data-hide-search="true"
                                                                                        data-placeholder="Pilih User"
                                                                                        tabindex="-1" aria-hidden="true">
                                                                                        <option></option>
                                                                                        @foreach ($unitkerja->Users as $user)
                                                                                            @if ($unitkerja->user_1 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @elseif($unitkerja->user_2 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @elseif($unitkerja->user_3 == $user->id)
                                                                                                <option
                                                                                                    value="{{ $user->id }}"
                                                                                                    selected disabled>
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @else
                                                                                                <option
                                                                                                    value="{{ $user->id }}">
                                                                                                    {{ $user->name }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                    {{-- End:: Input Group --}}
                                                                </div>
                                                                <!--end::Modal body-->

                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-active-primary text-white"
                                                                        style="background-color: #008CB4;">Save
                                                                        Setting</button>
                                                                    <button type="button" id="button-reset"
                                                                        name="button-reset"
                                                                        onclick="resetSelectOptions(this, true)"
                                                                        {{-- onclick="this.form.reset()" --}}
                                                                        class="btn btn-sm btn-light btn-active-primary">Reset
                                                                        Pilihan</button>
                                                                </div>
                                                            </div>
                                                            <!--end::Modal content-->
                                                        </div>
                                                        <!--end::Modal dialog-->
                                                    </form>
                                                </div>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->



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

    @foreach ($unitkerjas as $unitKerja)
        <!--begin::Modal-->

        <form action="/unit-kerja/update" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="modal" value="kt_modal_update_{{$unitKerja->divcode}}">
            <!--begin::Modal - Create App-->
            {{-- <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer"> --}}

            <!--begin::Modal - Create Proyek-->
            <div class="modal fade" id="kt_modal_update_{{$unitKerja->divcode}}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-900px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Unit Kerja</h2>
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


                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nomer ID</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="nomor-unit"
                                            name="nomor-unit" value="{{ $unitKerja->nomor_unit }}" placeholder="Nomer ID" />
                                        @error('nomor-unit')
                                            <h6 class="text-danger">{{ $message }}</h6>
                                        @enderror
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Unit Kerja</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="unit-kerja"
                                            name="unit-kerja" value="{{ $unitKerja->unit_kerja }}" placeholder="Unit Kerja" />
                                        @error('unit-kerja')
                                            <h6 class="text-danger">{{ $message }}</h6>
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
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Div Code</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="divcode"
                                            name="divcode" value="{{ $unitKerja->divcode }}" placeholder="Div Code" />
                                        @error('divcode')
                                            <h6 class="text-danger">{{ $message }}</h6>
                                        @enderror
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">DOP</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="dop-update-{{$unitKerja->divcode}}" name="dop" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="DOP">
                                            <option></option>
                                            @foreach ($dops as $dop)
                                                @if ($unitKerja->dop == $dop->dop)
                                                    <option value="{{ $dop->dop }}" selected>{{ $dop->dop }}</option>
                                                @else
                                                    <option value="{{ $dop->dop }}">{{ $dop->dop }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('dop')
                                            <h6 class="text-danger">{{ $message }}</h6>
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
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Company</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="company-update-{{$unitKerja->divcode}}" name="company" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="Company">
                                            <option></option>
                                            @foreach ($companies as $company)
                                                @if ($company->nama_company == $unitKerja->company)
                                                    <option value="{{ $company->nama_company }}" selected>
                                                        {{ $company->nama_company }}</option>
                                                @else
                                                    <option value="{{ $company->nama_company }}">
                                                        {{ $company->nama_company }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('company')
                                            <h6 class="text-danger">{{ $message }}</h6>
                                        @enderror
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Divisi PIC</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="divisi"
                                            name="divisi" value="{{ $unitKerja->divisi }}" placeholder="Divisi" />
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
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Is Active :</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="is-active-update-{{$unitKerja->divcode}}" name="is-active" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="Yes / No">
                                            <option></option>
                                            <option value="1" {{$unitKerja->is_active ? "selected" : ""}}>Yes</option>
                                            <option value="0" {{!$unitKerja->is_active ? "selected" : ""}}>No</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <div class="col-6">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Profit Center</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="profit-center"
                                        name="profit-center" value="{{ $unitKerja->id_profit_center }}" placeholder="Profit Center" />
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Company Code</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="company-code"
                                            name="company-code" value="{{ $unitKerja->company_code }}" placeholder="Company Code" />
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--End::Row Kanan+Kiri-->


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Update</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Create App-->
        </form>
        <!--end::Modals-->
    @endforeach


    <!--begin::Modal-->

    <form action="/unit-kerja/save" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="modal" value="kt_modal_create">

        <!--begin::Modal - Create App-->
        {{-- <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer"> --}}

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Unit Kerja</h2>
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


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nomer ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="nomor-unit"
                                        name="nomor-unit" value="{{ old('nomor-unit') }}" placeholder="Nomer ID" />
                                    @error('nomor-unit')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Unit Kerja</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="unit-kerja"
                                        name="unit-kerja" value="{{ old('unit-kerja') }}" placeholder="Unit Kerja" />
                                    @error('unit-kerja')
                                        <h6 class="text-danger">{{ $message }}</h6>
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
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Div Code</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="divcode"
                                        name="divcode" value="{{ old('divcode') }}" placeholder="Div Code" />
                                    @error('divcode')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">DOP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="dop" name="dop" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="DOP">
                                        <option></option>
                                        @foreach ($dops as $dop)
                                            @if ($dop->dop == null)
                                                <option value="{{ $dop->dop }}" selected>{{ $dop->dop }}</option>
                                            @else
                                                <option value="{{ $dop->dop }}">{{ $dop->dop }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('dop')
                                        <h6 class="text-danger">{{ $message }}</h6>
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
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Company</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="company" name="company" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Company">
                                        <option></option>
                                        @foreach ($companies as $company)
                                            @if ($company->nama_company == null)
                                                <option value="{{ $company->nama_company }}" selected>
                                                    {{ $company->nama_company }}</option>
                                            @else
                                                <option value="{{ $company->nama_company }}">
                                                    {{ $company->nama_company }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('company')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Divisi PIC</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="divisi"
                                        name="divisi" value="{{ old('divisi') }}" placeholder="Divisi" />
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
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Is Active :</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="is-active" name="is-active" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Yes / No">
                                        <option></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-6">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Profit Center</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="profit-center"
                                    name="profit-center" value="{{ old('profit-center') }}" placeholder="Profit Center" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="col-6">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Company Code</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="company-code"
                                        name="company-code" value="{{ old('company-code') }}" placeholder="Company Code" />
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--End::Row Kanan+Kiri-->


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    <!--end::Modals-->

    <!--begin::modal DELETE-->
    @foreach ($unitkerjas as $unitkerja)
        <form action="/unit-kerja/delete/{{ $unitkerja->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $unitkerja->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $unitkerja->unit_kerja }}</h2>
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
    <!--end::modal DELETE-->


@endsection

<!--end::Main-->

@section('js-script')
    <script>
        // let choosenUserIDArray = {
        //     user_1: 0,
        //     user_2: 0,
        //     user_3: 0,
        // };
        let choosenUserIDArray = [];

        function refreshUserData(elt) {
            const choosenUserID = elt.value;
            const thisSelectName = elt.getAttribute("name");
            const selectElts = elt.parentElement.parentElement.querySelectorAll(".select-user");
            choosenUserIDArray = choosenUserIDArray.filter(item => {
                return item != choosenUserID;
            });
            choosenUserIDArray.push(choosenUserID);
            // if (thisSelectName == "user-1") {
            //     choosenUserIDArray.user_1 = choosenUserID;
            // } else if (thisSelectName == "user-2") {
            //     choosenUserIDArray.user_2 = choosenUserID;
            // } else {
            //     choosenUserIDArray.user_3 = choosenUserID;
            // }

            selectElts.forEach(select => {
                const options = select.querySelectorAll("option");
                const selectName = select.getAttribute("name");
                options.forEach(option => {
                    const userID = option.getAttribute("value");
                    const isHasSelect2 = option.hasAttribute("data-select2-id");
                    if (choosenUserIDArray.includes(userID)) {
                        option.setAttribute("disabled", "");
                    } else {
                        option.removeAttribute("disabled");
                    }
                })
            });
        }

        // Begin :: Reset Options for Setting Approval
        function resetSelectOptions(elt, resetAll = true) {
            const selectElts = elt.parentElement.parentElement.querySelectorAll("select");
            if (resetAll) {
                $(selectElts).select2("val", "All");
                selectElts.forEach(select => {
                    const options = select.querySelectorAll("option");
                    const selectName = select.getAttribute("name");
                    options.forEach(option => {
                        const userID = option.getAttribute("value");
                        if (choosenUserIDArray.includes(userID)) {
                            choosenUserIDArray = choosenUserIDArray.filter(item => item != userID);
                        }
                    });
                });
                choosenUserIDArray = choosenUserIDArray.filter(item => item != "");
            }
            refreshUserData(elt);
        }
        // End :: Reset Options for Setting Approval

        // Begin :: Restore All Data for Submtting
        function restoreData(form) {
            // const getFormID = form.getAttribute("id");
            const selectElts = form.parentElement.querySelectorAll(`select`);
            selectElts.forEach(select => {
                const options = select.querySelectorAll("option");
                const selectName = select.getAttribute("name");
                options.forEach(option => {
                    option.removeAttribute("disabled");
                });
            });
            return true;
        }
        // End :: Restore All Data for Submtting
    </script>
@endsection
