<?php

namespace App\Http\Controllers;

use App\Models\AssessmentPartnerSelection;
use App\Models\KriteriaPenggunaJasa;
use App\Models\LegalitasPerusahaan;
use App\Models\MatriksApprovalPartnerSelection;
use App\Models\PartnerSelectionDetail;
use App\Models\PenilaianPartnerSelection;
use App\Models\PorsiJO;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AssessmentPartnerSelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_super_user_counter = MatriksApprovalPartnerSelection::all()->filter(function ($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });
        $is_user_exist_in_matriks_approval = $all_super_user_counter->contains(function ($user) {
            return $user->Pegawai->nama_pegawai == Auth::user()->name;
        });

        $matriks_user = Auth::user()->Pegawai->MatriksPartner ?? null;
        $collectDivisiMatriksUser = $matriks_user?->groupBy('divisi_id')->keys()->values()->toArray() ?? [];
        $collectDepartemenMatriksUser = $matriks_user?->groupBy('departemen_code')->keys()->values()->toArray() ?? [];

        $partnerApprovalAll = AssessmentPartnerSelection::with('PartnerJO')->whereIn('divisi_id', $collectDivisiMatriksUser)?->whereIn('departemen_id', $collectDepartemenMatriksUser)?->get();
        $customers = $partnerApprovalAll
            ->where(function ($query) {
                return $query->PartnerJO->id_company_jo != null;
            })
            ->where(function ($query) {
                return !is_null($query->PartnerJO->is_greenlane) && $query->PartnerJO->is_greenlane == false;
            })
            ->where(function ($query) {
                return !is_null($query->PartnerJO->is_disetujui) && $query->PartnerJO->is_disetujui == true;
            });
        $partnerDetail = PartnerSelectionDetail::all();
        $kriteriaPenilaian = PenilaianPartnerSelection::where('is_active', true)->get();

        if ($kriteriaPenilaian->isEmpty()) {
            Alert::error('Error', 'Mohon isi Master Data Penilaian Risiko Partner terlebih dahulu!');

            if (Gate::allows('super-admin')) {
                return redirect('/penilaian-partner-selection');
            } else {
                return redirect('/proyek');
            }
        }

        return view('16_Partner_Selection_Assessment', [
            'customers' => $customers,
            'partnerDetail' => $partnerDetail,
            'kriteriaPenilaian' => $kriteriaPenilaian,
            'matriks_user' => $matriks_user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $collectJawaban = [];

        $index = collect($data['index']);

        $legalitasMaster = LegalitasPerusahaan::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaMaster = KriteriaPenggunaJasa::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $partnerDetail = new PartnerSelectionDetail();

        $current_timestamp = Carbon::now();

        foreach ($index as $key => $urutan) {
            if ($key <= ($legalitasMaster->count() - 1)) {
                if (isset($data["dokumen_legalitas_$key"])) {
                    $files = collect($data["dokumen_legalitas_$key"])->values();
                    $array_files = collect();

                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $legalitasMaster[$key]->kategori;
                    $partnerDetail->kriteria = $data["is_legalitas_" . $urutan];
                    $partnerDetail->nilai = null;
                    $partnerDetail->keterangan = $data["is_legalitas_keterangan"][$key];

                    foreach ($files as $file) {
                        $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                        $array_files->push($id_document);
                        $file->move(public_path('file-selection-partner'), $id_document);
                    }

                    $partnerDetail->id_document = $array_files->toJson();
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                } else {
                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $legalitasMaster[$key]->kategori;
                    $partnerDetail->kriteria = $data["is_legalitas_" . $urutan];
                    $partnerDetail->nilai = null;
                    $partnerDetail->keterangan = $data["is_legalitas_keterangan"][$key];
                    $partnerDetail->id_document = null;
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                }
            } else {
                if (isset($data["dokumen_penilaian_$key"])) {
                    $files = collect($data["dokumen_penilaian_$key"])->values();
                    $array_files = collect();

                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $kriteriaMaster[(int)$urutan - 1]->kategori;
                    $partnerDetail->kriteria = $data["is_kriteria_" . $urutan];
                    $partnerDetail->nilai = (float)$data['nilai'][(int)$urutan - 1];
                    $partnerDetail->keterangan = $data["keterangan"][(int)$urutan - 1];

                    foreach ($files as $file) {
                        $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                        $array_files->push($id_document);
                        $file->move(public_path('file-selection-partner'), $id_document);
                    }

                    $partnerDetail->id_document = $array_files->toJson();
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                } else {
                    $partnerDetail->partner_id = $data["id_partner"];
                    $partnerDetail->item = $kriteriaMaster[(int)$urutan - 1]->item;
                    $partnerDetail->kriteria = $data["is_kriteria_" . $urutan];
                    $partnerDetail->nilai = (float)$data['nilai'][(int)$urutan - 1];
                    $partnerDetail->keterangan = $data["keterangan"][(int)$urutan - 1];
                    $partnerDetail->id_document = null;
                    $partnerDetail->urutan = $urutan;
                    $partnerDetail->kode_proyek = $data["kode_proyek"];
                    $partnerDetail->index = $key;
                }
            }

            $collectJawaban[] = $partnerDetail->attributesToArray();
        }

        if (PartnerSelectionDetail::insert($collectJawaban)) {
            Alert::success("Success", "Partner Selection berhasil dibuat!");
            return redirect()->back();
        }

        Alert::error("Error", "Partner Selection gagal dibuat!");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $legalitasMaster = LegalitasPerusahaan::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();
        $kriteriaMaster = KriteriaPenggunaJasa::where('nota_rekomendasi', 'Nota Rekomendasi 2')->where('is_active', true)->get()->sortBy('position')->values();

        try {
            foreach ($data['id_detail'] as $key => $value) {
                $kriteriaDetail = PartnerSelectionDetail::find($data['id_detail'][$key]);
                $current_file = collect(json_decode($kriteriaDetail->id_document, true));
                $urutan = $data['index'][$key];

                if ($key <= ($legalitasMaster->count() - 1)) {
                    $kriteriaDetail->item = $legalitasMaster[$key]->kategori;
                    $kriteriaDetail->kriteria = $data["is_legalitas_" . $urutan];
                    $kriteriaDetail->nilai = null;
                    $kriteriaDetail->keterangan = $data["is_legalitas_keterangan"][$key];

                    $files = $data["dokumen_legalitas_$key"] ?? null;
                    if (!empty($files)) {
                        foreach ($files as $file) {
                            $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                            $current_file->push($id_document);
                            $file->move(public_path('file-selection-partner'), $id_document);
                        }
                    }
                    $kriteriaDetail->id_document = empty($current_file) || $current_file->isEmpty() ? null : $current_file->toJson();
                } else {
                    $kriteriaDetail->item = $kriteriaMaster[(int)$urutan - 1]->kategori;
                    $kriteriaDetail->kriteria = $data["is_kriteria_" . $urutan];
                    $kriteriaDetail->nilai = (float)$data['nilai'][(int)$urutan - 1];
                    $kriteriaDetail->keterangan = $data["keterangan"][(int)$urutan - 1];

                    $files = $data["dokumen_penilaian_$urutan"] ?? null;
                    if (!empty($files)) {
                        foreach ($files as $file) {
                            $id_document = date("His_") . $key . '_' . str_replace(' ', '-', $file->getClientOriginalName());
                            $current_file->push($id_document);
                            $file->move(public_path('file-selection-partner'), $id_document);
                        }
                    }
                    $kriteriaDetail->id_document = empty($current_file) || $current_file->isEmpty() ? null : $current_file->toJson();
                }

                $kriteriaDetail->save();
            }
            // dd("Tes");
            Alert::success("Success", "Form Kriteria Partner Selection berhasil diperbaharui!");
            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error("Error", $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFile(Request $request)
    {
        try {
            $data = $request->all();

            $partnerSelected = PartnerSelectionDetail::find($data["id"]);
            $list_documents = collect(json_decode($partnerSelected["id_document"]));
            $updated_docs = collect();

            foreach ($list_documents as $doc) {
                if ($doc == $data["file-name"]) {
                    File::delete(public_path('/file-selection-partner//' . $doc));
                } else {
                    $updated_docs->push($doc);
                }
            }

            $partnerSelected->id_document = empty($updated_docs) || $updated_docs->isEmpty() ? null : $updated_docs;

            if ($partnerSelected->save()) {
                Alert::success("Success", "Form Kriteria Partner Selection berhasil berhasil diperbaharui!");
                return redirect()->back();
            }
        } catch (\Exception $th) {
            Alert::success("Error", "Form Kriteria Partner Selection gagal diperbaharui! Mohon untuk hubungi admin.");
            Log::error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Pengajuan KSO
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response JSON {success, message}
     */
    public function pengajuanApprovalKSO(Request $request)
    {
        $data = $request->all();
        $proyek = Proyek::find($data['kode_proyek']);

        if (empty($proyek)) {
            return response()->json([
                'success' => false,
                'message' => 'Proyek Tidak Ditemukan. Hubungi Admin!'
            ], 500);
        }

        $partnerKSO = $proyek->PorsiJO;

        if (empty($partnerKSO)) {
            return response()->json([
                'success' => false,
                'message' => 'Partner KSO belum ditentukan. Mohon tambah partner KSO terlebih dahulu!'
            ], 500);
        }

        try {
            $partnerKSO->each(function ($partner) use ($proyek, $request) {
                $newAssessment = new AssessmentPartnerSelection();
                $newAssessment->kode_proyek = $proyek->kode_proyek;
                $newAssessment->partner_id = $partner->id;
                $newAssessment->divisi_id = $proyek->UnitKerja->Divisi->id_divisi;
                $newAssessment->departemen_id = $proyek->departemen_proyek;
                $newAssessment->save();

                $matriksSelected = self::getMatriksSelanjutnya($proyek->UnitKerja->Divisi->id_divisi, $proyek->departemen_proyek, 'Pengajuan');

                if (empty($matriksSelected)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Matriks Approval Pengajuan Partner Selection tidak ada. Hubungi Admin!'
                    ], 500);
                }

                $url = $request->schemeAndHttpHost() . "?nip=" . $matriksSelected->Pegawai->nip . "&redirectTo=/assessment-partner-selection";
                $message = nl2br("Yth Bapak/Ibu " . $matriksSelected->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan pengajuan Partner Selection untuk " . $partner->Company->name . " pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
                sendNotifEmail($matriksSelected->Pegawai->email, "Permohonan Pengajuan Approval Partner Selection", $message);
            });

            return response()->json([
                'success' => true,
                'message' => 'Partner KSO berhasil diajukan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approval Pengajuan KSO
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response JSON {success, message}
     */
    public function setApprovalPengajuan(Request $request)
    {
        $data = $request->all();
        $assessmentSelection = AssessmentPartnerSelection::find($data['id_partner']);
        $proyek = Proyek::find($assessmentSelection->kode_proyek);
        $is_form = isset($data["is_form"]) ? true : false;


        if (empty($assessmentSelection)) {
            if ($is_form) {
                Alert::error('Error', 'Partner tidak ditemukan. Hubungi Admin!');
                return redirect()->back();
            }
            return response()->json([
                'success' => false,
                'message' => 'Partner tidak ditemukan. Hubungi Admin!'
            ], 500);
        }

        $approval_pengajuan = collect(json_decode($assessmentSelection->approved_pengajuan));

        if ($data['is_setuju'] == 't') {
            $approval_pengajuan = $approval_pengajuan->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => Carbon::now(),
            ]);
            $assessmentSelection->is_pengajuan_approved = true;
            $assessmentSelection->approved_pengajuan = $approval_pengajuan;
        } else {
            $approval_pengajuan = $approval_pengajuan->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => Carbon::now(),
                "catatan" => $data["alasan_tolak"]
            ]);
            $assessmentSelection->is_pengajuan_approved = false;
            $assessmentSelection->approved_pengajuan = $approval_pengajuan;
        }

        if ($assessmentSelection->save()) {
            $matriksSelected = self::getMatriksSelanjutnya($proyek->UnitKerja->Divisi->id_divisi, $proyek->departemen_proyek, 'Pengajuan');

            if (empty($matriksSelected)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matriks Approval Persetujuan Partner Selection tidak ada. Hubungi Admin!'
                ], 500);
            }

            $url = $request->schemeAndHttpHost() . "?nip=" . $matriksSelected->Pegawai->nip . "&redirectTo=/assessment-partner-selection";
            $message = nl2br("Yth Bapak/Ibu " . $matriksSelected->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan persetujuan Partner Selection untuk " . $assessmentSelection->PartnerJO->Company->name . " pada proyek $proyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            sendNotifEmail($matriksSelected->Pegawai->email, "Permohonan Persetujuan Approval Partner Selection", $message);

            if ($is_form) {
                Alert::success('Success', 'Partner berhasil ditolak');
                return redirect()->back();
            }
            return response()->json([
                'success' => true,
                'message' => 'Partner berhasil disetujui'
            ]);
        }
        if ($is_form) {
            Alert::error('Error', 'Partner gagal disetujui. Hubungi Admin!');
            return redirect()->back();
        }
        return response()->json([
            'success' => false,
            'message' => 'Partner gagal disetujui. Hubungi Admin!'
        ], 500);
    }

    /**
     * Approval Persetujuan KSO
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response JSON {success, message}
     */
    public function setApprovalPersetujuan(Request $request)
    {
        $data = $request->all();
        $assessmentSelection = AssessmentPartnerSelection::find($data['id_partner']);
        $is_form = isset($data["is_form"]) ? true : false;


        if (empty($assessmentSelection)) {
            if ($is_form) {
                Alert::error('Error', 'Partner tidak ditemukan. Hubungi Admin!');
                return redirect()->back();
            }
            return response()->json([
                'success' => false,
                'message' => 'Partner tidak ditemukan. Hubungi Admin!'
            ], 500);
        }

        $approval_persetujuan = collect(json_decode($assessmentSelection->approved_disetujui));

        if ($data['is_setuju'] == 't') {
            $approval_persetujuan = $approval_persetujuan->push([
                "user_id" => Auth::user()->id,
                "status" => "approved",
                "tanggal" => Carbon::now(),
            ]);
            $assessmentSelection->is_disetujui = true;
            $assessmentSelection->approved_disetujui = $approval_persetujuan;
        } else {
            $approval_persetujuan = $approval_persetujuan->push([
                "user_id" => Auth::user()->id,
                "status" => "rejected",
                "tanggal" => Carbon::now(),
                "catatan" => $data["alasan_tolak"]
            ]);
            $assessmentSelection->is_disetujui = false;
            $assessmentSelection->approved_disetujui = $approval_persetujuan;
        }

        if ($assessmentSelection->save()) {
            if ($is_form) {
                Alert::success('Success', 'Partner berhasil ditolak');
                return redirect()->back();
            }
            return response()->json([
                'success' => true,
                'message' => 'Partner berhasil disetujui'
            ]);
        }
        if ($is_form) {
            Alert::error('Error', 'Partner gagal disetujui. Hubungi Admin!');
            return redirect()->back();
        }
        return response()->json([
            'success' => false,
            'message' => 'Partner gagal disetujui. Hubungi Admin!'
        ], 500);
    }

    /**
     * Revisi Approval KSO
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response JSON {success, message}
     */
    public function setApprovalRevisi(Request $request)
    {
        $data = $request->all();
        $assessmentSelection = AssessmentPartnerSelection::find($data['id_partner']);
        $is_form = isset($data["is_form"]) ? true : false;


        if (empty($assessmentSelection)) {
            if ($is_form) {
                Alert::error('Error', 'Partner tidak ditemukan. Hubungi Admin!');
                return redirect()->back();
            }
            return response()->json([
                'success' => false,
                'message' => 'Partner tidak ditemukan. Hubungi Admin!'
            ], 500);
        }

        $revisi_approval = collect(json_decode($assessmentSelection->approved_revisi));

        $revisi_approval = $revisi_approval->push([
            "user_id" => Auth::user()->id,
            "status" => "rejected",
            "tanggal" => Carbon::now(),
            "catatan" => $data["catatan_revisi"]
        ]);
        $assessmentSelection->is_revisi = true;
        $assessmentSelection->approved_revisi = $revisi_approval;


        $assessmentSelection->is_pengajuan_approved = null;
        $assessmentSelection->approved_pengajuan = null;

        if ($assessmentSelection->save()) {
            if ($is_form) {
                Alert::success('Success', 'Partner berhasil dikembalikan ke tahap Pengajuan');
                return redirect()->back();
            }
            return response()->json([
                'success' => true,
                'message' => 'Partner berhasil dikembalikan ke tahap Pengajuan'
            ]);
        }
        if ($is_form) {
            Alert::error('Error', 'Partner gagal dikembalikan ke tahap Pengajuan');
            return redirect()->back();
        }
        return response()->json([
            'success' => false,
            'message' => 'Partner gagal dikembalikan ke tahap Pengajuan'
        ], 500);
    }

    /**
     * Get Matriks untuk mengirim notifikasi email
     * @return \App\Models\MatriksApprovalPartnerSelection
     */
    private function getMatriksSelanjutnya(string $divisi, string $departemen, string $kategori)
    {
        return MatriksApprovalPartnerSelection::where('is_active', true)->where('divisi_id', $divisi)->where('departemen_code', $departemen)->where('kategori', $kategori)->first();
    }
}
