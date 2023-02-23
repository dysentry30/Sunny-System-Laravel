<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Displaying Pegawai Home Page
     * @param Request $request
     * 
     * @return View
     */
    public function index(Request $request){
        $pegawai_all = Pegawai::all();
        return view("MasterData/Pegawai", compact(["pegawai_all"]));
    }
}
