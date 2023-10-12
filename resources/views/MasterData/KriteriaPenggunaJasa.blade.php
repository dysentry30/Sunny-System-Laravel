{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Kriteria Pengguna Jasa')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Kriteria Pengguna Jasa
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a  href="#" data-bs-target="#kt_modal_create_otomasi_approval" data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah Kriteria Pengguna Jasa</a>

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

                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table-->
                            <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                        <th class="min-w-auto text-white">No.</th>
                                        <th class="min-w-auto text-white">Kategori</th>
                                        <th class="min-w-auto text-white">Item</th>
                                        <th class="min-w-auto text-white">Bobot</th>
                                        <th class="min-w-auto text-white">Kriteria 1</th>
                                        <th class="min-w-auto text-white">Kriteria 2</th>
                                        <th class="min-w-auto text-white">Kriteria 3</th>
                                        <th class="min-w-auto text-white">Kriteria 4</th>
                                        <th class="min-w-auto text-white">Nota Rekomendasi</th>
                                        <th class="min-w-auto text-white">Action</th>
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
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center align-middle">{{$no++}}</td>
                                            <td class="align-middle">{{$item->kategori}}</td>
                                            <td class="align-middle">{{$item->item}}</td>
                                            <td class="text-center align-middle">{{ $item->bobot }}</td>
                                            <td class="">{!! nl2br($item->kriteria_1) !!}</td>
                                            <td class="">{!! nl2br($item->kriteria_2) !!}</td>
                                            <td class="">{!! nl2br($item->kriteria_3) !!}</td>
                                            <td class="">{!! nl2br($item->kriteria_4) !!}</td>
                                            <td class="text-center align-middle">{{ $item->nota_rekomendasi }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" data-bs-target="#kt_modal_create_pengguna_jasa_{{$item->id }}" data-bs-toggle="modal" class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;">Edit</a>
                                                        <input type="hidden" name="id-otomasi" value="{{$item->id }}">
                                                        <button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteItem('{{ $item->id }}')">Delete</button>
                                                </div>
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
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    
    <!--begin::Modal Tambah Kriteria Green Line-->
    <div class="modal fade" id="kt_modal_create_otomasi_approval" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Kriteria Pengguna Jasa</h2>
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

                <form action="/kriteria-pengguna-jasa/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_create_otomasi_approval">
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
    
    
                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="kategori" name="kategori"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                            data-select2-id="select2-feature-kategori" tabindex="-1" aria-hidden="true" onchange="setItem(this)">
                                            <option value="" selected></option>
                                            <option value="Legalitas Perusahaan">Legalitas Perusahaan</option>
                                            <option value="Reputasi Pemberi Kerja">Reputasi Pemberi Kerja</option>
                                            <option value="Financial">Financial</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Item</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="item" name="item"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Item"
                                            data-select2-id="select2-item" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->

                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Bobot</span>
                                </label>
                                <input type="number" name="bobot" class="form-control form-control-solid">
                            </div>

                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kriteria 1</span>
                                </label>
                                <textarea name="kriteria_1" id="kriteria_1" cols="30" rows="10"></textarea>
                            </div>

                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kriteria 2</span>
                                </label>
                                <textarea name="kriteria_2" id="kriteria_2" cols="30" rows="10"></textarea>
                            </div>

                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kriteria 3</span>
                                </label>
                                <textarea name="kriteria_3" id="kriteria_3" cols="30" rows="10"></textarea>
                            </div>

                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kriteria 4</span>
                                </label>
                                <textarea name="kriteria_4" id="kriteria_4" cols="30" rows="10"></textarea>
                            </div>

                            <div class="row mb-7">
                                 <!--begin::Label-->
                                 <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Nota Rekomendasi</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="nota_rekomendasi" name="nota_rekomendasi"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                        data-select2-id="select2-feature" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="Nota Rekomendasi 1">Nota Rekomendasi 1</option>
                                        <option value="Nota Rekomendasi 2">Nota Rekomendasi 2</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--End::Row Kanan+Kiri-->    
    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>
    
                    </div>
                    <!--end::Modal body-->
                </form>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal Tambah Kriteria Green Line-->

    <!--begin::Modal Edit Kriteria Green Line-->
    @foreach ($data as $item)
        <div class="modal fade" id="kt_modal_create_pengguna_jasa_{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Kriteria Pengguna Jasa</h2>
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

                    <form action="/kriteria-pengguna-jasa/update/{{ $item->id }}" method="POST">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_create_otomasi_approval">
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
        
        
                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kategori</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="kategori" name="kategori"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                                data-select2-id="select2-feature-edit-{{ $item->id }}" tabindex="-1" aria-hidden="true" onchange="setItem(this, '{{ $item->id }}')">
                                                <option value="" selected></option>
                                                <option value="Legalitas Perusahaan" {{ $item->kategori == "Legalitas Perusahaan" ? "selected" : "" }}>Legalitas Perusahaan</option>
                                                <option value="Reputasi Pemberi Kerja" {{ $item->kategori == "Reputasi Pemberi Kerja" ? "selected" : "" }}>Reputasi Pemberi Kerja</option>
                                                <option value="Financial" {{ $item->kategori == "Financial" ? "selected" : "" }}>Financial</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->

                                <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Item</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="item-{{ $item->id }}" name="item"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Item" tabindex="-1" aria-hidden="true">
                                            @if ($item->kategori != "Financial")
                                                <option value="{{ $item->item }}" selected>{{ $item->item }}</option>
                                            @else
                                                <option value="Current Ratio" {{ $item->item == "Current Ratio" ? 'selected' : '' }}></option>
                                                <option value="Cash Ratio" {{ $item->item == "Cash Ratio" ? 'selected' : '' }}></option>
                                                <option value="Debt to Equity Ratio" {{ $item->item == "Debt to Equity Ratio" ? 'selected' : '' }}></option>
                                                <option value="Kepatuhan Pembayaran Pajak" {{ $item->item == "Kepatuhan Pembayaran Pajak" ? 'selected' : '' }}></option>
                                            @endif

                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
    
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Bobot</span>
                                    </label>
                                    <input type="number" name="bobot" value="{{ $item->bobot }}" class="form-control form-control-solid">
                                </div>
    
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kriteria 1</span>
                                    </label>
                                    <textarea name="kriteria_1" id="kriteria_1" cols="30" rows="10">{!! $item->kriteria_1 !!}</textarea>
                                </div>
    
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kriteria 2</span>
                                    </label>
                                    <textarea name="kriteria_2" id="kriteria_2" cols="30" rows="10">{!! $item->kriteria_2 !!}</textarea>
                                </div>
    
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kriteria 3</span>
                                    </label>
                                    <textarea name="kriteria_3" id="kriteria_3" cols="30" rows="10">{!! $item->kriteria_3 !!}</textarea>
                                </div>
    
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kriteria 4</span>
                                    </label>
                                    <textarea name="kriteria_4" id="kriteria_4" cols="30" rows="10">{!! $item->kriteria_4 !!}</textarea>
                                </div>
    
                                <div class="row mb-7">
                                     <!--begin::Label-->
                                     <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nota Rekomendasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="nota_rekomendasi" name="nota_rekomendasi"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                            data-select2-id="select2-feature-{{ $item->id }}-{{ $no++ }}" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Nota Rekomendasi 1" {{ $item->nota_rekomendasi == "Nota Rekomendasi 1" ? "selected" : ""}}>Nota Rekomendasi 1</option>
                                            <option value="Nota Rekomendasi 2" {{ $item->nota_rekomendasi == "Nota Rekomendasi 2" ? "selected" : ""}}>Nota Rekomendasi 2</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--End::Row Kanan+Kiri-->    
        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                                style="background-color:#008CB4">Save</button>
        
                        </div>
                        <!--end::Modal body-->
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    @endforeach
    <!--end::Modal Edit Kriteria Green Line-->

    
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    
    <script>
        $('#example').DataTable({
            stateSave: true,
            ordering: false
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    function deleteItem(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then(async (result)=>{
            if(result.isConfirmed){
                try {
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    const req = await fetch(`{{ url('/kriteria-pengguna-jasa/delete/') }}/${id}`, {
                        method: 'POST',
                        header: {
                            "content-type": "application/json",
                        },
                        body:formData
                    }).then(res => res.json());
                    if (req.Success != true) {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Data gagal dihapus!'
                        }).then(res=>window.location.reload())
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus!'
                    }).then(res=>window.location.reload())
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error
                    }).then(res=>window.location.reload())
                }
            }
        })
    }

    function setItem(elt, id=null, text=null) {
        if (elt.value == "Legalitas Perusahaan") {
            let data = [
                {
                    id: "Legalitas Institusi / Perusahaan",
                    text: 'Legalitas Institusi / Perusahaan'
                }
            ]
            if (id != null) {
                $(`#item-${id}`).empty() 
                $(`#item-${id}`)
                $(`#item-${id}`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                })
            } else {
                $(`#item`).empty() 
                $(`#item`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                }) 
            }
        } else if(elt.value == "Reputasi Pemberi Kerja") {
            let data = [
                {
                    id: "Reputasi Pemberi Kerja Dalam Pemenuhan Kontrak (Historical)",
                    text: 'Reputasi Pemberi Kerja Dalam Pemenuhan Kontrak (Historical)'
                }
            ]
            if (id != null) {
                $(`#item-${id}`).empty() 
                $(`#item-${id}`)
                $(`#item-${id}`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                })
            } else {
                $(`#item`).empty() 
                $(`#item`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                }) 
            }
        } else {
            let data = [
                {
                    id: 'Current Ratio',
                    text: 'Current Ratio'
                },
                {
                    id: 'Cash Ratio',
                    text: 'Cash Ratio'
                },
                {
                    id: 'Debt to Equity Ratio',
                    text: 'Debt to Equity Ratio'
                },
                {
                    id: 'Kepatuhan Pembayaran Pajak',
                    text: 'Kepatuhan Pembayaran Pajak'
                }
            ]
            if (id != null) {
                $(`#item-${id}`).empty() 
                $(`#item-${id}`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                })
                $(`#item-${id}`).val()
            } else {
                $(`#item`).empty() 
                $(`#item`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                }) 
            }
        }
    }
</script>
@endsection

<!--end::Main-->
