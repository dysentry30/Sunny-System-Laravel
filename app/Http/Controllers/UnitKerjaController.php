<?php

namespace App\Http\Controllers;

use App\Models\Dop;
use App\Models\Company;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UnitKerjaController extends Controller
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
        // $activeFilter = $request->query("active-filter");
        $dops = Dop::all();
        $companies = Company::all();

        $adminPIC = str_contains(auth()->user()->name, "(PIC)");

        if(Auth::user()->check_administrator || $adminPIC) {
            if (!empty($column)){
                $unitkerjas = UnitKerja::sortable()->where($column, 'like', '%'.$filter.'%')->get();
            }else{
                $unitkerjas = UnitKerja::sortable()->get();
            }    
        } else {
            $unitkerjas = UnitKerja::sortable()->where("divcode", "=", Auth::user()->unit_kerja)->get();
        }
        return view('/MasterData/UnitKerja', compact(['unitkerjas', 'dops', 'companies', 'column', 'filter']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UnitKerja $newUnitKerja)
    {
        $dataUnitKerja = $request->all();
        $divcode = UnitKerja::where("divcode", "=", $dataUnitKerja["divcode"])->get()->first();
        if ($divcode == null) {
            $messages = [
                "required" => "This field is required",
            ];
            $rules = [
                "nomor-unit" => "required",
                "unit-kerja" => "required",
                "divcode" => "required",
                "dop" => "required",
                "company" => "required",
            ];
            $validation = Validator::make($dataUnitKerja, $rules, $messages);
            if ($validation->fails()) {
                $request->old("nomor-unit");
                $request->old("unit-kerja");
                $request->old("divcode");
                $request->old("dop");
                $request->old("company");
                Alert::error('Error', "Unit Kerja Gagal Dibuat, Periksa Kembali !");
            }
            $validation->validate();   
            
            $newUnitKerja->nomor_unit = $dataUnitKerja["nomor-unit"];
            $newUnitKerja->unit_kerja = $dataUnitKerja["unit-kerja"];
            $newUnitKerja->divcode = $dataUnitKerja["divcode"];
            $newUnitKerja->dop = $dataUnitKerja["dop"];
            $newUnitKerja->company = $dataUnitKerja["company"];
            $newUnitKerja->divisi = $dataUnitKerja["divisi"];
            $newUnitKerja->is_active = (int) $dataUnitKerja["is-active"];
            $newUnitKerja->id_profit_center = $dataUnitKerja["profit-center"];
            $newUnitKerja->company_code = $dataUnitKerja["company-code"];
    
            Alert::success('Success', $dataUnitKerja["unit-kerja"].", Berhasil Ditambahkan");
    
            if ($newUnitKerja->save()) {
                return redirect()->back();
            }
        } else{
            Alert::error('Error', 'Divcode "'.$dataUnitKerja["divcode"].'" Sudah Digunakan, Periksa Kembali !');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(UnitKerja $unitKerja)
    {
        //
    }

    /**
     * Update Data Unit Kerja, Different with Setting Appproval Update
     * @param UnitKerja $unitKerja
     * 
     * @return [type]
     */
    public function updateUnitKerja(Request $request) {
        $dataUnitKerja = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nomor-unit" => "required",
            "unit-kerja" => "required",
            "divcode" => "required",
            "dop" => "required",
            "company" => "required",
        ];
        $validation = Validator::make($dataUnitKerja, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-unit");
            $request->old("unit-kerja");
            $request->old("divcode");
            $request->old("dop");
            $request->old("company");
            Alert::error('Error', "Unit Kerja Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();   
        $update_unit_kerja = UnitKerja::find($dataUnitKerja["divcode"]);
        $update_unit_kerja->nomor_unit = $dataUnitKerja["nomor-unit"];
        $update_unit_kerja->unit_kerja = $dataUnitKerja["unit-kerja"];
        $update_unit_kerja->divcode = $dataUnitKerja["divcode"];
        $update_unit_kerja->dop = $dataUnitKerja["dop"];
        $update_unit_kerja->company = $dataUnitKerja["company"];
        $update_unit_kerja->divisi = $dataUnitKerja["divisi"];
        $update_unit_kerja->is_active = (int) $dataUnitKerja["is-active"];
        $update_unit_kerja->id_profit_center = $dataUnitKerja["profit-center"];
        $update_unit_kerja->company_code = $dataUnitKerja["company-code"];

        if ($update_unit_kerja->save()) {
            Alert::html('Success', "Update untuk <b>" . $update_unit_kerja->unit_kerja ."</b> Berhasil Ditambahkan", "success");
            return redirect('/unit-kerja')->with("success", true);
        }
        Alert::html('Error', "Update untuk <b>" . $update_unit_kerja->unit_kerja . "</b> gagal disimpan, Periksa Kembali!", "error");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $unitKerja = UnitKerja::find($data["id-unit-kerja"]);

        $messages = [
            "required" => "This field is required",
            "string" => "This field must be string",
        ];
        $rules = [
            "metode-approval" => "required|string",
            "user-1" => "required",
        ];
        if(isset($data["user-2"])) {
            $rules["user-2"] = "required";
            $unitKerja->user_2 = $data["user-2"];
        }
        if(isset($data["user-3"])) {
            $rules["user-3"] = "required";
            $unitKerja->user_3 = $data["user-3"];
        }
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("metode-approval");
            $request->old("user-1");
            $request->old("user-2");
            $request->old("user-3");
            Alert::html('Error', "Setting Approval untuk <b>" . $unitKerja->unit_kerja . "</b> gagal disimpan, Periksa Kembali!", "error");
        }
        $validation->validate();   
        $unitKerja->metode_approval = $data["metode-approval"];
        $unitKerja->user_1 = $data["user-1"];
        

        if ($unitKerja->save()) {
            Alert::html('Success', "Setting Approval untuk <b>" . $unitKerja->unit_kerja ."</b> Berhasil Ditambahkan", "success");
            return redirect('/unit-kerja')->with("success", true);
        }
        Alert::html('Error', "Setting Approval untuk <b>" . $unitKerja->unit_kerja . "</b> gagal disimpan, Periksa Kembali!", "error");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitKerja  $unitKerja
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = UnitKerja::find($id);
        $unitKerja = $id->unit_kerja;
        
        $id->delete();
        Alert::success('Delete', $unitKerja.", Berhasil Dihapus");

        return redirect()->back();
    }
}
