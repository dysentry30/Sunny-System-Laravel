<!DOCTYPE html>

<html lang="en">

<!--begin::Head-->

<head>
    <base href="">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('/media/logos/Icon-CCM.png') }}" />
    <!--begin::Fonts-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    {{-- begin::Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    {{-- end::Bootstrap CSS --}}

    {{-- begin::Froala CSS --}}
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
    {{-- end::Froala CSS --}}

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
    </style>
    {{-- end:: Disable Native Date Browser --}}
</head>
<!--end::Head-->


<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">


    <!--begin::Aside-->
    {{-- @yield('aside') --}}
    @if (auth()->user())
        <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="background-color:#0db0d9">
            <!--begin::Brand-->
            <div class="aside-logo flex-column-auto" id="kt_aside_logo" style="background-color:#0db0d9;">
                <!--begin::Logo-->
                <a href="#" style="background-color:#0db0d9;">
                    <img alt="Logo" src="/media/logos/Logo2.png" class="h-70px logo"
                        style="margin-top:30px;margin-left:-20px;" />
                </a>
                <!--end::Logo-->

            </div>
            <!--end::Brand-->
            <!--begin::Aside menu-->
            <div class="aside-menu flex-column-fluid" style="background-color:#0db0d9;margin-top:40px;">
                <!--begin::Aside Menu-->
                <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                    data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">

                    {{-- #008CB4 --}}

                    <!--begin::Menu-->
                    <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#0db0d9;">

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
                            <div class="menu-item">
                                <a class="menu-link " href="/dashboard"
                                    style="color:white; {{ Request::Path() == 'dashboard' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/dashboards.svg"
                                                class="h-35px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Dashboard</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                            <div class="menu-item">
                                <a class="menu-link " href="/customer"
                                    style="color:white; {{ Request::Path() == 'customer' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/account.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Pelanggan</span>
                                </a>
                            </div>
                        @endif


                        @if (auth()->user()->check_administrator || auth()->user()->check_user_sales || auth()->user()->check_team_proyek)
                            <div class="menu-item">
                                <a class="menu-link " href="/proyek"
                                    style="color:white; {{ Request::Path() == 'proyek' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/opportunity.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Proyek</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
                            <div class="menu-item">
                                <a class="menu-link " href="/forecast"
                                    style="color:white; {{ Request::Path() == 'forecast' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-graph-up-arrow text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Forecast</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_team_proyek)
                            <div class="menu-item">
                                <a class="menu-link " href="/contract-management"
                                    style="color:white; {{ Request::Path() == 'contract-management' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/contract.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Contract Management</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_team_proyek)
                            <div class="menu-item">
                                <a class="menu-link " href="/claim-management"
                                    style="color:white; {{ Request::Path() == 'claim-management' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/releases.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Claim Management</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="/document"
                                    style="color:white; {{ Request::Path() == 'document' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Document</span>
                                </a>
                            </div>
                        @endif


                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
                            <!--Begin::Master Data Expand-->
                            {{-- <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#0db0d9;margin-top:8px;"> --}}
                            <div class="menu-item">
                                <p>
                                    <a class="menu-link" id="collapse-button" style="color:white;"
                                        data-bs-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-cloud-download-fill text-white"
                                                    style="font-size: 18px; margin-left:7px"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title-2">Master Data <i
                                                class="bi bi-caret-down-fill text-white"></i></span>
                                    </a>
                                </p>
                                <!--begin::Colapse-->
                                <div class="collapse" id="collapseExample">
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'company' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/company" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-building text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">Company</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'sumber-dana' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/sumber-dana" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-wallet text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">Sumber Dana</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'dop' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/dop" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-bar-chart text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">DOP</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'sbu' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/sbu" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-bar-chart text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">SBU</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'unit-kerja' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/unit-kerja" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-diagram-3-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">Unit Kerja</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'pasal/edit' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/pasal/edit" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-stack text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">Pasal</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'user' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/user" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-people-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">Users</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'team-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/team-proyek" style="color:white;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-lines-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title-2">Team Proyek</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                </div>
                                <!--end::Colapse-->
                                <!--end::Svg Icon-->
                                </span>
                                </a>
                            </div>
                            {{-- </div> --}}
                            <!--end::Master Data Expand-->
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="/rkap"
                                    style="color:white; {{ Request::Path() == 'rkap' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-chat-left-dots-fill text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Group RKAP</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="/kpi"
                                    style="color:white; {{ Request::Path() == 'kpi' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/bonus_rules.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">KPI</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
                            <div class="menu-item">
                                <a class="menu-link " href="/knowledge-base"
                                    style="color:white; {{ Request::Path() == 'knowledge-base' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/knowledge_base.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Knowledge Base</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="/change-request"
                                    style="color:white; {{ Request::Path() == 'change-request' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/changes.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Change Request</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="stakeholder-communication"
                                    style="color:white; {{ Request::Path() == 'stakeholder-communication' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/feed.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title-2">Stakeholder Communication</span>
                                </a>
                            </div>
                        @endif

                        <br><br><br>

                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Aside Menu-->
            </div>
            <!--end::Aside menu-->

        </div>
        <!--end::Aside-->
    @endif



    <!--begin:: CONTENT-->
    @yield('content')
    <!--end :: CONTENT-->

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
        window.Echo.channel("notification.password.reset").listen("NotificationPasswordReset", (data) => {
            userSocketID = window.Echo.socketId();
            let isNotifExist = "";
            if (data.id_notification != "") {
                isNotifExist = document.querySelector(`#item-${data.id_notification}`);
            }
            const notificationCounter = document.querySelector("#notification-counter");
            const mainNotifContent = document.querySelector("#main-content-notif");
            const isAdministrator = Number("{{ auth()->user()->check_administrator ?? 0 }}");
            const idUser = Number("{{ auth()->user()->id ?? 0 }}");
            // const idNotification = data.id_notification;
            const dataDate = new Date(data.timestamp.date);
            const nowDate = new Date();
            const diff = Math.abs(dataDate - nowDate);
            let time = "";

            if (diff < 1000) {
                time = `now`;
            } else if (diff % 1000 == 0) {
                time = `${diff} sec`;
            }

            if (isNotifExist == "" || isNotifExist == null) {

                if (isAdministrator == 1 && data.to_user.id == idUser) {
                    notificationCounter.innerText = Number(notificationCounter.innerText) + 1;

                    let html = `
                    <!--begin::Item-->
                        <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.id_notification}">
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
                                    <a href="/user/view/${data.from_user.id}"
                                        class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
                                    <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" onclick="resetPasswordAuthorize(this, true)">Cancel</button>
                                    <button type="button" class="btn btn-sm btn-active-primary text-white" data-parent-item="${data.id_notification}" onclick="resetPasswordAuthorize(this)" style="background-color: #008CB4;">Authorize</button>
                                </div>
                                <!--end::Title-->
                                
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8" id="timestamp-notif">${time}</span>
                            <!--end::Label-->
                        </div>
                    <!--end::Item-->
                    `;
                    mainNotifContent.innerHTML += html;
                } else if (data.to_user.id == idUser && data.to_user.check_administrator != 1 && data.message.includes("sudah")) {
                    notificationCounter.innerText = Number(notificationCounter.innerText) + 1;

                    let actionNotifBtn = ``;
                    if (!data.is_rejected) {
                        actionNotifBtn = `
                        <form action="/user/password/reset/new" method="POST">
                            @csrf
                            <input type="hidden" name="id-notification" value="${data.id_notification}">
                            <button type="submit"
                                name="reset-password"
                                class="btn btn-sm btn-active-primary text-white"
                                style="background-color: #008CB4;">Buat password baru</button>
                        </form>
                        `;
                    }
                    let html = `
                    <!--begin::Item-->
                        <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.from_user.id}">
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
                                    <a href="/user/view/${data.from_user.id}"
                                        class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
                                    <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
                                    </div>
                                    <br>
                                    
                                    ${actionNotifBtn}
                                    
                                </div>
                                <!--end::Title-->
                                
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8" id="timestamp-notif">${time}</span>
                            <!--end::Label-->
                        </div>
                    <!--end::Item-->
                    `;
                    mainNotifContent.innerHTML += html;
                }
            } else {
                let actionNotifBtn = "";
                if (data.is_rejected) {
                    actionNotifBtn = `
                            <button type="button"
                                class="btn btn-sm btn-secondary disabled">Sudah tidak
                                disetujui</button>
                        `;
                } else {
                    actionNotifBtn = `
                            <button type="button"
                                class="btn btn-sm btn-secondary disabled">Sudah
                                disetujui</button>
                        `;
                }

                let html = `
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
                                    <a href="/user/view/${data.to_user.id}"
                                        class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.to_user.name}</a>
                                    <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
                                    </div>
                                    <br>

                                    ${actionNotifBtn}

                                </div>
                                <!--end::Title-->
                                
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8" id="timestamp-notif">${time}</span>
                            <!--end::Label-->
                    `;
                isNotifExist.innerHTML = html;
            }
        });

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
        window.Echo.channel("lock.foreacast.event").listen("LockForeacastEvent", data => {
            console.log("Data Received");
            console.log(data);

            const mainNotifContent = document.querySelector("#main-content-notif");
            const isAdministrator = Number("{{ auth()->user()->check_administrator ?? 0 }}");
            const idUser = Number("{{ auth()->user()->id ?? 0 }}");
            // const dataDate = new Date(data.timestamp.date);
            // const nowDate = new Date();
            // const diff = Math.abs(dataDate - nowDate);
            // let time = "";

            // if (diff < 1000) {
            //     time = `now`;
            // } else if (diff % 1000 == 0) {
            //     time = `${diff} sec`;
            // }
            let html = "";
            if (data.to_user.check_administrator == isAdministrator && data.is_rejected) {
                let actionBtn = "";
                if (data.is_rejected) {
                    actionBtn = `
                    <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" disabled>Lock tidak disetujui</button>
                `;
                }

                html = `
                        <!--begin::Item-->
                            <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.id_notification}">
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
                                            class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
                                        <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
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
                            </div>
                        <!--end::Item-->
                        `;
                mainNotifContent.innerHTML += html;
            } else {
                if (data.to_user.id == idUser)
                    html = `
                        <!--begin::Item-->
                            <div class="d-flex flex-stack py-4 border-bottom" id="item-${data.id_notification}">
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
                                            class="fs-6 text-gray-800 text-hover-primary fw-bolder" id="title-notif">${data.from_user.name}</a>
                                        <div class="text-gray-400 fs-7" id="msg-notif">${data.message}
                                        </div>
                                        <br>
                                        <button type="button" class="btn btn-sm btn-light btn-active-primary" data-parent-item="${data.id_notification}" onclick="lockUnlockForecast(this, true, ${data.to_user.id}, ${data.from_user.id})">Reject</button>
                                        <button type="button" class="btn btn-sm btn-active-primary text-white" data-parent-item="${data.id_notification}" onclick="lockUnlockForecast(this, false, ${JSON.stringify(data.next_user)}, ${JSON.stringify(data.next_user) != "[]" ? data.from_user.id : data.to_user.id })" style="background-color: #ffa62b;">Accept</button>
                                    </div>
                                    <!--end::Title-->
                                    
                                </div>
                                <!--end::Section-->
                                <!--begin::Label-->
                                <span class="badge badge-light fs-8" id="timestamp-notif">${"Now"}</span>
                                <!--end::Label-->
                            </div>
                        <!--end::Item-->
                        `;
                mainNotifContent.innerHTML += html;
            }
        });

        async function lockUnlockForecast(elt, isRejected = false, nextUser, fromUser) {
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

            const nextApprovalUserLock = await fetch("/user/forecast/set-lock", {
                method: "POST",
                header: {
                    "Content-Type": "application/json",
                    // "X-Socket-ID": window.Echo.socketId(),
                },
                body: formData,
            });

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
        }
        // End Lock/Unlock Forecast
    </script>
    {{-- end::Pusher --}}


    {{-- begin::Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    {{-- end::Bootstrap JS --}}

    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}

    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    {{-- begin::html2pdf JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- end::html2pdf JS --}}


    {{-- begin::Froala Editor JS --}}
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"
        integrity="sha512-bGuEL2NBSooMeQLM6bf6Xdywje4PWKegNTuKpghz2xgFXtRjEs4B3X1ql7nghiCvt8gXBAks5S3KN3Jp3Jgtow=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    @yield('js-script')

    <script>
        // script reformat number by add class
        function reformat() {
            this.value = Intl.NumberFormat("en-US").format(this.value.replace(/[^0-9]/gi, ""));
        }
        document.querySelectorAll('.reformat').forEach(inp => {
            inp.addEventListener('input', reformat);
        });
    </script>
    <!--end::Page Custom Javascript-->

    {{-- End :: Notif Open --}}
    <script>
        const tabNotif = document.querySelector("#notif-alert");
        const tabNotifBoots = new bootstrap.Tab(tabNotif, {});
        tabNotifBoots.show();
    </script>
    {{-- Begin :: Notif Open --}}
    
    <!--end::Javascript-->

</body>
<!--end::Body-->

</html>

@include('sweetalert::alert')
