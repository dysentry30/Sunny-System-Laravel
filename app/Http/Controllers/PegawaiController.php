<?php

namespace App\Http\Controllers;

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
        return view("MasterData/Pegawai", compact([]));
    }
}
