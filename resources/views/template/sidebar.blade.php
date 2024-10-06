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
                   
                    @php
                        $userMenus = Auth::user()->UserMenuManagement;
                        
                        if ($userMenus->isNotEmpty()) {
                            $menuMap = $userMenus->whereNotIn("aplikasi", ["MOBILE"])->map(function($item){
                                return $item->MasterMenu;
                            });

                            $menusGroup = $menuMap->groupBy("kode_parrent")->sortBy("urutan");
                        }
                    @endphp
                    <!--begin::Menu-->
                    <div id="#kt_aside_menu" data-kt-menu="true" style="background-color:#0db0d9;">
                        
                        @foreach ($menusGroup as $key => $menus)
                            @if (empty($key))
                                @foreach ($menus->unique()?->sortBy("urutan")?->values() as $menu)
                                    {{-- @can('access-menu-read', $menu->kode_menu) --}}
                                        @if (!empty($menu->path))
                                            <div class="menu-item">
                                                <a class="menu-link " href="{{ $menu->path }}"
                                                    style="color:white; padding-left:20px; padding-top:10px; {{ Request::Segment(1) == substr($menu->path, 1) ? 'background-color:#008CB4' : '' }}">
                                                    <span class="menu-icon">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            {!! $menu->icon !!}
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <span class="menu-title" style="font-size: 16px; padding-left: 10px">{{ $menu->nama_menu }}</span>
                                                </a>
                                            </div>
                                        @endif                                        
                                    {{-- @endcan --}}
                                @endforeach
                            @else
                                @php
                                    $parentMenu = \App\Models\MasterMenu::where("kode_menu", $key)->first();
                                @endphp
                                <div class="menu-item" style="{{ $menus->contains(Request::Segment(1)) ? 'background-color:#008CB4' : '' }}">
                                    <a class="menu-link" id="collapse-button" style="color:white; padding-left:20px;"
                                        data-bs-toggle="collapse" href="#collapseExample{{ $parentMenu->kode_menu }}" role="button"
                                        aria-expanded="false" aria-controls="collapseExample{{ $parentMenu->kode_menu }}">
                                        <span class="menu-icon">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                {!! $parentMenu->icon !!}
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px"> {{ $parentMenu->nama_menu }} <i class="bi bi-caret-down-fill text-white"></i></span>
                                    </a>

                                    <div class="collapse" id="collapseExample{{ $parentMenu->kode_menu }}">
                                        @foreach ($menus->unique()?->sortBy("urutan")?->values() as $menuChild)
                                            {{-- @can('access-menu-read', $menuChild->kode_menu) --}}
                                                <!--begin::Menu Colapse-->
                                                <div id="#kt_aside_menu" data-kt-menu="true"
                                                    style="background-color:#0ca1c6; padding:8px 0px 8px 40px; {{ str_contains($menuChild, Request::Path()) ? 'background-color:#008CB4' : '' }}">
                                                    <a class="menu-link " href="{{ $menuChild->path }}" style="color:white; padding-left:20px;">
                                                        <span class="menu-icon">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                            {!! $menuChild->icon !!}
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        <span class="menu-title" style="font-size: 16px; padding-left: 10px">{{ $menuChild->nama_menu }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu Colapse-->                                                                                            
                                            {{-- @endcan --}}
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach

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