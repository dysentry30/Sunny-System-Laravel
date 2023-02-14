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
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_rekomendasi" style="font-size:14px;">Rekomendasi</a>
                                        </li>
                                        <!--end:::Tab item -->

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
                                    <a href="#" onclick="exportToExcel(this, '#rekomendasi-pengajuan')" class="btn btn-sm btn-success"><i class="bi bi-file-spreadsheet-fill"></i>Export to Excel</a>
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
                                                        // $customer = $proyek->proyekBerjalan->Customer;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
                                                        $is_approved = $approved_data->every(function($item) {
                                                            return !empty($item) && $item->status == "approved";
                                                        }) && ($approved_data->count() == $all_super_user_counter);
                                                        // dd($approved_data);
                                                        if($is_approved) {
                                                            // $approved_data_first = $approved_data;
                                                        } else {
                                                            $is_user_id_exist = $approved_data->filter(function($d) {
                                                                return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                                            });
                                                        }
                                                        $is_pending = !$is_approved && ($approved_data->count() < $all_super_user_counter);
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
                                                            @if ($is_approved)
                                                                <small class="badge badge-light-success">Disetujui</small>
                                                            @elseif($is_pending)
                                                                <small class="badge badge-light-primary">Proses Pengajuan</small>
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
                                                        // $customer = $proyek->proyekBerjalan->Customer;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
                                                        $is_approved = $approved_data->every(function($item) {
                                                            return !empty($item) && $item->status == "approved";
                                                        });
                                                        $is_data_null = $approved_data->every(function($d) {
                                                            return $d == null;
                                                        });

                                                        if($is_data_null) {
                                                            $approved_data = collect();
                                                        }
                                                        
                                                        // dd($approved_data);
                                                        if($is_approved) {
                                                            // $approved_data_first = $approved_data;
                                                        } else {
                                                            $is_user_id_exist = $approved_data->filter(function($d) {
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
                                                            @php
                                                                $msg = "";
                                                                $is_approved = $approved_data->every(function($item) {
                                                                    return !empty($item) && $item->status == "approved";
                                                                }) && ($approved_data->count() == $all_super_user_counter);
                                                                $is_pending = !$is_approved && ($approved_data->count() < $all_super_user_counter);
                                                                if(!$is_approved) {
                                                                    if(!empty($approved_data) && !$is_approved) {
                                                                        $nama_user = collect();
                                                                        foreach ($approved_data as $item) {
                                                                            if(!empty($item) && $item->status == "rejected") {
                                                                                try {
                                                                                    $user = App\Models\User::find($item->user_id)->name;
                                                                                    if(!empty($user)) $nama_user->push($user);
                                                                                } catch (\Throwable $th) {
                                                                                    //throw $th;
                                                                                }
                                                                            }
                                                                        }
                                                                        $nama_user = $nama_user->join(", ", " dan ");
                                                                        if(!empty($nama_user)) {
                                                                            $msg = "Rekomendasi ini ditolak oleh <b>$nama_user</b>";
                                                                        }
                                                                    }
                                                                }   
                                                            @endphp
                                                            @if ($is_approved)
                                                                @if ($is_approved)
                                                                    <small class="badge badge-light-success">Disetujui</small>
                                                                @elseif($is_pending)
                                                                    <small class="badge badge-light-primary">Proses Pengajuan</small>
                                                                @else
                                                                    <small class="badge badge-light-danger" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="{{ $msg }}">Ditolak</small>
                                                                @endif
                                                            @else
                                                                @if(!$is_pending && !$is_approved)
                                                                    <small class="badge badge-light-danger"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="{{ $msg }}">Ditolak</small>
                                                                @elseif(!$is_pending && $is_approved)        
                                                                    <small class="badge badge-light-success">Disetujui</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses Pengajuan</small>
                                                                @endif
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
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-bg-dark">
                                <th>No</th>
                                <th>Item</th>
                                <th>Uraian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nama Proyek</td>
                                <td>{{ $proyek->nama_proyek }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Lokasi Proyek</td>
                                <td>{{ $proyek->Provinsi->province_name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Nama Pemberi Kerja</td>
                                <td>{{ $proyek->proyekBerjalan->name_customer ?? "-"}}</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Instansi Pemberi Kerja</td>
                                <td>{{ $proyek->proyekBerjalan->Customer->jenis_instansi ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Sumber Pendanaan Proyek</td>
                                <td>{{ $proyek->sumber_dana }}</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Nilai Proyek</td>
                                <td>Rp. {{ number_format($proyek->nilaiok_awal, 0, ".", ".") }}</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Kategori Proyek</td>
                                <td>{{ $proyek->klasifikasi_pasdin ?? "-" }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if (!empty($proyek->file_rekomendasi))
                        <hr>
                        <h5>File Preview: </h5>
                        <div class="text-center">
                            <iframe src="{{asset("file-rekomendasi" . "\\" . $proyek->file_rekomendasi)}}" width="800px" height="600px" ></iframe>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @php
                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
                        $is_data_null = $approved_data->every(function($d) {
                            return $d == null;
                        });
                        $is_user_id_exist = $approved_data->map(function($d) {
                            if(!empty($d) && $d->user_id == Auth::user()->id) {
                                $new_class = new stdClass();
                                $new_class->user_id = $d->user_id;
                                $new_class->status = $d->status;
                                return $new_class;
                            }
                            // if(is_array($d->user_id)) {
                            //     return in_array(Auth::user()->id, $d->user_id);
                            // }
                            // return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                        })->firstWhere("user_id", "!=", null);
                        if($is_data_null) {
                            $approved_data = collect();
                        }
                        // dump($is_user_id_exist, $is_data_null, $approved_data->count() != $all_super_user_counter);
                    @endphp
                    @if ($is_super_user && empty($is_user_id_exist) && $is_data_null && $approved_data->count() != $all_super_user_counter)
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{$proyek->kode_proyek}}">
                            <input type="submit" name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                            <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                        </form>
                    @elseif(!empty($is_user_id_exist))
                        {{-- @php
                            $status_approval = $is_user_id_exist->first();
                        @endphp --}}
                        @switch($is_user_id_exist->status)
                            @case("approved")
                                <small class="badge badge-light-success">Disetujui</small>
                                @break
                            @case("rejected")
                                <small class="badge badge-light-danger">Ditolak</small>
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
                dom: 'Bfrtip',
                pageLength : 20,
                buttons: [
                    'excel'
                ],
            });

            setTimeout(() => {
                const exportBtn = document.querySelectorAll(".buttons-excel");
                exportBtn.forEach(item => {
                    item.style.display = "none";
                }); 
            }, 0);

            const rekomendasiOpen = "{{ $rekomendasi_open ?? null }}";
            if(rekomendasiOpen) {
                const modalOpen = document.querySelector(`#${rekomendasiOpen}`);
                const modalOpenBoots = new bootstrap.Modal(modalOpen, {});
                modalOpenBoots.show();
            }
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

    {{-- Begin :: Export To Excel Data --}}
    <script>
        function exportToExcel(e, tableElt) {
            // console.log(e.parentElement);
            document.querySelector(`${tableElt}_wrapper .buttons-excel`).click();
            return;
        }
    </script>
    {{-- End :: Export To Excel Data --}}
@endsection

