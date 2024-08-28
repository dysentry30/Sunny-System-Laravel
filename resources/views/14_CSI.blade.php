@extends('template.main')
@section('title', 'CSI')
<!--begin::Main-->
@section('content')

    @php
        $is_super_user = str_contains(Auth::user()->name, 'PIC') || Auth::user()->check_administrator;
    @endphp

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
                            <h1 class="d-flex align-items-center fs-3 my-1">CSI</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Post-->
                <!--begin::Container-->
                <!--begin::Card-->
                <div class="card" Id="List-vv">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Panel-->
                            <div class="d-flex align-items-center" style="width: 100%;">

                                <!--begin:: Input Filter-->
                                <form action="">
                                    <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select id="unit-kerja" name="filter-unit" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                            <option></option>
                                            @foreach ($unit_kerja as $unitkerja)
                                                <option value="{{ $unitkerja->divcode }}"
                                                    {{ $filterUnit == $unitkerja->divcode ? 'selected' : '' }}>{{ $unitkerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
    
                                        <select id="progress-filter" name="filter-progress" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Progress">
                                            <option></option>
                                            <option value="A" {{ $filterProgress == "A" ? "selected" : "" }}>20% - 40%</option>
                                            <option value="B" {{ $filterProgress == "B" ? "selected" : "" }}>95% - 100%</option>
                                        </select>
    
                                        <button class="btn btn-sm btn-primary ms-2" type="submit">Filter</button>
                                        <a class="btn btn-sm btn-secondary ms-2" href="/csi">Reset</a>
                                    </div>
                                </form>
                                <!--end:: Input Filter-->
                            </div>
                            <!--end::Panel-->
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div id="tab-content" class="tab-content">
                            <!--begin::Panel-->
                            <div class="tab-pane fade show active" id="kt_panel_view_1" role="tabpanel">
                                <!--begin::Table CSI-->
                                <table class="table align-middle table-row-dashed fs-6" id="csi-table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-auto text-center" rowspan="3">Profit Center</th>
                                            <th class="min-w-auto" rowspan="3">Nama Proyek</th>
                                            <th class="min-w-auto" rowspan="3">Unit Kerja</th>
                                            <th class="min-w-auto text-center" rowspan="3">Progress</th>
                                            <th class="min-w-auto text-center" colspan="4">Form Kepuasan Pelanggan</th>
                                            <th class="min-w-auto text-center" rowspan="3">Nilai Akhir</th>
                                            <th class="min-w-auto text-center" rowspan="3">Remarks</th>
                                            {{-- <th class="min-w-auto">ID Contract</th> --}}
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-200px text-center" colspan="2">20 - 40 % (a)</th>
                                            <th class="min-w-200px text-center" colspan="2">95 - 100 % (b)</th>
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-200px text-center">Score</th>
                                            <th class="min-w-200px text-center">Action</th>
                                            <th class="min-w-200px text-center">Score</th>
                                            <th class="min-w-200px text-center">Action</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600 fs-6">
                                        @foreach ($proyeks as $proyek)
                                            @php
                                                $bulan = date('m');
                                                $tahun = date('Y');

                                                if ($bulan == 1) {
                                                    $bulan = 12;
                                                    $tahun = $tahun - 1;
                                                }
                                                // $proyekProgress = $proyek->ProyekProgress?->where('periode', date('Ym'))->first();
                                                $proyekProgress = $proyek->ProyekProgress
                                                    ?->where('periode', (string) $tahun . (string) $bulan)
                                                    ->first();
                                                if (empty($proyekProgress)) {
                                                    $formatPeriode = (string) $tahun . '0' . (string) $bulan - 1;
                                                    $proyekProgress = $proyek->ProyekProgress
                                                        ?->where('periode', $formatPeriode)
                                                        ->first();
                                                }
                                                $progress = 0;
                                                if (!empty($proyekProgress)) {
                                                    $progress =
                                                        $proyekProgress->ok_review &&
                                                        $proyekProgress->progress_fisik_ri
                                                            ? (int) $proyekProgress->progress_fisik_ri /
                                                                (int) $proyekProgress->ok_review
                                                            : 0;
                                                }
                                            @endphp
                                            <tr>
                                                <!--Begin :: List Profit Center-->
                                                <td class="text-center">{{ $proyek->profit_center ?? '-' }}</td>
                                                <!--End :: List Profit Center-->

                                                <!--Begin :: List Nama Proyek-->
                                                <td>{{ $proyek->proyek_name }}</td>
                                                <!--End :: List Nama Proyek-->

                                                <!--Begin :: List Nama Proyek-->
                                                <td class="text-center">{{ $proyek->UnitKerja->unit_kerja ?? "-" }}</td>
                                                <!--End :: List Nama Proyek-->

                                                <!--Begin :: List Progress-->
                                                <td class="text-center">
                                                    {{ round($progress, 2) * 100 }}%
                                                </td>
                                                <!--End :: List Progress-->

                                                <!--Begin :: List Score CSI 20% - 40%-->
                                                <td class="text-center min-w-100px">
                                                    @if ($proyek->Csi->isNotEmpty())
                                                        @if ($proyek->Csi->where('kategori', 'A')->isNotEmpty())
                                                            @if ($proyek->Csi->where('kategori', 'A')->first()->status == "Done")
                                                                <span>{{ $proyek->Csi->where('kategori', 'A')->first()->score_csi }}</span>
                                                            @elseif ($proyek->Csi->where('kategori', 'A')->first()->status == "Requested")
                                                                <span class="px-4 fs-8 badge badge-light-warning">
                                                                    Waiting for Customer
                                                                </span>
                                                            @else
                                                                <span>-</span>
                                                                @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                                <!--End :: List Score CSI 20% - 40%-->

                                                <!--Begin :: List Action CSI 20% - 40%-->
                                                <td class="text-center min-w-100px">
                                                    @if ($proyek->Csi->isNotEmpty())
                                                        @if ($proyek->Csi->where('kategori', 'A')->isNotEmpty())
                                                            @if ($proyek->Csi->where('kategori', 'A')->first()->status == "Done")
                                                                <a target="_blank" href="/csi/customer-survey/{{ $proyek->Csi?->where('kategori', 'A')?->first()?->id_csi }}" class="btn fs-8 btn-sm btn-light btn-active-primary text-hover-white">Cek CSI &nbsp; <i class="bi bi-search"></i></a>
                                                            @elseif ($proyek->Csi->where('kategori', 'A')->first()->status == "Requested")
                                                                <span class="px-4 fs-8 badge badge-light-warning">
                                                                    Waiting for Customer
                                                                </span>
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        @else
                                                            @if ($progress >= 0.2 && $progress <= 0.4)
                                                                <button type="button" class="btn btn-sm btn-light btn-active-primary" onclick="showModalCategory('{{ $proyek->unsetRelation('Csi') }}', 'A', '{{ round($progress, 2) * 100 }}')">Send</button>
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ($progress >= 0.2)
                                                            <button type="button" class="btn btn-sm btn-light btn-active-primary" onclick="showModalCategory('{{ $proyek->unsetRelation('Csi') }}', 'A', '{{ round($progress, 2) * 100 }}')">Send</button>
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <!--End :: List Action CSI 20% - 40%-->

                                                <!--Begin :: List Score CSI 95% - 100%-->
                                                <td class="text-center min-w-100px">
                                                    @if ($proyek->Csi->isNotEmpty())
                                                        @if ($proyek->Csi->where('kategori', 'B')->isNotEmpty())
                                                            @if ($proyek->Csi->where('kategori', 'B')->first()->status == "Done")
                                                                <span>{{ $proyek->Csi->where('kategori', 'B')->first()->score_csi }}</span>
                                                            @elseif ($proyek->Csi->where('kategori', 'B')->first()->status == "Requested")
                                                                <span class="px-4 fs-8 badge badge-light-warning">
                                                                    Waiting for Customer
                                                                </span>
                                                            @else
                                                                <span>-</span>
                                                                @endif
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                                <!--End :: List Score CSI 95% - 100%-->

                                                <!--Begin :: List Action CSI 95% - 100%-->
                                                <td class="text-center min-w-100px">
                                                    @if ($proyek->Csi->isNotEmpty())
                                                        @if ($proyek->Csi->where('kategori', 'B')->isNotEmpty())
                                                            @if ($proyek->Csi->where('kategori', 'B')->first()->status == "Done")
                                                                <a target="_blank" href="/csi/customer-survey/{{ $proyek->Csi?->where('kategori', 'B')?->first()?->id_csi }}" class="btn fs-8 btn-sm btn-light btn-active-primary text-hover-white">Cek CSI &nbsp; <i class="bi bi-search"></i></a>
                                                            @elseif ($proyek->Csi->where('kategori', 'B')->first()->status == "Requested")
                                                                <span class="px-4 fs-8 badge badge-light-warning">
                                                                    Waiting for Customer
                                                                </span>
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        @else
                                                            @if ($proyek->Csi->where('kategori', 'A')->isNotEmpty() && $proyek->Csi->where('kategori', 'A')->first()->status == "Done")
                                                                @if ($progress >= 0.95)
                                                                    <button type="button" class="btn btn-sm btn-light btn-active-primary" onclick="showModalCategory('{{ $proyek->unsetRelation('Csi') }}', 'B', '{{ round($progress, 2) * 100 }}')">Send</button>
                                                                @else
                                                                    <span>-</span>
                                                                @endif
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ($proyek->Csi->where('kategori', 'A')->isNotEmpty() && $proyek->Csi->where('kategori', 'A')->first()->status == "Done")
                                                            @if ($progress >= 0.95)
                                                                <button type="button" class="btn btn-sm btn-light btn-active-primary" onclick="showModalCategory('{{ $proyek->unsetRelation('Csi') }}', 'B', '{{ round($progress, 2) * 100 }}')">Send</button>
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        @else
                                                            <span>-</span>
                                                            
                                                        @endif
                                                    @endif
                                                </td>
                                                <!--End :: List Action CSI 95% - 100%-->

                                                <!--Begin::List Nilai Akhir-->
                                                <td class="text-center">
                                                    @php
                                                        $nilaiAkhir = $proyek->Csi?->sortByDesc('created_at')?->filter(function($item){
                                                            return $item->kategori == "B" || $item->kategori == "A";
                                                        })->first();

                                                        if (!empty($nilaiAkhir)) {
                                                            $scoreTotal = $nilaiAkhir->score_csi;
                                                        }else{
                                                            $scoreTotal = "-";
                                                        }
                                                    @endphp

                                                    {{ $scoreTotal }}
                                                </td>
                                                <!--End::List Nilai Akhir-->
                                                
                                                <!--Begin::List Remark-->
                                                <td class="text-center">-</td>
                                                <!--End::List Remark-->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--begin::Table body-->
                                </table>
                                <!--end::Table CSI-->
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

<!--Begin :: Modal Dynamic CSI-->
<form action="/csi/send/new" method="post" >
@csrf
<div class="modal fade w-100" style="margin-top: 120px" id="modal-send-csi-dynamic"
    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mw-600px">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Kirim Survey CSI ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Nama Proyek : <b id="nama-proyek"></b></p>
                <p>Pemberi Kerja : <b id="pemberi-kerja"></b></p>

                <input type="hidden" name="id-pemberi-kerja" id="id-pemberi-kerja" />
                <input type="hidden" name="pemberi-kerja" id="pemberi-kerja-input" />
                <input type="hidden" name="kode-proyek" id="kode-proyek" />
                <input type="hidden" name="kategori" id="kategori" />
                <input type="hidden" name="progress" id="progress" />

                <!--begin::Row-->
                <div class="row fv-row">
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span class="required">Nama</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="nama-penerima" placeholder="Nama" required />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                    <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3 required">
                                <span>Kontak Nomor (WA)</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="nomor-penerima" placeholder="Kontak Nomor" required />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                </div>
                <!--End begin::Row-->

                <!--begin::Row-->
                <div class="row fv-row">
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span class="required">Email</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="email"
                                placeholder="Email" required />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                </div>
                <!--End begin::Row-->

                <!--begin::Row-->
                <div class="row fv-row">
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span class="required">Role</span>
                            </label>
                            <!--end::Label-->
                            <!--Begin::Input-->
                            <select onchange="pilihSegmen(this)"
                                id="segmen-csi" name="segmen"
                                class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Pilih Role" required>
                                <option></option>
                                <option value="Decision Maker">Decision Maker</option>
                                <option value="Influencer">Influencer</option>
                                <option value="Buyer">Buyer</option>
                                <option value="User">User</option>
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
                                <span class="required">Jabatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select id="jabatan-csi" name="jabatan"
                                class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Pilih Jabatan">
                                <option value=""></option>
                            </select>
                            <script>
                                function pilihSegmen(e) {
                                    let jabatan = document.getElementById('jabatan-csi');
                                    // console.log(e.value, jabatan);
                                    if (e.value == 'Decision Maker') {
                                        jabatan.innerHTML = `
                                    <option value="Menteri">Menteri</option>
                                    <option value="Eselon I">Eselon I</option>
                                    <option value="Direktur Utama">Direktur Utama</option>`;
                                    } else if (e.value == 'Influencer') {
                                        jabatan.innerHTML = `
                                    <option value="Eselon II">Eselon II</option>
                                    <option value="Direksi">Direksi</option>`;
                                    } else if (e.value == 'Buyer') {
                                        jabatan.innerHTML = `
                                    <option value="Kepala Balai">Kepala Balai</option>
                                    <option value="Eselon III">Eselon III</option>
                                    <option value="POKJA Pengadaan">POKJA Pengadaan</option>
                                    <option value="Kepala Pengadaan">Kepala Pengadaan</option>`;
                                    } else if (e.value == 'User') {
                                        jabatan.innerHTML =
                                            `
                                    <option value="Eselon IV">Eselon IV</option>
                                    <option value="PPK/Pimro">PPK/Pimro</option>
                                    <option value="Kepala Satker">Kepala Satker</option>
                                    <option value="Kepala Unit Bisnis/Operasi">Kepala Unit Bisnis/Operasi</option>`;
                                    } else {
                                        jabatan.innerHTML = ``;
                                    }
                                    // console.log(e.value, jabatan, jabatan.value, jabatan.innerHTML);
                                }
                            </script>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                </div>
                <!--End begin::Row-->
            </div>

            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button> --}}
                <button type="submit" class="btn btn-success btn-sm">Send <i
                        class="bi bi-send"></i></button>
            </div>

        </div>
    </div>
