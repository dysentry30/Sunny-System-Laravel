<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Verifikasi Internal Penentuan Proyek Green Lane atau Non Green lane</title>
</head>

<body>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        #alasan_lainnya {
            border-top-width: 0;
            border-right-width: 0;
            border-bottom-width: 1px;
            border-left-width: 0;
            border-style: solid;
            border-color: black;
            font-family: 'Times New Roman', Times, serif;
            font-size: 0.8rem;
            width: 700px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.5cm;
            font-size: 0.8rem;
            color: black;
            text-align: end;
            line-height: 1.5cm;
        }
    </style>
    <h5>Lampiran 11.1. Verifikasi Internal Penentuan Proyek Green Lane atau Non Green lane</h5>
    @php
        $is_green_lane_nota_2 = checkGreenLaneNota2($proyek);
    @endphp
    <table style="width: 100%;">
        <tr style="margin: 0; padding:0">
            <td style="width: 18%;">
                <h4 style="margin: 0; padding:0">Nama Proyek</h4>
            </td>
            <td style="width: 2%">
                <h4 style="margin: 0; padding:0">:</h4>
            </td>
            <td style="width: 80%">
                <h4 style="margin: 0; padding:0">{{ $proyek->nama_proyek }}</h4>
            </td>
        </tr>
        <tr style="margin: 0; padding:0">
            <td style="width: 18%">
                <h4 style="margin: 0; padding:0">Nilai Pagu/HPS</h4>
            </td>
            <td style="width: 2%">
                <h4 style="margin: 0; padding:0">:</h4>
            </td>
            <td style="width: 80%">
                <h4 style="margin: 0; padding:0">Rp.{{ number_format((int) str_replace('.', '', $proyek->hps_pagu), 0, '.', '.')     }}</h4>
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%">
        <tr>
            <td>1.</td>
            <td><label style="font-size: 0.8rem">Jenis Kontrak</label> <label style="font-size: 0.6rem">**)</label></td>
            <td>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox1" value="option1" {{ $proyek->jenis_terkontrak == "Unit Price" ? "checked" : "" }}>
                <br>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox2" value="option2" {{ $proyek->jenis_terkontrak == "Lumpsum" ? "checked" : "" }}>
            </td>
            <td>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;"><i>Unit Price</i></label>
                <br>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;"><i>Lumpsum</i></label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <label style="font-size: 0.6rem">*Note: Jika Proyek terdiri dari 2 (dua) jenis Kontrak, maka dipilih yang paling dominan</label><br>
                <label style="font-size: 0.6rem">**Note: Jika jenis kontrak tidak ada yang terpilih maka jenis terkontrak diluar dari 2 pilihan diatas.</label>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>2.</td>
            <td><label style="font-size: 0.8rem">Uang Muka</label> <label style="font-size: 0.6rem">**)</label></td>
            <td>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox1" value="option3" {{ $proyek->is_uang_muka ? "checked" : "" }}>
                <br>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox2" value="option4" {{ !is_null($proyek->is_uang_muka) && !$proyek->is_uang_muka ? "checked" : "" }}>
            </td>
            <td>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;">Ada</label>
                <br>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;">Tidak Ada</label>
            </td>
        </tr>
        <br>
        <tr>
            <td>3.</td>
            <td><label style="font-size: 0.8rem">Metode Pembayaran</label> <label style="font-size: 0.6rem">**)</label></td>
            <td>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox1" value="option5" {{ $proyek->sistem_bayar == "Monthly" ? "checked" : "" }}>
                <br>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox2" value="option6" {{ $proyek->sistem_bayar == "Milestone" ? "checked" : "" }}>
                <br>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox2" value="option7" {{ $proyek->sistem_bayar == "CPF (Turn Key)" ? "checked" : "" }}>
                <br>
                <input class="form-check-input" style="height:0px" type="checkbox" id="inlineCheckbox2" value="option8" {{ $proyek->sistem_bayar == "Others" ? "checked" : "" }}>
            </td>
            <td>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;"><i>Monthly</i></label>
                <br>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;"><i>Milestone</i></label>
                <br>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;"><i>Pre Financing</i></label>
                <br>
                <label class="form-check-label" for="inlineCheckbox1"
                    style="font-size: 0.8rem; margin-top: 0px;"><i>Others : _________________________</i></label>
            </td>
        </tr>
    </table>
    <br>
    <label style="font-size: 0.6rem">**) Pilih salah satu, diisi oleh pembuat</label>
    <br>
    <table style="width: 100%">
        <tr>
            <td><h5 style="margin: 0; padding:0">Keputusan **) :</h5></td>
            <td></td>
            <td><h5 style="margin: 0; padding:0">Keterangan :</h5></td>
        </tr>
        <tr>
            <td style="width: 5%"><h5 style="margin: 0; padding:0"><i>Project Green Lane</i></h5></td>
            <td style="width: 3%">
                <input class="form-check-input" style="height:-10px; font-size:20pt" type="checkbox" id="inlineCheckbox2" value="option9" {{ $is_green_lane_nota_2 ? 'checked' : '' }}>
            </td>
            <td style="width: 10%; vertical-align: text-top" rowspan="2">
                <p style="font-size: 0.8rem; margin:0; padding:0px">{!! nl2br($proyek->keterangan_greenlane) !!}</p>
            </td>
        </tr>
        <tr>
            <td style="width: 5%"><h5 style="margin: 0; padding:0"><i>Project Non Green Lane</i></h5></td>
            <td style="width: 3%">
                <input class="form-check-input" style="height:-10px; font-size:20pt" type="checkbox" id="inlineCheckbox2" value="option10" {{ !$is_green_lane_nota_2 ? 'checked' : '' }}>
            </td>
        </tr>
    </table>
    <br>
    <p style="font-size: 0.8rem; margin-top: 0px; margin:0px; padding:0px;">Tanggal, {{ \Carbon\Carbon::now()->translatedFormat("d F Y") }}</p>
    <br>
    <br>
    <table style="width:100%; margin:0px; padding:0px;">
        <tr>
            <td style="text-align:center; width: 33%">
                <div class="" style="margin:0px; padding-top:5px;">
                    <b>
                        <h5 style="margin:0px; padding-top:0px;">Dibuat Oleh,</h5>
                    </b>
                    <table style="width: 100%">
                        <tr>
                            @if (isset($pathQRPengajuan))
                                @foreach ($pathQRPengajuan as $ttdPengajuan)
                                    <td style="width: 100%; text-align:center">
                                        <img src="{{ public_path('template-ttd/verif-proyek-nota-2/') . $ttdPengajuan["fileName"] }}" style="scale: 5">
                                        <br>
                                        <b><h5 style="font-size:0.6rem; margin:0px; padding-top:10px">{{ $ttdPengajuan["user"] }}</h5></b>
                                        <b><h5 style="font-size:0.4rem; margin:0px; padding-top:0px">({{ $ttdPengajuan["jabatan"] }})</h5></b>
                                    </td>
                                @endforeach
                            @else
                                <td style="width: 100%; text-align:center">
                                    <br><br><br>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">(....................................)</p>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">SubPJFs Key Account</p>
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>
            </td>
            <td style="text-align:center; width: 34%">
                <div class="" style="margin:0px; padding-top:5px;">
                    <b>
                        <h5 style="margin:0px; padding-top:0px;">Direkomendasikan Oleh,</h5>
                    </b>
                    <table style="width:100%">
                        <tr>
                            @if (isset($pathQRRekomendasi))
                                @foreach ($pathQRRekomendasi as $ttdRekomendasi)
                                    <td style="width:100%; text-align:center">
                                        <img src="{{ public_path('template-ttd/verif-proyek-nota-2/') . $ttdRekomendasi["fileName"] }}" style="scale: 5">
                                        <br>
                                        <b><h5 style="font-size:0.6rem; margin:0px; padding-top:10px">{{ $ttdRekomendasi["user"] }}</h5></b>
                                        <b><h5 style="font-size:0.4rem; margin:0px; padding-top:0px">({{ $ttdRekomendasi["jabatan"] }})</h5></b>
                                    </td>    
                                @endforeach
                            @else
                                <td style="width:100%; text-align:center">
                                    <br><br><br>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">
                                        (....................................)</p>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PJFs Marketing</p>
                                </td>
                                <td style="width:100%; text-align:center">
                                    <br><br><br>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">
                                        (....................................)</p>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PJFs Operasi</p>
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>
            </td>
            <td style="text-align:center; width: 33%">
                <div class="" style="margin:0px; padding-top:5px;">
                    <b>
                        <h5 style="margin:0px; padding-top:0px;">Disetujui Oleh,</h5>
                    </b>
                    <table style="width:100%">
                        <tr>
                            @if (isset($pathQRPersetujuan))
                                @foreach ($pathQRPersetujuan as $ttdPersetujuan)
                                    <td style="width:100%; text-align:center">
                                        <img src="{{ public_path('template-ttd/verif-proyek-nota-2/') . $ttdPersetujuan["fileName"] }}" style="scale: 5">
                                        <br>
                                        <b><h5 style="font-size:0.6rem; margin:0px; padding-top:10px">{{ $ttdPersetujuan["user"] }}</h5></b>
                                        <b><h5 style="font-size:0.4rem; margin:0px; padding-top:0px">({{ $ttdPersetujuan["jabatan"] }})</h5></b>
                                    </td>
                                @endforeach
                            @else
                                <td style="width:100%; text-align:center">
                                    <br><br><br>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">
                                        (....................................)</p>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PJFK Corporate Marketing</p>
                                </td>
                                <td style="width:100%; text-align:center">
                                    <br><br><br>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">
                                        (....................................)</p>
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PJPU Operasi</p>
                                </td>                           
                            @endif
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <footer>*Dokumen ini dibuat oleh sistem CRM</footer>

</body>

</html>
