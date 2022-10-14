{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}


<style>
    /* th, td { white-space: nowrap; } */
    div.dataTables_wrapper {
        width: 100%;
        /* height: 100%; */
        /* min-height: 1000px;  */
        margin: 0 auto;
    }

    .content-table {
        position: relative;
        max-height: 450px !important;
        overflow: scroll;
    }

    .content-table table {
        border-collapse: separate;
    }

    #header {
        position: sticky;
        position: --webkit-sticky;
        background-color: white;
        z-index: 255;
        top: 0;
    }

    #header th {
        border-bottom: 1px solid rgb(225, 225, 225);
    }

    #header tr #proyek-title {
        position: sticky;
        position: --webkit-sticky;
        background-color: white;
        z-index: 260;
        top: 0;
        left: 0;
    }

    #footer {
        position: sticky;
        position: --webkit-sticky;
        background-color: white;
        z-index: 255;
        bottom: 0;
    }

    /* .table>:not(caption)>*>* {
    padding: 0.5rem 0.5rem;
    background-color: var(--bs-table-bg);
    border-bottom-width: 0px;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    } */
</style>

{{-- Begin::Title --}}
@section('title', 'Request Approval History')
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
                @include('template.header')
                <!--end::Header-->

                <!--begin::Form-->
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf


                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Toolbar-->
                        <div style="height:90px" class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 row">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Approval History
                                    </h1>
                                    <div class="row">
                                        <div class="col">
                                            <ul
                                                class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                                <!--begin:::Tab item Forecast Bulanan-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast"
                                                        style="font-size:14px;">Forecast Eksternal
                                                        Bulanan</a>
                                                </li>
                                                <!--end:::Tab item Forecast Bulanan-->

                                                <!--begin:::Tab item Forecast Internal-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast-internal"
                                                        style="font-size:14px;">Forecast Bulanan
                                                        Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast Internal-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        href="/forecast-kumulatif-eksternal"
                                                        style="font-size:14px;">Forecast Kumulatif Eksternal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        href="/forecast-kumulatif-eksternal-internal"
                                                        style="font-size:14px;">Forecast Kumulatif Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab Request Aprroval History-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active"
                                                        href="/request-approval-history" style="font-size:14px;">Request
                                                        Approval History</a>
                                                </li>
                                                <!--end:::Tab Request Aprroval History-->
                                            </ul>
                                        </div>
                                    </div>
                                    <!--begin::Title-->
                                </div>
                                <!--begin::Page title-->
                            </div>
                            <!--begin::Container-->
                        </div>
                        <!--begin::Toolbar-->

                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="w-100"
                                style="overflow: auto; background-color:white; white-space: nowrap;">
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="">

                                    <!--begin::All Content-->
                                    <div class="col-xl-15">

                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100"
                                            style="max-height: 70vh; overflow-y: scroll; scroll-behavior: smooth;"
                                            id="kt_contacts_main">

                                            <!--begin::Card body-->
                                            <div class="card-body mt-0" style="background-color: white;">
                                                @forelse ($historyForecast as $dop => $historyUnitKerjas)
                                                    <!--begin::Card Content-->
                                                    <div class="card-content mb-5">
                                                        <div class="position-sticky start-0 bg-white border shadow-sm p-5 mb-3 text-center"
                                                            style="z-index: 99; top:5px;">
                                                            <h4 class="h4">{{ $dop }}</h4>
                                                        </div>
                                                        @foreach ($historyUnitKerjas as $unit_kerja => $unit_kerja_history)
                                                            <div class="row mb-5">
                                                                <div class="col">
                                                                    <div
                                                                        class="card border shadow-sm bg-body border-dashed">
                                                                        <div class="card-body">
                                                                            <div
                                                                                class="row d-flex align-items-center justify-content-between w-100">
                                                                                <div class="col-9 text-wrap">
                                                                                    <div
                                                                                        class="d-flex align-items-center mb-3">
                                                                                        <div class="col-6">
                                                                                            <div class="row">
                                                                                                <div class="col text-end">
                                                                                                    <span>Unit Kerja:
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="col">
                                                                                                    <span><b>{{ $unit_kerja }}</b></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <div
                                                                                                        class="d-flex align-items-center">
                                                                                                        <div class="col-4">
                                                                                                            <span>Nilai
                                                                                                                Forecast:
                                                                                                            </span>
                                                                                                        </div>
                                                                                                        <div class="col">
                                                                                                            <span><b>Rp.
                                                                                                                    <span
                                                                                                                        class="text-end">{{ number_format($unit_kerja_history->nilai_forecast, 0, '.', '.') }}</span></b></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <div
                                                                                                        class="d-flex align-items-center">
                                                                                                        <div class="col-4">
                                                                                                            <span>Nilai
                                                                                                                Realisasi:
                                                                                                            </span>
                                                                                                        </div>
                                                                                                        <div class="col">
                                                                                                            <span><b>Rp.
                                                                                                                    <span
                                                                                                                        class="text-end">{{ number_format($unit_kerja_history->realisasi_forecast, 0, '.', '.') }}</span></b></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <div
                                                                                                        class="d-flex align-items-center">
                                                                                                        <div class="col-4">
                                                                                                            <span>Nilai
                                                                                                                RKAP:
                                                                                                            </span>
                                                                                                        </div>
                                                                                                        <div class="col">
                                                                                                            <span><b>Rp.
                                                                                                                    <span
                                                                                                                        class="text-end">{{ number_format($unit_kerja_history->rkap_forecast, 0, '.', '.') }}</span></b></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    @if (Auth::user()->check_administrator || str_contains(Auth::user()->name, "PIC"))
                                                                                        @if ($unit_kerja_history->is_approved_1 == "t")
                                                                                            <div
                                                                                                class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-success text-white disabled"
                                                                                                    style="background-color: rgb(17, 179, 17)">Approved</button>
                                                                                                @if ($unit_kerja_history->is_request_unlock == "f")
                                                                                                    <form action=""></form>
                                                                                                    <form action="/history/unlock"class="mt-4" method="POST">
                                                                                                        @csrf
                                                                                                        <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                        <button type="submit"
                                                                                                            class="btn btn-sm btn-active-primary text-white"
                                                                                                            style="background-color:#008CB4;">Unlock Forecast</button>
                                                                                                    </form>
                                                                                                @endif
                                                                                            </div>
                                                                                        @elseif($unit_kerja_history->is_approved_1 == "f")
                                                                                            <div
                                                                                                class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-danger text-white disabled">Approval ditolak</button>
                                                                                            </div>
                                                                                        @else
                                                                                            <div
                                                                                                class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                <button type="button"
                                                                                                    onclick="confirmAction(this, '{{ $unit_kerja }}', true)"
                                                                                                    class="btn btn-sm btn-active-primary text-white"
                                                                                                    style="background-color:#008CB4;">Approve</button>
                                                                                                <button type="button"
                                                                                                    onclick="confirmAction(this, '{{ $unit_kerja }}', false)"
                                                                                                    class="btn btn-sm btn-light btn-active-danger">Cancel</button>
                                                                                            </div>
                                                                                        @endif
                                                                                    @else
                                                                                        @if ($unit_kerja_history->is_approved_1 == "t")
                                                                                            <div
                                                                                                class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-success text-white disabled"
                                                                                                    style="background-color: rgb(17, 179, 17)">Approved</button>
                                                                                                <form action=""></form>
                                                                                                @if($unit_kerja_history->is_request_unlock == "f")
                                                                                                    <button type="button"
                                                                                                        class="btn btn-sm btn-active-primary text-white disabled ms-7"
                                                                                                        style="background-color:#008CB4;">Menunggu Approval Unlock...</button>
                                                                                                @elseif($unit_kerja_history->is_request_unlock == "t")
                                                                                                    <form action="/forecast/set-unlock"class="mt-4" method="POST">
                                                                                                        @csrf
                                                                                                        <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                        <button type="submit"
                                                                                                        onclick="confirmDeleteHistory(this); return false"
                                                                                                        class="btn btn-sm btn-danger text-white"
                                                                                                        style="background-color:#008CB4;">Hapus History</button>
                                                                                                    </form>
                                                                                                @else
                                                                                                    <form action="/history/request-unlock"class="mt-4" method="POST">
                                                                                                        @csrf
                                                                                                        <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                        <button type="submit"
                                                                                                            class="btn btn-sm btn-active-primary text-white"
                                                                                                            style="background-color:#008CB4;">Request Unlock</button>
                                                                                                    </form>
                                                                                                @endif 
                                                                                            </div>
                                                                                        @elseif($unit_kerja_history->is_approved_1 == "f")
                                                                                            <div
                                                                                                class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-danger text-white disabled">Approval ditolak</button>
                                                                                                <form action=""></form>
                                                                                                <form action="/forecast/set-unlock"class="mt-4" method="POST">
                                                                                                    @csrf
                                                                                                    <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                    <button type="submit"
                                                                                                    class="btn btn-sm btn-active-primary text-white"
                                                                                                    style="background-color:#008CB4;">Hapus History</button>
                                                                                                </form>
                                                                                            </div>
                                                                                        @else
                                                                                            <div
                                                                                                class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                <button type="button"
                                                                                                    class="btn btn-sm btn-active-primary text-white disabled"
                                                                                                    style="background-color:#008CB4;">Menunggu untuk approval...</button>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                    <!--begin::Card Content-->
                                                @empty
                                                    <div class="row">
                                                        <div class="col text-center">Data tidak ditemukan!</div>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                    <!--end::All Content-->
                                </div>
                                <!--end::Contacts App- Edit Contact-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->
                    </div>
                    <!--begin::Content-->
                </form>
                <!--begin::Form-->
            </div>
            <!--begin::Wrapper-->
        </div>
        <!--begin::Page-->
    </div>
    <!--begin::Root-->
