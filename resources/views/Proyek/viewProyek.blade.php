{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'View Proyek')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                
                <!--begin::Header-->
                @extends('template.header')
                <!--end::Header-->


					<!--begin::Content-->
					<!--begin::Form-->
                    <form action="/proyek/update/" method="post" enctype="multipart/form-data"> 
                        @csrf
                        

                    <!--begin:: id_customer selected-->
                    <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}" id="kode-proyek">
                    <!--end:: id_customerid-->
                    
                    
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--begin::Toolbar-->
                            <div class="toolbar" id="kt_toolbar">
                                <!--begin::Container-->
                                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                    <!--begin::Page title-->
                                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                        <!--begin::Title-->
                                        <h1 class="d-flex align-items-center fs-3 my-1">Proyek
                                        </h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center py-1">
                                        
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-sm btn-primary" id="customer_new_save"
                                        style="background-color:#ffa62b">
                                        Save</button>
                                        <!--end::Button-->

                                        <!--begin::Button-->
                                        <a class="btn btn-sm btn-light btn-active-primary fs-7 px-4 mx-3" data-bs-toggle="modal" 
                                        data-bs-target="#kt_modal_create_approval" 
                                        id="kt_toolbar_primary_button" style="padding: 8px">
                                        Req Approval
                                        </a>
                                        <!--end::Button-->
                                                                                
                                        <!--begin::Button-->
                                        <a href="/proyek" class="btn btn-sm btn-light btn-active-primary" id="customer_new_close">
                                        Close</a>
                                        <!--end::Button-->
                                        
                                        
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

<!--begin::Header Orange-->
                                        <div class="col-xl-15 mb-8">
                                            <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                                <div class="card-body pt-auto"
                                                    style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                                    <div class="form-group">

                                                        <div id="stage-button" class="stage-list">
                                                        <a href="#" class="stage-button color-is-default stage-is-done"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Pasar Dini
                                                        </a>
                                                        <a href="#" class="stage-button color-is-default stage-is-not-active"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Pasar Potensial
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Prakualifikasi
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Tender Diikuti
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Perolehan
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Menang
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Terkontrak
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            ForeCast
                                                        </a>
                                                        <a href="#" class="stage-button stage-is-not-active color-is-default"
                                                            style="outline: 0px; cursor: pointer;">
                                                            Approval
                                                        </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            const stages = document.querySelectorAll(".stage-button");
                                            stages.forEach((stage, i) => {
                                                stage.setAttribute("stage", i + 1);
                                                if (i + 1 <= Number("{{ $proyek->stage }}")) {
                                                    stage.classList.add("stage-is-done");
                                                    stage.style.cursor = "cursor";
                                                } else {
                                                    stage.classList.add("stage-is-not-active");
                                                    stage.style.cursor = "cursor";
                                                    if (i > Number("{{ $proyek->stage }}")) {
                                                        stage.style.cursor = "not-allowed";
                                                        stage.style.pointerEvents = "none";
                                                    }
                
                                                }
                                                               
                                                stage.addEventListener("click", async e => {
                                                    e.stopPropagation();
                                                    const stage = e.target.getAttribute("stage");
                                                    const formData = new FormData();
                                                    formData.append("_token", "{{ csrf_token() }}");
                                                    formData.append("stage", stage);
                                                    // formData.append("id", "");
                                                    formData.append("kode_proyek", "{{ $proyek->kode_proyek }}");
                                                    const setStage = await fetch("/proyek/stage-save", {
                                                        method: "POST",
                                                        body: formData
                                                    }).then(res => res.json());
                                                    console.log(setStage);
                                                    if (setStage.link) {
                                                        // window.location.href = setStage.link;
                                                        window.location.reload();
                                                    }
                                                });
                                            });
                                        </script>
<!--end::Header Orange-->


                                <!--begin::All Content-->
                                <div class="col-xl-15">
                                    <!--begin::Contacts-->
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                        <!--begin::Card body-->
                                        <div class="card-body pt-5">


<!--begin:::Tabs Navigasi-->
                                        <ul
                                            class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                            @if ($proyek->stage > 0)
                                                <!--begin:::Tab item Pasar Dini-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active"
                                                        data-bs-toggle="tab" href="#kt_user_view_overview_pasardini"
                                                        style="font-size:14px;">Pasar Dini</a>
                                                </li>
                                                <!--end:::Tab item Pasar Dini-->
                                            @endif
                                            
                                            @if ($proyek->stage > 1)
                                            <!--begin:::Tab item Pasar Potensial-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_potensial"
                                                style="font-size:14px;">Pasar Potensial</a>
                                            </li>
                                            <!--end:::Tab item Pasar Potensial-->
                                            @endif
                                            
                                            @if ($proyek->stage > 2)
                                            <!--begin:::Tab item Prakualifikasi-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_prakualifikasi"
                                                style="font-size:14px;">Prakualifikasi</a>
                                            </li>
                                            <!--end:::Tab item Prakualifikasi-->
                                            @endif
                                            
                                            @if ($proyek->stage > 3)
                                            <!--begin:::Tab item Tender Diikuti-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_tender"
                                                style="font-size:14px;">Tender Diikuti</a>
                                            </li>
                                            <!--end:::Tab item Tender Diikuti-->
                                            @endif
                                            
                                            @if ($proyek->stage > 4)
                                            <!--begin:::Tab item Perolehan-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_perolehan"
                                                style="font-size:14px;">Perolehan</a>
                                            </li>
                                            <!--end:::Tab item Perolehan-->
                                            @endif
                                            
                                            @if ($proyek->stage > 5)
                                            <!--begin:::Tab item Menang-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_menang"
                                                style="font-size:14px;">Menang</a>
                                            </li>
                                            <!--end:::Tab item Menang-->
                                            @endif
                                            
                                            @if ($proyek->stage > 6)
                                            <!--begin:::Tab item Terkontrak-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_terkontrak"
                                                style="font-size:14px;">Terkontrak</a>
                                            </li>
                                            <!--end:::Tab item Terkontrak-->
                                            @endif
                                            
                                            <!--begin:::Tab item Forecast-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_forecast"
                                                style="font-size:14px;">Forecast</a>
                                            </li>
                                            <!--end:::Tab item Forecast-->

                                            <!--begin:::Tab item Approval-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_approval"
                                                style="font-size:14px;">Approval</a>
                                            </li>
                                            <!--end:::Tab item Approval-->

                                            @if ($proyek->stage > 8)
                                            <!--begin:::Tab item Feedback-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                href="#kt_user_view_overview_Feedback"
                                                style="font-size:14px;">Feedback</a>
                                            </li>
                                            <!--end:::Tab item Feedback-->
                                            @endif
                                        </ul>

