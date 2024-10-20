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
                        @php
                            $title = str_replace('-', '', $jenis_claim);
                        @endphp
                        <h1 class="d-flex align-items-center fs-3 my-1">{{ $title }}
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                        <!--begin::Button-->
                        <a href="/claim-management" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                            id="customer_new_close" style="background-color:#f1f1f1; margin-left:10px;">
                            Close</a>
                        <!--end::Button-->

                    </div>
                    <!--end::Actions-->
                </div>

                <!--end::Container-->
            </div>
            <!--end::Toolbar-->

            <div class="row">
                <div class="col d-flex justify-content-center">
                    @if (Session::has('success'))
                        {{-- begin::Alert --}}
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="#54d2b6" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                        </svg>
                        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                aria-label="Danger:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div class="text-success">
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                        </div>
                        {{-- end::Alert --}}
                    @endif
                </div>
            </div>


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

                                <!--begin::Card body-->
                                <div class="card-body pt-5">

                                    {{-- <!--begin:::Tabs Navigasi-->
                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                href="#kt_user_view_claim" style="font-size:14px;">Claim</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item Anti Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                data-bs-toggle="tab" href="#kt_user_view_overview_potensial"
                                                style="font-size:14px;">Anti Claim</a>
                                        </li>
                                        <!--end:::Tab item Anti Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                data-bs-toggle="tab" href="#kt_user_view_overview_asuransi"
                                                style="font-size:14px;">Claim Asuransi</a>
                                        </li>
                                        <!--end:::Tab item -->
                                    </ul>
<!--end:::Tabs Navigasi--> --}}

                                    <!--begin:::Tab isi content  -->
                                    <div class="tab-content" id="myTabContent">
                                        <!--begin::Title-->
                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                            {{ $proyek->kode_proyek }} - {{ $proyek->nama_proyek }}
                                            <span class="gap-3">
                                                <a href="#" onclick="exportToExcel(this, '#kt_proyek_table')" class="">(Klik di sini untuk Export ke Excel)</a>
                                            </span>
                                        </h3>
                                        <br>
                                        <!--end::Title-->

                                        <!--begin:::Tab Jenis Claim-->
                                        <div class="tab-pane fade show active" id="kt_user_view_claim" role="tabpanel">
                                            <!--begin::Table Claim-->
                                            <table class="table table-row-dashed fs-6 gy-2"
                                                id="kt_proyek_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        {{-- <th class="min-w-auto">Uraian Perubahan</th>
                                                        <th class="min-w-auto">Tanggal Perubahan</th>
                                                        <th class="min-w-auto">No Proposal Klaim</th>
                                                        <th class="min-w-auto">Tanggal Pengajuan</th>
                                                        <th class="min-w-auto">Biaya Pengajuan</th>
                                                        <th class="min-w-auto">Waktu Pengajuan</th>
                                                        <th class="min-w-auto">Status</th> --}}
                                                        {{-- <th class="min-w-auto">Action</th> --}}
                                                        {{-- <th class=""><center>Action</center></th> --}}

                                                        {{-- <th class="min-w-auto">Jenis Perubahan</th> --}}
                                                        <th class="min-w-auto">Tanggal Perubahan</th>
                                                        <th class="min-w-auto">Uraian Perubahan</th>
                                                        {{-- <th class="min-w-auto">Jenis Dokumen</th>
                                                        <th class="min-w-auto">Nomor Dokumen</th> --}}
                                                        <th class="min-w-auto">No Proposal Klaim</th>
                                                        <th class="min-w-auto">Tanggal Pengajuan</th>
                                                        <th class="min-w-auto">Biaya Pengajuan</th>
                                                        <th class="min-w-auto">Waktu Pengajuan</th>
                                                        <th class="min-w-auto">Status</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @foreach ($proyekClaims as $claim)
                                                        <tr>
                                                            <!--begin::Name Proyek-->
                                                            <td>
                                                                {{ Carbon\Carbon::create($claim->tanggal_perubahan)->translatedFormat("d F Y") }}
                                                            </td>
                                                            <!--end::Name Proyek-->
                                                            <!--begin::Name-->
                                                            <td>
                                                                <a href="/contract-management/view/{{$claim->id_contract}}/perubahan-kontrak/{{$claim->id_perubahan_kontrak}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">
                                                                    {{ $claim->uraian_perubahan }}
                                                                </a>
                                                            </td>
                                                            <!--end::Name-->
                                                            <!--begin::Unit Kerja-->
                                                            <td>
                                                                {{ $claim->proposal_klaim }}
                                                            </td>
                                                            <!--end::Unit Kerja-->
                                                            <!--begin::Unit Kerja-->
                                                            <td>
                                                                {{ Carbon\Carbon::create($claim->tanggal_pengajuan)->translatedFormat("d F Y") }}
                                                            </td>
                                                            <!--end::Unit Kerja-->
                                                            <!--begin::Unit Kerja-->
                                                            <td>
                                                                {{ number_format($claim->biaya_pengajuan ?? 0, 0, '.', '.') }}
                                                            </td>
                                                            <!--end::Unit Kerja-->
                                                            <!--begin::Unit Kerja-->
                                                            <td>
                                                                {{ Carbon\Carbon::create($claim->waktu_pengajuan)->translatedFormat("d F Y") }}
                                                            </td>
                                                            <!--end::Unit Kerja-->
                                                            <!--begin::Unit Kerja-->
                                                            @php
                                                                $stage = "";
                                                                $class_name = "";
                                                                if ($claim->is_dispute) {
                                                                    $stage = "Dispute";
                                                                    $class_name = "badge fs-8 badge-light-danger";
                                                                } else {
                                                                    switch ($claim->stage) {
                                                                        case 1:
                                                                            $stage = "Draft";
                                                                            $class_name = "badge fs-8 badge-light-primary";
                                                                            break;
                                                                        case 2:
                                                                            $stage = "Diajukan";
                                                                            $class_name = "badge fs-8 badge-light-primary";
                                                                            break;
                                                                        case 3:
                                                                            $stage = "Revisi";
                                                                            $class_name = "badge fs-8 badge-light-primary";
                                                                            break;
                                                                        case 4:
                                                                            $stage = "Negoisasi";
                                                                            $class_name = "badge fs-8 badge-light-primary";
                                                                            break;
                                                                        case 5:
                                                                            $stage = "Diterima";
                                                                            $class_name = "badge fs-8 badge-light-success";
                                                                            break;
                                                                        case 6:
                                                                            $stage = "Ditolak";
                                                                            $class_name = "badge fs-8 badge-light-danger";
                                                                            break;
                                                                    }
                                                                }
                                                            @endphp
                                                            <td>
                                                                <small class="{{$class_name}}">
                                                                    {{ $stage }}
                                                                </small>
                                                            </td>
                                                            <!--begin::Action=-->
                                                            {{-- <td>
                                                                <form action="/claim-management/delete"
                                                                    style="height: 1.5rem" method="POST">
                                                                    @csrf
                                                                    <button type="submit" name="delete-claim"
                                                                        class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder">Delete</button>
                                                                    <input type="hidden"
                                                                        value="{{ $claim->id_claim }}" name="id-claim">
                                                                </form>
                                                            </td> --}}
                                                            <!--end::Action=-->
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!--end::Table -->
                                        </div>
                                        <!--end:::Tab Jenis Claim-->


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





                        <!--begin::Modal-->
                        {{-- begin::Calendar --}}
                    </div>
                    <!--end::Modal - Calendar Start -->
                    {{-- end::Calendar --}}
                    <!--end::Modal-->


                </div>
                <!--end::Container-->
            </div>
            <!--end::Post-->


        </div>
        <!--end::Content-->
    </div>
