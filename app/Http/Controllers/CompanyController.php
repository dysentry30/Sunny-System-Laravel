<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function index(Request $request)
    {
        $column = $request->get("column");
        $filter = $request->query("filter");

        if (!empty($column)) {
            $companies = Company::sortable()->where($column, 'like', '%'.$filter.'%')->get();
        }else{
        $companies = Company::sortable()->get();
        }    
        return view('/MasterData/Company', compact(['companies', 'column', 'filter']));
    }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
    public function store(Request $request, Company $newCompany)
    {
        $dataCompany = $request->all(); 
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nama-company" => "required",
        ];
        $validation = Validator::make($dataCompany, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Company gagal dibuat !");
        }
        
        $validation->validate();
        $newCompany->nama_company = $dataCompany["nama-company"];

        Alert::success('Success', $dataCompany["nama-company"].", Berhasil Ditambahkan");

        if ($newCompany->save()) {
            return redirect("/company");
        }
    }

  
        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\Company  $company
         * @return \Illuminate\Http\Response
         */
    public function delete($id)
    {
        $id = Company::find($id);
        $company = $id->nama_company;
        
        $id->delete();
        Alert::success('Delete', $company.", Berhasil Dihapus")->hideCloseButton();

        return redirect("/company");
    }


    public function update($id, Request $request)
    {
        $dataCompany = $request->all();
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "nama-company" => "required",
        ];
        $validation = Validator::make($dataCompany, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Company gagal dibuat !");
        }
        $validation->validate();

        $newCompany = Company::find($id);
        $newCompany->nama_company = $dataCompany["nama-company"];

        Alert::success('Success', $dataCompany["nama-company"] . ", Berhasil Ditambahkan");

        if ($newCompany->save()) {
            return redirect("/company");
        }
    }
}
