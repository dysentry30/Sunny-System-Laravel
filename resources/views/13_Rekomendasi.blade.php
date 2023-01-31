@extends('template.main')
@section('title', 'Nota Rekomendasi')
<!--begin::Main-->
@section('content')

    @php
        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
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
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Nota Rekomendasi</h1>
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
                        <div class="card-header border-0">

                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    {{-- <select style="display: none !important" id="column" name="column" onchange="changes(this)"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                        <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>

                                    </select> --}}
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    {{-- <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                            <option></option>
                                            @foreach ($unitkerjas as $unitkerja)
                                                <option value="{{ $unitkerja->divcode }}"
                                                    {{ $filterUnit == $unitkerja->divcode ? 'selected' : '' }}>
                                                    {{ $unitkerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="filterJenis" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter-jenis"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek"
                                            tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="I" {{ $filterJenis == 'I' ? 'selected' : '' }}>Internal</option>
                                            <option value="N" {{ $filterJenis == 'N' ? 'selected' : '' }}>External</option>
                                            <option value="J" {{ $filterJenis == 'J' ? 'selected' : '' }}>JO</option>
                                        </select>
                                    </div>
                                    <!--end:: Input Filter-->

                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>
                                    <!--end:: Filter-->

                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                        
                                    <script>
                                        function resetFilter() {
                                            window.location.href = "/rekomendasi";
                                        }
                                    </script>
                                    <!--end:: RESET--> --}}
                                </form>
                                <!--end:: BUTTON FILTER-->
                            </div>
                            <!--begin::Card title-->

                            <!--begin::Card title-->
                            <div class="card-title" style="width: 100%">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" aria-selected="true" href="#kt_user_view_pengajuan"
                                                style="font-size:14px;">Pengajuan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_persetujuan" style="font-size:14px;">Persetujuan</a>
                                        </li>
                                        <!--end:::Tab item -->
                                    </ul>

                                </div>

                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div id="tab-content" class="tab-content">
                                {{-- Begin :: Tab Content Proyek Pengajuan Rekomendasi --}}
                                <div class="tab-pane fade show active" id="kt_user_view_pengajuan" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-pengajuan">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Lokasi</th>
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Instansi</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Mengusulkan</th>
                                                <th class="min-w-auto">Status</th>
                                                <th class="min-w-auto"></th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @if (!empty($proyeks_pengajuan) && !$is_super_user)
                                                @forelse ($proyeks_pengajuan as $proyek)
                                                    @php
                                                        $customer = $proyek->proyekBerjalan->Customer;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)]);
                                                        $is_user_id_exist = $approved_data->filter(function($d) {
                                                            if(is_array($d)) {
                                                                return in_array(Auth::user()->id, $d);
                                                            }
                                                            return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                                        });
                                                        $is_approved = is_array(collect($approved_data->first())->values()->first()) ? collect($approved_data->first())->values()->count() == $all_super_user_counter : $approved_data->count() == $all_super_user_counter;
                                                        // dd($approved_data->first());
                                                        if($is_approved) {
                                                            $approved_data_first = $approved_data;
                                                            $is_approved = collect($approved_data_first)->every(function($adf) {
                                                                return collect($adf->status)->every(function($s){
                                                                    return $s == "approved";
                                                                });
                                                            });
                                                        }
                                                        $is_pending = $proyek->is_request_rekomendasi;
                                                        // dump($approved_data->count(), $all_super_user_counter);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{-- <a href="#kt_modal_view_proyek_{{$proyek->kode_proyek}}" target="_blank" data-bs-toggle="modal" class="text-hover-primary">{{ $proyek->nama_proyek }}</a> --}}
                                                            <a href="/proyek/view/{{$proyek->kode_proyek}}" target="_blank" class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $provinsi = App\Models\Provinsi::find($proyek->provinsi)->first()->province_name;
                                                                } catch (\Throwable $th) {
                                                                    $provinsi = $proyek->provinsi;
                                                                }
                                                            @endphp
                                                            <small>{{ $provinsi ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->name ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->jenis_instansi ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $sumber_dana = App\Models\SumberDana::where("nama_sumber", "=", $customer->sumber_dana)->first()->nama_sumber;
                                                                } catch (\Throwable $th) {
                                                                    $sumber_dana = $proyek->sumber_dana;
                                                                }
                                                            @endphp
                                                            <small>{{ $sumber_dana ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ number_format((int)$proyek->nilaiok_awal, 0, '.', '.' ?? '0'); }}</small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                {{$proyek->klasifikasi_pasdin ?? "-"}}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                @if ($proyek->klasifikasi_pasdin == "Proyek Kecil" || $proyek->klasifikasi_pasdin == "Proyek Menengah")
                                                                    GM Pemasaran Operasi
                                                                @else 
                                                                    Kepala Divisi Operasi
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $status_approval = $is_user_id_exist->first();
                                                            @endphp
                                                            @if ($is_approved)
                                                                <small class="badge badge-light-success">Disetujui</small>
                                                            @elseif($is_pending)
                                                                <small class="badge badge-light-primary">Pengajuan</small>
                                                            @else
                                                                <small class="badge badge-light-danger">Ditolak</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <td><p>There is no data</p></td> --}}
                                                @endforelse
                                            @else
                                            {{-- <td><p>There is no data</p></td> --}}
                                            @endif
                                            
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Proyek Pengajuan Rekomendasi --}}
                                
                                {{-- Begin :: Tab Content Proyek Persetujuan Rekomendasi --}}
                                <div class="tab-pane fade" id="kt_user_view_persetujuan" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-persetujuan">
                                        <!--begin::Table head-->
                                        <thead class="">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Lokasi</th>
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Instansi</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Mengusulkan</th>
                                                <th class="min-w-auto">Status</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @if (!empty($proyeks_persetujuan) &&  $is_super_user)
                                                @forelse ($proyeks_persetujuan as $proyek)
                                                    @php
                                                        $customer = $proyek->proyekBerjalan->Customer;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)]);
                                                        $is_approved = is_array(collect($approved_data->first())->values()->first()) ? collect($approved_data->first())->values()->count() == $all_super_user_counter : $approved_data->count() == $all_super_user_counter;
                                                        
                                                        // dd($approved_data->first());
                                                        if($is_approved) {
                                                            $approved_data_first = $approved_data;
                                                            $is_approved = collect($approved_data_first)->every(function($adf) {
                                                                return collect($adf->status)->every(function($s){
                                                                    return $s == "approved";
                                                                });
                                                            });
                                                        } else {
                                                            $is_user_id_exist = $approved_data->filter(function($d) {
                                                                if(is_array($d)) {
                                                                    return in_array(Auth::user()->id, $d);
                                                                }
                                                                return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                                            });
                                                        }
                                                        $is_pending = $proyek->is_request_rekomendasi;
                                                        // dump($all_super_user_counter);
                                                        // dump($approved_data->count(), $all_super_user_counter);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a href="#kt_modal_view_proyek_{{$proyek->kode_proyek}}" target="_blank" data-bs-toggle="modal" class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $provinsi = App\Models\Provinsi::find($proyek->provinsi)->first()->province_name;
                                                                } catch (\Throwable $th) {
                                                                    $provinsi = $proyek->provinsi;
                                                                }
                                                            @endphp
                                                            <small>{{ $provinsi ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->name ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->jenis_instansi ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $sumber_dana = App\Models\SumberDana::where("nama_sumber", "=", $customer->sumber_dana)->first()->nama_sumber;
                                                                } catch (\Throwable $th) {
                                                                    $sumber_dana = $proyek->sumber_dana;
                                                                }
                                                            @endphp
                                                            <small>{{ $sumber_dana ?? "-" }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ number_format((int)$proyek->nilaiok_awal, 0, '.', '.' ?? '0'); }}</small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                {{$proyek->klasifikasi_pasdin ?? "-"}}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                @if ($proyek->klasifikasi_pasdin == "Proyek Kecil" || $proyek->klasifikasi_pasdin == "Proyek Menengah")
                                                                    GM Pemasaran Operasi
                                                                @else 
                                                                    Kepala Divisi Operasi
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td>
                                                            {{-- @if ((bool) $proyek->is_rekomendasi == false && !is_null($proyek->is_rekomendasi))
                                                                <small class="badge badge-light-danger">Ditolak</small>
                                                            @elseif($proyek->is_rekomendasi)
                                                                <small class="badge badge-light-success">Disetujui</small>
                                                            @else 
                                                                <small class="badge badge-light-primary">Pengajuan</small>
                                                            @endif --}}
                                                            @if (isset($is_approved))
                                                                @if ($is_approved)
                                                                    <small class="badge badge-light-success">Disetujui</small>
                                                                @elseif($is_pending)
                                                                    <small class="badge badge-light-primary">Pengajuan</small>
                                                                @else
                                                                    <small class="badge badge-light-danger">Ditolak</small>
                                                                @endif
                                                            @else
                                                                @php
                                                                    $status_approval = isset($is_user_id_exist) ? $is_user_id_exist->first() : null;
                                                                @endphp
                                                                @switch($status_approval->status ?? "")
                                                                    @case("approved")
                                                                        <small class="badge badge-light-success">Disetujui</small>
                                                                        @break
                                                                    @case("rejected")
                                                                        <small class="badge badge-light-danger">Ditolak</small>
                                                                        @break
                                                                    @default
                                                                        <small class="badge badge-light-primary">Pengajuan</small>
                                                                        @break
                                                                @endswitch
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <td><p>There is no data</p></td> --}}
                                                @endforelse
                                            @else
                                            {{-- <td><p>There is no data</p></td> --}}
                                            @endif
                                            
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Proyek Persetujuan Rekomendasi --}}
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
    
    <!--Begin::Root-->
    @php
        $proyeks = $is_super_user ? $proyeks_persetujuan : $proyeks_pengajuan;
    @endphp
    @foreach ($proyeks as $proyek)
        <div class="modal fade" id="kt_modal_view_proyek_{{$proyek->kode_proyek}}" tabindex="-1" aria-labelledby="kt_modal_view_proyek_{{$proyek->kode_proyek}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Detail Proyek (Readonly)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <input type="text"
                                    class="form-control form-control-solid char-counter"
                                    data-max-char="40" id="nama-proyek"
                                    name="nama-proyek"
                                    value="{{ $proyek->nama_proyek }}" />
                                <!--end::Input-->
                                <div class="d-flex flex-row justify-content-end">
                                    <small class="">0/40</small>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Unit Kerja <i
                                            class="bi bi-lock"></i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <select name="unit-kerja"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Unit Kerja">
                                        <option></option>
                                        @foreach ($unitkerjas as $unitkerja)
                                        @if ($unitkerja->divcode == $proyek->unit_kerja)
                                        <option
                                        value="{{ $unitkerja->divcode }}"
                                        selected>{{ $unitkerja->unit_kerja }}
                                    </option>
                                    @endif
                                    @endforeach
                                    </select> --}}
                                    <input type="text" readonly
                                        class="form-control form-control-solid"
                                        value="{{ $proyek->UnitKerja->unit_kerja }}"
                                        readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->
                    </div>
                    <!--End::Row Kanan+Kiri-->

                    <!--begin::Row Kanan+Kiri-->
                    <div class="d-flex flex-row align-items-center">
                        {{-- <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Pendek Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control form-control-solid char-counter"
                                        data-max-char="40"
                                        id="short-name" name="short-name"
                                        value="{{ $proyek->nama_pendek_proyek }}" />
                                        <div class="d-flex flex-row justify-content-end">
                                            <small class="">0/40</small>
                                        </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div> --}}

                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kode Proyek <i
                                            class="bi bi-lock"></i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                @isset($proyek->kode_proyek)
                                    <input type="text"
                                        class="form-control form-control-solid"
                                        id="edit-kode-proyek" name="edit-kode-proyek"
                                        value="{{ $proyek->kode_proyek }}" readonly />
                                @endisset
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>

                        @php
                            $proyekBerjalans = $proyek->proyekBerjalan;
                            if(!empty($proyekBerjalans)) {
                                $check_green_line = checkGreenLine($proyekBerjalans);
                            } else {
                                $check_green_line = false;
                            }
                        @endphp

                        <div class="col-6 mt-5 ms-5">
                            <div class="form-check">
                                <input class="form-check-input" name="is-green-line" type="checkbox" {{(bool) $check_green_line ? "checked" : ""}} disabled id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Green Line
                                </label>
                            </div>
                        </div>
                        <!--End::Col-->
                    </div>
                    <!--End::Row Kanan+Kiri-->

                    <!--begin::Row Kanan+Kiri-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-4">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Pelanggan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <option value="{{ $proyekberjalans->kode_proyek }}" selected>{{$proyekberjalans->kode_proyek }}</option> --}}
                                <select id="customer_{{$proyek->kode_proyek}}" name="customer"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="false"
                                    data-placeholder="Pilih Customer">
                                    <option value="">{{$proyekBerjalans->name_customer}}</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->
                        <!--begin::Col-->
                        @if (!empty($proyekberjalans))
                            <div class="col-2">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="mt-12 fs-6 fw-bold form-label mt-3">
                                        <a class="btn btn-sm btn-light btn-active-primary ms-2"
                                            target="_blank"
                                            href="/customer/view/{{ $proyekberjalans->id_customer }}/{{ $proyekberjalans->name_customer }}"
                                            id="kt_toolbar_export"><i
                                                class="bi bi-search"></i> Cek Pemberi Kerja
                                        </a>
                                    </label>
                                    {{-- <a target="_blank" href="/customer/view/{{ $proyekberjalans->id_customer }}">
                                        <span> Cek Pelanggan</span>
                                    </a> --}}
                                    <!--end::Label-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        @endif
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
                                    <span class="required">Tipe Proyek <i
                                            class="bi bi-lock"></i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="tipe-proyek_{{$proyek->kode_proyek}}" name="tipe-proyek"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Tipe Proyek"
                                    {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                    <option value="R"
                                        {{ $proyek->tipe_proyek == 'R' ? 'selected' : '' }}>
                                        Retail</option>
                                    <option value="P"
                                        {{ $proyek->tipe_proyek == 'P' ? 'selected' : '' }}>
                                        Non-Retail</option>
                                </select>
                                {{-- <input type="text"
                                        class="form-control form-control-solid"
                                        id="tipe-proyek" name="tipe-proyek"
                                        value="{{ $proyek->tipe_proyek == 'R' ? 'Retail' : 'Non-Retail' }}"
                                        readonly /> --}}
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
                                    <span class="required">Jenis Proyek <i
                                            class="bi bi-key"></i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- @isset($proyek->jenis_proyek) --}}
                                {{-- @dump($proyek->jenis_proyek) --}}
                                <select id="jenis-proyek_{{$proyek->kode_proyek}}"
                                    onchange="tampilJOCategory(this)" name="jenis-proyek"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Jenis Proyek"
                                    {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                    <option value="I"
                                        {{ $proyek->jenis_proyek == 'I' ? 'selected' : '' }}>
                                        Internal</option>
                                    <option value="N"
                                        {{ $proyek->jenis_proyek == 'N' ? 'selected' : '' }}>
                                        External</option>
                                    <option value="J"
                                        {{ $proyek->jenis_proyek == 'J' ? 'selected' : '' }}>
                                        JO</option>
                                </select>
                                <input type="hidden" name="jo-category" id="jo-category"
                                    value="">
                                {{-- @php
                                        $jenis_jo = "";
                                        switch ($proyek->jenis_jo) {
                                            case 30:
                                                $jenis_jo = "JO Integrated Leader";
                                                break;
                                            case 31:
                                                $jenis_jo = "JO Integrated Member";
                                                break;
                                            case 40:
                                                $jenis_jo = "JO Portion Leader";
                                                break;
                                            case 41:
                                                $jenis_jo = "JO Portion Member";
                                                break;
                                            case 50:
                                                $jenis_jo = "JO Mix Integrated - Portion";
                                                break;
                                            default:
                                                $jenis_jo = "Proyek ini bukan JO";
                                                break;
                                        }
                                    @endphp
                                    @if (!empty($proyek->jenis_jo))
                                        <small>JO Category: <b>{{ $jenis_jo }}</b></small>
                                    @else 
                                        <small>JO Category: <b class="text-danger">{{ $jenis_jo }}</b></small>
                                    @endif --}}
                                {{-- @endisset --}}
                                {{-- <input type="text"
                                        class="form-control form-control-solid"
                                        id="jenis-proyek" name="jenis-proyek"
                                        value="{{ $proyek->jenis_proyek == 'I' ? 'Internal' : 'External' }}"
                                        readonly /> --}}
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
                                    <span class="required">RA Tahun Perolehan <i
                                            class="bi bi-key"></i></span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- @php
                                        $years = $proyek->tahun_perolehan;
                                    @endphp --}}
                                {{-- @for ($i = 2021; $i < $years + 20; $i++)
                                        <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor --}}
                                <input type="number"
                                    class="form-control form-control-solid"
                                    name="tahun-perolehan" min="2021"
                                    max="{{ $proyek->tahun_perolehan + 10 }}"
                                    step="1" value="{{ $proyek->tahun_perolehan }}"
                                    {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
                                <!--begin::Input-->
                                {{-- <select id="tahun-perolehan" name="tahun-perolehan"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
                                        @for ($i = 2021; $i < $years + 20; $i++)
                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select> --}}
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--Begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>RA Klasifikasi Proyek</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="ra-klasifikasi-proyek_{{$proyek->kode_proyek}}" name="ra-klasifikasi-proyek"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="RA Klasifikasi Proyek">
                                    <option value="" selected></option>
                                    <option value="Proyek Besar"
                                        {{ $proyek->klasifikasi_pasdin == 'Proyek Besar' ? 'selected' : '' }}>
                                        Proyek Besar</option>
                                    <option value="Proyek Menengah"
                                        {{ $proyek->klasifikasi_pasdin == 'Proyek Menengah' ? 'selected' : '' }}>
                                        Proyek Menengah</option>
                                    <option value="Proyek Kecil"
                                        {{ $proyek->klasifikasi_pasdin == 'Proyek Kecil' ? 'selected' : '' }}>
                                        Proyek Kecil</option>
                                    <option value="Mega Proyek"
                                        {{ $proyek->klasifikasi_pasdin == 'Mega Proyek' ? 'selected' : '' }}>
                                        Mega Proyek</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->
                        <div class="col-6">
                            @if ($proyek->jenis_proyek == 'J')
                            @endif
                            @if ($proyek->jenis_jo == null || $proyek->jenis_jo != 10 || $proyek->jenis_jo != 20)
                                <!--begin::Input group-->
                                <div id="kategori-jenis-jo" class="fv-row mb-7"
                                    style="display: none">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori JO</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    {{-- @php
                                            $years = $proyek->tahun_perolehan;
                                        @endphp --}}
                                    {{-- @for ($i = 2021; $i < $years + 20; $i++)
                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor --}}
                                    @php
                                        $jenis_jo = '';
                                        switch ($proyek->jenis_jo) {
                                            case 30:
                                                $jenis_jo = 'JO Integrated Leader';
                                                break;
                                            case 31:
                                                $jenis_jo = 'JO Integrated Member';
                                                break;
                                            case 40:
                                                $jenis_jo = 'JO Portion Leader';
                                                break;
                                            case 41:
                                                $jenis_jo = 'JO Portion Member';
                                                break;
                                            case 50:
                                                $jenis_jo = 'JO Mix Integrated - Portion';
                                                break;
                                            default:
                                                $jenis_jo = 'Proyek ini bukan JO';
                                                break;
                                        }
                                    @endphp
                                    {{-- <input type="text"
                                            class="form-control form-control-solid"
                                            name="preview-kategori-JO"
                                            value="{{ $jenis_jo }}"
                                            disabled
                                            /> --}}
                                    <label class="fs-6 fw-bold form-label">
                                        {{-- <span><b>Pilih JO:</b></span> --}}
                                        {{-- <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}">Max Porsi JO : {{ $proyek->porsi_jo }}% </b></span> --}}
                                    </label>
                                    <select id="detail-jo_{{$proyek->kode_proyek}}" name="detail-jo"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Jenis JO" readonly=""
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="30">JO Integrated Leader
                                        </option>
                                        <option value="31">JO Integrated Member
                                        </option>
                                        <option value="40">JO Portion Leader</option>
                                        <option value="41">JO Portion Member</option>
                                        <option value="50">JO Mix Integrated - Portion
                                        </option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                            @endif
                        </div>

                    </div>
                    <!--End::Row Kanan+Kiri-->


                    <!--begin::Row Kanan+Kiri-->
                    <div class="row fv-row">
                        <!--End begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>RA Bulan Perolehan</span>
                                </label>
                                <!--end::Label-->
                                <!--Begin::Input-->
                                <select id="bulan-pelaksanaan_{{$proyek->kode_proyek}}" name="bulan-pelaksanaan"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Bulan Perolehan">
                                    <option></option>
                                    <option value="1"
                                        {{ $proyek->bulan_pelaksanaan == '1' ? 'selected' : '' }}>
                                        Januari</option>
                                    <option value="2"
                                        {{ $proyek->bulan_pelaksanaan == '2' ? 'selected' : '' }}>
                                        Februari</option>
                                    <option value="3"
                                        {{ $proyek->bulan_pelaksanaan == '3' ? 'selected' : '' }}>
                                        Maret</option>
                                    <option value="4"
                                        {{ $proyek->bulan_pelaksanaan == '4' ? 'selected' : '' }}>
                                        April</option>
                                    <option value="5"
                                        {{ $proyek->bulan_pelaksanaan == '5' ? 'selected' : '' }}>
                                        Mei</option>
                                    <option value="6"
                                        {{ $proyek->bulan_pelaksanaan == '6' ? 'selected' : '' }}>
                                        Juni</option>
                                    <option value="7"
                                        {{ $proyek->bulan_pelaksanaan == '7' ? 'selected' : '' }}>
                                        Juli</option>
                                    <option value="8"
                                        {{ $proyek->bulan_pelaksanaan == '8' ? 'selected' : '' }}>
                                        Agustus</option>
                                    <option value="9"
                                        {{ $proyek->bulan_pelaksanaan == '9' ? 'selected' : '' }}>
                                        September</option>
                                    <option value="10"
                                        {{ $proyek->bulan_pelaksanaan == '10' ? 'selected' : '' }}>
                                        Oktober</option>
                                    <option value="11"
                                        {{ $proyek->bulan_pelaksanaan == '11' ? 'selected' : '' }}>
                                        November</option>
                                    <option value="12"
                                        {{ $proyek->bulan_pelaksanaan == '12' ? 'selected' : '' }}>
                                        Desember</option>
                                </select>
                                <!--end::Input-->
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
                                    <span>Sumber Dana</span>
                                </label>
                                @php
                                    // $sumberdanas = $sumberdanas->sortBy('created_at');
                                @endphp
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="sumber-dana_{{$proyek->kode_proyek}}" name="sumber-dana"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Sumber Dana">
                                    <option value="" selected>{{$proyek->sumber_dana}}</option>
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
                                    <span>Nilai OK (Excludde Ppn) </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                    class="form-control reformat form-control-solid"
                                    id="nilai-rkap" name="nilai-rkap"
                                    value="{{ number_format((int) str_replace('.', '', $proyek->nilaiok_awal), 0, '.', '.') }}"
                                    placeholder="Nilai OK (Excludde Ppn)" />
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
                                    <span>Status Pasar Dini</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="text"
                                        class="form-control form-control-solid"
                                        id="status-pasardini" name="status-pasardini" placeholder="Status Pasar Dini"
                                        value="{{ $proyek->status_pasdin }}" /> --}}
                                <select id="status-pasardini_{{$proyek->kode_proyek}}" name="status-pasardini"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Status Pasar Dini">
                                    <option value=""></option>
                                    <option value="Cadangan"
                                        {{ $proyek->status_pasdin == 'Cadangan' ? 'selected' : '' }}>
                                        Cadangan</option>
                                    <option value="Potensial"
                                        {{ $proyek->status_pasdin == 'Potensial' ? 'selected' : '' }}>
                                        Potensial</option>
                                    <option value="Sasaran"
                                        {{ $proyek->status_pasdin == 'Sasaran' ? 'selected' : '' }}>
                                        Sasaran</option>
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
                                    <span>Asal Info Proyek</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                    class="form-control form-control-solid"
                                    id="info-proyek" name="info-proyek"
                                    placeholder="Asal Info Proyek"
                                    value="{{ $proyek->info_asal_proyek }}" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->
                    </div>
                    <!--End::Row Kanan+Kiri-->


                    <!--Begin::Title Biru Form: Nilai RKAP Review-->
                    &nbsp;<br>
                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                        Nilai RKAP Review &nbsp;
                        <i onclick="hideReview()" id="hide-review"
                            class="bi bi-arrows-collapse"></i><i onclick="showReview()"
                            id="show-review" style="display: none"
                            class="bi bi-arrows-expand"></i>
                    </h3>
                    <script>
                        function hideReview() {
                            document.getElementById("divRkapReview").style.display = "none";
                            document.getElementById("hide-review").style.display = "none";
                            document.getElementById("show-review").style.display = "";
                        }

                        function showReview() {
                            document.getElementById("divRkapReview").style.display = "";
                            document.getElementById("hide-review").style.display = "";
                            document.getElementById("show-review").style.display = "none";
                        }
                    </script>
                    <br>
                    <div id="divRkapReview">
                        <!--End::Title Biru Form: Nilai RKAP Review-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Nilai OK Review (Valas) (Exclude Tax)</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" onkeyup="hitungReview()"
                                        class="form-control form-control-solid reformat"
                                        id="nilai-valas-review" name="nilai-valas-review"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_valas_review), 0, '.', '.') }}"
                                        placeholder="Nilai OK Review (Valas) (Exclude Tax)" />
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
                                        <span>Mata Uang Review</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="mata-uang-review_{{$proyek->kode_proyek}}" name="mata-uang-review"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Mata Uang">
                                        <option value="" selected>{{$proyek->mata_uang_review}}</option>
                                    </select>
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
                                        <span>Kurs Review <i class="bi bi-key"></i></span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input onkeyup="hitungReview()" type="text"
                                        class="form-control form-control-solid reformat"
                                        id="kurs-review" name="kurs-review"
                                        value="{{ $proyek->kurs_review }}"
                                        placeholder="Kurs Review"
                                        {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
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
                                        <span>Bulan Pelaksanaan Review <i
                                                class="bi bi-key"></i></span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="bulan-pelaksanaan-review_{{$proyek->kode_proyek}}"
                                        name="bulan-pelaksanaan-review"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Bulan Pelaksanaan"
                                        {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                        <option></option>
                                        <option value="1"
                                            {{ $proyek->bulan_review == '1' ? 'selected' : '' }}>
                                            Januari</option>
                                        <option value="2"
                                            {{ $proyek->bulan_review == '2' ? 'selected' : '' }}>
                                            Februari</option>
                                        <option value="3"
                                            {{ $proyek->bulan_review == '3' ? 'selected' : '' }}>
                                            Maret</option>
                                        <option value="4"
                                            {{ $proyek->bulan_review == '4' ? 'selected' : '' }}>
                                            April</option>
                                        <option value="5"
                                            {{ $proyek->bulan_review == '5' ? 'selected' : '' }}>
                                            Mei</option>
                                        <option value="6"
                                            {{ $proyek->bulan_review == '6' ? 'selected' : '' }}>
                                            Juni</option>
                                        <option value="7"
                                            {{ $proyek->bulan_review == '7' ? 'selected' : '' }}>
                                            Juli</option>
                                        <option value="8"
                                            {{ $proyek->bulan_review == '8' ? 'selected' : '' }}>
                                            Agustus</option>
                                        <option value="9"
                                            {{ $proyek->bulan_review == '9' ? 'selected' : '' }}>
                                            September</option>
                                        <option value="10"
                                            {{ $proyek->bulan_review == '10' ? 'selected' : '' }}>
                                            Oktober</option>
                                        <option value="11"
                                            {{ $proyek->bulan_review == '11' ? 'selected' : '' }}>
                                            November</option>
                                        <option value="12"
                                            {{ $proyek->bulan_review == '12' ? 'selected' : '' }}>
                                            Desember</option>
                                    </select>
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
                                        <span>Nilai OK (Exclude PPN) <i
                                                class="bi bi-key"></i></span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control form-control-solid reformat"
                                        id="nilaiok-review" name="nilaiok-review"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilaiok_review), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Exclude PPN)"
                                        {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <script>
                            function hitungReview() {
                                let nilaiOkReview = document.getElementById("nilai-valas-review").value.replaceAll(".", "");
                                // console.log(nilaiOkReview); 
                                let kursReview = document.getElementById("kurs-review").value.replaceAll(".", "");
                                let hasilOkReview = nilaiOkReview * kursReview;
                                document.getElementById("nilaiok-review").value = Intl.NumberFormat(["id"]).format(hasilOkReview);
                                // console.log(hasilOkReview);
                            }
                        </script>
                    </div>
                    <!--divRkapReview-->


                    <!--Begin::Title Biru Form: Nilai RKAP Awal-->
                    <br>
                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                        Nilai RKAP Awal &nbsp;
                        <i onclick="hideColumn()" id="hide-button"
                            class="bi bi-arrows-collapse"></i><i onclick="showColumn()"
                            id="show-button" style="display: none"
                            class="bi bi-arrows-expand"></i>
                    </h3>
                    <script>
                        function hideColumn() {
                            document.getElementById("divRkapAwal").style.display = "none";
                            document.getElementById("hide-button").style.display = "none";
                            document.getElementById("show-button").style.display = "";
                        }

                        function showColumn() {
                            document.getElementById("divRkapAwal").style.display = "";
                            document.getElementById("hide-button").style.display = "";
                            document.getElementById("show-button").style.display = "none";
                        }
                    </script>
                    <br>
                    <div id="divRkapAwal">
                        <!--End::Title Biru Form: Nilai RKAP Awal-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Nilai RKAP Awal (Valas) (Exclude Tax) <i class="bi bi-lock"></i></span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" onkeyup="hitungAwal()"
                                        class="form-control form-control-solid reformat"
                                        id="nilai-valas-awal" name="nilai-valas-awal"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') }}"
                                        placeholder="Nilai OK Awal (Valas) (Exclude Tax)"
                                        readonly />
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
                                        <span class="required">Mata Uang Awal</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="mata-uang-awal_{{$proyek->kode_proyek}}" name="mata-uang-awal"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Mata Uang">
                                        <option value="" selected>{{$proyek->mata_uang_awal}}</option>
                                        {{-- <option value="Rupiah"
                                                {{ $proyek->mata_uang_awal == 'Rupiah' ? 'selected' : '' }}>
                                                Rupiah</option>
                                            <option value="US Dollar"
                                                {{ $proyek->mata_uang_awal == 'US Dollar' ? 'selected' : '' }}>
                                                US Dollar</option>
                                            <option value="Chinese Yuan"
                                                {{ $proyek->mata_uang_awal == 'Chinese Yuan' ? 'selected' : '' }}>
                                                Chinese Yuan</option> --}}
                                    </select>
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
                                        <span>Kurs Awal <i class="bi bi-lock"></i></span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input onkeyup="hitungAwal()" type="text"
                                        class="form-control form-control-solid reformat"
                                        value="1"
                                        placeholder="Kurs Awal" readonly />
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
                                        <span>Bulan Pelaksanaan Awal <i
                                                class="bi bi-lock"></i></span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="bulan-pelaksanaan-awal_{{$proyek->kode_proyek}}"
                                        name="bulan-pelaksanaan-awal"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Bulan Pelaksanaan" readonly>
                                        <option></option>
                                        <option selected>
                                            @switch($proyek->bulan_pelaksanaan)
                                                @case('1')
                                                    Januari
                                                @break

                                                @case('2')
                                                    Februari
                                                @break

                                                @case('3')
                                                    Maret
                                                @break

                                                @case('4')
                                                    April
                                                @break

                                                @case('5')
                                                    Mei
                                                @break

                                                @case('6')
                                                    Juni
                                                @break

                                                @case('7')
                                                    Juli
                                                @break

                                                @case('8')
                                                    Agustus
                                                @break

                                                @case('9')
                                                    September
                                                @break

                                                @case('10')
                                                    Oktober
                                                @break

                                                @case('11')
                                                    November
                                                @break

                                                @case('12')
                                                    Desember
                                                @break

                                                @default
                                                    *Bulan Belum Ditentukan
                                            @endswitch
                                        </option>
                                    </select>
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
                                        <span>Nilai RKAP (Exclude PPN) <i
                                                class="bi bi-lock"></i></span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control form-control-solid reformat"
                                        id="nilaiok-awal" name="nilaiok-awal"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Exclude PPN)" readonly />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        {{-- <script>
                            function hitungAwal() {
                                let nilaiOkAwal = document.getElementById("nilai-valas-awal").value.replaceAll(".", "");
                                let kursAwal = document.getElementById("kurs-awal").value.replaceAll(".", "");
                                let hasilOkAwal = nilaiOkAwal * kursAwal;
                                document.getElementById("nilaiok-awal").value = Intl.NumberFormat(["id"]).format(hasilOkAwal);
                            }
                        </script> --}}
                        <!--End::Row Kanan+Kiri-->
                    </div>
                    <!--divRkapAwal-->


                    <!--Begin::Title Biru Form: Laporan Kualitatif-->
                    <br>
                    <h3 class="fw-bolder m-0 required" id="HeadDetail"
                        style="font-size:14px;">Laporan Kualitatif
                    </h3>
                    <br>
                    <div class="form-group">
                        <textarea id="laporan-kualitatif-pasdin" name="laporan-kualitatif-pasdin" class="form-control" rows="7">{!! $proyek->laporan_kualitatif_pasdin !!}</textarea>
                    </div>
                    <!--End::Title Biru Form: Laporan Kualitatif-->

                    <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>
                </div>
                <div class="modal-footer">
                    
                    @if ($is_super_user && isset($is_user_id_exist) && !$is_user_id_exist->count() > 0 && $proyek->is_request_rekomendasi && $approved_data->count() != $all_super_user_counter)
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{$proyek->kode_proyek}}">
                            <input type="submit" name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                            <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                        </form>
                    @elseif(isset($is_user_id_exist) && $is_user_id_exist->isNotEmpty())
                        @php
                            $status_approval = $is_user_id_exist->first();
                        @endphp
                        @switch($status_approval->status)
                            @case("approved")
                                <small class="badge badge-light-success">Disetujui</small>
                                @break
                            @case("rejected")
                                <small class="badge badge-light-success">Ditolak</small>
                                @break
                            @default
                                
                        @endswitch
                    @endif
                </div>
            </div>
            </div>
        </div>
    @endforeach
    <!--end::Modals-->
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>
    <!--end::Data Tables-->

    <script>
        $(document).ready(function() {
            $("#rekomendasi-pengajuan, #rekomendasi-persetujuan").DataTable( {
                // dom: '<"float-start"f><"#example"t>rtip',
                // dom: 'Brti',
                dom: 'frtip',
                pageLength : 20,
            } );
        });
    </script>

    <script>
        const modals = document.querySelectorAll(".modal");
        setTimeout(() => {
            modals.forEach(modal => {
                const inputs = modal.querySelectorAll(".modal-dialog .modal-content .modal-body input, .modal-dialog .modal-content .modal-body select, .modal-dialog .modal-content .modal-body textarea");
                inputs.forEach(input => {
                    input.setAttribute("readonly", true);
                })
            });
        }, 500);
    </script>
@endsection

