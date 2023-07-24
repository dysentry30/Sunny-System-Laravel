{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Claim Managements')
{{-- end:: title --}}

{{-- begin:: content --}}
@section('content')
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Dokumen Database
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                        <!--begin::Wrapper-->
                         <!--begin::Button-->
                         {{-- <a type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                         style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                         data-bs-target="#kt_modal_input_perubahan_kontrak">
                         New</a> --}}
                        <!--end::Button-->

                        <!--begin::Button-->
                        {{-- <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                            style="background-color:#f3f6f9;margin-left:10px;color: black;">
                            Close</a> --}}
                        <!--end::Button-->
                        <!--end::Wrapper-->

                    </div>
                    <!--end::Actions-->
                </div>

                <!--end::Container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-fluid">
                    <!--begin::Contacts App- Edit Contact-->
                    <div class="row">


                        <!--begin::All Content-->
                        <div class="col-xl-15">
                            <!--begin::Contacts-->
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-1">
                                    <!--begin::Card title-->
                                    <div class="card-title">

                                        <!--Begin:: BUTTON FILTER-->
                                        <form action="" class="d-flex flex-row w-auto" method="get">
                                            <!--begin::Select Options-->
                                            <div style="" id="nama-proyek" class="d-flex align-items-center position-relative me-3">
                                                <select id="nama-proyek" name="nama-proyek"
                                                    class="form-select form-select-solid select2-hidden-accessible mx-3"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Nama Proyek"
                                                    tabindex="-1" aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @forelse ($proyeks as $proyek)
                                                        <option value="{{ $proyek->kode_proyek }}" {{ $nama_proyek == $proyek->kode_proyek ? 'selected' : '' }}>{{ $proyek->nama_proyek }}</option>
                                                    @empty
                                                        <option value=""></option>
                                                    @endforelse
                                                    
                                                </select>
                                            </div>
                                            <!--end::Select Options-->

                                            <!--begin:: Input Filter-->
                                            <div id="jenis-dokumen" class="d-flex align-items-center position-relative">
                                                <select id="jenis-dokumen" name="jenis-dokumen" class="form-select form-select-solid w-200px ms-2"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Jenis Dokumen">
                                                    <option></option>
                                                    @forelse ($category_document as $item)
                                                    {{-- @php
                                                    $kategori = "";
                                                        switch ($item) {
                                                            case 'aanwitjzing':
                                                                $kategori = "Aanwitjzing";
                                                                break;
                                                            case 'resiko-perolehan':
                                                                $kategori = "Input Risk (Perolehan)";
                                                                break;
                                                            case 'resiko-pelaksanaan':
                                                                $kategori = "Input Risk (Pelaksanaan)";
                                                                break;
                                                            case 'pending-issue':
                                                                $kategori = "Pending Issue (Perolehan)";
                                                                break;
                                                            case 'pending-issue-pelaksanaan':
                                                                $kategori = "Pending Issue (Pelaksanaan)";
                                                                break;
                                                            case 'pending-issue-pemeliharaan':
                                                                $kategori = "Pending Issue (Pemeliharaan)";
                                                                break;
                                                            case 'perubahan-kontrak':
                                                                $kategori = "Perubahan Kontrak";
                                                                break;
                                                            case 'tinjauan-perolehan':
                                                                $kategori = "Tinjauan Dokumen Kontrak (Perolehan)";
                                                                break;
                                                            case 'usulan-perubahan':
                                                                $kategori = "Usulan Perubahan Draft Kontrak (Perolehan)";
                                                                break;
                                                            case 'pasal-kontraktual':
                                                                $kategori = "Pasal Kontraktual";
                                                                break;
                                                            case 'rkap_bab12':
                                                                $kategori = "Usulan Perubahan Draft Kontrak";
                                                                break;
                                                            
                                                        }
                                                    @endphp --}}
                                                        <option value="{{ $item }}" {{ $jenis_dokumen == $item ? 'selected' : '' }}>{{ $item }}</option>
                                                    @empty
                                                        <option value=""></option>
                                                    @endforelse
                                                </select>
                                            </div>

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
                                                    window.location.href = "/document";
                                                }
                                            </script>
                                        </form>
                                            <!--end:: BUTTON FILTER-->
                                    </div>
                                    <!--begin::Card title-->

                                </div>
                                <!--end::Card header-->

                                <div class="card-body pt-5">
                                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="claim-management">
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">@sortablelink('category','Jenis Dokumen')</th>
                                                <th class="min-w-auto">Nama Dokumen</th>
                                                <th class="min-w-auto">Tanggal Upload</th>
                                                <th class="min-w-auto">Action</th>
                                                {{-- <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        {{-- @php
                                            $claim_get = $claim->map(function($p){
                                                return $p->first();
                                            })
                                        @endphp --}}
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @php
                                                $no = 1;
                                            @endphp
                                            @forelse ($documents as $item)

                                            {{-- @php
                                            $kategori = "";
                                                switch ($item->category) {
                                                    case 'aanwitjzing':
                                                        $kategori = "Aanwitjzing";
                                                        break;
                                                    case 'resiko-perolehan':
                                                        $kategori = "Input Risk (Perolehan)";
                                                        break;
                                                    case 'resiko-pelaksanaan':
                                                        $kategori = "Input Risk (Pelaksanaan)";
                                                        break;
                                                    case 'pending-issue':
                                                        $kategori = "Pending Issue (Perolehan)";
                                                        break;
                                                    case 'pending-issue-pelaksanaan':
                                                        $kategori = "Pending Issue (Pelaksanaan)";
                                                        break;
                                                    case 'pending-issue-pemeliharaan':
                                                        $kategori = "Pending Issue (Pemeliharaan)";
                                                        break;
                                                    case 'perubahan-kontrak':
                                                        $kategori = "Perubahan Kontrak";
                                                        break;
                                                    case 'tinjauan-perolehan':
                                                        $kategori = "Tinjauan Dokumen Kontrak (Perolehan)";
                                                        break;
                                                    case 'usulan-perubahan':
                                                        $kategori = "Usulan Perubahan Draft Kontrak (Perolehan)";
                                                        break;
                                                    case 'pasal-kontraktual':
                                                        $kategori = "Pasal Kontraktual";
                                                        break;
                                                    case 'rkap_bab12':
                                                        $kategori = "Usulan Perubahan Draft Kontrak";
                                                        break;
                                                    
                                                }
                                            @endphp --}}

                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->contract->project->nama_proyek }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->nama_document }}</td>
                                                <td class="text-center">{{ Carbon\Carbon::createFromTimeString($item->created_at)->translatedFormat("d F Y | H:i") }}</td>
                                                <td class="text-center"><a target="_blank" class="btn btn-secondary btn-sm text-hover-primary" href="{{ asset('words/'.$item->id_document) }}">Download</a></td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>

                            </div>
                            <!--End::Contacts-->


                        </div>
                        <!--end::All Content-->
            
                    </div>
                    <!--end::Contacts App- Edit Contact-->
                </div>
                <!--end::Container-->


            </div>
            <!--end::Post-->
        </div>
        <!--end::Content-->
    </div>
@endsection
{{-- end:: content --}}

{{-- @section('aside')
    @include('template.aside')
@endsection --}}


@section('js-script')


<script src="{{ asset('/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset("/datatables/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.html5.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.colVis.min.js") }}"></script>
<script src="{{ asset("/datatables/jszip.min.js") }}"></script>
<script src="{{ asset("/datatables/pdfmake.min.js") }}"></script>
<script src="{{ asset("/datatables/vfs_fonts.js") }}"></script>
<!--end::Data Tables-->
    <!--begin:: Dokumen File Upload Max Size-->
    <script>
        $(document).ready(function() {
            $('#claim-management').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>rti',
                pageLength : 50,
                ordering: false,
            } );
        });
    </script>

@endsection