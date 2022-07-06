<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Save Document to Server and update data from database
    public function documentSave(Request $request) {
        $id_document = $request->id_document;
        $id = $request->id;
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
                        $primary_column = array_keys(get_object_vars($data));
                        $docx_writer = writeDOCXFile($request->get("content_word"));
                        $counter = explode("_", $data->id_document);
                        if (empty($counter[1])) {
                            $file_name = trim($counter[0]) . "_2";
                            $docx_writer->save(public_path("storage/words/" . $file_name . ".docx"));
                        } else {
                            $num = (int) $counter[1] + 1;
                            $file_name = trim($counter[0]) . "_$num";
                            $docx_writer->save(public_path("storage/words/" . $file_name . ".docx"));
                        }
                        DB::update("UPDATE $table_name SET id_document = '$file_name' WHERE  $primary_column[0] = $id");
                        if ($table_name == "addendum_contract_drafts") {
                            $query = "SELECT * FROM addendum_contracts WHERE addendum_contracts.id_addendum = $data->id_addendum";
                            $addendumContract = DB::selectOne($query);
                            return response()->json([
                                "status" => "success",
                                "redirect" => url("/contract-management/view/$addendumContract->id_contract/addendum-contract/$addendumContract->id_addendum"),
                            ]);
                        }
                        return response()->json([
                            "status" => "success",
                            "redirect" => url("/contract-management/view/$data->id_contract"),
                        ]);
                    }
                }
            }
        }
        return response()->json([
            "status" => "failed",
            "redirect" => url("/contract-management"),
        ]);
    }

    // View Document History
    public function documentViewHistory(Request $request) {
        $id_document = explode("_", $request->id_document)[0];
        $id_document = str_replace(".docx", "", $id_document);
        $id = $request->id;
        $files = Storage::disk("public/words")->allFiles();
        $file_documents = [];
        foreach ($files as $file) {
            if (str_contains($file, "_")) {
                $file_id = explode("_", $file)[0];
            } else {
                $file_id = str_replace(".docx", "", $file);
            }
            if ($file_id == $id_document) {
                // dump($file);
                array_push($file_documents, $file);
            }
        }
        // dd($file_documents);
        return view("/document/document-history", ["files" => $file_documents, "id" => $id]);
    }

    // View Document to Document Viewer
    public function documentView(Request $request) {
        $id_document = $request->id_document;
        $id = $request->id;
        // dd($request->id_document);
        $document_path = asset("words/" . $id_document . ".docx");
        return view("/document/document", ["document" => $document_path, "id" => $id, "id_document" => $id_document]);
        // return view("document", ["document" => $document_path]);
    }
}
