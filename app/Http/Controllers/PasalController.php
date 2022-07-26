<?php

namespace App\Http\Controllers;

use App\Models\Pasals;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use App\Models\AddendumContracts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PasalController extends Controller
{
 
    public function index()
    {
        return view("pasals/view", ["pasals" => Pasals::all()]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Pasals $pasal)
    {
        return response()->json([
            "pasal" => $pasal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pasals $pasal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasals $pasal)
    {
        if ($pasal->delete()) {
            Alert::success('Delete', $pasal->pasal.", Berhasil Dihapus");
            
            return Redirect::back();
            // return Redirect::back()->with("msg", "This pasal have been deleted");
        }
        return Redirect::back()->with("msg", "This pasal failed to delete");
    }

    public function pasalClear(Request $request) {
        if (Session::has("pasals")) {
            Session::forget("pasals");
        }
        return response()->json([
            "status" => "success",
            "message" => "Pasal-pasal have been cleared",
        ]);
    }

    // save pasal to Session
    public function pasalSave(Request $request) {
        $data = $request->all();
        $pasalsPost = explode(",", $data["pasals"]);
        $pasals = [];
        foreach ($pasalsPost as $pasalPost) {
            $pasal = Pasals::find($pasalPost);
            if ($pasal instanceof Pasals) {
                array_push($pasals, $pasal);
            }
        }
        if (Session::has("pasals")) {
            Session::forget("pasals");
            Session::put("pasals", $pasals);
            return response()->json([
                "status" => "success",
                "message" => "Success to update pasal",
                "pasals" => json_encode(Session::get("pasals")),
            ]);
        } else {
            Session::put("pasals", $pasals);
        }
    
        if (Session::has("pasals")) {
            return response()->json([
                "status" => "success",
                "message" => "Success to add pasal",
                "pasals" => json_encode(Session::get("pasals")),
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Failed to add pasal",
        ]);
    }

    // Save Pasal to database or server
    public function pasalAdd(Request $request, Pasals $pasals) {
        $pasal = $request->get("pasal");
        $tipePasal = $request->get("tipe-pasal");
        $prioritas = $request->get("prioritas");
        $keterangan = $request->get("keterangan");
        // dd($request->all());
        $pasals->pasal = $pasal;
        $pasals->tipe_pasal = $tipePasal;
        $pasals->prioritas = $prioritas;
        $pasals->keterangan = $keterangan;
        if ($pasals->save()) {
            Alert::success('Success', $pasal.", Berhasil Ditambahkan");
            return response()->json([
                "status" => "success",
                "message" => "Your pasal have been added",
                "pasals" => Pasals::all(),
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Your pasal cannot be added",
        ]);
    }
    
    // update Pasal from input to database
    
    public function pasalUpdate(Request $request) {
        $pasal = $request->get("pasal");
        $tipePasal = $request->get("tipe-pasal");
        $id_pasal = $request->get("id_pasal");
        $pasals = Pasals::find($id_pasal);
        $pasals->pasal = $pasal;
        $pasals->tipe_pasal = $tipePasal;
        if ($pasals->save()) {
            Alert::success('Success', $pasal.", Berhasil Diubah")->autoClose(3000);
            return response()->json([
                "status" => "success",
                "message" => "Your pasal have been updated",
                "pasals" => Pasals::all(),
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Your pasal cannot be updated",
        ]);
    }

    //IMPORT pasal
    public function importPasal(Request $request)
    {
        $file = $request -> file('import-file'); //get temp data
        // dd($file);
        
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        // dd(count($sheetData));
        
        $data = 0;
        for($i=3; $i<count($sheetData); $i++){
            $tipePasal = $sheetData[$i]['1'];
            $pasal = $sheetData[$i]['2'];

            $newPasal = new Pasals();
            $newPasal->tipe_pasal = $tipePasal;
            $newPasal->pasal = $pasal;
            $newPasal->save();
            $data++;
            // dump($pasal);
        }
        // dd();
        if($data > 0){
            Alert::success('Success', "Data Berhasil di Import");
            return redirect()->back();
        }
        return redirect()->back();

        // $file_name = $_FILES['import-file']['name']; //get file name yg di upload
        // if(isset($_POST['file-submit'])){
        //     $err = "";
        //     $ekstensi = "";
        //     $success = "";
        //     $file_name = $_FILES['import-file']['name']; //get file name yg di upload
        //     $file_data = $_FILES['import-file']['tmp_name']; //get temp data
        // }
        // if(empty($file_name)){
        //     $err .= "<p>nama file error</p>";
        //     Alert::error('Error', "Nama file kosong");
        // } else {
        //     $ekstensi = pathinfo($file_name)['extension'];
        //     // dd($ekstensi);
        //     // return redirect()->back();
        // }
        // $ekstensi_allowed = array("xls","xlsx");
        // if (!in_array($ekstensi, $ekstensi_allowed)) {
        //     $err .= "<p>format file error (xls/xlsx)</p>";
        //     Alert::error('Error', "Gunakan format xls / xlsx. File yang anda gunakan .".$ekstensi);
        //     // return redirect()->back();
        // }
    }


}
