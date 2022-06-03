<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;

class CustomerController extends Controller
{
    public function view() 
    {
        // dd(Customer::all());
        return view('2_Customer',["customer" => Customer::all()]);
    }

    
}
