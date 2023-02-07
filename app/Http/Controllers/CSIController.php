<?php

namespace App\Http\Controllers;

use App\Models\Csi;
use Illuminate\Http\Request;

class CSIController extends Controller
{
    public function index(Request $request) {
        $csi = Csi::all();
        return view("14_CSI", compact(["csi"]));
    }
}
