<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
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
        $piutangs = Piutang::all();
        return view("/Piutang/piutang", compact(["piutangs"]));
    }
}
