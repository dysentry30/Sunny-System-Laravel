<html lang="en">
<head>
    <base href="">
    <title>WIKA Survey Customer</title>
    
    <!-- begin::DataTables -->
    <link rel="stylesheet" href="datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatables/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <!-- end::DataTables -->

    <link rel="shortcut icon" href="{{ asset('/media/logos/Icon-Sunny.png') }}" />
    <!--begin::Fonts-->

    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> --}}
    <link rel="stylesheet" href="{{ asset('/css/cssFont.css') }}" />
    <!--end::Fonts-->

    <!-- begin::Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> --}}
    <link href="{{ asset('/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"> --}}
    <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap-icons.css') }}">
    <!-- end::Bootstrap CSS -->

    <!-- begin::Froala CSS -->
    {{-- <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' /> --}}
    <link href='{{ asset('/froala/froala_editor.pkgd.min.css') }}' rel='stylesheet'
        type='text/css' />
    <!-- end::Froala CSS -->

    {{-- begin::sweetalert2 JS --}}
    <script src="{{ asset('/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- end::sweetalert2 JS --}}
    
    <!-- Begin:: Leaflet Map -->
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin=""/> --}}
    <!-- End:: Leaflet Map -->

    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/stage.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/calendar.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->


    {{-- begin:: Disable Native Date Browser --}}
    <style>
        input[type="date"]::-webkit-input-placeholder {
            visibility: hidden !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            display: none;
        }

        .select2-selection__rendered{
            color: #181c32 !important;
        }

        /* change color sortable to default text-gray-400 */
        th a{
            color: #b5b5c3 !important;
        }
        tr td, tr td a{
            color: #3f4254 !important;
        }
        .swal2-select {
            border-radius: 0;
            border: 0;
            border-bottom: 1px dashed #606061;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 8px !important;
            border: none !important;
            width: 40px !important;
        }
        div.dataTables_wrapper div.dataTables_length {
            margin-right: 5px !important;
            width: none !important;
        }
        
        .buttons-html5 {
            border-radius: 5px !important;
            border: none !important;
        }
        .buttons-colvis {
            border: none !important;
            border-radius: 5px !important;
        }
        div.dataTables_wrapper div.dataTables_filter input{
            border-radius: 5px !important;
        }
        
        /* @media (min-width: 992px) {
            [data-kt-aside-minimize=on] .aside {
                width: 50px !important;
                transition: width 0.3s ease;
            }
        } */
        
        .fr-wrapper div:not(.fr-element.fr-view):nth-child(1) {
            display: none;
        }

        div.dt-button-collection button.dt-button.active:not(.disabled) {
            background: #0db0d9 !important;
            color: white;
            border-radius: 4px;
            padding: 10px;
            border: none;
            font-weight: normal;
            
        }
        
        div.dt-button-collection button.dt-button:not(.disabled) {
            font-weight: normal;
            border: none;
            border-radius: 4px;
            padding: 10px;

        }

    </style>
    {{-- end:: Disable Native Date Browser --}}
</head>
<!--end::Head-->


