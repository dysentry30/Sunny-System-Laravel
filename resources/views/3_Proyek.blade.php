{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Proyek')
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


                {{-- Begin:: Alert --}}
                {{-- @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('delete'))
                    <div class="alert alert-warning alert-dismissible fade show rounded-0" role="alert">
                        {{ Session::get('delete') }}
                    </div>
                @endif
                @if (Session::has('failed'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-0" role="alert">
                        {{ Session::get('failed') }}
                    </div>
                @endif --}}
                {{-- End:: Alert --}}



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
                                <h1 class="d-flex align-items-center fs-3 my-1">Proyek
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button class="btn btn-sm btn-primary w-80px"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_create_proyek" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" 
                                        style="background-color:#008CB4; padding: 6px">
                                        New</button>

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
                        <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Proyek" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->

                            <!--begin::Paginate-->
                            {{-- <div class="align-items-center d-flex flex-row-reverse">
												<div>
													{{ $proyeks->links() }}
												</div>

												<div class="p-2" style="color:gray">
													Showing
													{{ $proyeks->firstItem() }}
													to
													{{ $proyeks->lastItem() }}
													of
													{{ $proyeks->total()}}
													entries
												</div>
											</div> --}}
                            <!--end::Paginate-->
                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table Proyek-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Kode Proyek</th>
                                        <th class="min-w-auto">Nama Proyek</th>
                                        <th class="min-w-auto">Unit Kerja</th>
                                        <th class="min-w-auto">Nilai RKAP</th>
                                        <th class="min-w-auto">Nilai Forecast</th>
                                        <th class="min-w-auto">Nilai Realisasi</th>
                                        <th class="min-w-auto">Jenis Proyek</th>
                                        <th class="min-w-auto">Tipe Proyek</th>
                                        @if (auth()->user()->check_administrator)
                                            <th class="min-w-auto text-center">Action</th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    $proyeks = $proyeks->reverse();
                                @endphp
                                @foreach ($proyeks as $proyek)
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>

                                            <!--begin::Name=-->
                                            <td>
                                                <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                    class="text-gray-800 text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Email=-->
                                            <td>
                                                {{ $proyek->nama_proyek }}
                                            </td>
                                            <!--end::Email=-->
                                            <!--begin::Company=-->
                                            <td>
                                                {{ $proyek->UnitKerja->unit_kerja }}
                                            </td>
                                            <!--end::Company=-->

                                            <!--begin::Nilai OK=-->
                                            <td>
                                                {{ $proyek->nilai_rkap }}
                                            </td>
                                            <!--end::Nilai OK=-->
                                            <!--begin::Forecast=-->
                                            <td>
                                                {{-- {{ $proyek->nilai_forecast }} --}}
                                            </td>
                                            <!--end::Forecast=-->
                                            <!--begin::Realisasi=-->
                                            <td>
                                                {{-- {{ $proyek->nilai_realisasi }} --}}
                                            </td>
                                            <!--end::Realisasi=-->
                                            <!--begin::Jenis Proyek=-->
                                            <td>
                                                {{ $proyek->jenis_proyek == 'I' ? 'Internal' : 'External' }}
                                            </td>
                                            <!--end::Jenis Proyek=-->
                                            <!--begin::Tipe Proyek=-->
                                            <td>
                                                {{ $proyek->tipe_proyek == 'R' ? 'Retail' : 'Non-Retail' }}
                                            </td>
                                            <!--end::Tipe Proyek=-->
                                            @if (auth()->user()->check_administrator)
                                                <!--begin::Action=-->
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $proyek->kode_proyek }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
                                                    </button>
                                                    </form>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action=-->
                                            @endif
                                        </tr>
                                @endforeach

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table Proyek-->


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


    <!--begin::Modal New Proyek-->

    <form action="/proyek/save" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create_proyek" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New Proyek</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-circle-fill ts-8"></i>
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
                                        <span class="required">Nama Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="nama-proyek"
                                        name="nama-proyek" value="{{ old('nama-proyek') }}"
                                        placeholder="Nama Proyek" />
                                    @error('nama-proyek')
                                        <h6 class="text-danger">{{ $message }}</h6>
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
                                        <span class="required">Unit Kerja</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="unit-kerja" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                        <option></option>
                                        @foreach ($unitkerjas as $unitkerja)
                                            <option value="{{ $unitkerja->divcode }}"
                                                {{ old('unit-kerja') == $unitkerja->divcode ? 'selected' : '' }}>
                                                {{ $unitkerja->unit_kerja }}</option>
                                        @endforeach
                                    </select>
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
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jenis Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="jenis-proyek" name="jenis-proyek" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek">
                                        <option selected></option>
                                        <option value="I" {{ old('jenis-proyek') == 'I' ? 'selected' : '' }}>
                                            Internal</option>
                                        <option value="E" {{ old('jenis-proyek') == 'E' ? 'selected' : '' }}>
                                            External</option>
                                    </select>
                                    @error('jenis-proyek')
                                        <h6 class="text-danger">{{ $message }}</h6>
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
                                        <span class="required">Tipe Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="tipe-proyek" name="tipe-proyek" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tipe Proyek">
                                        <option selected></option>
                                        <option value="R" {{ old('tipe-proyek') == 'R' ? 'selected' : '' }}>
                                            Retail</option>
                                        <option value="P" {{ old('tipe-proyek') == 'P' ? 'selected' : '' }}>
                                            Non-Retail</option>
                                    </select>
                                    @error('tipe-proyek')
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
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nilai OK RKAP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid reformat"
                                        id="nilai-rkap" name="nilai-rkap" value="{{ old('nilai-rkap') }}"
                                        placeholder="Nilai OK RKAP" />
                                    @error('nilai-rkap')
                                        <h6 class="text-danger">{{ $message }}</h6>
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
                                        <span class="required">Sumber Dana</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="sumber-dana" name="sumber-dana" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Sumber Dana">
                                        <option></option>
                                        @foreach ($sumberdanas as $sumberdana)
                                            <option value="{{ $sumberdana->nama_sumber }}"
                                                {{ old('sumber-dana') == $sumberdana->nama_sumber ? 'selected' : '' }}>
                                                {{ $sumberdana->nama_sumber }}</option>
                                        @endforeach
                                    </select>
                                    @error('sumber-dana')
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
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Tahun Perolehan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" class="form-control form-control-solid" id="tahun-perolehan"
                                        name="tahun-perolehan" min="2021" max="2099" step="1"
                                        value="{{ old('tahun-perolehan') }}" placeholder="Tahun Perolehan" />
                                    @error('tahun-perolehan')
                                        <h6 class="text-danger">{{ $message }}</h6>
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
                                        <span class="required">Bulan Pelaksanaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="bulan-pelaksanaan" name="bulan-pelaksanaan"
                                        class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Bulan Pelaksanaan">
                                        <option selected></option>
                                        <option value="Januari"
                                            {{ old('bulan-pelaksanaan') == 'Januari' ? 'selected' : '' }}>Januari
                                        </option>
                                        <option value="Februari"
                                            {{ old('bulan-pelaksanaan') == 'Februari' ? 'selected' : '' }}>Februari
                                        </option>
                                        <option value="Maret"
                                            {{ old('bulan-pelaksanaan') == 'Maret' ? 'selected' : '' }}>Maret</option>
                                        <option value="April"
                                            {{ old('bulan-pelaksanaan') == 'April' ? 'selected' : '' }}>April</option>
                                        <option value="Mei"
                                            {{ old('bulan-pelaksanaan') == 'Mei' ? 'selected' : '' }}>Mei</option>
                                        <option value="Juni"
                                            {{ old('bulan-pelaksanaan') == 'Juni' ? 'selected' : '' }}>Juni</option>
                                        <option value="Juli"
                                            {{ old('bulan-pelaksanaan') == 'Juli' ? 'selected' : '' }}>Juli</option>
                                        <option value="Agustus"
                                            {{ old('bulan-pelaksanaan') == 'Agustus' ? 'selected' : '' }}>Agustus
                                        </option>
                                        <option value="September"
                                            {{ old('bulan-pelaksanaan') == 'September' ? 'selected' : '' }}>September
                                        </option>
                                        <option value="Oktober"
                                            {{ old('bulan-pelaksanaan') == 'Oktober' ? 'selected' : '' }}>Oktober
                                        </option>
                                        <option value="November"
                                            {{ old('bulan-pelaksanaan') == 'November' ? 'selected' : '' }}>November
                                        </option>
                                        <option value="Desember"
                                            {{ old('bulan-pelaksanaan') == 'Desember' ? 'selected' : '' }}>Desember
                                        </option>
                                    </select>
                                    @error('bulan-pelaksanaan')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" style="background-color:#008CB4" id="proyek_new_save">Save</button>
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
    <!--end::Modal New Proyek-->

    <!--begin::modal DELETE-->
    @foreach ($proyeks as $proyek)
        <form action="/proyek/delete/{{ $proyek->kode_proyek }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $proyek->kode_proyek }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $proyek->kode_proyek }} - {{ $proyek->nama_proyek }}
                            </h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg text-white"></i>
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
