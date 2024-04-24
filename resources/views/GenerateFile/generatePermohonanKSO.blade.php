<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)</title>
</head>

<body>
    <style>
        @page { margin: 10px 25px 0px 10px; }
        body{
            margin: 10px 25px 10px 25px;
            font-family: Arial, Helvetica, sans-serif;
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
    <h5>Lampiran 11.14. Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)</h5>
    <p style="font-size: 0.7rem; margin:5px 0px 5px 0px; padding:0"><b>A. DATA PROYEK</b></p>
    <table style="width: 100%;">
        <tr style="margin: 0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">1.</p>
            </td>
            <td style="width: 20%;">
                <p style="margin: 0; padding:0; font-size:0.5rem">Nama Proyek</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 50%">
                <p style="margin: 0; padding:0; font-size:0.5rem">{{ $proyek->nama_proyek }}</p>
            </td>
        </tr>
        <tr style="margin: 0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">2.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Tujuan ber-KSO</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            @php
                $collectTujuanKSO = collect(json_decode($proyek->tujuan_kso));
                $countTujuanKSO = $collectTujuanKSO->count();
            @endphp
            <td style="width: 70%">
                <table style="width: 60%">
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" {{ $countTujuanKSO > 0 && $collectTujuanKSO->where('index', 1)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 60%"><p style="margin: 0; padding: 0; font-size:0.5rem">Meningkatkan kompetensi</p></td>
                    </tr>
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option2" {{ $countTujuanKSO > 0 && $collectTujuanKSO->where('index', 2)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 60%"><p style="margin: 0; padding: 0; font-size:0.5rem">Mengurangi persaingan</p></td>
                    </tr>
                </table>
            </td>
            <td style="width: 70%">
                <table style="width: 100%">
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option3" {{ $countTujuanKSO > 0 && $collectTujuanKSO->where('index', 3)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 80%"><p style="margin: 0; padding: 0; font-size:0.5rem">Presentasi / pengembangan pasar</p></td>
                    </tr>
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option4" {{ $countTujuanKSO > 0 && $collectTujuanKSO->where('index', 4)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 80%">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:20%"><p style="margin: 0; padding: 0; font-size:0.5rem">Lain-lain,</p></td>
                                    <td style="width:80%"><textarea id="catatan" cols="30" rows="10" style="border: 0px solid black; font-size:0.5rem; font-family: Arial, Helvetica, sans-serif; margin:0; padding: 0">{!! $countTujuanKSO > 0 && $collectTujuanKSO->where('index', 4)->count() > 0 ? $collectTujuanKSO->where('index', 4)->first()->keterangan : '' !!}</textarea></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="margin: 0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">3.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Tahapan</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 70%">
                <table style="width: 60%">
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"></td>
                        <td style="width: 80%"><p style="margin: 0; padding: 0; font-size:0.5rem">Pemasaran</p></td>
                    </tr>
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked></td>
                        <td style="width: 80%"><p style="margin: 0; padding: 0; font-size:0.5rem">Prakualifikasi</p></td>
                    </tr>
                </table>
            </td>
            <td style="width: 70%">
                <table style="width: 100%">
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"></td>
                        <td style="width: 80%"><p style="margin: 0; padding: 0; font-size:0.5rem">Tender</p></td>
                    </tr>
                    <tr style="margin: 0; padding:0">
                        <td style="width: 5%"><input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"></td>
                        <td style="width: 80%"><p style="margin: 0; padding: 0; font-size:0.5rem">Pelaksanaan</p></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="margin: 0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">4.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Uraian Proyek</p>
            </td>
        </tr>
    </table>
    <table style="width:100%; margin-left:20px">
        <tr style="margin:0; padding:0">
            <td style="width: 2%" valign="top">
                <p style="margin: 0; padding:0; font-size:0.5rem">1.</p>
            </td>
            <td style="width: 20%" valign="top">
                <p style="margin: 0; padding:0; font-size:0.5rem">Lingkup Pekerjaan</p>
            </td>
            <td style="width: 2%" valign="top">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%"><p style="font-size: 0.5rem; margin:0; padding:0px">{!! nl2br($proyek->lingkup_pekerjaan) !!}</p></td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%" valign="top">
                <p style="margin: 0; padding:0; font-size:0.5rem">2.</p>
            </td>
            <td style="width: 20%" valign="top">
                <p style="margin: 0; padding:0; font-size:0.5rem">Pemberi Tugas</p>
            </td>
            <td style="width: 2%" valign="top">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">{{ $proyek->proyekBerjalan->Customer->name }}</p>
            </td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">3.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Lokasi</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">{{ \App\Models\Negara::where('abbreviation', $proyek->negara)->first()?->country }}</p>
            </td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">4.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Provinsi</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">{{ \App\Models\Provinsi::where('province_id', $proyek->provinsi)->first()?->province_name }}</p>
            </td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">5.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Perkiraan Nilai Proyek</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Rp. {{ number_format((int) str_replace('.', '', $proyek->nilaiok_awal), 0, '.', '.') }}</p>
            </td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">6.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Sumber Dana</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">{{ $proyek->sumber_dana }}</p>
            </td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">7.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Perkiraan Waktu Pelaksanaan</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">{{ $proyek->waktu_pelaksanaan > 360 ? 'lebih' : 'kurang' }} dari 1 tahun</p>
            </td>
        </tr>
        <tr style="margin:0; padding:0">
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">8.</p>
            </td>
            <td style="width: 20%">
                <p style="margin: 0; padding:0; font-size:0.5rem">Jenis Tender</p>
            </td>
            <td style="width: 2%">
                <p style="margin: 0; padding:0; font-size:0.5rem">:</p>
            </td>
            <td style="width: 80%">
                <p style="margin: 0; padding:0; font-size:0.5rem">(bebas / terbebas / penunjukan)</p>
            </td>
        </tr>
    </table>
    <p style="font-size: 0.7rem; margin:5px 0px 5px 0px; padding:0"><b>B. DATA MITRA TERSELEKSI</b> <small style="font-size: 0.5rem"><i>(lihat hasil seleksi & klarifikasi terlampir)</i></small></p>
    <table style="width: 100%">
        @php
            $pemimpinKSO = '';
            if ($proyek->porsi_jo > 50) {
                $pemimpinKSO = 'PT Wijaya Karya (Persero) Tbk';
            }else{
                $pemimpinKSO = $proyek->PorsiJO?->filter(function($partner)use($proyek){
                    return $partner->porsi_jo == $proyek->PorsiJO?->max('porsi_jo');
                });
            }
        @endphp
        <tr>
            <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">1.</p></td>
            <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">Pemimpin KSO</p></td>
            <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $pemimpinKSO ?? '' }}</p></td>
            {{-- <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem"></p></td> --}}
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">2.</p></td>
            <td style="width: 17%"><p style="margin: 0; padding:0; font-size:0.5rem">Mitra KSO</p></td>
            <td style="width: 40%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 30%"><p style="margin: 0; padding:0; font-size:0.5rem">Partisipasi <small style="font-size: 0.5rem"><i>(share)</i></small></p></td>
        </tr>
    </table>
    <table style="width: 100%; margin-left:20px">
        @php
            $isWikaMember = $proyek->porsi_jo < 50 ? true : false;
            $filterPartner = $proyek->PorsiJO?->filter(function($partner){
                return $partner->porsi_jo < 50;
            });
        @endphp
        @if ($isWikaMember)
            <tr>
                {{-- <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">1.</p></td> --}}
                <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">PT Wijaya Karya (Persero) Tbk</p></td>
                {{-- <td style="width: 17%"></td> --}}
                <td style="width: 40%"></td>
                <td style="width: 30%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $proyek->porsi_jo }} %</p></td>
            </tr>            
        @endif
        @if ($filterPartner->isNotEmpty())
            @foreach ($filterPartner as $partner)
                <tr>
                    {{-- <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">2.</p></td> --}}
                    <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $partner->Company->name }}</p></td>
                    {{-- <td style="width: 17%"></td> --}}
                    <td style="width: 40%"></td>
                    <td style="width: 30%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $partner->porsi_jo }} %</p></td>
                </tr>            
            @endforeach
        @endif
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">3.</p></td>
            <td style="width: 17%"><p style="margin: 0; padding:0; font-size:0.5rem">Track Record</p></td>
            <td style="width: 40%"></td>
            <td style="width: 30%"></td>
        </tr>
    </table>
    <table style="width: 100%; margin-left:10px">
        <tr>
            <td style="width:2%"></td>
            <td style="width:20%"><p style="margin: 0; padding:0; font-size:0.5rem"><b>Nama Mitra KSO</b></p></td>
            <td style="width:30%"><p style="margin-left: 20px; margin-top: 0; margin-bottom: 0; padding:0; font-size:0.5rem"><b>Sudah Pernah ber-KSO dengan WIKA</b></p></td>
            <td style="width:20%" colspan="2"><p style="margin: 0; padding:0; font-size:0.5rem"><b>Evaluasi Kinerja Mitra KSO</b></p></td>
        </tr>
        <tr>
            <td style="width:2%"></td>
            <td style="width:20%"></td>
            <td style="width:30%"></td>
            <td style="width:20%"><p style="margin: 0; padding:0; font-size:0.5rem"><b>Kekuatan</b></p></td>
            <td style="width:20%"><p style="margin: 0; padding:0; font-size:0.5rem"><b>Kelemahan</b></p></td>
        </tr>
        @php
            $partnerJO = $proyek->PorsiJO?->sortBy('porsi_jo');
        @endphp
        @if ($partnerJO->isNotEmpty())
        @foreach ($partnerJO as $index => $partner)
            @php
                $isSudahBerpartner = \App\Models\PorsiJO::where('id_company_jo', $partner->id_company_jo)->count() > 1;
            @endphp
            <!--Begin::Mitra 1-->
            <tr>
                <!--Nomor-->
                <td valign="top" style="width:2%"><p style="margin: 0; padding:0; font-size:0.5rem; text-align:start"></p></td>
                <!--Mitra KSO-->
                <td valign="top" style="width:20%"><p style="margin: 0; padding:0; font-size:0.5rem; text-align:start">{{ $partner->Company->name }}</p></td>
                <!--Sudah / Belum-->
                <td valign="top" style="width:30%"><p style="margin-left: 20px; margin-top: 0; margin-bottom: 0; padding:0; font-size:0.5rem; text-align:start">{{ $isSudahBerpartner ? 'sudah' : 'belum' }}</p></td>
                <!--Kekuatan-->
                <td style="width:20%">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 100%"><p style="margin: 0; padding:0; font-size:0.5rem; text-align:start">{!! nl2br($partner->kekuatan_partner) !!}</p></td>
                        </tr>
                    </table>
                </td>
                <!--Kelemahan-->
                <td style="width:20%">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 100%"><p style="margin: 0; padding:0; font-size:0.5rem; text-align:start">{!! nl2br($partner->kelemahan_partner) !!}</p></td>
                        </tr>
                    </table>
                </td>
            </tr>            
            <!--End::Mitra 1-->            
        @endforeach
        @endif
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 2%"><p style="margin: 0; padding:0; font-size:0.5rem">4.</p></td>
            <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">Pertimbangan Pembentukan KSO</p></td>
            <td style="width: 40%"></td>
            <td style="width: 30%"></td>
        </tr>
    </table>
    <table style="width: 100%">
        @php
            $collectAlasanKSO = collect(json_decode($proyek->alasan_kso));
            $countAlasanKSO = $collectAlasanKSO->count();
        @endphp
        <tr>
            <td style="width: 2%"></td>
            <td style="width: 30%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 2%"><input type="checkbox" id="opsi1" {{ $countAlasanKSO > 0 && $collectAlasanKSO->where('index', 1)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">Belum memiliki Kemampuan Dasar</p></td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 2%"><input type="checkbox" id="opsi2" {{ $countAlasanKSO > 0 && $collectAlasanKSO->where('index', 2)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">Tidak memiliki personil yang dipersyaratkan</p></td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 2%"><input type="checkbox" id="opsi3" {{ $countAlasanKSO > 0 && $collectAlasanKSO->where('index', 3)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 20%"><p style="margin: 0; padding:0; font-size:0.5rem">Tidak memiliki peralatan yang dipersyaratkan</p></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 2%"></td>
            <td style="width: 25%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 2%"><input type="checkbox" id="opsi4" {{ $countAlasanKSO > 0 && $collectAlasanKSO->where('index', 4)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 60%"><p style="margin: 0; padding:0; font-size:0.5rem">Meningkatkan peluang memenangkan lelang</p></td>
                    </tr>
                </table>
            </td>
            <td style="width: 45%">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 2%"><input type="checkbox" id="opsi5" {{ $countAlasanKSO > 0 && $collectAlasanKSO->where('index', 5)->count() > 0 ? 'checked' : '' }}></td>
                        <td style="width: 15%"><p style="margin: 0; padding:0; font-size:0.5rem">Alasan Lainnya, </p></td>
                        <td style="width: 80%"><textarea id="catatan" cols="30" rows="10" style="border: 0px solid black; font-size:0.5rem; font-family: Arial, Helvetica, sans-serif; margin:0; padding: 0">{!! $countAlasanKSO > 0 && $collectAlasanKSO->where('index', 5)->count() > 0 ? $collectAlasanKSO->where('index', 5)->first()->keterangan : '' !!}</textarea></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <p style="font-size: 0.7rem; margin:5px 0px 5px 0px; padding:0"><b>C. ASSESSMENT MITRA KSO</b></p>
    <p style="font-size: 0.5rem"><b>Assessment ini dilakukan untuk Calon Mitra KSO yang berada di area <i>Non Green Lane</i></b></p>
    @php
        $partnerNonGreenlane = $proyek->PorsiJO->where('is_greenlane', false);
    @endphp
    @if ($partnerNonGreenlane->isNotEmpty())
    @foreach ($partnerNonGreenlane as $partner)
    @php
        $nilaiRisk = $partner->PartnerSelection?->where('kode_proyek', $partner->kode_proyek)->sum('nilai');
        if (empty($nilaiRisk)) {
            $kategoriRiskPartner = null;
        } else {
            $kategoriRiskPartner = \App\Models\PenilaianPartnerSelection::where('is_active', true)->get()?->filter(function ($item) use ($nilaiRisk) {
                    return (float) $item->dari_nilai <= (int) $nilaiRisk && (float) $item->sampai_nilai >= (int) $nilaiRisk;
            })->first()?->nama;
        }
    @endphp
    {{-- @dd($partner->PartnerSelection) --}}
    <p style="margin:0; padding:0; font-size:0.5rem"><b>{{ $partner->Company?->name }}</b></p>
    <p style="margin:0; padding:0; font-size:0.5rem">1. Assessment Internal</p>
    <table style="width: 100%">
        <tr>
            <td style="width: 3%"></td>
            <td style="width: 10%"><p style="margin: 0; padding:0; font-size:0.5rem"><i>Score</i></p></td>
            <td style="width: 3%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $nilaiRisk }}</p></td>
        </tr>
        <tr>
            <td style="width: 3%"></td>
            <td style="width: 10%"><p style="margin: 0; padding:0; font-size:0.5rem">Profile Risiko</p></td>
            <td style="width: 3%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $kategoriRiskPartner }}</p></td>
        </tr>
    </table>
    <p style="margin:0; padding:0; font-size:0.5rem">2. Assessment External</p>
    <table style="width: 100%">
        <tr>
            <td style="width: 3%"></td>
            <td style="width: 10%"><p style="margin: 0; padding:0; font-size:0.5rem"><i>Score</i></p></td>
            <td style="width: 3%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $partner->score_pefindo_jo }}</p></td>
        </tr>
        <tr>
            <td style="width: 3%"></td>
            <td style="width: 10%"><p style="margin: 0; padding:0; font-size:0.5rem"><i>Grade</i></p></td>
            <td style="width: 3%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $partner->grade }}</p></td>
        </tr>
        <tr>
            <td style="width: 3%"></td>
            <td style="width: 10%"><p style="margin: 0; padding:0; font-size:0.5rem">Profile Risiko</p></td>
            <td style="width: 3%"><p style="margin: 0; padding:0; font-size:0.5rem">:</p></td>
            <td style="width: 80%"><p style="margin: 0; padding:0; font-size:0.5rem">{{ $partner->keterangan }}</p></td>
        </tr>
    </table>
    <br>       
    @endforeach
    @endif
    <table style="width: 100%">
        <tr>
            <td style="width: 13%" valign="top"><p style="margin: 0; padding:0; font-size:0.5rem"><b>Catatan</b></p></td>
            <td style="width: 3%" valign="top"><p style="margin: 0; padding:0; font-size:0.5rem"><b>:</b></p></td>
            <td style="width: 80%"><textarea id="catatan" cols="30" rows="10" style="border: 0px solid black; font-size:0.5rem; font-family: Arial, Helvetica, sans-serif; margin:0; padding: 0"></textarea></td>
        </tr>
    </table>
    @if ($proyek->PorsiJO->count() > 1)
    <div class="" style="page-break-before: always;">        
    @endif
        <p style="font-size: 0.7rem; margin:5px 0px 5px 0px; padding:0"><b>D. PERSETUJUAN PENGGUNAAN FASILITAS NON CASH LOAN (NCL)</b></p>
        <table style="width: 80%">
            <tr>
                <td style="width:2%"><p style="margin: 0; padding:0; font-size:0.5rem">1.</p></td>
                <td style="width:5%"><input type="checkbox" id="opsi-loan-1" {{ !empty($proyek->fasilitas_ncl) && str_contains($proyek->fasilitas_ncl, 'Diajukan untuk porsi masing-masing ke Pengguna Jasa') ? 'checked' : '' }}></td>
                <td style="width:90%"><p style="margin: 0; padding:0; font-size:0.5rem">Diajukan untuk porsi masing-masing ke Pengguna Jasa</p></td>
            </tr>
            <tr>
                <td style="width:2%"><p style="margin: 0; padding:0; font-size:0.5rem">2.</p></td>
                <td style="width:5%"><input type="checkbox" id="opsi-loan-2" {{ !empty($proyek->fasilitas_ncl) && str_contains($proyek->fasilitas_ncl, 'Diajukan untuk porsi masing-masing sesuai porsi ke Pengguna Jasa') ? 'checked' : '' }}></td>
                <td style="width:90%"><p style="margin: 0; padding:0; font-size:0.5rem">Diajukan untuk terbit masing-masing sesuai porsi ke Pengguna Jasa</p></td>
            </tr>
            <tr>
                <td style="width:2%"><p style="margin: 0; padding:0; font-size:0.5rem">3.</p></td>
                <td style="width:5%"><input type="checkbox" id="opsi-loan-3" {{ !empty($proyek->fasilitas_ncl) && str_contains($proyek->fasilitas_ncl, 'Diajukan untuk counter sesuai porsi ke salah satu member KSO (khusus NCL yang diterbitkan oleh Bank)') ? 'checked' : '' }}></td>
                <td style="width:90%"><p style="margin: 0; padding:0; font-size:0.5rem">Diajukan untuk counter sesuai porsi ke salah satu member KSO (khusus NCL yang diterbitkan oleh Bank)</p></td>
            </tr>
        </table>
        <small style="font-size: 0.5rem">*) Pilih salah satu, diisi oleh Pengusul</small>
        <br>
        <p style="font-size: 0.5rem; margin:5px 0px 5px 0px; padding:0"><b>Data yang disampaikan dalam form ini adalah benar dan dapat dipertanggungjawabkan.</b></p>
        <p style="margin: 5px 0px 0px 0px; padding:0; font-size:0.5rem">Jakarta, {{ \Carbon\Carbon::parse()->translatedFormat('d F Y') }}</p>
        <table style="width:100%; margin:0px; padding:0px;">
            <tr>
                <td style="text-align:center">
                    <div class="" style="margin:0px; padding-top:5px;">
                        <p style="margin: 0; padding:0; font-size:0.5rem">Diusulkan Oleh,</p>
                        <br><br>
                        <table style="width:100%">
                            <tr>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.5rem; margin:0px; padding-top:0px;">PJFK Corporate Marketing</p>
                                </td>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.8rem; margin:0px; padding-top:0px;">
                                        <p style="font-size:0.5rem; margin:0px; padding-top:0px;">PJPU Operasi</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="text-align:center">
                    <div class="" style="margin:0px; padding-top:5px;">
                        <p style="margin: 0; padding:0; font-size:0.5rem">Direkomendasikan Oleh,</p>
                        <br><br>
                        <table style="width:100%">
                            <tr>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.5rem; margin:0px; padding-top:0px;">PJFK Risk Management</p>
                                </td>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.5rem; margin:0px; padding-top:0px;">PJFK Finance</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="text-align:center">
                    <div class="" style="margin:0px; padding-top:5px;">
                        <p style="margin: 0; padding:0; font-size:0.5rem">Disetujui Oleh,</p>
                        <br><br>
                        <table style="width:100%">
                            <tr>
                                <td style="width:100%; text-align:center">
                                    <p style="font-size:0.5rem; margin:0px; padding-top:0px;">Direktur Operasi Pembina</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    @if ($proyek->PorsiJO->count() > 1)
    </div>
    @endif

    
    {{-- <footer>*Dokumen ini dibuat oleh sistem CRM</footer> --}}

</body>

</html>
