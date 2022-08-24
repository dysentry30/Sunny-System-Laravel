<?php

namespace App\Http\Controllers;

use Faker\Core\Uuid;
use App\Models\Proyek;
use App\Models\Customer;
use App\Models\UnitKerja;
use App\Models\CustomerPic;
use Illuminate\Http\Request;
use App\Models\ProyekBerjalans;
use App\Models\StrukturCustomer;
use Illuminate\Http\UploadedFile;
use Illuminate\support\Facades\DB;
use App\Models\CustomerAttachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
        $customer = Customer::find($id_customer);
        $customer->delete();
        Alert::success('Delete', $customer->name.", Berhasil Dihapus");
        return redirect("/customer")->with('status', 'Customer deleted');   
    }

    public function new () {
        $data_provinsi = json_decode(Storage::get("/public/data/provinsi.json"));
        // $id_kabupaten = $customer->provinsi; 
        // $data_kabupaten = json_decode(Storage::get("/public/data/$id_kabupaten.json"));
        $data_negara = json_decode(Storage::get("/public/data/country.json"));
        return view('Customer/newCustomer', compact(["data_provinsi", "data_negara"]));
    }
    
    public function saveNew (Request $request, Customer $newCustomer) {
        $data = $request->all();
        // dd($data); 
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-customer" => "required",
            "email" => "required",
            "phone-number" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::toast("Pelanggan Gagal Dibuat, Periksa Kembali !", "error")->autoClose(3000);
            // dd($request);
            $request->old("name-customer");
            $request->old("email");
            $request->old("phone-number");
            redirect()->back()->with("modal", $data["modal-name"]);
        }
        
        $validation->validate();
        
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
        // $newCustomer->jenis_instansi = $data["jenis-instansi"];
        // // $newCustomer->kode_proyek = $data["kodeproyek-company"];
        // $newCustomer->kode_pelanggan = $data["kodepelanggan-company"];
        // $newCustomer->kode_nasabah = $data["kodenasabah-company"];
        // $newCustomer->npwp_company = $data["npwp-company"];
        // $newCustomer->negara = $data["negara"];
        // $newCustomer->provinsi = $data["provinsi"];
        // $newCustomer->kota_kabupaten = $data["kabupaten"];
        // // $newCustomer->journey_company = $data["journey-company"];
        // // $newCustomer->segmentation_company = $data["segmentation-company"];
        // $newCustomer->name_pic = $data["name-pic"];
        // $newCustomer->kode_pic = $data["kode-pic"];
        // $newCustomer->email_pic = $data["email-pic"];
        // $newCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form attachment
        Alert::success('Success', $data["name-customer"].", Berhasil Ditambahkan");

        if ($newCustomer->save()) {
            return redirect("/customer/view/$newCustomer->id_customer")->with("success", true);
        }
    }

    public function view ($id_customer) 
    {
        $customer = Customer::find($id_customer);
        // $data_provinsi = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json")->json();
        // $data = Http::get("http://maps.googleapis.com/maps/api/geocode/xml?address=". "Boston, USA" . "&sensor=false");
        
        $data_provinsi = json_decode(Storage::get("/public/data/provinsi.json"));
        $id_kabupaten = $customer->provinsi; 
        $data_kabupaten = json_decode(Storage::get("/public/data/$id_kabupaten.json"));
        $data_negara = json_decode(Storage::get("/public/data/country.json"));
        $pic = CustomerPic::where("id_customer", "=", $id_customer)->get();
        $struktur = StrukturCustomer::where("id_customer", "=", $id_customer)->get();
        $proyeks = ProyekBerjalans::where("id_customer", "=", $id_customer)->get();
        $area_proyeks = collect();
        
        foreach($proyeks as $p) {
            $p = Proyek::find($p->kode_proyek);
            // $coord_kabupaten = json_decode(Storage::get("/public/data/$p->kabupaten.json"));
            $coord_provinsi = collect(json_decode(Storage::get("/public/data/provinsi.json")))->filter(function($data) use($p) {
                $data = (array) $data;
                return $data["id"] == $p->provinsi;
            })->first();
            // $coord_provinsi = array_filter(, function($data) use($p) {
            //     return $data["province_id"] == $p->provinsi;
            // });
            // dd($p->negara);
            // dd($coord_provinsi);
            if (!empty($coord_provinsi)) {
                $location = $p->negara . " " . $coord_provinsi->name;
                $getCoordCountry = Http::get("https://nominatim.openstreetmap.org/search.php?q=$location&polygon_geojson=1&format=json")->json();
                if (empty($area_proyeks->keys()->get($p->provinsi))) {
                    $area_proyeks->push(["$p->provinsi" => $getCoordCountry[0]]);
                }
            }
        }
        // begin::chart Performance Pelanggan
        // $kategoriProyek = [];
        $proyekBerjalan = ProyekBerjalans::all();
        $kategoriProyek = $proyekBerjalan->where("id_customer", "=", $id_customer);
        $namaProyek = [];
        $nilaiOK = [];
        $nilaiForecast = 0;
        $proyekOngoing = 0;
        $proyekClosed = 0;
        foreach ($kategoriProyek as $kategori){
            array_push($namaProyek, $kategori->nama_proyek);
            $nilai = (int) str_replace(",", "", $kategori->nilaiok_proyek);
            array_push($nilaiOK, $nilai);
            $nilaiForecast += $kategori->proyek->forecast;
            if ($kategori->proyek->stage <= 7) {
                $proyekOngoing ++;
            }
            if ($kategori->proyek->stage > 7) {
                $proyekClosed ++;
            }
            // dump($kategori->proyek->forecast);
        }
        // dump($kategori->proyek);
        // end::chart Performance Pelanggan
        
        return view('Customer/viewCustomer', [
            "customer" => $customer, 
            "attachment" => $customer->customerAttachments->all(),   
            "proyekberjalan" => $customer->proyekBerjalans->all(),
            // "proyekberjalan0" => $customer->proyekBerjalans->where('stage', ">", 0),
            // "proyekberjalan6" => $customer->proyekBerjalans->where('stage', ">", 6),
            "proyeks" => $proyeks,
            "pics" => $pic,
            "strukturs" => $struktur,
            "data_provinsi" => $data_provinsi,
            "data_kabupaten" => $data_kabupaten,
            "data_negara" => $data_negara,
            "kategoriProyek" => $kategoriProyek,
            "nilaiOK" => $nilaiOK,
            "namaProyek" => $namaProyek,
            "nilaiForecast" => $nilaiForecast,
            "proyekOngoing" => $proyekOngoing,
            "proyekClosed" => $proyekClosed,
            "area_proyeks" => $area_proyeks,
        ]);
    }

    public function saveEdit(
        Request $request, 
        Customer $editCustomer, 
        CustomerAttachments $customerAttachments) 
        {

        $data = $request->all(); 
        // dd($data);
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


        $editCustomer=Customer::find($data["id-customer"]);
        // dd($request);
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
        $editCustomer->negara = $data["negara"];
        $editCustomer->provinsi = $data["provinsi"];
        $editCustomer->kota_kabupaten = $data["kabupaten"];
        // $editCustomer->journey_company = $data["journey-company"];
        // $editCustomer->segmentation_company = $data["segmentation-company"];
        // $editCustomer->name_pic = $data["name-pic"];
        // $editCustomer->kode_pic = $data["kode-pic"];
        // $editCustomer->email_pic = $data["email-pic"];
        // $editCustomer->phone_number_pic = $data["phone-number-pic"];
        
        // form table performance
        $editCustomer->nilaiok = $data["nilaiok-performance"];
        $editCustomer->piutang = $data["piutang-performance"];
        $editCustomer->laba = $data["laba-performance"];
        $editCustomer->rugi = $data["rugi-performance"];

        // form attachment
        $editCustomer->note_attachment = $data["note-attachment"];
        $customerAttachments->id_customer=$data["id-customer"];
        // $customerAttachments->name_customer=$data["name-customer"];
        
        
        
        if ($_FILES['doc-attachment']['size'] == 0)
        {   
            Alert::success('Success', "Edit Berhasil")->autoClose(3000);
            // file is empty (and not an error)
            $editCustomer->save();
        }else{
            $editCustomer->save();
            // dd($data);
            $faker = new Uuid();
            $fileAttachment = $data['doc-attachment'];
            $id_document = $faker->uuid3();
            $file_name = $request->file("doc-attachment")->getClientOriginalName();
            $customerAttachments->name_attachment = date("His_") . $file_name;
            $customerAttachments->id_document = $id_document;
            $customerAttachments->created_by = Auth::user()->name;
            moveFileTemp($fileAttachment, $id_document);
            // $request->file("doc-attachment")->storeAs("public/CustomerAttachments", $file_name);
            $customerAttachments->save();
        }

        return redirect()->back();
    }

    public function deleteAttachment($id)
    {
        $delete = CustomerAttachments::find($id);
        // dd($delete);
        $delete->delete();
        Alert::success("Success", "Attachment Berhasil Dihapus");
        return redirect()->back();
    }

    public function pic (Request $request, CustomerPic $newPIC)
    {
        $data = $request->all();

        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-pic" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::toast("PIC Gagal Ditambahkan, Periksa Kembali !" , "error");
            return redirect()->back();
        }

        $validation->validate();
        
        $newPIC->id_customer = $data["id-customer"];
        $newPIC->nama_pic = $data["name-pic"];
        $newPIC->jabatan_pic = $data["kode-pic"];
        $newPIC->email_pic = $data["email-pic"];
        $newPIC->phone_pic = $data["phone-number-pic"];

        Alert::toast($data["kode-pic"].$data["name-pic"].", Berhasil Ditambahkan" , "success");

        $newPIC->save();
        return redirect()->back();
        
    }

    public function struktur (Request $request, StrukturCustomer $newStruktur)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-struktur" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::toast("Struktur Gagal Ditambahkan, Periksa Kembali !" , "error");
            return redirect()->back();
        }

        $validation->validate();
        
        // $idCustomer=Customer::find($data["id-customer"]);
        // dd($idCustomer);

        $newStruktur->id_customer = $data["id-customer"];
        $newStruktur->nama_struktur = $data["name-struktur"];
        $newStruktur->jabatan_struktur = $data["jabatan-struktur"];
        $newStruktur->email_struktur = $data["email-struktur"];
        $newStruktur->phone_struktur = $data["phone-struktur"];

        Alert::toast($data["jabatan-struktur"].$data["name-struktur"].", Berhasil Ditambahkan" , "success");

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
