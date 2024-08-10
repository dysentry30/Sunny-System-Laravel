<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dokumen Verifikasi Internal Penentuan KSO / Non KSO</title>
</head>
<body>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        #alasan_lainnya{
            border-top-width: 0;
            border-right-width: 0;
            border-bottom-width: 1px;
            border-left-width: 0;
            border-style: solid;
            border-color: black;
            font-family:'Times New Roman', Times, serif;
            font-size: 0.8rem;
            width:700px;
        }
        footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 0.5cm;
                font-size: 0.8rem;
                color: black;
                text-align:end;
                line-height: 1.5cm;
            }
    </style>
    <h5>Lampiran 11.13. a. Verifikasi Internal Penentuan KSO atau Non KSO</h5>

    <table style="width: 100%">
        <tr>
            <td rowspan="2" style="width: 20%"><h5>Ikut Lelang KSO **)</h5></td>
            <td rowspan="2" style="width: 10%">
                <input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" {{ $jenisProyek == "J" ? "checked" : '' }}>
            </td>
            <td style="width: 100%">
                <table style="width: 100%">
                    <tr>
                        <td style="font-size: 0.6rem">
                            <table>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" {{ $verifikasiKSO->contains('index', 1) ? "checked" : "" }}>
                                    </td>
                                    <td>
                                        <label class="form-check-label" style="margin: 0; padding:0" for="inlineCheckbox1" style="font-size: 0.8rem">Belum Memiliki Kemampuan Dasar</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-size: 0.6rem">
                            <table>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" {{ $verifikasiKSO->contains('index', 2) ? "checked" : "" }}>
                                    </td>
                                    <td>
                                        <label class="form-check-label" style="margin: 0; padding:0" for="inlineCheckbox2" style="font-size: 0.8rem">Tidak Memiliki Personil yang Dipersyaratkan</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-size: 0.6rem">
                            <table>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" {{ $verifikasiKSO->contains('index', 3) ? "checked" : "" }}>
                                    </td>
                                    <td>
                                        <label class="form-check-label" style="margin: 0; padding:0" for="inlineCheckbox3" style="font-size: 0.8rem">Tidak Memiliki Peralatan yang Dipersyaratkan</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="font-size: 0.6rem">
                            <table>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" {{ $verifikasiKSO->contains('index', 4) ? "checked" : "" }}>
                                    </td>
                                    <td>
                                        <label class="form-check-label" style="margin: 0; padding:0" for="inlineCheckbox3" style="font-size: 0.8rem">Meningkatkan Peluang Lelang</label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" {{ $verifikasiKSO->contains('index', 5) ? "checked" : "" }}>
                        </td>
                        <td>
                            <label class="form-check-label" style="margin: 0; padding:0" for="inlineCheckbox3" style="font-size: 0.8rem">Alasan Lainnya : </label>
                        </td>
                        <td>
                            @php
                                $alasanLainnya = null;
                                if ($verifikasiKSO->contains('index', 5)) {
                                    $alasanLainnya = $verifikasiKSO->where('index', 5)->first()?->keterangan;
                                }
                            @endphp
                            <p id="alasan_lainnya">{!! $verifikasiKSO->contains('index', 5) && !empty($alasanLainnya) ? $alasanLainnya : '' !!}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td rowspan="2" style="width: 20%"><h5>Ikut Lelang Non KSO</h5></td>
            <td rowspan="2" style="width: 10%">
                <input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" {{ $jenisProyek != "J" ? "checked" : '' }}>
            </td>
            <td style="width: 100%"></td>
        </tr>
    </table>
    <small style="font-size: 0.5rem">**) Pilih salah satu atau lebih, diisi oleh pembuat</small>
    <br>
    <br>
    <br>
    <p style="font-size: 0.8rem; margin:0px; padding:0px;">Tanggal, {{ \Carbon\Carbon::now()->translatedFormat("d F Y") }}</p>
    <br>
    <table style="width:100%; margin:0px; padding-top:0px;">
        <tr>
            <td style="text-align:center; vertical-align:text-top">
                <div class="" style="margin:0px; padding-top:5px;">
                    <b><h5 style="margin:0px; padding-top:0px;">Dibuat Oleh,</h5></b>
                    <table style="width: 100%">
                        <tr>
                            @if (isset($pathQRPengajuan))
                                @foreach ($pathQRPengajuan as $ttdPengajuan)
                                <td style="width: 100%; text-align:center">
                                    <br>
                                    <img src="{{ public_path('template-ttd/verif-internal-partner/') . $ttdPengajuan["fileName"] }}">
                                    <br>
                                    <b><h5 style="font-size:0.8rem; margin:0px; padding-top:10px">{{ $ttdPengajuan["user"] }}</h5></b>
                                    <b><h5 style="font-size:0.6rem; margin:0px; padding-top:0px">({{ $ttdPengajuan["jabatan"] }})</h5></b>
                                </td>                                    
                                @endforeach
                            @else
                                <br><br><br><br>
                                <td style="width: 100%; text-align:center">
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">SubPJFs Key Account</p>
                                </td>                                
                            @endif
                        </tr>
                    </table>
                </div>
            </td>
            <td style="text-align:center; vertical-align:text-top">
                <div class="" style="margin:0px; padding-top:5px;">
                    <b><h5 style="margin:0px; padding-top:0px;">Direkomendasikan Oleh,</h5></b>
                    <table style="width:100%">
                        <tr>
                            @if (isset($pathQRRekomendasi))
                                @foreach ($pathQRRekomendasi as $ttdRekomendasi)
                                    <td style="width:100%; text-align:center">
                                        <br>
                                        <img src="{{ public_path('template-ttd/verif-internal-partner/') . $ttdRekomendasi["fileName"] }}">
                                        <br>
                                        <b><h5 style="font-size:0.8rem; margin:0px; padding-top:10px">{{ $ttdRekomendasi["user"] }}</h5></b>
                                        <b><h5 style="font-size:0.6rem; margin:0px; padding-top:0px">({{ $ttdRekomendasi["jabatan"] }})</h5></b>
                                    </td>   
                                @endforeach
                            @else
                                <br><br><br><br>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PjFs Marketing</p>
                                </td>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PjFs Operasi</p>
                                </td>                                
                            @endif
                        </tr>
                    </table>
                </div>
            </td>
            <td style="text-align:center; vertical-align:text-top">
                <div class="" style="margin:0px; padding-top:5px;">
                    <b><h5 style="margin:0px; padding-top:0px;">Disetujui Oleh,</h5></b>
                    <table style="width:100%">
                        <tr>
                            @if (isset($pathQRPersetujuan))
                                @foreach ($pathQRPersetujuan as $ttdPersetujuan)
                                    <td style="width:100%; text-align:center">
                                        <br>
                                        <img src="{{ public_path('template-ttd/verif-internal-partner/') . $ttdPersetujuan["fileName"] }}">
                                        <br>
                                        <b><h5 style="font-size:0.8rem; margin:0px; padding-top:10px">{{ $ttdPersetujuan["user"] }}</h5></b>
                                        <b><h5 style="font-size:0.6rem; margin:0px; padding-top:0px">({{ $ttdPersetujuan["jabatan"] }})</h5></b>
                                    </td>
                                @endforeach
                            @else
                                <br><br><br><br>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PjFK Corporate Marketing</p>
                                </td>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">PjPU Operasi</p>
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