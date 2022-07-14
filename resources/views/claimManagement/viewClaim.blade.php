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
        @extends('template.header')
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Claim
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                    <!--begin::Button-->
                    <a href="/claim-management" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" id="customer_new_close"
                    style="background-color:#f1f1f1; margin-left:10px;">
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
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
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
                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">{{ $proyek->kode_proyek }} - {{ $proyek->nama_proyek }}  
                                        </h3>
                                        <br>
                                        <!--end::Title-->

<!--begin:::Tab Jenis Claim-->
                                        <div class="tab-pane fade show active" id="kt_user_view_claim" role="tabpanel">
                                            <!--begin::Table Claim-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                id="kt_proyek_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-auto">ID Claim</th>
                                                        <th class="min-w-auto">Kode Proyek</th>
                                                        <th class="min-w-auto">Nama Proyek</th>
                                                        <th class="min-w-auto">Unit Kerja</th>
                                                        <th class="min-w-auto">Jenis Claim</th>
                                                        <th class="min-w-auto">Approval Status</th>
                                                        <th class="min-w-auto">PIC</th>
                                                        <th class="min-w-auto">Action</th>
                                                        {{-- <th class=""><center>Action</center></th> --}}
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @foreach ($proyekClaims as $claim)
                                                        @if ($claim->jenis_claim == 'Claim')
                                                            <tr class="align-middle">

                                                                <!--begin::Name=-->
                                                                <td>
                                                                    <a class="text-hover-primary text-gray-500"
                                                                        href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}</a>
                                                                </td>
                                                                <!--end::Name=-->
                                                                <!--begin::Name=-->
                                                                <td>
                                                                    {{ $claim->id_contract }}
                                                                </td>
                                                                <!--end::Name=-->
                                                                <!--begin::Email=-->
                                                                <td>
                                                                    {{ $proyek->kode_proyek }}
                                                                </td>
                                                                <!--end::Email=-->
                                                                <!--begin::Company=-->
                                                                <td>
                                                                    {{ $proyek->nama_proyek }}
                                                                    {{-- {{ $proyek->kode_proyek }} --}}
                                                                </td>
                                                                <!--end::Company=-->
                                                                <!--begin::Action=-->
                                                                <td>
                                                                    {{ $claim->jenis_claim }}
                                                                </td>
                                                                <!--end::Action=-->
                                                                <!--begin::Approval-->
                                                                <td>
                                                                    @switch($claim->stages)
                                                                        @case(1) On Progress
                                                                            @break
                                                                        @case(2) Disetujui
                                                                            @break
                                                                        @case(3) Ditolak
                                                                            @break
                                                                        @case(4) cancel
                                                                            @break
                                                                        @default
                                                                    @endswitch
                                                                </td>
                                                                <!--end::Approval-->
                                                                <!--begin::PIC=-->
                                                                <td>
                                                                    {{ $claim->pic }}
                                                                </td>
                                                                <!--end::PIC=-->
                                                                
                                                                <!--begin::Action=-->
                                                                <td>
                                                                    <form action="/claim-management/delete" style="height: 1.5rem" method="POST">
                                                                        @csrf
                                                                        <button type="submit" name="delete-claim" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" >Delete</button>
                                                                        <input type="hidden" value="{{$claim->id_claim }}" name="id-claim">
                                                                    </form>
                                                                </td>
                                                                <!--end::Action=-->
                                                            </tr>
                                                            @endif
                                                    @endforeach
                                                    @foreach ($proyekClaims as $claim)
                                                        @if ($claim->jenis_claim == 'Claim Asuransi')
                                                            <tr>
                                                                <!--begin::Name=-->
                                                                <td>
                                                                    <a class="text-hover-primary text-gray-500"
                                                                        href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}</a>
                                                                </td>
                                                                <!--end::Name=-->
                                                                <!--begin::Name=-->
                                                                <td>
                                                                    {{ $claim->id_contract }}
                                                                </td>
                                                                <!--end::Name=-->
                                                                <!--begin::Email=-->
                                                                <td>
                                                                    {{ $proyek->kode_proyek }}
                                                                </td>
                                                                <!--end::Email=-->
                                                                <!--begin::Company=-->
                                                                <td>
                                                                    {{ $proyek->nama_proyek }}
                                                                    {{-- {{ $proyek->kode_proyek }} --}}
                                                                </td>
                                                                <!--end::Company=-->
                                                                <!--begin::Action=-->
                                                                <td>
                                                                    {{ $claim->jenis_claim }}
                                                                </td>
                                                                <!--end::Action=-->
                                                                <!--begin::Approval-->
                                                                <td>
                                                                    @switch($claim->stages)
                                                                        @case(1) On Progress
                                                                            @break
                                                                        @case(2) Disetujui
                                                                            @break
                                                                        @case(3) Ditolak
                                                                            @break
                                                                        @case(4) cancel
                                                                            @break
                                                                        @default
                                                                    @endswitch
                                                                </td>
                                                                <!--end::Approval-->
                                                                <!--begin::PIC=-->
                                                                <td>
                                                                    {{ $claim->pic }}
                                                                </td>
                                                                <!--end::PIC=-->

                                                                <!--begin::Action=-->
                                                                <td>
                                                                    <form action="/claim-management/delete" style="height: 1.5rem" method="POST">
                                                                        @csrf
                                                                        <button type="submit" name="delete-claim" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" >Delete</button>
                                                                        <input type="hidden" value="{{$claim->id_claim }}" name="id-claim">
                                                                    </form>
                                                                </td>
                                                                <!--end::Action=-->
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($proyekClaims as $claim)
                                                        @if ($claim->jenis_claim == 'Anti Claim')
                                                            <tr>
                                                                <!--begin::Name=-->
                                                                <td>
                                                                    <a class="text-hover-primary text-gray-500"
                                                                        href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}</a>
                                                                </td>
                                                                <!--end::Name=-->
                                                                <!--begin::Name=-->
                                                                <td>
                                                                    {{ $claim->id_contract }}
                                                                </td>
                                                                <!--end::Name=-->
                                                                <!--begin::Email=-->
                                                                <td>
                                                                    {{ $proyek->kode_proyek }}
                                                                </td>
                                                                <!--end::Email=-->
                                                                <!--begin::Company=-->
                                                                <td>
                                                                    {{ $proyek->nama_proyek }}
                                                                    {{-- {{ $proyek->kode_proyek }} --}}
                                                                </td>
                                                                <!--end::Company=-->
                                                                <!--begin::Action=-->
                                                                <td>
                                                                    {{ $claim->jenis_claim }}
                                                                </td>
                                                                <!--end::Action=-->
                                                                <!--begin::Approval-->
                                                                <td>
                                                                    @switch($claim->stages)
                                                                        @case(1) On Progress
                                                                            @break
                                                                        @case(2) Disetujui
                                                                            @break
                                                                        @case(3) Ditolak
                                                                            @break
                                                                        @case(4) cancel
                                                                            @break
                                                                        @default
                                                                    @endswitch
                                                                </td>
                                                                <!--end::Approval-->
                                                                <!--begin::PIC=-->
                                                                <td>
                                                                    {{ $claim->pic }}
                                                                </td>
                                                                <!--end::PIC=-->

                                                                <!--begin::Action=-->
                                                                <td>
                                                                    <form action="/claim-management/delete" style="height: 1.5rem" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$claim->id_claim }}" name="id-claim">
                                                                        <button type="submit" name="delete-claim" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" >Delete</button>
                                                                    </form>
                                                                </td>
                                                                <!--end::Action=-->
                                                            </tr>
                                                        @endif
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
                        <!--begin::Modal - Calendar Start -->
                        <div class="modal fade" id="kt_modal_calendar" data-bs-backdrop="static" tabindex="-1"
                            aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-300px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header">
                                        <!--begin::Modal title-->
                                        <h2>Approval Date</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="black" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body py-lg-6 px-lg-6">

                                        <!--begin:: Calendar-->
                                        <div class="fv-row mb-5">
                                            <div class="calendar" id="approval-date">
                                                <div class="calendar__opts">
                                                    <select name="calendar__month" id="calendar__month">
                                                        <option value="1" selected>Jan</option>
                                                        <option value="2">Feb</option>
                                                        <option value="3">Mar</option>
                                                        <option value="4">Apr</option>
                                                        <option value="5">May</option>
                                                        <option value="6">Jun</option>
                                                        <option value="7">Jul</option>
                                                        <option value="8">Aug</option>
                                                        <option value="9">Sep</option>
                                                        <option value="10">Oct</option>
                                                        <option value="11">Nov</option>
                                                        <option value="12">Dec</option>
                                                    </select>

                                                    <select name="calendar__year" id="calendar__year">
                                                        <option>2017</option>
                                                        <option>2018</option>
                                                        <option>2019</option>
                                                        <option selected>2020</option>
                                                        <option>2021</option>
                                                        <option>2022</option>
                                                    </select>
                                                </div>

                                                <div class="calendar__body">
                                                    {{-- <div class="calendar__days">
                                <div>M</div>
                                <div>T</div>
                                <div>W</div>
                                <div>T</div>
                                <div>F</div>
                                <div>S</div>
                                <div>S</div>
                                </div> --}}

                                                    <div class="calendar__dates">
                                                        {{-- <div class="calendar__date calendar__date--grey"><span>27</span></div>
                                    <div class="calendar__date calendar__date--grey"><span>28</span></div>
                                    <div class="calendar__date calendar__date--grey"><span>29</span></div>
                                    <div class="calendar__date calendar__date--grey"><span>30</span></div> --}}
                                                        <div class="calendar__date"><span>1</span></div>
                                                        <div class="calendar__date"><span>2</span></div>
                                                        <div class="calendar__date"><span>3</span></div>
                                                        <div class="calendar__date"><span>4</span></div>
                                                        <div class="calendar__date"><span>5</span></div>
                                                        <div class="calendar__date"><span>6</span></div>
                                                        <div class="calendar__date"><span>7</span></div>
                                                        <div class="calendar__date"><span>8</span></div>
                                                        <div class="calendar__date"><span>9</span></div>
                                                        <div class="calendar__date"><span>10</span></div>
                                                        <div class="calendar__date"><span>11</span></div>
                                                        <div class="calendar__date"><span>12</span></div>
                                                        <div class="calendar__date"><span>13</span></div>
                                                        <div class="calendar__date"><span>14</span></div>
                                                        <div class="calendar__date"><span>15</span></div>
                                                        <div class="calendar__date">
                                                            <span>16</span>
                                                        </div>
                                                        <div class="calendar__date">
                                                            <span>17</span>
                                                        </div>
                                                        <div class="calendar__date">
                                                            <span>18</span>
                                                        </div>
                                                        <div class="calendar__date"><span>19</span></div>
                                                        <div class="calendar__date"><span>20</span></div>
                                                        <div class="calendar__date">
                                                            <span>21</span>
                                                        </div>
                                                        <div class="calendar__date"><span>22</span></div>
                                                        <div class="calendar__date"><span>23</span></div>
                                                        <div class="calendar__date"><span>24</span></div>
                                                        <div class="calendar__date"><span>25</span></div>
                                                        <div class="calendar__date"><span>26</span></div>
                                                        <div class="calendar__date"><span>27</span></div>
                                                        <div class="calendar__date"><span>28</span></div>
                                                        <div class="calendar__date"><span>29</span></div>
                                                        <div class="calendar__date"><span>30</span></div>
                                                        <div class="calendar__date"><span>31</span></div>
                                                    </div>
                                                </div>

                                                <div class="calendar__buttons">
                                                    <button class="btn btn-sm fw-normal btn-primary"
                                                        style="background: #f3f6f9;color:black;" data-bs-dismiss="modal"
                                                        id="cancel-date-btn-start">Back</button>

                                                    <button class="btn btn-sm fw-normal btn-primary"
                                                        data-bs-dismiss="modal"
                                                        style="background-color: #008cb4;color: white;"
                                                        id="set-calendar-start">Apply</button>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Calendar-->

                                    </div>
                                    <!--end::Input group-->

                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
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

@endsection
