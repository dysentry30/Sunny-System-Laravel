@extends('template.main')
@section('title', 'Document Viewer')
<style>
    #froala-editor {
        position: relative;
        height: 100%;
        width: 100%;
    }

    .circle-loading {
        position: relative;
        width: 1.5rem;
        height: 1.5rem;
        top: 0;
        left: 0;
        margin-left: 1rem;
        border: 4px solid rgb(212, 212, 212);
        border-top: 4px solid rgb(255, 255, 255);
        border-radius: 50%;
        animation-name: rotation;
        animation-duration: 1s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
        display: none;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

</style>
@section('content')
    {{-- begin::action --}}
    <a href="#" onclick="saveDocument()" class="btn btn-sm btn-primary d-flex justify-content-center align-items-center"
        style="background-color:#26b2e9;">
        Save
        <div class="circle-loading"></div>
    </a>
    <a href="/document/view/{{ $id }}/{{ $id_document }}/history"
        class="btn btn-sm btn-primary my-2 d-flex justify-content-center align-items-center"
        style="background-color:#e78b13;">
        View Document History
    </a>
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
@endsection
@section('js-script')

    <script src="{{ asset('/js/html-docx.js') }}" crossorigin="anonymous"></script>
    {{-- begin::Read File --}}
    <script>
        var editor = new FroalaEditor('#froala-editor', {
            charCounterCount: true,
            documentReady: true,
            // height: 400,
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
                    // if (show) {
                    // }
                    document.querySelector(".fr-view").innerHTML = html;
                    data = html;
                    // document.getElementById("A").remove();
                });
            }
            file.readAsBinaryString(docx);
            return data;
            // End::Read DOCX Content
        }
        async function saveDocument() {
            const html = document.querySelector(".fr-view #A section");
            const circleLoadingElt = document.querySelector(".circle-loading");
            const formData = new FormData();
            // const editor = new FroalaEditor('div#froala-editor', {}, function() {
            //     html = editor.html.get();

            // });
            // const content = htmlDocx.asBlob(html.innerHTML);
            const parser = new XMLSerializer().serializeToString(html);
            // console.log(parser);
            // return;
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("id", "{{ $id }}");
            formData.append("id_document", "{{ $id_document }}");
            formData.append("content_word", parser);
            circleLoadingElt.style.display = "block";
            const uploadFile = await fetch(
                "/document/view/{{ $id }}/{{ $id_document }}/save", {
                    method: "POST",
                    body: formData,
                    header: {
                        "content-type": "application/json",
                    }
                }).then(res => res.json());
            console.log(uploadFile);
            circleLoadingElt.style.display = "none";
            if (uploadFile.status == "success") {
                console.log(uploadFile);
                window.location.href = uploadFile.redirect;
            }
            circleLoadingElt.style.display = "none";
            return;
            // const document = await readFile("{{ $document }}", false);
        }
        // /document/save///save
        document.addEventListener("DOMContentLoaded", () => {
            readFile(`{{ $document }}`);
        });
    </script>
    {{-- end::Read File --}}
@endsection
