<?php

namespace App\Http\Controllers;

use App\Models\ContractUploadFinal;
use App\Models\DocumentTemplate;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;

class DocumentController extends Controller
{

    function documentDatabaseView(Request $request)
    {
        // $data = $request->all();
        
        $nama_proyek = $request->query("nama-proyek")??"";
        $jenis_dokumen = $request->query("jenis-dokumen")??"";
        // $document_all = ContractUploadFinal::all();
        
        if(Auth::user()->check_administrator){
            $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"];
            $unit_kerjas_all = UnitKerja::whereNotIn("divcode",$unit_kerja_code)->get("divcode");
            $unit_kerjas = UnitKerja::whereNotIn("divcode",  $unit_kerja_code)->get();
        }else{
            $unit_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",",Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            
            $unit_kerja_code =  ["1", "2", "3", "4", "5", "6", "7", "8","B", "C", "D", "N"];
            $unit_kerjas_all = UnitKerja::whereNotIn("divcode", $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get("divcode");
            $unit_kerjas = UnitKerja::whereNotIn("divcode",   $unit_kerja_code)->whereIn("divcode", $unit_user->toArray())->get();
        }

        if(empty($nama_proyek)){
            $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerjas_all)->get();
        }else{
            $proyeks = Proyek::join("contract_managements", "contract_managements.project_id", "=", "proyeks.kode_proyek")->whereIn("unit_kerja", $unit_kerjas_all)->where("kode_proyek", "=", $nama_proyek)->get();
        }
        $contracts = $proyeks->map(function ($item){
            return $item->ContractManagements;
        });

        $documents = $contracts->map(function ($item){
            return $item->UploadFinal;
        })->flatten()->sortByDesc('created_at');
        
        if(!empty($jenis_dokumen)){
            $documents = $documents->where("category", "=", $jenis_dokumen);
        }

        $category_document = ContractUploadFinal::all()->groupBy("category")->keys();

        // dd($category_document);
        return view("6_Document", compact(['documents', 'proyeks', 'category_document', 'nama_proyek', 'jenis_dokumen']));
    }

    function documentTemplateView(Request $request)
    {
        $category_get = $request->query('jenis-dokumen');
        $documents_template = DocumentTemplate::all();

        if(!empty($category_get)){
            $documents_template = DocumentTemplate::where('category', '=', $category_get)->get();
        }
        return view("6_Document_Template", compact(['documents_template', 'category_get']));
    }
    