@endsection

{{-- begin:: JS script --}}
@section('js-script')
    <script>
        function confirmAction(e, unitKerja, isApproved) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                html: "Aksi ini tidak bisa <b>dikembalikan</b>!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then(async (result) => {
                const formData = new FormData();
                formData.append("is_approved", Number(isApproved));
                formData.append("unit_kerja", unitKerja);
                formData.append("_token", "{{ csrf_token() }}");
                if (result.isConfirmed) {
                    const setLockRes = await fetch("/forecast/set-lock/unit-kerja", {
                        method: "POST",
                        header: {
                            "content-type": "application/json",
                        },
                        body: formData,
                    }).then(res => res.json());
                    if(isApproved) {
                        e.parentElement.innerHTML = `<button type="button"
                                                        class="btn btn-sm btn-success text-white disabled"
                                                        style="background-color: rgb(17, 179, 17)">Approved</button>`;
                        Swal.fire({
                            title: "",
                            html: setLockRes.msg,
                            icon: setLockRes.status.toLowerCase(),
                            toast: true,
                            confirmButtonColor: "#008CB4",
                            timer: 1500,
                            timerProgressBar: true,
                            position: 'top-end',
                        });
                    } else {
                        e.parentElement.innerHTML = `
                        <button type="button"
                        class="btn btn-sm btn-danger text-white disabled">Approval ditolak</button>`;
                        Swal.fire({
                            title: "",
                            html: `<b>${unitKerja}</b>, approval ditolak`,
                            icon: setLockRes.status.toLowerCase(),
                            toast: true,
                            confirmButtonColor: "#008CB4",
                            timer: 1500,
                            timerProgressBar: true,
                            position: 'top-end',
                        });
                    }
                    return true;
                }
                return false;
            });
        }

        function confirmDeleteHistory(e) {
            const form = e.parentElement;
            Swal.fire({
                title: 'Forecast ini sudah di Lock. Apakah anda yakin?',
                html: "Aksi ini tidak bisa <b>dikembalikan</b>!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if(result.isConfirmed) {
                    form.submit();
                }
                return false;
            });
        }
    </script>
@endsection
{{-- End:: JS script --}}
