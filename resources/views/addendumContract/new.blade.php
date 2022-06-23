@extends('template.main')
@section('content')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        
        <!--begin::Header-->
        @extends('template.header')
        <!--end::Header-->

        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            @isset($addendumDraft)
                @section('title', 'Update Addendum Contract')
                <form action="/addendum-contract/draft/update" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-addendum" value="{{ $addendumDraft->id_addendum }}">
                    <input type="hidden" name="id-addendum-draft" value="{{ $addendumDraft->id_addendum_draft }}">
                    <input type="hidden" name="id-contract" value="{{ $id_contract }}">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Update Addendum
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                                    style="background-color:#ffa62b;">
                                    Save</button>
                                <!--end::Button-->

                                <!--begin::Button-->
                                <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                                    style="background-color:#f3f6f9;margin-left:10px;color: black;">
                                    Close</a>
                                <!--end::Button-->


                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid">
                            <!--begin::Contacts App- Edit Contact-->
                            <div class="row g-7">
                                @if (Session::has('error'))
                                    <h1>{{ Session::get('error') }}</h1>
                                @endif
                                <!--begin::Header Contract-->
                                <div class="col-xl-15">

                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                        <div class="card-body pt-5">
                                            <div class="card-title m-0">
                                                <!--begin::Input group Website-->
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="fs-6 form-label mt-3">
                                                        <span style="font-weight: normal">Attachment</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->

                                                    <input type="file" style="font-weight: normal"
                                                        class="form-control form-control-solid" name="attach-file-addendum"
                                                        id="attach-file-addendum"
                                                        value="{{ $addendumDraft->document_name_addendum ?? '' }}"
                                                        accept=".docx" placeholder="Name terima">
                                                    @error('attach-file-addendum')
                                                        <h6>
                                                            <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                        </h6>
                                                    @enderror
                                                    <!--end::Input-->

                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                        <span style="font-weight: normal">Nama
                                                            Dokumen</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-solid"
                                                        name="document-name-addendum" id="document-name-addendum"
                                                        value="{{ old('document-name-addendum') ?? ($addendumDraft->document_name_addendum ?? '') }}"
                                                        style="font-weight: normal" placeholder="Nama Document" />
                                                    @error('document-name-addendum')
                                                        <h6>
                                                            <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                        </h6>
                                                    @enderror
                                                    <!--end::Input-->

                                                    <!--begin::Label-->
                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                        <span style="font-weight: normal">Catatan</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" style="font-weight: normal"
                                                        class="form-control form-control-solid" name="note-addendum"
                                                        id="note-addendum"
                                                        value="{{ old('note-addendum') ?? ($addendumDraft->note_addendum ?? '') }}"
                                                        placeholder="Catatan" />
                                                    @error('note-addendum')
                                                        <h6>
                                                            <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                        </h6>
                                                    @enderror
                                                    <!--end::Input-->
                                                    <small id="file-error-msg"
                                                        style="color: rgb(199, 42, 42); display:none"></small>


                                                    {{-- begin::Froala Editor --}}
                                                    <div class="my-3">
                                                        <div id="froala-editor-addendum">
                                                            <h1>Attach file with <b>.DOCX</b> format
                                                                only</h1>
                                                        </div>
                                                    </div>

                                                    {{-- end::Froala Editor --}}
                                                    {{-- begin::Read File --}}
                                                    {{-- Begin::input textarea --}}
                                                    <textarea hidden name="content-word-attachment" class="form-control form-control-solid"
                                                        id="content-word-attachment"></textarea>
                                                    {{-- Begin::input textarea --}}
                                                    {{-- end::Read File --}}
                                                </div>
                                                <!--end::Input group-->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header Contract-->
                </form>
            @else
            @section('title', 'New Addendum Contract')

            <form action="/addendum-contract/draft/upload" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id-addendum" value="{{ $addendumContract->id_addendum }}">
                <input type="hidden" name="id-contract" value="{{ $id_contract }}">
                <!--begin::Toolbar-->
                <div class="toolbar" id="kt_toolbar">
                    <!--begin::Container-->
                    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                        <!--begin::Page title-->
                        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                            <!--begin::Title-->
                            <h1 class="d-flex align-items-center fs-3 my-1">New Addendum Contract
                            </h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">

                            <!--begin::Button-->
                            <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                                style="background-color:#ffa62b;">
                                Save</button>
                            <!--end::Button-->

                            <!--begin::Button-->
                            <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                                style="background-color:#f3f6f9;margin-left:10px;color: black;">
                                Close</a>
                            <!--end::Button-->


                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Post-->
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-fluid">
                        <!--begin::Contacts App- Edit Contact-->
                        <div class="row g-7">
                            @if (Session::has('error'))
                                <h1>{{ Session::get('error') }}</h1>
                            @endif
                            <!--begin::Header Contract-->
                            <div class="col-xl-15">

                                <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                    <div class="card-body pt-5">
                                        <div class="card-title m-0">
                                            <!--begin::Input group Website-->
                                            <div class="fv-row mb-5">
                                                <!--begin::Label-->
                                                <label class="fs-6 form-label mt-3">
                                                    <span style="font-weight: normal">Attachment</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input type="file" style="font-weight: normal"
                                                    class="form-control form-control-solid" name="attach-file-addendum"
                                                    id="attach-file-addendum"
                                                    value="{{ $addendumDraft->document_name_addendum ?? '' }}"
                                                    accept=".docx" placeholder="Name terima">
                                                @error('attach-file-addendum')
                                                    <h6>
                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                    </h6>
                                                @enderror
                                                <!--end::Input-->

                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span style="font-weight: normal">Nama
                                                        Dokumen</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    name="document-name-addendum" id="document-name-addendum"
                                                    value="{{ old('document-name-addendum') ?? ($addendumDraft->document_name ?? '') }}"
                                                    style="font-weight: normal" placeholder="Nama Document" />
                                                @error('document-name-addendum')
                                                    <h6>
                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                    </h6>
                                                @enderror
                                                <!--end::Input-->

                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span style="font-weight: normal">Catatan</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" style="font-weight: normal"
                                                    class="form-control form-control-solid" name="note-addendum"
                                                    id="note-addendum"
                                                    value="{{ old('note-addendum') ?? ($addendumDraft->draft_note ?? '') }}"
                                                    placeholder="Catatan" />
                                                @error('note-addendum')
                                                    <h6>
                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                    </h6>
                                                @enderror
                                                <!--end::Input-->
                                                <small id="file-error-msg"
                                                    style="color: rgb(199, 42, 42); display:none"></small>


                                                {{-- begin::Froala Editor --}}
                                                <div class="my-3">
                                                    <div id="froala-editor-addendum">
                                                        <h1>Attach file with <b>.DOCX</b> format
                                                            only</h1>
                                                    </div>
                                                </div>

                                                {{-- end::Froala Editor --}}
                                                {{-- begin::Read File --}}
                                                {{-- Begin::input textarea --}}
                                                <textarea hidden name="content-word-attachment" class="form-control form-control-solid"
                                                    id="content-word-attachment"></textarea>
                                                {{-- Begin::input textarea --}}
                                                {{-- end::Read File --}}
                                            </div>
                                            <!--end::Input group-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Header Contract-->
            </form>
        @endisset
    </div>
    <!--end::Contacts App- Edit Contact-->
</div>

@endsection

@include('template.aside')

@section('js-script')
<script>
    const froalaEditorAddendum = new FroalaEditor("#froala-editor-addendum", {
        documentReady: true,
    });

    const fileAttachmentAddendumElt = document.querySelector("#attach-file-addendum");
    fileAttachmentAddendumElt.addEventListener("change", async e => {
        await readFile(e.target.files[0], "#froala-editor-addendum");
    });



    async function readFile(file, elt) {
        const docx2html = require("docx2html");
        const html = await docx2html(file);
        document.querySelector(` ${elt} .fr-wrapper .fr-view`).innerHTML = html;
        return html;
    };
</script>
@endsection