    function documentTemplateNew(Request $request, DocumentTemplate $template)
    {
        $data = $request->all();
        $file = $request->file("file-document");
        $id_document = date("His_") . $file->getClientOriginalName();
        $nama_file = $file->getClientOriginalName();
        try {
            $messages = [
                "required" => "Field di atas wajib diisi",
                "file" => "This field must be file only",
            ];
            $rules = [
                "file-document" => "required|file",
            ];
            $validation = Validator::make($data, $rules, $messages);
            if ($validation->fails()) {
                Alert::error('Error', "Dokumen Template gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
                // dd($validation->errors());
            }
            $validation->validate();

            
            $template->id_dokumen = $id_document;
            $template->nama_dokumen = $nama_file;
            $template->category = $data['category'];

            if ($template->save()) {
                moveFileDocumentTemp($file, explode(".", $id_document)[0]);
                Alert::success("Success", "Dokumen Template berhasil ditambahkan");
                return redirect()->back();
            }
                Alert::error("Erorr", "Dokumen Final gagal ditambahkan");
                return Redirect::back()->with("modal", $data["modal-name"]);
                // return redirect()->back();

        } catch (\Throwable $th) {
            throw $th;
            // Alert::error("Erorr", "Dokumen Final gagal ditambahkan");
            // return Redirect::back()->with("modal", $data["modal-name"]);
        }
        return view("6_DocumentTemplate", compact(['documents']));
    }

    function documentTemplateDelete($id)
    {
        $document_selected = DocumentTemplate::where('id', '=', $id)->first();
        try {

            File::delete(public_path("template/$document_selected->id_dokumen"));
            if($document_selected->delete()){
                Alert::success("Success", "Dokumen Template berhasil dihapus");
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }
            Alert::error("Erorr", "Dokumen Final gagal dihapus");
            return response()->json([
                "status" => "success",
                "link" => false,
            ]);
            
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error("Erorr", "Dokumen Final gagal dihapus");
            return response()->json([
                "status" => "success",
                "link" => false,
            ]);
        }

    }

    function documentIndex()
    {
        $all_document = collect();
        $tables = DB::select("SELECT table_name
                            FROM information_schema.columns
                            WHERE column_name='id_document';");
        foreach ($tables as $table) {
            $table_name = $table->table_name;
            $data = DB::table($table_name)->select("*")->get();
            if (!empty($data)) {
                $all_document->push($data);
                // array_push($all_document, $data);
            }
        }
        // $all_document = array_merge(...$all_document);
        $all_document = $all_document->flatten();
        $id_documents = $all_document->map(function ($array) {
            return array_values((array) $array);
        }, $all_document);
        $documents_name = $all_document->map(function ($array) {
            $array = get_object_vars($array);
            $array_keys = array_keys($array);
            foreach ($array_keys as $key) {
                if (str_contains($key, "document_name") || str_contains($key, "nama_attach")) {
                    return $array[$key];
                }
            }
        }, $all_document);
        return view("6_Document", ["all_document" => $all_document, "id_documents" => $id_documents, "documents_name" => $documents_name]);
    }

    // Save Document to Server and update data from database
    public function documentSave(Request $request)
    {
        $id_document = $request->id_document;
        $id = $request->id;
        $file = $request->file("content_word");
        $id_contract_redirect = "";
        $tables = DB::select("SELECT table_name
        FROM information_schema.columns;");
        foreach ($tables as $table) {
            $table_name = $table->table_name;
            $columns = DB::select("SELECT column_name
            FROM information_schema.columns
           WHERE table_name  = '$table_name';");
            foreach ($columns as $column) {
                $column_name = $column->column_name;
                if ($column_name == "id_document") {
                    $query = "SELECT * FROM $table_name WHERE $table_name.id_document = '$id_document';";
                    $data = DB::selectOne($query);
                    if (!empty($data)) {
                        $id_contract_redirect = $data->id_contract;
                        $primary_column = array_keys(get_object_vars($data));
                        // $docx_writer = writeDOCXFile($file->getContent());
                        $counter = explode("_", $data->id_document);
                        if (empty($counter[1])) {
                            $file_name = trim($counter[0]) . "_2";
                            // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                            // header('Content-Type: application/octet-stream');
                            // header("Content-Disposition: attachment;filename=$file_name.docx");
                            // $docx_writer->save(public_path("words/" . $file_name . ".docx"));
                            // moveFileTemp($file, $file_name);
                            $file->move(public_path("words/"), $file_name . ".docx");
                        } else {
                            $num = (int) $counter[1] + 1;
                            $file_name = trim($counter[0]) . "_$num";
                            // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                            // header('Content-Type: application/octet-stream');
                            // header("Content-Disposition: attachment;filename=$file_name.docx");
                            $file->move(public_path("words/"), $file_name . ".docx");
                            // moveFileTemp($file, $file_name);
                            // $docx_writer->save(public_path("words/" . $file_name . ".docx"));
                        }
                        DB::update("UPDATE $table_name SET id_document = '$file_name' WHERE  $primary_column[0] = $id");
                        if ($table_name == "addendum_contract_drafts") {
                            $query = "SELECT * FROM addendum_contracts WHERE addendum_contracts.id_addendum = $data->id_addendum";
                            $addendumContract = DB::selectOne($query);
                            Alert::success("Success", "Document berhasil diperbarui");
                            return response()->json([
                                "status" => "success",
                                "redirect" => url("/contract-management/view/$addendumContract->id_contract/addendum-contract/$addendumContract->id_addendum"),
                            ]);
                        }
                        Alert::success("Success", "Document berhasil diperbarui");
                        return response()->json([
                            "status" => "success",
                            "redirect" => url("/contract-management/view/$data->id_contract"),
                        ]);
                    }
                }
            }
        }
        Alert::error("Error", "Document gagal diperbarui");
        return response()->json([
            "status" => "failed",
            "redirect" => url("/contract-management/view/$id_contract_redirect"),
        ]);
    }

    // View Document History
    public function documentViewHistory(Request $request)
    {
        $id_document = explode("_", $request->id_document)[0];
        $id_document = str_replace(".docx", "", $id_document);
        $id = $request->id;
        // $files = Storage::disk("public/words")->allFiles();
        $files = File::files(public_path("words/"));
        $file_documents = [];
        foreach ($files as $file) {
            // dump($file);
            if (str_contains($file->getFilenameWithoutExtension(), "_")) {
                $file_id = explode("_", $file->getFilenameWithoutExtension())[0];
            } else {
                $file_id = str_replace(".docx", "", $file->getFilenameWithoutExtension());
            }
            if ($file_id == $id_document) {
                // dump($file);
                array_push($file_documents, $file->getFilenameWithoutExtension());
            }
        }
        // dd();
        return view("/document/document-history", ["files" => $file_documents, "id" => $id]);
    }

    // View Document to Document Viewer
    public function documentView(Request $request)
    {
        $id_document = $request->id_document;
        $id = $request->id;
        // dd($request->id_document);
        $document_path = asset("words/" . $id_document . ".docx");
        return view("/document/document", ["document" => $document_path, "id" => $id, "id_document" => $id_document]);
        // return view("document", ["document" => $document_path]);
    }
}
