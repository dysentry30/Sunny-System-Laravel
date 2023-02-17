<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PiutangController extends Controller
{
    /**
     * Displaying Piutang Home Page
     * @param Request $request
     * 
     * @return [type]
     */
    public function index(Request $request){
        return view("/Piutang/piutang", compact([]));
    }
}
