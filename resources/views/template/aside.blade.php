<!--begin::Aside-->
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
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">

            {{-- #ffa62b --}}

            <!--begin::Menu-->
            <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#0db0d9;">


                <div class="menu-item">
                    <a class="menu-link " href="/dashboard" style="color:white; {{ Request::Path() == 'dashboard' ? 'background-color:#ffa62b' : '' }}">
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


                <div class="menu-item">
                    <a class="menu-link " href="/customer" style="color:white; {{ Request::Path() == 'customer' ? 'background-color:#ffa62b' : '' }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img alt="Logo" src="/media/icons/duotune/creatio/account.svg" class="h-30px logo" />
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title-2">Pelanggan</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link " href="/project" style="color:white; {{ (Request::Path() == 'project') ? 'background-color:#ffa62b' : '' }}">
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

                <div class="menu-item">
                    <a class="menu-link " href="/forecast" style="color:white; {{ Request::Path() == 'forecast' ? 'background-color:#ffa62b' : '' }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-wallet-fill text-white" style="font-size: 18px; margin-left:7px"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title-2">Forecast</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link " href="/contract-management" style="color:white; {{ Request::Path() == 'contract-management' ? 'background-color:#ffa62b' : '' }}">
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

                <div class="menu-item">
                    <a class="menu-link " href="/claim-management" style="color:white; {{ Request::Path() == 'claim-management' ? 'background-color:#ffa62b' : '' }}">
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

                <div class="menu-item">
                    <a class="menu-link " href="/document" style="color:white; {{ Request::Path() == 'document' ? 'background-color:#ffa62b' : '' }}">
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
                


                <!--Begin::Master Data Expand-->
                    {{-- <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#0db0d9;margin-top:8px;"> --}}
                        <div class="menu-item">
                            <p>
                                <a class="menu-link" id="collapse-button" style="color:white;" data-bs-toggle="collapse"
                                    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <img alt="Logo" src="/media/icons/duotune/creatio/contract.svg"
                                                class="h-30px logo" />
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'company' ? 'background-color:#ffa62b' : '' }}">
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'sumber-dana' ? 'background-color:#ffa62b' : '' }}">
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'dop' ? 'background-color:#ffa62b' : '' }}">
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'sbu' ? 'background-color:#ffa62b' : '' }}">
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'unit-kerja' ? 'background-color:#ffa62b' : '' }}">
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'pasal/edit' ? 'background-color:#ffa62b' : '' }}">
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
                                    style="background-color:#0b89a9; padding:8px 0px 8px 40px; {{ Request::Path() == 'pic' ? 'background-color:#ffa62b' : '' }}">
                                    <a class="menu-link " href="/pic" style="color:white;">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <i class="bi bi-person-fill text-white"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title-2">PIC</span>
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


                <div class="menu-item">
                    <a class="menu-link " href="/kpi" style="color:white; {{ Request::Path() == 'kpi' ? 'background-color:#ffa62b' : '' }}">
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

                <div class="menu-item">
                    <a class="menu-link " href="/knowledge-base" style="color:white; {{ Request::Path() == 'knowledge-base' ? 'background-color:#ffa62b' : '' }}">
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

                <div class="menu-item">
                    <a class="menu-link " href="/change-request" style="color:white; {{ Request::Path() == 'change-request' ? 'background-color:#ffa62b' : '' }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img alt="Logo" src="/media/icons/duotune/creatio/changes.svg" class="h-30px logo" />
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title-2">Change Request</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link " href="stakeholder-communication" style="color:white; {{ Request::Path() == 'stakeholder-communication' ? 'background-color:#ffa62b' : '' }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <img alt="Logo" src="/media/icons/duotune/creatio/feed.svg" class="h-30px logo" />
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title-2">Stakeholder Communication</span>
                    </a>
                </div>
                
                <br><br><br>
                
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
<!--end::Aside-->
