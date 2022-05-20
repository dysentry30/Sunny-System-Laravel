<!--end::Main-->
<script>
    var hostUrl = "../";
</script>
<!--begin::Javascript-->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
{{-- begin::Froala Editor JS --}}
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
</script>
{{-- end::Froala Editor JS --}}
{{-- begin::Support Plugin for Word Editor --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.29.4/docxtemplater.js"></script>
<script src="https://unpkg.com/pizzip@3.1.1/dist/pizzip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script src="https://unpkg.com/pizzip@3.1.1/dist/pizzip-utils.js"></script>
{{-- end::Support Plugin for Word Editor --}}
{{-- begin::docx4js Library --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/docx4js@3.2.20/dist/docx4js.js"></script> --}}
{{-- <script>
    import * as docx from "docx";
</script> --}}
{{-- end::docx4js Library --}}
{{-- begin::Mammoth Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"
integrity="sha512-bGuEL2NBSooMeQLM6bf6Xdywje4PWKegNTuKpghz2xgFXtRjEs4B3X1ql7nghiCvt8gXBAks5S3KN3Jp3Jgtow=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- end::Mammoth Library --}}
{{-- begin:: docx2html Library --}}
<script src="https://cdn.jsdelivr.net/npm/docx2html@1.3.2/dist/docx2html.min.js"></script>
{{-- end:: docx2html Library --}}
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('/js/custom/widgets.js') }}"></script>
<script src="{{ asset('/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('/js/custom/modals/create-app.js') }}"></script>
<script src="{{ asset('/js/custom/modals/upgrade-plan.js') }}"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>
