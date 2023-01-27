<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekomendasiController extends Controller
{
    public function index(){

        $proyeks = Proyek::where("stage", "=", 1)->get();

        return view('13_Rekomendasi', compact(['proyeks']));
    }
}
