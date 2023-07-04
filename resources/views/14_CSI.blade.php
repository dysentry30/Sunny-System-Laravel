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
                        <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Panel-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_panel_view_1"
                                                style="font-size:14px;">Progress > 20%</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                href="#kt_panel_view_2" style="font-size:14px;">Progress 90-100%</a>
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
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Nomor SPK</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto text-center">Progress</th>
                                                <th class="min-w-auto text-center">Status</th>
                                                <th class="min-w-auto text-center" width="75px">Action</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @foreach ($proyeks as $proyek)
                                                {{-- @if ((int) $proyek->progress >= 20 && (int) $proyek->progress <= 40) --}}
                                                @if (!empty($proyek->proyekBerjalan))
                                                    <tr>
                                                        <td>
                                                            <a target="_blank"
                                                                href="/customer/view/{{ $proyek->proyekBerjalan->id_customer ?? null }}/{{ $proyek->proyekBerjalan->name_customer ?? '-' }}"
                                                                class="text-gray-800 text-hover-primary">{{ $proyek->proyekBerjalan->name_customer ?? '-' }}</a>
                                                        </td>
                                                        <td>{{ $proyek->kode_proyek }}</td>
                                                        <td>{{ $proyek->nama_proyek }}</td>
                                                        <td>{{ $proyek->UnitKerja->unit_kerja }}</td>
                                                        <td
                                                            class="text-center {{ empty($proyek->Csi->progress) ? 'text-danger' : '' }}">
                                                            {{ $proyek->Csi->progress ?? 'Belum Get Progress' }}</td>
                                                        <td class="text-center">
                                                        @empty(!$proyek->Csi)
                                                            <span
                                                                class="px-4 fs-7 badge {{ $proyek->Csi->status == 'Not Sent' ? 'badge-light-danger' : ($proyek->Csi->status == 'Requested' ? 'badge-light-primary' : 'badge-light-success') }}">
                                                                {{ $proyek->Csi->status }}
                                                            </span>
                                                        @endempty
                                                    </td>
                                                    <td class="text-center">
                                                    @empty(!$proyek->Csi)
                                                        @if ($proyek->Csi->status == 'Done')
                                                            <a target="_blank"
                                                                href="/csi/customer-survey/{{ $proyek->Csi->id_csi }}"
                                                                class="btn fs-8 btn-sm btn-light btn-active-primary text-hover-white">Cek
                                                                CSI &nbsp; <i class="bi bi-search"></i></a>
                                                        @else
                                                            <button class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                                                                data-bs-target="#modal-send-{{ $proyek->Csi->id_csi }}">Send</button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                                                            data-bs-target="#modal-create-{{ $proyek->kode_proyek }}">Get Progress</button>
                                                    @endempty
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table CSI-->
                        </div>
                        <!--end::Panel-->
                        <!--begin::Panel-->
                        <div class="tab-pane fade" id="kt_panel_view_2" role="tabpanel">
                            <!--begin::Table CSI-->
                            <table class="table align-middle table-row-dashed fs-6" id="csi-table-2">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Pemberi Kerja</th>
                                        <th class="min-w-auto">Nomor SPK</th>
                                        <th class="min-w-auto">Nama Proyek</th>
                                        <th class="min-w-auto">Unit Kerja</th>
                                        <th class="min-w-auto">Progress</th>
                                        <th class="min-w-auto text-center">Status</th>
                                        <th class="min-w-auto text-center" width="75px">Action</th>
                                        {{-- <th class="min-w-auto">ID Contract</th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ($proyeks as $proyek)
                                        {{-- @dd($proyek) --}}
                                        @if ((int) $proyek->progress >= 90)
                                            <tr>
                                                <td>
                                                    <a target="_blank"
                                                        href="/customer/view/{{ $proyek->proyekBerjalan->id_customer ?? null }}/{{ $proyek->proyekBerjalan->name_customer ?? '-' }}"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->proyekBerjalan->name_customer ?? '-' }}</a>
                                                </td>
                                                <td>{{ $proyek->no_spk }}</td>
                                                <td>{{ $proyek->nama_proyek }}</td>
                                                <td>{{ $proyek->UnitKerja->unit_kerja }}</td>
                                                <td>{{ $proyek->progress }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="px-4 fs-7 badge {{ $proyek->status == 'Not Sent' ? 'badge-light-danger' : ($proyek->status == 'Requested' ? 'badge-light-primary' : 'badge-light-success') }}">
                                                        {{ $proyek->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($proyek->status == 'Done')
                                                        <a target="_blank"
                                                            href="/csi/customer-survey/{{ $proyek->id_csi }}"
                                                            class="btn fs-8 btn-sm btn-light btn-active-primary text-hover-white">Cek
                                                            CSI &nbsp; <i class="bi bi-search"></i></a>
                                                    @else
                                                        <button class="btn btn-sm btn-light btn-active-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-send-{{ $proyek->id_csi }}">Send</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
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
<!--end::Modals-->

<!-- begin::modal confirm send wa-->
@foreach ($csi as $c)
<form action="/csi/send/{{ $c->id_csi }}" method="post">
    @csrf
    <div class="modal fade w-100" style="margin-top: 120px" id="modal-send-{{ $c->id_csi }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mw-600px">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Kirim Survey CSI ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- @php
                        $struktur = $c->Proyek->proyekBerjalan->customer->struktur
                            ->where('proyek_struktur', '=', $c->no_spk)
                            ->where('id_customer', '=', $c->id_customer)
                            ->first();
                        // dd($struktur);
                    @endphp --}}

                    <input type="hidden" name="id-csi" value="{{ $c->id_csi }}" />
                    <input type="hidden" name="kode-proyek" value="{{ $c->Proyek->kode_proyek }}" />
                    {{-- <input type="hidden" name="id-struktur" value="{{ $struktur->id }}" /> --}}
                    <input type="hidden" name="id-pemberi-kerja" value="{{ $c->id_customer }}" />
                    <input type="hidden" name="pemberi-kerja" value="{{ $c->Proyek->proyekBerjalan->name_customer ?? '-' }}" />
                    {{-- <input type="hidden" name="nama-penerima" value="{{ $struktur->nama_struktur }}" />
                    <input type="hidden" name="nomor-penerima" value="{{ $struktur->phone_struktur }}" /> --}}

                    <p>Nama Proyek : <b>{{ $c->Proyek->nama_proyek }}</b></p>
                    <p>Pemberi Kerja : <b>{{ $c->Proyek->proyekBerjalan->name_customer ?? '-' }}</b></p>
                    {{-- <p>Nama Penerima : <b>{{ $struktur->nama_struktur }}</b></p>
                    <p>Kontak Penerima Penerima : <b>{{ $struktur->phone_struktur }}</b></p> --}}

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
                                <input type="text" class="form-control form-control-solid" name="nama-penerima" placeholder="Nama" required/>
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
                                <input type="text" class="form-control form-control-solid" name="nomor-penerima" placeholder="Kontak Nomor" required/>
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
                                    <span>Email</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="email" placeholder="Email" required/>
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
                                <select onchange="pilihSegmen(this)" id="segmen" name="segmen" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Role" required>
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
                                <select id="jabatan" name="jabatan" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Jabatan">
                                    <option value=""></option>
                                </select>
                                <script>
                                    function pilihSegmen(e) {
                                        let jabatan = document.getElementById('jabatan');
                                        // console.log(e.value, jabatan);
                                        if (e.value == 'Decision Maker') {
                                            jabatan.innerHTML = `
                                            <option value="Menteri">Menteri</option>
                                            <option value="Eselon I">Eselon I</option>
                                            <option value="Direktur Utama">Direktur Utama</option>`;
                                        } else if (e.value == 'Influencer'){
                                            jabatan.innerHTML = `
                                            <option value="Eselon II">Eselon II</option>
                                            <option value="Direksi">Direksi</option>`;
                                        } else if (e.value == 'Buyer'){
                                            jabatan.innerHTML = `
                                            <option value="Kepala Balai">Kepala Balai</option>
                                            <option value="Eselon III">Eselon III</option>
                                            <option value="POKJA Pengadaan">POKJA Pengadaan</option>
                                            <option value="Kepala Pengadaan">Kepala Pengadaan</option>`;
                                        } else if (e.value == 'User'){
                                            jabatan.innerHTML = `
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
                    <button type="submit" class="btn btn-success btn-sm">Send <i class="bi bi-send"></i></button>
                </div>

            </div>
        </div>
    </div>
</form>
@endforeach
<!-- end::modal confirm send wa-->

<!-- begin::modal create CSI-->
@foreach ($proyeks as $p)
<form action="/csi/get-progress/{{ $p->kode_proyek }}" method="post">
    @csrf
    <div class="modal fade w-100" style="margin-top: 120px" id="modal-create-{{ $p->kode_proyek }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mw-600px">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Get Progress</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id-customer" value="{{ $p->proyekBerjalan->id_customer ?? null }}" />
                    <input type="hidden" name="kode-proyek" value="{{ $p->kode_proyek }}" />

                    <p>Nama Proyek : <b>{{ $p->nama_proyek }}</b></p>
                    <p>Pemberi Kerja : <b>{{ $p->proyekBerjalan->name_customer ?? '-' }}</b></p>

                </div>

                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button> --}}
                    <button type="submit" class="btn btn-success btn-sm">Get Progress</button>
                </div>

            </div>
        </div>
    </div>
</form>
@endforeach
<!-- end::modal create CSI-->

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
            dom: '<"float-start"f><"#example"t>rtip',
            // dom: 'Brti',
            // dom: 'frtip',
            pageLength: 20,
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#csi-table-2").DataTable({
            dom: '<"float-start"f><"#example"t>rtip',
            // dom: 'Brti',
            // dom: 'frtip',
            pageLength: 20,
        });
    });
</script>


{{-- <script>
        const modals = document.querySelectorAll(".modal");
        setTimeout(() => {
            modals.forEach(modal => {
                const inputs = modal.querySelectorAll(".modal-dialog .modal-content .modal-body input, .modal-dialog .modal-content .modal-body select, .modal-dialog .modal-content .modal-body textarea");
                inputs.forEach(input => {
                    input.setAttribute("readonly", true);
                })
            });
        }, 500);
    </script> --}}
@endsection
