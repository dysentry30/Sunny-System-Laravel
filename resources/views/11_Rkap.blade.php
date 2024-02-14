{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Group RKAP')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')


    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->


                <!--begin::Delete Alert -->
                {{-- <div class="alert alert-success" role="alert">
						Delete Success !
					</div> --}}
                <!--end::Delete Alert -->

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
                                <h1 class="d-flex align-items-center fs-3 my-1">Group RKAP
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            {{-- @if (auth()->user()->check_administrator)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 7px 30px 7px 30px">
                                        New</a>

                                    <!--begin::Wrapper-->
                                    <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6155ac804a1c2">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bolder">Choose actions:</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="">
                                                <!--begin::Item-->
                                                <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_import"  id="kt_toolbar_import">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                                </button>
                                                <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_export"  id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                                </button>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Wrapper-->


                                </div>
                                <!--end::Actions-->
                            @endif --}}
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Card title-->
                                <div class="card-title">

                                    <!--Begin:: BUTTON FILTER-->
                                    <form action="" class="d-flex flex-row w-auto" method="get">
                                        <!--begin::Select Options-->
                                        <div style="" id="filterTahun" class="d-flex align-items-center">
                                            <select id="tahun-proyek" name="tahun-proyek"
                                                class="form-select form-select-solid"
                                                data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                                tabindex="-1" aria-hidden="true">
                                                @php
                                                    $startYear = 2020;
                                                    $currentYear = date('Y');
                                                    $diffYear = $currentYear - $startYear;
                                                @endphp
                                                <option value=""></option>
                                                @foreach (range(1,$diffYear+2) as $thn)
                                                    <option value="{{ $startYear }}"
                                                        {{ $filterTahun == $startYear ? 'selected' : '' }}>{{ $startYear }}
                                                    </option>
                                                @php
                                                    $startYear++;
                                                @endphp
                                                @endforeach
                                                {{-- @foreach ($tahunProyek as $tahun)
                                                    <option value="{{ $tahun }}"
                                                        {{ $filterTahun == $tahun ? 'selected' : '' }}>{{ $tahun }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Select Options-->

                                        <!--begin:: Filter-->
                                        <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                            id="kt_toolbar_primary_button">
                                            Filter</button>
                                        <!--end:: Filter-->

                                        <!--begin:: RESET-->
                                        <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                            onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>

                                        <script>
                                            function resetFilter() {
                                                window.location.href = "/rkap";
                                            }
                                        </script>
                                    </form>
                                    <!--end:: BUTTON FILTER-->
                                </div>
                                <!--begin::Card title-->
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body py-10">
                            @if (Auth::user()->canany(['super-admin', 'admin-crm']))
                            @php
                                $total_nilai_rkap = 0;
                            @endphp
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-auto">@sortablelink('unit_kerja', 'Unit Kerja')</th>
                                            <th class="min-w-auto text-center">Tahun Pelaksanaan</th>
                                            <th class="min-w-auto text-center">Total OK Awal</th>
                                            <th class="min-w-auto text-center">Total OK Review</th>
                                            <th class="min-w-auto text-center">@sortablelink('is_active', 'Is Locked')</th>
                                            {{-- <th class="text-center">Action</th>
                                        <th class="text-center">Settings</th> --}}
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @foreach ($proyeks as $divisi => $proyek)
                                        @php
                                            $nama_unit_kerja = \App\Models\UnitKerja::where('divcode', $divisi)?->first()?->unit_kerja;
                                            $historyRkap = \App\Models\HistoryRKAP::where('unit_kerja', $nama_unit_kerja)->where('tahun_pelaksanaan', $filterTahun)?->first()?->is_locked == true;
                                            $nilai_rkap_perproyek = 0;
                                            $nilai_rkap = $proyek->each(function($p) use($filterTahun, &$nilai_rkap_perproyek){
                                                if ($p->tipe_proyek != "R") {
                                                    $nilai_rkap_perproyek += $p->nilai_rkap;
                                                }else{
                                                    $nilai_rkap_perproyek += $p->Forecasts->sum(function($f) use($filterTahun){
                                                        if ($f->periode_prognosa == 1 && $f->tahun == $filterTahun) {
                                                            return $f->rkap_forecast;
                                                        }
                                                    });
                                                }
                                            });
                                            $total_nilai_rkap += $nilai_rkap_perproyek;
                                        @endphp
                                        {{-- @dump($nilai_rkap_perproyek) --}}
                                            <tr>
                                                <td class="min-w-auto">
                                                    <a href="/rkap/{{ $proyek->first()->unit_kerja }}/{{ $filterTahun }}" target="_blank" class="text-gray-600 text-hover-primary mb-1">{{ $nama_unit_kerja }}</a>
                                                </td>
                                                <td class="min-w-auto text-center">{{ $filterTahun }}</td>
                                                {{-- <td class="min-w-auto text-end">{{ number_format((int) str_replace('.', '', $proyek->sum('nilai_rkap')), 0, '.', '.') }} --}}
                                                <td class="min-w-auto text-end">{{ number_format($nilai_rkap_perproyek, 0, '.', '.') }}
                                                </td>
                                                <td class="min-w-auto text-end">{{ number_format((int) str_replace('.', '', $proyek->sum('nilaiok_review')), 0, '.', '.') }}
                                                </td>
                                                <td class="min-w-auto text-center">
                                                    @if (!empty($historyRkap) && $historyRkap)
                                                        <button type="button" id="btnLocked" class="btn btn-sm btn-danger" onclick="lockedRKAPDivisi('{{ $divisi }}', '{{ $filterTahun }}', false)">Unlock</button>
                                                    @else
                                                        <button type="button" id="btnLocked" class="btn btn-sm btn-primary" onclick="lockedRKAPDivisi('{{ $divisi }}', '{{ $filterTahun }}', true)">Lock</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="bg-dark text-white"><b class="px-4">Total</b></td>
                                            <td class="text-end bg-dark text-white">{{ number_format((int) $total_nilai_rkap, 0, '.', '.') }}</td>
                                            <td class="text-end bg-dark text-white">{{ number_format((int) str_replace('.', '', $totalOkReview), 0, '.', '.') }}</td>
                                            <td class=""></td>
                                        </tr>
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->

                                <script>
                                    function lockedRKAPDivisi(divisi, tahun_pelaksanaan, is_locked) {
                                        let url
                                        let text
                                        if (is_locked) {
                                            url = '/rkap/locked';
                                            text = 'Lock';
                                        } else {
                                            url = '/rkap/unlocked';
                                            text = 'Unlock';
                                        }
                                        Swal.fire({
                                            title: 'Apakah anda yakin?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#008CB4',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: text
                                        }).then(async (result) => {
                                            if (result.isConfirmed) {
                                                try {
                                                    const formData = new FormData();
                                                    formData.append('_token', '{{ csrf_token() }}');
                                                    formData.append('divisi', divisi);
                                                    formData.append('tahun_pelaksanaan', tahun_pelaksanaan);

                                                    const response = await fetch(url, {
                                                        method:'POST',
                                                        header:'application/json',
                                                        body:formData
                                                    }).then(res => res.json());

                                                    if (response.Success != true) {
                                                        return Swal.fire({
                                                            icon: 'error',
                                                            title: response.Message
                                                        }).then(res => window.location.reload())
                                                    }
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: response.Message
                                                    }).then(res => window.location.reload())
                                                } catch (error) {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: error
                                                    }).then(res => window.location.reload())
                                                }
                                            }
                                        })

                                    }
                                </script>
                            @endif


                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->


                </div>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
@endsection

@section('js-script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    </script>
@endsection
