<!--begin::Header-->
<div id="kt_header" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-2x mt-1">
                    {{-- <i class="bi bi-list"></i> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="#" class="d-lg-none">
                <img alt="Logo" src="/media/logos/Icon-CCM.png" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-stretch" id="kt_header_nav">
                <!--begin::Menu wrapper-->
                <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                    data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                    data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">

                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Navbar-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-stretch flex-shrink-0">
                <!--begin::Toolbar wrapper-->
                <div class="d-flex align-items-stretch flex-shrink-0">

                    <!--begin::Notifications-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <!--begin::Menu- wrapper-->
                        <div class="btn-icon btn-active-light-primary position-relative"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen022.svg-->
                            <i class="bi bi-x-diamond-fill fs-1 text-hover-primary"></i>&nbsp;&nbsp;
                            {{-- <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
                                        fill="black" />
                                    <path
                                        d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
                                        fill="black" />
                                    <path opacity="0.3"
                                        d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
                                        fill="black" />
                                </svg>
                            </span> --}}
                            <!--end::Svg Icon-->
                            <span
                                class="position-absolute top-0 start-75 translate-middle badge rounded-circle bg-danger" style="padding: 5px">
                                <span id="notification-counter"></span>
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                            <!--begin::Heading-->
                            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                style="background-image:url('/media/misc/pattern-1.jpg')">
                                <!--begin::Title-->
                                <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications
                                </h3>
                                <!--end::Title-->
                                <!--begin::Tabs-->
                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                                    <li class="nav-item ">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 "
                                            data-bs-toggle="tab" id="notif-alert"
                                            href="#kt_topbar_notifications_1">Alerts</a>
                                    </li>

                                </ul>
                                <!--end::Tabs-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Tab content-->
                            <div class="tab-content">
                                <!--begin::Tab panel-->
                                <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                                    <!--begin::Items-->
                                    <div class="scroll-y mh-325px my-5 px-8" id="main-content-notif">
                                        @if (auth()->user()->check_administrator)
                                            @php
                                                $user_notif = auth()
                                                    ->user()
                                                    ->Notifications->sortByDesc('created_at');
                                            @endphp
                                            @foreach ($user_notif as $notif)
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack py-4 border-bottom"
                                                    id="item-{{ $notif->id_notification }}">
                                                    <!--begin::Section-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-35px me-4">
                                                            <span class="symbol-label bg-light-primary">
                                                                @if (str_contains($notif->message, 'ganti password'))
                                                                    <i class="bi bi-key-fill fs-2" id="icon-notif"
                                                                        style="color: rgb(223, 155, 28)"></i>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        @php
                                                            $is_msg_contain_user_name = str_contains($notif->message, '<b>' . auth()->user()->name . '</b>');
                                                            $msg = $notif->is_rejected ? 'Request ganti password ditolak oleh <b>Anda</b>' : 'Request ganti password sudah disetujui oleh <b>Anda</b>';
                                                            // dd($is_msg_contain_user_name);
                                                        @endphp
                                                        <!--begin::Title-->
                                                        <div class="mb-0 me-2">
                                                            <a href="/user/view/{{ $notif->FromUser->id }}"
                                                                class="fs-6 text-gray-800 text-hover-primary fw-bolder"
                                                                id="title-notif">{{ $notif->FromUser->name }}</a>
                                                            <div class="text-gray-400 fs-7" id="msg-notif">
                                                                @if ($is_msg_contain_user_name)
                                                                    {!! $msg !!}
                                                                @else
                                                                    {!! $notif->message !!}
                                                                @endif
                                                            </div>
                                                            <br>

                                                            @if ($notif->is_rejected)
                                                                <button type="button"
                                                                    class="btn btn-sm btn-secondary disabled">Sudah
                                                                    tidak
                                                                    disetujui</button>
                                                            @elseif($notif->is_approved)
                                                                <button type="button"
                                                                    class="btn btn-sm btn-secondary disabled">Sudah
                                                                    disetujui</button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-sm btn-light btn-active-primary"
                                                                    data-parent-item="{{ $notif->id_notification }}"
                                                                    onclick="resetPasswordAuthorize(this, true)">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-active-primary text-white"
                                                                    data-parent-item="{{ $notif->id_notification }}"
                                                                    onclick="resetPasswordAuthorize(this)"
                                                                    style="background-color: #008CB4;">Authorize</button>
                                                            @endif
                                                        </div>
                                                        <!--end::Title-->

                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Label-->
                                                    @php
                                                        $date_now = date_create('now');
                                                        $date_notif = date_create($notif->created_at);
                                                        $date_differ = date_diff($date_now, $date_notif);
                                                        // dd($date_differ);
                                                    @endphp

                                                    @if ($date_differ->y != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->y }} yr</span>
                                                    @elseif($date_differ->m != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->m }} mo</span>
                                                    @elseif($date_differ->d != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->d }} day</span>
                                                    @elseif($date_differ->h != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->h }} hr</span>
                                                    @elseif($date_differ->i != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->i }} min</span>
                                                    @elseif($date_differ->s != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->s }} sec</span>
                                                    @else
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">now</span>
                                                    @endif
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                            @endforeach
                                        @else
                                            @php
                                                $user_notif = auth()
                                                    ->user()
                                                    ->Notifications->sortByDesc('created_at');
                                            @endphp
                                            @foreach ($user_notif as $notif)
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack py-4 border-bottom"
                                                    id="item-{{ $notif->from_id_user }}">
                                                    <!--begin::Section-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-35px me-4">
                                                            <span class="symbol-label bg-light-primary">
                                                                @if (str_contains($notif->message, 'ganti password'))
                                                                    <i class="bi bi-key-fill fs-2" id="icon-notif"
                                                                        style="color: rgb(223, 155, 28)"></i>
                                                                @elseif(str_contains($notif->message, 'Lock Forecast'))
                                                                    <i class="bi bi-lock-fill fs-2" id="icon-notif"
                                                                        style="color: rgb(223, 155, 28)"></i>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Title-->

                                                        <div class="mb-0 me-2">
                                                            <a href="#"
                                                                class="fs-6 text-gray-800 text-hover-primary fw-bolder"
                                                                id="title-notif">{{ $notif->FromUser->name }}</a>
                                                            <div class="text-gray-400 fs-7" id="msg-notif">
                                                                {!! $notif->message !!}
                                                            </div>
                                                            <br>
                                                            @if (!empty($notif->token_reset_password) && !$notif->is_rejected)
                                                                <form action="/user/password/reset/new"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id-notification"
                                                                        value="{{ $notif->id_notification }}">
                                                                    <button type="submit" name="reset-password"
                                                                        class="btn btn-sm btn-active-primary text-white"
                                                                        style="background-color: #008CB4;">Buat
                                                                        password baru</button>
                                                                </form>
                                                            @elseif(empty($notif->token_reset_password) && $notif->is_rejected)
                                                                {{-- !MAKE THIS EMPTY --}}
                                                            @elseif(empty($notif->token_reset_password) && $notif->is_rejected && $notif->is_approved)
                                                                @php
                                                                    $from_user = $notif->FromUser;
                                                                    $to_user = $notif->ToUser;
                                                                    $next_user = explode(",", $notif->next_user)[0];

                                                                @endphp
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-light btn-active-primary"
                                                                            data-parent-item="${data.id_notification}"
                                                                            onclick="lockUnlockForecast(this, true, {{ $to_user->id }}, {{ $from_user->id }})">Reject</button>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-active-primary text-white"
                                                                            data-parent-item="${data.id_notification}"
                                                                            onclick="lockUnlockForecast(this, false, {{ $next_user}}, {{ $to_user }})"
                                                                            style="background-color: #008CB4;">Accept</button>
                                                                    </div>
                                                                    <!--end::Title-->
                                                            
                                                            @else
                                                                <button type="button" name="reset-password"
                                                                    class="btn btn-sm btn-secondary text-dark disabled">Request
                                                                    sudah terpakai</button>
                                                            @endif
                                                        </div>
                                                        <!--end::Title-->

                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Label-->
                                                    @php
                                                        $date_now = date_create('now');
                                                        $date_notif = date_create($notif->created_at);
                                                        $date_differ = date_diff($date_now, $date_notif);
                                                        // dd($date_differ);
                                                    @endphp

                                                    @if ($date_differ->y != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->y }} yr</span>
                                                    @elseif($date_differ->m != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->m }} mo</span>
                                                    @elseif($date_differ->d != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->d }} day</span>
                                                    @elseif($date_differ->h != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->h }} hr</span>
                                                    @elseif($date_differ->i != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->i }} min</span>
                                                    @elseif($date_differ->s != 0)
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">{{ $date_differ->s }} sec</span>
                                                    @else
                                                        <span class="badge badge-light fs-8"
                                                            id="timestamp-notif">now</span>
                                                    @endif
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                            @endforeach
                                        @endif
                                    </div>
                                    <!--end::Items-->

                                </div>
                                <!--end::Tab panel-->


                            </div>
                            <!--end::Tab content-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Notifications-->


                    <!--begin::User-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        @auth
                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                                data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                Hi,<strong> {{ auth()->user()->name }}&nbsp;</strong>
                                {{-- <img src="/media/avatars/User-Icon.png" alt="user" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" />
                                    &nbsp; --}}
                                <div class="d-inline-flex justify-content-center align-self-center"
                                    style="background-color:#0db0d9; width: 35px; height: 35px; border-radius: 50%;"
                                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <a
                                        class="d-flex justify-content-center align-self-center text-white text-uppercase font-weight-bold">{{ mb_substr(auth()->user()->name, 0, 1) }}</a>
                                </div>
                                <ul class="dropdown-menu pt-6" aria-labelledby="dropdownMenuButton1">
                                    <a href="/logout" class="btn btn-sm dropdown-item rounded-0 mb-3">Logout</a>
                                    {{-- <form action="/logout" method="post" class="form" id="kt_sign_in_form">
                                        @csrf
                                        <button type="submit" class="btn btn-active-primary dropdown-item rounded-0">Logout</button>
                                    </form> --}}
                                </ul>
                            </div>
                            {{-- @else
                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                                data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                Hi,<strong> Tes Login &nbsp;</strong>
                                <img src="/media/avatars/User-Icon.png" alt="user" class="dropdown-toggle"
                                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false" />
                                &nbsp;
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="/">Login</a>
                                    </li>
                                </ul>
                            </div> --}}

                        @endauth

                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::User -->



                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->