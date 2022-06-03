<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function index()
    {
        return view('/MasterData/Company', ['companies' => Company::all()]);
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
        
        $newCompany->nama_company = $dataCompany["nama-company"];

        if ($newCompany->save()) {
            return redirect("/company")->with("success", true);
        }
    }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Company  $company
         * @return \Illuminate\Http\Response
         */
    public function show(Company $company)
    {
        //
    }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\Company  $company
         * @return \Illuminate\Http\Response
         */
    public function update(Request $request, Company $company)
    {
        //
    }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\Company  $company
         * @return \Illuminate\Http\Response
         */
    public function destroy(Company $company)
    {
        //
    }
}
