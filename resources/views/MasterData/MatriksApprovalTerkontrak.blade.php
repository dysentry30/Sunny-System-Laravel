{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Matriks Approval Proyek Terkontrak')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Matriks Approval Proyek Terkontrak
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @canany(['super-admin'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#kt_modal_input_matriks_approval" data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah</a>

                                </div>
                                <!--end::Actions-->                                
                            @endcanany
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
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">NIP</th>
                                        <th class="min-w-125px">Nama Pegawai</th>
                                        <th class="min-w-100px">Unit Kerja</th>
                                        <th class="min-w-auto text-white">Start Periode</th>
                                        <th class="min-w-auto text-white">Finish Periode</th>
                                        <th class="min-w-auto text-white">Active</th>
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
                                    @foreach ($matriks_all as $approval)
                                        <tr>
                                            <td class="text-center">{{ $approval->nip }}</td>
                                            <td>{{ $approval->Pegawai->nama_pegawai }}</td>
                                            <td class="text-center">{{$approval->UnitKerja->unit_kerja}}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::create($approval->start_date)->translatedFormat("d M Y") }}</td>
                                            <td class="text-center">{{ !empty($approval->finish_date) ? \Carbon\Carbon::create($approval->finish_date)->translatedFormat("d M Y") : "" }}</td>
                                            <td class="text-center"><p class="m-0 badge badge-sm {{ $approval->is_active ? "bg-success" : "bg-danger" }}">{{ $approval->is_active ? "Yes" : "No" }}</p></td>
                                            <td class="text-center">
                                                <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;" onclick="showModal('{{ $approval }}')">Edit</button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_matriks_delete_{{$approval->id}}">Delete</button>
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
    <div class="modal fade" id="kt_modal_input_matriks_approval" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Matriks Approval Proyek Terkontrak</h2>
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

                <form action="/matriks-approval-proyek-terkontrak/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_input_matriks_approval">
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
                                        <span class="required">Start Periode</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <a href="#" class="btn"
                                        style="background: transparent;"
                                        id="start-date-modal"
                                        onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill"
                                            style="color: #008CB4"></i>
                                    </a>
                                    <input type="date" name="start_date" id="start_date" class="form-control form-control-solid">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Pegawai</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                        
                                    <select id="nama_pegawai" name="nama_pegawai"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Nama Pegawai..."
                                        data-select2-id="select2-nama_pegawai" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
    
                            <div class="row mb-7">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Unit Kerja</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select name="unit_kerja" id="unit_kerja" data-control="select2" data-hide-search="true" data-placeholder="Pilh Unit Kerja..."
                                        tabindex="-1" aria-hidden="true" class="form-select form-select-solid">
                                        <option value=""></option>
                                            @foreach ($unitKerjas as $unitKerja)
                                                <option value="{{ $unitKerja->divcode }}">{{ $unitKerja->unit_kerja }}</option>                                                
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7 d-none" id="finish-periode">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Finish Periode</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <input type="date" name="finish_date" id="finish_date" class="form-control form-control-solid">
                                <!--end::Input-->
                                
                            </div>
                            <!--end::Input group-->
                            <div class="row ms-1">
                                <!--Begin::Input Checkbox-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="create" name="isActive" id="active-periode" onchange="setActive(this)" checked>
                                    <label class="form-check-label" for="active-periode">
                                        Active
                                    </label>
                                </div>
                                <!--End::Input Checkbox-->
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

    @foreach ($matriks_all as $approval)
        <!--begin::Modal Tambah Kriteria Green Line-->
        <div class="modal fade" id="kt_modal_edit_{{ $approval->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Matriks Approval Proyek Terkontrak</h2>
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

                    <form action="/matriks-approval-proyek-terkontrak/{{ $approval->id }}/update" method="POST">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_edit_{{ $approval->id }}">
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
                                            <span class="required">Start Periode</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <a href="#" class="btn"
                                            style="background: transparent;"
                                            id="start-date-modal"
                                            onclick="showCalendarModal(this)">
                                            <i class="bi bi-calendar2-plus-fill"
                                                style="color: #008CB4"></i>
                                        </a>
                                        <input type="date" name="start_date" id="start_date_{{ $approval->id }}" value="{{ $approval->start_date }}" class="form-control form-control-solid">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nama Pegawai</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->                                            
                                        <select id="nama-pegawai-{{ $approval->id }}" name="nama_pegawai"
                                            class="form-select form-select-solid" data-hide-search="false" data-placeholder="Pilih Nama Pegawai..."aria-hidden="true">
                                            <option value="" selected></option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
        
                                <div class="row mb-7">
                                    <div class="col">
                                        <div id="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Unit Kerja</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <select name="unit_kerja" id="unit_kerja_{{ $approval->id }}" data-control="select2" data-hide-search="true" data-placeholder="Pilh Unit Kerja..."
                                                tabindex="-1" aria-hidden="true" class="form-select form-select-solid">
                                                <option value=""></option>
                                                @foreach ($unitKerjas as $unitKerja)
                                                    <option value="{{ $unitKerja->divcode }}" {{ $approval->unit_kerja == $unitKerja->divcode ? "selected" : "" }}>{{ $unitKerja->unit_kerja }}</option>                                                
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>

                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7 d-none" id="finish-periode-edit-{{ $approval->id }}">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Finish Periode</span>
                                    </label>
                                    <!--begin::Input-->
                                    <a href="#" class="btn"
                                        style="background: transparent;"
                                        id="start-date-modal"
                                        onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill"
                                            style="color: #008CB4"></i>
                                    </a>
                                    <input type="date" name="finish_date" id="finish_periode_{{ $approval->id }}" value="{{ $approval->finish_periode }}" class="form-control form-control-solid">
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <div class="row ms-1">
                                    <!--Begin::Input Checkbox-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="edit" name="isActive" id="active-periode" onchange="setActive(this, '{{ $approval->id }}')" {{ $approval->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active-periode">
                                            Active
                                        </label>
                                    </div>
                                    <!--End::Input Checkbox-->
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
    @endforeach
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 

    <!--begin::modal DELETE-->
    @foreach ($matriks_all as $approval)
        <form action="/matriks-approval-proyek-terkontrak/{{ $approval->id }}/delete" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id-matriks-approval" value="{{$approval->id}}">
            <div class="modal fade" id="kt_modal_matriks_delete_{{ $approval->id  }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $approval->Pegawai->nama_pegawai }}</h2>
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
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-danger min-w-100px fs-6">Delete</button>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $("#kt_modal_matriks_update_{{ $approval->id  }} select").select2({
                    dropdownParent: $('#kt_modal_matriks_update_{{ $approval->id  }}'),
                });
            });
        </script>
    @endforeach
    <!--end::modal DELETE-->
      
    
    <script>
        $('#example').DataTable({
            dom: '<"float-start"f><"#example"t>rtip',
            pageLength : 50,
            stateSave: true,
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    const perPage = 10;
    $(document).ready(function() {
        $("#nama_pegawai").select2({
            ajax: {
                url: '/proyek/get-data-pegawai',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        perPage: perPage,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1

                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                    const optionData = isPagination ? data.data : data;
                    const options = optionData.map(item => {
                        return {
                            id: item.nip, 
                            text: item.nip + " - " + item.nama_pegawai
                        }
                    })
                    return {
                        results: options,
                        pagination: {
                            more: isPagination ? (params.page * (perPage || 10)) < data.total : false
                        }
                    }
                },
                cache: true,
                minimumResultsForSearch: 0
            },
            dropdownParent: $('#kt_modal_input_matriks_approval'),
        });
        $("#unit-kerja, #klasifikasi-proyek, #kategori").select2({
            dropdownParent: $('#kt_modal_input_matriks_approval'),
        })
    });

    function setActive(e, id = null) {
        if (e.value == "create") {
            const elementFinish = document.querySelector('#finish-periode');
            if(e.checked){
                elementFinish.classList.add('d-none');
                // elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                // elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
            }else{
                elementFinish.classList.remove('d-none');
                // elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                // elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
            }
        } else {
            const elementFinish = document.querySelector(`#finish-periode-edit-${id}`);
            if(e.checked){
                elementFinish.classList.add('d-none');
                // elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                // elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
            }else{
                console.log(elementFinish);
                elementFinish.classList.remove('d-none');
                // elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                // elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
            }    
        }
    }
</script>
<script>
    async function setDepartemen(e, id=null){
        const data = e.options[e.selectedIndex].getAttribute('data-sap');
        // console.log(data);
        let html = '<option value=""></option>'
        // console.log(data)
        if(data == 'A141' || data == 'A142' || data == 'A151' || data == 'A161'){
            // document.getElementById("div-departemen").style.visibility ='
            let departemenElt;

            if (id != null) {
                departemenElt = document.querySelector(`#departemen-proyek-${id}`);
            }else{
                departemenElt = document.getElementById("departemen-proyek");
            }

            const response = await fetch(`/proyek/get-departemen/${data}`, {
                method: 'GET',
            }).then(result => result.json())
            // console.log(response.data);
            response.data.forEach(data => {
                html += `<option value="${data.kode_departemen}">${data.nama_departemen}</option>`
            });
            
            departemenElt.innerHTML = html;
        }else{
            document.getElementById("div-departemen").style.value = null;
        }
    }
</script>
<script>
    function showModal(approval) {
        const approvalData = JSON.parse(approval);
        let modal = document.getElementById('kt_modal_edit_' + approvalData.id);

        $(modal).modal('show');

        let select2 = document.getElementById('nama-pegawai-' + approvalData.id);

        $(select2).select2({
            ajax: {
                url: '/proyek/get-data-pegawai',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        perPage: perPage,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1

                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                    const optionData = isPagination ? data.data : data;
                    const options = optionData.map(item => {
                        return {
                            id: item.nip, 
                            text: item.nip + " - " + item.nama_pegawai
                        }
                    })
                    return {
                        results: options,
                        pagination: {
                            more: isPagination ? (params.page * (perPage || 10)) < data.total : false
                        }
                    }
                },
                cache: true,
                minimumResultsForSearch: 0
            },
            dropdownParent: $(modal)
        });

        const newOption = new Option(
            approvalData.pegawai?.nama_pegawai, 
            approvalData.pegawai?.nip, 
            true, 
            true
        )
        $(select2).append(newOption).trigger('change')
        $(select2).trigger({
            type: 'select2:select',
            params: {
                data: approvalData.pegawai?.nip
            }
        })

        $(`#unit_kerja_${approvalData.id}`).select2({
            dropdownParent: $(modal)
        });

        // $(`#departemen-proyek-${approvalData.id}`).select2({
        //     dropdownParent: $(modal)
        // })

        // $(`#departemen-proyek-${approvalData.id}`).select2({
        //     ajax: {
        //         url: `/get-data-divisi/${approvalData.divisi_id}`,
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function (data, params) {
        //             const parseData = data.map(item => {
        //                 return {
        //                     id : item.kode_departemen,
        //                     text : item.nama_departemen
        //                 }
        //             })
        //             return{
        //                 results:parseData
        //             }
        //         }
        //     },
        //     dropdownParent: $(modal)
        // });
        
        // const newOption2 = new Option(
        //     approvalData.departemen?.nama_departemen, 
        //     approvalData.departemen?.kode_departemen, 
        //     true, 
        //     true
        // )
        // $(`#departemen-proyek-${approvalData.id}`).append(newOption2).trigger('change');
        // $(`#departemen-proyek-${approvalData.id}`).trigger({
        //     type: 'select2:select',
        //     params: {
        //         data: approvalData.departemen?.kode_departemen
        //     }
        // })
    }
</script>
@endsection

<!--end::Main-->
