{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Syarat Prakualifikasi')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <style>

    .form-control.form-control-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
    }
    .form-select.form-select-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
    }

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
                                <h1 class="d-flex align-items-center fs-3 my-1">Syarat Prakualifikasi - <b>{{ $proyek->nama_proyek }}</b>
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--Begin::Submit-->
                            <button class="btn btn-sm btn-primary text-white" id="submit" type="submit" form="syarat-prakualifikasi">Submit</button>
                            <!--End::Submit-->
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
                            <form action="/proyek/syarat-prakualifikasi/{{ $proyek->kode_proyek }}/save" method="POST" id="syarat-prakualifikasi">
                                @csrf
                                <!--begin::Table-->
                                <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">No.</th>
                                            <th class="min-w-auto text-white">Aspek Penilaian</th>
                                            <th class="min-w-auto text-white">Syarat Prakualifikasi</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <!--Begin::Aspek Legal-->
                                        <!--Begin::Aspek Legal Lokal-->
                                        <tr style="background-color: #e0e0e5">
                                            <td class="text-center"><b>A</b></td>
                                            <td colspan="2"><b><u>Aspek Legal:</u></b></td>
                                        </tr>
                                        <tr style="background-color: #e0e0e5">
                                            <td class="text-center"><b>A1</b></td>
                                            <td colspan="2"><b><u>Badan Usaha Lokal (Indonesia)</u></b></td>
                                        </tr>
                                        @foreach ($aspekLegalLokal as $itemLokal)
                                            <tr>
                                                <td class="text-end">{{ $itemLokal->posisi }}</td>
                                                <td>{{ $itemLokal->isi }}</td>
                                                <td>
                                                    <input type="hidden" name="index[]" id="index_{{ $itemLokal->id }}" value="{{ $itemLokal->posisi }}">
                                                    <input type="hidden" name="aspek[]" id="aspek" value="{{ $itemLokal->kategori }}">
                                                    <div class="">
                                                        <select name="aspek_legal_lokal[]" id="aspek_legal_lokal_{{ $itemLokal->id }}" 
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Perlu / Tidak Perlu"
                                                        data-select2-id="select2-aspek_legal_lokal_{{ $itemLokal->id }}">
                                                            <option value="" selected></option>
                                                            <option value="Perlu">Perlu</option>
                                                            <option value="Tidak Perlu">Tidak Perlu</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!--End::Aspek Legal Lokal-->

                                        <!--Begin::Aspek Legal Asing-->
                                        <tr style="background-color: #e0e0e5">
                                            <td class="text-center"><b>A2</b></td>
                                            <td colspan="2"><b><u>Badan Usaha Asing</u></b></td>
                                            {{-- <td></td> --}}
                                        </tr>
                                        @foreach ($aspekLegalAsing as $itemAsing)
                                            <tr>
                                                <td class="text-end">{{ $itemAsing->posisi }}</td>
                                                <td>{{ $itemAsing->isi }}</td>
                                                <td>
                                                    <input type="hidden" name="index[]" id="index_{{ $itemAsing->id }}" value="{{ $itemAsing->posisi }}">
                                                    <input type="hidden" name="aspek[]" id="aspek" value="{{ $itemAsing->kategori }}">
                                                    <div class="">
                                                        <select name="aspek_legal_asing[]" id="aspek_legal_asing_{{ $itemAsing->id }}" 
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Perlu / Tidak Perlu"
                                                        data-select2-id="select2-aspek_legal_asing_{{ $itemAsing->id }}">
                                                            <option value="" selected></option>
                                                            <option value="Perlu">Perlu</option>
                                                            <option value="Tidak Perlu">Tidak Perlu</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!--Begin::Aspek Legal Asing-->
                                        
                                        
                                        <!--Begin::Aspek Teknikal-->
                                        <tr style="background-color: #e0e0e5">
                                            <td class="text-center"><b>B</b></td>
                                            <td colspan="2"><b><u>Aspek Teknikal:</u></b></td>
                                        </tr>
                                        @foreach ($aspekTeknikal as $itemTeknikal)
                                            <tr>
                                                <td class="text-end">{{ $itemTeknikal->posisi }}</td>
                                                <td>{{ $itemTeknikal->isi }}</td>
                                                <td>
                                                    <input type="hidden" name="index[]" id="index_{{ $itemTeknikal->id }}" value="{{ $itemTeknikal->posisi }}">
                                                    <input type="hidden" name="aspek[]" id="aspek" value="{{ $itemTeknikal->aspek }}">
                                                    <div class="">
                                                        @if ($itemTeknikal->opsi == 'pilihan')
                                                        <select name="aspek_teknikal[]" id="aspek_teknikal" 
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Perlu / Tidak Perlu"
                                                        data-select2-id="select2-aspek_teknikal_{{ $itemTeknikal->id }}">
                                                            <option value="" selected></option>
                                                            <option value="Perlu">Perlu</option>
                                                            <option value="Tidak Perlu">Tidak Perlu</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                        @elseif ($itemTeknikal->opsi == 'kombinasi')
                                                        <select name="aspek_teknikal[]" id="aspek_teknikal" 
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Perlu / Tidak Perlu"
                                                        data-select2-id="select2-aspek_teknikal_{{ $itemTeknikal->id }}">
                                                            <option value="" selected></option>
                                                            <option value="Perlu">Perlu</option>
                                                            <option value="Tidak Perlu">Tidak Perlu</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                        <br>
                                                        <input type="text" class="form-control form-control-solid" name="aspek_teknikal_isi[]" id="aspek_teknikal" placeholder="Isi">
                                                        @else
                                                        <input type="text" class="form-control form-control-solid" name="aspek_teknikal[]" id="aspek_teknikal" placeholder="Isi">
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        <!--End::Aspek Teknikal-->
                                        
                                        <!--Begin::Aspek Komersial-->
                                        <tr style="background-color: #e0e0e5">
                                            <td class="text-center"><b>C</b></td>
                                            <td colspan="2"><b><u>Aspek Komersial:</u></b></td>
                                        </tr>
                                        @foreach ($aspekKomersial as $itemKomersial)
                                            <tr>
                                                <td class="text-end">{{ $itemKomersial->posisi }}</td>
                                                <td>{{ $itemKomersial->isi }}</td>
                                                <td>
                                                    <input type="hidden" name="index[]" id="index_{{ $itemKomersial->id }}" value="{{ $itemKomersial->posisi }}">
                                                    <input type="hidden" name="aspek[]" id="aspek" value="{{ $itemKomersial->aspek }}">
                                                    <div class="">
                                                        @if ($itemKomersial->opsi == 'pilihan')
                                                        <select name="aspek_komersial[]" id="aspek_komersial" 
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Perlu / Tidak Perlu"
                                                        data-select2-id="select2-aspek_komersial_{{ $itemKomersial->id }}">
                                                            <option value="" selected></option>
                                                            <option value="Perlu">Perlu</option>
                                                            <option value="Tidak Perlu">Tidak Perlu</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                        @elseif ($itemKomersial->opsi == 'kombinasi')
                                                        <select name="aspek_komersial[]" id="aspek_komersial" 
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Perlu / Tidak Perlu"
                                                        data-select2-id="select2-aspek_komersial_{{ $itemKomersial->id }}">
                                                            <option value="" selected></option>
                                                            <option value="Perlu">Perlu</option>
                                                            <option value="Tidak Perlu">Tidak Perlu</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                        <br>
                                                        <input type="text" class="form-control form-control-solid" name="aspek_komersial_isi[]" id="aspek_komersial" placeholder="Isi">
                                                        @else
                                                        <input type="text" class="form-control form-control-solid" name="aspek_komersial[]" id="aspek_komersial" placeholder="Isi">
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        <!--End::Aspek Teknikal-->
                                        <!--End::Aspek Legal-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </form>
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
                        const req = await fetch(`{{ url('/master-fortune-rank/${id}/delete') }}`, {
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
