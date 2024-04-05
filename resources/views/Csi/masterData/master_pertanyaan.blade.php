{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master Pertanyaan CSI')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Pertanyaan CSI
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            
                            @canany(['super-admin'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-primary text-white" onclick="showModal(this)" data-id-modal="#kt_modal_create_master_csi">Tambah</button>
                                    <!--end::Button-->

                                </div>
                                <!--end::Actions-->
                            @endcanany
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Card-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 py-2">
                            <!--begin::Card title-->
                            <div class="card-title">

                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">
                            <!--begin::Table-->
                            <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                        <th class="min-w-auto text-white">No.</th>
                                        <th class="min-w-auto text-white">Kategori</th>
                                        <th class="min-w-auto text-white">Pertanyaan (Bahasa Indonesia)</th>
                                        <th class="min-w-auto text-white">Pertanyaan (Bahasa Inggris)</th>
                                        <th class="min-w-auto text-white">Tipe Pertanyaan</th>
                                        <th class="min-w-auto text-white">Bobot</th>
                                        <th class="min-w-auto text-white">Pilihan Jawaban</th>
                                        <th class="min-w-auto text-white">Active</th>
                                        <th class="min-w-auto text-white">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    $no = 1;
                                @endphp
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($data as $item)
                                        <tr>
                                            <!--Bagin::Nomor-->
                                            <td class="text-center align-middle">{{ $no++ }}</td>
                                            <!--End::Nomor-->
                                            
                                            <!--Begin::Kategori-->
                                            <td class="text-center align-middle">{{ $item->CsiMasterKategoriPertanyaan->kategori }}</td>
                                            <!--End::Kategori-->
                                            
                                            <!--Begin::Pertanyaan Bahasa Indonesia-->
                                            <td class="align-middle"><p class="m-0">{!! $item->pertanyaan_indonesia !!}</p></td>
                                            <!--End::Pertanyaan Bahasa Indonesia-->

                                            <!--Begin::Pertanyaan Bahasa Inggris-->
                                            <td class="align-middle"><p class="m-0">{!! $item->pertanyaan_inggris !!}</p></td>
                                            <!--End::Pertanyaan Bahasa Inggris-->
                                            
                                            <!--Begin::Tipe Inputan-->
                                            <td class="text-center align-middle">{{ ucwords($item->tipe_input) }}</td>
                                            <!--End::Tipe Inputan-->
                                            
                                            <!--Begin::Bobot-->
                                            <td class="text-center align-middle">{{ $item->bobot }}</td>
                                            <!--End::Bobot-->
                                            
                                            <!--Begin::Kategori Jawaban-->
                                            <td class="text-center align-middle">
                                                @php
                                                    switch ($item->pilihan_jawaban) {
                                                        case 1:
                                                            $pilihan = "Sangat Penting / Sangat Tidak Penting";
                                                            break;
                                                        case 2:
                                                            $pilihan = "Sangat Puas / Sangat Tidak Puas";
                                                            break;
                                                        case 3:
                                                            $pilihan = "Sangat Setuju / Sangat Tidak Setuju";
                                                            break;
                                                        case 4:
                                                            $pilihan = "Lebih Baik / Sama / Lebih Buruk";
                                                            break;
                                                        case 5:
                                                            $pilihan = "Ya / Tidak";
                                                            break;
                                                        
                                                        default:
                                                            $pilihan = "Isian";
                                                            break;
                                                    }
                                                @endphp

                                                <p class="m-0">{{ $pilihan }}</p>

                                            </td>
                                            <!--End::Kategori Jawaban-->
                                            
                                            <!--Begin::Is Active-->
                                            <td class="text-center align-middle">
                                                <p class="badge badge-sm m-0 {{ $item->is_active ? 'badge-primary' : 'badge-danger' }}">
                                                    {{ $item->is_active ? 'Active' : 'Not Active' }}
                                                </p>
                                            </td>
                                            <!--End::Is Active-->
                                            
                                            <!--Begin::Action-->
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary text-white" onclick="showModalEdit(this, '{{ $item->id }}')" data-id-modal="#kt_modal_edit_master_csi">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteItem('{{ $item->id }}')">Delete</button>
                                                </div>
                                            </td>
                                            <!--End::Action-->
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

    <!--begin::Modal Tambah Master Pertanyaan-->
        <div class="modal fade" id="kt_modal_create_master_csi" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Master Pertanyaan CSI</h2>
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

                    <form action="/csi/master-data/master-pertanyaan/save" method="POST">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_create_master_csi">
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Start Periode</span>
                                </label>
                                <input type="date" name="start-periode" id="start-periode" class="form-control form-control-solid" value="{{ old('start-periode') }}">
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="kategori" name="kategori"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilh Kategori"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            @foreach ($masterKategori as $kategori)
                                            <option value="{{ $kategori->code }}" {{ old('kategori') == $kategori->code ? 'selected' : '' }}>{{ $kategori->kategori }}</option>                                            
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Group Parent</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="parent" name="parent"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Group Parent"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($masterParent as $parent)
                                                <option value="{{ $parent->code }}" {{ old('parent') == $parent->code ? 'selected' : ''}}>{{ $parent->kategori }}</option>                                                
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Group Sub Parent</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="sub-parent" name="sub-parent"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Sub Parent"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Kepentingan" {{ old('sub-parent') == 'Kepentingan' ? 'selected' : '' }}>Kepentingan</option>
                                                <option value="Kepuasan" {{ old('sub-parent') == 'Kepuasan' ? 'selected' : '' }}>Kepuasan</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Pertanyaan <i>(Dalam Bahasa Indonesia)</i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="pertanyaan-indonesia" id="pertanyaan-indonesia" rows="8" class="form-control">{!! old('pertanyaan-indonesia') !!}</textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Pertanyaan <i>(Dalam Bahasa Inggris)</i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="pertanyaan-inggris" id="pertanyaan-inggris" rows="8" class="form-control">{!! old('pertanyaan-inggris') !!}</textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Tipe Pertanyaan</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="tipe-input" name="tipe-input"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Tipe Pertanyaan"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="pilihan" {{ old('tipe-input') == 'pilihan' ? 'selected' : '' }}>Pilihan</option>
                                                <option value="text" {{ old('tipe-input') == 'text' ? 'selected' : '' }}>Text</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Jumlah Input</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="jumlah-pilihan" name="jumlah-pilihan"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Jumlah Input"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="1" {{ old('jumlah-pilihan') == '1' ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ old('jumlah-pilihan') == '2' ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ old('jumlah-pilihan') == '3' ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ old('jumlah-pilihan') == '4' ? 'selected' : '' }}>4</option>
                                                <option value="5" {{ old('jumlah-pilihan') == '5' ? 'selected' : '' }}>5</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori Jawaban</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="pilihan-jawaban" name="pilihan-jawaban"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilh Kategori Jawaban"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="1" {{ old('pilihan-jawaban') == '1' ? 'selected' : '' }}>Sangat Penting / Sangat Tidak Penting</option>
                                            <option value="2" {{ old('pilihan-jawaban') == '2' ? 'selected' : '' }}>Sangat Puas / Sangat Tidak Puas</option>
                                            <option value="3" {{ old('pilihan-jawaban') == '3' ? 'selected' : '' }}>Sangat Setuju / Sangat Tidak Setuju</option>
                                            <option value="3" {{ old('pilihan-jawaban') == '4' ? 'selected' : '' }}>Lebih Baik / Sama / Lebih Buruk</option>
                                            <option value="4" {{ old('pilihan-jawaban') == '5' ? 'selected' : '' }}>Ya / Tidak</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Bobot</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <input type="number" name="bobot" id="bobot" value="{{ old('bobot') }}" class="form-control form-control-solid">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Posisi</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <input type="number" name="posisi" id="posisi" value="{{ old('posisi') }}" class="form-control form-control-solid">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <div class="row fv-row my-2">
                                <!--Begin::Input Checkbox-->
                                <div class="form-check">
                                    <input class="form-check-input" name="is-active" type="checkbox" value="active" id="active-periode" onchange="checkActive(this)" {{ old('is-active') == true ? 'checked' : '' }} checked>
                                    <label class="form-check-label" for="active-periode">
                                        Active
                                    </label>
                                </div>
                                <!--End::Input Checkbox-->
                            </div>

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row d-none" id="finish-periode">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Finish Periode</span>
                                </label>
                                <input type="date" name="finish-periode" id="finish-periode" class="form-control form-control-solid" value="{{ old('finish-periode') }}">
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <script>
                                function checkActive(params) {
                                    if (params.checked) {
                                        const elementFinish = params.parentElement.parentElement.nextElementSibling
                                        elementFinish.classList.add('d-none')
                                    }else{
                                        const elementFinish = params.parentElement.parentElement.nextElementSibling
                                        elementFinish.classList.remove('d-none')
                                    }
                                }
                            </script>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                                style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    <!--end::Modal Tambah Master Pertanyaan-->
    
    <!--begin::Modal Edit Master Pertanyaan-->
        <div class="modal fade" id="kt_modal_edit_master_csi" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Master Pertanyaan CSI</h2>
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

                    <form action="" method="POST" id="form_edit_master_csi">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_edit_master_csi">
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Start Periode</span>
                                </label>
                                <input type="date" name="start-periode" id="start-periode-edit" class="form-control form-control-solid" value="{{ old('start-periode') }}">
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="kategori-edit" name="kategori"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilh Kategori"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Group Parent</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="parent-edit" name="parent"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Group Parent"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Group Sub Parent</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="sub-parent-edit" name="sub-parent"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Sub Parent"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Pertanyaan <i>(Dalam Bahasa Indonesia)</i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="pertanyaan-indonesia" id="pertanyaan-indonesia-edit" rows="8" class="form-control">{!! old('pertanyaan-indonesia') !!}</textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Pertanyaan <i>(Dalam Bahasa Inggris)</i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="pertanyaan-inggris" id="pertanyaan-inggris-edit" rows="8" class="form-control">{!! old('pertanyaan-inggris') !!}</textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Tipe Pertanyaan</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="tipe-input-edit" name="tipe-input"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Tipe Pertanyaan"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Jumlah Input</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="jumlah-pilihan-edit" name="jumlah-pilihan"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Jumlah Input"
                                                tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori Jawaban</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="pilihan-jawaban-edit" name="pilihan-jawaban"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilh Kategori Jawaban"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Bobot</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <input type="number" name="bobot" id="bobot-edit" value="{{ old('bobot') }}" class="form-control form-control-solid">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Posisi</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <input type="number" name="posisi" id="posisi-edit" value="{{ old('posisi') }}" class="form-control form-control-solid">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--end::Row Kanan+Kiri-->

                            <div class="row fv-row my-2">
                                <!--Begin::Input Checkbox-->
                                <div class="form-check">
                                    <input class="form-check-input" name="is-active" type="checkbox" value="active" id="active-periode-edit" onchange="checkActive(this)" checked>
                                    <label class="form-check-label" for="active-periode">
                                        Active
                                    </label>
                                </div>
                                <!--End::Input Checkbox-->
                            </div>

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row d-none" id="finish-periode">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Finish Periode</span>
                                </label>
                                <input type="date" name="finish-periode" id="finish-periode-edit" class="form-control form-control-solid" value="{{ old('finish-periode') }}">
                            </div>
                            <!--end::Row Kanan+Kiri-->                            
                        </div>
                        <!--End::Modal body-->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                                style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    <!--end::Modal Edit Master Pertanyaan-->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

    <script>
        $('#example').DataTable({
            stateSave: true,
            ordering: false
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    })
</script>
    <script>
        function showModal(params){
            const idModal = params.getAttribute('data-id-modal');
            $(idModal).modal('show');
        }

        async function showModalEdit(params, id) {
            const idModal = params.getAttribute('data-id-modal');
            LOADING_BODY.block();
            const response = await fetch(`/csi/master-data/master-pertanyaan/${id}/get-data`, {
                method:'GET'
            }).then(async (res) => {
                const data = await res.json();
                LOADING_BODY.release();
                if (data[0].success) {
                    await setValueEditModal(idModal, data);
                } else {
                    Swal.fire({title: data[0].message, icon: 'success', confirmButtonColor: '#008CB4',}).then(()=>{
                        window.location.reload();
                    });
                }
            }).catch((err) => {
                Swal.fire({title: err, icon: 'error', confirmButtonColor: '#008CB4',}).then(()=>{
                    window.location.reload();
                });
            });
        }

        function setValueEditModal(idModal, data) {
            
            const getData = data[0].data;

            $(idModal).modal('show');

            const modalEl = document.querySelector(idModal);

            const form = modalEl.querySelector('#form_edit_master_csi');

            const startPeriode = modalEl.querySelector('#start-periode-edit');
            const kategori = modalEl.querySelector('#kategori-edit');
            const parent = modalEl.querySelector('#parent-edit');
            const subParent = modalEl.querySelector('#sub-parent-edit');
            const pertanyaanIndo = modalEl.querySelector('#pertanyaan-indonesia-edit');
            const pertanyaanInggris = modalEl.querySelector('#pertanyaan-inggris-edit');
            const tipeInput = modalEl.querySelector('#tipe-input-edit');
            const jumlahInput = modalEl.querySelector('#jumlah-pilihan-edit');
            const kategoriJawaban = modalEl.querySelector('#pilihan-jawaban-edit');
            const bobot = modalEl.querySelector('#bobot-edit');
            const posisi = modalEl.querySelector('#posisi-edit');
            const active = modalEl.querySelector('#active-periode-edit');
            const finishPeriode = modalEl.querySelector('#finish-periode-edit');

            form.setAttribute('action', `/csi/master-data/master-pertanyaan/${getData.masterPertanyaan.id}/edit`);

            startPeriode.value = getData.masterPertanyaan.start_periode;

            getData.masterKategoriPertanyaan.forEach(item => {
                let option = document.createElement('option');
                option.value = item.code;
                option.textContent = item.kategori;

                if (option.value == getData.masterPertanyaan.kategori) {
                    option.selected = true;
                }

                kategori.appendChild(option);
            });
            
            getData.masterGroupParentPertanyaan.forEach(item => {
                let option = document.createElement('option');
                option.value = item.code;
                option.textContent = item.kategori;

                if (option.value == getData.masterPertanyaan.parent) {
                    option.selected = true;
                }

                parent.appendChild(option);
            });

            getData.masterGroupSubParentPertanyaan.forEach(item => {
                let option = document.createElement('option');
                option.value = item;
                option.textContent = item;

                if (option.value == getData.masterPertanyaan.sub_parent) {
                    option.selected = true;
                }

                subParent.appendChild(option);
            });

            pertanyaanIndo.value = getData.masterPertanyaan.pertanyaan_indonesia;

            pertanyaanInggris.value = getData.masterPertanyaan.pertanyaan_inggris;

            getData.masterPilihanInput.forEach(item => {
                let option = document.createElement('option');
                option.value = item;
                option.textContent = item.charAt(0).toUpperCase() + item.slice(1);

                if (option.value == getData.masterPertanyaan.tipe_input) {
                    option.selected = true;
                }

                tipeInput.appendChild(option);
            });
            
            getData.masterJumlahInput.forEach(item => {
                let option = document.createElement('option');
                option.value = item;
                option.textContent = item;

                if (option.value == getData.masterPertanyaan.jumlah_pilihan) {
                    option.selected = true;
                }

                jumlahInput.appendChild(option);
            });
            
            getData.masterKategoriJawaban.forEach((item, index) => {
                let option = document.createElement('option');
                option.value = index + 1;
                option.textContent = item;

                if (option.value == getData.masterPertanyaan.pilihan_jawaban) {
                    option.selected = true;
                }

                kategoriJawaban.appendChild(option);
            });

            bobot.value = getData.masterPertanyaan.bobot;

            posisi.value = getData.masterPertanyaan.posisi;
            
            active.checked = getData.masterPertanyaan.is_active ? true : false;
            
            finishPeriode.value = getData.masterPertanyaan.finish_periode;

            if (active.checked) {
                finishPeriode.parentElement.classList.add('d-none');
            } else {
                finishPeriode.parentElement.classList.remove('d-none');            
            }
        }
    </script>



    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("id", id);
                        const req = await fetch(`{{ url('/csi/master-data/master-pertanyaan/delete') }}`, {
                            method: 'POST',
                            header: {
                                "content-type": "application/json",
                            },
                            body: formData
                        }).then(res => res.json());
                        if (req.Success != true) {
                            return Swal.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!'
                            }).then(res => window.location.reload())
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus!'
                        }).then(res => window.location.reload())
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: error
                        }).then(res => window.location.reload())
                    }
                }
            })
        }
    </script>
@endsection

<!--end::Main-->