<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">




    <!--begin:: CONTENT-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" style="padding-left: 0px !important" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar" style="left: 0px !important">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">KUESIONER KEPUASAN PELANGGAN (&nbsp;<b> {{ $proyek->nama_proyek }} </b>&nbsp;)
                                </h1>
                                <!--end::Title-->
                            </div>

                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">
                                    @php
                                        $viewer = Auth::user()->nip != $csi->id_struktur_organisasi;
                                    @endphp

                                    @if ($viewer)
                                        <!--begin::Button-->
                                        <a href="/csi" class="btn btn-sm btn-light btn-active-primary ms-2">
                                            Back</a>
                                        <!--end::Button-->
                                    @else
                                        <!--begin::Button-->
                                        <a href="/logout" class="btn btn-sm btn-light btn-active-primary ms-2">
                                            Cancel</a>
                                        <!--end::Button-->
                                    @endif

                                    <!--begin::Wrapper-->
                                    {{-- <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                            id="kt_menu_6155ac804a1c2">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bolder">Choose actions:</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="">
                                                <!--begin::Item-->
                                                <a href="/proyek/export-proyek"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                                </a>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div> --}}
                                    <!--end::Wrapper-->


                                </div>
                                <!--end::Actions-->
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Header Contract-->
                    <div id="agreed-survey" class="px-12" style="margin-bottom: 2rem;">
                        <div class="card card-flush h-lg-100 p-12" id="kt_contacts_main">
                            <!--begin::Row-->
                            <p>
                            <h4>To Whom It May Concern</h4> 
                            <br><br> 
                            Mr/Mrs : <h4>{{  $csi->Struktur->nama_struktur }}</h4> 
                            <br> 
                            Position : <h4>{{ $csi->Struktur->jabatan_struktur }}</h4>
                            <br> 
                            Project : <h4>{{ $proyek->nama_proyek }}</h4>
                            <br><br>
                            <h4>We kindly ask for your assistance in measuring the customer satisfaction index for the project which we are currently running. As part of our commitment to provide high-quality services, we believe it is essential to evaluate and understand our valuable customers level of satisfaction.</h4>
                            <i>Kami mohon bantuan Anda dalam mengukur indeks kepuasan pelanggan untuk proyek yang sedang kami jalankan. Sebagai bagian dari komitmen kami untuk menyediakan layanan berkualitas tinggi, kami percaya penting untuk mengevaluasi dan memahami tingkat kepuasan pelanggan kami yang berharga.</i>
                            <br>
                            <br>
                            <h4>We hope that you are willing to provide information to help us with this project. We are looking forward to receiving your response and help to improve our customer satisfaction.</h4>
                            <i>Kami harap Anda bersedia memberikan informasi untuk membantu kami dalam proyek ini. Kami berharap dapat menerima tanggapan Anda dan membantu meningkatkan kepuasan pelanggan kami.</i>
                            <br><br>
                            Best regards, 
                            <br> 
                            SvP Strategic Marketing & Transformation</p>
                            <!--end::Row-->
                            <hr> <br>
                            <!--begin::Col-->
                            <div class="d-flex align-items-center">
                                <div class="text-end me-5">
                                    <input onclick="surveyButton(this)" class="form-check-input" type="checkbox" value="" id="persetujuan" name="persetujuan" {{ empty($csi->jawaban) ? '' : 'checked disabled' }}>
                                </div>
                                <div class="text-dark text-start">
                                    <span class=""><h4>Agreed to fill out the survey given, signed below</h4><i>Setuju untuk mengisi survei yang diberikan, saya yang bertanda tangan dibawah ini</i> </span>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <div id="spinner-survey" style="display: none"  class="card card-flush p-12 mx-12">
                        <span class="spinner-border text-primary text-center" role="status"></span>
                    </div>
                    <!--begin::Container-->
                    <script>
                        function surveyButton(e) {
                            // console.log(e.value,e.checked);     
                            if (e.checked == true) {
                                setTimeout( function() {
                                    document.getElementById("spinner-survey").style.display = "";
                                    document.getElementById('agreed-survey').style.display = "none";
                                    setTimeout( function() {
                                        document.getElementById("spinner-survey").style.display = "none";
                                        document.getElementById('body-survey').style.display = "";
                                        document.getElementById('head-survey').style.display = "";
                                    }, 1000);
                                }, 500);
                            } else {
                                document.getElementById('head-survey').style.display = "none";
                                document.getElementById('body-survey').style.display = "none";
                            }                       
                        }
                    </script>

                    <!--begin::Header Contract-->
                    <div id="head-survey" class="px-12 mb-6" style="margin-bottom: 2rem; display: none">
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">
                            <!--begin::Row-->
                            <div class="d-flex align-items-center py-2">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Name-->
                                    <div class="d-flex align-items-center">
                                        <div class="col-5 text-end me-5">
                                            <span class="">Nama Proyek : </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b class="fs-6">{{ $proyek->nama_proyek }}</b>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>
                                <!--end-begin::Col-->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="col-3 text-end me-5">
                                            <span class="">Pengguna Jasa : </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b class="fs-6">{{ $customer->name }}</b>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="d-flex align-items-center py-2">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Name-->
                                    <div class="d-flex align-items-center">
                                        <div class="col-5 text-end me-5">
                                            <span class="">Tanggal Submit : </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b class="fs-6">{{ $csi->Struktur->created_at ?? '' }}</b>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>
                                <!--end-begin::Col-->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="col-3 text-end me-5">
                                            <span class="">Nama Responden : </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b class="fs-6">{{  $csi->Struktur->nama_struktur }}</b>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="d-flex align-items-center py-2">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Name-->
                                    <div class="d-flex align-items-center">
                                        <div class="col-5 text-end me-5">
                                            <span class="">Jabatan : </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b class="fs-6">{{ $csi->Struktur->jabatan_struktur }}</b>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>
                                <!--end-begin::Col-->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="col-3 text-end me-5">
                                            <span class="">Agreed : </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <input class="form-check-input" type="checkbox" value="" id="persetujuan" name="persetujuan" checked disabled>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                    </div>
                    <!--begin::Container-->
                    
                    <!--begin::Card "style edited"-->
                    <div class="card mx-12" id="body-survey" style="position: relative; overflow: hidden; display: {{ empty($csi->jawaban) ? 'none' : '' }}" >

                        <!--begin::Card header-->
                        {{-- <div class="card-header border-0 py-1">
                            <!--begin::Card title-->
                            <div class="card-title">
                            </div>
                            <!--begin::Card title-->
                        </div> --}}
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-12">
                            {{-- {{ dd($csi, Auth::user()->id, $csi->id_struktur_organisasi) }} --}}
                        
                        @if (!$viewer)
                        <form action="/csi/customer-survey-save" method="post">
                        @csrf
                        @endif
                            <!--begin::Survey-->
                            <ol class="decimal_type" style="list-style-type: decimal;margin-left:1cmundefined;">
                                <li><strong><span style="line-height:150%;font-size:12px;">Customer Loyalty</span></strong>
                                    <ol class="decimal_type" style="list-style-type: decimal;">
                                        <li>
                                            <span style="line-height:150%;font-size:12px;"><b>My company does not plan to use construction services other than PT Wijaya Karya.</b></span><br>
                                            <span style="line-height:150%;font-size:12px;"><i>(Perusahaan saya tidak berencana untuk menggunakan jasa konstruksi selain PT Wijaya Karya)</i></span>
                                        </li>
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                            <span class="col-3 text-end">
                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Setuju</p>
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_1" value="1" {{ !empty($jawaban["answer_1_1"]) && $jawaban["answer_1_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>1
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_1" value="2" {{ !empty($jawaban["answer_1_1"]) && $jawaban["answer_1_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>2
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_1" value="3" {{ !empty($jawaban["answer_1_1"]) && $jawaban["answer_1_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>3
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_1" value="4" {{ !empty($jawaban["answer_1_1"]) && $jawaban["answer_1_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>4
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_1" value="5" {{ !empty($jawaban["answer_1_1"]) && $jawaban["answer_1_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>5
                                            </span>
                                            <span class="col-2 text-start">
                                                <p style="line-height:150%;font-size:12px;">Sangat Setuju</p>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                        <li>
                                            <span style="line-height:150%;font-size:12px;"><b>For various needs of my company's construction services, I will always use PT Wijaya Karya.</b></span><br>
                                            <span style="line-height:150%;font-size:12px;"><i>(Untuk berbagai kebutuhan jasa konstruksi perusahaan saya akan selalu menggunakan PT Wijaya Karya.)</i></span>
                                        </li>
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                            <span class="col-3 text-end">
                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Setuju</p>
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_2" value="1" {{ !empty($jawaban["answer_1_2"]) && $jawaban["answer_1_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>1
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_2" value="2" {{ !empty($jawaban["answer_1_2"]) && $jawaban["answer_1_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>2
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_2" value="3" {{ !empty($jawaban["answer_1_2"]) && $jawaban["answer_1_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>3
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_2" value="4" {{ !empty($jawaban["answer_1_2"]) && $jawaban["answer_1_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>4
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_1_2" value="5" {{ !empty($jawaban["answer_1_2"]) && $jawaban["answer_1_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>5
                                            </span>
                                            <span class="col-2 text-start">
                                                <p style="line-height:150%;font-size:12px;">Sangat Setuju</p>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                    </ol>
                                </li>
                            {{-- </ol>
                            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:1.0cm;text-align:left;text-indent:0cm;line-height:150%;font-size:16px;font-family:"Arial",sans-serif;'><strong><span style="font-size:12px;line-height:150%;">&nbsp;</span></strong></p>
                            <ol class="decimal_type" style="list-style-type: undefined;margin-left:2cmundefined;"> --}}
                                <br>
                                <li><strong><span style="line-height:150%;font-size:12px;">Customer Satisfaction Index</span></strong>
                                    <ol class="decimal_type" style="list-style-type: undefined;">
                                        <li><span style="line-height:150%;font-size:12px;">Mesikpun harga yang ditawarkan lebih mahal dibandingkan dengan perusahaan jasa konstruksi lain, perusahaan saya akan tetap menggunakan jasa PT Wijaya Karya.</span>
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                            <span class="col-3 text-end">
                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Setuju</p>
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_1" value="1" {{ !empty($jawaban["answer_2_1"]) && $jawaban["answer_2_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>1
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_1" value="2" {{ !empty($jawaban["answer_2_1"]) && $jawaban["answer_2_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>2
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_1" value="3" {{ !empty($jawaban["answer_2_1"]) && $jawaban["answer_2_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>3
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_1" value="4" {{ !empty($jawaban["answer_2_1"]) && $jawaban["answer_2_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>4
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_1" value="5" {{ !empty($jawaban["answer_2_1"]) && $jawaban["answer_2_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>5
                                            </span>
                                            <span class="col-2 text-start">
                                                <p style="line-height:150%;font-size:12px;">Sangat Setuju</p>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                        <li><span style="line-height:150%;font-size:12px;">Saya percaya 100% kepada PT Wijaya Karya.</span></li>
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                            <span class="col-3 text-end">
                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Setuju</p>
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_2" value="1" {{ !empty($jawaban["answer_2_2"]) && $jawaban["answer_2_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>1
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_2" value="2" {{ !empty($jawaban["answer_2_2"]) && $jawaban["answer_2_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>2
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_2" value="3" {{ !empty($jawaban["answer_2_2"]) && $jawaban["answer_2_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>3
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_2" value="4" {{ !empty($jawaban["answer_2_2"]) && $jawaban["answer_2_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>4
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_2" value="5" {{ !empty($jawaban["answer_2_2"]) && $jawaban["answer_2_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>5
                                            </span>
                                            <span class="col-2 text-start">
                                                <p style="line-height:150%;font-size:12px;">Sangat Setuju</p>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                        <li><span style="line-height:150%;font-size:12px;">Saya sangat merekomendasikan jasa konstruksi PT Wijaya Karya kepada perusahaan lain.</span></li>
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                            <span class="col-3 text-end">
                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Setuju</p>
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_3" value="1" {{ !empty($jawaban["answer_2_3"]) && $jawaban["answer_2_3"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>1
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_3" value="2" {{ !empty($jawaban["answer_2_3"]) && $jawaban["answer_2_3"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>2
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_3" value="3" {{ !empty($jawaban["answer_2_3"]) && $jawaban["answer_2_3"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>3
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_3" value="4" {{ !empty($jawaban["answer_2_3"]) && $jawaban["answer_2_3"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>4
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_2_3" value="5" {{ !empty($jawaban["answer_2_3"]) && $jawaban["answer_2_3"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>5
                                            </span>
                                            <span class="col-2 text-start">
                                                <p style="line-height:150%;font-size:12px;">Sangat Setuju</p>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                        </li>
                                    </ol>
                                </li>
                            {{-- </ol>
                            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:35.45pt;text-align:left;text-indent:0cm;line-height:150%;font-size:16px;font-family:"Arial",sans-serif;'><strong><span style="font-size:12px;line-height:150%;">&nbsp;</span></strong></p>
                            <ol class="decimal_type" style="list-style-type: undefined;margin-left:1cmundefined;"> --}}
                                <br>
                                <li><strong><span style="line-height:150%;font-size:12px;">Net Promoter Score</span></strong>
                                    <ol class="decimal_type" style="list-style-type: undefined;">
                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Bersediakah anda merekomendasikan produk/jasa Perusahaan Jasa PT Wijaya Karya kepada orang/perusahaan lain?</span></li>
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                            <span class="col-3 text-end">
                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Setuju</p>
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_3" value="1" {{ !empty($jawaban["answer_3"]) && $jawaban["answer_3"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>1
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_3" value="2" {{ !empty($jawaban["answer_3"]) && $jawaban["answer_3"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>2
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_3" value="3" {{ !empty($jawaban["answer_3"]) && $jawaban["answer_3"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>3
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_3" value="4" {{ !empty($jawaban["answer_3"]) && $jawaban["answer_3"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>4
                                            </span>
                                            <span class="col p-0 pt-1 text-center">
                                                <input required type="radio" name="answer_3" value="5" {{ !empty($jawaban["answer_3"]) && $jawaban["answer_3"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <br>5
                                            </span>
                                            <span class="col-2 text-start">
                                                <p style="line-height:150%;font-size:12px;">Sangat Setuju</p>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                    </ol>
                                </li>
                            {{-- </ol>
                            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:49.65pt;text-align:left;text-indent:0cm;line-height:150%;font-size:16px;font-family:"Arial",sans-serif;'><strong><span style="font-size:12px;line-height:150%;">&nbsp;</span></strong></p>
                            <ol class="decimal_type" style="list-style-type: undefined;margin-left:1cmundefined;"> --}}
                                <br>
                                <li><strong><span style="line-height:150%;font-size:12px;">Mutu Produk, Mutu Waktu, Safety Health &amp; Environment (SHE) dan Pengamanan</span></strong>
                                    <ol class="decimal_type" style="list-style-type: undefined;">
                                        <li><strong><span style="line-height:150%;font-size:12px;">Mutu Produk</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap mutu hasil pekerjaan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_1" value="1" {{ !empty($jawaban["answer_4_1_1"]) && $jawaban["answer_4_1_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_1" value="2" {{ !empty($jawaban["answer_4_1_1"]) && $jawaban["answer_4_1_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_1" value="3" {{ !empty($jawaban["answer_4_1_1"]) && $jawaban["answer_4_1_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_1" value="4" {{ !empty($jawaban["answer_4_1_1"]) && $jawaban["answer_4_1_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_1" value="5" {{ !empty($jawaban["answer_4_1_1"]) && $jawaban["answer_4_1_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah mutu hasil pekerjaan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_2" value="1" {{ !empty($jawaban["answer_4_1_2"]) && $jawaban["answer_4_1_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_2" value="2" {{ !empty($jawaban["answer_4_1_2"]) && $jawaban["answer_4_1_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_2" value="3" {{ !empty($jawaban["answer_4_1_2"]) && $jawaban["answer_4_1_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_2" value="4" {{ !empty($jawaban["answer_4_1_2"]) && $jawaban["answer_4_1_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_1_2" value="5" {{ !empty($jawaban["answer_4_1_2"]) && $jawaban["answer_4_1_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                        <br>
                                        <li><strong><span style="line-height:150%;font-size:12px;">Mutu Waktu</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap pencapaian progress pekerjaan dalam penyelesaian proyek terhadap waktu yang telah ditetapkan.</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_1" value="1" {{ !empty($jawaban["answer_4_2_1"]) && $jawaban["answer_4_2_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_1" value="2" {{ !empty($jawaban["answer_4_2_1"]) && $jawaban["answer_4_2_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_1" value="3" {{ !empty($jawaban["answer_4_2_1"]) && $jawaban["answer_4_2_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_1" value="4" {{ !empty($jawaban["answer_4_2_1"]) && $jawaban["answer_4_2_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_1" value="5" {{ !empty($jawaban["answer_4_2_1"]) && $jawaban["answer_4_2_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah pencapaian progress pekerjaan dalam penyelesaian proyek terhadap waktu yang telah ditetapkan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_2" value="1" {{ !empty($jawaban["answer_4_2_2"]) && $jawaban["answer_4_2_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_2" value="2" {{ !empty($jawaban["answer_4_2_2"]) && $jawaban["answer_4_2_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_2" value="3" {{ !empty($jawaban["answer_4_2_2"]) && $jawaban["answer_4_2_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_2" value="4" {{ !empty($jawaban["answer_4_2_2"]) && $jawaban["answer_4_2_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_4_2_2" value="5" {{ !empty($jawaban["answer_4_2_2"]) && $jawaban["answer_4_2_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                        <br>
                                        <li><strong><span style="line-height:150%;font-size:12px;">Safety Health &amp; Environment (SHE)</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal:</span>
                                                    <ul class="decimal_type" style="list-style-type: disc;">
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Kelengkapan alat-alat pelindung diri dan kepatuhan pekerja dalam pemakaian alat-alat pelindung diri.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_1" value="1" {{ !empty($jawaban["answer_4_3_1"]) && $jawaban["answer_4_3_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_1" value="2" {{ !empty($jawaban["answer_4_3_1"]) && $jawaban["answer_4_3_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_1" value="3" {{ !empty($jawaban["answer_4_3_1"]) && $jawaban["answer_4_3_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_1" value="4" {{ !empty($jawaban["answer_4_3_1"]) && $jawaban["answer_4_3_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_1" value="5" {{ !empty($jawaban["answer_4_3_1"]) && $jawaban["answer_4_3_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ul>
                                                </li>
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal:</span>
                                                    <ul style="list-style-type: disc;">
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Kelengkapan alat-alat pelindung diri dan kepatuhan pekerja dalam pemakaian alat-alat pelindung diri.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_2" value="1" {{ !empty($jawaban["answer_4_3_2"]) && $jawaban["answer_4_3_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_2" value="2" {{ !empty($jawaban["answer_4_3_2"]) && $jawaban["answer_4_3_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_2" value="3" {{ !empty($jawaban["answer_4_3_2"]) && $jawaban["answer_4_3_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_2" value="4" {{ !empty($jawaban["answer_4_3_2"]) && $jawaban["answer_4_3_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_3_2" value="5" {{ !empty($jawaban["answer_4_3_2"]) && $jawaban["answer_4_3_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ul>
                                                </li>
                                            </ol>
                                        </li>
                                        <br>
                                        <li><strong><span style="line-height:150%;font-size:12px;">Pengamanan</span></strong><span style="line-height:150%;font-size:12px;">&nbsp;</span>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><strong><span style="line-height:150%;font-size:12px;">Pemasangan rambu-rambu SHE.</span></strong>
                                                    <ul class="decimal_type" style="list-style-type: disc;">
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:;font-size:9.0pt;line-height:;;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">emasangan rambu-rambu SHE.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_a" value="1" {{ !empty($jawaban["answer_4_4_1_a"]) && $jawaban["answer_4_4_1_a"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_a" value="2" {{ !empty($jawaban["answer_4_4_1_a"]) && $jawaban["answer_4_4_1_a"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_a" value="3" {{ !empty($jawaban["answer_4_4_1_a"]) && $jawaban["answer_4_4_1_a"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_a" value="4" {{ !empty($jawaban["answer_4_4_1_a"]) && $jawaban["answer_4_4_1_a"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_a" value="5" {{ !empty($jawaban["answer_4_4_1_a"]) && $jawaban["answer_4_4_1_a"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:150%;font-size:9.0pt;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">emasangan rambu-rambu SHE.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_b" value="1" {{ !empty($jawaban["answer_4_4_1_b"]) && $jawaban["answer_4_4_1_b"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_b" value="2" {{ !empty($jawaban["answer_4_4_1_b"]) && $jawaban["answer_4_4_1_b"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_b" value="3" {{ !empty($jawaban["answer_4_4_1_b"]) && $jawaban["answer_4_4_1_b"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_b" value="4" {{ !empty($jawaban["answer_4_4_1_b"]) && $jawaban["answer_4_4_1_b"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_1_b" value="5" {{ !empty($jawaban["answer_4_4_1_b"]) && $jawaban["answer_4_4_1_b"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ul>
                                                </li>
                                                <li><strong><span style="line-height:150%;font-size:12px;">Pengelolaan sampah dan limbah B3.</span></strong>
                                                    <ul class="decimal_type" style="list-style-type: disc;">
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:;font-size:9.0pt;line-height:;;">&nbsp;pengelolaan sampah dan limbah B3</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_a" value="1" {{ !empty($jawaban["answer_4_4_2_a"]) && $jawaban["answer_4_4_2_a"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_a" value="2" {{ !empty($jawaban["answer_4_4_2_a"]) && $jawaban["answer_4_4_2_a"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_a" value="3" {{ !empty($jawaban["answer_4_4_2_a"]) && $jawaban["answer_4_4_2_a"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_a" value="4" {{ !empty($jawaban["answer_4_4_2_a"]) && $jawaban["answer_4_4_2_a"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_a" value="5" {{ !empty($jawaban["answer_4_4_2_a"]) && $jawaban["answer_4_4_2_a"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:150%;font-size:9.0pt;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">engelolaan sampah dan limbah B3</span><span style="line-height:150%;font-size:12px;">.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_b" value="1" {{ !empty($jawaban["answer_4_4_2_b"]) && $jawaban["answer_4_4_2_b"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_b" value="2" {{ !empty($jawaban["answer_4_4_2_b"]) && $jawaban["answer_4_4_2_b"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_b" value="3" {{ !empty($jawaban["answer_4_4_2_b"]) && $jawaban["answer_4_4_2_b"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_b" value="4" {{ !empty($jawaban["answer_4_4_2_b"]) && $jawaban["answer_4_4_2_b"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_2_b" value="5" {{ !empty($jawaban["answer_4_4_2_b"]) && $jawaban["answer_4_4_2_b"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ul>
                                                </li>
                                                <li><strong><span style="line-height:150%;font-size:12px;">Penanganan keluhan masyarakat yang berhubungan dengan lingkungan sekitar proyek.</span></strong>
                                                    <ul class="decimal_type" style="list-style-type: disc;">
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:;font-size:9.0pt;line-height:;;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">enanganan keluhan masyarakat yang berhubungan dengan lingkungan sekitar proyek.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_a" value="1" {{ !empty($jawaban["answer_4_4_3_a"]) && $jawaban["answer_4_4_3_a"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_a" value="2" {{ !empty($jawaban["answer_4_4_3_a"]) && $jawaban["answer_4_4_3_a"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_a" value="3" {{ !empty($jawaban["answer_4_4_3_a"]) && $jawaban["answer_4_4_3_a"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_a" value="4" {{ !empty($jawaban["answer_4_4_3_a"]) && $jawaban["answer_4_4_3_a"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_a" value="5" {{ !empty($jawaban["answer_4_4_3_a"]) && $jawaban["answer_4_4_3_a"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:150%;font-size:9.0pt;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">enanganan keluhan masyarakat yang berhubungan dengan lingkungan sekitar proyek.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_b" value="1" {{ !empty($jawaban["answer_4_4_3_b"]) && $jawaban["answer_4_4_3_b"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_b" value="2" {{ !empty($jawaban["answer_4_4_3_b"]) && $jawaban["answer_4_4_3_b"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_b" value="3" {{ !empty($jawaban["answer_4_4_3_b"]) && $jawaban["answer_4_4_3_b"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_b" value="4" {{ !empty($jawaban["answer_4_4_3_b"]) && $jawaban["answer_4_4_3_b"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_3_b" value="5" {{ !empty($jawaban["answer_4_4_3_b"]) && $jawaban["answer_4_4_3_b"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ul>
                                                </li>
                                                <li><strong><span style="line-height:150%;font-size:12px;">Pengelolaan pengamanan proyek.</span></strong>
                                                    <ul style="list-style-type: disc;">
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:;font-size:9.0pt;line-height:;;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">engelolaan pengamanan proyek.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_a" value="1" {{ !empty($jawaban["answer_4_4_4_a"]) && $jawaban["answer_4_4_4_a"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_a" value="2" {{ !empty($jawaban["answer_4_4_4_a"]) && $jawaban["answer_4_4_4_a"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_a" value="3" {{ !empty($jawaban["answer_4_4_4_a"]) && $jawaban["answer_4_4_4_a"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_a" value="4" {{ !empty($jawaban["answer_4_4_4_a"]) && $jawaban["answer_4_4_4_a"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_a" value="5" {{ !empty($jawaban["answer_4_4_4_a"]) && $jawaban["answer_4_4_4_a"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                        <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah kinerja pelaksanaan SHE &amp; pengamanan diproyek dalam hal</span><span style="line-height:150%;font-size:9.0pt;">&nbsp;p</span><span style="line-height:150%;font-size:12px;">engelolaan pengamanan proyek.</span></li>
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col-3 text-end">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_b" value="1" {{ !empty($jawaban["answer_4_4_4_b"]) && $jawaban["answer_4_4_4_b"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>1
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_b" value="2" {{ !empty($jawaban["answer_4_4_4_b"]) && $jawaban["answer_4_4_4_b"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>2
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_b" value="3" {{ !empty($jawaban["answer_4_4_4_b"]) && $jawaban["answer_4_4_4_b"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>3
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_b" value="4" {{ !empty($jawaban["answer_4_4_4_b"]) && $jawaban["answer_4_4_4_b"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>4
                                                            </span>
                                                            <span class="col p-0 pt-1 text-center">
                                                                <input required type="radio" name="answer_4_4_4_b" value="5" {{ !empty($jawaban["answer_4_4_4_b"]) && $jawaban["answer_4_4_4_b"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <br>5
                                                            </span>
                                                            <span class="col-2 text-start">
                                                                <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ul>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                            {{-- </ol>
                            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:72.0pt;text-align:left;text-indent:0cm;line-height:150%;font-size:16px;font-family:"Arial",sans-serif;'><strong><span style="font-size:12px;line-height:150%;">&nbsp;</span></strong></p>
                            <ol class="decimal_type" style="list-style-type: undefined;margin-left:1cmundefined;"> --}}
                                <br>
                                <li><strong><span style="line-height:150%;font-size:12px;">Mutu Pelayanan</span></strong>
                                    <ol class="decimal_type" style="list-style-type: undefined;">
                                        <li><strong><span style="line-height:150%;font-size:12px;">Kerjasama, Koordinasi dan Komunikasi antara Tim Manajemen WIKA dengan Konsultan/Owner</span></strong><strong><span style="line-height:150%;">.</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap Kerjasama, Koordinasi dan Komunikasi antara Tim Manajemen WIKA dengan Konsultan/Owner?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_1" value="1" {{ !empty($jawaban["answer_5_1_1"]) && $jawaban["answer_5_1_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_1" value="2" {{ !empty($jawaban["answer_5_1_1"]) && $jawaban["answer_5_1_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_1" value="3" {{ !empty($jawaban["answer_5_1_1"]) && $jawaban["answer_5_1_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_1" value="4" {{ !empty($jawaban["answer_5_1_1"]) && $jawaban["answer_5_1_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_1" value="5" {{ !empty($jawaban["answer_5_1_1"]) && $jawaban["answer_5_1_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah Kerjasama, Koordinasi dan Komunikasi antara Tim Manajemen WIKA dengan Konsultan/Owner?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_2" value="1" {{ !empty($jawaban["answer_5_1_2"]) && $jawaban["answer_5_1_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_2" value="2" {{ !empty($jawaban["answer_5_1_2"]) && $jawaban["answer_5_1_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_2" value="3" {{ !empty($jawaban["answer_5_1_2"]) && $jawaban["answer_5_1_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_2" value="4" {{ !empty($jawaban["answer_5_1_2"]) && $jawaban["answer_5_1_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_1_2" value="5" {{ !empty($jawaban["answer_5_1_2"]) && $jawaban["answer_5_1_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                        <li><strong><span style="line-height:150%;font-size:12px;">R</span></strong><strong><span style="line-height:150%;font-size:12px;">espon dalam penanganan dan penyelesaian permasalahan</span></strong><strong><span style="line-height:150%;font-size:12px;">.</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap respon dalam penanganan dan penyelesaian permasalahan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_1" value="1" {{ !empty($jawaban["answer_5_2_1"]) && $jawaban["answer_5_2_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_1" value="2" {{ !empty($jawaban["answer_5_2_1"]) && $jawaban["answer_5_2_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_1" value="3" {{ !empty($jawaban["answer_5_2_1"]) && $jawaban["answer_5_2_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_1" value="4" {{ !empty($jawaban["answer_5_2_1"]) && $jawaban["answer_5_2_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_1" value="5" {{ !empty($jawaban["answer_5_2_1"]) && $jawaban["answer_5_2_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah respon dalam penanganan dan penyelesaian permasalahan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_2" value="1" {{ !empty($jawaban["answer_5_2_2"]) && $jawaban["answer_5_2_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_2" value="2" {{ !empty($jawaban["answer_5_2_2"]) && $jawaban["answer_5_2_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_2" value="3" {{ !empty($jawaban["answer_5_2_2"]) && $jawaban["answer_5_2_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_2" value="4" {{ !empty($jawaban["answer_5_2_2"]) && $jawaban["answer_5_2_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_2_2" value="5" {{ !empty($jawaban["answer_5_2_2"]) && $jawaban["answer_5_2_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                        <li><strong><span style="line-height:150%;font-size:12px;">K</span></strong><strong><span style="line-height:150%;font-size:12px;">etepatan komitmen yang dijanjikan</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap ketepatan komitmen yang dijanjikan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_1" value="1" {{ !empty($jawaban["answer_5_3_1"]) && $jawaban["answer_5_3_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_1" value="2" {{ !empty($jawaban["answer_5_3_1"]) && $jawaban["answer_5_3_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_1" value="3" {{ !empty($jawaban["answer_5_3_1"]) && $jawaban["answer_5_3_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_1" value="4" {{ !empty($jawaban["answer_5_3_1"]) && $jawaban["answer_5_3_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_1" value="5" {{ !empty($jawaban["answer_5_3_1"]) && $jawaban["answer_5_3_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah ketepatan komitmen yang dijanjikan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_2" value="1" {{ !empty($jawaban["answer_5_3_2"]) && $jawaban["answer_5_3_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_2" value="2" {{ !empty($jawaban["answer_5_3_2"]) && $jawaban["answer_5_3_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_2" value="3" {{ !empty($jawaban["answer_5_3_2"]) && $jawaban["answer_5_3_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_2" value="4" {{ !empty($jawaban["answer_5_3_2"]) && $jawaban["answer_5_3_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_3_2" value="5" {{ !empty($jawaban["answer_5_3_2"]) && $jawaban["answer_5_3_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                        <li><strong><span style="line-height:150%;font-size:12px;">T</span></strong><strong><span style="line-height:150%;font-size:12px;">ertib administrasi (laporan, surat menyurat, dll) yang diterapkan</span></strong><strong><span style="line-height:150%;">.</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap tertib administrasi (laporan, surat menyurat, dll) yang diterapkan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_1" value="1" {{ !empty($jawaban["answer_5_4_1"]) && $jawaban["answer_5_4_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_1" value="2" {{ !empty($jawaban["answer_5_4_1"]) && $jawaban["answer_5_4_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_1" value="3" {{ !empty($jawaban["answer_5_4_1"]) && $jawaban["answer_5_4_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_1" value="4" {{ !empty($jawaban["answer_5_4_1"]) && $jawaban["answer_5_4_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_1" value="5" {{ !empty($jawaban["answer_5_4_1"]) && $jawaban["answer_5_4_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah tertib administrasi (laporan, surat-menyurat, dll) yang diterapkan?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_2" value="1" {{ !empty($jawaban["answer_5_4_2"]) && $jawaban["answer_5_4_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_2" value="2" {{ !empty($jawaban["answer_5_4_2"]) && $jawaban["answer_5_4_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_2" value="3" {{ !empty($jawaban["answer_5_4_2"]) && $jawaban["answer_5_4_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_2" value="4" {{ !empty($jawaban["answer_5_4_2"]) && $jawaban["answer_5_4_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_4_2" value="5" {{ !empty($jawaban["answer_5_4_2"]) && $jawaban["answer_5_4_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                        <li><strong><span style="line-height:150%;font-size:12px;">P</span></strong><strong><span style="line-height:150%;font-size:12px;">rofesionalisme sumber daya manusia WIKA di proyek</span></strong><strong><span style="line-height:;font-size:9.0pt;line-height:;;">.</span></strong>
                                            <ol class="decimal_type" style="list-style-type: undefined;">
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa puaskah anda terhadap profesionalisme sumber daya manusia WIKA di proyek?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Puas</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_1" value="1" {{ !empty($jawaban["answer_5_5_1"]) && $jawaban["answer_5_5_1"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_1" value="2" {{ !empty($jawaban["answer_5_5_1"]) && $jawaban["answer_5_5_1"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_1" value="3" {{ !empty($jawaban["answer_5_5_1"]) && $jawaban["answer_5_5_1"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_1" value="4" {{ !empty($jawaban["answer_5_5_1"]) && $jawaban["answer_5_5_1"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_1" value="5" {{ !empty($jawaban["answer_5_5_1"]) && $jawaban["answer_5_5_1"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Puas</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                                <li><span style="line-height:;font-size:9.0pt;line-height:;;">Seberapa pentingkah profesionalisme sumber daya manusia WIKA di proyek?</span></li>
                                                <!--begin::Answer-->
                                                <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                    <span class="col-3 text-end">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Tidak Penting</p>
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_2" value="1" {{ !empty($jawaban["answer_5_5_2"]) && $jawaban["answer_5_5_2"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>1
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_2" value="2" {{ !empty($jawaban["answer_5_5_2"]) && $jawaban["answer_5_5_2"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>2
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_2" value="3" {{ !empty($jawaban["answer_5_5_2"]) && $jawaban["answer_5_5_2"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>3
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_2" value="4" {{ !empty($jawaban["answer_5_5_2"]) && $jawaban["answer_5_5_2"] == '4' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>4
                                                    </span>
                                                    <span class="col p-0 pt-1 text-center">
                                                        <input required type="radio" name="answer_5_5_2" value="5" {{ !empty($jawaban["answer_5_5_2"]) && $jawaban["answer_5_5_2"] == '5' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                        <br>5
                                                    </span>
                                                    <span class="col-2 text-start">
                                                        <p style="line-height:150%;font-size:12px;">Sangat Penting</p>
                                                    </span>
                                                </div>
                                                <!--end::Answer-->
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                            {{-- </ol>
                            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:150%;font-size:16px;font-family:"Arial",sans-serif;'><strong><span style="font-size:12px;line-height:150%;">&nbsp;</span></strong></p>
                            <ol class="decimal_type" style="list-style-type: undefined;margin-left:1cmundefined;"> --}}
                                <br>
                                <li><strong><span style="line-height:150%;font-size:12px;">Komentar/pendapat anda tentang kinerja WIKA jika dibandingkan dengan kontraktor lain.</span></strong>
                                    <ol style="list-style-type: lower-alpha;">
                                        <li><span style="line-height:150%;font-size:12px;">Apabila WIKA dibandingkan dengan (silahkan isi nama kontraktor)</span>
                                            <ol style="list-style-type: lower-roman;">
                                                <li><span style="line-height:150%;font-size:12px;">Mutu Hasil Pekerjaan</span>
                                                    <ol style="list-style-type: decimal;">
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_i"value="1" {{ !empty($jawaban["answer_6_a_i"]) && $jawaban["answer_6_a_i"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">< (lebih buruk)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_i"value="2" {{ !empty($jawaban["answer_6_a_i"]) && $jawaban["answer_6_a_i"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">= (sama)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input  class="" type="radio"name="answer_6_a_i"value="3" {{ !empty($jawaban["answer_6_a_i"]) && $jawaban["answer_6_a_i"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">> (lebih baik)</label>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ol>
                                                </li>
                                                <li><span style="line-height:150%;font-size:12px;">Mutu Waktu</span>
                                                    <ol style="list-style-type: decimal;">
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_ii"value="1" {{ !empty($jawaban["answer_6_a_ii"]) && $jawaban["answer_6_a_ii"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">< (lebih buruk)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_ii"value="2" {{ !empty($jawaban["answer_6_a_ii"]) && $jawaban["answer_6_a_ii"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">= (sama)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input  class="" type="radio"name="answer_6_a_ii"value="3" {{ !empty($jawaban["answer_6_a_ii"]) && $jawaban["answer_6_a_ii"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">> (lebih baik)</label>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ol>
                                                </li>
                                                <li><span style="line-height:150%;font-size:12px;">Mutu SHE &amp; Pengamanan</span>
                                                    <ol style="list-style-type: decimal;">
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_iii"value="1" {{ !empty($jawaban["answer_6_a_iii"]) && $jawaban["answer_6_a_iii"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">< (lebih buruk)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_iii"value="2" {{ !empty($jawaban["answer_6_a_iii"]) && $jawaban["answer_6_a_iii"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">= (sama)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input  class="" type="radio"name="answer_6_a_iii"value="3" {{ !empty($jawaban["answer_6_a_iii"]) && $jawaban["answer_6_a_iii"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">> (lebih baik)</label>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ol>
                                                </li>
                                                <li><span style="line-height:150%;font-size:12px;">Mutu Pelayanan</span>
                                                    <ol style="list-style-type: decimal;">
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_iv"value="1" {{ !empty($jawaban["answer_6_a_iv"]) && $jawaban["answer_6_a_iv"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">< (lebih buruk)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_iv"value="2" {{ !empty($jawaban["answer_6_a_iv"]) && $jawaban["answer_6_a_iv"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">= (sama)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input  class="" type="radio"name="answer_6_a_iv"value="3" {{ !empty($jawaban["answer_6_a_iv"]) && $jawaban["answer_6_a_iv"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">> (lebih baik)</label>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ol>
                                                </li>
                                                <li><span style="line-height:150%;font-size:12px;">Sumber Daya Alat</span>
                                                    <ol style="list-style-type: decimal;">
                                                        <!--begin::Answer-->
                                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3">
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_v"value="1" {{ !empty($jawaban["answer_6_a_v"]) && $jawaban["answer_6_a_v"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">< (lebih buruk)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input class="" type="radio"name="answer_6_a_v"value="2" {{ !empty($jawaban["answer_6_a_v"]) && $jawaban["answer_6_a_v"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">= (sama)</label>
                                                            </span>
                                                            <span class="col text-center">
                                                                <input  class="" type="radio"name="answer_6_a_v"value="3" {{ !empty($jawaban["answer_6_a_v"]) && $jawaban["answer_6_a_v"] == '3' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                                <label class="mb-3">> (lebih baik)</label>
                                                            </span>
                                                        </div>
                                                        <!--end::Answer-->
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                                <li><strong><span style="line-height:150%;font-size:12px;">Rekomendasi untuk proyek yang akan datang? (</span></strong><strong><span style="line-height:150%;font-size:12px;">Ya/Tidak</span></strong><strong><span style="line-height:150%;font-size:12px;">)</span></strong>
                                    <ol class="decimal_type" style="list-style-type: undefined;">
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3 ms-3">
                                            <span class="col text-center">
                                                <input class="" type="radio"name="answer_7"value="1" {{ !empty($jawaban["answer_7"]) && $jawaban["answer_7"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <label class="mb-3">Tidak</label>
                                            </span>
                                            <span class="col text-center">
                                                <input  class="" type="radio"name="answer_7"value="2" {{ !empty($jawaban["answer_7"]) && $jawaban["answer_7"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <label class="mb-3">Ya</label>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                    </ol>
                                </li>
                                <li><strong><span style="line-height:150%;font-size:12px;">Apakah anda akan merekomendasikan WIKA pada rekan/teman bisnis anda?</span></strong>
                                    <ol class="decimal_type" style="list-style-type: undefined;">
                                        <!--begin::Answer-->
                                        <div class="row w-75 bg-secondary bg-opacity-50 rounded p-4 pb-0 my-3 ms-3">
                                            <span class="col text-center">
                                                <input class="" type="radio"name="answer_8"value="1" {{ !empty($jawaban["answer_8"]) && $jawaban["answer_8"] == '1' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <label class="mb-3">Tidak</label>
                                            </span>
                                            <span class="col text-center">
                                                <input  class="" type="radio"name="answer_8"value="2" {{ !empty($jawaban["answer_8"]) && $jawaban["answer_8"] == '2' ? 'checked' : ''  }} {{ $viewer ? 'disabled' : '' }}>
                                                <label class="mb-3">Ya</label>
                                            </span>
                                        </div>
                                        <!--end::Answer-->
                                    </ol>
                                </li>
                                <li><strong><span style="line-height:150%;font-size:12px;">Kritik/saran?&nbsp;</span></strong></li>
                            </ol>
                            <div class="form-group ms-16 mw-850px">
                                <textarea id="kritik-saran" name="kritik-saran" class="form-control form-control-solid" rows="4">{{ $jawaban["kritik-saran"] ?? '-' }}</textarea>
                            </div>
                            <!--end::Survey-->
                            <!--begin::Table-->
                            {{-- <p>
                                {{ $csi }}
                            </p> --}}
                            <!--end::Table-->
                            <!--begin::Table-->
                            {{-- <p>
                                {{ $customer }}
                            </p> --}}
                            <!--end::Table-->
                            <!--begin::Table-->
                            {{-- <p>
                                {{ $proyek }}
                            </p> --}}
                            <!--end::Table-->
                            <br>
                        @if (!$viewer)
                            <button type="submit" class="ms-16 btn btn-primary btn-sm">Submit Survey</button>
                        </form>
                        @endif
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
    <!--end :: CONTENT-->
    
    <!--begin :: Modal Welcome-->
    <div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subscribe our Newsletter</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
				<p>Subscribe to our mailing list to get the latest updates straight in your inbox.</p>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Address">
                    </div>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!--end :: Modal Welcome-->


    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="black" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->



    <!--end::Main-->
    
    <!--begin::Javascript-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    
    {{-- <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                initComplete: function(settings, json) {
                    const btns = document.querySelectorAll(".dt-buttons .dt-button");
                    btns.forEach(btn => {
                        btn.classList.add("btn");
                        btn.classList.add("btn-active-primary");
                    });
                    // const btnsCollection = document.querySelectorAll("div.dt-button-collection button.dt-button.active");
                    // console.log(btnsCollection);
                    // btnsCollection.forEach(btn => {
                    //     btn.classList.add("btn");
                    //     btn.classList.add("btn-active-primary");
                    // });
                },
                // dom: 'lBfrtip',
                dom: 'Bfrtip',
                stateSave : true,
                scrollX : true,
                pageLength : 25,
                // iDisplayLength : 25,
                // lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 5 ]
                        }
                    },
                    'colvis'
                ]
            } );
    } );
    </script> --}}
    <!--end::Javascript-->

</body>
<!--end::Body-->

@include('sweetalert::alert')

</html>