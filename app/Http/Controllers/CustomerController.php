<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Customer;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\ProyekBerjalans;
use Illuminate\support\Facades\DB;
use App\Models\CustomerAttachments;
use App\Models\StrukturCustomer;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function getIndex(Request $request)
    {
        // $cari = $request->query("cari");
        $column = $request->query("column");
        $filter = $request->query("filter");
        $sort = $request->sort;
        // dd($request->all());

        if (!empty($column)) {
            $results = Customer::sortable()->where($column, 'like', '%'.$filter.'%')->get();
            $all_customer = Customer::all(); //untuk delete modal
        }else{
            if(!empty($sort)){
                $results = Customer::sortable()->get();
                $all_customer = Customer::all(); //untuk delete modal
            } else {
                // $results = Customer::sortable()->get();
                $results = Customer::sortable()->orderBy('id_customer')->paginate(15);
                $all_customer = Customer::all(); //untuk delete modal
                $artilces = '';
                if ($request->ajax()) {
                    foreach ($results as $customers) {
                        $actButton = "";
                        if(auth()->user()->check_administrator) {
                            $actButton = '
                            <td class="text-center">
                                <button data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_delete'.$customers->id_customer.'"
                                    id="modal-delete"
                                    class="btn btn-sm btn-light btn-active-primary">Delete
                                </button>
                            </td>
                            ';
                        }

                        $artilces.=
                        '<tr>
                            <!--begin::Kode Pelanggan=-->
                            <td>
                            <a href="/customer/view/'.$customers->id_customer. '" class="text-gray-800 text-hover-primary mb-1">'.$customers->kode_pelanggan.'</a>
                            </td>
                            <!--end::Kode Pelanggan-->
                            <!--begin::Name=-->
                            <td>
                            <a href="/customer/view/'.$customers->id_customer.'" class="text-gray-800 text-hover-primary mb-1">'.$customers->name.'</a>
                            </td>
                            <!--end::Name=-->
                            <!--begin::Email=-->
                            <td>
                            <a href="#">'.($customers->email).'</a>
                            </td>
                            <!--end::Email=-->
                            <!--begin::Nomor=-->
                            <td>
                            '.$customers->phone_number.'
                            </td>
                            <!--end::Nomor-->
                            <!--begin::check_customer-->
                            <td>
                            '.($customers->check_customer == 1 ? "Yes" : "No").'
                            </td>
                            <!--end::check_customer=-->
                            <!--begin::check_partner-->
                            <td>
                            '.($customers->check_partner == 1 ? "Yes" : "No").'
                            </td>
                            <!--end::check_partner-->
                            <!--begin::check_competitor-->
                            <td data-filter="mastercard">
                            '.($customers->check_competitor == 1 ? "Yes" : "No").'
                            </td>
                            <!--end::check_competitor-->
                            <!--begin::Kode Nasabah=-->
                            <td>
                            '.$customers->kode_nasabah. '
                            </td>
                            <!--end::Kode Nasabah-->
                            <!--begin::Action=-->
                            '. $actButton . '
                        </tr>';

                    }
                    return $artilces;
                }
            }
        }

        return view('2_Customer', compact(["results", "column", "filter", "sort", "all_customer"]));
    }

    // public function index (Request $request) 
    // {   
    //     $customer = Customer::paginate(15);
    //     return view('2_Customer',["customer" => $customer]);

    // }

    public function delete ($id_customer) 
    { 
        $id_customer = Customer::find($id_customer);
        $id_customer->delete();
        Alert::success('Delete', $id_customer->name.", Berhasil Dihapus");
        return redirect("/customer")->with('status', 'Customer deleted');   
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
            "email" => "required",
            "phone-number" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        $validation->validate();
        if ($validation->fails()) {
            // Alert::error('Error', "Pelanggan Gagal Dibuat, Periksa Kembali !");
            $request->old("name-customer");
            $request->old("email");
            $request->old("phone-number");
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
        // $newCustomer->kode_proyek = $data["kodeproyek-company"];
        $newCustomer->kode_pelanggan = $data["kodepelanggan-company"];
        $newCustomer->kode_nasabah = $data["kodenasabah-company"];
        $newCustomer->npwp_company = $data["npwp-company"];
        // $newCustomer->journey_company = $data["journey-company"];
        // $newCustomer->segmentation_company = $data["segmentation-company"];
        $newCustomer->name_pic = $data["name-pic"];
        $newCustomer->kode_pic = $data["kode-pic"];
        $newCustomer->email_pic = $data["email-pic"];
        $newCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form table performance
        // $newCustomer->nilaiok = $data["nilaiok-performance"];
        // $newCustomer->piutang = $data["piutang-performance"];
        // $newCustomer->laba = $data["laba-performance"];
        // $newCustomer->rugi = $data["rugi-performance"];
        
        // form attachment
        Alert::success('Success', $data["name-customer"].", Berhasil Ditambahkan");

        if ($newCustomer->save()) {
            return redirect("/customer/view/$newCustomer->id_customer")->with("success", true);
        }
    }

    public function view ($id_customer) 
    {
        $customer = Customer::find($id_customer);
        $struktur = StrukturCustomer::where("id_customer", "=", $id_customer)->get();
        // dd($struktur);
        return view('Customer/viewCustomer', [
            "customer" => $customer, 
            "attachment" => $customer->customerAttachments->all(),   
            "proyekberjalan" => $customer->proyekBerjalans->all(),
            // "proyekberjalan0" => $customer->proyekBerjalans->where('stage', ">", 0),
            // "proyekberjalan6" => $customer->proyekBerjalans->where('stage', ">", 6),
            "proyeks" => Proyek::all(),
            "strukturs" => $struktur,
        ]);
    }

    public function saveEdit(
        Request $request, 
        Customer $editCustomer, 
        CustomerAttachments $customerAttachments) 
        {

        $data = $request->all(); 
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-customer" => "required",
            "email" => "required",
            "phone-number" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        $validation->validate();
        if ($validation->fails()) {
            // Alert::error('Error', "Pelanggan Gagal Dibuat, Periksa Kembali !");
            $request->old("name-customer");
            $request->old("email");
            $request->old("phone-number");
            return redirect()->back();
        }


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
        $editCustomer->kode_pelanggan = $data["kodepelanggan-company"];
        $editCustomer->npwp_company = $data["npwp-company"];
        $editCustomer->kode_nasabah = $data["kodenasabah-company"];
        // $editCustomer->journey_company = $data["journey-company"];
        // $editCustomer->segmentation_company = $data["segmentation-company"];
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
            Alert::success('Success', "Edit Berhasil")->autoClose(3000);
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

    public function struktur (Request $request, StrukturCustomer $newStruktur)
    {
        $data = $request->all();
        
        // $idCustomer=Customer::find($data["id-customer"]);
        // dd($idCustomer);

        $newStruktur->id_customer = $data["id-customer"];
        $newStruktur->nama_struktur = $data["name-struktur"];
        $newStruktur->jabatan_struktur = $data["jabatan-struktur"];
        $newStruktur->email_struktur = $data["email-struktur"];
        $newStruktur->phone_struktur = $data["phone-struktur"];

        $newStruktur->save();
        return redirect()->back();
        
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
