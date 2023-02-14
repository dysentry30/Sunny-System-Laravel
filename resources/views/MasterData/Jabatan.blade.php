{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Jabatan')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <!-- begin::DataTables -->
    <link rel="stylesheet" href="datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatables/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <!-- end::DataTables -->


    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Jabatan
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" onclick="getJabatan(this)" class="btn btn-sm p-5 btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Get Jabatan</a>

                                </div>
                                <!--end::Actions-->
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 py-2">
                            <!--begin::Card title-->
                            <div class="card-title">

                                {{-- <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option {{ $column == '' ? 'selected' : '' }}></option>
                                        <option value="mata_uang" {{ $column == 'mata_uang' ? 'selected' : '' }}>Jenis Proyek</option>

                                    </select>
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="filter"
                                            name="filter" value="{{ $filter }}"
                                            class="form-control form-control-solid ms-2 ps-12 w-auto"
                                            placeholder="Input Filter" />
                                    </div>
                                    <!--end:: Input Filter-->

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
                                            $("#column").select2({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");

                                            $("#filter").text({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER--> --}}

                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">

                            <div id="loading" style="display: none">
                                <div class="position-absolute top-50 start-50 h-100 w-100 translate-middle bg-gray-900 z-index-3 opacity-50">
                                    <div class="text-center" style="position: relative; top: 50%;">
                                        <div class="spinner-border fs-1 w-50px h-50px text-white"  role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div><br>
                                        <span class="text-white">Memuat data...</span>
                                    </div>
                                </div>
                            </div>

                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">No</th>
                                        <th class="min-w-auto">Nama Jabatan</th>
                                        <th class="min-w-auto">Unit Kerja</th>
                                        <th class="min-w-auto">Tahun</th>
                                        <th class="min-w-auto">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    // $companies = $companies->reverse();
                                    $no = 1;
                                @endphp
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($jabatans as $no => $jabatan)
                                        @php
                                            if($jabatan->unit_kerja) {
                                                $unit_kerjas = collect(explode(",", $jabatan->unit_kerja));
                                                $unit_kerjas = $unit_kerjas->map(function($unit_kerja) {
                                                    return "<b>" . App\Models\UnitKerja::find($unit_kerja)->unit_kerja . "</b>";
                                                })->join(", ", " dan ");
                                            } else {
                                                $unit_kerjas = "-";
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $jabatan->nama_jabatan }}</td>
                                            <td>{!! $unit_kerjas !!}</td>
                                            <td>{{ $jabatan->tahun }}</td>
                                            <td>
                                                <a href="#kt_modal_edit_{{$jabatan->id_jabatans}}" class="btn btn-sm btn-secondary" data-bs-toggle="modal">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->



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
            
            <!--begin::Modal-->
            @foreach ($jabatans as $no => $jabatan)
            <div class="modal fade" id="kt_modal_edit_{{$jabatan->id_jabatans}}" tabindex="-1" aria-labelledby="kt_modal_edit_{{$jabatan->id_jabatans}}" aria-hidden="true">
                <form action="/jabatan/save" method="POST">
                    @csrf
                    <input type="hidden" value="{{$jabatan->id_jabatans}}" name="id-jabatan">
                    <input type="hidden" value="kt_modal_edit_{{$jabatan->id_jabatans}}" name="modal">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="kt_modal_edit_{{$jabatan->id_jabatans}}">Edit Jabatan</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <label for="nama-jabatan" class="required">Nama Jabatan</label>
                                    <input type="text" name="nama-jabatan" class="form-control form-control-solid" id="nama-jabatan" value="{{$jabatan->nama_jabatan}}" placeholder="E.g Direksi">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col" id="list-dop">
                                    @php
                                        $list_unit_kerja = str_contains($jabatan->unit_kerja, ',') ? collect(explode(',', $jabatan->unit_kerja)) : $jabatan->unit_kerja;
                                        // dd($list_unit_kerja);
                                    @endphp
                                    @foreach ($dops as $dop)
                                        <div
                                            class="d-flex justify-content-between align-items-center">
                                            <p><b>{{ $dop->dop }}</b></p>
                                            <button type="button"
                                                onclick="selectAllUnitKerja(this)"
                                                data-dop="{{ $dop->dop }}"
                                                class="btn btn-link btn-sm">Select
                                                all</button>
                                        </div>
                                        <div class=""
                                            style="display: grid; grid-template-rows: repeat(1, 1fr); grid-template-columns: repeat(5, 1fr); row-gap: 1rem;">
                                            @php
                                                $dop->UnitKerjas = $dop->UnitKerjas->whereNotIn('divcode', ['B', 'C', 'D', '8']);
                                            @endphp
                                            @foreach ($dop->UnitKerjas as $unit_kerja)
                                                <div
                                                    class="form-check me-3 d-flex align-items-center">
                                                    @php
                                                        // dd($list_unit_kerja);
                                                        $is_unit_kerja_choosen = $list_unit_kerja instanceof \Illuminate\Support\Collection ? $list_unit_kerja->contains($unit_kerja->divcode) : $list_unit_kerja == $unit_kerja->divcode;
                                                        // dd($is_unit_kerja_choosen);
                                                    @endphp
                                                    @if ($is_unit_kerja_choosen)
                                                        <input
                                                            class="form-check-input me-2"
                                                            style="width: 1.5rem;height: 1.5rem;border-radius:3px;"
                                                            type="checkbox"
                                                            data-dop="{{ $dop->dop }}"
                                                            value="{{ $unit_kerja->divcode }}"
                                                            checked name="unit-kerja[]"
                                                            id="{{ $unit_kerja->divcode }}">
                                                    @else
                                                        <input
                                                            class="form-check-input me-2"
                                                            style="width: 1.5rem;height: 1.5rem;border-radius:3px;"
                                                            type="checkbox"
                                                            data-dop="{{ $dop->dop }}"
                                                            value="{{ $unit_kerja->divcode }}"
                                                            name="unit-kerja[]"
                                                            id="{{ $unit_kerja->divcode }}">
                                                    @endif
                                                    <label class="form-check-label"
                                                        for="{{ $unit_kerja->divcode }}">
                                                        <small>{{ $unit_kerja->unit_kerja }}</small>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="tahun" class="required">Tahun</label>
                                    <input type="text" name="tahun" class="form-control form-control-solid" id="tahun" value="{{$jabatan->tahun}}" placeholder="E.g 2023">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
            @endforeach
            <!--end::Modal-->

        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    
    <script>
        const datatable = $('#example').DataTable({
            stateSave: true,
            pageLength: 5,
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    async function getJabatan(e) {
        e.classList.add("disabled");
        const loadingElt = document.querySelector("#loading");
        loadingElt.style.display = "";
        const getJabatanRes = await fetch("/get-jabatans").then(res => res.json());
        if(getJabatanRes.status) {
            Toast.fire({
                html: getJabatanRes.status+ " " + getJabatanRes.msg,
                icon: "error",
            });
            loadingElt.style.display = "none";
            e.classList.remove("disabled");
            return;
        }
        let html = '';
        datatable.rows().remove().draw();
        getJabatanRes.forEach((data, i) => {
            // let oddOrEven = (i + 1) % 2 == 0 ? "even" : "odd";
            // html += `
            //     <td class="sorting_1 dtfc-fixed-left">${data.name}</td>
            //     <td class="dtfc-fixed-left">${data.username}</td>
            //     <td>${data.email}</td>
            // `;
            // <tr class="${oddOrEven}">
                // </tr>
                // document.querySelector("#example tbody").innerHTML = html;
            datatable.row.add([
                data.name,
                data.username,
                data.email,
            ]);
        });
        datatable.draw(false);
        loadingElt.style.display = "none";
        e.classList.remove("disabled");
    }

    function selectAllUnitKerja(e) {
        const dop = e.getAttribute("data-dop");
        const inputCheckUnitKerjas = document.querySelectorAll(`input[data-dop="${dop}"]`);
        inputCheckUnitKerjas.forEach(input => {
            input.checked = true;
        });
    }
</script>
@endsection

<!--end::Main-->
