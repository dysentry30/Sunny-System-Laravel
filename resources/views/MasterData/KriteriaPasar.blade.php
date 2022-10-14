{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Kriteria Pasar')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Kriteria Pasar
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

                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option {{ $column == '' ? 'selected' : '' }}></option>
                                        <option value="kategori" {{ $column == 'kategori' ? 'selected' : '' }}>Kategori
                                        </option>
                                        <option value="kriteria" {{ $column == 'kriteria' ? 'selected' : '' }}>Kriteria
                                        </option>
                                        <option value="bobot" {{ $column == 'bobot' ? 'selected' : '' }}>Bobot</option>
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
                                        <th class="min-w-auto">@sortablelink('kategori', 'Kategori')</th>
                                        <th class="min-w-auto">@sortablelink('kriteria', 'Kriteria Value')</th>
                                        <th class="min-w-auto">@sortablelink('bobot', 'Bobot')</th>
                                        @if (auth()->user()->check_administrator)
                                            <th class="text-center">Action</th>
                                        @endif
                                        {{-- <th class=""><center>Action</center></th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                {{-- @php
												$proyeks = $proyeks->reverse();
												@endphp --}}
                                @foreach ($kriteriaPasar as $kriteriaPasars)
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>

                                            <!--begin::Name-->
                                            <td>
                                                <a type="button" data-bs-toggle="modal"
                                                    data-bs-target="#kt_edit_{{ $kriteriaPasars->id }}"
                                                    class="text-gray-600 text-gray text-hover-primary">{{ $kriteriaPasars->kategori }}</a>
                                                </a>
                                            </td>
                                            <!--end::Name-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $kriteriaPasars->kriteria }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $kriteriaPasars->bobot }}
                                            </td>
                                            <!--end::Coloumn-->

                                            @if (auth()->user()->check_administrator || $adminPIC)
                                                <!--begin::Action-->
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $kriteriaPasars->id }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
                                                    </button>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action-->
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


    <!--begin::Modal-->
    <form action="/kriteria-pasar/save" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Kriteria Pasar</h2>
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
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="kategori" class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Kategori">
                                        <option></option>
                                        <option value="Technologi">Technologi</option>
                                        <option value="Risiko usaha">Risiko usaha</option>
                                        <option value="Cara Peroleh">Cara Peroleh</option>
                                        <option value="Membangun Image">Membangun Image</option>
                                        <option value="Margin (OH+Proyek)">Margin (OH+Proyek)</option>
                                        <option value="Nilai (Besaran OK)">Nilai (Besaran OK)</option>
                                        <option value="Kesiapan sumber daya">Kesiapan sumber daya</option>
                                        <option value="Kelangsungan Pekerjaan">Kelangsungan Pekerjaan</option>
                                        <option value="Sebagai referensi kerja">Sebagai referensi kerja</option>
                                        <option value="Waktu Pelaksanaan Tender">Waktu Pelaksanaan Tender</option>
                                        <option value="Keamanan Pembayaran (Sumber Dana)">Keamanan Pembayaran (Sumber Dana)
                                        </option>
                                        <option value="Menunjang / mendukung produksi pada tahun perolehan">Menunjang /
                                            mendukung produksi pada tahun perolehan</option>
                                    </select>
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
                                        <span>Kriteria Value</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kriteria"
                                        name="kriteria" value="" placeholder="Input Kriteria" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row mb-7">
                            <!--begin::Col-->
                            <div class="col-4">
                                <!--begin::Input group Website-->
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Bobot (1-100)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input onkeyup="hitungBobot(this)" onchange="hitungBobot(this)" type="number"
                                    min="1" max="100" class="form-control form-control-solid" id="bobot"
                                    name="bobot" value="" placeholder="Bobot Nilai (%)" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <div class="col-2 pt-15">
                                <span id="bobotPersen">= 0.0%</span>
                            </div>
                        </div>
                        <!--End::Col-->
                    </div>
                    <!--End::Row Kanan+Kiri-->


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="proyek_new_save" style="background-color:#008CB4">Save</button>

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
    <!--end::Modals-->

    <!--begin::EDIT-->
    @foreach ($kriteriaPasar as $kriteriaPasars)
        <form action="/kriteria-pasar/{{ $kriteriaPasars->id }}/edit" method="post" enctype="multipart/form-data">
            @csrf

            <!--begin::Modal - Create App-->
            <input type="hidden" name="id-kriteria" value="{{ $kriteriaPasars->id }}" id="id-kriteria">

            <!--begin::Modal - Create Proyek-->
            <div class="modal fade" id="kt_edit_{{ $kriteriaPasars->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Kriteria Pasar</h2>
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
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kategori</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="kategori" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="Kategori">
                                            <option value="{{ $kriteriaPasars->kategori }}">
                                                {{ $kriteriaPasars->kategori }}</option>
                                        </select>
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
                                            <span>Kriteria Value</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="kriteria"
                                            name="kriteria" value="{{ $kriteriaPasars->kriteria }}"
                                            placeholder="Input Kriteria" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--End::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-4">
                                    <!--begin::Input group Website-->
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Bobot (1-100)</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input onkeyup="hitungBobot(this)" onchange="hitungBobot(this)" type="number"
                                        min="1" max="100" class="form-control form-control-solid"
                                        id="edit-bobot" name="bobot" value="{{ $kriteriaPasars->bobot * 100 }}"
                                        placeholder="Bobot Nilai (%)" />
                                    <!--end::Input-->
                                    <!--end::Input group-->
                                </div>
                                <div class="col-2 pt-15">
                                    <span id="bobotPersen">= {{ $kriteriaPasars->bobot }}%</span>
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--End::Row Kanan+Kiri-->

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Create App-->
        </form>
    @endforeach
    <!--end::EDIT-->


    <!--begin::modal DELETE-->
    @foreach ($kriteriaPasar as $kriteriaPasars)
        <form action="/kriteria-pasar/delete/{{ $kriteriaPasars->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $kriteriaPasars->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $kriteriaPasars->kategori }} -> {{ $kriteriaPasars->kriteria }}</h2>
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

<script>
    function hitungBobot(e) {
        let bobot = e.value;
        let persen = e.parentElement.parentElement.querySelector("#bobotPersen");
        let kalkulasi = bobot / 100;
        persen.innerHTML = "= " + kalkulasi + "%";
        // console.log(e.parentElement.parentElement.querySelector("#bobotPersen"));
        // console.log(kalkulasi);
    }
</script>
