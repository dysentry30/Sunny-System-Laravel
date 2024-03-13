<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompetitorController extends Controller
{
    /**
     * View Menu Competitor
     */
    public function view(Request $request)
    {
        $customer = Customer::where('check_competitor', true)->get();
        return view('20_Menu_Competitor', ['customer' => $customer]);
    }

    /**
     * View Menu Detail Competitor
     */
    public function viewDetail(Request $request, Customer $customer)
    {
        if (empty($customer)) {
            Alert::error('Error', 'Kompetitor tidak ditemukan');
            return redirect()->back();
        }

        $listTender = $customer->PesertaTender;

        if ($listTender->isNotEmpty()) {
            $totalTenderDiikuti = $listTender->count();
            $jumlahMenang = $listTender->where('status', 'Menang')->count();
            $jumlahKalah = $listTender->where('status', 'Kalah')->count();

            $dataPieChart = [
                'totalTender' => $totalTenderDiikuti,
                'jumlahMenang' => $jumlahMenang,
                'jumlahKalah' => $jumlahKalah,
            ];
        } else {
            $dataPieChart = [
                'totalTender' => 0,
                'jumlahMenang' => 0,
                'jumlahKalah' => 0,
            ];
        }

        return view('PesertaTender.view', ['listTender' => $listTender, 'dataPieChart' => json_encode($dataPieChart), 'customer' => $customer]);
    }
}
