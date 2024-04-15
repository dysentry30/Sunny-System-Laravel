<!--begin::Aside-->
@if (auth()->user())
    @if (!str_contains(Request::path(), "document/view"))
    @php
    // $adminPIC = str_contains(auth()->user()->name, "(PIC)");
    $adminPIC = Gate::allows('admin-crm') || Gate::allows('admin-ccm');
    @endphp


        <div id="kt_aside" class="aside aside-dark" data-kt-drawer="true" data-kt-drawer-name="aside"
            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="background-color:#0db0d9; z-index: 300">
            <!--begin::Brand-->
            <div class="aside-logo flex-column-auto" id="kt_aside_logo" style="background-color:#0db0d9;">
                <!--begin::Logo-->
                {{-- @if (auth()->user()->check_admin_kontrak)
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/logo-ccm.png" class="h-60px logo ms-6"
                            style="margin-top:30px;margin-left:-10px;" />
                    </a>
                @else
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/Logo2.png" class="h-60px logo"
                            style="margin-top:30px;margin-left:-10px;" />
                    </a>
                @endif --}}

                @can('ccm')
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/logo-ccm.png" class="h-60px logo ms-6"
                            style="margin-top:30px;margin-left:-10px;" />
                    </a>
                @elsecan('ccm')
                    <a style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/logo-wika.png" class="h-60px logo"
                            style="margin-top:30px;margin-left:-10px;" />
                    </a>
                @endcan
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

                        @canany(['super-admin', 'crm', 'ccm', 'csi'])
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

                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales)
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
                        @endif --}}
                        
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
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
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
                        @endif --}}

                        @canany(['super-admin', 'crm', 'admin-csi'])
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
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales || auth()->user()->check_team_proyek)
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
                        @endif --}}
                        @canany(['super-admin', 'crm'])
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
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
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
                        @endif --}}
                        
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Contract Management</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_team_proyek)
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
                        @endif --}}
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Change Management</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_team_proyek)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Change Management</span>
                                </a>
                            </div>
                        @endif --}}
                        
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Request For Approval</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Request For Approval</span>
                                </a>
                            </div>
                        @endif --}}
                        
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Document Database</span>
                                </a>
                            </div>
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                        @endif --}}
                        
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
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Document Template</span>
                                </a>
                            </div>                            
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
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
                        @endif --}}

                        @canany(['super-admin', 'admin-crm', 'approver-crm', 'risk-crm'])
                            @if (str_contains(Request::url(), '/rekomendasi')||
                                str_contains(Request::url(), '/green-lane') ||
                                str_contains(Request::url(), '/non-green-lane')
                            )
                                <div class="menu-item">
                                    <a class="menu-link"
                                        data-bs-toggle="collapse" href="#green-line-collapse" role="button"
                                        aria-expanded="false" aria-controls="green-line-collapse"
                                        style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/rekomendasi') ||
                                        str_contains(Request::url(), '/green-lane') ||
                                        str_contains(Request::url(), '/non-green-lane')
                                         ? 'background-color:#008CB4' : '' }}">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                    class="h-30px logo" />
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Nota Rekomendasi 1</span>
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
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Green Lane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                        style="background-color:#0ca1c6; {{ Request::Path() == 'non-green-lane' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link" href="/non-green-lane" style="color:white; padding-left:30px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-wallet text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Non Green Lane</span>
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
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Nota Rekomendasi 1</span>
                                    </a>
                                </div>
                            @endif
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || $adminPIC || auth()->user()->check_user_sales )
                            <div class="menu-item">
                                <a class="menu-link " href="/rekomendasi"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::Path(), 'rekomendasi') ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/documents.svg"
                                                class="h-30px logo" />
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Rekomendasi</span>
                                </a>
                            </div>
                        @endif --}}

                        @canany(['super-admin', 'crm'])
                            <div class="menu-item">
                                <a class="menu-link"
                                    data-bs-toggle="collapse" href="#tender-collapse" role="button"
                                    aria-expanded="false" aria-controls="tender-collapse"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/tender') ||
                                    str_contains(Request::url(), '/personel-utama') ||
                                    str_contains(Request::url(), '/alat')
                                    ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-book-half text-white" style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Tender  <i
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
                                            <i class="bi bi-person-plus-fill text-white" style="font-size: 18px; margin-left:7px"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Personel Utama</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" data-kt-menu="true"
                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'alat' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link " href="/alat" style="color:white; padding-left:20px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-tools text-white" style="font-size: 18px; margin-left:7px"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Alat</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                            </div>                            
                        @endcanany
                        {{-- @if (auth()->user()->check_administrator || $adminPIC || auth()->user()->check_user_sales )
                                <div class="menu-item">
                                    <a class="menu-link"
                                        data-bs-toggle="collapse" href="#tender-collapse" role="button"
                                        aria-expanded="false" aria-controls="tender-collapse"
                                        style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/tender') ||
                                        str_contains(Request::url(), '/personel-utama') ||
                                        str_contains(Request::url(), '/alat')
                                         ? 'background-color:#008CB4' : '' }}">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-book-half text-white" style="font-size: 18px; margin-left:7px"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">Tender  <i
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
                                                <i class="bi bi-person-plus-fill text-white" style="font-size: 18px; margin-left:7px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Personel Utama</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'alat' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/alat" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <i class="bi bi-tools text-white" style="font-size: 18px; margin-left:7px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Alat</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                </div>
                        @endif --}}

                        @canany(['super-admin', 'admin-crm'])
                        {{-- @if (auth()->user()->check_administrator || $adminPIC) --}}
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
                            str_contains(Request::Path(), 'konsultan-perencana') ||
                            str_contains(Request::Path(), 'kriteria-pengguna-jasa') ||
                            str_contains(Request::Path(), 'legalitas-perusahaan') ||
                            str_contains(Request::Path(), 'penilaian-pengguna-jasa') ||
                            str_contains(Request::Path(), 'matriks-approval-rekomendasi') ||
                            str_contains(Request::Path(), 'except-greenlane') ||
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
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">SBU Internal WIKA</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    
                                    @canany(['super-admin', 'admin-crm'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-klasifikasi-sbu' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/master-klasifikasi-sbu" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-tools text-white" style="font-size: 18px; margin-left:7px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">SBU KBLI</span>
                                        </a>
                                    </div>
                                    {{-- @endif --}}
                                    @endcanany
                                    
                                    @canany(['super-admin', 'admin-crm'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-subklasifikasi-sbu' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/master-subklasifikasi-sbu" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-tools text-white" style="font-size: 18px; margin-left:7px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Sub Klasifikasi SBU KBLI</span>
                                        </a>
                                    </div>
                                    {{-- @endif --}}
                                    @endcanany
                                    
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
                                    {{-- @if (!auth()->user()->check_user_sales) --}}
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
                                    {{-- @endif --}}
                                    @canany(['super-admin', 'admin-crm'])
                                    {{-- @if (auth()->user()->check_administrator || $adminPIC) --}}
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'user' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/user" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    <i class="bi bi-people-fill text-white"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Users</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    {{-- @endif                                         --}}
                                    @endcanany
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
                                    {{-- @if (!auth()->user()->check_user_sales) --}}
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
                                    {{-- @endif --}}

                                    {{-- @if (!auth()->user()->check_user_sales) --}}
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
                                    {{-- @endif --}}

                                    @canany(['super-admin'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
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
                                    {{-- @endif                                         --}}
                                    @endcanany

                                    @canany(['super-admin'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
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
                                    {{-- @endif                                         --}}
                                    @endcanany

                                    @canany(['super-admin'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
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
                                    {{-- @endif                                         --}}
                                    @endcanany

                                    @canany(['super-admin'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
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
                                    {{-- @endif                                         --}}
                                    @endcanany
                                    
                                    @canany(['super-admin'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
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
                                    {{-- @endif                                         --}}
                                    @endcanany
                                    
                                    @canany(['super-admin'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'except-greenlane' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/except-greenlane" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-award-fill text-white"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Except Greenlane</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    {{-- @endif                                         --}}
                                    @endcanany

                                    @canany(['super-admin', 'admin-crm'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
                                    <!--begin::Menu Colapse-->
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'konsultan-perencana' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/konsultan-perencana" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i> --}}
                                                <i class="bi bi-fingerprint text-white" style="font-size: 20px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Konsultan Perencana</span>
                                        </a>
                                    </div>
                                    <!--end::Menu Colapse-->
                                    {{-- @endif                                         --}}
                                    @endcanany

                                    @canany(['super-admin', 'admin-crm'])
                                    {{-- @if (auth()->user()->check_administrator) --}}
                                    <div id="#kt_aside_menu" data-kt-menu="true"
                                        style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'master-alat-proyek' ? 'background-color:#008CB4' : '' }}">
                                        <a class="menu-link " href="/master-alat-proyek" style="color:white; padding-left:20px;">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                <i class="bi bi-tools text-white" style="font-size: 18px; margin-left:7px"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master Alat</span>
                                        </a>
                                    </div>
                                    {{-- @endif --}}
                                    @endcanany

                                    @can('super-admin')
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
                                    @endcan

                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'kriteria-pengguna-jasa' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/kriteria-pengguna-jasa" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                    <i class="bi bi-type text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kriteria Pengguna Jasa</span>
                                            </a>
                                        </div>
                                        <!--end::Menu Colapse-->
                                    @endcan
                                    
                                    @can('super-admin')
                                        <!--begin::Menu Colapse-->
                                        <div id="#kt_aside_menu" data-kt-menu="true"
                                            style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ Request::Path() == 'legalitas-perusahaan' ? 'background-color:#008CB4' : '' }}">
                                            <a class="menu-link " href="/legalitas-perusahaan" style="color:white; padding-left:20px;">
                                                <span class="menu-icon">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                    {{-- <i class="bi bi-buildings text-white"></i>                                                     --}}
                                                    <i class="bi bi-type text-white" style="font-size: 20px"></i>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-title" style="font-size: 16px; padding-left: 10px">Legalitas Perusahaan</span>
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
                        {{-- @endif --}}
                        @endcanany

                        @canany(['super-admin', 'crm'])
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_user_sales) --}}
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
                        {{-- @endif                             --}}
                        @endcanany
                        
                        {{-- @canany(['super-admin'])
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
                        @endcanany --}}

                        {{-- @canany(['super-admin'])
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
                        @endcanany --}}

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

                        @canany(['super-admin', 'crm', 'ccm'])
                        {{-- @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak || auth()->user()->check_user_sales) --}}
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
                        {{-- @endif                             --}}
                        @endcanany
                        
                        @canany(['super-admin'])
                        {{-- @if (auth()->user()->check_administrator) --}}
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
                        {{-- @endif                             --}}
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
                            <!--begin::Menu Colapse-->
                            <div class="menu-item">
                                <a class="menu-link " href="/ska-skt" style="color:white; padding-left:20px; {{ Request::Path() == 'ska-skt' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        {{-- <i class="bi bi-buildings text-white"></i> --}}
                                        <i class="bi bi-person-lines-fill text-white" style="font-size: 20px"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">SKA SKT</span>
                                </a>
                            </div>
                            <!--end::Menu Colapse-->
                        @endcanany
                        
                        @canany(['super-admin', 'admin-crm', 'user-crm'])
                            <!--begin::Menu Colapse-->
                            <div class="menu-item">
                                <a class="menu-link " href="/competitor" style="color:white; padding-left:20px; {{ Request::Path() == 'competitor' ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        {{-- <i class="bi bi-buildings text-white"></i> --}}
                                        <i class="bi bi-building-fill-exclamation text-white" style="font-size: 20px"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Kompetitor</span>
                                </a>
                            </div>
                            <!--end::Menu Colapse-->
                        @endcanany


                        @canany(['super-admin', 'admin-crm'])
                        {{-- @if (auth()->user()->check_administrator || $adminPIC) --}}
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
                        {{-- @endif                             --}}
                        @endcanany
                        
                        @canany(['super-admin', 'csi'])
                        <div class="menu-item">
                            <a class="menu-link"
                                data-bs-toggle="collapse" href="#csi-collapse" role="button"
                                aria-expanded="false" aria-controls="csi-collapse"
                                style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/csi') ||
                                str_contains(Request::url(), '/csi/dashboard') ||
                                str_contains(Request::url(), '/csi/report') ||
                                str_contains(Request::url(), '/csi/mamster-data')
                                 ? 'background-color:#008CB4' : '' }}">
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
                                style="background-color:#0ca1c6; {{ Request::Path() == '/csi/dashboard' ? 'background-color:#008CB4' : '' }}">
                                <a class="menu-link" href="/csi/dashboard" style="color:white; padding-left:30px;">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <i class="bi bi-building text-white"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Dashboard</span>
                                </a>
                            </div>
                            <!--end::Menu Colapse-->
                            <!--begin::Menu Colapse-->
                            <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                style="background-color:#0ca1c6; {{ Request::Path() == 'csi' ? 'background-color:#008CB4' : '' }}">
                                <a class="menu-link" href="/csi" style="color:white; padding-left:30px;">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <i class="bi bi-wallet text-white"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">List CSI</span>
                                </a>
                            </div>
                            <!--end::Menu Colapse-->
                            <!--begin::Menu Colapse-->
                            <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                style="background-color:#0ca1c6; {{ Request::Path() == 'csi/report' ? 'background-color:#008CB4' : '' }}">
                                <a class="menu-link" href="/csi/report" style="color:white; padding-left:30px;">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <i class="bi bi-wallet text-white"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Report CSI</span>
                                </a>
                            </div>
                            <!--end::Menu Colapse-->
                            <!--begin::Menu Colapse-->
                            <div id="#kt_aside_menu" class="p-5" data-kt-menu="true"
                                style="background-color:#0ca1c6; {{ Request::Path() == 'csi/master-data' ? 'background-color:#008CB4' : '' }}">
                                <a class="menu-link"
                                    data-bs-toggle="collapse" href="#csi-master-collapse" role="button"
                                    aria-expanded="false" aria-controls="csi-master-collapse"
                                    style="color:white; padding-left:20px; {{ str_contains(Request::url(), '/csi/mamster-data')
                                    ? 'background-color:#008CB4' : '' }}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="bi bi-folder-fill text-white" style="font-size: 18px; margin-left:7px"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">Master Data</span>
                                    <span><i class="bi bi-caret-down-fill text-white"></i></span>
                                </a>
                            </div>
                            <div class="collapse" id="csi-master-collapse">
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" class="p-5" data-kt-menu="true" style="background-color:#0ca1c6; {{ Request::Path() == '/csi/master-data/master-pertanyaan' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" href="/csi/master-data/master-pertanyaan" style="color:white; padding-left:30px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-card-list text-white"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 12px; padding-left: 10px">Master Pertanyaan</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                                <!--begin::Menu Colapse-->
                                <div id="#kt_aside_menu" class="p-5" data-kt-menu="true" style="background-color:#0ca1c6; {{ Request::Path() == '/csi/master-data/master-tingkat-kepuasan' ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" href="/csi/master-data/master-tingkat-kepuasan" style="color:white; padding-left:30px;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-hand-thumbs-up-fill text-white"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 12px; padding-left: 10px">Master Tingkat Kepuasan</span>
                                    </a>
                                </div>
                                <!--end::Menu Colapse-->
                            </div>
                            <!--end::Menu Colapse-->
                        </div>
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