</div>
</form>
<!--End :: Modal Dynamic CSI-->

<script>
    

</script>

@endsection

@section('js-script')
<!--begin::Data Tables-->
<script src="/datatables/jquery.dataTables.min.js"></script>
{{-- <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script> --}}
<!--end::Data Tables-->

<script>
    $(document).ready(function() {
        $("#csi-table").DataTable({
            dom: '<"float-finish"f><"#example"t>rtip',
            order: [
                [8, 'desc'],
            ],
            pageLength: 20,
        });
    });
</script>

<script>
    function showModalCategory(proyekPIS, kategori, progress) {
        const proyek = JSON.parse(proyekPIS);

        $('#modal-send-csi-dynamic').modal('show');

        const namaProyekEl = document.getElementById('nama-proyek')
        const pemberiKerjaEL = document.getElementById('pemberi-kerja')
        const inputIdPemberiKerjaEl = document.getElementById('id-pemberi-kerja')
        const inputPemberiKerjaEl = document.getElementById('pemberi-kerja-input')
        const inputKodeProyekEl = document.getElementById('kode-proyek')
        const inputKategoriEl = document.getElementById('kategori')
        const inputProgressEl = document.getElementById('progress')

        namaProyekEl.innerHTML = proyek.proyek_shortname;
        pemberiKerjaEL.innerHTML = proyek.customer.name;

        inputIdPemberiKerjaEl.value = proyek.customer.id_customer;
        inputPemberiKerjaEl.value = proyek.customer.name;
        // inputKodeProyekEl.value = proyek.profit_center != null ? proyek.profit_center : proyek.spk_intern_no;
        inputKodeProyekEl.value = proyek.spk_intern_no;
        inputKategoriEl.value = kategori;
        inputProgressEl.value = progress;
    }
</script>

@endsection
