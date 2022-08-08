<?php

namespace App\Http\Controllers;

use App\Models\AddendumContractAmandemen;
use App\Models\AddendumContractDiajukan;
use App\Models\AddendumContractDisetujui;
use App\Models\AddendumContractDrafts;
use App\Models\AddendumContractNegoisasi;
use App\Models\AddendumContracts;
use App\Models\ContractManagements;
use DateTime;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AddendumContractController extends Controller
{
    public function changeRequest(Request $request)
    {
        $column = $request->get("column");
        $filter = $request->get("filter");
        
        if ($column == "uraian_perubahan"){
            $addendumContracts = AddendumContractDrafts::sortable()->join("contract_managements", "contract_managements.id_contract", "=", "addendum_contracts.id_contract")->join("proyeks", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where("uraian_perubahan", 'like', '%'.$filter.'%')->get();
        }else if (!empty($column)){
            $addendumContracts = AddendumContracts::sortable()->join("contract_managements", "contract_managements.id_contract", "=", "addendum_contracts.id_contract")->join("proyeks", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->where($column, 'like', '%'.$filter.'%')->get();
        }else{
            $addendumContracts = AddendumContracts::sortable()->join("contract_managements", "contract_managements.id_contract", "=", "addendum_contracts.id_contract")->join("proyeks", "contract_managements.project_id", "=", "proyeks.kode_proyek")->where("proyeks.unit_kerja", "=", Auth::user()->unit_kerja)->get();
        // $arrayDrafts = [];
        // foreach ($addendumContracts as $addendumContract) {
        //     $idAddendum = $addendumContract->id_addendum;
        //     $addendumDrafts = AddendumContractDrafts::sortable()->where("id_addendum", '=', $idAddendum)->get();
        //     // dump($addendumDrafts->each);
        //     array_push($arrayDrafts, $addendumDrafts->each);
        //     }
        //     dump($arrayDrafts);
        }    
        // dd();
        
        return view("9_Change_request", compact(["addendumContracts", 'column', 'filter']));
    }

    // upload data addendum to server or database
    public function upload(Request $request, AddendumContracts $addendumContracts)
    {

        $data = $request->all();
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            // "document-name-addendum-menang" => "required|string",
            "addendum-contract-title" => "required|string",
            "addendum-contract-version" => "required|numeric",
            "addendum-contract-start-date" => "required|date",
            "addendum-contract-create-by" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        // if (!Session::has("pasals")) {
        //     $request->old("addendum-contract-title");
        //     $request->old("addendum-contract-version");
        //     $request->old("addendum-contract-start-date");
        //     $request->old("addendum-contract-create-by");
        //     return Redirect::back()->with("error", "Pastikan pasal-pasal sudah di ceklis");
        // }
        $validation->validate();
        // if (Session::has("pasals")) {
        //     $pasals = [];
        //     foreach (Session::get("pasals") as $pasal) {
        //         array_push($pasals, $pasal->id_pasal);
        //     }
        // }

        if ($validation->fails()) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            $request->old("addendum-contract-title");
            $request->old("addendum-contract-version");
            $request->old("addendum-contract-start-date");
            $request->old("addendum-contract-create-by");

            return Redirect::back()->with("error", "Please fill 'Addendum Contract' empty field");
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            $request->old("addendum-contract-title");
            $request->old("addendum-contract-version");
            $request->old("addendum-contract-start-date");
            $request->old("addendum-contract-create-by");
            return Redirect::back()->with("error", "Contract not exist");
        }

        $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        // if ($is_tender_menang == 1) {
        //     $rules["document-name-addendum-menang"] = "required|string";
        //     $addendumContracts->document_name = $data["document-name-addendum-menang"];
        // } else {
        // }
        $validation->validate();

        // Update Stages Contract
        // $is_id_contract_exist->stages = 4;
        // $addendumContracts->document_name = $data["document-name-addendum"];
        $addendumContracts->created_by = $data["addendum-contract-create-by"];
        $addendumContracts->start_date = $data["addendum-contract-start-date"];
        $addendumContracts->id_contract = $data["id-contract"];
        $addendumContracts->tender_menang = $is_tender_menang;
        $addendumContracts->stages = 1;
        $addendumContracts->addendum_contract_version = $data["addendum-contract-version"];
        $addendumContracts->no_addendum = $data["addendum-contract-title"];
        if ($addendumContracts->save() && $is_id_contract_exist->save()) {
            Alert::success("Success", "Addendum Kontrak berhasil dibuat");
            return Redirect::to("/contract-management/view/$addendumContracts->id_contract");
        }
        Alert::error("Error", "Addendum Kontrak berhasil dibuat");
        return Redirect::back();
    }

    // upload data addendum to server or database
    public function update(Request $request)
    {

        $data = $request->all();
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            // "document-name-addendum-menang" => "required|string",
            "addendum-contract-title" => "required|string",
            "addendum-contract-version" => "required|numeric",
            "id-addendum" => "required|numeric",
            "addendum-contract-start-date" => "required|date",
            "addendum-contract-create-by" => "required|string",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if (!Session::has("pasals")) {
            $request->old("addendum-contract-title");
            $request->old("addendum-contract-version");
            $request->old("addendum-contract-start-date");
            $request->old("addendum-contract-create-by");
            $request->old("id-addendum");
            $validation->validate();
            return Redirect::back()->with("error", "Pastikan pasal-pasal sudah di ceklis");
        }
        if (Session::has("pasals")) {
            $pasals = [];
            foreach (Session::get("pasals") as $pasal) {
                array_push($pasals, $pasal->id_pasal);
            }
            Session::forget("pasals");
        }

        if ($validation->fails()) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            $request->old("addendum-contract-title");
            $request->old("addendum-contract-version");
            $request->old("addendum-contract-start-date");
            $request->old("addendum-contract-create-by");
            Alert::error("Error", "Silahkan isi data yang kosong terlebih dahulu!");
            return Redirect::back()->with("error", "Please fill 'Addendum Contract' empty field");
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            $request->old("addendum-contract-title");
            $request->old("addendum-contract-version");
            $request->old("addendum-contract-start-date");
            $request->old("addendum-contract-create-by");
            return Redirect::back()->with("error", "Contract not exist");
        }

        $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        // if ($is_tender_menang == 1) {
        //     $rules["document-name-addendum-menang"] = "required|string";
        //     $addendumContracts->document_name = $data["document-name-addendum-menang"];
        // } else {
        // }
        $validation->validate();

        $addendumContracts = AddendumContracts::find($data["id-addendum"]);

        // Update Stages Contract
        $is_id_contract_exist->stages = 4;
        // $addendumContracts->document_name = $data["document-name-addendum"];
        $addendumContracts->created_by = $data["addendum-contract-create-by"];
        $addendumContracts->start_date = $data["addendum-contract-start-date"];
        $addendumContracts->id_contract = $data["id-contract"];
        $addendumContracts->tender_menang = $is_tender_menang;
        $addendumContracts->stages = 1;
        $addendumContracts->pasals = join(",", $pasals) ?? "";
        $addendumContracts->addendum_contract_version = $data["addendum-contract-version"];
        $addendumContracts->no_addendum = $data["addendum-contract-title"];
        if ($addendumContracts->save() && $is_id_contract_exist->save()) {
            Alert::success("Success", "Addendum Contract berhasil diperbarui");
            return Redirect::to("/contract-management/view/$addendumContracts->id_contract");
        }
        Alert::error("Error", "Addendum Contract gagal diperbarui");
        return Redirect::back();
    }

    // Save Draft of Addendum to Server or Database
    public function draftUpload(Request $request, AddendumContractDrafts $addendumContractDrafts)
    {

        $data = $request->all();
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            "pengajuan-waktu" => "required|date",
            "surat-instruksi" => "required|file",
            "draft-proposal-addendum" => "required|file",
            "draft-rekomendasi" => "required|boolean",
            "uraian-rekomendasi" => "required|string",
            "uraian-perubahan" => "required|string",
            "pengajuan-biaya" => "required|numeric",
            "id-addendum" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        $validation->validate();

        $faker = new Uuid();
        $id_document = $faker->uuid3();
        if ($validation->fails()) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            // $request->old("note-addendum");
            // $request->old("document-name-addendum");
            // $request->old("document-name-addendum-menang");
            // $request->old("attach-file-addendum");
            Alert::error("Error", "Silahkan isi data yang kosong!");
            return Redirect::back();
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            $request->old("note-addendum");
            $request->old("document-name-addendum");
            $request->old("document-name-addendum-menang");
            $request->old("attach-file-addendum");
            Alert::error("Error", "Pastikan kontrak sudah dibuat!");
            return Redirect::back();
        }

        $pasals = [];
        if (Session::has("pasals")) {
            foreach (Session::get("pasals") as $pasal) {
                array_push($pasals, $pasal->id_pasal);
            }
            Session::forget("pasals");
        }

        // $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        // if ($is_tender_menang == 1) {
        //     $addendumContracts->document_name_addendum = $data["document-name-addendum-menang"];
        // } else {
        // }
        $id_document_instruksi_name = $faker->uuid3();
        $id_document_draft_proposal_addendum_name = $faker->uuid3();

        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
        $addendumContractDrafts->list_id_document_pendukung = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $addendumContractDrafts->list_id_document_pendukung = $id_document;
        }

        $addendumContractDrafts->id_addendum = $data["id-addendum"];
        $addendumContractDrafts->id_contract = $data["id-contract"];
        $addendumContractDrafts->id_document_instruksi = $id_document_instruksi_name;
        $addendumContractDrafts->rekomendasi = (bool) $data["draft-rekomendasi"];
        $addendumContractDrafts->uraian_rekomendasi = $data["uraian-rekomendasi"];
        $addendumContractDrafts->uraian_perubahan = $data["uraian-perubahan"];
        $addendumContractDrafts->pengajuan_waktu = $data["pengajuan-waktu"];
        $addendumContractDrafts->pengajuan_biaya = $data["pengajuan-biaya"];
        $addendumContractDrafts->id_document_draft_proposal_addendum = $id_document_draft_proposal_addendum_name;
        $addendumContractDrafts->pasals = join(",", $pasals);
        if ($addendumContractDrafts->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["surat-instruksi"], $id_document_instruksi_name);
            moveFileTemp($data["draft-proposal-addendum"], $id_document_draft_proposal_addendum_name);

            Alert::success("Success", "Addendum Draft berhasil dibuat");
            return Redirect::to("/contract-management/view/" . $data['id-contract'] . "/addendum-contract/$addendumContractDrafts->id_addendum");
        }
        Alert::error("Error", "Addendum Draft gagal dibuat");
        return Redirect::back();
    }

    public function draftUpdate(Request $request)
    {

        $data = $request->all();
        $addendumContractDrafts = AddendumContractDrafts::find($data["id-addendum-draft"]);
        $messages = [
            "required" => "This field is required",
            "numeric" => "This field must be numeric only",
            "file" => "This field must be file only",
            "string" => "This field must be alphabet only",
            "date" => "This field must be date format only",
        ];
        $rules = [
            "attach-file-addendum" => "file",
            // "document-name-addendum-menang" => "required|string",
            "document-name-addendum" => "required|string",
            "note-addendum" => "required|string",
            "id-contract" => "required|numeric",
        ];
        $validation = Validator::make($data, $rules, $messages);
        $validation->validate();

        if (isset($file)) {
            $faker = new Uuid();
            $id_document = $faker->uuid3();
        }

        if ($validation->fails()) {
            // Session::flash("failed", "Please fill 'Draft Contract' empty field");
            $request->old("note-addendum");
            $request->old("document-name-addendum");
            $request->old("document-name-addendum-menang");
            $request->old("attach-file-addendum");

            return Redirect::back()->with("error", "Please fill 'Addendum Contract' empty field");
        }

        // Check ID Contract exist
        $is_id_contract_exist = ContractManagements::find($data["id-contract"]);

        if (empty($is_id_contract_exist)) {
            dd("contract exist");
            $request->old("note-addendum");
            $request->old("document-name-addendum");
            $request->old("document-name-addendum-menang");
            $request->old("attach-file-addendum");
            return Redirect::back()->with("error", "Contract not exist");
        }

        $is_tender_menang = !empty($data["is-tender-menang"]) ? 1 : 0;
        if ($is_tender_menang == 1) {
            $rules["document-name-addendum-menang"] = "required|string";
            $addendumContractDrafts->document_name_addendum = $data["document-name-addendum-menang"];
        } else {
            $addendumContractDrafts->document_name_addendum = $data["document-name-addendum"] ?? $addendumContractDrafts->document_name_addendum;
        }
        $addendumContractDrafts->id_document = $id_document ?? $addendumContractDrafts->id_document;
        // $addendumContractDrafts->id_addendum = $data["id-addendum"];
        $addendumContractDrafts->note_addendum = $data["note-addendum"];
        // $addendumContractDrafts->tender_menang = $is_tender_menang;
        if ($addendumContractDrafts->save()) {
            // Session::forget("pasals");
            if (isset($file)) {
                moveFileTemp($file, $id_document);
            }
            return Redirect::to("/contract-management/view/" . $data['id-contract'] . "/addendum-contract/$addendumContractDrafts->id_addendum")->with("success", "Your Draft Addendum Contract has been updated");
        }
        return Redirect::back()->with("error", "Your Draft Addendum Contract failed to update");
    }

    public function draftDiajukanUpload(Request $request, AddendumContractDiajukan $addendumContractDiajukan)
    {
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


        $id_document_proposal_addendum = $faker->uuid3();

        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $addendumContractDiajukan->list_id_document_pendukung = $id_document;
        }

        $addendumContractDiajukan->id_addendum = $data["id-addendum"];
        $addendumContractDiajukan->id_document_proposal_addendum = $id_document_proposal_addendum;
        $addendumContractDiajukan->tanggal_diajukan = $data["tanggal-diajukan"];
        $addendumContractDiajukan->rekomendasi = (bool) $data["diajukan-rekomendasi"];
        $addendumContractDiajukan->uraian_rekomendasi = $data["uraian-rekomendasi"];
        $addendumContractDiajukan->dokumen_pendukung = join(",", $list_id_document_pendukung);
        if ($addendumContractDiajukan->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["proposal-addendum"], $id_document_proposal_addendum);
            Alert::success("Success", "Kontrak Diajukan berhasil dibuat");
            return redirect()->back();
        }

        Alert::error("Error", "Kontrak Diajukan gagal dibuat");
        return Redirect::back();
    }

    public function draftNegoisasiUpload(Request $request, AddendumContractNegoisasi $addendumContractNegoisasi)
    {
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

        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $addendumContractNegoisasi->list_id_document_pendukung = $id_document;
        }

        $addendumContractNegoisasi->id_addendum = $data["id-addendum"];
        $addendumContractNegoisasi->uraian_activity = $data["uraian-activity"];
        $addendumContractNegoisasi->tanggal_activity = $data["tanggal-activity"];
        $addendumContractNegoisasi->dokumen_pendukung = join(",", $list_id_document_pendukung);
        $addendumContractNegoisasi->keterangan = $data["keterangan"];
        if ($addendumContractNegoisasi->save()) {
            // Session::forget("pasals");
            Alert::success("Success", "Kontrak Negosiasi berhasil dibuat");
            return redirect()->back();
        }

        Alert::error("Error", "Kontrak Negosiasi gagal dibuat");
        return Redirect::back();
    }

    public function draftDisetujuiUpload(Request $request, AddendumContractDisetujui $addendumContractDisetujui)
    {
        $data = $request->all();
        // dd($data);
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

        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
            $addendumContractDisetujui->dokumen_pendukung = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $addendumContractDisetujui->dokumen_pendukung = $id_document;
        }

        $addendumContractDisetujui->id_addendum = $data["id-addendum"];
        $addendumContractDisetujui->id_document_surat_disetujui = $id_document_surat_disetujui;
        $addendumContractDisetujui->tanggal_disetujui = $data["tanggal-disetujui"];
        $addendumContractDisetujui->biaya_disetujui = $data["biaya-disetujui"];
        $addendumContractDisetujui->waktu_eot_disetujui = $data["waktu-eot-disetujui"];
        $addendumContractDisetujui->keterangan = $data["keterangan-disetujui"];
        if ($addendumContractDisetujui->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["surat-disetujui"], $id_document_surat_disetujui);
            Alert::success("Success", "Buat Kontrak Disetujui berhasil dibuat");
            return redirect()->back();
        }

        Alert::error("Error", "Buat Kontrak Disetujui gagal dibuat");
        return Redirect::back();
    }

    public function draftAmandemenUpload(Request $request, AddendumContractAmandemen $addendumContractAmandemen)
    {
        $data = $request->all();
        // dd($data);
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


        $id_dokumen_amandemen = $faker->uuid3();

        if (count($data["dokumen-pendukung"]) > 1) {
            $list_id_document_pendukung = [];
            foreach ($data["dokumen-pendukung"] as $dokumen_pendukung) {
                $id_document = $faker->uuid3();
                array_push($list_id_document_pendukung, $id_document);
                moveFileTemp($dokumen_pendukung, $id_document);
            }
            $addendumContractAmandemen->dokumen_pendukung = join(",", $list_id_document_pendukung);
        } else {
            $id_document = $faker->uuid3();
            moveFileTemp($data["dokumen-pendukung"][0], $id_document);
            $addendumContractAmandemen->dokumen_pendukung = $id_document;
        }

        $addendumContractAmandemen->id_addendum = $data["id-addendum"];
        $addendumContractAmandemen->id_dokumen_amandemen = $id_dokumen_amandemen;
        $addendumContractAmandemen->tanggal_amandemen = $data["tanggal-amandemen"];
        $addendumContractAmandemen->biaya_amandemen = $data["biaya-amandemen"];
        $addendumContractAmandemen->waktu_eot_amandemen = $data["waktu-eot-amandemen"];
        $addendumContractAmandemen->keterangan = $data["keterangan-amandemen"];
        if ($addendumContractAmandemen->save()) {
            // Session::forget("pasals");
            moveFileTemp($data["dokumen-amandemen"], $id_dokumen_amandemen);
            Alert::success("Success", "Buat Kontrak Amandemen berhasil");
            return redirect()->back();
        }

        Alert::error("Error", "Buat Kontrak Amandemen gagal");
        return Redirect::back();
    }
}
