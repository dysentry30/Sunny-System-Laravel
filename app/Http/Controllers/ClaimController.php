<?php

namespace App\Http\Controllers;

use App\Models\ClaimContractDiajukan;
use App\Models\ClaimContractDisetujui;
use App\Models\ClaimContractDrafts;
use App\Models\ClaimContractNegoisasi;
use DateTime;
use Faker\Core\Uuid;
use App\Models\Proyek;
use App\Models\ClaimDetails;
use Illuminate\Http\Request;
use App\Models\ClaimManagements;
use App\Models\ContractManagements;
use App\Models\Pasals;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $column = $request->get("column");
        $filter = $request->get("filter");
        
        if (!empty($column)){
            $proyekClaim = ClaimManagements::sortable()->where('jenis_claim', '=', "Claim")->where($column, 'like', '%'.$filter.'%')->get();
            
            $proyekAnti = ClaimManagements::sortable()->where('jenis_claim', '=', "Anti Claim")->where($column, 'like', '%'.$filter.'%')->get();
            
            $proyekAsuransi = ClaimManagements::sortable()->where('jenis_claim', '=', "Claim Asuransi")->where($column, 'like', '%'.$filter.'%')->get();
            
            // $proyekClaim = Proyek::sortable()->WhereHas('ClaimManagements', function ($claim) use ($column, $filter){
            //     $claim->where('jenis_claim', '=', "Claim")->where($column, 'like', '%'.$filter.'%');
            // })->get();

            // $proyekAnti = Proyek::sortable()->WhereHas('ClaimManagements', function ($claim) {
            //     $claim->where('jenis_claim', '=', "Anti Claim");
            // })->where($column, 'like', '%'.$filter.'%')->get();
            
            // $proyekAsuransi = Proyek::sortable()->WhereHas('ClaimManagements', function ($claim) {
            //     $claim->where('jenis_claim', '=', "Claim Asuransi");
            // })->where($column, 'like', '%'.$filter.'%')->get();
        }else{
            $proyekClaim = ClaimManagements::sortable()->where('jenis_claim', '=', "Claim")->get();
            
            $proyekAnti = ClaimManagements::sortable()->where('jenis_claim', '=', "Anti Claim")->get();
            
            $proyekAsuransi = ClaimManagements::sortable()->where('jenis_claim', '=', "Claim Asuransi")->get();

            // $proyekClaim = Proyek::sortable()->WhereHas('ClaimManagements', function ($claim) {
            //     $claim->where('jenis_claim', '=', "Claim");
            // })->get();

            // $proyekAnti = Proyek::sortable()->WhereHas('ClaimManagements', function ($claim) {
            //     $claim->where('jenis_claim', '=', "Anti Claim");
            // })->get();
            
            // $proyekAsuransi = Proyek::sortable()->WhereHas('ClaimManagements', function ($claim) {
            //     $claim->where('jenis_claim', '=', "Claim Asuransi");
            // })->get();
        }    

        return view("5_Claim", compact(["proyekClaim", "proyekAnti", "proyekAsuransi", "column", "filter"]));
    }

    public function viewClaim($id_proyek, $jenis_claim)
    {
        $proyek = Proyek::find($id_proyek);
        $claim = $proyek->ClaimManagements;
        $jenis_claim = str_replace('-', ' ', $jenis_claim);
        $proyekClaim = [];
        foreach ($claim as $claims) {
            if ($claims->jenis_claim == $jenis_claim) {
                array_push($proyekClaim, $claims);
            }
        }

        // dd($jenis_claim);

        // $proyekClaim = ClaimManagements::where('jenis_claim', "=", "Claim")->get();


        return view("claimManagement/viewClaim", ['proyekClaims' => $proyekClaim, 'proyek' => $proyek, "jenis_claim" => $jenis_claim]);
    }

    public function claimDelete(Request $request)
    {
        $data = $request->all();
        $claim = ClaimManagements::find($data["id-claim"]);
        ClaimDetails::where("id_claim", "=", $claim->id_claim)->get()->each(function ($approval) {
            Storage::disk("public/words")->delete($approval->id_document . ".docx");
            $approval->delete();
        });
        if ($claim->delete()) {
            return redirect("/claim-management")->with("success", "Claim berhasil dihapus");
        }
        return redirect("/claim-management")->with("success", "Claim gagal dihapus");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new(Proyek $proyek, ContractManagements $contract)
    {
        $no_urut = new ClaimManagements();
        if (!empty($no_urut->all()->sortBy("id_claim")->last()->id_claim)) {
            $no_urut = (int) explode(".", $no_urut->all()->sortBy("id_claim")->last()->id_claim ?? 0)[2];
        } else {
            $no_urut = 0;
        }
        if ($no_urut < 1) {
            $no_urut = 1;
        } else {
            $no_urut += 1;
        }
        $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);
        $kode_claim = "CL." . date("Y") . "." . $no_urut;
        return view("claimManagement/new", ["contractManagements" => ContractManagements::all(), "currentContract" => $contract, "proyek" => $proyek, "kode_claim" => $kode_claim, "claimContract" => null]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, ClaimManagements $claimManagements)
    {
        $data = $request->all();
        // if (preg_match("/[^,0-9]/i", $data["total-claim"])) {
        //     return redirect()->back()->with("failed", "Total Claim must be numeric or ',' only");
        // }

        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            "approve-date" => "required|date",
            "pic" => "required|string",
            "project-id" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("approve-date");
            $request->old("pic");
            // $request->old("project-id");
            // $request->old("id-contract");
            $request->old("number-claim");
            $request->old("jenis-claim");
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $validation->validate();
        $claimManagements->id_claim = $data["number-claim"];
        $claimManagements->kode_proyek = $data["project-id"];
        $claimManagements->id_contract = $data["id-contract"];
        $claimManagements->stages = 1;
        $claimManagements->nilai_claim = 0;
        $claimManagements->tanggal_claim = new DateTime($data["approve-date"]);
        $claimManagements->pic = $data["pic"];
        $claimManagements->jenis_claim = $data["jenis-claim"];

        if ($claimManagements->save()) {
            Alert::success("Success", "Claim Berhasil Ditambahkan");
            return redirect("/contract-management/view/" . $data["id-contract"]);
        }
        Alert::error("Error", "Claim Gagal Ditambahkan");
        return redirect("/claim-management");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $approval_name = trim(htmlspecialchars($request->get("approval-claim-name")));
        $id_claim = $request->id_claim;
        $total = $request->total;
        $claimManagement = ClaimManagements::find($id_claim);
        $approval_array = explode(";", trim($claimManagement->approval_claim));
        $index_array = count($approval_array);
        $claimManagement->nilai_claim += $total;
        if ($index_array > 1) {
            $store_data_array = [$index_array, $approval_name, $total];
            $claimManagement->approval_claim = $claimManagement->approval_claim . json_encode($store_data_array) . ";";
        } else {
            $store_data_array = [$index_array, $approval_name, $total];
            $claimManagement->approval_claim = json_encode($store_data_array) . ";";
        }

        if ($claimManagement->save()) {
            return response()->json([
                "status" => "success",
                "message" => "Approval has been added",
                "approval_name" => $approval_name,
                "index_array" => $index_array,
                "nilai_claim" => number_format($claimManagement->nilai_claim, 0, ",", ","),
            ]);
        }
        return response()->json([
            "status" => "success",
            "message" => "Approval failed to add",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClaimManagements $claim_management)
    {
        return view("claimManagement/new", ["currentContract" => $claim_management->contract, "claimContract" => $claim_management, "proyek" => $claim_management->project, "pasals" => Pasals::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id_claim = $request->id_claim;
        $id_requested = $request->index_array;
        $claimManagement = ClaimManagements::find($id_claim);
        $approval_array = explode(";", trim($claimManagement->approval_claim));
        array_pop($approval_array); //remove last array because it's always an empty string
        $approval_array = array_map(function ($data) {
            $data_array = json_decode($data);
            return $data_array;
        }, $approval_array);
        $total = array_map(function ($data) {
            return (int) $data[2];
        }, $approval_array);
        $approval_array = array_filter($approval_array, function ($data) use ($id_requested) {
            return $data[0] != $id_requested;
        });
        $index_array = count($approval_array);
        $total = array_sum($total);
        $store_data_array = "";
        foreach ($approval_array as $approval) {
            $store_data_array .= json_encode($approval) . ";";
            // $store_data_array += "";
        }
        dump($store_data_array);
        // if ($index_array > 1) {
        //     $claimManagement->approval_claim = json_encode($approval_array) . ";";
        // } else {
        //     $claimManagement->approval_claim = "";
        // }
        // $claimManagement->nilai_claim = $total;
        // if ($claimManagement->save()) {
        //     return response()->json([
        //         "status" => "success",
        //         "message" => "Selected approval has been deleted",
        //         "approval_name" => $approval_name,
        //         "index_array" => $index_array,
        //         "nilai_claim" => number_format($claimManagement->nilai_claim, 0, ",", ","),
        //     ]);
        // }
        // return response()->json([
        //     "status" => "success",
        //     "message" => "Approval failed to add",
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        // if (preg_match("/[^,0-9]/i", $data["total-claim"])) {
        //     return redirect()->back()->with("failed", "Total Claim must be numeric or ',' only");
        // }
        $claimManagements = ClaimManagements::find($data["id-claim"]);
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            "approve-date" => "required|date",
            "pic" => "required|string",
            "project-id" => "required|string",
            "id-claim" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("approve-date");
            $request->old("pic");
            $request->old("project-id");
            $request->old("id-contract");
            $request->old("id-claim");
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $validation->validate();
        $claimManagements->kode_proyek = $data["project-id"];
        $claimManagements->id_contract = $data["id-contract"];
        $claimManagements->tanggal_claim = new DateTime($data["approve-date"]);
        $claimManagements->pic = $data["pic"];

        if ($claimManagements->save()) {
            return redirect("/claim-management/view/$claimManagements->id_claim")->with("success", "This claim has been updated");
        }
        return redirect("/claim-management")->with("failed", "This claim failed to update");
    }

    public function detailSave(Request $request, ClaimDetails $claimDetail)
    {
        $data = $request->all();
        $id_claim = $data["id-claim"];
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "string" => "This field must be alphabet only",
            "file" => "This field must be file only"
        ];
        $rules = [
            "attach-file-claim-detail" => "required|file",
            "document-name-claim-detail" => "required|string",
            "note-claim-detail" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("attach-file-claim-detail");
            $request->old("document-name-claim-detail");
            $request->old("note-claim-detail");
            return redirect()->back()->with("failed", "This claim failed to add");
        }
        $faker = new Uuid();
        $id_document = $faker->uuid3();
        $validation->validate();
        $claimDetail->id_document = $id_document;
        $claimDetail->document_name = $data["document-name-claim-detail"];
        $claimDetail->id_claim = $id_claim;
        $claimDetail->note_detail_claim = $data["note-claim-detail"];
        if ($claimDetail->save()) {
            moveFileTemp($data["attach-file-claim-detail"], $id_document);
            return redirect("/claim-management/view/$id_claim")->with("success", "Detail Claim has been added");
        }
        $request->old("attach-file-claim-detail");
        $request->old("document-name-claim-detail");
        $request->old("note-claim-detail");
        return redirect("/claim-management/view/$id_claim")->with("failed", "This claim failed to add");
    }

    public function claimStage(Request $request)
    {
        $id_claim = $request->id_claim;
        $stage = $request->stage;
        // if (!empty($request->get("stage-disetujui"))) {
        //     $stage = 2;
        // } else if (!empty($request->get("stage-ditolak"))) {
        //     $stage = 3;
        // } elseif (!empty($request->get("stage-cancel"))) {
        //     $stage = 4;
        // }

        $claimManagement = ClaimManagements::find($id_claim);
        if ($claimManagement instanceof ClaimManagements) {
            $claimManagement->stages = $stage;
            if ($claimManagement->save()) {
                return response()->json([
                    "status" => "success",
                ]);
                // Alert::success("Success", "Stage berhasil diperbarui");
                // return redirect()->back();
            }
        }
        return response()->json([
            "status" => "failed",
        ]);
        // Alert::error("Error", "Stage gagal diperbarui");
        // return redirect()->back();
    }

    public function claimDraftUpload(Request $request, ClaimContractDrafts $claimContractDrafts) {
        $data = $request->all();
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);
    
        if (empty($is_id_contract_exist)) {
            // $request->old("note-addendum");
            // $request->old("document-name-addendum");
            // $request->old("document-name-addendum-menang");
            // $request->old("attach-file-addendum");
            Alert::error("Error", "Pastikan kontrak sudah dibuat!");
            return Redirect::back();
        }

        $pasals = [];
        if (Session::has("pasals")) {
            foreach (Session::get("pasals") as $pasal) {
                if($pasal instanceof Pasals) {
                    array_push($pasals, $pasal->id_pasal);
                } else {
                    array_push($pasals, $pasal->pasal);
                }
            }
            Session::forget("pasals");
        }

        $faker = new Uuid;
        $id_document_proposal_claim = $faker->uuid3();
        $id_document_surat_instruksi = $faker->uuid3();

        if(count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
            $claimContractDrafts->dokumen_pendukung = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $claimContractDrafts->dokumen_pendukung = $id_document;
        }
        
        $claimContractDrafts->id_claim = $data["id-claim"];
        $claimContractDrafts->no_claim_draft = $data["no-draft-claim"];
        $claimContractDrafts->uraian_claim_draft = $data["uraian-claim"];
        $claimContractDrafts->id_document_proposal_claim = $id_document_proposal_claim;
        $claimContractDrafts->id_document_surat_instruksi = $id_document_surat_instruksi;
        $claimContractDrafts->pengajuan_biaya = (int) str_replace(",", "", $data["pengajuan-biaya"]);
        $claimContractDrafts->rekomendasi = (bool) $data["rekomendasi"];
        $claimContractDrafts->uraian_rekomendasi = $data["uraian-rekomendasi"];
        $claimContractDrafts->pengajuan_waktu_eot = $data["pengajuan-waktu"];
        $claimContractDrafts->pasals = join(",", $pasals);
        if ($claimContractDrafts->save()) {
            $claim_management = ClaimManagements::find($data["id-claim"]);
            $claim_management->nilai_claim += $claimContractDrafts->pengajuan_biaya;
            $claim_management->save();
            // Session::forget("pasals");
            moveFileTemp($data["proposal-claim"], $id_document_proposal_claim);
            moveFileTemp($data["surat-instruksi"], $id_document_surat_instruksi);
            Alert::success("Success", "Buat Draft Claim berhasil");
            return redirect()->back();
        }

        Alert::error("Error", "Buat Draft Claim gagal");
        return Redirect::back();
    }

    public function claimDiajukanUpload(Request $request, ClaimContractDiajukan $claimContractDiajukan) {
        $data = $request->all();
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);
    
        if (empty($is_id_contract_exist)) {
            // $request->old("note-addendum");
            // $request->old("document-name-addendum");
            // $request->old("document-name-addendum-menang");
            // $request->old("attach-file-addendum");
            Alert::error("Error", "Pastikan kontrak sudah dibuat!");
            return Redirect::back();
        }

        $faker = new Uuid;
        $id_document_proposal_claim = $faker->uuid3();

        if(count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $claimContractDiajukan->list_id_document_pendukung = $id_document;
        }

        $claimContractDiajukan->id_claim = $data["id-claim"];
        $claimContractDiajukan->id_document_proposal_claim = $id_document_proposal_claim;
        $claimContractDiajukan->tanggal_diajukan = $data["tanggal-diajukan"];
        $claimContractDiajukan->rekomendasi = (bool) $data["diajukan-rekomendasi"];
        $claimContractDiajukan->uraian_rekomendasi = $data["uraian-rekomendasi"];
        $claimContractDiajukan->dokumen_pendukung = join(",", $list_id_document_pendukung);
        if ($claimContractDiajukan->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["proposal-claim"], $id_document_proposal_claim);
            Alert::success("Success", "Buat Claim Diajukan berhasil");
            return redirect()->back();
        }

        Alert::error("Error", "Buat Claim Diajukan gagal");
        return Redirect::back();
    }

    public function claimNegosiasiUpload(Request $request, ClaimContractNegoisasi $claimContractNegoisasi) {
        $data = $request->all();

        $faker = new Uuid();
        if(count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $claimContractNegoisasi->list_id_document_pendukung = $id_document;
        }

        $claimContractNegoisasi->id_claim = $data["id-claim"];
        $claimContractNegoisasi->uraian_activity = $data["uraian-activity"];
        $claimContractNegoisasi->tanggal_activity = $data["tanggal-activity"];
        $claimContractNegoisasi->dokumen_pendukung = join(",", $list_id_document_pendukung);
        $claimContractNegoisasi->keterangan = $data["keterangan"];
        if ($claimContractNegoisasi->save()) {
            // Session::forget("pasals");
            Alert::success("Success", "Buat Data Negosiasi berhasil");
            return redirect()->back();
        }

        Alert::error("Error", "Buat Data Negosiasi gagal");
        return Redirect::back();
    }

    public function claimDisetujuiUpload(Request $request, ClaimContractDisetujui $claimContractDisetujui) {
        $data = $request->all();
        // $messages = [
        //     "required" => "This field is required",
        //     "numeric" => "This field must be numeric only",
        //     "file" => "This field must be file only",
        //     "string" => "This field must be alphabet only",
        //     "date" => "This field must be date format only",
        // ];
        // $rules = [
        //     "pengajuan-waktu" => "required|date",
        //     "surat-instruksi" => "required|file",
        //     "draft-proposal-addendum" => "required|file",
        //     "draft-rekomendasi" => "required|boolean",
        //     "uraian-rekomendasi" => "required|string",
        //     "uraian-perubahan" => "required|string",
        //     "pengajuan-biaya" => "required|numeric",
        //     "id-addendum" => "required|numeric",
        // ];
        // $validation = Validator::make($data, $rules, $messages);
        // $validation->validate();
    
        $faker = new Uuid();
        $id_document = $faker->uuid3();
        // if ($validation->fails()) {
        //     // Session::flash("failed", "Please fill 'Draft Contract' empty field");
        //     // $request->old("note-addendum");
        //     // $request->old("document-name-addendum");
        //     // $request->old("document-name-addendum-menang");
        //     // $request->old("attach-file-addendum");
        //     Alert::error("Error", "Silahkan isi data yang kosong!");
        //     return Redirect::back();
        // }
    
        // // Check ID Contract exist
        // $is_id_contract_exist = ContractManagements::find($data["id-contract"]);
    
        // if (empty($is_id_contract_exist)) {
        //     $request->old("note-addendum");
        //     $request->old("document-name-addendum");
        //     $request->old("document-name-addendum-menang");
        //     $request->old("attach-file-addendum");
        //     Alert::error("Error", "Pastikan kontrak sudah dibuat!");
        //     return Redirect::back();
        // }

        
        $id_document_surat_disetujui = $faker->uuid3();

        if(count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $claimContractDisetujui->list_id_document_pendukung = $id_document;
        }

        $claimContractDisetujui->id_claim = $data["id-claim"];
        $claimContractDisetujui->id_document_surat_disetujui = $id_document_surat_disetujui;
        $claimContractDisetujui->tanggal_disetujui = $data["tanggal-disetujui"];
        $claimContractDisetujui->biaya_disetujui = $data["biaya-disetujui"];
        $claimContractDisetujui->waktu_eot_disetujui = $data["waktu-eot-disetujui"];
        $claimContractDisetujui->keterangan = $data["keterangan-disetujui"];
        $claimContractDisetujui->dokumen_pendukung = join(",", $list_id_document_pendukung);
        if ($claimContractDisetujui->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["surat-disetujui"], $id_document_surat_disetujui);
            Alert::success("Success", "Buat Data Disetujui berhasil");
            return redirect()->back();
        }

        Alert::error("Error", "Buat Data Disetujui gagal");
        return Redirect::back();
    }
}
