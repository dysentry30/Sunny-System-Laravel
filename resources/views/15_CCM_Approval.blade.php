{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'History Approval CCM')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">History Approval CCM
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            {{-- @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 6px">
                                        New</a>

                                   
                                </div>
                                <!--end::Actions-->
                            @endif --}}

                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card card-flush" id="kt_contacts_main" Id="List-vv">

                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--Begin:: BUTTON FILTER-->
                            <form action="" class="d-flex flex-row w-auto mt-6" method="get">

                                 <!--begin::Select Options-->
                                 <div style="" id="filterTahun" class="d-flex align-items-center position-relative me-3">
                                    <select id="tahun-proyek" name="tahun-proyek"
                                        class="form-select form-select-solid select2-hidden-accessible mx-3"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" selected>{{date("Y")}}</option>
                                        @foreach ($tahun_proyeks as $tahun)
                                            <option value="{{$tahun}}" {{$filterTahun == $tahun ? "selected" : ""}}>{{$tahun}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Select Options-->
                                 
                                <!--begin::Select Options-->
                                 <div style="" id="filterBulan" class="d-flex align-items-center position-relative me-3">
                                    <select id="bulan-proyek" name="bulan-proyek"
                                        class="form-select form-select-solid select2-hidden-accessible mx-3"
                                        data-control="select2" data-hide-search="true" data-placeholder="Bulan"
                                        tabindex="-1" aria-hidden="true">
                                        {{-- <option {{ $month == '' ? 'selected' : '' }}></option> --}}
                                        <option value="1" {{ $filterBulan == 1 ? 'selected' : '' }}>Januari</option>
                                        <option value="2" {{ $filterBulan == 2 ? 'selected' : '' }}>Februari</option>
                                        <option value="3" {{ $filterBulan == 3 ? 'selected' : '' }}>Maret</option>
                                        <option value="4" {{ $filterBulan == 4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ $filterBulan == 5 ? 'selected' : '' }}>Mei</option>
                                        <option value="6" {{ $filterBulan == 6 ? 'selected' : '' }}>Juni</option>
                                        <option value="7" {{ $filterBulan == 7 ? 'selected' : '' }}>Juli</option>
                                        <option value="8" {{ $filterBulan == 8 ? 'selected' : '' }}>Agustus</option>
                                        <option value="9" {{ $filterBulan == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $filterBulan == 10 ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $filterBulan == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $filterBulan == 12 ? 'selected' : '' }}>Desember</option>
                                    </select>
                                </div>
                                <!--end::Select Options-->

                                <!--begin:: Input Filter-->
                                <div id="filterUnit" class="d-flex align-items-center position-relative">
                                    <select id="unit-kerja" onchange="this.form.submit()" name="filter-unit" class="form-select form-select-solid w-200px ms-2"
                                        data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                        <option></option>
                                        @foreach ($unit_kerjas_select as $unitkerja)
                                            <option value="{{ $unitkerja->divcode }}"
                                                {{ $filterUnit == $unitkerja->divcode ? 'selected' : '' }}>
                                                {{ $unitkerja->unit_kerja }}</option>
                                        @endforeach
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
                                        window.location.href = "/history-approval";
                                    }
                                </script>
                                <!--end:: RESET-->
                            </form>
                            <!--end:: BUTTON FILTER-->
                        </div>
                        <!--begin::Card title-->


                        @if ($approvals->isNotEmpty())
                        @foreach ($approvals as $history)
                            <!--begin::Card body-->    
                            <div class="card-body pt-0">
                                <div class="mt-6">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center w-100 px-5">
                                                <div class="col-9">
                                                    <!--Begin::Detail Contract-->
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <p class="m-0">Nama Proyek</p>
                                                            <p><b>{{ $history['nama_proyek'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Bulan Periode</p>
                                                            <p><b>{{ $history['periode'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Nilai Kontrak</p>
                                                            <p><b>Rp.{{ $history['nilai_kontrak'] != 0 ? number_format($history['nilai_kontrak'], 0, ",", ".") : 0 }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Unit Kerja</p>
                                                            <p><b>{{ $history['unit_kerja'] }}</b></p>
                                                        </div>
                                                    </div>
                                                    <hr class="m-0">
                                                    <!--End::Detail Content-->
                                                    <!--Begin::Total Claim Contract-->
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <p class="m-0">Total VO Submitted</p>
                                                            <p><b>{{ $history['total_vo'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Total Klaim Submitted</p>
                                                            <p><b>{{ $history['total_klaim'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Total Anti Klaim Submitted</p>
                                                            <p><b>{{ $history['total_anti_klaim'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Total Klaim Asuransi Submitted</p>
                                                            <p><b>{{ $history['total_klaim_asuransi'] }}</b></p>
                                                        </div>
                                                    </div>
                                                    {{-- <hr class="m-0"> --}}
                                                    <!--End::Total Claim Contract-->
                                                    <!--Begin::Jumlah Claim Contract-->
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah VO Submitted</p>
                                                            <p><b>Rp.{{ number_format($history['jumlah_vo'], 0, ",", "." ) }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah Klaim Submitted</p>
                                                            <p><b>Rp.{{ number_format($history['jumlah_klaim'], 0, ",", ".") }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah Anti Klaim Submitted</p>
                                                            <p class="text-danger"><b>Rp.{{ number_format($history['jumlah_anti_klaim'], 0, ",", ".") }} ( - )</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah Klaim Asuransi Submitted</p>
                                                            <p><b>Rp.{{ number_format($history['jumlah_klaim_asuransi'], 0, ",", ".") }}</b></p>
                                                        </div>
                                                    </div>
                                                    <!--End::Jumlah Claim Contract-->
                                                    <hr class="m-0">
                                                    <!--Begin::Total Claim Contract Approve-->
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <p class="m-0">Total VO Approved</p>
                                                            <p><b>{{ $history['total_vo_approve'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Total Klaim Approved</p>
                                                            <p><b>{{ $history['total_klaim_approve'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Total Anti Klaim Approved</p>
                                                            <p><b>{{ $history['total_anti_klaim_approve'] }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Total Klaim Asuransi Approved</p>
                                                            <p><b>{{ $history['total_klaim_asuransi_approve'] }}</b></p>
                                                        </div>
                                                    </div>
                                                    {{-- <hr class="m-0"> --}}
                                                    <!--End::Total Claim Contract Approve-->
                                                    <!--Begin::Jumlah Claim Contract Approve-->
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah VO Approved</p>
                                                            <p><b>Rp.{{ number_format($history['jumlah_vo_approve'], 0, ",", "." ) }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah Klaim Approved</p>
                                                            <p><b>Rp.{{ number_format($history['jumlah_klaim_approve'], 0, ",", ".") }}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah Anti Klaim Approved</p>
                                                            <p class="text-danger"><b>Rp.{{ number_format($history['jumlah_anti_klaim_approve'], 0, ",", ".") }} ( - )</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p class="m-0">Jumlah Klaim Asuransi Approved</p>
                                                            <p><b>Rp.{{ number_format($history['jumlah_klaim_asuransi_approve'], 0, ",", ".") }}</b></p>
                                                        </div>
                                                    </div>
                                                    <!--End::Jumlah Claim Contract Approve-->
                                                </div>


                                                <div class="col-3 ps-5">
                                                    {{-- @if ($user->check_administrator || ($user->Pegawai->kode_jabatan == 410 && $user->Pegawai->kode_fungsi_bidang == 30100)) --}}
                                                    @canany(['approve-change', 'lock-change'], $history['profit_center'])
                                                        {{-- @if ($user->check_administrator || auth()->user()->can("admin-ccm")) --}}
                                                        @can('approve-change', $history['profit_center'])
                                                        <div class="d-flex flex-column flex-md-row gap-4 justify-content-center">
                                                            @if ($history['is_approved'] == "t")
                                                                    <a class="btn btn-success btn-sm disabled d-flex align-items-center">Approved</a>
                                                                    @if($history['is_request_unlock'] == "t")
                                                                        @can('unlock-ccm')
                                                                        <form action="/history-approval/set-unlock" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="id_contract" value="{{ $history['id_contract'] }}">
                                                                            <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center">Unlock</button>
                                                                        </form>
                                                                        @endcan
                                                                    @endif
                                                            @elseif($history['is_approved'] == "f")
                                                                <button class="btn btn-danger btn-sm disabled">Approval Ditolak</button>
                                                            @else
                                                                <a class="btn btn-primary btn-sm d-flex align-items-center" onclick="confirmAction(this, '{{ $history['profit_center'] }}')">Approve</a>
                                                                <a class="btn btn-secondary btn-sm d-flex align-items-center" onclick="confirmAction(this, '{{ $history['profit_center'] }}')">Cancel</a>
                                                            @endif
                                                        </div>                                                            
                                                        @endcan
                                                        {{-- @else --}}
                                                        @can('lock-change', $history['profit_center'])
                                                        <div class="d-flex flex-column flex-md-row gap-4 justify-content-center">
                                                            @if ($history['is_approved'] == "t")
                                                                <a class="btn btn-success btn-sm d-flex align-items-center disabled">Approved</a>
                                                                @if($history['is_request_unlock'] == "t")
                                                                <a class="btn btn-success btn-sm d-flex align-items-center disabled">Menunggu Unlock...</a>
                                                                @else
                                                                <form action="/history-approval/request-unlock" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id_contract" value="{{ $history['id_contract'] }}">
                                                                    <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center">Request Unlock</button>
                                                                </form>
                                                                @endif
                                                            @elseif($history['is_approved'] == "f")
                                                                <a class="btn btn-danger btn-sm d-flex align-items-center disabled">Approve Ditolak</a>
                                                            @else
                                                                <a class="btn btn-success btn-sm d-flex align-items-center disabled">Menunggu untuk approval...</a>
                                                            @endif
                                                        </div>                                                            
                                                        @endcan
                                                        {{-- @endif                                                         --}}
                                                    @endcanany
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        @endforeach
                        @else
                        <div class="d-flex flex-row align-items-center" style="height: 10vh">
                            <div class="col text-center">Data tidak ditemukan!</div>
                        </div>  
                        <hr>
                        @endif
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

@section('js-script')
<script>
    const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    })
    async function confirmAction(e, id_contract) {
        // console.log(e.innerHTML)
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: "Aksi ini tidak dapat <b>dikembalikan<b>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#008CB4',
            cancelButtonColor: '#BABABA',
            confirmButtonText: 'Ya'
        }).then(async(result)=>{
            LOADING_BODY.block();
            if(result.isConfirmed){
                if(e.innerHTML == "Approve"){
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("approve", "t");
                    formData.append("periode", "{{ $filterBulan }}");
                    const sendData = await fetch(`/history-approval/set-approve/${id_contract}`,{
                        method: "POST",
                        body: formData
                    }).then(res => res.json());
                    if(sendData.link){
                        window.location.reload();
                    }
                    LOADING_BODY.release();
                }else{
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("approve", "f");
                    const sendData = await fetch(`/history-approval/set-approve/${id_contract}`,{
                        method: "POST",
                        body: formData
                    }).then(res => res.json());
                    if(sendData.link){
                        window.location.reload();
                    }
                    LOADING_BODY.release();
                }
            }

        })
    }
</script>
@endsection


@endsection

<!--end::Main-->
