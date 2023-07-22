<!--begin::Aside-->
@if (auth()->user())
    @if (!str_contains(Request::path(), "document/view"))
    @php
    $adminPIC = str_contains(auth()->user()->name, "(PIC)");
    @endphp


        <div id="kt_aside" class="aside aside-dark" data-kt-drawer="true" data-kt-drawer-name="aside"
            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="background-color:#0db0d9; z-index: 300">
            <!--begin::Brand-->
            <div class="aside-logo flex-column-auto" id="kt_aside_logo" style="height: auto; background-color:#0db0d9;">
                <!--begin::Logo-->
                @if (auth()->user()->check_admin_kontrak)
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/logo-ccm.png" class="h-60px logo ms-6"
                            style="margin-top:30px;margin-left:-10px;" />
                    </a>
                @else
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/Logo2.png" class="h-100px logo"
                            style="margin-top:30px;margin-left:20px;" />
                    </a>
                @endif
                <!--end::Logo-->
                <!--begin::Aside toggler-->
                <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
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

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
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
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
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
                        @endif


                        @if (auth()->user()->check_administrator || auth()->user()->check_user_sales || auth()->user()->check_team_proyek)
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
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                            <div class="menu-item">
                                <a class="menu-link " href="/forecast/{{ (int) date("m") }}/{{ (int) date("Y") }}"
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
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_team_proyek)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Contract Management</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Claim Management</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">History Approval</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Document Database</span>
                                </a>
                            </div>
                        @endif
                        
                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Document Template</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || $adminPIC || auth()->user()->check_user_sales )
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Nota Rekomendasi 1</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator || $adminPIC)
                            <!--Begin::Master Data Expand-->
                            {{-- <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#008CB4;margin-top:8px;"> --}}
                            <div class="menu-item" 
                            style="{{ str_contains(Request::Path(), 'company') || 
                            str_contains(Request::Path(), 'sumber-dana') ||
                            str_contains(Request::Path(), 'dop') ||
                            str_contains(Request::Path(), 'sbu') ||
                            str_contains(Request::Path(), 'unit-kerja') ||
                            str_contains(Request::Path(), 'pasal/edit') ||
                            str_contains(Request::Path(), 'user') ||
                            str_contains(Request::Path(), 'kriteria-pasar') ||
                            str_contains(Request::Path(), 'industry-attractivness') ||
                            str_contains(Request::Path(), 'industry-sector') ||
                            str_contains(Request::Path(), 'kriteria-green-line') ||
                            str_contains(Request::Path(), 'kriteria-assessment') ||
                            str_contains(Request::Path(), 'jabatan') ||
                            str_contains(Request::Path(), 'piutang') ||
                            str_contains(Request::Path(), 'divisi') ||
                            str_contains(Request::Path(), 'pegawai') ||
                            str_contains(Request::Path(), 'direktorat') ||
                            str_contains(Request::Path(), 'departemen') ||
                            str_contains(Request::Path(), 'matriks-approval-rekomendasi') ||
                            str_contains(Request::Path(), 'provinsi') ||
                            // str_contains(Request::Path(), 'instansi') ||
                            str_contains(Request::Path(), 'team-proyek') ? 'background-color:#008CB4' : '' }}">

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
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'company' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/company" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-building text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Company</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'sumber-dana' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/sumber-dana" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-wallet text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Sumber Dana</span>
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
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">DOP</span>
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
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">SBU</span>
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
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Unit Kerja</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-pasar' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/kriteria-pasar" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-sort-up text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria Pasar</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @if (!auth()->user()->check_user_sales)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'pasal/edit' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/pasal/edit" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-stack text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Pasal</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif
                                    @if (auth()->user()->check_administrator || $adminPIC)
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'user' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/user" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-people-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Users Management</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endif
                                    @if (auth()->user()->check_administrator || $adminPIC)
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'pegawai' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/pegawai" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-person-fill-gear text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Pegawai</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endif
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'mata-uang' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/mata-uang" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-cash-stack text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Mata Uang</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'jenis-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/jenis-proyek" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-gear-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Jenis Proyek</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'tipe-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/tipe-proyek" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-gear-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Tipe Proyek</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @if (!auth()->user()->check_user_sales)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'team-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/team-proyek" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-person-lines-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Team Proyek</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (!auth()->user()->check_user_sales)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'industry-attractivness' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/industry-attractivness" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-building text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Industri Attractiveness</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'provinsi' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/provinsi" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-geo-alt-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Provinsi</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'industry-sector' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/industry-sector" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-buildings-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Industry Sector</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'language' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/language" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-translate text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Language</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-green-line' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/kriteria-green-line" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-award-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria Green Line</span>
                                        </a>
                                    </div>
                                    @endif
                                    
                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-assessment' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/kriteria-assessment" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-award-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria Assessment</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif
                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'jabatan' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/jabatan" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-bezier text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Jabatan</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif
                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'matriks-approval-rekomendasi' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/matriks-approval-rekomendasi" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-person-fill-lock text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Matriks Approval Rekomendasi</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'piutang' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/piutang" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}                                                    
                                                <i class="bi bi-wallet-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Piutang</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'divisi' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/divisi" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}                                                    
                                                <i class="bi bi-wallet-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Divisi</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'direktorat' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/direktorat" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}                                                    
                                                <i class="bi bi-wallet-fill text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Direktorat</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif

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

                                    @if (auth()->user()->check_administrator)
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
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Departemen</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    @endif
                                </div>
                                <!--end::Colapse-->
                                <!--end::Svg Icon-->
                                </span>
                                </a>
                            </div>
                            {{-- </div> --}}
                            <!--end::Master Data Expand-->
                        @endif

                        @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
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
                        @endif
                        
                        @if (auth()->user()->check_administrator)
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
                        @endif

                        @if (auth()->user()->check_administrator)
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
                        @endif

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

                        @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
                            <div class="menu-item">
                                <a class="menu-link " href="/knowledge-base"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'knowledge-base') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/knowledge_base.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Knowledge Base</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Change Request</span>
                                </a>
                            </div>
                        @endif

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

                        @if (auth()->user()->check_administrator || $adminPIC)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">History Autorisasi</span>
                                </a>
                            </div>
                        @endif

                        @if (auth()->user()->check_administrator)
                            <div class="menu-item">
                                <a class="menu-link " href="/csi"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'csi') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-rulers text-white"
                                                style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">CSI</span>
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
    @endif
@endif
<!--end::Aside-->