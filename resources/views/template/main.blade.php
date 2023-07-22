<!DOCTYPE html>

<html lang="en">

<!--begin::Head-->

<head>
    <base href="">
    <title>@yield('title')</title>

    {{-- <link rel="shortcut icon" href="{{ asset('/media/logos/Icon-CCM.png') }}" /> --}}
    {{-- <link rel="icon" type="image/x-icon" href="public/media/logos/Icon-Sunny.png"> --}}
    <link rel="icon" type="image/x-icon" href="/assets/media/logos/icon-sunny.png?v=2" />
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
    {{-- <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap-icons.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- end::Bootstrap CSS -->

    <!-- begin::Froala CSS -->
    {{-- <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' /> --}}
    <link href='{{ asset('/froala/froala_editor.pkgd.min.css') }}' rel='stylesheet'
        type='text/css' />
    <!-- end::Froala CSS -->

    <!-- begin::DataTables -->
    <link rel="stylesheet" href="datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatables/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="datatables/buttons.dataTables.min.css">    
    <!-- end::DataTables -->
    
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
        /* @media (min-width: 992px) {
            [data-kt-aside-minimize=on] .aside {
                width: 50px !important;
                transition: width 0.3s ease;
            }
        } */
        
        .fr-wrapper div:not(.fr-element.fr-view):nth-child(1) {
            display: none;
        }
        select[readonly].select2-hidden-accessible + .select2-container {
            pointer-events: none;
            touch-action: none;
        }
        table thead tr th{
            background-color: #0DB0D9 !important;
            color: white !important;
            padding: 5px !important;
        }
        table tbody tr td{
            padding: 5px !important;
        }

        table, th, td, tr {
            border: 0.5px solid #ACADBA !important;
        }
        th a {
            color: white !important;
        }
        .fa.fa-sort {
            color: white !important;
        }
    </style>
    {{-- end:: Disable Native Date Browser --}}
</head>
<!--end::Head-->


<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    @include('template.sidebar')

    <!--begin:: HEADER-->
    {{-- @yield('header') --}}
    <!--end:: HEADER-->
    <!--begin:: CONTENT-->
    @yield('content')
    <!--end :: CONTENT-->


    <!--start::Modal - Calendar -->
    <div class="modal fade" id="kt_modal_calendar" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-300px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" style="padding: 15px">
                    <!--begin::Modal title-->
                    <h2>Pilih Tanggal</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-6" style="padding: 10px">

                    <!--begin:: Calendar-->
                    @php
                        $mytime = Carbon\Carbon::now()->translatedFormat("Y-F-d");
                        $year = (int) date("Y") ;
                        $day = (int) date("d");
                        // $year = 2030 ;
                    @endphp
                    <div class="calendar w-auto" style="padding: 0px" id="start-date">
                        <div class="calendar__opts">
                            <select class="rounded-2" onchange="monthCalendar(this)" name="calendar__month" id="calendar__month">
                                <option value="1"{{ str_contains($mytime, 'Jan') ? 'selected' : '' }}>Jan</option>
                                <option value="2"{{ str_contains($mytime, 'Feb') ? 'selected' : '' }}>Feb</option>
                                <option value="3"{{ str_contains($mytime, 'Mar') ? 'selected' : '' }}>Mar</option>
                                <option value="4"{{ str_contains($mytime, 'Apr') ? 'selected' : '' }}>Apr</option>
                                <option value="5"{{ str_contains($mytime, 'Mei') ? 'selected' : '' }}>May</option>
                                <option value="6"{{ str_contains($mytime, 'Jun') ? 'selected' : '' }}>Jun</option>
                                <option value="7"{{ str_contains($mytime, 'Jul') ? 'selected' : '' }}>Jul</option>
                                <option value="8"{{ str_contains($mytime, 'Agu') ? 'selected' : '' }}>Ags</option>
                                <option value="9"{{ str_contains($mytime, 'Sep') ? 'selected' : '' }}>Sep</option>
                                <option value="10"{{ str_contains($mytime, 'Okt') ? 'selected' : '' }}>Oct</option>
                                <option value="11"{{ str_contains($mytime, 'Nov') ? 'selected' : '' }}>Nov</option>
                                <option value="12"{{ str_contains($mytime, 'Des') ? 'selected' : '' }}>Dec</option>
                            </select>
                            
                            <select class="rounded-2" name="calendar__year" id="calendar__year">
                                @if (str_contains(Request::path(), "customer/view"))
                                @for ($i = $year-70; $i < $year+10; $i++ )
                                <option {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                                @else
                                @for ($i = $year-3; $i < $year+10; $i++ )
                                <option {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                                @endif
                            </select>
                        </div>

                        <div class="calendar__body">
                            <div class="calendar__dates" style="padding: 0px">
                                <div class="calendar__date {{ $day == 1 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>1</span></div>
                                <div class="calendar__date {{ $day == 2 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>2</span></div>
                                <div class="calendar__date {{ $day == 3 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>3</span></div>
                                <div class="calendar__date {{ $day == 4 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>4</span></div>
                                <div class="calendar__date {{ $day == 5 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>5</span></div>
                                <div class="calendar__date {{ $day == 6 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>6</span></div>
                                <div class="calendar__date {{ $day == 7 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>7</span></div>
                                <div class="calendar__date {{ $day == 8 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>8</span></div>
                                <div class="calendar__date {{ $day == 9 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>9</span></div>
                                <div class="calendar__date {{ $day == 10 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>10</span></div>
                                <div class="calendar__date {{ $day == 11 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>11</span></div>
                                <div class="calendar__date {{ $day == 12 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>12</span></div>
                                <div class="calendar__date {{ $day == 13 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>13</span></div>
                                <div class="calendar__date {{ $day == 14 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>14</span></div>
                                <div class="calendar__date {{ $day == 15 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>15</span></div>
                                <div class="calendar__date {{ $day == 16 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>16</span></div>
                                <div class="calendar__date {{ $day == 17 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>17</span></div>
                                <div class="calendar__date {{ $day == 18 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>18</span></div>
                                <div class="calendar__date {{ $day == 19 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>19</span></div>
                                <div class="calendar__date {{ $day == 20 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>20</span></div>
                                <div class="calendar__date {{ $day == 21 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>21</span></div>
                                <div class="calendar__date {{ $day == 22 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>22</span></div>
                                <div class="calendar__date {{ $day == 23 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>23</span></div>
                                <div class="calendar__date {{ $day == 24 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>24</span></div>
                                <div class="calendar__date {{ $day == 25 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>25</span></div>
                                <div class="calendar__date {{ $day == 26 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>26</span></div>
                                <div class="calendar__date {{ $day == 27 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>27</span></div>
                                <div class="calendar__date {{ $day == 28 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>28</span></div>
                                @php
                                    $is_leap_year = (bool) date("L");
                                @endphp
                                @if (str_contains($mytime, 'Feb'))
                                    @if ($is_leap_year)
                                        <div id="tgl-29" class="calendar__date {{ $day == 29 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>29</span></div>
                                    @endif
                                <div id="tgl-30" style="display: none" class="calendar__date {{ $day == 30 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>30</span></div>
                                <div id="tgl-31" style="display: none" class="calendar__date {{ $day == 31 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>31</span></div>
                                @elseif (str_contains($mytime, 'Apr') || str_contains($mytime, 'Jun') || str_contains($mytime, 'Sep') || str_contains($mytime, 'Nov'))
                                <div id="tgl-29" class="calendar__date {{ $day == 29 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>29</span></div>
                                <div id="tgl-30" class="calendar__date {{ $day == 30 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>30</span></div>
                                <div id="tgl-31" style="display: none" class="calendar__date {{ $day == 31 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>31</span></div>
                                @else
                                <div id="tgl-29" class="calendar__date {{ $day == 29 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>29</span></div>
                                <div id="tgl-30" class="calendar__date {{ $day == 30 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>30</span></div>
                                <div id="tgl-31" class="calendar__date {{ $day == 31 ? 'calendar__date--selected calendar__date--range-end calendar__date--first-date' : '' }}"><span>31</span></div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    <!--end::Calendar-->
                    
                </div>
                <!--end::Input group-->
                <div class="modal-footer" style="padding: 10px">
                    {{-- <div class="calendar__buttons"> --}}
                    {{-- <button class="btn btn-sm fw-normal btn-active-primary" data-bs-dismiss="modal" id="cancel-date-btn-start">Back</button> --}}
                    <button class="btn btn-sm fw-normal btn-active-primary text-white" onclick="setCalendar()"  style="background-color: #008cb4" data-bs-dismiss="modal" id="set-calendar-start">Apply</button>
                </div>
                
            </div>
            <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Calendar -->

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
    <script>
        var hostUrl = "../";
    </script>


    <script src="{{ asset('/js/app.js') }}"></script>
    {{-- begin::Pusher --}}
    <script>
        let userSocketID = "";
        // window.Echo.channel("notification.password.reset").listen("NotificationPasswordReset", (data) => {
        //     userSocketID = window.Echo.socketId();
        //     let isNotifExist = "";
        //     if (data.id_notification != "") {
        //         isNotifExist = document.querySelector(`#item-${data.id_notification}`);
        //     }
        //     const notificationCounter = document.querySelector("#notification-counter");
        //     const mainNotifContent = document.querySelector("#main-content-notif");
        //     const isAdministrator = Number("{{ auth()->user()->check_administrator ?? 0 }}");
        //     const idUser = Number("{{ auth()->user()->id ?? 0 }}");
        //     // const idNotification = data.id_notification;
        //     const dataDate = new Date(data.timestamp.date);
        //     const nowDate = new Date();
        //     const diff = Math.abs(dataDate - nowDate);
        //     let time = "";

        //     if (diff < 1000) {
        //         time = `now`;
        //     } else if (diff % 1000 == 0) {
        //         time = `${diff} sec`;
        //     }

        //     if (isNotifExist == "" || isNotifExist == null) {

        //         if (isAdministrator == 1 && data.to_user.id == idUser) {
        //             notificationCounter.innerText = Number(notificationCounter.innerText) + 1;

        //             let html = `
        //             <!--begin::Item-->
        //                 <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.id_notification}">
        //                     <!--begin::Section-->
        //                     <div class="d-flex align-items-center">
        //                         <!--begin::Symbol-->
        //                         <div class="symbol symbol-35px me-4">
        //                             <span class="symbol-label bg-light-primary">
        //                                 <i class="bi bi-key-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
        //                             </span>
        //                         </div>
        //                         <!--end::Symbol-->
        //                         <!--begin::Title-->
        //                         <div class="mb-0 me-2">
        //                             <a href="/user/view/${data.from_user.id}"
        //                                 class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
        //                             <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
        //                             </div>
        //                             <br>
        //                             <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" onclick="resetPasswordAuthorize(this, true)">Cancel</button>
        //                             <button type="button" class="btn btn-sm btn-active-primary text-white" data-parent-item="${data.id_notification}" onclick="resetPasswordAuthorize(this)" style="background-color: #008CB4;">Authorize</button>
        //                         </div>
        //                         <!--end::Title-->
                                
        //                     </div>
        //                     <!--end::Section-->
        //                     <!--begin::Label-->
        //                     <span class="badge badge-light fs-8" id="timestamp-notif">${time}</span>
        //                     <!--end::Label-->
        //                 </div>
        //             <!--end::Item-->
        //             `;
        //             mainNotifContent.innerHTML += html;
        //         } else if (data.to_user.id == idUser && data.to_user.check_administrator != 1 && data.message.includes("sudah")) {
        //             notificationCounter.innerText = Number(notificationCounter.innerText) + 1;

        //             let actionNotifBtn = ``;
        //             if (!data.is_rejected) {
        //                 actionNotifBtn = `
        //                 <form action="/user/password/reset/new" method="POST">
        //                     @csrf
        //                     <input type="hidden" name="id-notification" value="${data.id_notification}">
        //                     <button type="submit"
        //                         name="reset-password"
        //                         class="btn btn-sm btn-active-primary text-white"
        //                         style="background-color: #008CB4;">Buat password baru</button>
        //                 </form>
        //                 `;
        //             }
        //             let html = `
        //             <!--begin::Item-->
        //                 <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.from_user.id}">
        //                     <!--begin::Section-->
        //                     <div class="d-flex align-items-center">
        //                         <!--begin::Symbol-->
        //                         <div class="symbol symbol-35px me-4">
        //                             <span class="symbol-label bg-light-primary">
        //                                 <i class="bi bi-key-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
        //                             </span>
        //                         </div>
        //                         <!--end::Symbol-->
        //                         <!--begin::Title-->
        //                         <div class="mb-0 me-2">
        //                             <a href="/user/view/${data.from_user.id}"
        //                                 class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
        //                             <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
        //                             </div>
        //                             <br>
                                    
        //                             ${actionNotifBtn}
                                    
        //                         </div>
        //                         <!--end::Title-->
                                
        //                     </div>
        //                     <!--end::Section-->
        //                     <!--begin::Label-->
        //                     <span class="badge badge-light fs-8" id="timestamp-notif">${time}</span>
        //                     <!--end::Label-->
        //                 </div>
        //             <!--end::Item-->
        //             `;
        //             mainNotifContent.innerHTML += html;
        //         }
        //     } else {
        //         let actionNotifBtn = "";
        //         if (data.is_rejected) {
        //             actionNotifBtn = `
        //                     <button type="button"
        //                         class="btn btn-sm btn-secondary disabled">Sudah tidak
        //                         disetujui</button>
        //                 `;
        //         } else {
        //             actionNotifBtn = `
        //                     <button type="button"
        //                         class="btn btn-sm btn-secondary disabled">Sudah
        //                         disetujui</button>
        //                 `;
        //         }

        //         let html = `
        //                     <!--begin::Section-->
        //                     <div class="d-flex align-items-center">
        //                         <!--begin::Symbol-->
        //                         <div class="symbol symbol-35px me-4">
        //                             <span class="symbol-label bg-light-primary">
        //                                 <i class="bi bi-key-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
        //                             </span>
        //                         </div>
        //                         <!--end::Symbol-->
        //                         <!--begin::Title-->
        //                         <div class="mb-0 me-2">
        //                             <a href="/user/view/${data.to_user.id}"
        //                                 class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.to_user.name}</a>
        //                             <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
        //                             </div>
        //                             <br>

        //                             ${actionNotifBtn}

        //                         </div>
        //                         <!--end::Title-->
                                
        //                     </div>
        //                     <!--end::Section-->
        //                     <!--begin::Label-->
        //                     <span class="badge badge-light fs-8" id="timestamp-notif">${time}</span>
        //                     <!--end::Label-->
        //             `;
        //         isNotifExist.innerHTML = html;
        //     }
        // });

        // window.Echo.on('connect', function(){
        //     console.log('connected', window.Echo.socketId());
        // });

        // begin Reset Password Authorization
        async function resetPasswordAuthorize(elt, is_rejected = false) {
            const getParentID = elt.getAttribute("data-parent-item");
            const parentElt = document.querySelector(`#item-${getParentID}`);
            const name = parentElt.querySelector("#title-notif");
            const message = parentElt.querySelector("#msg-notif");
            const time = parentElt.querySelector("#timestamp-notif");
            const formData = new FormData();
            let actionButtonAdmin = '';
            formData.append("_token", "{{ csrf_token() }}");
            if (is_rejected) {
                formData.append("is_rejected", true);
                actionButtonAdmin = `
                    <button type="button"
                        class="btn btn-sm btn-secondary disabled">Sudah tidak
                        disetujui</button>
                `;
            } else {
                actionButtonAdmin = `
                    <button type="button"
                        class="btn btn-sm btn-secondary disabled">Sudah
                        disetujui</button>
                `;
            }
            formData.append("id-user", getParentID);
            // formData.append("id-notif", idNotification);
            const resetPasswordRes = await fetch("/user/password/reset", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Socket-ID": window.Echo.socketId(),
                }
            }).then(res => res.json);


            let html = `
            <!--begin::Item-->
                    <div class="d-flex flex-stack py-4 border-bottom" id="item-${getParentID}">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35px me-4">
                                <span class="symbol-label bg-light-primary">
                                    <i class="bi bi-key-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="mb-0 me-2">
                                <a href="/user/view/${getParentID}"
                                    class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${name.innerText}</a>
                                <div class="text-gray-400 fs-7" id="msg-notif">${message.innerText}
                                </div>
                                <br>
                                ${actionButtonAdmin}
                            </div>
                            <!--end::Title-->
                            
                        </div>
                        <!--end::Section-->
                        <!--begin::Label-->
                        <span class="badge badge-light fs-8" id="timestamp-notif">${time.innerText}</span>
                        <!--end::Label-->
                    </div>
                <!--end::Item-->
            `;

            // console.log(parentElt);
            parentElt.innerHTML = html;
            // parentElt.remove();
        }
        // end Reset Password Authorization

        // Begin Lock/Unlock Forecast
        // window.Echo.channel("lock.foreacast.event").listen("LockForeacastEvent",async data => {
        //     // console.log("Data Received");
        //     console.log(data);

        //     const mainNotifContent = document.querySelector("#main-content-notif");
        //     const isAdministrator = Number("{{ auth()->user()->check_administrator ?? 0 }}");
        //     const lockForecastBtn = document.querySelector("#lock-forecast");
        //     const idUser = Number("{{ auth()->user()->id ?? 0 }}");
        //     const nextUser = data.next_user.length > 1 ? JSON.stringify(data.next_user) : isNaN(Number(data.next_user[0])) ? "[]" : Number(Number(data.next_user[0]));
        //     // const dataDate = new Date(data.timestamp.date);
        //     // const nowDate = new Date();
        //     // const diff = Math.abs(dataDate - nowDate);
        //     // let time = "";

        //     // if (diff < 1000) {
        //     //     time = `now`;
        //     // } else if (diff % 1000 == 0) {
        //     //     time = `${diff} sec`;
        //     // }

        //     let html = "";
        //     if (data.to_user.check_administrator == isAdministrator && data.to_user.id == idUser && (data.is_rejected || data.is_approved)) {
        //         if(lockForecastBtn) {
        //             const icon = lockForecastBtn.querySelector("i");
        //             const formData = new FormData();
        //             formData.append("_token", "{{csrf_token()}}");
        //             formData.append("set-lock", true);
                    
        //             const setLockForecastRes = await fetch("/forecast/set-lock", {
        //                 method: "POST",
        //                 header: {
        //                     "Content-Type": "application/json",
        //                 },
        //                 body: formData,
        //             }).then(res => res.json());
        //             if(data.is_approved) {
        //                 // if(icon.classList.contains("bi-lock-fill")) {
        //                 //     icon.classList.add("bi-unlock-fill")
        //                 //     icon.classList.remove("bi-lock-fill")
        //                 // } else {
        //                 //     icon.classList.remove("bi-unlock-fill")
        //                 //     icon.classList.add("bi-lock-fill")
        //                 // }
        //                 lockForecastBtn.removeAttribute("disabled");
        //                 const allInputsForecast = document.querySelectorAll("input[data-month]");
        //                 if(allInputsForecast) {
        //                     allInputsForecast.forEach(input => {
        //                         if (input.hasAttribute("disabled")) {
        //                             input.removeAttribute("disabled");
        //                         } else {
        //                             input.setAttribute("disabled", "");
        //                         }
        //                     });
        //                 }
        //             }
        //             Swal.fire({
        //                 title: 'Success',
        //                 text: setLockForecastRes.msg,
        //                 icon: 'success',
        //                 timer: 3000,
        //                 showConfirmButton: false,
        //             });
        //         }
        //         let actionBtnForecast = "";
        //         if (data.is_rejected) {
        //             actionBtnForecast = `
        //             <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" disabled>Lock tidak disetujui</button>
        //         `;
        //     } else if(data.is_approved) {
        //             actionBtnForecast = `
        //             <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" disabled>Lock disetujui</button>
        //         `;  
        //         }

        //         html = `
        //                 <!--begin::Item-->
        //                     <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.id_notification}">
        //                         <!--begin::Section-->
        //                         <div class="d-flex align-items-center">
        //                             <!--begin::Symbol-->
        //                             <div class="symbol symbol-35px me-4">
        //                                 <span class="symbol-label bg-light-primary">
        //                                     <i class="bi bi-lock-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
        //                                 </span>
        //                             </div>
        //                             <!--end::Symbol-->
        //                             <!--begin::Title-->
        //                             <div class="mb-0 me-2">
        //                                 <a href="#"
        //                                     class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
        //                                 <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
        //                                 </div>
        //                                 <br>
        //                                 ${actionBtnForecast}
        //                             </div>
        //                             <!--end::Title-->
                                    
        //                         </div>
        //                         <!--end::Section-->
        //                         <!--begin::Label-->
        //                         <span class="badge badge-light fs-8" id="timestamp-notif">${"Now"}</span>
        //                         <!--end::Label-->
        //                     </div>
        //                 <!--end::Item-->
        //                 `;
        //         mainNotifContent.innerHTML += html;
        //     } else {
        //         let buttonActionUnlock = "";
        //         if (data.message.includes("Unlock")) {
        //             buttonActionUnlock = `lockUnlockForecast(this, false, ${nextUser == "[]" ? data.from_user.id : nextUser}, ${nextUser == "[]" ? data.to_user.id : data.from_user.id }, true)`;
        //         } else {
        //             buttonActionUnlock = `lockUnlockForecast(this, false, ${nextUser == "[]" ? data.from_user.id : nextUser}, ${nextUser == "[]" ? data.to_user.id : data.from_user.id })`;
        //         }
        //         if (data.to_user.id == idUser)
        //             html = `
        //                 <!--begin::Item-->
        //                     <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.id_notification}">
        //                         <!--begin::Section-->
        //                         <div class="d-flex align-items-center">
        //                             <!--begin::Symbol-->
        //                             <div class="symbol symbol-35px me-4">
        //                                 <span class="symbol-label bg-light-primary">
        //                                     <i class="bi bi-lock-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
        //                                 </span>
        //                             </div>
        //                             <!--end::Symbol-->
        //                             <!--begin::Title-->
        //                             <div class="mb-0 me-2">
        //                                 <a href="#"
        //                                     class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
        //                                 <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
        //                                 </div>
        //                                 <br>
        //                                 <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" onclick="lockUnlockForecast(this, true, ${data.to_user.id}, ${data.from_user.id})">Reject</button>
        //                                 <button type="button" class="btn btn-sm btn-active-primary text-white" data-parent-item="${data.id_notification}" onclick="lockUnlockForecast(this, false, ${nextUser == "[]" ? data.from_user.id : nextUser}, ${nextUser == "[]" ? data.to_user.id : data.from_user.id })" style="background-color: #008CB4;">Accept</button>
        //                             </div>
        //                             <!--end::Title-->
                                    
        //                         </div>
        //                         <!--end::Section-->
        //                         <!--begin::Label-->
        //                         <span class="badge badge-light fs-8" id="timestamp-notif">${"Now"}</span>
        //                         <!--end::Label-->
        //                     </div>
        //                 <!--end::Item-->
        //                 `;
        //         mainNotifContent.innerHTML += html;
        //     }
        // });

        async function lockUnlockForecast(elt, isRejected = false, nextUser, fromUser, isUnlock = false) {
            const idNotification = elt.getAttribute("data-parent-item");
            const parentElt = document.querySelector(`#item-${idNotification}`);
            const nameFrom = parentElt.querySelector("#title-notif").innerText;
            const message = parentElt.querySelector("#msg-notif").innerText;
            let actionBtn = "";

            const formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            if (isRejected) {
                formData.append("is_rejected", isRejected);
            } else {
                formData.append("is_approved", true);
            }

            if(nextUser.length < 1) {
                formData.append("notif_end", true);
            } else {
                formData.append("next_user", nextUser);
            }
            formData.append("id_notification", idNotification);
            formData.append("from_user", fromUser);

            if (isRejected) {
                actionBtn = `
                <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${idNotification}" disabled>Lock tidak disetujui</button>
                `;
            } else {
                actionBtn = `
                <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${idNotification}" disabled>Lock disetujui</button>
                `;
            }
            const html = `
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35px me-4">
                                <span class="symbol-label bg-light-primary">
                                    <i class="bi bi-lock-fill fs-2" id="icon-notif" style="color: rgb(223, 155, 28)"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="mb-0 me-2">
                                <a href="#"
                                    class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${nameFrom}</a>
                                <div class="text-gray-400 fs-7" id="msg-notif">${message}
                                </div>
                                <br>
                                ${actionBtn}
                            </div>
                            <!--end::Title-->
                            
                        </div>
                        <!--end::Section-->
                        <!--begin::Label-->
                        <span class="badge badge-light fs-8" id="timestamp-notif">${"Now"}</span>
                        <!--end::Label-->
                `;
            parentElt.innerHTML = html;
            let url = isUnlock ? "/user/forecast/set-unlock" : "/user/forecast/set-lock";
            const nextApprovalUserLock = await fetch(url, {
                method: "POST",
                header: {
                    "Content-Type": "application/json",
                    // "X-Socket-ID": window.Echo.socketId(),
                },
                body: formData,
            });
        }
        // End Lock/Unlock Forecast
    </script>
    {{-- end::Pusher --}}


    {{-- begin::Bootstrap JS --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script> --}}
    <script src="{{ asset('/bootstrap/popper.min.js') }}"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    {{-- end::Bootstrap JS --}}

    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}

    {{-- Begin:: Leaflet JS --}}
    {{-- <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
    integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
    crossorigin=""></script> --}}
    {{-- End:: Leaflet JS --}}

    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    {{-- begin::html2pdf JS --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('/js/html2pdf.bundle.min.js') }}"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- end::html2pdf JS --}}

    {{-- begin::sweetalert2 JS --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.all.min.js"></script> --}}
    <script src="{{ asset('/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- end::sweetalert2 JS --}}


    {{-- begin::Froala Editor JS --}}
    {{-- <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script> --}}
    <script type='text/javascript' src='{{ asset('/froala/froala_editor.pkgd.min.js') }}'>
    </script>
    {{-- end::Froala Editor JS --}}


    {{-- FUNGSI UNKNOWN - begin::Support Plugin for Word Editor --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.29.4/docxtemplater.js"></script>
    <script src="https://unpkg.com/pizzip@3.1.1/dist/pizzip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://unpkg.com/pizzip@3.1.1/dist/pizzip-utils.js"></script>
    {{-- end::Support Plugin for Word Editor --}}

    {{-- begin::docx4js Library --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/docx4js@3.2.20/dist/docx4js.js"></script> --}}
    {{-- <script>import * as docx from "docx";</script> --}}
    {{-- end::docx4js Library --}}


    {{-- begin::Mammoth Library --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"
        integrity="sha512-bGuEL2NBSooMeQLM6bf6Xdywje4PWKegNTuKpghz2xgFXtRjEs4B3X1ql7nghiCvt8gXBAks5S3KN3Jp3Jgtow=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('/froala/mammoth.browser.min.js') }}" referrerpolicy="no-referrer"></script>
    {{-- end::Mammoth Library --}}
    {{-- begin:: docx2html Library --}}
    <script src="https://cdn.jsdelivr.net/npm/docx2html@1.3.2/dist/docx2html.min.js"></script>
    {{-- end:: docx2html Library --}}
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('/js/custom/modals/upgrade-plan.js') }}"></script>

    {{-- Begin :: Animation Progress Bar --}}
    <script>
        function animateProgressBar() {
            const progressbarElts = document.querySelectorAll("div[role='progressbar']");
            progressbarElts.forEach(item => {
                const dataPersen = item.parentElement.parentElement.querySelector("#data-persen");
                let width = Number(dataPersen.innerText.replace("%", ""));
                item.style.width = width + "%";
            });
        }
        animateProgressBar();
    </script>
    {{-- End :: Animation Progress Bar --}}

    {{-- Begin :: Animation Counter Number --}}
    <script>
        function animateCounterNumber(selector, firstPrefix = "", lastPrefix = "") {
            const animateCounterElts = document.querySelectorAll(`${selector}`);
            animateCounterElts.forEach(item => {
                let data;
                if(firstPrefix != ""){
                    data = Number(item.innerText.replaceAll(firstPrefix, "").replaceAll(".", ""));
                } else {
                    data = Number(item.innerText.replaceAll(lastPrefix, ""));
                }
                item.innerText = `${firstPrefix}0${lastPrefix}`;
                let i = 0;
                const interval = setInterval(() => {
                    if(i == data || i >= data) {
                        clearInterval(interval);
                        if(firstPrefix == "Rp. "){
                            data = Intl.NumberFormat(["id"]).format(data);
                        }
                        item.innerText = `${firstPrefix}${data}${lastPrefix}`;
                        return;
                    };
                    if(data > 15) {
                        i+= Math.floor(data/15);
                    } else {
                        i+= 1;
                    }
                    if(firstPrefix == "Rp. "){
                        // i+= Math.floor((data / 15) + data);
                        item.innerText = `${firstPrefix}${Intl.NumberFormat(["id"]).format(i)}${lastPrefix}`;
                    } else {
                        // i++;
                        item.innerText = `${firstPrefix}${i}${lastPrefix}`;
                    }
                }, 25);
            });
        }
        // animateCounterNumber("#data-persen", "", "%");
        // animateCounterNumber("#data-items", "Rp. ");
    </script>
    {{-- End :: Animation Counter Number --}}

    @yield('js-script')

    <script>
        // script reformat number by add class
        function reformat() {
            this.value = Intl.NumberFormat("id").format(this.value.replace(/[^0-9]/gi, ""));
            // this.value = Intl.NumberFormat("en-US").format(this.value.replace(/[^0-9]/gi, ""));
            // return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }
        document.querySelectorAll('.reformat').forEach(inp => {
            inp.addEventListener('input', reformat);
        });

        // script reformat number by add class
        function reformatRetail() {
            // console.log(Number(this.value.replace(/[^0-9][^\+\-]/gi, "")));
            if(this.value.includes("-") && !this.value.includes("+")) {
                this.value = Intl.NumberFormat("id").format(Number(this.value.replace(/[^0-9]/gi, "")) * -1);
                return;
            }else if(this.value.includes("+")) {
                this.value = Intl.NumberFormat("id").format(Number(this.value.replace(/[^0-9|-]/gi, "")) * -1);
                return;
            }
            this.value = Intl.NumberFormat("id").format(Number(this.value.replace(/[^0-9|-]/gi, "")));
            // this.value = Intl.NumberFormat("en-US").format(this.value.replace(/[^0-9]/gi, ""));
            // return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }
        document.querySelectorAll('.reformat-retail').forEach(inp => {
            inp.addEventListener('input', reformatRetail);
        });
    </script>
    <!--end::Page Custom Javascript-->

    @if (!str_contains(Request::path(), "document/view"))
    {{-- End :: Notif Open --}}
    <script>
        const tabNotif = document.querySelector("#notif-alert");
        const tabNotifBoots = new bootstrap.Tab(tabNotif, {});
        tabNotifBoots.show();
    </script>
    {{-- Begin :: Notif Open --}}
        
    @endif

    <script>
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
        });
    </script>

    <!--begin:: show calendar-->
    <script>
        const calendarElt = document.querySelector("#kt_modal_calendar");

        if(calendarElt) {
            //begin:: onChange Month //pada element select Month tambahkan fungsi onchange="monthCalendar(this)" && tambahkan id="tgl-30"; id="tgl-31"
            function monthCalendar(e) {
                const isLeapYear = Boolean("{{$is_leap_year}}");
                if (e.value == "2"){
                    if(!isLeapYear) {
                        document.getElementById("tgl-29").style.display = "none";
                    }
                    document.getElementById("tgl-30").style.display = "none";
                    document.getElementById("tgl-31").style.display = "none";
                }else if (e.value == "4" || e.value == "6" || e.value == "9" || e.value == "11"){
                    document.getElementById("tgl-29").style.display = "";
                    document.getElementById("tgl-30").style.display = "";
                    document.getElementById("tgl-31").style.display = "none";
                }else{
                    document.getElementById("tgl-29").style.display = "";
                    document.getElementById("tgl-30").style.display = "";
                    document.getElementById("tgl-31").style.display = "";
                }
            }
            //end:: onChange Month

            // Begin :: Set Date Clickable
            function setDateClickable(rootElt) {
                const dates = document.querySelectorAll(
                    `${rootElt} .calendar__body .calendar__dates .calendar__date`);
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
                            // if (rootElt.toString().match("end")) {
                            //     dateEnd = Number(elt.firstElementChild.innerText);
                            //     const dateStart = document.querySelectorAll(
                            //         `#start-date .calendar__body .calendar__dates .calendar__date`
                            //     );
                            //     dateStart.forEach((d, i) => {
                            //         if (i + 1 == dateEndFix) {
                            //             d.classList.add("calendar__date--range-start");
                            //         } else {
                            //             d.classList.remove("calendar__date--range-start");
                            //         }
                            //     });
                            // } else {
                            //     date = Number(elt.firstElementChild.innerText);
                            //     const dateEnd = document.querySelectorAll(
                            //         `#end-date .calendar__body .calendar__dates .calendar__date`
                            //     );
                            //     dateEnd.forEach((d, i) => {
                            //         if (i + 1 <= date && monthEndFix < month) {
                            //             // d.classList.add("calendar__date--range-start");
                            //             d.classList.add("calendar__date--grey");
                            //         } else {
                            //             d.classList.remove("calendar__date--range-start");
                            //         }
                            //     });
                            // }
                            elt.classList.add("calendar__date--selected");
                            elt.classList.add("calendar__date--range-end");
                            elt.classList.add("calendar__date--first-date");
                        }
                    });
                });
            }
            setDateClickable("#kt_modal_calendar");
            // End :: Set Date Clickable
            const calendarBoots = new bootstrap.Modal(calendarElt, {});
            let dateInputElt = null;
            function showCalendarModal(elt) {
                calendarBoots.show();
                // dateInputElt = elt.parentElement.querySelector("input[type='date']");
                dateInputElt = returnParentElement(elt, "input[type='date']");
            }
            
            function returnParentElement(elt, targetInput) {
                const inputDate = elt.querySelector(targetInput);
                if (inputDate) {
                    return inputDate;
                }
                return returnParentElement(elt.parentElement, targetInput);
            }
    
            function setCalendar() {
                const date = calendarElt.querySelector(".calendar__date--first-date");
                const month = calendarElt.querySelector("#calendar__month").value;
                const year = calendarElt.querySelector("#calendar__year").value;
                const valueDate = `${year}-${month.toString().padStart(2, "0")}-${date.innerText.padStart(2, "0")}`;
                dateInputElt.value = valueDate;
            }
        }

        // Overlay Modal
        jQuery(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1040 + 10 * jQuery('.modal:visible').length;
            jQuery(this).css('z-index', zIndex);
            setTimeout(() => jQuery('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
        });


    </script>
    <!--end:: show calendar-->
    
    <!--begin:: Cancel Button-->
    {{-- <script>
        let isEditing = false;
        const cancelAllInput = document.querySelectorAll("input");
        
        // function closeButton(e){
        //     if (isEditing == true) {
        //         // console.log("close");
        //         e.preventDefault();
        //         e.setAttribute("type", "button");
        //         // console.log(e.getAttribute("href"));
        //         Swal.fire({
        //             title: '',
        //             text: "Edited File will be deleted ?",
        //             icon: false,
        //             showCancelButton: true,
        //             confirmButtonColor: '#008CB4',
        //             cancelButtonColor: '#BABABA',
        //             confirmButtonText: 'Ya'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 formSend.submit();
        //             }
        //             return false;
        //         });
        //     } else {
        //         return true;
        //     }
        // }
        
        cancelAllInput.forEach(input => {
            input.addEventListener("click", e => {
                isEditing = true;
                if (document.querySelector("#cancel-button")) {
                    document.querySelector("#cancel-button").style.display = "";

                    // console.log(input.getAttribute("type"));
                    // if(isEditing == true){
                    // }
                    // else{
                    //     window.onbeforeunload = async (e) => {
                    //     }
                    // }
                    
                    // if (!document.querySelector("#proyek-save")) {
                    //     console.log("on save button");
                    // }
                    // function saveProyek() {
                    // }
                }
            });
            input.addEventListener("input", e => {
                isEditing = true;
                if (document.querySelector("#cancel-button")) {
                document.querySelector("#cancel-button").style.display = "";
                    // window.onbeforeunload = async (e) => {
                    //     // console.log("oke");
                    //     // return;
                    //     // const data = await Swal.fire({
                    //     //     title: 'Are you sure?',
                    //     //     text: "You won't be able to revert this!",
                    //     //     icon: 'warning',
                    //     //     showCancelButton: true,
                    //     //     confirmButtonColor: '#3085d6',
                    //     //     cancelButtonColor: '#d33',
                    //     //     confirmButtonText: 'Yes, delete it!'
                    //     //     }).then((result) => {
                    //     //     if (result.isConfirmed) {
                    //     //         return result;
                    //     //         // Swal.fire(
                    //     //         // 'Deleted!',
                    //     //         // 'Your file has been deleted.',
                    //     //         // 'success'
                    //     //         // )
                    //     //     }
                    //     // })
                    //     // return data;
                    //     // if(isEditing) {
                    //     //     let isConfirmed = confirm("apakah anda yakin ingin pindah halaman?");
                    //     //     if (!isConfirmed) {
                    //     //         return;
                    //     //     }
                    //     // }
                    // };
                }
            });
        });
        
        $("select").select2().on("change", e => {
            isEditing = true;
            if (document.querySelector("#cancel-button")) {
                document.querySelector("#cancel-button").style.display = "";
                // window.onbeforeunload = async (e) => {
                //     // console.log("oke");
                //     // return;
                //     // const data = await Swal.fire({
                //     //     title: 'Are you sure?',
                //     //     text: "You won't be able to revert this!",
                //     //     icon: 'warning',
                //     //     showCancelButton: true,
                //     //     confirmButtonColor: '#3085d6',
                //     //     cancelButtonColor: '#d33',
                //     //     confirmButtonText: 'Yes, delete it!'
                //     //     }).then((result) => {
                //     //     if (result.isConfirmed) {
                //     //         return result;
                //     //         // Swal.fire(
                //     //         // 'Deleted!',
                //     //         // 'Your file has been deleted.',
                //     //         // 'success'
                //     //         // )
                //     //     }
                //     // })
                //     // return data;
                //     // if(isEditing) {
                //     //     let isConfirmed = confirm("apakah anda yakin ingin pindah halaman?");
                //     //     if (!isConfirmed) {
                //     //         return;
                //     //     }
                //     // }
                // };
            }
        });
    </script> --}}
    <!--end:: Cancel Button-->
    
    <!-- Begin :: Get Modal ID -->
     <script>
        const modalNameElts = document.querySelectorAll(".modal-name");
        if (modalNameElts) {
            modalNameElts.forEach(async elt => {
                const getModalIDName = await getModalID(elt).then(res => res.id);
                elt.value = getModalIDName;
            });
        }

        async function getModalID (elt) {
            const promises = new Promise((success) => {
                let modalElement = returnParentElement(elt);
                const isContainsKTMODAL = modalElement.id.includes("kt_modal");
                if (!isContainsKTMODAL) {
                    modalElement = getModalID(modalElement);
                }
                return success(modalElement);
            });
            return promises;
        }

        function returnParentElement(elt) {
            return elt.parentElement;
        }
     </script>
    <!-- End :: Get Modal ID -->
    
    <!-- begin :: Show Modal jika terjadi error pada inputan -->
    @if (Session::has("modal"))
        <script>
            const modalWantToOpenElt = document.querySelector("#{{Session::get('modal')}}");
            const modalWantToOpenBoots = new bootstrap.Modal(modalWantToOpenElt, {});
            modalWantToOpenBoots.show();
        </script>
    @endif
    <!-- End :: Show Modal jika terjadi error pada inputan -->

    {{-- Begin :: Char Counter --}}
    <script>
        const charCounterElts = document.querySelectorAll(".char-counter");
        charCounterElts.forEach(item => {
            const textNumberElt = item.parentElement.querySelector(".d-flex small");
            const maxChar = Number(item.getAttribute("data-max-char"));
            if(maxChar && !item.value) {
                item.addEventListener("input", e => {
                    let lengthChar = item.value.length;
                    if(lengthChar >= maxChar) {
                        // console.log(item.value);
                        const newValue = item.value.split("");
                        newValue.pop();
                        item.value = newValue.join("");
                        lengthChar = item.value.length;
                    }
                    textNumberElt.innerText = `${lengthChar}/${maxChar}`;
                });
            }else if(item.value) {
                item.addEventListener("input", e => {
                    let lengthChar = item.value.length;
                    if(lengthChar >= maxChar) {
                        // console.log(item.value);
                        const newValue = item.value.split("");
                        newValue.pop();
                        item.value = newValue.join("");
                        lengthChar = item.value.length;
                    }
                    textNumberElt.innerText = `${lengthChar}/${maxChar}`;
                });
                let lengthChar = item.value.length;
                if(lengthChar >= maxChar) {
                    // console.log(item.value);
                    const newValue = item.value.split("");
                    for(let i = 1; i <= lengthChar - maxChar; i++) {
                        newValue.pop();
                    }
                    item.value = newValue.join("");
                    lengthChar = item.value.length;
                }
                textNumberElt.innerText = `${lengthChar}/${maxChar}`;
            } else {
                console.error("You implement char counter. Make sure each field has data-max-char attribute");
            }
        })
    </script>
    {{-- End :: Char Counter --}}

    <!--end::Javascript-->

</body>
<!--end::Body-->

</html>

@include('sweetalert::alert')