@endsection
{{-- end:: content --}}

@section('js-script')

    <script>
        let month = 1;
        let year = 2020;
        let date = -1;
        let monthFix = 1;
        let yearFix = 2020;
        let dateFix = -1;

        // Begin Function Calendar Start
        const months = document.querySelector(`#approval-date #calendar__month`);
        const years = document.querySelector(`#approval-date #calendar__year`);
        months.addEventListener("change", elt => {
            month = elt.target.value;
            if (month == 2) {
                let html = ``;
                for (let i = 0; i < 29; i += 1) {
                    if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;
            } else {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;

                    } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;

            }
            setDateClickable("#approval-date");
        });
        years.addEventListener("change", elt => {
            year = elt.target.value;
            if (yearEnd == year) {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;

            } else {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;


            }
            setDateClickable("#approval-date");
        });

        setDateClickable("#approval-date");

        function setDateClickable(rootElt) {
            const dates = document.querySelectorAll(`${rootElt} .calendar__body .calendar__dates .calendar__date`);
            dates.forEach(elt => {
                elt.addEventListener("click", e => {
                    dates.forEach(d => {
                        if (d.classList.contains("calendar__date--selected")) {
                            d.classList.remove("calendar__date--selected");
                            d.classList.remove("calendar__date--range-end");
                            d.classList.remove("calendar__date--first-date");
                        }
                    });

                    if (elt.classList.contains("calendar__date--selected")) {
                        elt.classList.remove("calendar__date--selected");
                        elt.classList.remove("calendar__date--range-end");
                        elt.classList.remove("calendar__date--first-date");
                    } else {
                        if (rootElt.toString().match("end")) {
                            dateEnd = Number(elt.firstElementChild.innerText);
                            const dateStart = document.querySelectorAll(
                                `#approval-date .calendar__body .calendar__dates .calendar__date`);
                            dateStart.forEach((d, i) => {
                                if (i + 1 == dateEndFix) {
                                    d.classList.add("calendar__date--range-start");
                                } else {
                                    d.classList.remove("calendar__date--range-start");
                                }
                            });
                        } else {
                            date = Number(elt.firstElementChild.innerText);
                            const dateEnd = document.querySelectorAll(
                                `#end-date .calendar__body .calendar__dates .calendar__date`);
                            dateEnd.forEach((d, i) => {
                                if (i + 1 <= date && monthEndFix < month) {
                                    // d.classList.add("calendar__date--range-start");
                                    d.classList.add("calendar__date--grey");
                                } else {
                                    d.classList.remove("calendar__date--range-start");
                                }
                            });
                        }
                        elt.classList.add("calendar__date--selected");
                        elt.classList.add("calendar__date--range-end");
                        elt.classList.add("calendar__date--first-date");
                    }
                });
            });
        }

        const setCalendarStartBtn = document.querySelector("#set-calendar-start");
        setCalendarStartBtn.addEventListener("click", e => {
            document.querySelector("#approve-date").setAttribute("value",
                `${year}-${month.toString().length < 2 ? month.toString().padStart(2, "0") : month}-${date.toString().length < 2 ? date.toString().padStart(2, "0") : date}`
            );
            dateFix = date;
            monthFix = month;
            yearFix = year;
            let html = ``;
            if (monthEnd == 2) {
                let html = ``;
                for (let i = 0; i < 29; i += 1) {
                    if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                        html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;
            } else {
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
            }
            const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;
            setDateClickable("#end-date");
        })
        // End Function Calendar Start

        // begin reformatNumber
        function reformatNumber(elt) {
            const valueFormatted = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
            elt.value = valueFormatted;
        }
        // end reformatNumber
    </script>

<script>
    function exportToExcel(e, tableElt) {
        // console.log(e.parentElement);
        document.querySelector(`${tableElt}_wrapper .buttons-excel`).click();
        return;
    }
</script>

<script>
    window.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            const exportBtn = document.querySelectorAll(".buttons-excel");
            exportBtn.forEach(item => {
                item.style.display = "none";
            }); 
        }, 1000);
    });
</script>

<script src="/datatables/jquery.dataTables.min.js"></script>
<script src="/datatables/dataTables.buttons.min.js"></script>
<script src="/datatables/buttons.html5.min.js"></script>
<script src="/datatables/buttons.colVis.min.js"></script>
<script src="/datatables/jszip.min.js"></script>
<script src="/datatables/pdfmake.min.js"></script>
<script src="/datatables/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        $('#kt_proyek_table').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Perubahan Kontrak {{ $title }}'
                },
                   
                ]
        } );
    });
</script>
@endsection
