<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProyekBerjalans;
use Illuminate\support\Facades\DB;
use App\Models\CustomerAttachments;
use App\Models\Proyek;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index () 
    {
        return view('2_Customer',["customer" => Customer::all()]);
    }

    public function delete ($id_customer) 
    { 
        $id_customer = Customer::find($id_customer)->delete();
        return redirect("/customer")->with('status', 'Customer deleted');   
    }

    public function view ($id_customer) 
    {
        $customer = Customer::find($id_customer);
        return view('Customer/viewCustomer', [
            "customer" => $customer, 
            // "customers" => Customer::all(),
            "attachment" => $customer->customerAttachments->all(),   
            "proyekberjalan" => $customer->proyekBerjalans->all(),
            // "proyekberjalan0" => $customer->proyekBerjalans->where('stage', ">", 0),
            // "proyekberjalan6" => $customer->proyekBerjalans->where('stage', ">", 6),
            "proyeks" => Proyek::all(),
        ]);
    }

    public function saveEdit(
        Request $request, 
        Customer $editCustomer, 
        CustomerAttachments $customerAttachments) 
        {

        $data = $request->all(); 
        // dd($data); //tes log hasil $data 
        $editCustomer=Customer::find($data["id-customer"]);
        $editCustomer->name = $data["name-customer"];
        $editCustomer->check_customer = $request->has("check-customer"); //boolean check
        $editCustomer->check_partner = $request->has("check-partner"); //boolean check
        $editCustomer->check_competitor = $request->has("check-competitor"); //boolean check
        $editCustomer->address_1 = $data["AddressLine1"];
        $editCustomer->address_2 = $data["AddressLine2"];
        $editCustomer->email = $data["email"];
        $editCustomer->phone_number = $data["phone-number"];
        $editCustomer->website = $data["website"];

        // form company information
        $editCustomer->jenis_instansi = $data["jenis-instansi"];
        $editCustomer->kode_proyek = $data["kodeproyek-company"];
        $editCustomer->npwp_company = $data["npwp-company"];
        $editCustomer->kode_nasabah = $data["kodenasabah-company"];
        $editCustomer->journey_company = $data["journey-company"];
        $editCustomer->segmentation_company = $data["segmentation-company"];
        $editCustomer->name_pic = $data["name-pic"];
        $editCustomer->kode_pic = $data["kode-pic"];
        $editCustomer->email_pic = $data["email-pic"];
        $editCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form table performance
        $editCustomer->nilaiok = $data["nilaiok-performance"];
        $editCustomer->piutang = $data["piutang-performance"];
        $editCustomer->laba = $data["laba-performance"];
        $editCustomer->rugi = $data["rugi-performance"];

        // form attachment
        $editCustomer->note_attachment = $data["note-attachment"];
        $customerAttachments->id_customer=$data["id-customer"];
        $customerAttachments->name_customer=$data["name-customer"];
        
        
        
        if ($_FILES['doc-attachment']['size'] == 0)
        {
            // file is empty (and not an error)
            $editCustomer->save();
        }else{
            $editCustomer->save();
            $file_name = $request->file("doc-attachment")->getClientOriginalName();
            $customerAttachments->name_attachment = $file_name;
            $request->file("doc-attachment")->storeAs("public/CustomerAttachments", $file_name);
            $customerAttachments->save();
        }

        return redirect()->back();
    }
    
    public function new () {
        return view('Customer/newCustomer');
    }
    
    public function saveNew (Request $request, Customer $newCustomer) {
        $data = $request->all(); 
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-customer" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        $validation->validate();
        if ($validation->fails()) {
            // $request->old("name-customer");
            // dd(session()->all());
            return redirect()->back();
        }
        
        $newCustomer->name = $data["name-customer"];
        $newCustomer->check_customer = $request->has("check-customer"); //boolean check
        $newCustomer->check_partner = $request->has("check-partner"); //boolean check
        $newCustomer->check_competitor = $request->has("check-competitor"); //boolean check
        $newCustomer->address_1 = $data["AddressLine1"];
        $newCustomer->address_2 = $data["AddressLine2"];
        $newCustomer->email = $data["email"];
        $newCustomer->phone_number = $data["phone-number"];
        $newCustomer->website = $data["website"];

        // form company information
        $newCustomer->jenis_instansi = $data["jenis-instansi"];
        $newCustomer->kode_proyek = $data["kodeproyek-company"];
        $newCustomer->npwp_company = $data["npwp-company"];
        $newCustomer->kode_nasabah = $data["kodenasabah-company"];
        $newCustomer->journey_company = $data["journey-company"];
        $newCustomer->segmentation_company = $data["segmentation-company"];
        $newCustomer->name_pic = $data["name-pic"];
        $newCustomer->kode_pic = $data["kode-pic"];
        $newCustomer->email_pic = $data["email-pic"];
        $newCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form table performance
        $newCustomer->nilaiok = $data["nilaiok-performance"];
        $newCustomer->piutang = $data["piutang-performance"];
        $newCustomer->laba = $data["laba-performance"];
        $newCustomer->rugi = $data["rugi-performance"];
        
        // form attachment
        // $newCustomer->note_attachment = $data["note-attachment"];

        if ($newCustomer->save()) {
            return redirect("/customer")->with("success", true);
        }
    }

    public function customerHistory (
        Request $request, 
        Customer $modalCustomer, 
        ProyekBerjalans $customerHistory,) 
        {

        $data = $request->all(); 
        // $proyekAll = Proyek::all();

        $modalCustomer=Customer::find($data["id-customer"]);
        $customerHistory->id_customer = $data["id-customer"];
        $customerHistory->nama_proyek = $data["nama-proyek"];
        
        $dataProyek = Proyek::where('nama_proyek', "=", $data["nama-proyek"])->get()->first();
        $customerHistory->kode_proyek = $dataProyek->kode_proyek;
        $customerHistory->pic_proyek = $dataProyek->ketua_tender;
        $customerHistory->unit_kerja = $dataProyek->unit_kerja;
        $customerHistory->jenis_proyek = $dataProyek->jenis_proyek;
        $customerHistory->nilaiok_proyek = $dataProyek->nilai_rkap;
        $customerHistory->stage = $dataProyek->stage;

        $modalCustomer->save();
        $customerHistory->save();
        return redirect()->back();
            
    }




    
}
