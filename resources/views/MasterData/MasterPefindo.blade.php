{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master Pefindo')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Pefindo
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, '(PIC)'))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#kt_modal_create_pefindo" data-bs-toggle="modal"
                                        class="btn btn-sm btn-primary py-3" style="background-color:#008CB4; padding: 6px">
                                        Tambah Pefindo</a>

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
                                        <th class="min-w-auto text-white">Nama Pelanggan</th>
                                        <th class="min-w-auto text-white">Score</th>
                                        <th class="min-w-auto text-white">File</th>
                                        <th class="min-w-auto text-white">Action</th>
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
                                    @foreach ($data as $item)
                                        @php
                                            switch ($item->bulan) {
                                                case 1:
                                                    $periode = 'Januari';
                                                    break;
                                                case 2:
                                                    $periode = 'Februari';
                                                    break;
                                                case 3:
                                                    $periode = 'Maret';
                                                    break;
                                                case 4:
                                                    $periode = 'April';
                                                    break;
                                                case 5:
                                                    $periode = 'Mei';
                                                    break;
                                                case 6:
                                                    $periode = 'Juni';
                                                    break;
                                                case 7:
                                                    $periode = 'Juli';
                                                    break;
                                                case 8:
                                                    $periode = 'Agustus';
                                                    break;
                                                case 9:
                                                    $periode = 'September';
                                                    break;
                                                case 10:
                                                    $periode = 'Oktober';
                                                    break;
                                                case 11:
                                                    $periode = 'November';
                                                    break;
                                                case 12:
                                                    $periode = 'Desember';
                                                    break;

                                                default:
                                                    $periode = '-';
                                                    break;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle">{{ $no++ }}</td>
                                            <td class="align-middle">{{ $item->nama_pelanggan }}</td>
                                            <td class="text-center align-middle">{{ $item->score }}</td>
                                            <td class="text-center align-middle"><a target="_blank"
                                                    href="{{ asset('pefindo/' . $item->id_document) }}"
                                                    class="text-hover-primary">{{ $item->id_document }}</a></td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <a href="#"
                                                        data-bs-target="#kt_modal_edit_lq_rank_{{ $item->id }}"
                                                        data-bs-toggle="modal" class="btn btn-sm btn-primary text-white"
                                                        style="background-color: #008CB4;">Edit</a>
                                                    <input type="hidden" name="id-otomasi" value="{{ $item->id }}">
                                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                                        onclick="deleteItem('{{ $item->id }}')">Delete</button>
                                                </div>
                                            </td>
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

    <!--begin::Modal Tambah Kriteria Green Line-->
    <div class="modal fade" id="kt_modal_create_pefindo" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Pefindo</h2>
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

                <form action="/master-pefindo/save" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_create_pefindo">
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Pelanggan</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        {{-- <select id="nama" name="nama"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                            data-select2-id="select2-feature" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Risiko Rendah">Risiko Rendah</option>
                                            <option value="Risiko Moderat">Risiko Moderat</option>
                                            <option value="Risiko Tinggi">Risiko Tinggi</option>
                                            <option value="Risiko Ekstrem">Risiko Ekstrem</option>
                                        </select> --}}
                                        <input type="text" name="nama_pelanggan" class="form-control form-control-solid">
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->

                            <div class="">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Score</span>
                                </label>
                                <input type="number" name="score" class="form-control form-control-solid">
                            </div>

                            <div class="">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Upload File</span>
                                </label>
                                <input type="file" name="file" class="form-control form-control-solid">
                            </div>
                        </div>
                        <!--End::Row Kanan+Kiri-->

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
    <!--end::Modal Tambah Kriteria Green Line-->

    <!--begin::Modal Edit Kriteria Green Line-->
    {{-- @foreach ($data as $pefindo)
        <div class="modal fade" id="kt_modal_edit_lq_rank_{{ $pefindo->id }}" tabindex="-1"
            aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Pefindo</h2>
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

                    <form action="/master-lq-rank/{{ $lq->id }}/edit" method="POST">
                        @csrf
                        <input type="hidden" name="modal"
                            value="kt_modal_edit_lq_rank_{{ $lq->id }}">
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">


                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Periode</span>
                                        </label>
                                        @php
                                            $tahun = (int) date('Y');
                                        @endphp
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="bulan_{{ $lq->id }}" name="bulan"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Bulan..."
                                                data-select2-id="select2-bulan_{{ $lq->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="1" {{ $lq->bulan == '1' ? 'selected' : '' }}>
                                                    Januari</option>
                                                <option value="2" {{ $lq->bulan == '2' ? 'selected' : '' }}>
                                                    Februari</option>
                                                <option value="3" {{ $lq->bulan == '3' ? 'selected' : '' }}>
                                                    Maret</option>
                                                <option value="4" {{ $lq->bulan == '4' ? 'selected' : '' }}>
                                                    April</option>
                                                <option value="5" {{ $lq->bulan == '5' ? 'selected' : '' }}>Mei
                                                </option>
                                                <option value="6" {{ $lq->bulan == '6' ? 'selected' : '' }}>Juni
                                                </option>
                                                <option value="7" {{ $lq->bulan == '7' ? 'selected' : '' }}>Juli
                                                </option>
                                                <option value="8" {{ $lq->bulan == '8' ? 'selected' : '' }}>
                                                    Agustus</option>
                                                <option value="9" {{ $lq->bulan == '9' ? 'selected' : '' }}>
                                                    September</option>
                                                <option value="10" {{ $lq->bulan == '10' ? 'selected' : '' }}>
                                                    Oktober</option>
                                                <option value="11" {{ $lq->bulan == '11' ? 'selected' : '' }}>
                                                    November</option>
                                                <option value="12" {{ $lq->bulan == '12' ? 'selected' : '' }}>
                                                    Desember</option>
                                            </select>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <select id="tahun_{{ $lq->id }}" name="tahun"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilh Tahun..."
                                                data-select2-id="select2_tahun_{{ $lq->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach (range(1, 2) as $thn)
                                                    <option value="{{ $tahun }}"
                                                        {{ !empty($lq->tahun) && $lq->tahun == $tahun ? 'selected' : '' }}>
                                                        {{ $tahun }}</option>
                                                    @php
                                                        $tahun++;
                                                    @endphp
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->

                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nama Pelanggan</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <input type="text" name="nama_pelanggan"
                                                class="form-control form-control-solid"
                                                value="{{ $lq->nama_pelanggan }}">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->

                                <div class="">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Urutan</span>
                                    </label>
                                    <input type="number" name="urutan" class="form-control form-control-solid"
                                        min="0" max="100" value="{{ $lq->urutan }}">
                                </div>
                            </div>
                            <!--End::Row Kanan+Kiri-->

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    @endforeach --}}
    <!--end::Modal Edit Kriteria Green Line-->

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
                        const req = await fetch(`{{ url('/master-pefindo/${id}/delete') }}`, {
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

        function setActive(e, id = null) {
            if (e.value == "create") {
                const elementFinish = document.querySelector('#finish-periode');
                if (e.checked) {
                    elementFinish.classList.add('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                    elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
                } else {
                    elementFinish.classList.remove('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                    elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
                }
            } else {
                const elementFinish = document.querySelector(`#finish-periode-edit-${id}`);
                if (e.checked) {
                    elementFinish.classList.add('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                    elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
                } else {
                    console.log(elementFinish);
                    elementFinish.classList.remove('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                    elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
                }
            }
        }
    </script>
@endsection

<!--end::Main-->
