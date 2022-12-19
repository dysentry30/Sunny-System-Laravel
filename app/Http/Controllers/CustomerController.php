<?php

namespace App\Http\Controllers;

use Faker\Core\Uuid;
use App\Models\Proyek;
use App\Models\Customer;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use App\Models\CustomerPic;
use Illuminate\Http\Request;
use App\Models\ProyekBerjalans;
use App\Models\StrukturCustomer;
use Illuminate\Http\UploadedFile;
use Illuminate\support\Facades\DB;
use App\Models\CustomerAttachments;
use App\Models\CustomerSAP;
use App\Models\IndustryOwner;
use App\Models\IndustrySector;
use App\Models\Provinsi;
use App\Models\StrukturAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            // $results = Customer::sortable()->where($column, 'like', '%'.$filter.'%')->get();
            $results = Customer::sortable()->get()->filter(function ($cust) use ($column, $filter) {
                return preg_match("/$filter/i", $cust[$column]);
            });
            $all_customer = Customer::all(); //untuk delete modal
        } else {
            if (!empty($sort)) {
                $results = Customer::sortable()->orderBy('id_customer')->get();
                $all_customer = Customer::all(); //untuk delete modal
            } else {
                // $results = Customer::sortable()->get();
                $results = Customer::sortable()->orderBy('id_customer')->paginate(50);
                $all_customer = Customer::all(); //untuk delete modal
                // $artilces = '';
                // if ($request->ajax()) {
                //     foreach ($results as $customers) {
                //         $actButton = "";
                //         if (auth()->user()->check_administrator) {
                //             $actButton = '
                //             <td class="text-center">
                //                 <button data-bs-toggle="modal"
                //                     data-bs-target="#kt_modal_delete' . $customers->id_customer . '"
                //                     id="modal-delete"
                //                     class="btn btn-sm btn-light btn-active-primary">Delete
                //                 </button>
                //             </td>
                //             ';
                //         }

                //         $artilces .=
                //             '<tr>
                //             <!--begin::Kode Pelanggan=-->
                //             <td>
                //             <a href="/customer/view/' . $customers->id_customer . '" class="text-gray-800 text-hover-primary mb-1">' . $customers->kode_pelanggan . '</a>
                //             </td>
                //             <!--end::Kode Pelanggan-->
                //             <!--begin::Name=-->
                //             <td>
                //             <a href="/customer/view/' . $customers->id_customer . '" class="text-gray-800 text-hover-primary mb-1">' . $customers->name . '</a>
                //             </td>
                //             <!--end::Name=-->
                //             <!--begin::Email=-->
                //             <td>
                //             <a href="#">' . ($customers->email) . '</a>
                //             </td>
                //             <!--end::Email=-->
                //             <!--begin::check_customer-->
                //             <td>
                //             ' . ($customers->check_customer == 1 ? "Yes" : "No") . '
                //             </td>
                //             <!--end::check_customer=-->
                //             <!--begin::check_partner-->
                //             <td>
                //             ' . ($customers->check_partner == 1 ? "Yes" : "No") . '
                //             </td>
                //             <!--end::check_partner-->
                //             <!--begin::check_competitor-->
                //             <td data-filter="mastercard">
                //             ' . ($customers->check_competitor == 1 ? "Yes" : "No") . '
                //             </td>
                //             <!--end::check_competitor-->
                //             <!--begin::Kode Nasabah=-->
                //             <td>
                //             ' . $customers->kode_nasabah . '
                //             </td>
                //             <!--end::Kode Nasabah-->
                //             <!--begin::Action=-->
                //             ' . $actButton . '
                //         </tr>';
                //     }
                //     return $artilces;
                // }
            }
        }

        $industrySectors = IndustrySector::all();

        return view('2_Customer', compact(["results", "column", "filter", "sort", "all_customer", "industrySectors"]));
    }

    // public function index (Request $request) 
    // {   
    //     $customer = Customer::paginate(15);
    //     return view('2_Customer',["customer" => $customer]);

    // }

    public function delete($id_customer)
    {
        $customer = Customer::find($id_customer);
        $customer->delete();
        Alert::success('Delete', $customer->name . ", Berhasil Dihapus");
        return redirect("/customer")->with('status', 'Customer deleted');
    }

    public function new()
    {
        $data_provinsi = json_decode(Storage::get("/public/data/provinsi.json"));
        // $id_kabupaten = $customer->provinsi; 
        // $data_kabupaten = json_decode(Storage::get("/public/data/$id_kabupaten.json"));
        $data_negara = json_decode(Storage::get("/public/data/country.json"));
        return view('Customer/newCustomer', compact(["data_provinsi", "data_negara"]));
    }

    public function saveNew(Request $request, Customer $newCustomer)
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
        $newCustomer->kode_pos = $data["kode-pos"];
        $newCustomer->industry_sector = $data["industry-sector"];
        $newCustomer->npwp_company = $data["npwp-company"];
        $newCustomer->npwp_address = $data["npwp-address"];


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
        Alert::success('Success', $data["name-customer"] . ", Berhasil Ditambahkan");

        if ($newCustomer->save()) {
            return redirect("/customer/view/$newCustomer->id_customer")->with("success", true);
        }
    }

    public function view($id_customer)
    {
        $customer = Customer::find($id_customer);
        // $data_provinsi = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json")->json();
        // $data = Http::get("http://maps.googleapis.com/maps/api/geocode/xml?address=". "Boston, USA" . "&sensor=false");

        // $data_provinsi = json_decode(Storage::get("/public/data/provinsi.json"));
        $id_kabupaten = $customer->provinsi;
        $data_kabupaten = json_decode(Storage::get("/public/data/$id_kabupaten.json"));
        $data_negara = collect(json_decode(Storage::get("/public/data/country.json")));
        // dd($customer->negara, $data_negara, $customer->negara);
        $kode_negara = null;
        if(!empty($customer->negara)) {
            if (strlen($customer->negara) > 2) {
                $kode_negara = $data_negara->where("country", "=", $customer->negara)->first()->abbreviation;
            } else {
                $kode_negara = $data_negara->where("abbreviation", "=", $customer->negara)->first()->abbreviation;
            }
        }
        $data_provinsi = Provinsi::where("country_id", "=", $kode_negara)->get();
        $pic = CustomerPic::where("id_customer", "=", $id_customer)->get();
        $struktur = StrukturCustomer::where("id_customer", "=", $id_customer)->get();
        $proyeks = ProyekBerjalans::where("id_customer", "=", $id_customer)->get();
        $area_proyeks = collect();
        $per = 1000000;
        $industryOwners = IndustryOwner::all();
        $industrySectors = IndustrySector::all();

        // foreach($proyeks as $p) {
        //     $p = Proyek::find($p->kode_proyek);
        //     // $coord_kabupaten = json_decode(Storage::get("/public/data/$p->kabupaten.json"));
        //     $coord_provinsi = collect(json_decode(Storage::get("/public/data/provinsi.json")))->filter(function($data) use($p) {
        //         $data = (array) $data;
        //         return $data["id"] == $p->provinsi;
        //     })->first();
        //     // $coord_provinsi = array_filter(, function($data) use($p) {
        //     //     return $data["province_id"] == $p->provinsi;
        //     // });
        //     // dd($p->negara);
        //     // dd($coord_provinsi);
        //     if (!empty($coord_provinsi)) {
        //         $location = $p->negara . " " . $coord_provinsi->name;
        //         $getCoordCountry = Http::get("https://nominatim.openstreetmap.org/search.php?q=$location&polygon_geojson=1&format=json")->json();
        //         if (empty($area_proyeks->keys()->get($p->provinsi))) {
        //             $area_proyeks->push(["$p->provinsi" => $getCoordCountry[0]]);
        //         }
        //     }
        // }
        // begin::chart Performance Pelanggan
        // $kategoriProyek = [];
        // $proyekBerjalan = ProyekBerjalans::all();
        $kategoriProyek = $proyeks->where("unit_kerja", "!=", "")->groupBy("unit_kerja");
        $namaProyek = [];
        $nilaiOK = [];
        $totalNilaiOKPerUnit = 0;
        $totalProyekOngoing = 0;
        $totalProyekForecast = 0;
        $totalProyekClosed = 0;
        $totalProyekOpportunity = 0;
        $totalAmountProyekOngoing = 0;
        $totalAmountProyekForecast = 0;
        $totalAmountProyekClosed = 0;
        $totalAmountProyekOpportunity = 0;
        if (!empty($kategoriProyek)) {
            foreach ($kategoriProyek as $kode_unit_kerja => $proyekBerjalans) {
                if (!empty($proyekBerjalans)) {
                    foreach ($proyekBerjalans as $proyekBerjalan) {
                        // dd($proyekBerjalan, $proyekBerjalan->proyek);
                        $totalNilaiOKPerUnit += $proyekBerjalan->proyek->nilai_rkap ?? 0;
                        
                        $proyek = $proyekBerjalan->proyek;
                        if ($proyek->stage <= 3) {
                            $totalProyekOpportunity++;
                            $totalAmountProyekOpportunity += $proyek->forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) {
                                return (int) $f->nilai_forecast;
                            }) / $per;
                        }
                        if ($proyek->stage <= 5) {
                            $totalProyekOngoing++;
                            $totalAmountProyekOngoing += $proyek->forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) {
                                return (int) $f->nilai_forecast;
                            }) / $per;
                        }
                        if ($proyek->stage == 6 || $proyek->stage > 7) {
                            $totalProyekClosed++;
                            $totalAmountProyekClosed += $proyek->forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) {
                                return (int) $f->nilai_forecast;
                            }) / $per;
                        }
                        if($proyek->forecasts->where("periode_prognosa", "=", (int) date("m"))->count() > 0) {
                            $totalProyekForecast++;
                            $totalAmountProyekForecast += $proyek->forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) {
                                return (int) $f->nilai_forecast;
                            }) / $per;
                        }
                    }
                    $unitKerja = UnitKerja::where("divcode", "=", $kode_unit_kerja)->first();
                    if (!empty($unitKerja)) {
                        $totalOkLegend = number_format($totalNilaiOKPerUnit / $per, 0, '.', '.');
                        array_push($nilaiOK, ["name" => $unitKerja->unit_kerja." : $totalOkLegend", "y" => $totalNilaiOKPerUnit]);
                    }
                    $totalNilaiOKPerUnit = 0;
                }
            }
        };
        $nilaiForecast = collect([$totalProyekForecast, $totalAmountProyekForecast]);
        $proyekOngoing = collect([$totalProyekOngoing, $totalAmountProyekOngoing]);
        $proyekClosed = collect([$totalProyekClosed, $totalAmountProyekClosed]);
        $proyekOpportunity = collect([$totalProyekOpportunity, $totalAmountProyekOpportunity]);
        // dd($nilaiForecast, $proyekOngoing, $proyekClosed, $proyekOpportunity);

        // foreach ($kategoriProyek as $kategori){
        //     // array_push($namaProyek, $kategori->nama_proyek);
        //     $nilai = (int) str_replace(",", "", $kategori->nilaiok_proyek);
        //     array_push($nilaiOK, ["name" => $kategori->nama_proyek, "y" => $nilai]);
        //     if(!empty($kategori->proyek->forecasts)) {
        //         $nilaiForecast = $kategori->proyek->forecasts->sum(function($f) {
        //             if($f->periode_prognosa == (int) date("m")) {
        //                 return $f->nilai_forecast;
        //             }
        //         });
        //     }

        //     // dump($kategori->proyek->forecast);
        // }
        // dump($kategori->proyek);
        // end::chart Performance Pelanggan

        // begin::chart Laba / Rugi
        $namaUnit = [];
        $labaProyek = [];
        $rugiProyek = [];
        $piutangProyek = [];
        $nilaiTotalLaba = 0;
        $nilaiTotalRugi = 0;
        $nilaiTotalPiutang = 0;
        foreach ($kategoriProyek as $kode_unit_kerja => $proyekBerjalans) {
            foreach ($proyekBerjalans as $proyekBerjalan) {
                $nilaiTotalLaba += $proyekBerjalan->proyek->laba / $per ?? 0;
                $nilaiTotalRugi += $proyekBerjalan->proyek->rugi / $per ?? 0;
                $nilaiTotalPiutang += $proyekBerjalan->proyek->piutang / $per ?? 0;
            }
            $unitKerja = UnitKerja::where("divcode", "=", $kode_unit_kerja)->first();
            if (!empty($unitKerja) && !in_array($unitKerja->unit_kerja, $namaUnit)) {
                array_push($namaUnit, $unitKerja->unit_kerja);
            }
            array_push($labaProyek, $nilaiTotalLaba);
            array_push($rugiProyek, $nilaiTotalRugi);
            $totalPiutangLegend = number_format($nilaiTotalPiutang, 0, '.', '.');
            array_push($piutangProyek, ["name" => $unitKerja->unit_kerja." : $totalPiutangLegend", "y" => $nilaiTotalPiutang, "x" => "$totalPiutangLegend"]);
            $nilaiTotalRugi = 0;
            $nilaiTotalLaba = 0;
            $nilaiTotalPiutang = 0;


            // $proyekPiutang = $proyekBerjalan->proyek;
            // // $namaUnitIndex = array_search($proyekBerjalan->unit_kerja, $namaUnit);
            // // if($namaUnitIndex != false) {
            // //     dd($namaUnitIndex, $namaUnit);
            // // }
            // $nilaiLaba = (int) str_replace(",", "", $proyekPiutang->laba ?? 0);
            // if($nilaiLaba != 0) {
            //     array_push($labaProyek, $nilaiLaba);
            // }

            // $proyekPiutang = $proyekBerjalan->proyek;
            // $nilaiRugi = (int) str_replace(",", "", $proyekPiutang->rugi ?? 0);
            // if($nilaiRugi != 0) {
            //     array_push($rugiProyek, $nilaiRugi);
            // }
        }
        // dd($namaUnit, $labaProyek, $rugiProyek );
        // end::chart Laba / Rugi

        return view('Customer/viewCustomer', [
            "customer" => $customer,
            "attachment" => $customer->customerAttachments->all(),
            "strukturAtttachment" => $customer->strukturAttachments->all(),
            "proyekberjalan" => $customer->proyekBerjalans->all(),
            'sumberdanas' => SumberDana::all(),
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
        ], compact("namaUnit", "labaProyek", "rugiProyek", "piutangProyek", "proyekOpportunity", "industryOwners", "industrySectors"));
    }

    public function saveEdit(
        Request $request,
        Customer $editCustomer,
        CustomerAttachments $customerAttachments
    ) {

        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-customer" => "required",
            // "email" => "required",
            // "phone-number" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        $validation->validate();
        if ($validation->fails()) {
            // Alert::error('Error', "Pelanggan Gagal Dibuat, Periksa Kembali !");
            $request->old("name-customer");
            // $request->old("email");
            // $request->old("phone-number");
            return redirect()->back();
        }

        if ($data["customer-loyalty-rate"] > 5 || $data["net-promoter-score"] > 5 || $data["customer-satisfaction-index"] > 5) {
            Alert::error('Error', "CSI tidak boleh lebih dari 5 !");
            return back();
        }


        $editCustomer = Customer::find($data["id-customer"]);
        // dd($request);
        $editCustomer->name = $data["name-customer"];
        $editCustomer->handphone = $data["handphone"];
        $editCustomer->check_customer = $request->has("check-customer"); //boolean check
        $editCustomer->check_partner = $request->has("check-partner"); //boolean check
        $editCustomer->check_competitor = $request->has("check-competitor"); //boolean check
        $editCustomer->address_1 = $data["AddressLine1"];
        $editCustomer->address_2 = $data["AddressLine2"];
        $editCustomer->email = $data["email"];
        $editCustomer->phone_number = $data["phone-number"];
        $editCustomer->website = $data["website"];
        // $editCustomer->tax_number = $data["npwp_company"];
        $editCustomer->kode_pos = $data["kode-pos"];

        // form company information
        $editCustomer->jenis_instansi = $data["jenis-instansi"];
        $editCustomer->kode_pelanggan = $data["kodepelanggan-company"];
        $editCustomer->npwp_company = $data["npwp-company"];
        $editCustomer->npwp_address = $data["npwp-address"];
        $editCustomer->kode_nasabah = $data["kodenasabah-company"];
        $editCustomer->negara = $data["negara"];
        $editCustomer->provinsi = $data["provinsi"];
        // $editCustomer->kota_kabupaten = $data["kabupaten"];
        $editCustomer->industry_sector = $data["industry-sector"];
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

        // CSI :: Tab Overview Section CSI
        $editCustomer->customer_loyalty_rate = $data["customer-loyalty-rate"];
        $editCustomer->net_promoter_score = $data["net-promoter-score"];
        $editCustomer->customer_satisfaction_index = $data["customer-satisfaction-index"];

        // CUSTOMER SAP :: Tab Company Information SAP
        $is_exist_customer_sap = CustomerSAP::where("id_customer", '=', $editCustomer->id_customer)->first();
        if(!empty($is_exist_customer_sap)) {
            $is_exist_customer_sap->bp_grouping = $data["bp-grouping"];
            $is_exist_customer_sap->name_2 = $data["name-2"];
            $is_exist_customer_sap->name_3 = $data["name-3"];
            $is_exist_customer_sap->search_term_1 = $data["search-term-1"];
            $is_exist_customer_sap->search_term_2 = $data["search-term-2"];
            $is_exist_customer_sap->language = $data["languange"];
            $is_exist_customer_sap->bp_role = $data["bp-role"];
            $is_exist_customer_sap->reconciliation_account = $data["reconciliation-account"];
            $is_exist_customer_sap->check_double_invoice = $data["check-double-invoice"];
            $is_exist_customer_sap->withholding_tax_type = $data["withholding-tax-type"];
            $is_exist_customer_sap->subject = $data["subject"];
            $is_exist_customer_sap->oblig_from = $data["oblig-from"];
            $is_exist_customer_sap->oblig_to = $data["oblig-to"];
            $is_exist_customer_sap->sales_organization = $data["sales-organization"];
            $is_exist_customer_sap->distribution_channel = $data["distribution-channel"];
            $is_exist_customer_sap->customer_group = $data["customer-group"];
            $is_exist_customer_sap->price_procedure_term = $data["price-procedure-term"];
            $is_exist_customer_sap->shipping_conditions = $data["shipping-condition"];
            $is_exist_customer_sap->account_assignment_group = $data["account-assignment-group"];
            $is_exist_customer_sap->purchasing_organization = $data["purchasing-organization"];
            $is_exist_customer_sap->order_currency = $data["order-currency"];
            $is_exist_customer_sap->gr_based_invoice_verification = $data["gr-based-invoice-verification"];
            $is_exist_customer_sap->confirmation_control_key = $data["confirmation-control-key"];
            $is_exist_customer_sap->tax_number_category = $data["tax-number-category"];
            $is_exist_customer_sap->tax_number = $data["tax-number"];
            $is_exist_customer_sap->bank_country_key = $data["bank-country-key"];
            $is_exist_customer_sap->bank_keys = $data["bank-keys"];
            $is_exist_customer_sap->account_no = $data["account-no"];
            $is_exist_customer_sap->account_holder_name = $data["account-holder-name"];
            $is_exist_customer_sap->partner_function = $data["partner-function"];
            $is_exist_customer_sap->tax_category = $data["tax-category"];
            $is_exist_customer_sap->tax_classification = $data["tax-classification"];
            $is_exist_customer_sap->last_name = $data["last-name"];
            $is_exist_customer_sap->street = $data["street"];
            $is_exist_customer_sap->save();
        } else {
            $customer_sap = new CustomerSAP();
            $customer_sap->id_customer = $editCustomer->id_customer;
            // $customer_sap->supplier = $data["supplier"];
            $customer_sap->bp_grouping = $data["bp-grouping"];
            $customer_sap->name_2 = $data["name-2"];
            $customer_sap->name_3 = $data["name-3"];
            $customer_sap->search_term_1 = $data["search-term-1"];
            $customer_sap->search_term_2 = $data["search-term-2"];
            $customer_sap->language = $data["languange"];
            $customer_sap->bp_role = $data["bp-role"];
            $customer_sap->reconciliation_account = $data["reconciliation-account"];
            $customer_sap->check_double_invoice = $data["check-double-invoice"];
            $customer_sap->withholding_tax_type = $data["withholding-tax-type"];
            $customer_sap->subject = $data["subject"];
            $customer_sap->oblig_from = $data["oblig-from"];
            $customer_sap->oblig_to = $data["oblig-to"];
            $customer_sap->sales_organization = $data["sales-organization"];
            $customer_sap->distribution_channel = $data["distribution-channel"];
            $customer_sap->customer_group = $data["customer-group"];
            $customer_sap->price_procedure_term = $data["price-procedure-term"];
            $customer_sap->shipping_conditions = $data["shipping-condition"];
            $customer_sap->account_assignment_group = $data["account-assignment-group"];
            $customer_sap->purchasing_organization = $data["purchasing-organization"];
            $customer_sap->order_currency = $data["order-currency"];
            $customer_sap->gr_based_invoice_verification = $data["gr-based-invoice-verification"];
            $customer_sap->confirmation_control_key = $data["confirmation-control-key"];
            $customer_sap->tax_number_category = $data["tax-number-category"];
            $customer_sap->tax_number = $data["tax-number"];
            $customer_sap->bank_country_key = $data["bank-country-key"];
            $customer_sap->bank_keys = $data["bank-keys"];
            $customer_sap->account_no = $data["account-no"];
            $customer_sap->account_holder_name = $data["account-holder-name"];
            $customer_sap->partner_function = $data["partner-function"];
            $customer_sap->tax_category = $data["tax-category"];
            $customer_sap->tax_classification = $data["tax-classification"];
            $customer_sap->last_name = $data["last-name"];
            $customer_sap->street = $data["street"];
            $customer_sap->save();
        }


        // form attachment

        $editCustomer->note_attachment = $data["note-attachment"];
        $customerAttachments->id_customer = $data["id-customer"];
        // $customerAttachments->name_customer=$data["name-customer"];

        $id_customer = $data["id-customer"];

        if ($_FILES['doc-attachment']['size'] == 0) {
            Alert::toast("Edit Berhasil", "success")->autoClose(3000);
            // file is empty (and not an error)
            if (isset($data["struktur-attachment"])) {
                self::uploadStrukturOrganisasi($data["struktur-attachment"], $id_customer);
            }
            $editCustomer->save();
        } else {
            if (isset($data["struktur-attachment"])) {
                self::uploadStrukturOrganisasi($data["struktur-attachment"], $id_customer);
            }
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

    public function pic(Request $request, CustomerPic $newPIC)
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
            Alert::error("Error", "PIC Gagal Ditambahkan, Periksa Kembali !");
            return redirect()->back();
        }

        $validation->validate();

        $newPIC->id_customer = $data["id-customer"];
        $newPIC->nama_pic = $data["name-pic"];
        $newPIC->jabatan_pic = $data["kode-pic"];
        $newPIC->email_pic = $data["email-pic"];
        $newPIC->phone_pic = $data["phone-number-pic"];

        Alert::success("Success", $data["kode-pic"] . ": " . $data["name-pic"] . ", PIC Berhasil Ditambah");

        $newPIC->save();
        return redirect()->back();
    }

    public function editPic(Request $request, $id)
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
            Alert::error("Error", "PIC Gagal Ditambahkan, Periksa Kembali !");
            return redirect()->back();
        }

        $validation->validate();

        $editPIC = CustomerPic::find($id);

        $editPIC->id_customer = $data["id-customer"];
        $editPIC->nama_pic = $data["name-pic"];
        $editPIC->jabatan_pic = $data["kode-pic"];
        $editPIC->email_pic = $data["email-pic"];
        $editPIC->phone_pic = $data["phone-number-pic"];

        Alert::success("Success", $data["kode-pic"] . ": " . $data["name-pic"] . ", PIC Berhasil Diubah");

        $editPIC->save();
        return redirect()->back();
    }

    public function deletePic($id)
    {
        $delete = CustomerPic::find($id);
        // dd($delete);
        $delete->delete();
        Alert::success("Success", "PIC Berhasil Dihapus");
        return redirect()->back();
    }

    public function struktur(Request $request, StrukturCustomer $newStruktur)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-struktur" => "required",
            "jabatan-struktur" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error("Error", "Struktur Gagal Ditambahkan, Periksa Kembali !");
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
        $newStruktur->ultah_struktur = $data["ultah-struktur"];
        $newStruktur->proyek_struktur = $data["proyek-struktur"];
        $newStruktur->role_struktur = $data["role-struktur"];

        Alert::success("Success", $data["jabatan-struktur"] . ": " . $data["name-struktur"] . ", Struktur Berhasil Ditambahkan");

        $newStruktur->save();
        return redirect()->back();
    }

    public function editStruktur(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "This field is required",
        ];
        $rules = [
            "name-struktur" => "required",
            "jabatan-struktur" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error("Error", "Struktur Gagal Ditambahkan, Periksa Kembali !");
            return redirect()->back();
        }

        $validation->validate();

        $editStruktur = StrukturCustomer::find($id);
        $editStruktur->id_customer = $data["id-customer"];
        $editStruktur->nama_struktur = $data["name-struktur"];
        $editStruktur->jabatan_struktur = $data["jabatan-struktur"];
        $editStruktur->email_struktur = $data["email-struktur"];
        $editStruktur->phone_struktur = $data["phone-struktur"];
        $editStruktur->ultah_struktur = $data["ultah-struktur"];
        $editStruktur->proyek_struktur = $data["proyek-struktur"];
        $editStruktur->role_struktur = $data["role-struktur"];

        Alert::success("Success", $data["jabatan-struktur"] . ": " . $data["name-struktur"] . ", Struktur Berhasil Ditambahkan");

        $editStruktur->save();
        return redirect()->back();
    }

    public function deleteStruktur($id)
    {
        $delete = StrukturCustomer::find($id);
        // dd($delete);
        $delete->delete();
        Alert::success("Success", "Struktur Berhasil Dihapus");
        return redirect()->back();
    }

    public function deleteStrukturAttach($id)
    {
        $delete = StrukturAttachment::find($id);
        $extFile = explode(".", $delete->nama_dokumen);
        $extFile = $extFile[count($extFile) - 1];
        if (File::exists(public_path("words/" . $delete->id_document . "." . $extFile))) {
            File::delete(public_path("words/" . $delete->id_document . "." . $extFile));
        }
        $delete->delete();
        Alert::success("Success", "Struktur Berhasil Dihapus");
        return redirect()->back();
    }

    public function customerHistory(
        Request $request,
        Customer $modalCustomer,
        ProyekBerjalans $customerHistory,
    ) {

        $data = $request->all();
        // $proyekAll = Proyek::all();

        $modalCustomer = Customer::find($data["id-customer"]);
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

    public function getNilaiOKCustomer(Request $request) {
        $customer = Customer::find($request->id_customer);
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $proyeks = $customer->proyekBerjalans->map(function($pb) {
            return $pb->proyek;
        });
        $proyeks = $proyeks->where("unit_kerja", "=", $unit_kerja->divcode)->sortByDesc("nilai_rkap")->values();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai OK");
        
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $unit_kerja) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $unit_kerja->unit_kerja);
            $sheet->setCellValue('D' . $row, $p->nilai_rkap);
            // $p->nilai_ok = $nilai_ok;
            $p->unit_kerja = $unit_kerja->unit_kerja;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $unit_kerja_join = str_replace(" ", "-", $unit_kerja->unit_kerja);
        $file_name = "$unit_kerja_join-Nilai-OK-Pelanggan-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getNilaiPiutangCustomer(Request $request) {
        $customer = Customer::find($request->id_customer);
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $proyeks = $customer->proyekBerjalans->map(function($pb) {
            return $pb->proyek;
        });
        $proyeks = $proyeks->where("unit_kerja", "=", $unit_kerja->divcode)->sortByDesc("piutang")->values();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', "Nilai Piutang");
        
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $unit_kerja) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $unit_kerja->unit_kerja);
            $sheet->setCellValue('D' . $row, $p->piutang);
            // $p->nilai_ok = $nilai_ok;
            $p->unit_kerja = $unit_kerja->unit_kerja;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $unit_kerja_join = str_replace(" ", "-", $unit_kerja->unit_kerja);
        $file_name = "$unit_kerja_join-Nilai-Piutang-Pelanggan-" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    public function getNilaiLabaRugiCustomer(Request $request) {
        $customer = Customer::find($request->id_customer);
        $type = $request->type;
        $unit_kerja = UnitKerja::where("unit_kerja", "=", $request->unit_kerja)->first();
        $proyeks = $customer->proyekBerjalans->map(function($pb) {
            return $pb->proyek;
        });
        if($type == "Laba") {
            $proyeks = $proyeks->where("unit_kerja", "=", $unit_kerja->divcode)->sortByDesc("laba")->values();
        } else {
            $proyeks = $proyeks->where("unit_kerja", "=", $unit_kerja->divcode)->sortByDesc("rugi")->values();
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Stage');
        $sheet->setCellValue('C1', 'Unit Kerja');
        if($type == "Laba") {
            $sheet->setCellValue('D1', "Nilai Laba");
        } else {
            $sheet->setCellValue('D1', "Nilai Rugi");
        }
        
        $row = 2;
        $proyeks->each(function ($p) use (&$row, $sheet, $unit_kerja, $type) {
            $sheet->setCellValue('A' . $row, $p->nama_proyek);
            $sheet->setCellValue('B' . $row, $this->getProyekStage($p->stage));
            $sheet->setCellValue('C' . $row, $unit_kerja->unit_kerja);
            if($type == "Laba") {
                $sheet->setCellValue('D' . $row, $p->laba);
            } else {
                $sheet->setCellValue('D' . $row, $p->rugi);
            }
            // $p->nilai_ok = $nilai_ok;
            $p->unit_kerja = $unit_kerja->unit_kerja;
            $row++;
        });
        $writer = new Xlsx($spreadsheet);
        $unit_kerja_join = str_replace(" ", "-", $unit_kerja->unit_kerja);
        if($type == "Laba") {
            $file_name = "$unit_kerja_join-Nilai-Laba-Pelanggan-" . date('dmYHis') . ".xlsx";
        } else {
            $file_name = "$unit_kerja_join-Nilai-Rugi-Pelanggan-" . date('dmYHis') . ".xlsx";
        }
        $writer->save(public_path("excel/$file_name"));

        return response()->json(["href" => $file_name, "data" => $proyeks]);
    }

    private function uploadStrukturOrganisasi(UploadedFile $uploadedFile, $id_customer)
    {
        $faker = new Uuid();
        $dokumen = new StrukturAttachment();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->id_customer = $id_customer;
        // dd($dokumen);
        $dokumen->save();
    }

    public function getKodeNasabah(Request $request) {
        $response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm", $request->all())->body();
        return response($response);
    }

    public function getFullMonth($month)
    {
        switch ($month) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    public static function getProyekStage($month)
    {
        switch ($month) {
            case 0:
                return "Pasar Dini";
                break;
            case 1:
                return "Pasar Dini";
                break;
            case 2:
                return "Pasar Potensial";
                break;
            case 3:
                return "Prakualifikasi";
                break;
            case 4:
                return "Tender Diikuti";
                break;
            case 5:
                return "Perolehan";
                break;
            case 6:
                return "Menang";
                break;
            case 7:
                return "Terendah";
                break;
            case 8:
                return "Terkontrak";
                break;
        }
    }

}
