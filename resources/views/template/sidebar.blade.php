<!--begin::Aside-->
@if (auth()->user())
    @if (!str_contains(Request::path(), 'document/view'))
        @php
            $adminPIC = str_contains(auth()->user()->name, '(PIC)');
        @endphp


        <div id="kt_aside" class="aside aside-dark" data-kt-drawer="true" data-kt-drawer-name="aside"
            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="background-color:#0db0d9; z-index: 300">
            <!--begin::Brand-->
            <div class="aside-logo flex-column-auto" id="kt_aside_logo" style="height: auto; background-color:#0db0d9;">
                <!--begin::Logo-->
                @can('ccm')
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/logo-ccm.png" class="h-60px logo ms-6"
                            style="margin-top:30px;margin-left:-10px;" />
                    </a>
                @else
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/Logo2.png" class="h-100px logo"
                            style="margin-top:30px;margin-left:20px;" />
                    </a>
                @endcan
                <!--end::Logo-->
                <!--begin::Aside toggler-->
                <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                    data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                    data-kt-toggle-name="aside-minimize">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                    <span class="svg-icon svg-icon-1 rotate-180" style="margin-top:30px;margin-left:10px;">
                        <i class="bi bi-chevron-double-left text-white text-hover-primary" style="font-size: 18px"></i>
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> --}}
                        {{-- <path class="text-white" opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black" />
                            <path class="text-white" d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black" /> --}}
                        {{-- </svg> --}}
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Aside toggler-->
            </div>
            <!--end::Brand-->
            <!--begin::Aside menu-->
            <div class="aside-menu flex-column-fluid" style="background-color:#0db0d9;margin-top:10px;">
                <!--begin::Aside Menu-->
                <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                    data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">

                    {{-- @dump(Request::Path()) --}}

                    <!--begin::Menu-->
                    <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#0db0d9;">

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales) --}}
                        @canany(['crm', 'ccm', 'super-admin'])
                            <div class="menu-item">
                                <a class="menu-link " href="/dashboard"
                                    style="color:white; padding-left:20px; padding-top:10px; {{ str_contains(Request::Path(), 'dashboard') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/dashboards.svg"
                                                class="h-35px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Dashboard</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales) --}}
                        @canany(['super-admin', 'crm', 'admin-csi'])
                            <div class="menu-item">
                                <a class="menu-link " href="/customer"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'customer') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/account.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Pelanggan</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}


                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales || auth()->user()->check_team_proyek) --}}
                        @canany(['super-admin', 'crm', 'admin-csi', 'approver-ccm', 'ska-skt'])
                            <div class="menu-item">
                                <a class="menu-link " href="/proyek"
                                    style="color:white; padding-left:20px; {{ Request::Segment(1) == 'proyek' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/opportunity.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Proyek</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales) --}}
                        @canany(['super-admin', 'crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/forecast/{{ (int) date('m') }}/{{ (int) date('Y') }}"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'forecast') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-bar-chart-fill text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Forecast</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_team_proyek) --}}
                        @canany(['super-admin', 'ccm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/contract-management"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'contract-management') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/contract.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Contract
                                        Management</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak) --}}
                        @canany(['super-admin', 'ccm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/claim-management"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'claim-management') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/releases.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Change
                                        Management</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak) --}}
                        @canany(['super-admin', 'ccm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/history-approval"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'history-approval') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/tranzaction.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Request For
                                        Approval</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak) --}}
                        @canany(['super-admin', 'ccm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/document"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'document-database') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Document
                                        Database</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak) --}}
                        @canany(['super-admin', 'ccm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/document-template"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'document-template') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Document
                                        Template</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @endif --}}
                        @canany(['super-admin', 'approver-ccm', 'user-crm', 'admin-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/approval-terkontrak-proyek"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), 'approval-terkontrak-proyek') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Approval Proyek Terkontrak
                                        2</span>
                                </a>
                            </div>
                        @endcanany
                        @canany(['super-admin', 'admin-crm', 'approver-crm', 'risk-crm'])
                            @if (str_contains(Request::url(), '/rekomendasi') ||
                                    str_contains(Request::url(), '/green-lane') ||
                                    str_contains(Request::url(), '/non-green-lane'))
                                <div class="menu-item">
                                    <a class="menu-link" data-bs-toggle="collapse" href="#green-line-collapse"
                                        role="button" aria-expanded="false" aria-controls="green-line-collapse"
                                        style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/rekomendasi') ||
                                        str_contains(Request::url(), '/green-lane') ||
                                        str_contains(Request::url(), '/non-green-lane')
                                            ? 'background-color:#008CB4'
                                            : '' }}">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                    class="h-30px logo" />
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Nota
                                            Rekomendasi 1</span>
                                        <span><i class="bi bi-caret-down-fill text-white"></i></span>
                                    </a>
                                </div>
                                <div class="collapse" id="green-line-collapse">
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                        style="background-color:#0ca1c6; {{ Request::Path() == 'green-lane' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link" href="/green-lane" style="color:white; padding-left:30px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-building text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Green
                                                Lane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                        style="background-color:#0ca1c6; {{ Request::Path() == 'non-green-lane' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link" href="/non-green-lane"
                                            style="color:white; padding-left:30px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-wallet text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Non Green
                                                Lane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                </div>
                            @else
                                <div class="menu-item">
                                    <a class="menu-link " href="/rekomendasi"
                                        style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/rekomendasi') ? 'background-color:#008CB4' : '' }}">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                    class="h-30px logo" />
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Nota
                                            Rekomendasi 1</span>
                                    </a>
                                </div>
                            @endif
                        @endcanany

                        @canany(['super-admin', 'approver-crm', 'user-crm', 'risk-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/nota-rekomendasi-2"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), 'nota-rekomendasi-2') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Nota Rekomendasi
                                        2</span>
                                </a>
                            </div>
                        @endcanany
                        
                        @canany(['super-admin', 'approver-crm', 'user-crm', 'risk-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/verifikasi-internal-partner"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), 'verifikasi-internal-partner') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Verifikasi Internal Penentuan Proyek KSO / Non KSO</span>
                                </a>
                            </div>
                        @endcanany

                        @canany(['super-admin', 'approver-crm', 'user-crm', 'risk-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/verifikasi-internal-persetujuan-partner"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), 'verifikasi-internal-persetujuan-partner') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)</span>
                                </a>
                            </div>
                        @endcanany

                        @canany(['super-admin', 'approver-crm', 'user-crm', 'risk-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/verifikasi-proyek-nota-2"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), 'verifikasi-proyek-nota-2') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Verifikasi Internal Proyek Greenlane/Non Greenlane</span>
                                </a>
                            </div>
                        @endcanany

                        @canany(['super-admin', 'admin-crm', 'user-crm', 'approver-crm'])
                            <div class="menu-item">
                                <a class="menu-link" data-bs-toggle="collapse" href="#tender-collapse" role="button"
                                    aria-expanded="false" aria-controls="tender-collapse"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/tender') ||
                                    str_contains(Request::url(), '/personel-utama') ||
                                    str_contains(Request::url(), '/alat')
                                        ? 'background-color:#008CB4'
                                        : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-book-half text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Tender <i
                                            class="bi bi-caret-down-fill text-white"></i></span>
                                </a>
                            </div>
                            <div class="collapse" id="tender-collapse">
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'personel-utama' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link " href="/personel-utama" style="color:white; padding-left:20px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-person-plus-fill text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Personel
                                            Utama</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'alat' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link " href="/alat" style="color:white; padding-left:20px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-tools text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Alat</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                            </div>
                        @endcanany

                        @canany(['super-admin', 'admin-crm', 'risk-crm'])
                            <!--Begin::Master Data Expand-->
                            <div class="menu-item"
                                style="{{ str_contains(Request::Path(), 'company') ||
                                str_contains(Request::Path(), 'sumber-dana') ||
                                str_contains(Request::Path(), 'dop') ||
                                str_contains(Request::Path(), 'sbu') ||
                                str_contains(Request::Path(), 'unit-kerja') ||
                                str_contains(Request::Path(), 'pasal/edit') ||
                                str_contains(Request::Path(), 'user') ||
                                str_contains(Request::Path(), 'kriteria-pasar') ||
                                str_contains(Request::Path(), 'industry-sector') ||
                                str_contains(Request::Path(), 'jabatan') ||
                                str_contains(Request::Path(), 'divisi') ||
                                str_contains(Request::Path(), 'pegawai') ||
                                str_contains(Request::Path(), 'direktorat') ||
                                str_contains(Request::Path(), 'departemen') ||
                                str_contains(Request::Path(), 'provinsi') ||
                                str_contains(Request::Path(), 'otomasi-approval') ||
                                str_contains(Request::Path(), 'konsultan-perencana') ||
                                str_contains(Request::Path(), 'matriks-approval-proyek-terkontrak') ||
                                // str_contains(Request::Path(), 'instansi') ||
                                str_contains(Request::Path(), 'team-proyek')
                                    ? 'background-color:#008CB4'
                                    : '' }}">

                                <a class="menu-link" id="collapse-button" style="color:white; padding-left:20px;"
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master Data <i
                                            class="bi bi-caret-down-fill text-white"></i></span>
                                </a>
                                <!--begin::Colapse #0db0d9-->
                                <div class="collapse" id="collapseExample">
                                    @cannot('risk-crm')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'company' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/company" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-building text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Company</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'sumber-dana' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/sumber-dana"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-wallet text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Sumber
                                                    Dana</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'dop' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/dop" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-bar-chart text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">DOP</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'sbu' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/sbu" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-bar-chart text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">SBU</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'unit-kerja' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/unit-kerja" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-diagram-3-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Unit
                                                    Kerja</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-pasar' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/kriteria-pasar"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-sort-up text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                    Pasar</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'pasal/edit' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/pasal/edit" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-stack text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Pasal</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'user' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/user" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-people-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Users
                                                    Management</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'pegawai' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/pegawai" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-person-fill-gear text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Pegawai</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'mata-uang' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/mata-uang" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-cash-stack text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Mata
                                                    Uang</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'jenis-proyek' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/jenis-proyek"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-gear-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Jenis
                                                    Proyek</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'tipe-proyek' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/tipe-proyek"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-gear-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Tipe
                                                    Proyek</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'team-proyek' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/team-proyek"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-person-lines-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Team
                                                    Proyek</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcannot
                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'provinsi' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/provinsi" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-geo-alt-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Provinsi</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'industry-sector' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/industry-sector"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-buildings-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Industry
                                                    Sector</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'language' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/language" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-translate text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Language</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'jabatan' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/jabatan" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-bezier text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Jabatan</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'divisi' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/divisi" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-wallet-fill text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Divisi</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'direktorat' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/direktorat" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-wallet-fill text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Direktorat</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    {{-- @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'instansi' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/instansi" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <i class="bi bi-building-fill text-white" style="font-size: 20px"></i>
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Instansi</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif --}}

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'departemen' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/departemen" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                    <i class="bi bi-building-fill text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title"
                                                    style="font-size: 16px; padding-left: 10px">Departemen</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'otomasi-approval' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/otomasi-approval"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-qr-code text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Otomasi
                                                    Approval</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'role-management' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/role-management"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-fingerprint text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Role
                                                    Managements</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'konsultan-perencana' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/konsultan-perencana"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-fingerprint text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Konsultan
                                                    Perencana</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan

                                    @canany(['super-admin', 'admin-crm'])
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-alat-proyek' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/master-klasifikasi-alat"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                    <i class="bi bi-tools text-white"
                                                        style="font-size: 18px; margin-left:7px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master
                                                    Alat</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcanany

                                    @canany(['super-admin', 'admin-crm'])
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-klasifikasi-sbu' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/master-klasifikasi-sbu"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                    <i class="bi bi-tools text-white"
                                                        style="font-size: 18px; margin-left:7px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master
                                                    Klasifikasi SBU</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcanany

                                    @canany(['super-admin', 'admin-crm'])
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-subklasifikasi-sbu' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/master-subklasifikasi-sbu"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                    <i class="bi bi-tools text-white"
                                                        style="font-size: 18px; margin-left:7px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master
                                                    Sub Klasifikasi SBU</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcanany

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-proyek-terkontrak' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/matriks-approval-proyek-terkontrak"
                                                style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-fingerprint text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Materiks Approval Proyek Terkontrak</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan
                                </div>
                                <!--end::Colapse-->
                                <!--end::Svg Icon-->
                                </span>
                                </a>
                            </div>
                            {{-- </div> --}}
                            <!--end::Master Data Expand-->
                        @endcanany

                        @canany(['super-admin', 'crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/rkap"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'rkap') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-chat-left-dots-fill text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Group RKAP</span>
                                </a>
                            </div>
                        @endcanany

                        {{-- @can('super-admin')
                            <div class="menu-item">
                                <a class="menu-link " href="/ok-awal"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'ok-awal') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-cash text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">RKAP Awal</span>
                                </a>
                            </div>                            
                        @endcan --}}

                        {{-- @can('super-admin')
                            <div class="menu-item">
                                <a class="menu-link " href="/ok-review"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'ok-review') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-cash-stack text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">RKAP Review</span>
                                </a>
                            </div>                            
                        @endcan --}}

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="/kpi"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'kpi') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/bonus_rules.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">KPI</span>
                                </a>
                            </div>
                        @endif --}}

                        @canany(['super-admin', 'admin-crm', 'risk-crm'])
                            <!--Begin::Knowladge Base Expand-->
                            <div class="menu-item"
                                style="{{ 
                                Request::url() == "/knowladge-base/peraturan" ||
                                Request::url() == "/knowladge-base/company-profile" ||
                                Request::url() == "/knowladge-base/portofolio" ||
                                // str_contains(Request::Path(), 'instansi') ||
                                str_contains(Request::Path(), 'team-proyek')
                                    ? 'background-color:#008CB4'
                                    : '' }}">

                                <a class="menu-link" id="collapse-button" style="color:white; padding-left:20px;"
                                    data-bs-toggle="collapse" href="#knowladge-collaps" role="button"
                                    aria-expanded="false" aria-controls="collapseExample">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-archive-fill text-white" style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Knowladge Base <i
                                            class="bi bi-caret-down-fill text-white"></i></span>
                                </a>
                                <!--begin::Colapse #0db0d9-->
                                <div class="collapse" id="knowladge-collaps">
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::url() == '/knowladge-base/peraturan' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/knowladge-base/peraturan" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-800v241-1 400-640 200-200Zm80 400h140q9-23 22-43t30-37H280v80Zm0 160h127q-5-20-6.5-40t.5-40H280v80ZM200-80q-33 0-56.5-23.5T120-160v-640q0-33 23.5-56.5T200-880h320l240 240v100q-19-8-39-12.5t-41-6.5v-41H480v-200H200v640h241q16 24 36 44.5T521-80H200Zm460-120q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29ZM864-40 756-148q-21 14-45.5 21t-50.5 7q-75 0-127.5-52.5T480-300q0-75 52.5-127.5T660-480q75 0 127.5 52.5T840-300q0 26-7 50.5T812-204L920-96l-56 56Z"/></svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"
                                                style="font-size: 16px; padding-left: 10px">Peraturan</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::url() == '/knowladge-base/company-profile' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/knowladge-base/company-profile" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z"/></svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"
                                                style="font-size: 16px; padding-left: 10px">Company Profile</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::url() == '/knowladge-base/portofolio' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/knowladge-base/portofolio" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-280h320v-22q0-45-44-71.5T600-400q-72 0-116 26.5T440-302v22Zm160-160q33 0 56.5-23.5T680-520q0-33-23.5-56.5T600-600q-33 0-56.5 23.5T520-520q0 33 23.5 56.5T600-440ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h240l80 80h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Zm0-80h640v-400H447l-80-80H160v480Zm0 0v-480 480Z"/></svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"
                                                style="font-size: 16px; padding-left: 10px">Portofolio</span>
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
                            <!--end::Knowladge Base Expand-->
                        @endcanany

                        @canany(['super-admin', 'ccm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/change-request"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'change-request') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/changes.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Change
                                        Request</span>
                                </a>
                            </div>
                        @endcanany

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                            <div class="menu-item">
                                <a class="menu-link " href="stakeholder-communication"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'stakeholder-communication') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/feed.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Stakeholder Communication</span>
                                </a>
                            </div>
                        @endif --}}

                        @canany(['super-admin', 'admin-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/history-autorisasi"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'history-autorisasi') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/knowledge_base.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">History
                                        Autorisasi</span>
                                </a>
                            </div>
                        @endcanany

                        @canany(['super-admin', 'csi'])
                            <div class="menu-item">
                                <a class="menu-link" data-bs-toggle="collapse" href="#csi-collapse" role="button"
                                    aria-expanded="false" aria-controls="csi-collapse"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/csi') ||
                                    str_contains(Request::url(), '/csi/dashboard') ||
                                    str_contains(Request::url(), '/csi/report') ||
                                    str_contains(Request::url(), '/csi/mamster-data')
                                        ? 'background-color:#008CB4'
                                        : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-rulers text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">CSI</span>
                                    <span><i class="bi bi-caret-down-fill text-white"></i></span>
                                </a>
                            </div>
                            <div class="collapse" id="csi-collapse">
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == '/csi/dashboard' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" href="/csi/dashboard" style="color:white; padding-left:30px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-building text-white"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title"
                                            style="font-size: 16px; padding-left: 10px">Dashboard</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'csi' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" href="/csi" style="color:white; padding-left:30px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-wallet text-white"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">List
                                            CSI</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'csi/report' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" href="/csi/report" style="color:white; padding-left:30px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-wallet text-white"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Report
                                            CSI</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'csi/master-data' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" data-bs-toggle="collapse" href="#csi-master-collapse"
                                        role="button" aria-expanded="false" aria-controls="csi-master-collapse"
                                        style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/csi/mamster-data') ? 'background-color:#008CB4' : '' }}">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-folder-fill text-white"
                                                    style="font-size: 18px; margin-left:7px"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master
                                            Data</span>
                                        <span><i class="bi bi-caret-down-fill text-white"></i></span>
                                    </a>
                                </div>
                                <div class="collapse" id="csi-master-collapse">
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == '/csi/master-data/master-pertanyaan' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link" href="/csi/master-data/master-pertanyaan"
                                            style="color:white; padding-left:30px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-card-list text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 12px; padding-left: 10px">Master
                                                Pertanyaan</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == '/csi/master-data/master-tingkat-kepuasan' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link" href="/csi/master-data/master-tingkat-kepuasan"
                                            style="color:white; padding-left:30px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-hand-thumbs-up-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 12px; padding-left: 10px">Master
                                                Tingkat Kepuasan</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                </div>
                                <!--end::Menu Colapse-->
                            </div>
                        @endcanany

                        @canany(['super-admin', 'risk-crm'])
                            <div class="menu-item"
                                style="color:white; {{ Request::Path() == 'matriks-approval-rekomendasi' ||
                                Request::Path() == 'matriks-approval-rekomendasi-2' ||
                                Request::Path() == 'matriks-approval-varifikasi-proyek' ||
                                Request::Path() == 'matriks-approval-partner' ||
                                Request::Path() == 'matriks-approval-verifikasi-partner' ||
                                Request::Path() == 'matriks-approval-persetujuan-partner' ||
                                Request::Path() == 'matriks-approval-paparan' ||
                                Request::Path() == 'matriks-approval-varifikasi-internal-partner' ||
                                Request::Path() == 'matriks-approval-varifikasi-internal-persetujuan-partner' ||
                                Request::Path() == 'matriks-approval-varifikasi-proyek' ||
                                Request::Path() == 'except-greenlane' ||
                                Request::Path() == 'piutang' ||
                                Request::Path() == 'kriteria-green-line' ||
                                Request::Path() == 'kriteria-assessment' ||
                                Request::Path() == 'industry-attractivness' ||
                                Request::Path() == 'kriteria-pengguna-jasa' ||
                                Request::Path() == 'legalitas-perusahaan' ||
                                Request::Path() == 'kriteria-selection-non-greenlane' ||
                                Request::Path() == 'penilaian-pengguna-jasa' ||
                                Request::Path() == 'checklist-calon-mitra-kso' ||
                                Request::Path() == 'kriteria-penilaian-pefindo' ||
                                Request::Path() == 'kriteria-greenlane-partner' ||
                                Request::Path() == 'penilaian-partner-selection' ||
                                Request::Path() == 'penilaian-checklist-project-selection' ||
                                Request::Path() == 'master-klasifikasi-proyek' ||
                                Request::Path() == 'master-klasifikasi-omzet' ||
                                Request::Path() == 'master-klasifikasi-produksi' ||
                                Request::Path() == 'master-fortune-rank' ||
                                Request::Path() == 'master-lq-rank' ||
                                Request::Path() == 'master-masalah-hukum' ||
                                Request::Path() == 'master-pefindo' ||
                                Request::Path() == 'master-group-tier' ||
                                Request::Path() == 'matriks-approval-varifikasi-partner' ||
                                Request::Path() == 'matriks-approval-persetujuan-partner' ||
                                Request::Path() == 'matriks-approval-varifikasi-proyek'
                                    ? 'background-color:#008CB4'
                                    : '' }}">
                                <a class="menu-link" id="collapse-button" style="color:white; padding-left:20px;"
                                    data-bs-toggle="collapse" href="#manrisk-collapse" role="button"
                                    aria-expanded="false" aria-controls="collapseExample">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-building-fill-exclamation text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 14px">Risk
                                            Management <i class="bi bi-caret-down-fill text-white"></i></span>
                                </a>
                            </div>
                            <div class="collapse" id="manrisk-collapse">
                                <!--begin::Menu Colapse-->
                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-rekomendasi' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-rekomendasi" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Rekomendasi</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-rekomendasi-2' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-rekomendasi-2" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Rekomendasi 2</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan
                                <!--end::Menu Colapse-->
                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-varifikasi-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-varifikasi-proyek"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Verifikasi Proyek</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan

                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-partner' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-partner" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Assessment Partner</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan

                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-paparan' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-paparan" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Paparan</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan

                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-varifikasi-partner' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-varifikasi-partner"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Verifikasi Internal Partner</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan

                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-persetujuan-partner' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-persetujuan-partner"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Verifikasi Persetujuan Partner</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan
                               
                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-varifikasi-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/matriks-approval-varifikasi-proyek"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks
                                                Approval Verifikasi Persetujuan Project Greenlane / Non Greenlane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'except-greenlane' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/except-greenlane"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Except
                                                Greenlane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'piutang' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/piutang"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-wallet-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title"
                                                style="font-size: 16px; padding-left: 10px">Piutang</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-green-line' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/kriteria-green-line"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-award-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                Green Line</span>
                                        </a>
                                    </div>
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-assessment' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/kriteria-assessment"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-award-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                Assessment</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'industry-attractivness' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/industry-attractivness"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-building text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Industri
                                                Attractiveness</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-pengguna-jasa' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/kriteria-pengguna-jasa"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-type text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                Pengguna Jasa</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'legalitas-perusahaan' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/legalitas-perusahaan"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-type text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Legalitas
                                                Perusahaan</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-selection-non-greenlane' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/kriteria-selection-non-greenlane" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-type text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                Selection Non Greenlane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'penilaian-pengguna-jasa' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/penilaian-pengguna-jasa" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Penilaian
                                                Risiko Pengguna Jasa</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @can('super-admin')
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'checklist-calon-mitra-kso' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/checklist-calon-mitra-kso" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-fingerprint text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Checklist
                                                Calon Mitra KSO</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcan

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-penilaian-pefindo' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/kriteria-penilaian-pefindo" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                Penilaian Pefindo</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-greenlane-partner' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/kriteria-greenlane-partner" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-person-fill-add text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria
                                                Green Lane Partner</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'penilaian-partner-selection' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/penilaian-partner-selection" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Penilaian
                                                Risiko Partner Selection</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'penilaian-checklist-project-selection' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/penilaian-checklist-project-selection"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Penilaian
                                                Risiko Partner Selection</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-klasifikasi-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/master-klasifikasi-proyek" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Klasifikasi
                                                Proyek</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-klasifikasi-omzet' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/master-klasifikasi-omzet" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Klasifikasi
                                                Omzet</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-klasifikasi-produksi' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center"
                                            href="/master-klasifikasi-produksi" style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-calculator-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Klasifikasi
                                                Produksi</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-fortune-rank' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/master-fortune-rank"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-trophy-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Fortune
                                                Rank</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-lq-rank' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/master-lq-rank"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-trophy-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">LQ
                                                Rank</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-masalah-hukum' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/master-masalah-hukum"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24"
                                                    viewBox="0 -960 960 960" width="24" fill="white">
                                                    <path
                                                        d="M160-120v-80h480v80H160Zm226-194L160-540l84-86 228 226-86 86Zm254-254L414-796l86-84 226 226-86 86Zm184 408L302-682l56-56 522 522-56 56Z" />
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Masalah
                                                Hukum</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-pefindo' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/master-pefindo"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-fingerprint text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master
                                                Pefindo</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                                @canany(['super-admin', 'risk-crm'])
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-group-tier' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link d-flex flex-row align-items-center" href="/master-group-tier"
                                            style="color:white; padding-left:10px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-collection-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master Group
                                                Tier BUMN</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                @endcanany

                            </div>
                        @endcanany


                        @canany(['super-admin', 'admin-crm', 'approver-crm', 'risk-crm'])
                            <div class="menu-item">
                                <a class="menu-link " href="/assessment-partner-selection"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), 'assessment-partner-selection') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Partner
                                        Selection</span>
                                </a>
                            </div>
                        @endcanany

                        @canany(['super-admin', 'admin-crm', 'ska-skt'])
                            <!--begin::Menu Colapse-->
                            <div class="menu-item">
                                <a class="menu-link " href="/ska-skt"
                                    style="color:white; padding-left:20px; {{ Request::Path() == 'ska-skt' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <i class="bi bi-person-lines-fill text-white" style="font-size: 20px"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">SKA SKT</span>
                                </a>
                            </div>
                            <!--end::Menu Colapse-->
                        @endcanany

                        <br><br><br>

                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Aside Menu-->
            </div>
            <!--end::Aside menu-->

        </div>
    @endif
@endif
<!--end::Aside-->