<!--end:::Tabs Navigasi-->

                                        <!--begin:::Tab isi content  -->
                                        <div class="tab-content" id="myTabContent">

<!--begin:::Tab Pasar Dini-->
                                            <div class="tab-pane fade show active" id="kt_user_view_overview_pasardini" role="tabpanel">

                                                {{-- @php
                                                     isset($proyek->nama_proyek)
                                                @endphp --}}

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
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="nama-proyek" name="nama-proyek" value="{{ $proyek->nama_proyek }}" placeholder="Nama Proyek" />
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
                                                                <select name="unit-kerja" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                                data-placeholder="Pilih Unit Kerja">
                                                                    <option></option>
                                                                    @foreach ($unitkerjas as $unitkerja)
                                                                    @if ($unitkerja->divcode == $proyek->unit_kerja)
                                                                        <option value="{{ $unitkerja->divcode }}" selected>{{$unitkerja->unit_kerja }}</option>
                                                                    {{-- @else
                                                                        <option value="{{ $unitkerja->divcode }}">{{$unitkerja->unit_kerja }}</option> --}}
                                                                    @endif
                                                                    @endforeach
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
                                                                    <span class="required">Kode Proyek</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="kode-proyek" name="kode-proyek" value="{{ $proyek->kode_proyek }}" placeholder="Kode Proyek" disabled/>
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        
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
                                                                    <span class="required">Tipe Proyek</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="tipe-proyek" name="tipe-proyek" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Tipe Proyek">
                                                                    <option selected>{{ $proyek->tipe_proyek == "R" ? "Retail" : "Non-Retail" }}</option>
                                                                    {{-- <option value="R" {{ $proyek->tipe_proyek == "R" ? "selected" : "" }}>Retail</option>
                                                                    <option value="P" {{ $proyek->tipe_proyek == "P" ? "selected" : "" }}>Non-Retail</option> --}}
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
                                                                    <span class="required">Jenis Proyek</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="jenis-proyek" name="jenis-proyek" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                    data-placeholder="Pilih Jenis Proyek">
                                                                    <option selected>{{ $proyek->jenis_proyek == "I" ? "Internal" : "External" }}</option>
                                                                    {{-- <option value="I" {{ $proyek->jenis_proyek == "I" ? "selected" : "" }}>Internal</option>
                                                                    <option value="E" {{ $proyek->jenis_proyek == "E" ? "selected" : "" }}>External</option> --}}
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
                                                                    <span class="required">Bulan Pelaksanaan</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--Begin::Input-->
                                                                <select id="bulan-pelaksanaan" name="bulan-pelaksanaan" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Bulan Pelaksanaan">
                                                                    <option></option>
                                                                        <option value="Januari" {{ $proyek->bulan_pelaksanaan == "Januari" ? "selected" : "" }}>Januari</option>
                                                                        <option value="Februari" {{ $proyek->bulan_pelaksanaan == "Februari" ? "selected" : "" }}>Februari</option>
                                                                        <option value="Maret" {{ $proyek->bulan_pelaksanaan == "Maret" ? "selected" : "" }}>Maret</option>
                                                                        <option value="April" {{ $proyek->bulan_pelaksanaan == "April" ? "selected" : "" }}>April</option>
                                                                        <option value="Mei" {{ $proyek->bulan_pelaksanaan == "Mei" ? "selected" : "" }}>Mei</option>
                                                                        <option value="Juni" {{ $proyek->bulan_pelaksanaan == "Juni" ? "selected" : "" }}>Juni</option>
                                                                        <option value="Juli" {{ $proyek->bulan_pelaksanaan == "Juli" ? "selected" : "" }}>Juli</option>
                                                                        <option value="Agustus" {{ $proyek->bulan_pelaksanaan == "Agustus" ? "selected" : "" }}>Agustus</option>
                                                                        <option value="September" {{ $proyek->bulan_pelaksanaan == "September" ? "selected" : "" }}>September</option>
                                                                        <option value="Oktober" {{ $proyek->bulan_pelaksanaan == "Oktober" ? "selected" : "" }}>Oktober</option>
                                                                        <option value="November" {{ $proyek->bulan_pelaksanaan == "November" ? "selected" : "" }}>November</option>
                                                                        <option value="Desember" {{ $proyek->bulan_pelaksanaan == "Desember" ? "selected" : "" }}>Desember</option>
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
                                                                    <span class="required">Tahun Perolehan</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="number" class="form-control form-control-solid" name="tahun-perolehan" min="2021" max="2099" step="1" value="{{ $proyek->tahun_perolehan }}" disabled/>
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
                                                                    <span class="required">Sumber Dana</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="sumber-dana" name="sumber-dana" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                    data-placeholder="Pilih Sumber Dana">
                                                                    <option></option>
                                                                    @foreach ($sumberdanas as $sumberdana)
                                                                    @if ($sumberdana->nama_sumber == $proyek->sumber_dana)
                                                                        <option value="{{ $sumberdana->nama_sumber }}" selected>{{$sumberdana->nama_sumber }}</option>
                                                                    @else
                                                                        <option value="{{ $sumberdana->nama_sumber }}">{{$sumberdana->nama_sumber }}</option>
                                                                    @endif
                                                                    @endforeach
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
                                                                    <span class="required">Nilai OK RKAP</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="nilai-rkap" name="nilai-rkap" value="{{ $proyek->nilai_rkap }}" placeholder="Nilai OK RKAP" />
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
                                                                    <span>Customer</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                {{-- <option value="{{ $proyekberjalans->kode_proyek }}" selected>{{$proyekberjalans->kode_proyek }}</option> --}}
                                                                <select id="customer" name="customer" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                    data-placeholder="Pilih Customer">
                                                                    <option></option>
                                                                    @if (isset($proyekberjalans))
                                                                        @foreach ($customers as $customer)
                                                                        @if ($customer->id_customer == $proyekberjalans->id_customer)
                                                                        <option value="{{ $customer->id_customer }}" selected>{{$customer->name }}</option>
                                                                        @else
                                                                        <option value="{{ $customer->id_customer }}">{{$customer->name }}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    @else
                                                                        @foreach ($customers as $customer)
                                                                        <option value="{{ $customer->id_customer }}">{{$customer->name }}</option>
                                                                        @endforeach
                                                                    @endif
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
                                                                    <span >Nama PIC</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="pic" name="pic" value="{{ $proyek->pic }}" placeholder="Nama PIC" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End::Col-->
                                                    </div>
                                                    <!--End::Row Kanan+Kiri-->
                                                    
                                                    
                                                    <!--Begin::Title Biru Form: Nilai RKAP Review-->
                                                    &nbsp;<br>
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Nilai RKAP Review
                                                        {{-- <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_proyek">+</a> --}}
                                                    </h3>
                                                    &nbsp;<br>
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
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="nilai-valas-review" name="nilai-valas-review" value="{{ $proyek->nilai_valas_review }}" placeholder="Nilai OK Review (Valas) (Exclude Tax)" />
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
                                                                    <span>Mata Uang</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--Begin::Input-->
                                                                <select id="mata-uang-review" name="mata-uang-review" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Mata Uang">
                                                                    <option ></option>
                                                                    <option value="IDR" {{ $proyek->mata_uang_review == "IDR" ? "selected" : "" }}>IDR</option>
                                                                    <option value="USD" {{ $proyek->mata_uang_review == "USD" ? "selected" : "" }}>USD</option>
                                                                    <option value="YUAN" {{ $proyek->mata_uang_review == "YUAN" ? "selected" : "" }}>YUAN</option>
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
                                                                    <span>Kurs Review</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="kurs-review" name="kurs-review" value="{{ $proyek->kurs_review }}" placeholder="Kurs Review" />
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
                                                                    <span>Bulan Pelaksanaan</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--Begin::Input-->
                                                                <select id="bulan-pelaksanaan-review" name="bulan-pelaksanaan-review" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Bulan Pelaksanaan">
                                                                    <option ></option>
                                                                    <option value="Januari" {{ $proyek->bulan_review == "Januari" ? "selected" : "" }}>Januari</option>
                                                                    <option value="Februari" {{ $proyek->bulan_review == "Februari" ? "selected" : "" }}>Februari</option>
                                                                    <option value="Maret" {{ $proyek->bulan_review == "Maret" ? "selected" : "" }}>Maret</option>
                                                                    <option value="April" {{ $proyek->bulan_review == "April" ? "selected" : "" }}>April</option>
                                                                    <option value="Mei" {{ $proyek->bulan_review == "Mei" ? "selected" : "" }}>Mei</option>
                                                                    <option value="Juni" {{ $proyek->bulan_review == "Juni" ? "selected" : "" }}>Juni</option>
                                                                    <option value="Juli" {{ $proyek->bulan_review == "Juli" ? "selected" : "" }}>Juli</option>
                                                                    <option value="Agustus" {{ $proyek->bulan_review == "Agustus" ? "selected" : "" }}>Agustus</option>
                                                                    <option value="September" {{ $proyek->bulan_review == "September" ? "selected" : "" }}>September</option>
                                                                    <option value="Oktober" {{ $proyek->bulan_review == "Oktober" ? "selected" : "" }}>Oktober</option>
                                                                    <option value="November" {{ $proyek->bulan_review == "November" ? "selected" : "" }}>November</option>
                                                                    <option value="Desember" {{ $proyek->bulan_review == "Desember" ? "selected" : "" }}>Desember</option>
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
                                                                    <span>Nilai OK (Exclude PPN)</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="nilaiok-review" name="nilaiok-review" value="{{ $proyek->nilaiok_review }}" placeholder="Nilai OK (Exclude PPN)" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End::Col-->
                                                    </div>
                                                    <!--End::Row Kanan+Kiri-->
                                                    
                                                    
                                                    <!--Begin::Title Biru Form: Nilai RKAP Awal-->
                                                    &nbsp;<br>
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Nilai RKAP Awal
                                                        {{-- <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_proyek">+</a> --}}
                                                    </h3>
                                                    &nbsp;<br>
                                                    <!--End::Title Biru Form: Nilai RKAP Awal-->
                                                    
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
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="nilai-valas-awal" name="nilai-valas-awal" value="{{ $proyek->nilai_valas_awal }}" placeholder="Nilai OK Review (Valas) (Exclude Tax)" />
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
                                                                    <span>Mata Uang</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--Begin::Input-->
                                                                <select id="mata-uang-awal" name="mata-uang-awal" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Mata Uang">  
                                                                    <option ></option>
                                                                    <option value="IDR" {{ $proyek->mata_uang_awal == "IDR" ? "selected" : "" }}>IDR</option>
                                                                    <option value="USD" {{ $proyek->mata_uang_awal == "USD" ? "selected" : "" }}>USD</option>
                                                                    <option value="YUAN" {{ $proyek->mata_uang_awal == "YUAN" ? "selected" : "" }}>YUAN</option>
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
                                                                    <span>Kurs Review</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="kurs-awal" name="kurs-awal" value="{{ $proyek->kurs_awal }}" placeholder="Kurs Review" />
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
                                                                    <span>Bulan Pelaksanaan</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--Begin::Input-->
                                                                <select id="bulan-pelaksanaan-awal" name="bulan-pelaksanaan-awal" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Bulan Pelaksanaan">
                                                                    <option ></option>
                                                                    <option value="Januari" {{ $proyek->bulan_awal == "Januari" ? "selected" : "" }}>Januari</option>
                                                                    <option value="Februari" {{ $proyek->bulan_awal == "Februari" ? "selected" : "" }}>Februari</option>
                                                                    <option value="Maret" {{ $proyek->bulan_awal == "Maret" ? "selected" : "" }}>Maret</option>
                                                                    <option value="April" {{ $proyek->bulan_awal == "April" ? "selected" : "" }}>April</option>
                                                                    <option value="Mei" {{ $proyek->bulan_awal == "Mei" ? "selected" : "" }}>Mei</option>
                                                                    <option value="Juni" {{ $proyek->bulan_awal == "Juni" ? "selected" : "" }}>Juni</option>
                                                                    <option value="Juli" {{ $proyek->bulan_awal == "Juli" ? "selected" : "" }}>Juli</option>
                                                                    <option value="Agustus" {{ $proyek->bulan_awal == "Agustus" ? "selected" : "" }}>Agustus</option>
                                                                    <option value="September" {{ $proyek->bulan_awal == "September" ? "selected" : "" }}>September</option>
                                                                    <option value="Oktober" {{ $proyek->bulan_awal == "Oktober" ? "selected" : "" }}>Oktober</option>
                                                                    <option value="November" {{ $proyek->bulan_awal == "November" ? "selected" : "" }}>November</option>
                                                                    <option value="Desember" {{ $proyek->bulan_awal == "Desember" ? "selected" : "" }}>Desember</option>
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
                                                                    <span>Nilai OK (Exclude PPN)</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid reformat" 
                                                                id="nilaiok-awal" name="nilaiok-awal" value="{{ $proyek->nilaiok_awal }}" placeholder="Nilai OK (Exclude PPN)" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End::Col-->
                                                    </div>
                                                    <!--End::Row Kanan+Kiri-->
                                                    
                                                    <!--Begin::Title Biru Form: Kriteria pasar-->
                                                    &nbsp;<br>
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Kriteria pasar
                                                        <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a>
                                                    </h3>
                                                    &nbsp;<br>
                                                    <!--End::Title Biru Form: Kriteria pasar-->
                                                    
                                                    <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                    &nbsp;<br>
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Laporan Kualitatif
                                                    </h3>
                                                    &nbsp;<br>
                                                    <div class="form-group">
                                                        <textarea id="laporan-kualitatif-pasdin" name="laporan-kualitatif-pasdin" class="form-control form-control-solid" id="exampleFormControlTextarea1" rows="3">{{ $proyek->laporan_kualitatif_pasdin }}</textarea>
                                                    </div>
                                                    <!--End::Title Biru Form: Laporan Kualitatif-->

                                            </div>
<!--end:::Tab Pasar Dini-->
                                            

<!--begin:::Tab Pasar Potensial-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_potensial" role="tabpanel">

                                                    <!--begin::Row-->
                                                    <div class="row fv-row">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>Negara</span>
                                                                </label>
                                                                <!--end::Label-->

                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="negara" name="negara" value="{{ $proyek->negara }}" placeholder="Negara" />
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
                                                                    <span>SBU</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="sbu" name="sbu" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih SBU">
                                                                    <option></option>
                                                                    @foreach ($sbus as $sbu)
                                                                    @if ($sbu->sbu == $proyek->sbu)
                                                                        <option value="{{ $sbu->sbu }}" selected>{{$sbu->sbu }}</option>
                                                                    @else
                                                                        <option value="{{ $sbu->sbu }}">{{$sbu->sbu }}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
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
                                                                    <span>Provinsi</span>
                                                                </label>
                                                                <!--end::Label-->

                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="provinsi" name="provinsi" value="{{ $proyek->provinsi }}" placeholder="Provinsi" />
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
                                                                    <span>Klasifikasi</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="klasifikasi" name="klasifikasi" value="{{ $proyek->klasifikasi }}" placeholder="Klasifikasi" />
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
                                                                    <span>Status Pasar</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="status-pasar" name="status-pasar" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Status Pasar">
                                                                    <option ></option>
                                                                    <option value="Dikelola Negara" {{ $proyek->status_pasar == "Dikelola Negara" ? "selected" : "" }}>Dikelola Negara</option>
                                                                    <option value="Dikelola Swasta" {{ $proyek->status_pasar == "Dikelola Swasta" ? "selected" : "" }}>Dikelola Swasta</option>
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
                                                                    <span>Sub-Klasifikasi</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" 
                                                                id="sub-klasifikasi" name="sub-klasifikasi" value="{{ $proyek->sub_klasifikasi }}" placeholder="Sub-Klasifikasi" />
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
                                                                    <span>DOP</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="dop" name="dop" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                    data-placeholder="Pilih DOP">
                                                                    <option selected>{{ $proyek->dop }}</option>
                                                                    {{-- @foreach ($dops as $dop)
                                                                    @if ($dop->dop == $proyek->dop)
                                                                        <option value="{{ $dop->dop }}" selected>{{$dop->dop }}</option>
                                                                    @else
                                                                        <option value="{{ $dop->dop }}">{{$dop->dop }}</option>
                                                                    @endif
                                                                    @endforeach --}}
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
                                                                    <span>Company</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select id="company" name="company" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                    data-placeholder="Pilih Company">
                                                                    <option selected>{{ $proyek->company }}</option>
                                                                    {{-- @foreach ($companies as $company)
                                                                    @if ($company->nama_company == $proyek->company)
                                                                        <option value="{{ $company->nama_company }}" selected>{{$company->nama_company }}</option>
                                                                    @else
                                                                        <option value="{{ $company->nama_company }}">{{$company->nama_company }}</option>
                                                                    @endif
                                                                    @endforeach --}}
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                    </div>
                                                    <!--End begin::Row-->
                                                    
                                                    <!--Begin::Title Biru Form: Kriteria pasar-->
                                                    &nbsp;<br>
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Kriteria pasar
                                                        <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a>
                                                    </h3>
                                                    &nbsp;<br>
                                                    <!--End::Title Biru Form: Kriteria pasar-->
                                                    
                                                    
                                                    <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                    &nbsp;<br>
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Laporan Kualitatif
                                                    </h3>
                                                    &nbsp;<br>
                                                    <div class="form-group">
                                                        <textarea class="form-control form-control-solid" id="laporan-kualitatif-paspot" name="laporan-kualitatif-paspot" rows="3">{{ $proyek->laporan_kualitatif_paspot }}</textarea>
                                                    </div>
                                                    <!--End::Title Biru Form: Laporan Kualitatif-->

                                            </div>
<!--end:::Tab Pasar Potensial-->


<!--begin:::Tab Prakualifikasi-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_prakualifikasi" role="tabpanel">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Jadwal PQ</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" name="jadwal-pq" value="{{ $proyek->jadwal_pq }}" placeholder="Date" />
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
                                                                <span>HPS / Pagu</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="hps-pagu" name="hps-pagu" value="{{ $proyek->hps_pagu }}" placeholder="HPS / Pagu" />
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
                                                                <span>Jadwal Proyek</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" name="jadwal-proyek" value="{{ $proyek->jadwal_proyek }}" placeholder="Date" />
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
                                                                <span>Porsi JO(%)</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="porsi-jo" name="porsi-jo" value="{{ $proyek->porsi_jo }}" placeholder="Porsi JO(%)" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>
                                                <!--End begin::Row-->

                                                
                                                <!--Begin::Title Biru Form: Partner JO-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Partner JO
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: Partner JO-->


                                                <!--Begin::Title Biru Form: Document Prakualifikasi-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Document Prakualifikasi
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: Document Prakualifikasi-->
                                                
                                                
                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Ketua Team Tender</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="ketua-tender" name="ketua-tender" value="{{ $proyek->ketua_tender }}" placeholder="Ketua Team Tender" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                </div>
                                                <!--End begin::Row-->
                                                
                                                
                                                <!--Begin::Title Biru Form: SKT Personil-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">SKT Personil
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">+</a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: SKT Personil-->

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="w-50px text-center">No.</th>
                                                                        <th class="max-w-50px">Nama</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                @php
                                                                    $no=1;
                                                                @endphp
                                                                @foreach ($teams as $team)
                                                                <tbody class="fw-bold text-gray-600">

                                                                    <tr>
                                                                        <!--begin::Name=-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name=-->
                                                                        <!--begin::Email=-->
                                                                        <td>
                                                                            {{ $team->User->name }}
                                                                        </td>
                                                                        <!--end::Email=-->
                                                                </tbody>
                                                                @endforeach
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Table-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                </div>
                                                <!--End begin::Row-->
                                                
                                                <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Laporan Kualitatif
                                                </h3>
                                                &nbsp;<br>
                                                <div class="form-group">
                                                    <textarea class="form-control form-control-solid" id="laporan-prakualifikasi" name="laporan-prakualifikasi" rows="3">{{ $proyek->laporan_prakualifikasi }}</textarea>
                                                </div>
                                                <!--End::Title Biru Form: Laporan Kualitatif-->


                                            </div>
<!--end:::Tab pane Prakualifikasi-->



<!--begin:::Tab pane Tender Diikuti-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_tender" role="tabpanel">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                    <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Jadwal Tender</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" 
                                                            id="jadwal-tender" name="jadwal-tender" value="{{ $proyek->jadwal_tender }}" placeholder="Date" />
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
                                                                <span>Lokasi Tender</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="lokasi-tender" name="lokasi-tender" value="{{ $proyek->lokasi_tender }}" placeholder="Lokasi Tender" />
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
                                                                <span>Nilai Penawaran</span>
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="penawaran-tender" name="penawaran-tender" value="{{ $proyek->penawaran_tender }}" placeholder="Nilai Penawaran" />
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
                                                                <span>HPS/Pagu Rupiah</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="hps-tender" name="hps-tender" value="{{ $proyek->hps_tender }}" placeholder="HPS/Pagu Rupiah" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>
                                                <!--End begin::Row-->

                                                
                                                <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Laporan Kualitatif
                                                </h3>
                                                &nbsp;<br>
                                                <div class="form-group">
                                                    <textarea class="form-control form-control-solid" id="laporan-tender" name="laporan-tender" rows="3">{{ $proyek->laporan_tender }}</textarea>
                                                </div>
                                                <!--End::Title Biru Form: Laporan Kualitatif-->
                                                
                                            </div>
<!--end:::Tab pane Tender Diikuti-->


<!--begin:::Tab Perolehan-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_perolehan" role="tabpanel">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                    <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Total Biaya Pra-Proyek</span>
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="biaya-praproyek" name="biaya-praproyek" value="{{ $proyek->biaya_praproyek }}" placeholder="Total Biaya Pra-Proyek" />
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
                                                                <span>Nilai Penawaran</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="penawaran-perolehan" name="penawaran-perolehan" value="{{ $proyek->penawaran_perolehan }}" placeholder="Nilai Penawaran" />
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
                                                                <span>HPS/Pagu Rupiah</span>
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="hps-perolehan" name="hps-perolehan" value="{{ $proyek->hps_perolehan }}" placeholder="HPS/Pagu Rupiah" />
                                                            <!--end::Input-->
                                                        </div>
                                                    <!--end::Input group-->
                                                    </div>
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
                                                                <span>% OE Wika</span>
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="oe-wika" name="oe-wika" value="{{ $proyek->oe_wika }}" placeholder="% OE Wika" />
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
                                                                <span>Peringkat Wika</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="peringkat-wika" name="peringkat-wika" value="{{ $proyek->peringkat_wika }}" placeholder="Peringkat Wika" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>
                                                <!--End begin::Row-->

                                                <!--Begin::Title Biru Form: List Peserta Tender-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">List Peserta Tender
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: List Peserta Tender-->
                                                
                                                
                                                <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Laporan Kualitatif
                                                </h3>
                                                &nbsp;<br>
                                                <div class="form-group">
                                                    <textarea class="form-control form-control-solid" id="laporan-perolehan" name="laporan-perolehan" rows="3">{{ $proyek->laporan_perolehan }}</textarea>
                                                </div>
                                                <!--End::Title Biru Form: Laporan Kualitatif-->

                                            </div>
<!--end:::Tab Perolehan-->


<!--begin:::Tab Menang-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_menang" role="tabpanel">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                    <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Aspek Pesaing</span>
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="aspek-pesaing" name="aspek-pesaing" value="{{ $proyek->aspek_pesaing }}" placeholder="Aspek Pesaing" />
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
                                                                <span>Aspek Non Pesaing</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="aspek-non-pesaing" name="aspek-non-pesaing" value="{{ $proyek->aspek_non_pesaing }}" placeholder="Aspek Non Pesaing" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>
                                                <!--End begin::Row-->


                                                <!--Begin::Title Biru Form: Usulan Saran Perbaikan-->
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span>Usulan Saran Perbaikan</span>
                                                </label>
                                                <div class="form-group">
                                                    <textarea class="form-control form-control-solid" id="saran-perbaikan" name="saran-perbaikan" rows="3">{{ $proyek->saran_perbaikan }}</textarea>
                                                </div>
                                                <!--End::Title Biru Form: Usulan Saran Perbaikan-->

                                            </div>
<!--end:::Tab Menang-->


<!--begin:::Tab Pasar Terkontrak New-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_terkontrak" role="tabpanel">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>No SPK External</span>
                                                            </label>
                                                            <!--end::Label-->

                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="nospk-external" name="nospk-external" value="{{ $proyek->nospk_external }}" placeholder="No SPK External" />
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
                                                                <span>Jenis Proyek</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select id="jenis-proyek-terkontrak" name="jenis-proyek-terkontrak" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Pilih Jenis Proyek">
                                                                <option ></option>
                                                                <option value="Internal" {{ $proyek->jenis_proyek_terkontrak == "Internal" ? "selected" : "" }}>Internal</option>
                                                                <option value="External" {{ $proyek->jenis_proyek_terkontrak == "External" ? "selected" : "" }}>External</option>
                                                            </select>
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
                                                                <span>Tanggal SPK Internal</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" 
                                                            id="tglspk-internal" name="tglspk-internal" value="{{ $proyek->tglspk_internal }}" placeholder="Date" />
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
                                                                <span>Porsi JO (%)</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="porsijo-terkontrak" name="porsijo-terkontrak" value="{{ $proyek->porsijo_terkontrak }}" placeholder="Porsi JO (%)" />
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
                                                                <span>Tahun RI Perolehan</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="number" class="form-control form-control-solid" 
                                                            id="" name="tahun-ri-perolehan" min="2020" max="2099" step="1" value="{{ $proyek->tahun_ri_perolehan }}" placeholder="Tahun Ri Perolehan"/>
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
                                                                <span>Nilai OK Review (Valas) (Exclude Tax)</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="nilaiok-terkontrak" name="nilaiok-terkontrak" value="{{ $proyek->nilaiok_terkontrak }}" placeholder="Nilai OK Review (Valas) (Exclude Tax)" />
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
                                                                <span>Bulan RI Perolehan</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--Begin::Input-->
                                                            <select id="bulan-ri-perolehan" name="bulan-ri-perolehan" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                            data-placeholder="Pilih Bulan RI Perolehan">
                                                                <option ></option>
                                                                <option value="Januari" {{ $proyek->bulan_ri_perolehan == "Januari" ? "selected" : "" }}>Januari</option>
                                                                <option value="Februari" {{ $proyek->bulan_ri_perolehan == "Februari" ? "selected" : "" }}>Februari</option>
                                                                <option value="Maret" {{ $proyek->bulan_ri_perolehan == "Maret" ? "selected" : "" }}>Maret</option>
                                                                <option value="April" {{ $proyek->bulan_ri_perolehan == "April" ? "selected" : "" }}>April</option>
                                                                <option value="Mei" {{ $proyek->bulan_ri_perolehan == "Mei" ? "selected" : "" }}>Mei</option>
                                                                <option value="Juni" {{ $proyek->bulan_ri_perolehan == "Juni" ? "selected" : "" }}>Juni</option>
                                                                <option value="Juli" {{ $proyek->bulan_ri_perolehan == "Juli" ? "selected" : "" }}>Juli</option>
                                                                <option value="Agustus" {{ $proyek->bulan_ri_perolehan == "Agustus" ? "selected" : "" }}>Agustus</option>
                                                                <option value="September" {{ $proyek->bulan_ri_perolehan == "September" ? "selected" : "" }}>September</option>
                                                                <option value="Oktober" {{ $proyek->bulan_ri_perolehan == "Oktober" ? "selected" : "" }}>Oktober</option>
                                                                <option value="November" {{ $proyek->bulan_ri_perolehan == "November" ? "selected" : "" }}>November</option>
                                                                <option value="Desember" {{ $proyek->bulan_ri_perolehan == "Desember" ? "selected" : "" }}>Desember</option>
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
                                                                <span>Mata Uang</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--Begin::Input-->
                                                            <select id="matauang-terkontrak" name="matauang-terkontrak" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                            data-placeholder="Pilih Mata Uang">
                                                                <option ></option>
                                                                <option value="IDR" {{ $proyek->matauang_terkontrak == "IDR" ? "selected" : "" }}>IDR</option>
                                                                <option value="USD" {{ $proyek->matauang_terkontrak == "USD" ? "selected" : "" }}>USD</option>
                                                                <option value="YUAN" {{ $proyek->matauang_terkontrak == "YUAN" ? "selected" : "" }}>YUAN</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>
                                                <!--End begin::Row-->

                                                <!--begin::Row Kanan+Kiri-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                    <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>No Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="nomor-terkontrak" name="nomor-terkontrak" value="{{ $proyek->nomor_terkontrak }}" placeholder="No Kontrak" />
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
                                                                <span>Kurs Review</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="kurs-review-terkontrak" name="kurs-review-terkontrak" value="{{ $proyek->kursreview_terkontrak }}" placeholder="Kurs Review" />
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
                                                                <span>Tanggal Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" 
                                                            id="tanggal-terkontrak" name="tanggal-terkontrak" value="{{ $proyek->tanggal_terkontrak }}" placeholder="Date" />
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
                                                                <span>Nilai Kontrak Keseluruhan</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="nilai-kontrak-keseluruhan" name="nilai-kontrak-keseluruhan" value="{{ $proyek->nilai_kontrak_keseluruhan}}" placeholder="Nilai Kontrak Keseluruhan" />
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
                                                                <span>Tanggal Mulai Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" 
                                                            id="tanggal-mulai-kontrak" name="tanggal-mulai-kontrak" value="{{ $proyek->tanggal_mulai_terkontrak }}" placeholder="Date" />
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
                                                                <span>Nilai Kontrak (Porsi WIKA)</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid reformat" 
                                                            id="nilai-wika-terkontrak" name="nilai-wika-terkontrak" value="{{ $proyek->nilai_wika_terkontrak }}" placeholder="Nilai Kontrak (Porsi WIKA)" />
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
                                                                <span>Tanggal Akhir Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" 
                                                            id="tanggal-akhir-kontrak" name="tanggal-akhir-kontrak" value="{{ $proyek->tanggal_akhir_terkontrak }}" placeholder="Date" />
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
                                                                <span>Klasifikasi Proyek</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="klasifikasi-terkontrak" name="klasifikasi-terkontrak" value="{{ $proyek->klasifikasi_terkontrak }}" placeholder="Klasifikasi Proyek" />
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
                                                                <span>Tanggal Selesai Bash PHO</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="Date" class="form-control form-control-solid" 
                                                            id="tanggal-selesai-kontrak" name="tanggal-selesai-kontrak" value="{{ $proyek->tanggal_selesai_terkontrak }}" placeholder="Date" />
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
                                                                <span>Jenis Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select id="jenis-terkontrak" name="jenis-terkontrak" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
                                                                data-placeholder="Jenis Kontrak">
                                                                <option ></option>
                                                                <option value="Internal" {{ $proyek->jenis_terkontrak == "Internal" ? "selected" : "" }}>Internal</option>
                                                                <option value="External" {{ $proyek->jenis_terkontrak == "External" ? "selected" : "" }}>External</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End::Col-->
                                                </div>
                                                <!--End::Row Kanan+Kiri-->

                                            </div>
<!--end:::Tab Pasar Terkontrak New-->


<!--begin:::Tab Approval-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_approval" role="tabpanel">

                                                <!--Begin::Title Biru Form: Approval-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Approval (user interface)
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal"> </a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: List Peserta Tender-->

                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">Kode Proyek</th>
                                                            <th class="min-w-auto">Nama Proyek</th>
                                                            <th class="min-w-auto">Unit Kerja</th>
                                                            <th class="min-w-auto">Nilai RKAP</th>
                                                            <th class="min-w-auto">Aprove By</th>
                                                            <th class="min-w-auto">Approval Status</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600">
                                                        <tr>
                                                            
                                                            <!--begin::Name=-->
                                                            <td>
                                                                <a href="/proyek/view/{{ $proyek->id }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
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
                                                            
                                                            <!--begin::Action=-->
                                                            <td>
                                                                {{ $proyek->nilai_rkap }}
                                                            </td>
                                                            <!--end::Action=-->
                                                            <!--begin::Action=-->
                                                            <td>
                                                                Head Of Division
                                                            </td>
                                                            <!--end::Action=-->
                                                            <!--begin::Action=-->
                                                            <td>
                                                                -
                                                            </td>
                                                            <!--end::Action=-->
                                                        </tr>
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->

                                                <!--Begin::Title Biru Form: Approval-->
                                                &nbsp;<br>
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Approval (Head interface)
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal"> </a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: List Peserta Tender-->

                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">Kode Proyek</th>
                                                            <th class="min-w-auto">Nama Proyek</th>
                                                            <th class="min-w-auto">Unit Kerja</th>
                                                            <th class="min-w-auto">Nilai RKAP</th>
                                                            <th class="min-w-auto text-center">Action</th>
                                                            {{-- <th class="min-w-auto">Action</th> --}}
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600">
                                                        <tr>
                                                            
                                                            <!--begin::Name=-->
                                                            <td>
                                                                <a href="/proyek/view/{{ $proyek->id }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
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
                                                            
                                                            <!--begin::Action=-->
                                                            <td>
                                                                {{ $proyek->nilai_rkap }}
                                                            </td>
                                                            <!--end::Action=-->
                                                            <!--begin::Action=-->
                                                            <td class="text-center">
                                                                <div class="d-grid gap-2 d-md-block">
                                                                    <!--begin::Button-->
                                                                    <button type="submit" class="btn btn-sm btn-primary" id="customer_new_save"
                                                                    style="background-color:#ffa62b; margin-left:10px">
                                                                    Approve</button>
                                                                    <!--end::Button-->
                                                                    
                                                                    <button class="btn btn-sm btn-light btn-active-danger" onclick="return confirm('Deleted file can not be undo. Are You Sure ?')">Reject</button>
                                                                </div>
                                                            </td>
                                                            <!--end::Action=-->
                                                            {{-- <!--begin::Action=-->
                                                            <td>
                                                                null
                                                            </td>
                                                            <!--end::Action=--> --}}
                                                        </tr>
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->

                                            </div>
<!--end:::Tab Approval-->

<!--begin:::Tab Feedback-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_feedback" role="tabpanel">

                                                <!--Begin::Title Biru Form: Approval-->
                                                &nbsp;<br>
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Proyek Feedback
                                                    <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_feedback">+</a>
                                                </h3>
                                                &nbsp;<br>
                                                <!--End::Title Biru Form: List Peserta Tender-->

                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">Nama Customer</th>
                                                            <th class="min-w-auto">Ratings</th>
                                                            <th class="min-w-400px">Approval Status</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-600">
                                                        <tr>
                                                            
                                                            <!--begin::Email=-->
                                                            <td>
                                                                PT. Membangun Negeri
                                                            </td>
                                                            <!--end::Email=-->
                                                            <!--begin::Company=-->
                                                            <td>
                                                                &#9733;&#9733;&#9733;&#9733;&#9733;
                                                            </td>
                                                            <!--end::Company=-->
                                                            
                                                            <!--begin::Action=-->
                                                            <td>
                                                                Lorem Ipsum dolor sit amet guido lan gustom inercos tanttio, el bro sautires ki del proesa bukari oresro.
                                                            </td>
                                                            <!--end::Action=-->
                                                        </tr>
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->

                                                
<!--end:::Tab Feedback-->

<!--begin:::Tab Forecast-->
    <div class="tab-pane fade" id="kt_user_view_overview_forecast" role="tabpanel">

        <!--Begin::Title Biru Form: Approval-->
        &nbsp;<br>
        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">History Forecast</h3>
        &nbsp;<br>
        <!--End::Title Biru Form: List Peserta Tender-->

        {{-- begin::Detail History Forecast --}}
        <div class="d-flex flex-row-reverse mb-5">
            <div>
                Periode Prognosa
                @php
                    setlocale(LC_TIME, 'id.UTF-8');
                    $periode_prognosa = count($historyForecast) > 0 ? strftime('%B', mktime(0, 0, 0, $historyForecast[0]->periode_prognosa)) : "Belum Dibuat";                                              
                @endphp
                <b class="mx-4">{{$periode_prognosa}}</b>
            </div>
        </div>
        {{-- end::Detail History Forecast --}}

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-auto">Nama Proyek</th>
                    <th class="min-w-auto">Nilai OK</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">
                @for ($i = 0; $i < 12; $i++)
                    <tr>
                        
                        <!--begin::Name=-->
                        <td>
                            <h6 class="text-gray-600 fw-light">{{ $proyek->nama_proyek }}</h6>
                        </td>
                        <!--end::Name=-->
                        @if(count($historyForecast) > 0)
                        @foreach ($historyForecast as $history)
                            @if ($i + 1 == $history->periode_prognosa)
                                <!--begin::Nilai OK=-->
                                <td class="text-dark">
                                    {{ $proyek->nilai_rkap }}
                                </td>
                                <!--end::Nilai OK=-->
                                @break
                                @else 
                                <!--begin::Nilai OK=-->
                                <td class="text-dark">
                                    0
                                </td>
                                <!--end::Nilai OK=-->
                                @break

                            @endif
                        @endforeach
                        @else 
                                <!--begin::Nilai OK=-->
                                <td class="text-dark">
                                    0
                                </td>
                                <!--end::Nilai OK=-->
                        @endif

                    </tr>
                @endfor
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
<!--end:::Tab Forecast-->


                                        </div>
                                        <!--end:::Tab isi content-->
            
                                        </div>
                                        <!--end::Card body-->

									</div>
									<!--end::Content-->
                                    </form>
									<!--end::Form-->
                                    
                                </div>
                                <!--end::Contacts App- Edit Contact-->
                                
							</div>
							<!--end::Container-->
						</div>
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

 


<!--begin::Modal-->

<!--begin::modal ADD USER-->
			<form action="/proyek/user/add" method="post" enctype="multipart/form-data"> 
				@csrf
				
				<input type="hidden" name="assign-kode-proyek" value="{{ $proyek->kode_proyek }}" id="id-customer">
				<input type="hidden" name="assign-stage" value="{{ $proyek->stage }}" id="id-customer">

				<!--begin::Modal - Create Proyek-->
				<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-600px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2>Assign Team untuk proyek : {{ $proyek->nama_proyek }}</h2>
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
									<div class="">
										<!--begin::Input group Website-->
										<div class="fv-row">
											{{-- <!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span class="required">Nama Company</span>
											</label>
											<!--end::Label--> --}}
											<!--begin::Input-->
                                            <select name="nama-team" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilih Team">
                                                <option></option>
                                                @foreach ($users as $user)
                                                {{-- @if ($user->name == $proyek->name) --}}
                                                    {{-- <option value="{{ $user->name }}" selected>{{$user->name }}</option> --}}
                                                {{-- @else --}}
                                                    <option value="{{ $user->id }}">{{$user->name }}</option>
                                                {{-- @endif --}}
                                                @endforeach
                                            </select>
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									</div>
									<!--End begin::Col-->
								</div>
								<!--End::Row Kanan+Kiri-->

                            </div>														
                                <div class="modal-footer">
								
								    <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save" style="background-color:#ffa62b">Save</button>
									
								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>
					<!--end::Modal - Create App-->
				</form>    
<!--end::modal ADD USER-->

<!--begin::modal APPROVAL-->
			{{-- <form action="/proyek" method="post" enctype="multipart/form-data"> 
				@csrf --}}
				
				<!--begin::Modal - Create Proyek-->
				<div class="modal fade" id="kt_modal_create_approval" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2>Choose Approval Head :</h2>
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
											<!--begin::Input-->
											<select name="head-approval" 
												class="form-select form-select-solid" 
												data-control="select2" data-hide-search="true" 
												data-placeholder="Select Head To Send Approval">
												<option></option>
												<option value="Head Divisi Bangun Gedung">Head Divisi Bangun Gedung</option>
												<option value="Head Divisi Industri Plant">Head Divisi Industri Plant</option>
												<option value="Head Industri Infrastruktur">Head Industri Infrastruktur</option>
											</select>
											<!--end::Input-->
								</div>
								<!--End::Row Kanan+Kiri-->
                                <br>
                            <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Send</button>
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Create App-->
        {{-- </form>     --}}
<!--begin::modal APPROVAL-->
<!--end::Modals-->

<!--begin::Feedback Modals-->
    
    {{-- <form action="/customer/save-modal" method="post" enctype="multipart/form-data"> 
    @csrf --}}
    
    <!--begin::Modal - Feedback-->
    <div class="modal fade" id="kt_modal_feedback" tabindex="-1" aria-hidden="true">
    
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Feedback</h2>
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
                
                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span>Nama Customer</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" 
                    id="nama-feedback" name="nama-feedback" value="" placeholder="Nama Customer" />
                    <!--end::Input-->
                    <br>
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span>Peringkat :&nbsp;&nbsp;</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <label class="form-check-label" for="inlineRadio1">1</label>
                      </div>
                      <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <label class="form-check-label" for="inlineRadio2">2</label>
                      </div>
                      <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                        <label class="form-check-label" for="inlineRadio3">3</label>
                      </div>
                      <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option4">
                        <label class="form-check-label" for="inlineRadio4">4</label>
                      </div>
                      <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio5" value="option5">
                        <label class="form-check-label" for="inlineRadio5">5</label>
                      </div>
                    <!--end::Input-->
                    
                    <!--begin::Label-->
                    <div>
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span>Kritik dan saran</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        &nbsp;<br>
                        <div class="form-group">
                            <textarea id="laporan-kualitatif-pasdin" name="laporan-kualitatif-pasdin" class="form-control form-control-solid" id="exampleFormControlTextarea1" rows="3">{{ $proyek->laporan_kualitatif_pasdin }}</textarea>
                        </div>
                        <!--end::Input-->
                    </div>
                    </div>
                    <!--end::Input group-->
                    
                    <button type="submit" class="btn btn-sm btn-primary" id="feedback_new_save">Save</button>
                        
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    {{-- </form> --}}

<!--end:: Feedback Modals-->



@endsection
{{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script> --}}
