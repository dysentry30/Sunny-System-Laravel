@extends('template.header')
@section('title', 'Document Viewer')
<style>
    #froala-editor {
        position: relative;
        height: 100%;
        width: 100%;
    }

</style>
@section('content')
    {{-- begin::action --}}
    <a href="#" onclick="saveDocument()" class="btn btn-sm btn-primary" style="background-color:#26b2e9;">Save</a>
    <a href="{{ $_SERVER['HTTP_REFERER'] }}" class="btn btn-sm btn-primary mt-2" style="background-color:#ffa62b;">Back to
        Contract
        Management</a>
    {{-- end::action --}}
    {{-- begin::text --}}
    <small style="text-align: center; font-size: 1rem; padding: 1rem 0">Make sure you use <b>Fullscreen Mode</b> for better
        view.
        Click top left button to use <b>Fullscreen Mode.</b>
    </small>
    {{-- end::text --}}
    {{-- begin::Froala Editor --}}
    <div id="froala-editor">
    </div>
    {{-- end::Froala Editor --}}
    {{-- begin::Read File --}}
    <script>
        var editor = new FroalaEditor('#froala-editor', {
            charCounterCount: true,
            documentReady: true,
        });

        // Convert DOCX format to HTML tag
        async function readFile(content, show = true) {
            const docx = await fetch(content).then(res => res.blob());
            // Begin:: Get DOCX File
            // End:: Get DOCX File

            // Begin::Read DOCX Content
            const file = new FileReader();
            let data = "";
            file.onloadend = () => {
                const docx2html = require("docx2html");
                const content = docx2html(file.result).then(html => {
                    if (show) {
                        document.querySelector(".fr-view").innerHTML = html;
                    }
                    data = html;
                    // document.getElementById("A").remove();
                });
            }
            file.readAsBinaryString(docx);
            return data;
            // End::Read DOCX Content
        }
        async function saveDocument() {
            const html = document.querySelector("#A section");
            const formData = new FormData();
            // const editor = new FroalaEditor('div#froala-editor', {}, function() {
            //     html = editor.html.get();

            // });
            // const content = htmlDocx.asBlob(html.innerHTML);

            formData.append("_token", "{{ csrf_token() }}");
            formData.append("id", "{{ $id }}");
            formData.append("id_document", "{{ $id_document }}");
            formData.append("content_word", html.innerHTML);
            const uploadFile = await fetch(
                "/document/view/{{ $id }}/{{ $id_document }}/save", {
                    method: "POST",
                    body: formData,
                }).then(res => res.json());
            window.location.href = uploadFile.redirect;
            return;
            // const document = await readFile("{{ $document }}", false);
        }
        // /document/save/{{ $id }}/{{ $id_document }}/save
        document.addEventListener("DOMContentLoaded", () => {
            readFile(`{{ $document }}`);
        });
    </script>
    {{-- end::Read File --}}
@endsection
<script src="{{ asset('/js/html-docx.js') }}" crossorigin="anonymous"></script>
@extends('template.footer')
