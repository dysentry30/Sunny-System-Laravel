<?php

namespace App\Http\Controllers;

use App\Models\AlatProyek;
use App\Models\Dop;
use App\Models\Sbu;
use App\Models\User;
use Faker\Core\Uuid;
use App\Models\Proyek;
use App\Models\Company;
use App\Models\PorsiJO;
use App\Models\Customer;
use App\Models\Forecast;
use App\Models\MataUang;
use App\Models\UnitKerja;
use App\Models\SumberDana;
use App\Models\TeamProyek;
use Illuminate\Http\Request;
use App\Models\DokumenTender;
use App\Models\KriteriaPasar;
use App\Models\PesertaTender;
use App\Models\ProyekAdendum;
use App\Models\HistoryForecast;
use App\Models\ProyekBerjalans;
use App\Models\AttachmentMenang;
use App\Models\ClaimManagements;
use App\Models\RiskTenderProyek;
use Illuminate\Http\UploadedFile;
use Illuminate\support\Facades\DB;
use App\Models\ContractManagements;
use App\Models\ContractRFADocument;
use App\Models\Departemen;
use App\Models\DokumenConsentNPWP;
use App\Models\DokumenDraft;
use App\Models\DokumenEca;
use App\Models\DokumenIca;
use App\Models\DokumenItbTor;
use App\Models\DokumenMou;
use App\Models\DokumenNda;
use App\Models\DokumenPefindo;
use App\Models\MasterPefindo;
use App\Models\DokumenNotaRekomendasi1;
use App\Models\KriteriaPasarProyek;
use App\Models\SyaratPrakualifikasi;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\DokumenPrakualifikasi;
use App\Models\DokumenRks;
use App\Models\JenisProyek;
use App\Models\KonsultanPerencana;
use App\Models\MatriksApprovalRekomendasi;
use App\Models\Provinsi;
use App\Models\ProyekKonsultanPerencana;
use App\Models\TipeProyek;
use App\Models\ChecklistCalonMitraKSO;
use App\Models\KriteriaPenilaianPefindo;
use App\Models\MasterKriteriaGreenlanePartner;
use App\Models\TimTender;
use App\Models\MatriksApprovalNotaRekomendasi2;
use App\Models\NotaRekomendasi2;
use App\Models\DokumenPenentuanKSO;
use App\Models\DokumenPenentuanProjectGreenlane;
use App\Models\MasterKlasifikasiOmsetProyek;
use App\Models\MasterKlasifikasiProduksiProyek;
use App\Models\DokumenKelengkapanPartnerKSO;
use App\Models\MasterGrupTierBUMN;
use App\Models\Negara;
use App\Models\PersonelTenderProyek;
use App\Models\DokumenPendukungPasdin;
use App\Models\MatriksApprovalPaparan;
use App\Models\NotaRekomendasi;
use App\Models\CashFlowProyek;
use App\Models\DokumenOtherProyek;
use App\Models\DokumenPersetujuanKSO;
use App\Models\DokumenSCurvesProyek;
use App\Models\MasterKlasifikasiSBU;
use App\Models\MasterSubKlasifikasiSBU;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Google\Service\FactCheckTools\Resource\Claims;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use DateTime;
use Illuminate\Support\Facades\Gate;

class ProyekController extends Controller
{
    public function view(Request $request, $datatables = "")
    {
        $cari = $request->query("cari");
        // $column = $request->get("column");
        $column = null;
        $filter = $request->query("filter");
        $filterStage = $request->query("filter-stage");
        $filterJenis = $request->query("filter-jenis");
        $filterTipe = $request->query("filter-tipe");
        $filterUnit = $request->query("filter-unit");
        $selected_year = $request->query("tahun-proyek") ?? (int) date("Y");
        $filterKalah = $request->query("filter-kalah");
        // dd($column);
        // $proyekBerjalan = ProyekBerjalans::all();
        // dd($proyekBerjalan);
        $customers = Customer::all();
        $sumberdanas = SumberDana::all();
        $jenisProyek = JenisProyek::all();
        $tipeProyek = TipeProyek::all();

        $year = (int) date("Y");

        if (Auth::user()->check_administrator) {
            $unitkerjas = UnitKerja::all()->sortBy('id_profit_center');
            if ($selected_year > 2022) {
                $unitkerjas = $unitkerjas->whereNotNull('id_profit_center');
            }
            // dd($unitkerjas);
            // $proyeks = Proyek::with(['UnitKerja', 'Forecasts', 'proyekBerjalan']);
            $proyeks = Proyek::with(['UnitKerja', 'proyekBerjalan']);
        } else {
            // $proyeks = Proyek::with(['UnitKerja', 'Forecasts', 'proyekBerjalan'])->where("unit_kerja", "=", Auth::user()->unit_kerja);
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : collect(Auth::user()->unit_kerja);
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $unitkerjas = UnitKerja::all()->whereIn("divcode", $unit_kerja_user->toArray())->sortBy('id_profit_center');
                if ($selected_year > 2022) {
                    $unitkerjas = $unitkerjas->whereNotNull('id_profit_center');
                }
                $proyeks = Proyek::with(['UnitKerja', 'proyekBerjalan'])->whereIn("unit_kerja", $unit_kerja_user->toArray());
            }
        }
        $tahun_proyeks = $proyeks->get()->groupBy("tahun_perolehan")->keys();
        if(!empty($selected_year)) {
            $proyeks = $proyeks->where("tahun_perolehan", "=", $selected_year);
        } else {
            $proyeks = $proyeks->where("tahun_perolehan", "=", $year);
        }

        // Begin::FILTER
        // if (!empty($filter)) {
        //     // $proyeks = $proyeks->where($column, 'like', '%' . $filter . '%')->get();
        //     $proyeks = $proyeks->get()->filter(function ($p) use ($column, $filter) {
        //         return preg_match("/$filter/i", $p[$column]);
        //     });
        // } 
        
        if (!empty($filterUnit)) {
            $proyeks = $proyeks->where('unit_kerja', '=', $filterUnit);
            // $proyeks = $proyeks->get()->filter(function ($p) use ($column, $filterUnit) {
            //     return preg_match("/$filterUnit/i", $p[$column]);
            // });
        } 
        
        if (!empty($filterStage)) {
            $proyeks = $proyeks->where('stage', '=', (int) $filterStage);
            // $proyeks = $proyeks->get()->filter(function ($p) use ($column, $filterStage) {
            //     return preg_match("/$filterStage/i", $p[$column]);
            // });
        } 
        
        if (!empty($filterJenis)) {
            $proyeks = $proyeks->where('jenis_proyek', '=', $filterJenis);
            // $proyeks = $proyeks->get()->filter(function ($p) use ($column, $filterJenis) {
            //     return preg_match("/$filterJenis/i", $p[$column]);
            // });
        } 
        
        if (!empty($filterTipe)) {
            $proyeks = $proyeks->where('tipe_proyek', '=', $filterTipe);
            // $proyeks = $proyeks->get()->filter(function ($p) use ($column, $filterTipe) {
            //     return preg_match("/$filterTipe/i", $p[$column]);
            // });
        }

        if (!empty($filterKalah)) {
            $proyeks = $proyeks->where('kategori_kalah', '=', $filterKalah);
        }

        $proyeks = $proyeks->get();
        $filter = null;
        // dd($filter);

        if (empty($datatables)) {
            return view('3_Proyek', compact(["tahun_proyeks", "filterJenis", "filterTipe", "filterUnit", "filterStage", "selected_year", "proyeks", "cari", "column", "filter", "customers", "sumberdanas", "unitkerjas", "jenisProyek", "tipeProyek", "filterKalah"]));
        }
        return view('3_DataSetProyek', compact(["tahun_proyeks", "filterJenis", "filterTipe", "filterUnit", "filterStage", "selected_year", "proyeks", "cari", "column", "filter", "customers", "sumberdanas", "unitkerjas", "jenisProyek", "tipeProyek", "filterKalah"]));
    }

    public function save(Request $request, Proyek $newProyek)
    {
        $dataProyek = $request->all();
        $proyekAll = Proyek::where("unit_kerja", "=", $dataProyek["unit-kerja"])->get();
        $unitKerja = UnitKerja::where('divcode', "=", $dataProyek["unit-kerja"])->get()->first();

        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nama-proyek" => "required",
            "unit-kerja" => "required",
            "jenis-proyek" => "required",
            "tipe-proyek" => "required",
            "nilai-rkap" => "required",
            // "sumber-dana" => "required",
            "tahun-perolehan" => "required",
            // "departemen-proyek" => "required",
            // "bulan-pelaksanaan" => "required",
        ];
        $validation = Validator::make($dataProyek, $rules, $messages);
        if ($validation->fails()) {
            Alert::toast("Proyek Gagal Dibuat, Periksa Kembali !", "error")->autoClose(3000);
            $request->old("nama-proyek");
            $request->old("unit-kerja");
            $request->old("jenis-proyek");
            $request->old("tipe-proyek");
            // $request->old("nilai-rkap");
            // $request->old("sumber-dana");
            $request->old("tahun-perolehan");
            $request->old("departemen-proyek");
            // $request->old("bulan-pelaksanaan");
            redirect()->back()->with("modal", $dataProyek["modal-name"]);
            // Session::flash('failed', 'Proyek gagal dibuat, Periksa kembali button "NEW" !');
        }

        // dd($dataProyek["departemen-proyek"]);

        $validation->validate();

        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        $newProyek->jenis_proyek = $dataProyek["jenis-proyek"];
        $newProyek->tipe_proyek = $dataProyek["tipe-proyek"];
        $newProyek->departemen_proyek = $dataProyek["departemen-proyek"] ?? null;
        // $newProyek->nilai_rkap = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);
        // $newProyek->sumber_dana = $dataProyek["sumber-dana"];
        $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        $newProyek->bulan_pelaksanaan = $dataProyek["bulan-pelaksanaan"];
        if($newProyek->jenis_proyek == "J") {
            $newProyek->jenis_jo = $dataProyek["kategori-jo"];
        } else if($newProyek->jenis_proyek == "N") {
            $newProyek->jenis_jo = 10;
        } else {
            $newProyek->jenis_jo = 20;
        }

        $nilaiOK = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);

        if ($nilaiOK > 500000000000 && $nilaiOK <= 2000000000000) {
            $newProyek->klasifikasi_pasdin = "Proyek Besar";
        } elseif ($nilaiOK > 250000000000 && $nilaiOK <= 500000000000) {
            $newProyek->klasifikasi_pasdin = "Proyek Menengah";
        } elseif ($nilaiOK > 0 && $nilaiOK <= 250000000000) {
            $newProyek->klasifikasi_pasdin = "Proyek Kecil";
        } elseif ($nilaiOK > 2000000000000) {
            $newProyek->klasifikasi_pasdin = "Proyek Mega";
        }

        //auto filled by required 
        $newProyek->bulan_awal = $dataProyek["bulan-pelaksanaan"];

        $newProyek->dop = $unitKerja->dop;
        $newProyek->company = $unitKerja->company;

        $newProyek->nilaiok_awal = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);
        // $newProyek->nilai_valas_review = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);
        // $newProyek->bulan_review = $dataProyek["bulan-pelaksanaan"];
        // $newProyek->nilaiok_review = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);
        // $newProyek->kurs_review = 1;
        // $newProyek->mata_uang_review = "IDR";

        $newProyek->kurs_awal = 1;
        $newProyek->mata_uang_awal = "IDR";
        $newProyek->nilaiok_awal = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);
        $newProyek->porsi_jo = 100;
        $newProyek->is_cancel = false;

        //begin::Generate Kode Proyek
        // $generateProyek = Proyek::where("tahun_perolehan", "=", (int) date("Y"))->get()->sortBy("id");

        $unit_kerja = $dataProyek["unit-kerja"];
        $jenis_proyek = $dataProyek["jenis-proyek"];
        $tipe_proyek = $dataProyek["tipe-proyek"];
        if ($tipe_proyek == "R") {
            $newProyek->stage = 8;
        } else {
            $newProyek->stage = 1;
        }
        $tahun = $dataProyek["tahun-perolehan"];

        // Kondisi kalau tahun lebih besar dari 2021 maka O Selain itu A
        // $kode_tahun = $tahun == 2021 ? "A" : "O";
        $kode_tahun = get_year_code($tahun);
        
        // Menggabungkan semua kode beserta nomor urut
        $kode_proyek = $unit_kerja . $jenis_proyek . $tipe_proyek . $kode_tahun;
        // $kode_proyek = $jenis_proyek . $tipe_proyek . $kode_tahun;

        // $no_urut = $generateProyek->count(function($p) use($kode_proyek) {
        //     return str_contains($p->kode_proyek, $kode_proyek);
        // }) + 1;

        $lastProyek = Proyek::select(["kode_proyek", "nama_proyek"])->where("kode_proyek", "like", "%" . $kode_proyek . "%")->get()->sortBy("kode_proyek")->last();
        // dd($no_urut);
        if (empty($lastProyek)) {
            $no_urut = 1;
        } else {
            $no_urut = (int) preg_replace("/[^0-9]/", "", $lastProyek->kode_proyek) + 1;
            if (preg_match('~[0-9]+~', $dataProyek["unit-kerja"])) {
                $no_urut = (int) (substr(preg_replace("/[^0-9]/", "", $lastProyek->kode_proyek) + 1, 1));
            }
            $len = strlen($no_urut);
            // $no_urut = (int) trim($lastProyek->kode_proyek, $kode_proyek) + 1;
            // $no_urut = substr($no_urut, ($len-3), 3);
        }
        
        // dd($lastProyek, $no_urut, $len);

        // Untuk membuat 3 digit nomor urut terakhir
        $no_urut = str_pad(strval($no_urut), 3, 0, STR_PAD_LEFT);
        // if (str_contains($generateProyek->last()->kode_proyek, "KD")) {
            //     $no_urut = (int) $generateProyek->last()->id + 1;
            // } else {
                //     // $no_urut = count($generateProyek)+1;
        //     $no_urut = (int) $generateProyek->last()->id + 1;
        // }
        
        // dd($kode_proyek . $no_urut);
        // for ($i= $no_urut; $i < $no_urut+100; $i++) { 
            //     # code...
            // }
        // $kode_proyek = $unit_kerja . $kode_proyek;
        $existProyek = Proyek::find($kode_proyek . $no_urut);
        if (!empty($existProyek)) {
            $number = (int) $no_urut+1;
            
            foreach ($proyekAll as $proyekExist) {
                if ($proyekExist->kode_proyek != $existProyek->kode_proyek) {
                    $number = (int) $no_urut+1;
                }
            }
            $number = str_pad(strval($number), 3, 0, STR_PAD_LEFT);
            // dd($existProyek, $kode_proyek . $number);
            $newProyek->kode_proyek = $kode_proyek . $number;
        } else {
            $newProyek->kode_proyek = $kode_proyek . $no_urut;
        }
        // dd($newProyek->kode_proyek, $existProyek);
        //end::Generate Kode Proyek

        // $newForecast = new Forecast;
        // $newForecast-


        //end::Generate Kode Proyek
        $idCustomer = $dataProyek["customer"];

        Alert::success('Success', $dataProyek["nama-proyek"] . ", Berhasil Ditambahkan");
        // dd($newProyek);

        if ($newProyek->save()) {

            if ($tipe_proyek == "P"){
                $uuid = new Uuid();
                $contractManagements = new ContractManagements();
                // dd($contractManagements);
                $contractManagements->project_id = $newProyek->kode_proyek;
                $contractManagements->id_contract = $uuid->uuid3();
                // $contractManagements->contract_in = $dataProyek["tanggal-mulai-kontrak"];
                // $contractManagements->contract_out = $dataProyek["tanggal-akhir-kontrak"];
                // $contractManagements->number_spk = $dataProyek["nospk-external"];
                // $contractManagements->value = preg_replace("/[^0-9]/i", "", $dataProyek["nilai-perolehan"]);
                // $contractManagements->value_review = 0;
                $contractManagements->contract_proceed = "Belum Selesai";
                $contractManagements->profit_center = $newProyek->profit_center;
                $contractManagements->stages = (int) 1;
                $contractManagements->save();
            }   

            if ($idCustomer != null) {
                // $customerHistory = ProyekBerjalans::where('kode_proyek', "=", $newProyek->kode_proyek)->get()->first();
                // dd($customerHistory);
                $customerHistory = new ProyekBerjalans();
                $customerHistory->id_customer = $idCustomer;
                $nameCustomer = Customer::find($idCustomer);
                $customerHistory->name_customer = $nameCustomer->name;
                $customerHistory->nama_proyek = $newProyek->nama_proyek;
                $customerHistory->kode_proyek = $newProyek->kode_proyek;
                $customerHistory->pic_proyek = $newProyek->ketua_tender;
                $customerHistory->unit_kerja = $newProyek->unit_kerja;
                $customerHistory->jenis_proyek = $newProyek->jenis_proyek;
                $customerHistory->nilaiok_proyek = $newProyek->nilaiok_awal;
                $customerHistory->stage = $newProyek->stage;
                $customerHistory->save();
            }
            return redirect("/proyek/view/".$newProyek->kode_proyek)->with("success", ($dataProyek["nama-proyek"] . ", Berhasil dibuat"));
        }
        // return redirect("/proyek")->with("failed", ($dataProyek["nama-proyek"].", Gagal Dibuat"));
    }

    public function edit($kode_proyek, $periodePrognosa = "")
    {
        $proyek = Proyek::find($kode_proyek);
        $mataUang = MataUang::all();
        // dd($proyek);
        if (empty($proyek)) {
            Alert::warning('Warning', "Proyek Tidak Ditemukan");
            return redirect("/proyek");
        }
        $historyForecastAll = HistoryForecast::where("kode_proyek", "=", $kode_proyek)->get();
        $historyForecast = $historyForecastAll->where("periode_prognosa", "=", date("m"));
        $teamProyek = TeamProyek::where("kode_proyek", "=", $kode_proyek)->get();
        $kriteriaProyek = KriteriaPasarProyek::where("kode_proyek", "=", $kode_proyek)->get();
        $porsiJO = PorsiJO::where("kode_proyek", "=", $kode_proyek)->get();
        // $data_provinsi = json_decode(Storage::get("/public/data/provinsi.json"));
        // $data_negara = json_decode(Storage::get("/public/data/country.json"));
        $data_negara = Negara::all();
        $is_admin = Auth::user()->check_administrator || str_contains(Auth::user()->name, "PIC");
        $companies = Company::all();
        $sumberdanas = SumberDana::all();
        $dops = Dop::all();
        $sbus = Sbu::all();
        $unitkerjas = UnitKerja::all();
        $customers = Customer::all();
        $users = User::all();
        $kriteriapasar = KriteriaPasar::all()->unique("kategori");
        $kriteriapasarproyek = $kriteriaProyek;
        $teams = $teamProyek;
        $provinsi = Provinsi::all();
        $pesertatender = PesertaTender::where("kode_proyek", "=", $kode_proyek)->get();
        $proyekberjalans = ProyekBerjalans::where("kode_proyek", "=", $kode_proyek)->get()->first();
        $departemen = Departemen::where("kode_divisi", "=", $proyek->UnitKerja->kode_sap)->get();

        // $historyForecast = $historyForecast;
        // $porsiJO = $porsiJO;
        // $data_negara = $data_negara;
        // dd($proyek); //tes log hasil 
        if ($proyek->tipe_proyek == "P") {
            $klasifikasiSBU = MasterKlasifikasiSBU::all();
            if (!empty($proyek->klasifikasi_sbu_kbli)) {
                $subKBLI = MasterSubKlasifikasiSBU::where('klasifikasi_id', $proyek->klasifikasi_sbu_kbli)->get();
            } else {
                $subKBLI = [];
            }
            $konsultan_perencana = KonsultanPerencana::all();
            // dd($teamProyek, $kriteriaProyek, $porsiJO, $pesertatender, $proyekberjalans, $departemen);
            $isExistPorsiJO = PorsiJO::where('kode_proyek', $proyek->kode_proyek)->get();
            if (!empty($isExistPorsiJO)) {
                $isExistPorsiJO->each(function ($porsi) {
                    $kriteria_partner = MasterGrupTierBUMN::where('id_pelanggan', $porsi->id_company_jo)->first();
                    $kriteria_partner_greenlane = MasterKriteriaGreenlanePartner::where('id_pelanggan', $porsi->id_company_jo)->first();
                    if (!empty($kriteria_partner)) {
                        $porsi->is_greenlane = true;
                        $porsi->is_disetujui = true;
                    } else {
                        if ($kriteria_partner_greenlane) {
                            $porsi->is_greenlane = true;
                            $porsi->is_disetujui = true;
                        } else {
                            $porsi->is_greenlane = false;
                        }
                    }
                    if (!$porsi->is_greenlane) {
                        if (empty($porsi->score_pefindo_jo)) {
                            $checkPefindo = MasterPefindo::where('id_pelanggan', $porsi->id_company_jo)->latest()?->first();
                            if (!empty($checkPefindo)) {
                                $porsi->score_pefindo_jo = $checkPefindo->score;
                                $porsi->file_pefindo_jo = $checkPefindo->id_document;
                                $porsi->grade = $checkPefindo->grade;
                                $porsi->keterangan = $checkPefindo->keterangan;

                                if (str_contains($checkPefindo->grade, 'E')) {
                                    $porsi->is_disetujui = false;
                                } else {
                                    $porsi->is_disetujui = true;
                                }
                            }
                        }
                    }
                    $porsi->save();
                });
            }
            return view(
                'Proyek/viewProyek',
                ["proyek" => $proyek, "proyeks" => Proyek::all()],
                compact(['companies', 'sumberdanas', 'dops', 'sbus', 'unitkerjas', 'customers', 'users', 'kriteriapasar', 'kriteriapasarproyek', 'teams', 'pesertatender', 'proyekberjalans', 'historyForecast', 'porsiJO', 'data_negara', 'mataUang', "provinsi", "departemen", "konsultan_perencana", "klasifikasiSBU", "subKBLI"])
                // [
                //     'companies' => Company::all(),
                //     'sumberdanas' => SumberDana::all(),
                //     'dops' => Dop::all(),
                //     'sbus' => Sbu::all(),
                //     'unitkerjas' => UnitKerja::all(),
                //     'customers' => Customer::all(),
                //     'users' => User::all(),
                //     'kriteriapasar' => KriteriaPasar::all()->unique("kategori"),
                //     'kriteriapasarproyek' => $kriteriaProyek,
                //     'teams' => $teamProyek,
                //     'pesertatender' => PesertaTender::where("kode_proyek", "=", $kode_proyek)->get(),
                //     'proyekberjalans' => ProyekBerjalans::where("kode_proyek", "=", $kode_proyek)->get()->first(),
                //     "historyForecast" => $historyForecast,
                //     'porsiJO' => $porsiJO,
                //     // 'data_provinsi' => $data_provinsi,
                //     'data_negara' => $data_negara,
                //     ]
            );
        } else {
            $periodePrognosa = $periodePrognosa == "" ? (int) date("m") : $periodePrognosa;
            $historyForecastAll = $historyForecastAll->groupBy("periode_prognosa");
            $listPeriodeExistInHistory = $historyForecastAll->keys()->sort()->values();
            // dd($listPeriodeExistInHistory);
            $tabPane = "";
            return view('Proyek/viewProyekRetail', ["proyek" => $proyek, "proyeks" => Proyek::all()], compact(['is_admin', "periodePrognosa", 'companies', 'sumberdanas', 'dops', 'sbus', 'unitkerjas', 'customers', 'users', 'kriteriapasar', 'kriteriapasarproyek', 'teams', 'pesertatender', 'proyekberjalans', 'historyForecast', 'porsiJO', 'data_negara', 'tabPane', "provinsi", "listPeriodeExistInHistory"]));
            // return redirect()->back();
        }
    }

    public function getDataDepartemen($divcode)
    {
        if (str_contains($divcode, 'A')) {
            $departemen = Departemen::where("kode_divisi", "=", $divcode)->get();
        } else {
            $unit_kerja = UnitKerja::where("divcode", "=", $divcode)->first();
            // dd($unit_kerja);
            $departemen = Departemen::where("kode_divisi", "=", $unit_kerja->kode_sap)->get();
        }
        if($departemen->isNotEmpty()){
            return response()->json([
                "status" => "success",
                "data" => $departemen
            ], 200);
        }else{
            return response()->json([
                "status" => "error",
                "data" => []
            ], 404);
        }
    }

    public function update(Request $request, Proyek $newProyek, ProyekBerjalans $customerHistory)
    {
        $dataProyek = $request->all();
        // dd($dataProyek);
        // dd($dataProyek); //console log hasil $dataProyek
        $newProyek = Proyek::find($dataProyek["kode-proyek"]);

        // dd($newProyek);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
            "numeric" => "*Kolom ini harus numeric!",
        ];
        $rules = [
            "nama-proyek" => "required",
            // "bulan-pelaksanaan" => "required",
            // "nilai-rkap" => "required",
            // "sumber-dana" => "required",
            // "porsi-jo" => "numeric"
        ];
        // if (isset($dataProyek["porsi-jo"])) {
        //     $rules["porsi-jo"] = "numeric";
        // }
        $validation = Validator::make($dataProyek, $rules, $messages);
        if ($validation->fails()) {
            // dd($validation);
            Alert::error('Error', "Proyek Gagal Diubah, Periksa Kembali !");
            $request->old("nama-proyek");
            Session::flash('failed', 'Proyek gagal dibuat, Periksa kembali button "NEW" !');
        }

        $validation->validate();

        $bulans = (int) date('m');
        $years = (int) date('Y');
        // dd($bulans);

        // form PASAR DINI
        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        // $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        $newProyek->kode_proyek = $dataProyek["kode-proyek"];
        $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        $newProyek->sumber_dana = $dataProyek["sumber-dana"];
        $newProyek->departemen_proyek = $dataProyek["departemen-proyek"];
        $newProyek->jenis_proyek = $dataProyek["jenis-proyek"];
        $newProyek->tipe_proyek = $dataProyek["tipe-proyek"];
        if ($dataProyek["tipe-proyek"] == "R") {
            $newProyek->stage = 8;
            $forecasts = Forecast::where("kode_proyek", "=", $newProyek->kode_proyek)->where("periode_prognosa", "=", $bulans)->whereYear("created_at", "=", $years)->first();
            $forecasts->delete();
        }
        // $newProyek->pic = $dataProyek["pic"];
        $newProyek->bulan_pelaksanaan = $dataProyek["bulan-pelaksanaan"];
        $newProyek->nilaiok_awal = (int) str_replace('.', '', $dataProyek["nilai-rkap"]);
        if (Auth::user()->check_administrator) {
            $newProyek->nilai_valas_review = (int) str_replace('.', '', $dataProyek["nilai-valas-review"]);
            $newProyek->mata_uang_review = $dataProyek["mata-uang-review"];
            $newProyek->kurs_review = $dataProyek["kurs-review"];
            $newProyek->bulan_review = $dataProyek["bulan-pelaksanaan-review"];
            $newProyek->nilaiok_review = (int) str_replace('.', '', $dataProyek["nilaiok-review"]);
        }
        // $newProyek->nilai_valas_awal = $dataProyek["nilai-rkap"];
        $newProyek->mata_uang_awal = $dataProyek["mata-uang-awal"];
        $newProyek->kurs_awal = $dataProyek["kurs-awal"] ?? 1;
        $newProyek->bulan_awal = $dataProyek["bulan-pelaksanaan"];
        // $newProyek->nilaiok_awal = (int) str_replace('.', '', $dataProyek["nilaiok-awal"]);
        $newProyek->status_pasdin  = $dataProyek["status-pasardini"];
        $newProyek->info_asal_proyek  = $dataProyek["info-proyek"];
        $newProyek->laporan_kualitatif_pasdin = $dataProyek["laporan-kualitatif-pasdin"];
        $newProyek->klasifikasi_pasdin = $dataProyek["ra-klasifikasi-proyek"];
        $newProyek->negara = $dataProyek["negara"];
        $newProyek->provinsi = $dataProyek["provinsi"];
        // if ($dataProyek["tipe-proyek"] == "P" && $newProyek->stage > 2) {
        //     if (!empty($dataProyek["klasifikasi-kbli-sbu"]) || !empty($dataProyek["sub-klasifikasi-kbli"])) {
        //         $newProyek->klasifikasi_sbu_kbli = $dataProyek["klasifikasi-kbli-sbu"];
        //         $newProyek->kode_kbli_2020 = $dataProyek["sub-klasifikasi-kbli"];
        //     } else {
        //         Alert::error("SBU KBLI dan Sub Klasifikasi SBU KBLI Belum Diisi", "Mohon isi terlebih dahulu");
        //         return redirect()->back();
        //     }
        // }
        // if ($newProyek->jenis_proyek == "J") {
        //     $newProyek->jenis_jo = $dataProyek["jo-category"];
        // } else {
        //     $newProyek->jenis_jo = null;
        // }        //Begin :: Nota Rekomendasi 1
        if (isset($dataProyek["proyek-rekomendasi"]) && isset($dataProyek["confirm-send-wa"]) && isset($dataProyek["ra-klasifikasi-proyek"])&& isset($dataProyek["sumber-dana"]) ) {
            if (!isset($dataProyek['selected-kam']) || empty($dataProyek['selected-kam'])) {
                Alert::error('KAM Tidak Ditemukan', 'Mohon pilih KAM yang sesuai');
                return redirect()->back();
            }
            $divisi = $newProyek->UnitKerja->Divisi->id_divisi;
            $departemen = $newProyek->departemen_proyek;
            // dump($divisi);
            $klasifikasi_proyek = $newProyek->klasifikasi_pasdin;
            $isnomorTargetActive = env('IS_SEND_EMAIL');
            // $matriks_approval = MatriksApprovalRekomendasi::where("unit_kerja", "=", $divisi)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("departemen", $departemen)->where("kategori", "=", "Pengajuan")->get();
            // // dd($matriks_approval);
            // // $nomorDefault = "6285376444701";
            // $nomorDefault = "085881028391";
            // foreach ($matriks_approval as $key => $user) {
            //     // dd($user->Pegawai->nama_pegawai);
            //     $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$newProyek->kode_proyek";
            //     // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            //     //     "api_key" => "p2QeApVsAUxG2fOJ2tX48BoipwuqZK",
            //     //     // "sender" => "6281188827008",
            //     //     "sender" => env("NO_WHATSAPP_BLAST"),
            //     //     "number" => $isnomorTargetActive ? $user->Pegawai->handphone : $nomorDefault,
            //     //     // "number" => "085881028391",
            //     //     "message" => "Yth Bapak/Ibu *" . $user->Pegawai->nama_pegawai . "*\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, *" . $newProyek->ProyekBerjalan->name_customer . "* untuk Proyek *$newProyek->nama_proyek*.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻",
            //     //     // "url" => $url
            //     // ]);
            //     // $send_msg_to_wa->onError(function ($error) {
            //     //     // dd($error);
            //     //     Alert::error('Error', "Terjadi Gangguan, Chat Whatsapp Tidak Terkirim Coba Beberapa Saat Lagi !");
            //     //     return redirect()->back();
            //     // });
            //     $message = nl2br("Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, " . $newProyek->ProyekBerjalan->name_customer . " untuk Proyek $newProyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            //     $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Pengajuan Nota Rekomendasi I", $message, $isnomorTargetActive);
            //     if (!$sendEmailUser) {
            //         return redirect()->back();
            //     }
            // }
            $pegawaiKAM = MatriksApprovalRekomendasi::where('nama_pegawai', $dataProyek["selected-kam"])->first()->Pegawai;
            $url = $request->schemeAndHttpHost() . "?nip=" . $pegawaiKAM->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_proyek_$newProyek->kode_proyek";
            $message = nl2br("Yth Bapak/Ibu " . $pegawaiKAM->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi I, " . $newProyek->ProyekBerjalan->name_customer . " untuk Proyek $newProyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻");
            $sendEmailUser = sendNotifEmail($pegawaiKAM, "Permohonan Tanda Tangan Pengajuan Nota Rekomendasi I", $message, $isnomorTargetActive);
            if (!$sendEmailUser) {
                return redirect()->back();
            }

            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            //     "api_key" => "c15978155a6b4656c4c0276c5adbb5917eb033d5",
            //     "sender" => "62811881227",
            //     "number" => "081319736111",
            //     "message" => "$newProyek->nama_proyek mengajukan rekomendasi.\nSilahkan tekan link di bawah ini untuk menyetujui atau tidak.\n\n$url",
            //     // "url" => $url
            // ]);
            // $send_msg_to_wa = Http::post("https://wa-api.wika.co.id/send-message", [
            //     "api_key" => "c15978155a6b4656c4c0276c5adbb5917eb033d5",
            //     "sender" => "62811881227",
            //     "number" => "082125416666",
            //     "message" => "$newProyek->nama_proyek mengajukan rekomendasi.\nSilahkan tekan link di bawah ini untuk menyetujui atau tidak.\n\n$url",
            //     // "url" => $url
            // ]);
            // dd($send_msg_to_wa, "send");
            $request_pengajuan = collect([
                "user_id" => $pegawaiKAM->User->id,
                "status" => "request",
                "tanggal" => \Carbon\Carbon::now(),
            ]);

            $newNotaRekomendasi = new NotaRekomendasi();
            $newNotaRekomendasi->kode_proyek = $newProyek->kode_proyek;
            $newNotaRekomendasi->unit_kerja = $newProyek->unit_kerja;
            $newNotaRekomendasi->divisi_id = $divisi;
            $newNotaRekomendasi->departemen_code = $departemen;
            $newNotaRekomendasi->klasifikasi_pasdin = $newProyek->klasifikasi_pasdin;
            $newNotaRekomendasi->is_request_rekomendasi = true;
            $newNotaRekomendasi->request_pengajuan = $request_pengajuan->toJson();

            if (!$newNotaRekomendasi->save()) {
                Alert::error('Error', "Proyek Gagal Diajukan");
                return redirect()->back();
            }
            
            $newProyek->is_request_rekomendasi  = true;

            Alert::success('Success', "Proyek Berhasil Diajukan");
        }
        //End :: Nota Rekomendasi 1

        //Begin :: Nota Rekomendasi 2
        if (isset($dataProyek["proyek-rekomendasi-2"]) && isset($dataProyek["confirm-send-wa-2"]) && isset($dataProyek["jenis-terkontrak-new"]) && isset($dataProyek["sistem-bayar-new"])) {
            $divisi = $newProyek->UnitKerja->Divisi->id_divisi;
            $departemen = $newProyek->departemen_proyek;
            $klasifikasi_proyek = $newProyek->klasifikasi_pasdin;
            $matriks_paparan = MatriksApprovalNotaRekomendasi2::where("divisi_id", "=", $divisi)->where("klasifikasi_proyek", "=", $klasifikasi_proyek)->where("departemen_code", $departemen)->where("kategori", "=", "Pengajuan")->where('is_active', true)->get();
            // dd($matriks_paparan);

            $isnomorTargetActive = env("IS_SEND_EMAIL");
            // $nomorDefault = "6285376444701";
            // $nomorDefault = "085881028391";

            if ($matriks_paparan->isEmpty()) {
                Alert::error('Error', 'Matriks untuk paparan tidak ditemukan. Hubungi Admin!');
                return redirect()->back();
            }

            foreach ($matriks_paparan as $user) {
                $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_pengajuan_$newProyek->kode_proyek";
                $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan pengajuan untuk Nota Rekomendasi II, " . $newProyek->ProyekBerjalan->name_customer . " untuk Proyek $newProyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
                $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Pengajuan Nota Rekomendasi II", nl2br($message), $isnomorTargetActive);
                if (!$sendEmailUser) {
                    return redirect()->back();
                }
            }

            // if ($matriks_paparan->contains('is_ktt', true)) {
            //     $user = TimTender::where('kode_proyek', $dataProyek["kode-proyek"])?->where('posisi', 'Ketua')->first();
            //     if (empty($user)) {
            //         Alert::error('Ketua Tim Tender Belum Ditentukan', "Mohon untuk mengisi data tim tender terlebih dahulu!");
            //         return redirect()->back();
            //     }
            //     $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/nota-rekomendasi-2?open=kt_modal_view_pengajuan_$newProyek->kode_proyek";
            //     $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi II, " . $newProyek->ProyekBerjalan->name_customer . " untuk Proyek $newProyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
            //     $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Pengajuan Nota Rekomendasi II", nl2br($message), $isnomorTargetActive);
            //     if (!$sendEmailUser) {
            //         return redirect()->back();
            //     }
            // } else {
            //     foreach ($matriks_paparan as $key => $user) {
            //         $url = $request->schemeAndHttpHost() . "?nip=" . $user->Pegawai->nip . "&redirectTo=/rekomendasi?open=kt_modal_view_pengajuan_$newProyek->kode_proyek";
            //         $message = "Yth Bapak/Ibu " . $user->Pegawai->nama_pegawai . "\nDengan ini menyampaikan permohonan tandatangan untuk form pengajuan Nota Rekomendasi II, " . $newProyek->ProyekBerjalan->name_customer . " untuk Proyek $newProyek->nama_proyek.\nSilahkan tekan link di bawah ini untuk proses selanjutnya.\n\n$url\n\nTerimakasih 🙏🏻";
            //         $sendEmailUser = sendNotifEmail($user->Pegawai, "Permohonan Tanda Tangan Pengajuan Nota Rekomendasi II", nl2br($message), $isnomorTargetActive);
            //         if (!$sendEmailUser) {
            //             return redirect()->back();
            //         }
            //     }
            // }

            // dd($newProyek);

            $newProyek->is_request_rekomendasi_2  = true;

            $newNotaRekomendasi2 = new NotaRekomendasi2();
            $newNotaRekomendasi2->kode_proyek = $dataProyek['kode-proyek'];
            $newNotaRekomendasi2->unit_kerja = $newProyek->unit_kerja;
            $newNotaRekomendasi2->klasifikasi_proyek = $newProyek->klasifikasi_proyek_nota_2;
            $newNotaRekomendasi2->divisi_id = $newProyek->UnitKerja->Divisi->id_divisi;
            $newNotaRekomendasi2->departemen_proyek = $newProyek->departemen_proyek;
            $newNotaRekomendasi2->is_request_rekomendasi = true;

            if ($newNotaRekomendasi2->save()) {
                Alert::success('Success', "Proyek Berhasil Diajukan");
            } else {
                Alert::error('Error', "Proyek Gagal Diajukan");
            }
        }
        //End :: Nota Rekomendasi 2



        // $newProyek->nama_pendek_proyek = $dataProyek["short-name"];
        // dd($dataProyek['negara']);
        // form PASAR POTENSIAL
        $newProyek->sbu = $dataProyek["sbu"];
        $newProyek->klasifikasi = $dataProyek["klasifikasi"];
        $newProyek->status_pasar = $dataProyek["status-pasar"];
        $newProyek->sub_klasifikasi = $dataProyek["sub-klasifikasi"];
        $newProyek->proyek_strategis = $request->has("proyek-strategis");
        $newProyek->klasifikasi_sbu_kbli = $dataProyek["klasifikasi-kbli"];
        $newProyek->kode_kbli_2020 = $dataProyek["sub-klasifikasi-kbli"];
        // $newProyek->dop = $dataProyek["dop"];
        // $newProyek->company = $dataProyek["company"];
        $newProyek->laporan_kualitatif_paspot = $dataProyek["laporan-kualitatif-paspot"];

        // form PASAR PRAKUALIFIKASI
        $newProyek->jadwal_pq = $dataProyek["jadwal-pq"];
        // $newProyek->jadwal_proyek = $dataProyek["jadwal-proyek"];
        $newProyek->hps_pagu = (int) str_replace('.', '', $dataProyek["hps-pagu"]);
        $newProyek->porsi_jo = $dataProyek["porsi-jo"];
        $newProyek->ketua_tender = $dataProyek["ketua-tender"];
        $newProyek->lingkup_pekerjaan = $dataProyek["lingkup-pekerjaan"];

        $isExistPorsiJO = PorsiJO::where('kode_proyek', $dataProyek["kode-proyek"])->get();
        if (!empty($isExistPorsiJO)) {
            $isExistPorsiJO->each(function ($porsi) {
                $kriteria_partner = MasterGrupTierBUMN::where('id_pelanggan', $porsi->id_company_jo)->first();
                if (!empty($kriteria_partner)) {
                    $porsi->is_greenlane = true;
                    $porsi->is_disetujui = true;
                } else {
                    $porsi->is_greenlane = false;
                }
                if (!$porsi->is_greenlane) {
                    if (empty($porsi->score_pefindo_jo)) {
                        $checkPefindo = MasterPefindo::where('id_pelanggan', $porsi->id_company_jo)->first();
                        if (!empty($checkPefindo)) {
                            $porsi->score_pefindo_jo = $checkPefindo->score;
                            $porsi->file_pefindo_jo = $checkPefindo->id_document;
                            $porsi->grade = $checkPefindo->grade;
                            $porsi->keterangan = $checkPefindo->keterangan;

                            if (str_contains($checkPefindo->grade, 'E')) {
                                $porsi->is_disetujui = false;
                            } else {
                                $porsi->is_disetujui = true;
                            }
                        }
                    }
                }
                $porsi->save();
            });
        }

        if (!empty($dataProyek["hps-pagu"]) && !empty($dataProyek["waktu_pelaksanaan"])) {

            $urutanKlasifikasi = collect(["Proyek Kecil", "Proyek Menengah", "Proyek Besar", "Proyek Mega"]);
            $urutanKlasifikasiOmzet = null;
            $urutanKlasifikasiProduksi = null;
            $klasifikasiNotaRekomendasi2 = null;

            $nilaiOmzetProyek = (int)str_replace('.', '', $dataProyek["nilai-rkap"]) * ((int)$dataProyek["porsi-jo"] / 100);
            $waktuPelaksanaanConvertBulan = (int)$dataProyek["waktu_pelaksanaan"] / 30; //Hari dijadikan bulan
            $nilaiProduksiPerbulan = $nilaiOmzetProyek / $waktuPelaksanaanConvertBulan;

            //Jika Pakai Omset Saja
            $klasifikasiOmzetSelected = MasterKlasifikasiOmsetProyek::all()?->filter(function ($item) use ($nilaiOmzetProyek) {
                return (float)$item->dari_nilai <= (int)$nilaiOmzetProyek && (float)$item->sampai_nilai >= (int)$nilaiOmzetProyek;
            })->first()?->keterangan;

            if (!empty($klasifikasiOmzetSelected)) {
                $urutanKlasifikasiOmzet = $urutanKlasifikasi->filter(function ($klasifikasi) use ($klasifikasiOmzetSelected) {
                    return $klasifikasi == $klasifikasiOmzetSelected;
                })?->keys()?->first();
            }

            //Jika Pakai Produksi Perbulan
            $klasifikasiProduksiSelected = MasterKlasifikasiProduksiProyek::all()?->filter(function ($item) use ($nilaiProduksiPerbulan) {
                return (float)$item->dari_nilai <= (int)$nilaiProduksiPerbulan && (float)$item->sampai_nilai >= (int)$nilaiProduksiPerbulan;
            })->first()?->keterangan;

            if (!empty($klasifikasiProduksiSelected)) {
                $urutanKlasifikasiProduksi = $urutanKlasifikasi->filter(function ($klasifikasi) use ($klasifikasiProduksiSelected) {
                    return $klasifikasi == $klasifikasiProduksiSelected;
                })?->keys()?->first();
            }

            // dd($dataProyek);

            if (!empty($urutanKlasifikasiOmzet) && !empty($urutanKlasifikasiProduksi)) {
                if ($urutanKlasifikasiProduksi < $urutanKlasifikasiOmzet) {
                    $klasifikasiNotaRekomendasi2 = $klasifikasiProduksiSelected;
                } else {
                    $klasifikasiNotaRekomendasi2 = $klasifikasiOmzetSelected;
                }
            } elseif (!empty($urutanKlasifikasiOmzet)) {
                $klasifikasiNotaRekomendasi2 = $klasifikasiOmzetSelected;
            } elseif (!empty($urutanKlasifikasiOmzet)) {
                $klasifikasiNotaRekomendasi2 = $klasifikasiProduksiSelected;
            } else {
                Alert::error('Error', "Terjadi kesalahan. Hubungi Admin!");
                return redirect()->back();
            }

            $newProyek->klasifikasi_proyek_nota_2 = $klasifikasiNotaRekomendasi2;
            $newProyek->nilai_klasifikasi_nota_2 = $nilaiOmzetProyek;

        }

        $newProyek->keterangan_greenlane = $dataProyek["keterangan-greenlane"];
        // $newProyek->score_pefindo = $dataProyek["score-pefindo"];
        // foreach($allProyek as $proyek) {
        //     if($proyek->ketua_tender == $dataProyek["ketua-tender"] && !($proyek->stage > 8)) {
        //         return redirect()->back()->with("failed", "Ketua Tender sudah terdaftar di proyek lain");
        //     }
        // }
        $newProyek->ketua_tender = $dataProyek["ketua-tender"];
        $newProyek->laporan_prakualifikasi = $dataProyek["laporan-prakualifikasi"];

        // form TENDER DIIKUTI
        $newProyek->jadwal_tender = $dataProyek["jadwal-tender"];
        $newProyek->lokasi_tender = $dataProyek["lokasi-tender"];
        $newProyek->penawaran_tender = (int) str_replace('.', '', $dataProyek["nilai-kontrak-penawaran"]);
        // $newProyek->nilai_kontrak_keseluruhan = $dataProyek["nilai-kontrak-penawaran"];
        // $newProyek->hps_tender = $dataProyek["hps-tender"];
        $newProyek->laporan_tender = $dataProyek["laporan-tender"];

        // form PEROLEHAN
        // $newProyek->biaya_praproyek = $dataProyek["biaya-praproyek"];
        $newProyek->nilai_perolehan = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
        // $newProyek->hps_perolehan = $dataProyek["hps-perolehan"];
        $oe_wika = 0;
        if (!empty($dataProyek["nilai-kontrak-penawaran"]) && !empty($dataProyek["hps-pagu"])) {
            $oe_wika = ((int) $dataProyek["nilai-kontrak-penawaran"] / (int) $dataProyek["hps-pagu"]) * 100;
            $newProyek->oe_wika = number_format($oe_wika, 2, '.', '.');
        };
        $newProyek->peringkat_wika = $dataProyek["peringkat-wika"];
        $newProyek->laporan_perolehan = $dataProyek["laporan-perolehan"];

        // form MENANG
        $newProyek->aspek_pesaing = $dataProyek["aspek-pesaing"];
        $newProyek->aspek_non_pesaing = $dataProyek["aspek-non-pesaing"];
        $newProyek->saran_perbaikan = $dataProyek["saran-perbaikan"];
        $newProyek->laporan_menang = $dataProyek["laporan-menang"];

        // form KALAH
        $newProyek->kategori_kalah = $dataProyek["kategori-kalah"] ?? null;


        // form TERKONTRAK
        // $newProyek->jenis_proyek_terkontrak = $dataProyek["jenis-proyek-terkontrak"];
        $newProyek->nospk_external = $dataProyek["nospk-external"];
        // $newProyek->porsijo_terkontrak = $dataProyek["porsijo-terkontrak"];
        $newProyek->tglspk_internal = $dataProyek["tglspk-internal"];
        // $newProyek->nilaiok_terkontrak = $dataProyek["nilaiok-terkontrak"];
        $newProyek->tahun_ri_perolehan = $dataProyek["tahun-ri-perolehan"];
        // $newProyek->matauang_terkontrak = $dataProyek["matauang-terkontrak"];
        $newProyek->bulan_ri_perolehan = $dataProyek["bulan-ri-perolehan"];
        // dd($dataProyek);

        $newForecast = Forecast::where("kode_proyek", "=", $newProyek->kode_proyek)->where("periode_prognosa", "=", $bulans)->where("tahun", "=", $years)->first();
        // if (empty($newForecast)) {
        //     $newForecast = new Forecast();
        //     $newForecast->kode_proyek = $newProyek->kode_proyek;
        //     $newForecast->rkap_forecast = $newProyek->nilai_rkap;
        //     $newForecast->month_rkap = $newProyek->bulan_pelaksanaan;
        //     $newForecast->periode_prognosa = $bulans;
        //     $newForecast->tahun = $years;
        //     $newForecast->save();
        //     // if (isset($newProyek->bulan_ri_perolehan) && isset($newProyek->nilai_perolehan) && $newProyek->stage > 7 ) {
        //     //     $newForecast->month_realisasi = $newProyek->bulan_ri_perolehan;
        //     //     // dump($newForecast, "bulan ri");
        //     //     // dd($newProyek);
        //     //     $newForecast->save();
        //     // };
        //     // if (isset($newProyek->bulan_pelaksanaan) && isset($newProyek->nilai_rkap) ) {
        //     //     $newForecast->rkap_forecast = $newProyek->nilai_rkap;
        //     //     $newForecast->month_rkap = $newProyek->bulan_pelaksanaan;
        //     //     // dd($newForecast, "bulan rkap");
        //     //     $newForecast->save();
        //     // };
        // }
        // $newProyek->kursreview_terkontrak = $dataProyek["kurs-review-terkontrak"];
        $newProyek->nomor_terkontrak = $dataProyek["nomor-terkontrak"];
        // $newProyek->nomor_terkontrak = urlencode(urlencode($dataProyek["nomor-terkontrak"]));
        $newProyek->tanggal_terkontrak = $dataProyek["tanggal-terkontrak"];
        // if ($dataProyek["nilai-perolehan"] != null && $dataProyek["porsi-jo"] != null && $newProyek->stage == 8 || $newProyek->stage == 9) {
        //     // dd($newProyek->stage);
        //     $nilaiPerolehan = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
        //     $kontrakKeseluruhan = ($nilaiPerolehan * 100) / $dataProyek["porsi-jo"];
        //     $nilaiKontrakKeseluruhan = $kontrakKeseluruhan;

        //     $newProyek->nilai_kontrak_keseluruhan = $nilaiKontrakKeseluruhan;
        // }
        $newProyek->nilai_kontrak_keseluruhan = str_replace('.', '', $dataProyek["nilai-kontrak-keseluruhan"]);
        $newProyek->tanggal_mulai_terkontrak = $dataProyek["tanggal-mulai-kontrak"];
        // $newProyek->nilai_wika_terkontrak = $dataProyek["nilai-wika-terkontrak"];
        $newProyek->tanggal_akhir_terkontrak = $dataProyek["tanggal-akhir-kontrak"];
        $newProyek->klasifikasi_terkontrak = $dataProyek["klasifikasi-terkontrak"];
        $newProyek->tanggal_selesai_pho = $dataProyek["tanggal-selesai-kontrak-pho"];
        $newProyek->tanggal_selesai_fho = $dataProyek["tanggal-selesai-kontrak-fho"];
        // dd($dataProyek);
        $newProyek->jenis_terkontrak = $dataProyek["jenis-terkontrak-new"];
        $newProyek->sistem_bayar = $dataProyek["sistem-bayar-new"];

        if (!empty($dataProyek["is-uang-muka"])) {
            if ($dataProyek["is-uang-muka"] == "Ya") {
                $newProyek->is_uang_muka = true;
                $newProyek->uang_muka = (int)$dataProyek["uang-muka"];
            } else {
                $newProyek->is_uang_muka = false;
            }
        }
        // $newProyek->nilai_sisa_risiko = $dataProyek["nilai-sisa-risiko"];
        // $newProyek->cadangan_risiko = $dataProyek["cadangan-risiko"];
        // $newProyek->nilai_disetujui = $dataProyek["nilai-disetujui"];
        $newProyek->pekerjaan_utama = $dataProyek["pekerjaan-utama"];
        $newProyek->laporan_terkontrak = $dataProyek["laporan-terkontrak"];
        // form table performance
        $newProyek->piutang = str_replace('.', '', $dataProyek["piutang-performance"]);
        $newProyek->laba = str_replace('.', '', $dataProyek["laba-performance"]);
        $newProyek->rugi = str_replace('.', '', $dataProyek["rugi-performance"]);
        $newProyek->latitude = $dataProyek["latitude"];
        $newProyek->longitude = $dataProyek["longitude"];
        // $newProyek->kode_kbli_2020 = $dataProyek["klasifikasi-kbli-sbu"];

        //Begin::Waktu Pelaksanaan
        $newProyek->waktu_pelaksanaan = $dataProyek["waktu_pelaksanaan"];
        //End::Waktu Pelaksanaan

        $idCustomer = $dataProyek["customer"];

        // Form update Customer dan auto Proyek Berjalan
        // $newProyek->customer= $dataProyek["customer"];
        // $newProyek->waktu_pemasukan_tender = $dataProyek["waktu-pemasukkan-tender"];
        $newProyek->waktu_jaminan_penawaran = $dataProyek["waktu-jaminan-penawaran"];
        // $newProyek->waktu_prakualifikasi = $dataProyek["waktu-prakualifikasi"];

        //Begin::Alasan KSO
        if (Auth::user()->check_administrator || Gate::any(['user-crm', 'approver-crm'])) {
            $alasan_kso = collect([]);
            if (isset($dataProyek["checklist-alasan-kso-1"])) {
                $alasan_kso->push([
                    "index" => 1,
                    "value" => $dataProyek["checklist-alasan-kso-1"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-alasan-kso-2"])) {
                $alasan_kso->push([
                    "index" => 2,
                    "value" => $dataProyek["checklist-alasan-kso-2"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-alasan-kso-3"])) {
                $alasan_kso->push([
                    "index" => 3,
                    "value" => $dataProyek["checklist-alasan-kso-3"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-alasan-kso-4"])) {
                $alasan_kso->push([
                    "index" => 4,
                    "value" => $dataProyek["checklist-alasan-kso-4"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-alasan-kso-5"])) {
                $alasan_kso->push([
                    "index" => 5,
                    "value" => $dataProyek["checklist-alasan-kso-5"],
                    "keterangan" => $dataProyek["alasan-kso-text"] ?? null
                ]);
            }

            // dd($alasan_kso);
            $newProyek->alasan_kso = $alasan_kso->toArray() ?? null;
        }
        //End::Alasan KSO

        //Begin::Tujuan KSO
        if (Auth::user()->check_administrator || Gate::any(['user-crm', 'approver-crm'])) {
            $tujuan_kso = collect([]);
            if (isset($dataProyek["checklist-tujuan-kso-1"])) {
                $tujuan_kso->push([
                    "index" => 1,
                    "value" => $dataProyek["checklist-tujuan-kso-1"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-tujuan-kso-2"])) {
                $tujuan_kso->push([
                    "index" => 2,
                    "value" => $dataProyek["checklist-tujuan-kso-2"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-tujuan-kso-3"])) {
                $tujuan_kso->push([
                    "index" => 3,
                    "value" => $dataProyek["checklist-tujuan-kso-3"],
                    "keterangan" => null
                ]);
            }
            if (isset($dataProyek["checklist-tujuan-kso-4"])) {
                $tujuan_kso->push([
                    "index" => 4,
                    "value" => $dataProyek["checklist-tujuan-kso-4"],
                    "keterangan" => $dataProyek["tujuan-kso-text"] ?? null
                ]);
            }

            // dd($tujuan_kso);
            $newProyek->tujuan_kso = $tujuan_kso->toArray() ?? null;
        }
        //End::Tujuan KSO

        //Begin::Persetujuan Fasilitan NCL
        if (Auth::user()->check_administrator || Gate::any(['user-crm', 'approver-crm'])) {
            $newProyek->fasilitas_ncl = $dataProyek["fasilitas-ncl"] ?? null;
        }
        //End::Persetujuan Fasilitan NCL

        // dd(isset($dataProyek["jenis-proyek"]));

        $kode_proyek = $newProyek->kode_proyek;

        // Begin :: EDIT KODE PROYEK
        // if ((isset($dataProyek["jenis-proyek"]) && $newProyek->jenis_proyek != $dataProyek["jenis-proyek"]) || (isset($dataProyek["tipe-proyek"]) && $newProyek->tipe_proyek != $dataProyek["tipe-proyek"]) || (isset($dataProyek["tahun-perolehan"]) && $newProyek->tahun_perolehan != $dataProyek["tahun-perolehan"])) {
        //     // dd($dataProyek);
        //     //begin::Generate Kode Proyek
        //     $kode_proyek = str_split($dataProyek["edit-kode-proyek"]);
        //     // $unit_kerja = $dataProyek["unit-kerja"];
        //     $kode_proyek[1] = $dataProyek["jenis-proyek"];
        //     $newProyek->jenis_proyek = $dataProyek["jenis-proyek"];

        //     $kode_proyek[2] = $dataProyek["tipe-proyek"];
        //     $newProyek->tipe_proyek = $dataProyek["tipe-proyek"];

        //     $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        //     $tahun = $dataProyek["tahun-perolehan"];
        //     $kode_tahun = $tahun == 2021 ? "A" : "O";
        //     $kode_proyek[3] = $kode_tahun;

        //     // Menggabungkan semua kode beserta nomor urut
        //     $kode_proyek = $kode_proyek[0] . $kode_proyek[1] . $kode_proyek[2] . $kode_proyek[3] . $kode_proyek[4] . $kode_proyek[5] . $kode_proyek[6];
        //     $newProyek->kode_proyek = $kode_proyek;

        //     Alert::success('Success', "Kode Proyek Berhasil Diubah : " . $kode_proyek);

        //     //end::Generate Kode Proyek
        // } else {
        //     Alert::toast("Edit Berhasil" , "success")->autoClose(3000);
        // }
        // Begin :: EDIT KODE PROYEK

        Alert::toast("Edit Berhasil", "success")->autoClose(3000);

        // if (isset($kode_proyek) && isset($dataProyek["nilai-perolehan"]) && isset($dataProyek["nospk-external"]) && isset($dataProyek["nomor-terkontrak"]) && isset($dataProyek["tanggal-mulai-kontrak"]) && isset($dataProyek["tanggal-akhir-kontrak"])) {
        // $contractManagements = ContractManagements::get()->where("project_id", "=", $kode_proyek)->first();
        // $isExistcontractManagements = ContractManagements::where(function ($query) use ($newProyek) {
        //     return $query->where("project_id", $newProyek->kode_proyek)->orWhere("profit_center", $newProyek->profit_center);
        // })->get();
        $isExistcontractManagements = ContractManagements::when(!empty($newProyek->profit_center), function ($query) use ($newProyek) {
            return $query->where("profit_center", $newProyek->profit_center);
        })->orWhere(function ($item) use ($newProyek) {
            $item->where("project_id", $newProyek->kode_proyek);
        })->first();

        if (empty($isExistcontractManagements)) {
            $uuid = new Uuid();
            $contractManagements = new ContractManagements();
            $contractManagements->project_id = $kode_proyek;
            // $contractManagements->id_contract = urlencode(urlencode($dataProyek["nomor-terkontrak"]));
            $contractManagements->id_contract = $uuid->uuid3();
            $contractManagements->no_contract = $dataProyek["nomor-terkontrak"];
            $contractManagements->contract_in = $dataProyek["tanggal-mulai-kontrak"];
            $contractManagements->contract_out = $dataProyek["tanggal-akhir-kontrak"];
            $contractManagements->number_spk = $dataProyek["nospk-external"];
            $contractManagements->contract_proceed = "Belum Selesai";
            $contractManagements->profit_center = $newProyek->profit_center;
            $contractManagements->value = preg_replace("/[^0-9]/i", "", $dataProyek["nilai-perolehan"]);
            if ($newProyek->stage == 8) {
                $contractManagements->stages = (int) 2;
            } else {
                $contractManagements->stages = (int) 1;
            }
            $contractManagements->value_review = 0;
            $contractManagements->profit_center = (strlen($newProyek->kode_proyek) > 8 || strlen($newProyek->kode_proyek) < 12) && empty($newProyek->profit_center) ? $newProyek->kode_proyek : (!empty($newProyek->profit_center) ? $newProyek->profit_center : null);
            $contractManagements->save();
        } else {
            $isExistcontractManagements->project_id = $kode_proyek;
            $isExistcontractManagements->no_contract = $newProyek->nomor_terkontrak;
            $isExistcontractManagements->contract_in = $dataProyek["tanggal-mulai-kontrak"];
            $isExistcontractManagements->contract_out = $dataProyek["tanggal-akhir-kontrak"];
            $isExistcontractManagements->number_spk = $dataProyek["nospk-external"];
            $isExistcontractManagements->contract_proceed = "Belum Selesai";
            $isExistcontractManagements->profit_center = $newProyek->profit_center;
            $isExistcontractManagements->value = preg_replace("/[^0-9]/i", "", $dataProyek["nilai-perolehan"]);
            if ($newProyek->stage == 8) {
                $isExistcontractManagements->stages = (int) 2;
            } else {
                $isExistcontractManagements->stages = (int) 1;
            }
            $isExistcontractManagements->value_review = 0;
            $isExistcontractManagements->profit_center = (strlen($newProyek->kode_proyek) > 8 || strlen($newProyek->kode_proyek) < 12) && empty($newProyek->profit_center) ? $newProyek->kode_proyek : (!empty($newProyek->profit_center) ? $newProyek->profit_center : null);
            $isExistcontractManagements->save();
        }
        // }

        // dd($dataProyek);
        // if ($dataProyek["nilai-perolehan"] != null && $newProyek->stage == 8 && $dataProyek["bulan-ri-perolehan"] != null){
            // if (!empty($newProyek->bulan_ri_perolehan) && !empty($newProyek->nilai_perolehan) && $newProyek->stage == 8 && $newProyek->tahun_perolehan == $years) {
            //     $editForecast = Forecast::where("kode_proyek", "=", $newProyek->kode_proyek)->where("periode_prognosa", "=", $bulans)->where("tahun", "=", $years)->first();
            //     if (!empty($editForecast)) {
            //         $oldestForecast = Forecast::where("kode_proyek", "=", $newProyek->kode_proyek)->where("periode_prognosa", "=", ($bulans - 1))->where("tahun", "=", $years)->first();
            //         if (!empty($oldestForecast) && (int) date("d") <= 15) {
            //             // $oldestForecast = new Forecast();
            //             $oldestForecast->kode_proyek = $newProyek->kode_proyek;
            //             $oldestForecast->periode_prognosa = $bulans - 1;
            //             $oldestForecast->tahun = $years;
            //             $oldestForecast->nilai_forecast = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
            //             $oldestForecast->realisasi_forecast = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
            //             $oldestForecast->month_realisasi = (int) $newProyek->bulan_ri_perolehan;
            //             $oldestForecast->save();
            //         }
            //         // $editForecast->month_forecast = $dataProyek["month-forecast"];
            //         $editForecast->nilai_forecast = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
            //         $editForecast->realisasi_forecast = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
            //         $editForecast->month_realisasi = (int) $newProyek->bulan_ri_perolehan;
            //         // $editForecast->tahun = $years;
            //         $editForecast->save();
            //     } else {
            //         $newForecast = new Forecast();
            //         $newForecast->kode_proyek = $newProyek->kode_proyek;
            //         // $newForecast->month_forecast = $dataProyek["month-forecast"];
            //         // $newForecast->nilai_forecast = (int) str_replace('.', '', $dataProyek["nilai-forecast"]);
            //         $newForecast->month_forecast = $dataProyek["bulan-ri-perolehan"];
            //         $newForecast->nilai_forecast = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
            //         $newForecast->month_realisasi = $dataProyek["bulan-ri-perolehan"];
            //         $newForecast->realisasi_forecast = (int) str_replace('.', '', $dataProyek["nilai-perolehan"]);
            //         $newForecast->periode_prognosa = $bulans;
            //         $newForecast->tahun = (int) date("Y");
            //         $newForecast->save();
            //     }
            // }

        if ($idCustomer != null) {
            // $customer = Customer::where('name', "=", $dataProyek["customer"])->get()->first();
            // $customer = Customer::find($idCustomer);

            $customerHistory = ProyekBerjalans::where('kode_proyek', "=", $newProyek->kode_proyek)->get()->first();

            if ($customerHistory == null) {

                $customerHistory = new ProyekBerjalans();
                $customerHistory->id_customer = $idCustomer;
                $nameCustomer = Customer::find($idCustomer);
                $customerHistory->name_customer = $nameCustomer->name;
                $customerHistory->nama_proyek = $newProyek->nama_proyek;
                $customerHistory->kode_proyek = $newProyek->kode_proyek;
                $customerHistory->pic_proyek = $newProyek->ketua_tender;
                $customerHistory->unit_kerja = $newProyek->unit_kerja;
                $customerHistory->jenis_proyek = $newProyek->jenis_proyek;
                $customerHistory->nilaiok_proyek = $newProyek->nilai_rkap;
                $customerHistory->stage = $newProyek->stage;
            } else {
                $customerHistory->id_customer = $idCustomer;
                $nameCustomer = Customer::find($idCustomer);
                $customerHistory->name_customer = $nameCustomer->name;
            }

            if ($newProyek->save()) {
                if (isset($dataProyek["dokumen-penentuan-kso"])) {
                    self::uploadDokumenPenentuanKSO($dataProyek["dokumen-penentuan-kso"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-penentuan-project-greenlane"])) {
                    self::uploadDokumenPenentuanProjectGreenlane($dataProyek["dokumen-penentuan-project-greenlane"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-pendukung-pasar-dini"])) {
                    self::uploadDokumenPendukungPasdin($dataProyek["dokumen-pendukung-pasar-dini"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-nota-rekomendasi-1"])) {
                    self::uploadDokumenNotaRekomendasi1($dataProyek["dokumen-nota-rekomendasi-1"], $kode_proyek);
                }
                // if (isset($dataProyek["dokumen-consent-npwp"])) {
                //     self::uploadDokumenConsentNPWP($dataProyek["dokumen-consent-npwp"], $kode_proyek);
                // }
                if (isset($dataProyek["dokumen-pefindo"])) {
                    self::uploadDokumenPefindo($dataProyek["dokumen-pefindo"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-prakualifikasi"])) {
                    self::uploadDokumenPrakualifikasi($dataProyek["dokumen-prakualifikasi"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-tender"])) {
                    self::uploadDokumenTender($dataProyek["dokumen-tender"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-nda"])) {
                    self::uploadDokumenNda($dataProyek["dokumen-nda"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-eca"])) {
                    self::uploadDokumenEca($dataProyek["dokumen-eca"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-ica"])) {
                    self::uploadDokumenIca($dataProyek["dokumen-ica"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-rks"])) {
                    self::uploadDokumenRks($dataProyek["dokumen-rks"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-itb-tor"])) {
                    self::uploadDokumenItbTor($dataProyek["dokumen-itb-tor"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-mou"])) {
                    self::uploadDokumenMou($dataProyek["dokumen-mou"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-draft"])) {
                    self::uploadDokumenDraft($dataProyek["dokumen-draft"], $kode_proyek);
                }
                if (isset($dataProyek["risk-tender"])) {
                    self::riskTender($dataProyek["risk-tender"], $kode_proyek);
                }
                if (isset($dataProyek["attachment-menang"])) {
                    self::attachmentMenang($dataProyek["attachment-menang"], $kode_proyek);
                }
                if (isset($dataProyek["file-cashflow"])) {
                    self::cashFlow($dataProyek["file-cashflow"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-scurves"])) {
                    self::uploadDokumenSCurves($dataProyek["dokumen-scurves"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-other-proyek"])) {
                    self::uploadDokumenOtherProyek($dataProyek["dokumen-other-proyek"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-form-persetujuan-kso"])) {
                    self::uploadDokumenPersetujuanKSO($dataProyek["dokumen-form-persetujuan-kso"], $kode_proyek);
                }
            }
            $customerHistory->save();
            return redirect("/proyek/view/" . $kode_proyek);
        } else {
            if ($newProyek->save()) {
                if (isset($dataProyek["dokumen-penentuan-kso"])) {
                    self::uploadDokumenPenentuanKSO($dataProyek["dokumen-penentuan-kso"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-penentuan-project-greenlane"])) {
                    self::uploadDokumenPenentuanProjectGreenlane($dataProyek["dokumen-penentuan-project-greenlane"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-pendukung-pasar-dini"])) {
                    self::uploadDokumenPendukungPasdin($dataProyek["dokumen-pendukung-pasar-dini"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-nota-rekomendasi-1"])) {
                    self::uploadDokumenNotaRekomendasi1($dataProyek["dokumen-nota-rekomendasi-1"], $kode_proyek);
                }

                if (isset($dataProyek["dokumen-pefindo"])) {
                    self::uploadDokumenPefindo($dataProyek["dokumen-pefindo"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-prakualifikasi"])) {
                    self::uploadDokumenPrakualifikasi($dataProyek["dokumen-prakualifikasi"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-nda"])) {
                    self::uploadDokumenNda($dataProyek["dokumen-nda"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-eca"])) {
                    self::uploadDokumenEca($dataProyek["dokumen-eca"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-ica"])) {
                    self::uploadDokumenIca($dataProyek["dokumen-ica"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-rks"])) {
                    self::uploadDokumenRks($dataProyek["dokumen-rks"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-itb-tor"])) {
                    self::uploadDokumenItbTor($dataProyek["dokumen-itb-tor"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-mou"])) {
                    self::uploadDokumenMou($dataProyek["dokumen-mou"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-draft"])) {
                    self::uploadDokumenDraft($dataProyek["dokumen-draft"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-tender"])) {
                    self::uploadDokumenTender($dataProyek["dokumen-tender"], $kode_proyek);
                }
                if (isset($dataProyek["risk-tender"])) {
                    self::riskTender($dataProyek["risk-tender"], $kode_proyek);
                }
                if (isset($dataProyek["attachment-menang"])) {
                    self::attachmentMenang($dataProyek["attachment-menang"], $kode_proyek);
                }
                if (isset($dataProyek["file-cashflow"])) {
                    self::cashFlow($dataProyek["file-cashflow"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-scurves"])) {
                    self::uploadDokumenSCurves($dataProyek["dokumen-scurves"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-other-proyek"])) {
                    self::uploadDokumenOtherProyek($dataProyek["dokumen-other-proyek"], $kode_proyek);
                }
                if (isset($dataProyek["dokumen-form-persetujuan-kso"])) {
                    self::uploadDokumenPersetujuanKSO($dataProyek["dokumen-form-persetujuan-kso"], $kode_proyek);
                }
            }
            return redirect("/proyek/view/" . $kode_proyek);
        }
    }

    private function uploadDokumenPendukungPasdin(UploadedFile $uploadedFile, $kode_proyek)
    {
        if ($uploadedFile->getClientOriginalExtension() != 'pdf') {
            Alert::error("Error", "File Dokumen Pendukung Pasar Dini Wajib PDF");
            return redirect()->back();
        }
        $dokumen = new DokumenPendukungPasdin();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(" ", "-", $file_name);
        $nama_document = $file_name;
        $dokumen->nama_document = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        $uploadedFile->move(public_path('dokumen-pendukung-pasdin'), $id_document);
        $dokumen->save();
    }

    public function deleteDokumenPendukungPasdin($id)
    {
        $delete = DokumenPendukungPasdin::find($id);
        File::delete(public_path(public_path("dokumen-pendukung-pasdin/$delete->id_document")));
        $delete->delete();
        Alert::success("Success", "Dokumen Pendukung Pasdin Berhasil Dihapus");
        return redirect()->back();
    }

    public function updateRetail(Request $request, Proyek $newProyek, ProyekBerjalans $customerHistory)
    {
        $dataProyek = $request->all();
        // dd($dataProyek); //console log hasil $dataProyek
        $newProyek = Proyek::find($dataProyek["kode-proyek"]);

        // dd($newProyek);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
            "numeric" => "*Kolom ini harus numeric!",
        ];
        $rules = [
            "nama-proyek" => "required",
            // "bulan-pelaksanaan" => "required",
            // "nilai-rkap" => "required",
            // "sumber-dana" => "required",
            // "porsi-jo" => "numeric"
        ];
        // if (isset($dataProyek["porsi-jo"])) {
        //     $rules["porsi-jo"] = "numeric";
        // }
        $validation = Validator::make($dataProyek, $rules, $messages);
        if ($validation->fails()) {
            dd($validation);
            Alert::error('Error', "Proyek Gagal Diubah, Periksa Kembali !");
            $request->old("nama-proyek");
            Session::flash('failed', 'Proyek gagal dibuat, Periksa kembali button "NEW" !');
        }

        $validation->validate();

        // form PASAR DINI
        $newProyek->nama_proyek = $dataProyek["nama-proyek"];
        // $newProyek->unit_kerja = $dataProyek["unit-kerja"];
        $newProyek->kode_proyek = $dataProyek["kode-proyek"];
        $newProyek->tahun_perolehan = $dataProyek["tahun-perolehan"];
        $newProyek->sumber_dana = $dataProyek["sumber-dana"];
        $newProyek->jenis_proyek = $dataProyek["jenis-proyek"];
        $newProyek->tipe_proyek = $dataProyek["tipe-proyek"];
        // if ($newProyek->jenis_proyek == "J") {
        //     $newProyek->jenis_jo = $dataProyek["jo-category"];
        // } else {
        //     $newProyek->jenis_jo = null;
        // }

        // $newProyek->pic = $dataProyek["pic"];
        $newProyek->bulan_pelaksanaan = $dataProyek["bulan-pelaksanaan"];
        // $newProyek->nilai_rkap = $dataProyek["nilai-rkap"];
        if (Auth::user()->check_administrator) {
            $newProyek->nilai_valas_review = $dataProyek["nilai-valas-review"];
            $newProyek->mata_uang_review = $dataProyek["mata-uang-review"];
            $newProyek->kurs_review = $dataProyek["kurs-review"];
            $newProyek->bulan_review = $dataProyek["bulan-pelaksanaan-review"];
            $newProyek->nilaiok_review = $dataProyek["nilaiok-review"];
        }
        // $newProyek->nilai_valas_awal = $dataProyek["nilai-rkap"];
        $newProyek->mata_uang_awal = $dataProyek["mata-uang-awal"];
        $newProyek->kurs_awal = $dataProyek["kurs-awal"];
        $newProyek->bulan_awal = $dataProyek["bulan-pelaksanaan"];
        $newProyek->nilaiok_awal = $dataProyek["nilaiok-awal"];
        $newProyek->status_pasdin  = $dataProyek["status-pasardini"];
        $newProyek->info_asal_proyek  = $dataProyek["info-proyek"];
        $newProyek->laporan_kualitatif_pasdin = $dataProyek["laporan-kualitatif-pasdin"];


        $idCustomer = $dataProyek["customer"];

        // Form update Customer dan auto Proyek Berjalan
        // $newProyek->customer= $dataProyek["customer"];

        // dd(isset($dataProyek["jenis-proyek"]));

        $kode_proyek = $newProyek->kode_proyek;

        Alert::toast("Edit Berhasil", "success")->autoClose(3000);

        if (isset($kode_proyek) && isset($dataProyek["nilai-perolehan"]) && isset($dataProyek["nospk-external"]) && isset($dataProyek["nomor-terkontrak"]) && isset($dataProyek["tanggal-mulai-kontrak"]) && isset($dataProyek["tanggal-akhir-kontrak"])) {
            $contractManagements = ContractManagements::get()->where("project_id", "=", $kode_proyek)->first();
            // $contractManagements = ContractManagements::find($newProyek->nomor_terkontrak);
            // dd($contractManagements);

            if (empty($contractManagements)) {
                // $contractManagements = new ContractManagements();
                // // dd($contractManagements);
                // $contractManagements->project_id = $kode_proyek;
                // // $contractManagements->id_contract = urlencode(urlencode($dataProyek["nomor-terkontrak"]));
                // $contractManagements->id_contract = $dataProyek["nomor-terkontrak"];
                // $contractManagements->contract_in = $dataProyek["tanggal-mulai-kontrak"];
                // $contractManagements->contract_out = $dataProyek["tanggal-akhir-kontrak"];
                // $contractManagements->number_spk = $dataProyek["nospk-external"];
                // $contractManagements->contract_proceed = "Belum Selesai";
                // $contractManagements->value = preg_replace("/[^0-9]/i", "", $dataProyek["nilai-perolehan"]);
                // $contractManagements->stages = (int) 1;
                // $contractManagements->value_review = 0;
                // $contractManagements->save();
            } else {
                // dd($contractManagements);
                // $contractManagements->project_id = $kode_proyek;
                // $contractManagements->id_contract = $newProyek->nomor_terkontrak;
                // $contractManagements->contract_in = $dataProyek["tanggal-mulai-kontrak"];
                // $contractManagements->contract_out = $dataProyek["tanggal-akhir-kontrak"];
                // $contractManagements->number_spk = $dataProyek["nospk-external"];
                // $contractManagements->contract_proceed = "Belum Selesai";
                // $contractManagements->value = preg_replace("/[^0-9]/i", "", $dataProyek["nilai-perolehan"]);
                // $contractManagements->stages = (int) 1;
                // $contractManagements->value_review = 0;
                // $contractManagements->save();
            }
        }

        if ($idCustomer != null) {
            // $customer = Customer::where('name', "=", $dataProyek["customer"])->get()->first();
            // $customer = Customer::find($idCustomer);

            $customerHistory = ProyekBerjalans::where('kode_proyek', "=", $newProyek->kode_proyek)->get()->first();

            if ($customerHistory == null) {

                $customerHistory = new ProyekBerjalans();
                $customerHistory->id_customer = $idCustomer;
                $nameCustomer = Customer::find($idCustomer);
                $customerHistory->name_customer = $nameCustomer->name;
                $customerHistory->nama_proyek = $newProyek->nama_proyek;
                $customerHistory->kode_proyek = $newProyek->kode_proyek;
                $customerHistory->pic_proyek = $newProyek->ketua_tender;
                $customerHistory->unit_kerja = $newProyek->unit_kerja;
                $customerHistory->jenis_proyek = $newProyek->jenis_proyek;
                $customerHistory->nilaiok_proyek = $newProyek->nilai_rkap;
                $customerHistory->stage = $newProyek->stage;
            } else {
                $customerHistory->id_customer = $idCustomer;
                $nameCustomer = Customer::find($idCustomer);
                $customerHistory->name_customer = $nameCustomer->name;
            }

            if ($newProyek->save()) {
                $customerHistory->save();
            }
            return redirect("/proyek/view/" . $kode_proyek);
        } else {
            $newProyek->save();
            return redirect("/proyek/view/" . $kode_proyek);
        }
    }

    public function resetJO(Request $request, $kode_proyek)
    {
        $joProyek = Proyek::find($kode_proyek);
        $joProyek->porsi_jo = 100;
        $joProyek->jenis_proyek = "J";

        foreach ($joProyek->PorsiJO as $porsi) {
            $porsi->delete();
        }

        if ($joProyek->nilai_perolehan != null && $joProyek->stage == 8) {
            $nilaiPerolehan = (int) str_replace('.', '', $joProyek->nilai_perolehan);
            $kontrakKeseluruhan = ($nilaiPerolehan * 100) / $joProyek->porsi_jo;

            $joProyek->nilai_kontrak_keseluruhan = round($kontrakKeseluruhan);
        } else {
            $joProyek->nilai_kontrak_keseluruhan = 0;
        }

        $joProyek->save();
        return redirect()->back();
    }

    private function attachmentMenang(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $attachment = new AttachmentMenang();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_attachment = date("His_") . $file_name;
        moveFileTemp($uploadedFile, $id_document);
        $attachment->nama_attachment = $nama_attachment;
        $attachment->id_document = $id_document;
        $attachment->kode_proyek = $kode_proyek;
        // dd($attachment);
        $attachment->save();
    }

    public function deleteAttachmentMenang($id)
    {
        $delete = AttachmentMenang::find($id);
        // dd($delete);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Attachment Menang Berhasil Dihapus");
        return redirect()->back();
    }

    private function cashFlow(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $cashFlow = new CashFlowProyek();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(' ', '_', $file_name);
        $nama_cashFlow = $file_name;
        // moveFileTemp($uploadedFile, $id_document);
        $cashFlow->nama_document = $nama_cashFlow;
        $cashFlow->id_document = $id_document;
        $cashFlow->kode_proyek = $kode_proyek;
        $cashFlow->save();
        $uploadedFile->move(public_path('dokumen-cashflow/'), $id_document);
    }
    
    public function deleteCashFlow($id)
    {
        $delete = CashFlowProyek::find($id);
        // dd($delete);
        $files = collect(File::allFiles(public_path("dokumen-cashflow")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Dokumen Cashflow Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenSCurves($files, $kode_proyek)
    {
        foreach ($files as $file) {
            $faker = new Uuid();
            $scurves = new DokumenSCurvesProyek();
            $file_name = $file->getClientOriginalName();
            $id_document = date("dmYHis_") . str_replace(' ', '_', $file_name);
            $nama_scurves = $file_name;
            $scurves->nama_document = $nama_scurves;
            $scurves->id_document = $id_document;
            $scurves->kode_proyek = $kode_proyek;
            $scurves->save();
            $file->move(public_path('dokumen-s-curves/'), $id_document);
        }
    }

    public function deleteDokumenSCurves($id)
    {
        $delete = DokumenSCurvesProyek::find($id);
        // dd($delete);
        $files = collect(File::allFiles(public_path("dokumen-scurves")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Dokumen S Curves Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenOtherProyek($files, $kode_proyek)
    {
        foreach ($files as $file) {
            $faker = new Uuid();
            $dokumenOther = new DokumenOtherProyek();
            $file_name = $file->getClientOriginalName();
            $id_document = date("dmYHis_") . str_replace(' ', '_', $file_name);
            $nama_dokumenOther = $file_name;
            $dokumenOther->nama_document = $nama_dokumenOther;
            $dokumenOther->id_document = $id_document;
            $dokumenOther->kode_proyek = $kode_proyek;
            $dokumenOther->save();
            $file->move(public_path('dokumen-other-proyek/'), $id_document);
        }
    }

    public function deleteDokumenOtherProyek($id)
    {
        $delete = DokumenOtherProyek::find($id);
        File::delete(public_path("dokumen-other-proyek/" . $delete->id_document));
        $delete->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function riskTender(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $attachment = new RiskTenderProyek();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_attachment = date("His_") . $file_name;
        moveFileTemp($uploadedFile, $id_document);
        $attachment->nama_risk_tender = $nama_attachment;
        $attachment->id_document = $id_document;
        $attachment->kode_proyek = $kode_proyek;
        $attachment->created_by = Auth::user()->name;
        // dd($attachment);
        $attachment->save();
    }

    public function deleteRiskTender($id)
    {
        $delete = RiskTenderProyek::find($id);
        // dd($delete);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Risk Tender Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenNotaRekomendasi1(UploadedFile $uploadedFile, $kode_proyek)
    {
        // $faker = new Uuid();
        $dokumen = new DokumenNotaRekomendasi1();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(" ", "-", $file_name);
        $nama_document = $file_name;
        // dd($uploadedFile);
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        // moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $uploadedFile->move(public_path('dokumen-nota-rekomendasi'), $id_document);
        $dokumen->save();
    }

    public function deleteNotaRekomendasi1($id)
    {
        $delete = DokumenNotaRekomendasi1::find($id);
        File::delete(public_path(public_path("dokumen-nota-rekomendasi/$delete->id_document")));
        $delete->delete();
        Alert::success("Success", "Dokumen Nota Rekomendasi 1 Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenPenentuanKSO(UploadedFile $uploadedFile, $kode_proyek)
    {
        // $faker = new Uuid();
        $dokumen = new DokumenPenentuanKSO();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(" ", "-", $file_name);
        $nama_document = $file_name;
        // dd($uploadedFile);
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        // moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_document = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $uploadedFile->move(public_path('dokumen-penentuan-kso'), $id_document);
        $dokumen->save();
    }

    public function downloadDokumenPenentuanKSO($id_document)
    {
        $file = DokumenPenentuanKSO::where('id_document', $id_document)->first();
        try {
            $checkFileFromStorage = public_path('dokumen-penentuan-kso/' . $file->id_document);
            return response()->download($checkFileFromStorage, 'Dokumen Penentuan KSO - ' . $file->Proyek->kode_proyek . '.pdf');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteDokumenPenentuanKSO($id)
    {
        $delete = DokumenPenentuanKSO::find($id);
        File::delete(public_path("/dokumen-penentuan-kso/$delete->id_document"));
        $delete->delete();
        Alert::success("Success", "Dokumen Penentuan KSO Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenPersetujuanKSO(UploadedFile $uploadedFile, $kode_proyek)
    {
        $dokumen = new DokumenPersetujuanKSO();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(" ", "-", $file_name);
        $nama_document = $file_name;
        $dokumen->nama_document = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        $uploadedFile->move(public_path('dokumen-persetujuan-kso'), $id_document);
        $dokumen->save();
    }

    public function downloadDokumenPersetujuanKSO($id_document)
    {
        $file = DokumenPersetujuanKSO::where('id_document', $id_document)->first();
        try {
            $checkFileFromStorage = public_path('dokumen-persetujuan-kso/' . $file->id_document);
            return response()->download($checkFileFromStorage, 'Dokumen Persetujuan KSO - ' . $file->Proyek->kode_proyek . '.pdf');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteDokumenPersetujuanKSO($id)
    {
        $delete = DokumenPenentuanKSO::find($id);
        File::delete(public_path("/dokumen-persetujuan-kso/$delete->id_document"));
        $delete->delete();
        Alert::success("Success", "Dokumen Persetujuan KSO Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenPenentuanProjectGreenlane(UploadedFile $uploadedFile, $kode_proyek)
    {
        // $faker = new Uuid();
        $dokumen = new DokumenPenentuanProjectGreenlane();
        $file_name = $uploadedFile->getClientOriginalName();
        $id_document = date("dmYHis_") . str_replace(" ", "-", $file_name);
        $nama_document = $file_name;
        // dd($uploadedFile);
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        // moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_document = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $uploadedFile->move(public_path('dokumen-penentuan-project-greenlane'), $id_document);
        $dokumen->save();
    }

    public function downloadDokumenPenentuanProjectGreenlane($id_document)
    {
        $file = DokumenPenentuanProjectGreenlane::where('id_document', $id_document)->first();
        try {
            $checkFileFromStorage = public_path('dokumen-penentuan-project-greenlane/' . $file->id_document);
            return response()->download($checkFileFromStorage, 'Dokumen Penentuan Project Greenlane atau Non Greenlane - ' . $file->Proyek->kode_proyek . '.pdf');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteDokumenPenentuanProjectGreenlane($id)
    {
        $delete = DokumenPenentuanProjectGreenlane::find($id);
        File::delete(public_path("/dokumen-penentuan-project-greenlane/$delete->id_document"));
        $delete->delete();
        Alert::success("Success", "Dokumen Penentuan Project Greenlane/Non Greenlane Berhasil Dihapus");
        return redirect()->back();
    }



    private function uploadDokumenPefindo(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen_pefindo = new DokumenPefindo();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen_pefindo->nama_dokumen = $nama_document;
        $dokumen_pefindo->id_document = $id_document;
        $dokumen_pefindo->kode_proyek = $kode_proyek;
        // dd($dokumen_pefindo);
        $dokumen_pefindo->save();
    }

    // private function uploadDokumenConsentNPWP(UploadedFile $uploadedFile, $kode_proyek)
    // {
    //     $faker = new Uuid();
    //     $dokumen = new DokumenConsentNPWP();
    //     $id_document = $faker->uuid3();
    //     $file_name = $uploadedFile->getClientOriginalName();
    //     $nama_document = date("His_") . $file_name;
    //     // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
    //     moveFileTemp($uploadedFile, $id_document);
    //     $dokumen->nama_dokumen = $nama_document;
    //     $dokumen->id_document = $id_document;
    //     $dokumen->kode_proyek = $kode_proyek;
    //     // dd($dokumen);
    //     $dokumen->save();
    // }

    public function deleteDokumenPefindo($id)
    {
        $delete = DokumenPefindo::find($id);
        // dd($$delete);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Dokumen Pefindo Berhasil Dihapus");
        return redirect()->back();
    }

    public function deleteDokumenConsentNPWP($id)
    {
        $delete = DokumenConsentNPWP::find($id);
        // dd($$delete);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Dokumen Consent & NPWP Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenPrakualifikasi(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen_prakualifikasi = new DokumenPrakualifikasi();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen_prakualifikasi->nama_dokumen = $nama_document;
        $dokumen_prakualifikasi->id_document = $id_document;
        $dokumen_prakualifikasi->kode_proyek = $kode_proyek;
        // dd($dokumen_prakualifikasi);
        $dokumen_prakualifikasi->save();
    }

    public function deleteDokumenPrakualifikasi($id)
    {
        $delete = DokumenPrakualifikasi::find($id);
        // dd($$delete);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($delete) {
            return str_contains($f->getFilename(), $delete->id_document);
        })->first();
        File::delete($files);
        $delete->delete();
        Alert::success("Success", "Dokumen Prakualifikasi Berhasil Dihapus");
        return redirect()->back();
    }
    
    private function uploadDokumenNda(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenNda();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenNda($id)
    {
        $deleteDokumen = DokumenNda::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }
    
    private function uploadDokumenMou(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenMou();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenMou($id)
    {
        $deleteDokumen = DokumenMou::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenEca(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenEca();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenEca($id)
    {
        $deleteDokumen = DokumenEca::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenIca(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenIca();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenIca($id)
    {
        $deleteDokumen = DokumenIca::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenRks(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenRks();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenRks($id)
    {
        $deleteDokumen = DokumenRks::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenDraft(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenDraft();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenDraft($id)
    {
        $deleteDokumen = DokumenDraft::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenItbTor(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();
        $dokumen = new DokumenItbTor();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen->nama_dokumen = $nama_document;
        $dokumen->id_document = $id_document;
        $dokumen->kode_proyek = $kode_proyek;
        // dd($dokumen);
        $dokumen->save();
    }

    public function deleteDokumenItbTor($id)
    {
        $deleteDokumen = DokumenItbTor::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Berhasil Dihapus");
        return redirect()->back();
    }

    private function uploadDokumenTender(UploadedFile $uploadedFile, $kode_proyek)
    {
        $faker = new Uuid();    
        $dokumen_tender = new DokumenTender();
        $id_document = $faker->uuid3();
        $file_name = $uploadedFile->getClientOriginalName();
        $nama_document = date("His_") . $file_name;
        // $nama_document = date("His_") . substr($uploadedFile->getClientOriginalName(), 0, strlen($uploadedFile->getClientOriginalName()) - 5);
        moveFileTemp($uploadedFile, $id_document);
        $dokumen_tender->nama_dokumen = $nama_document;
        $dokumen_tender->id_document = $id_document;
        $dokumen_tender->kode_proyek = $kode_proyek;
        $dokumen_tender->created_by = Auth::user()->name;
        // dd($dokumen_tender);
        $dokumen_tender->save();
    }

    public function deleteDokumenTender($id)
    {
        $deleteDokumen = DokumenTender::find($id);
        $files = collect(File::allFiles(public_path("words")))->filter(function ($f) use ($deleteDokumen) {
            return str_contains($f->getFilename(), $deleteDokumen->id_document);
        })->first();
        File::delete($files);
        // dd($files);
        $deleteDokumen->delete();
        Alert::success("Success", "Dokumen Tender Berhasil Dihapus");
        return redirect()->back();
    }

    public function delete($kode_proyek)
    {
        $deleteProyek = Proyek::find($kode_proyek);

        $proyekBerjalan = ProyekBerjalans::where('kode_proyek', "=", $deleteProyek->kode_proyek)->get()->first();
        $contractManagement = ContractManagements::where('project_id', "=", $deleteProyek->kode_proyek)->get()->first();
        $claimManagement = ClaimManagements::where('kode_proyek', "=", $deleteProyek->kode_proyek)->get();
        $forecasts = Forecast::where('kode_proyek', "=", $deleteProyek->kode_proyek)->get();
        $historyForecasts = HistoryForecast::where('kode_proyek', "=", $deleteProyek->kode_proyek)->get();
        
        $data = [
            "Proyek_Detail" => $deleteProyek->toArray(),
            "Proyek_Berjalan_Detail" => !empty($proyekBerjalan) ? $proyekBerjalan->toArray() : null ,
            "Contract_Management_Detail" => !empty($contractManagement) ? $contractManagement->toArray() : null,
            "ClaimManagement_Detail" => !empty($claimManagement) ? $claimManagement->toArray() : null,
            "Forecast_Detail" => !empty($forecasts) ? $forecasts->toArray() : null,
            "History_Forcast" => !empty($historyForecasts) ? $historyForecasts->toArray() : null,
        ];

        
        $claimManagement->each(function ($claim) {
            $claim->delete();
        });
        
        Alert::success('Delete', $deleteProyek->nama_proyek . ", Berhasil Dihapus");
        if (!empty($proyekBerjalan)) {
            $proyekBerjalan->delete();
        }
        if (!empty($contractManagement)) {
            $contractManagement->delete();
        }
        if (!empty($forecasts)) {
            foreach ($forecasts as $f) {
                $f->delete();
            }
        }
        if (!empty($historyForecasts)) {
            foreach ($historyForecasts as $hf) {
                $hf->delete();
            }
        }
        setLogging("proyek-delete", "Proyek ". $deleteProyek->kode_proyek . " - " . $deleteProyek->nama_proyek ." =>", $data);
        $deleteProyek->delete();
        
        // if ($proyekBerjalan != null && $contractManagement != null && $forecasts != null) {
        //     $deleteProyek->delete();
        //     $contractManagement->delete();
        //     $proyekBerjalan->delete();
        //     foreach ($forecasts as $f) {
        //         $f->delete();
        //     }
        //     foreach ($historyForecasts as $hf) {
        //         $hf->delete();
        //     }
        // } elseif ($proyekBerjalan != null && $contractManagement != null) {
        //     $deleteProyek->delete();
        //     $contractManagement->delete();
        //     $proyekBerjalan->delete();
        // } elseif ($contractManagement !=  null) {
        //     $deleteProyek->delete();
        //     $contractManagement->delete();
        // } elseif ($forecasts !=  null) {
        //     $deleteProyek->delete();
        //     foreach ($forecasts as $f) {
        //         $f->delete();
        //     }
        //     foreach ($historyForecasts as $hf) {
        //         $hf->delete();
        //     }
        // } else {
        //     $deleteProyek->delete();
        // }

        // dd($proyekBerjalan); 
        // dd($deleteProyek->kode_proyek);


        return redirect("/proyek")->with("success", "Proyek Berhasil Dihapus");
    }

    public function cancelProyek($kode_proyek)
    {
        $cancelProyek = Proyek::find($kode_proyek);
        // $bulans = (int) date('m');
        // $years = (int) date('Y');
        // $cancelForecast = Forecast::where("kode_Forecast", "=", $kode_proyek)->where("periode_prognosa", "=", $bulans)->whereYear("created_at", "=", $years)->get();
        // $cancelForecast->delete();
        // dd($cancelProyek);
        $cancelProyek->is_cancel = true;

        $forecasts = Forecast::where('kode_proyek', "=", $kode_proyek)->get();
        // $proyekBerjalan = ProyekBerjalans::where('kode_proyek', "=", $kode_proyek)->get()->first();
        // $contractManagement = ContractManagements::where('project_id', "=", $kode_proyek)->get()->first();
        // $claimManagement = ClaimManagements::where('kode_proyek', "=", $kode_proyek)->get();
        // $historyForecasts = HistoryForecast::where('kode_proyek', "=", $kode_proyek)->get();

        if (!empty($forecasts)) {
            foreach ($forecasts as $f) {
                // $f->delete();
                $f->nilai_forecast = 0;
                $f->realisasi_forecast = 0;
                $f->save();
            }
        }
        $cancelProyek->nilai_perolehan = 0;
        // if(!empty($historyForecasts)) {
        //     foreach ($historyForecasts as $hf) {
        //         $hf->delete();
        //     }
        // }

        $cancelProyek->save();

        Alert::warning('Cancel', $cancelProyek->nama_proyek . ", Telah ter-Cancel");

        return redirect()->back();
    }

    public function exportProyek(Request $request)
    {
        // dd($request);
        $counter = 2;

        $spreadsheet = new Spreadsheet();
        // nama proyek, status pasar, stage, unit kerja, bulan, nilai forecast

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle("A1:L1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0db0d9');
        $sheet->setCellValue('A1', 'Nama Proyek');
        $sheet->setCellValue('B1', 'Kode Proyek');
        $sheet->setCellValue('C1', 'Tipe Proyek');
        $sheet->setCellValue('D1', 'Jenis Proyek');
        $sheet->setCellValue('E1', 'Unit Kerja');
        $sheet->setCellValue('F1', 'Stage');
        $sheet->setCellValue('G1', 'Status Pasar');
        $sheet->setCellValue('H1', 'Tahun RA Perolehan');
        $sheet->setCellValue('I1', 'Bulan RA Perolehan');
        $sheet->setCellValue('J1', 'Nilai RKAP');
        $sheet->setCellValue('K1', 'Nilai Forecast');
        $sheet->setCellValue('L1', 'Nilai Realisasi');

        if (Auth::user()->check_administrator) {
            $proyek = Proyek::all();
        } else {
            $unit_kerja_user = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
            if ($unit_kerja_user instanceof \Illuminate\Support\Collection) {
                $proyek = Proyek::whereIn("unit_kerja", $unit_kerja_user->toArray())->get();
            } else {
                $proyek = Proyek::where("unit_kerja", "=", $unit_kerja_user)->get();
            }
        }

        // dd($proyek);
        foreach ($proyek as $p) {
            $sheet->setCellValue("A" . $counter, $p->nama_proyek);
            $sheet->setCellValue("B" . $counter, $p->kode_proyek);
            $sheet->setCellValue("C" . $counter, $p->tipe_proyek);
            $sheet->setCellValue("D" . $counter, $p->jenis_proyek);
            $sheet->setCellValue("E" . $counter, $this->getUnitKerjaProyek($p->unit_kerja));
            $sheet->setCellValue("F" . $counter, $this->getProyekStage($p->stage));
            $sheet->setCellValue("G" . $counter, $p->status_pasdin);
            $sheet->setCellValue("H" . $counter, $p->tahun_perolehan);
            $sheet->setCellValue("I" . $counter, $this->getFullMonth($p->bulan_pelaksanaan));
            $sheet->setCellValue("J" . $counter, $p->nilai_rkap);
            $sheet->setCellValue("K" . $counter, $p->forecast);
            $sheet->setCellValue("L" . $counter, $p->nilai_perolehan);
            // $stage = $this->getProyekStage($p->stage);
            $counter++;
        }


        $writer = new Xlsx($spreadsheet);
        $file_name = "Detail_Proyek_" . date('dmYHis') . ".xlsx";
        $writer->save(public_path("excel/$file_name"));

        // Session::flash('excel/'.$file_name, $file_name);
        // return Response::download($writer, $file_name);
        return redirect('excel/' . $file_name);
    }

    // public function stage(Request $request)
    // {
    //     // $url = $request->url;
    //     // dd($url);
    //     $kodeProyek = $request->kode_proyek;
    //     $proyekStage = Proyek::find($kodeProyek);
    //     $proyekAttach = $proyekStage->AttachmentMenang;
    //     $dokumenTender = $proyekStage->DokumenTender;
    //     $periode = (int) date('m');
    //     $years = (int) date('Y');
    //     $forecasts = Forecast::where("kode_proyek", "=", $kodeProyek)->where("periode_prognosa", "=", $periode)->whereYear("created_at", "=", $years)->first();
    //     // $forecasts = $proyekStage->Forecasts->where("periode_prognosa", "=", $periode)->whereYear("created_at", "=", $years)->first();
    //     dd($request->all());
    //     if ($request->stage == 4) {
    //         if ($proyekStage->hps_pagu == 0) {
    //             Alert::error("Error", "HPS Pagu Belum Diisi !");
    //             $request->stage = 3;
    //         } else {
    //             $request->stage = 4;
    //         }

    //         if ($proyekStage->DokumenPrakualifikasi->isEmpty()) {
    //             Alert::error("Error", "Dokumen Prakualifikasi wajib diisi !");
    //             $request->stage = 3;
    //         } else {
    //             $request->stage = 4;
    //         }
    //     } else if ($request->stage == 5) {
    //         // if ($dokumenTender->count() == 0) {
    //         //     // dd($dokumenTender);
    //         //     Alert::error("Error", "Silahkan Isi Dokumen Tender Terlebih Dahulu !");
    //         //     // return redirect()->back();
    //         // } else {
    //         //     $request->stage = 5;
    //         // }
    //         if ($proyekStage->penawaran_tender == 0 && $dokumenTender->count() == 0) {
    //             Alert::error("Error", "Silahkan Isi Nilai Penawaran dan Dokumen Tender Terlebih Dahulu !");
    //             $request->stage = 4;
    //         } else if ($proyekStage->penawaran_tender == 0) {
    //             Alert::error("Error", "Silahkan Isi Nilai Penawaran Terlebih Dahulu !");
    //             $request->stage = 4;
    //         } else if ($dokumenTender->count() == 0) {
    //             Alert::error("Error", "Silahkan Isi Dokumen Tender Terlebih Dahulu !");
    //             $request->stage = 4;
    //         } else {
    //             $request->stage = 5;
    //         }
    //     };

    //     if (!$request->is_ajax) {
    //         $data = $request->all();

    //         // Check kalo variable di bawah ini ada
    //         if (!empty($data["stage-menang"]) && $data["stage-menang"] == "Menang") {
    //             if ($proyekStage->nilai_perolehan == 0) {
    //                 Alert::error("Error", "Nilai Perolehan Belum Diisi !");
    //                 return redirect()->back();
    //             } else {
    //                 $request->stage = 6;
    //             }
    //         } elseif (!empty($data["stage-kalah"]) && $data["stage-kalah"] == "Kalah") {
    //             $proyekStage->nilai_perolehan = 0;
    //             $proyekStage->save();

    //             if (!empty($forecasts)) {
    //                 $forecasts->realisasi_forecast = 0;
    //                 $forecasts->save();
    //             }

    //             $request->stage = 7;
    //         } elseif (!empty($data["stage-terkontrak"]) && $data["stage-terkontrak"] == "Terkontrak") {
    //             $customer = $proyekStage->ProyekBerjalan->Customer ?? null;
    //             if (!empty($customer)) {
    //                 $error_msg = collect();
    //                 if (empty($customer->kode_nasabah)) {
    //                     $error_msg->push("Kode Nasabah");
    //                 }
    //                 if (empty($customer->email)) {
    //                     $error_msg->push("Email");
    //                 }
    //                 if (empty($customer->address_1)) {
    //                     $error_msg->push("Alamat");
    //                 }
    //                 if (empty($customer->kode_pos)) {
    //                     $error_msg->push("Kode Pos");
    //                 }
    //                 if (empty($customer->fax)) {
    //                     $error_msg->push("Fax");
    //                 }
    //                 if (empty($customer->phone_number)) {
    //                     $error_msg->push("No Telp");
    //                 }
    //                 if (empty($customer->handphone)) {
    //                     $error_msg->push("Handphone");
    //                 }
    //                 if (empty($customer->industry_sector)) {
    //                     $error_msg->push("Industry Sector");
    //                 }
    //                 if (empty($customer->jenis_instansi)) {
    //                     $error_msg->push("Instansi");
    //                 }
    //                 if (empty($customer->jenis_perusahaan)) {
    //                     $error_msg->push("Jenis Perusahaan");
    //                 }
    //                 if (empty($customer->provinsi)) {
    //                     $error_msg->push("Provinsi");
    //                 }
    //                 if (empty($customer->kota_kabupaten)) {
    //                     $error_msg->push("Kota/Kabupaten");
    //                 }
    //                 if (empty($customer->npwp_company)) {
    //                     $error_msg->push("NPWP");
    //                 }
    //                 if (empty($customer->syarat_pembayaran)) {
    //                     $error_msg->push("Term Payment");
    //                 }
    //                 if (empty($proyekStage->Departemen)) {
    //                     $error_msg->push("Departemen");
    //                 }
    //                 if ($customer->tax == null) {
    //                     $error_msg->push("Tax");
    //                 }
    //                 if ($error_msg->isNotEmpty()) {
    //                     Alert::html("Error - Pelanggan !", "Untuk pindah ke stage terkontrak, pastikan data <b>Pelanggan</b> dengan field <b>" . $error_msg->join(", ", " </b>dan<b> ") . "</b> sudah terisi!", "error")->autoClose(10000);
    //                     return redirect()->back();
    //                 }
    //             } else if (empty($customer)) {
    //                 Alert::html("Error - Proyek !", "Untuk pindah ke stage terkontrak, pastikan field <b>Pelanggan</b> pada stage Pasar Dini sudah terpilih!", "error")->autoClose(10000);
    //                 return redirect()->back();
    //             }
    //             $sap = $customer->sap;
    //             $pic = $customer->pic->filter( function ($p) {
    //                 return (!empty($p->nama_pic) && !empty($p->jabatan_pic) && !empty($p->email_pic) && !empty($p->phone_pic));
    //             })->first();

    //             if (empty($pic)) {
    //                 Alert::html("Error - PIC Pelanggan !", "Untuk pindah ke stage terkontrak, pastikan mengisi minimal <b>1 PIC Pelanggan</b> !", "error")->autoClose(10000);
    //                 return redirect()->back();
    //             }

    //             // dump($sap, $pic);
    //             // dd();
    //             if (empty($customer)) {
    //                 Alert::error("Error", "Pastikan Data Pelanggan sudah terisi!")->autoClose(10000);
    //                 return redirect()->back();
    //             }
    //             // http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm_dev
    //             // Begin :: Ngirim data ke nasabah online WIKA
    //             $provinsi = Provinsi::where("province_name", "=", $customer->provinsi)->first() ?? Provinsi::find($customer->provinsi);
    //             if (empty($provinsi)) {
    //                 Alert::html("Error", "Pastikan <b>Provinsi</b> pada Field <b>Pelanggan</b> sudah terisi!", "error")->autoClose(10000);
    //                 return redirect()->back();
    //             }
    //             // dd($customer);
    //             $grouping = "";
    //             $kdgrp = "";
    //             $ktgrd = "";
    //             $cust_akont = "";
    //             $witht = "";
    //             if($customer->jenis_instansi == "Kementrian / Pemerintah Pusat" || $customer->jenis_instansi == "Pemerintah Provinsi" || $customer->jenis_instansi == "Pemerintah Kota / Kabupaten") {
    //                 $kdgrp = "03";
    //                 $grouping = "ZN01";
    //                 $ktgrd = "Z1";
    //                 $cust_akont = "1104111000";
    //                 $witht = "J7";
    //             } else if($customer->jenis_instansi == "BUMN") {
    //                 $kdgrp = "04";
    //                 $grouping = "ZN01";
    //                 $ktgrd = "Z1";
    //                 $cust_akont = "1104111000";
    //                 $witht = "J7";
    //             } else if($customer->jenis_instansi == "BUMD" || $customer->jenis_instansi == "Swasta Nasional") {
    //                 $kdgrp = "05";
    //                 $grouping = "ZN02";
    //                 $ktgrd = "Z2";
    //                 $cust_akont = "1104211000";
    //                 $witht = "J7";
    //             } else if($customer->jenis_instansi == "Pemerintah Asing" || $customer->jenis_instansi == "Swasta Asing") {
    //                 $kdgrp = "06";
    //                 $grouping = "ZN02";
    //                 $ktgrd = "Z2";
    //                 $cust_akont = "1104211000";
    //                 $witht = "J7";
    //             } else if($customer->jenis_instansi == "Perusahaan JO") {
    //                 $kdgrp = "08";
    //                 $grouping = "ZN05";
    //                 $ktgrd = "Z4";
    //                 $cust_akont = "";
    //                 $witht = "";
    //             }
    //             $data_nasabah_online = collect([
    //                 "nmnasabah" => "$customer->name",
    //                 "alamat" => "$customer->address_1",
    //                 "kota" => "$customer->kota_kabupaten",
    //                 "email" => "$customer->email",
    //                 "ext" => "-",
    //                 "telepon" => "$customer->phone_number",
    //                 "fax" => "$customer->fax",
    //                 "npwp" => "$customer->npwp_company",
    //                 "nama_kontak" => $pic->nama_pic ?? "",
    //                 "jenisperusahaan" => "$customer->jenis_instansi",
    //                 "jabatan" => $pic->jabatan_pic ?? "",
    //                 "email1" => $pic->email_pic ?? "",
    //                 "telpon1" => $pic->phone_pic ?? "",
    //                 "handphone" => $pic->phone_pic ?? "",
    //                 "tipe_perusahaan" => "$customer->jenis_perusahaan",
    //                 "tipe_lain_perusahaan" => "-",
    //                 "cotid" => "11",
    //                 "dtsap" => [
    //                     [
    //                         "devid" => "YMMI002",
    //                         "packageid" => $this->GUID(),
    //                         "cocode" => "A000",
    //                         "prctr" => "",
    //                         // "timestamp" => "20221013100000",
    //                         "timestamp" => date("y") . date("m") . date("d") . "10000",
    //                         "data" => [
    //                             [
    //                                 "BPARTNER" => "$customer->kode_nasabah",
        
    //                                 "GROUPING" => "$grouping",
        
    //                                 "LVORM" => "",
        
    //                                 "TITLE" => "Z001",
        
    //                                 "NAME" => "$customer->name",
        
    //                                 "TITLELETTER" => "",
        
    //                                 "SEARCHTERM1" => substr($customer->name, 0, 40) ?? "",
        
    //                                 "SEARCHTERM2" => substr($customer->name, 0, 40) ?? "",
        
    //                                 "STREET" => $sap->street ?? "",
        
    //                                 "HOUSE_NO" => "",
        
    //                                 "POSTL_COD1" => "$customer->kode_pos",
        
    //                                 "CITY" => explode("-", $provinsi->province_id)[1],
        
    //                                 // "ADDR_COUNTRY" => $provinsi->country_id ?? "ID",
    //                                 "ADDR_COUNTRY" => "ID",
        
    //                                 "REGION" => explode("-", $provinsi->province_id)[1],
        
    //                                 "PO_BOX" => "",
        
    //                                 "POSTL_COD3" => "",
        
    //                                 "LANGU" => "E",
        
    //                                 "TELEPHONE" => "$customer->phone_number",
        
    //                                 "PHONE_EXTENSION" => "",
        
    //                                 "MOBPHONE" => "$customer->handphone",
        
    //                                 "FAX" => "$customer->fax",
        
    //                                 "FAX_EXTENSION" => "",
        
    //                                 "E_MAIL" => "$customer->email",
        
    //                                 "VALIDFROMDATE" => now()->translatedFormat("d-m-Y"),
        
    //                                 "VALIDTODATE" => now()->addMonths(5)->translatedFormat("d-m-Y"),
        
    //                                 "IDENTIFICATION" => [
    //                                     [
        
    //                                         // "TAXTYPE" => "$sap->tax_number_category",
    //                                         "TAXTYPE" => $provinsi->country_id == "ID" ? "ID1" : "ID2",
            
    //                                         "TAXNUMBER" => "$customer->npwp_company"
    //                                     ]
    //                                 ],
        
    //                                 "BANK" => [
    //                                     [
    //                                         "BANK_DET_ID" => "",
            
    //                                         "BANK_CTRY" => "",
            
    //                                         "BANK_KEY" => "",
            
    //                                         "BANK_ACCT" => "",
            
    //                                         "BK_CTRL_KEY" => "",
            
    //                                         "BANK_REF" => "",
            
    //                                         "EXTERNALBANKID" => "",
            
    //                                         "ACCOUNTHOLDER" => "",
            
    //                                         "BANKACCOUNTNAME" => ""
    //                                     ]
    //                                 ],
        
    //                                 "CUST_BUKRS" => "",
        
    //                                 "KUNNR" => "",
        
    //                                 "CUST_AKONT" => "$cust_akont",
        
    //                                 "CUST_C_ZTERM" => "$customer->syarat_pembayaran",
        
    //                                 "CUST_WTAX" => [
    //                                     [
        
    //                                         "WITHT" => "$witht",
            
    //                                         "WT_AGENT" => "",
            
    //                                         "WT_AGTDF" => "",
            
    //                                         "WT_AGTDT" => ""
    //                                     ]
    //                                 ],
        
    //                                 "VKORG" => "",
        
    //                                 "VTWEG" => "",
        
    //                                 "SPART" => "",
        
    //                                 "KDGRP" => $kdgrp,
        
    //                                 "CUST_WAERS" => "IDR",
        
    //                                 "KALKS" => "",
        
    //                                 "VERSG" => "",
        
    //                                 "VSBED" => "",
        
    //                                 "INCO1" => "",
        
    //                                 "INCO2_L" => "",
        
    //                                 "CUST_S_ZTERM" => "$customer->syarat_pembayaran",
        
    //                                 "KTGRD" => "$ktgrd",
        
    //                                 "TAXKD" => "$customer->tax",
        
    //                                 "VEND_BUKRS" => "",
        
    //                                 "LIFNR" => "",
        
    //                                 "VEND_AKONT" => "",
        
    //                                 "VEND_C_ZTERM" => "",
        
    //                                 "REPRF" => "X",
        
    //                                 "VEND_WTAX" => [[]],
    //                                 // "VEND_WTAX" => [
        
    //                                 //     "WITHT" => "J3",
        
    //                                 //     "WT_SUBJCT" => "X"
        
    //                                 // ],
        
    //                                 "EKORG" => "",
        
    //                                 "VEND_P_ZTERM" => "",
        
    //                                 "WEBRE" => "",
        
    //                                 "VEND_WAERS" => "",
        
    //                                 "LEBRE" => "",

    //                                 "BRAN2" => $customer->IndustrySector->id_industry_sector,
    //                             ]
    //                         ]
    //                     ]
    //                 ]
    //             ]);
    //             // dd($data_nasabah_online);
    //             // End :: Ngirim data ke nasabah online WIKA

    //             // dd($proyekStage->nilai_perolehan, $proyekStage->porsi_jo, $proyekStage->nilai_kontrak_keseluruhan);
    //             if ($proyekStage->nilai_perolehan != null && $proyekStage->porsi_jo != null) {
    //                 $nilaiPerolehan = (int) str_replace('.', '', $proyekStage->nilai_perolehan);
    //                 $kontrakKeseluruhan = ($nilaiPerolehan * 100) / (float) $proyekStage->porsi_jo;

    //                 $proyekStage->nilai_kontrak_keseluruhan = round($kontrakKeseluruhan);
    //                 $proyekStage->save();
    //             }
    //             if ($proyekAttach->count() == 0) {
    //                 Alert::error("Error", "Silahkan Isi Attachment Menang Terlebih Dahulu !");
    //                 return redirect()->back();
    //             } else {
    //                 $contractManagements = ContractManagements::get()->where("project_id", "=", $proyekStage->kode_proyek)->first();
    //                 if (str_contains(URL::full() , 'crm.wika.co.id')) {
    //                     $nasabah_online_response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm", $data_nasabah_online)->json();
    //                     // dd($nasabah_online_response);
    //                     if (!$nasabah_online_response["status"] && !str_contains($nasabah_online_response["msg"], "sudah ada dalam nasabah online")) {
    //                         Alert::error("Error", $nasabah_online_response["msg"]);
    //                         return redirect()->back();
    //                     }
    //                     // $nasabah_online_response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm_dev", $data_nasabah_online)->json();
    //                     $request->stage = 8;
    //                     if (!empty($contractManagements)) {
    //                             $contractManagements->stages = (int) 2;
    //                         $contractManagements->save();
    //                     }
    //                 } else {
    //                     $request->stage = 8;
    //                     if (!empty($contractManagements)) {
    //                             $contractManagements->stages = (int) 2;
    //                         $contractManagements->save();
    //                     }
    //                 }
    //             }
    //         } elseif (!empty($data["stage-terendah"]) && $data["stage-terendah"] == "Terendah") {
    //             if ($proyekAttach->count() == 0) {
    //                 Alert::error("Error", "Silahkan Isi Attachment Menang Lebih Dahulu !");
    //                 return redirect()->back();
    //             } else {
    //                 $request->stage = 9;
    //             }
    //         } else if (isset($data["stage-tidak-lulus-pq"])) {
    //             $proyekStage->is_tidak_lulus_pq = true;
    //             $request->stage = 3;
    //         } else if (isset($data["stage-prakualifikasi"])) {
    //             $proyekStage->is_tidak_lulus_pq = false;
    //             if (empty($proyekStage->klasifikasi_sbu_kbli) || empty($proyekStage->kbli_2020)) {
    //                 Alert::error("Error", "Klasifikasi SBU KBLI dan Sub Klasifikasi SBU KBLI wajib diisi!");
    //                 $request->stage = 2;
    //             } else {
    //                 $request->stage = 3;
    //             }
    //         }
    //     }
    //     $proyekStage->stage = $request->stage;

    //     $teamProyek = TeamProyek::where('kode_proyek', "=", $proyekStage->kode_proyek)->get();
    //     if ($teamProyek != null) {
    //         $teamProyek->each(function ($stage) use ($proyekStage) {
    //             if ($proyekStage->stage > 8) {
    //                 $stage->proyek_selesai = true;
    //                 $stage->save();
    //             }
    //         });
    //     }

    //     $proyekBerjalans = ProyekBerjalans::where('kode_proyek', "=", $proyekStage->kode_proyek)->get()->first();
    //     if ($proyekBerjalans == null) {
    //         $proyekStage->save();
    //         if ($request->is_ajax) {
    //             return response()->json([
    //                 "status" => "success",
    //                 "link" => true,
    //             ]);
    //         }
    //         Alert::success("Success", "Stage berhasil diperbarui");
    //         return back();
    //     } else {
    //         $proyekBerjalans->stage = $request->stage;
    //         $proyekBerjalans->save();
    //         $proyekStage->save();
    //         if ($request->is_ajax) {
    //             return response()->json([
    //                 "status" => "success",
    //                 "link" => true,
    //             ]);
    //         }
    //         Alert::success("Success", "Stage berhasil diperbarui");
    //         return back();
    //     }

    //     Alert::error("Error", "Stage gagal diperbarui");
    //     return back();
    // }

    public function stage(Request $request)
    {
        // $url = $request->url;
        // dd($url);
        $kodeProyek = $request->kode_proyek;
        $proyekStage = Proyek::find($kodeProyek);
        $proyekAttach = $proyekStage->AttachmentMenang;
        $dokumenTender = $proyekStage->DokumenTender;
        $periode = (int) date('m');
        $years = (int) date('Y');
        $forecasts = Forecast::where("kode_proyek", "=", $kodeProyek)->where("periode_prognosa", "=", $periode)->whereYear("created_at", "=", $years)->first();
        // $forecasts = $proyekStage->Forecasts->where("periode_prognosa", "=", $periode)->whereYear("created_at", "=", $years)->first();
        if ($proyekStage->stage == 8 && $request->is_ajax) {
            Alert::error("Error", "Proyek sudah tidak dapat dikembalikan. Hubungi admin!");
            return response()->json([
                "status" => "success",
                "link" => true,
            ]);
        }
        if ($request->stage >= 2 && empty($proyekStage->departemen_proyek)) {
            // $request->stage = 1;
            Alert::error("Error", "Departemen Pada Pasar Dini Belum Diisi !");
        } else if ($request->stage == 2 && $proyekStage->departemen_proyek) {
            $request->stage = 2;
            Alert::success("Success", "Stage berhasil diperbarui");
        }
        if ($request->stage == 4) {
            if ($proyekStage->hps_pagu == 0) {
                Alert::error("Error", "HPS Pagu Belum Diisi !");
                $request->stage = 3;
            } else {
                $request->stage = 4;
            }
        } else if ($request->stage == 5) {
            // if ($dokumenTender->count() == 0) {
            //     // dd($dokumenTender);
            //     Alert::error("Error", "Silahkan Isi Dokumen Tender Terlebih Dahulu !");
            //     // return redirect()->back();
            // } else {
            //     $request->stage = 5;
            // }
            if ($proyekStage->penawaran_tender == 0 && $dokumenTender->count() == 0) {
                Alert::error("Error", "Silahkan Isi Nilai Penawaran dan Dokumen Tender Terlebih Dahulu !");
                $request->stage = 4;
            } else if ($proyekStage->penawaran_tender == 0) {
                Alert::error("Error", "Silahkan Isi Nilai Penawaran Terlebih Dahulu !");
                $request->stage = 4;
            } else if ($dokumenTender->count() == 0) {
                Alert::error("Error", "Silahkan Isi Dokumen Tender Terlebih Dahulu !");
                $request->stage = 4;
            } else {
                $request->stage = 5;
            }
        } elseif ($request->stage == 8) {
            $customer = $proyekStage->ProyekBerjalan->Customer ?? null;
            if (!empty($customer)) {
                $error_msg = collect();
                if (empty($customer->kode_nasabah) && $proyekStage->UnitKerja->dop != 'EA') {
                    $error_msg->push("Kode Nasabah");
                }
                if (empty($customer->email)) {
                    $error_msg->push("Email");
                }
                if (empty($customer->address_1)) {
                    $error_msg->push("Alamat");
                }
                if (empty($customer->kode_pos)) {
                    $error_msg->push("Kode Pos");
                }
                if (empty($customer->fax)) {
                    $error_msg->push("Fax");
                }
                if (empty($customer->phone_number)) {
                    $error_msg->push("No Telp");
                }
                if (empty($customer->handphone)) {
                    $error_msg->push("Handphone");
                }
                if (empty($customer->industry_sector)) {
                    $error_msg->push("Industry Sector");
                }
                if (empty($customer->jenis_instansi)) {
                    $error_msg->push("Instansi");
                }
                if (empty($customer->jenis_perusahaan)) {
                    $error_msg->push("Jenis Perusahaan");
                }
                if (empty($customer->provinsi)) {
                    $error_msg->push("Provinsi");
                }
                if (empty($customer->kota_kabupaten) && $proyekStage->UnitKerja->dop != 'EA') {
                    $error_msg->push("Kota/Kabupaten");
                }
                if (empty($customer->npwp_company)) {
                    $error_msg->push("NPWP");
                }
                // if (empty($proyekStage->Departemen)) {
                //     $error_msg->push("Departemen");
                // }
                if (empty($customer->syarat_pembayaran)) {
                    $error_msg->push("Term Payment");
                }
                if ($customer->tax == null) {
                    $error_msg->push("Tax");
                }
                if ($error_msg->isNotEmpty()) {
                    Alert::html("Error - Pelanggan !", "Untuk pindah ke stage terkontrak, pastikan data <b>Pelanggan</b> dengan field <b>" . $error_msg->join(", ", " </b>dan<b> ") . "</b> sudah terisi!", "error")->autoClose(10000);
                    return redirect()->back();
                }
            } else if (empty($customer)) {
                Alert::html("Error - Proyek !", "Untuk pindah ke stage terkontrak, pastikan field <b>Pelanggan</b> pada stage Pasar Dini sudah terpilih!", "error")->autoClose(10000);
                return redirect()->back();
            }
            $sap = $customer->sap;
            $pic = $customer->pic->filter(function ($p) {
                return (!empty($p->nama_pic) && !empty($p->jabatan_pic) && !empty($p->email_pic) && !empty($p->phone_pic));
            })->first();

            if (empty($pic)) {
                Alert::html("Error - PIC Pelanggan !", "Untuk pindah ke stage terkontrak, pastikan mengisi minimal <b>1 PIC Pelanggan</b> !", "error")->autoClose(10000);
                return redirect()->back();
            }

            // dump($sap, $pic);
            // dd();
            if (empty($customer)) {
                Alert::error("Error", "Pastikan Data Pelanggan sudah terisi!")->autoClose(10000);
                return redirect()->back();
            }
            // http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm_dev
            // Begin :: Ngirim data ke nasabah online WIKA
            $provinsi = Provinsi::where("province_name", "=", $customer->provinsi)->first() ?? Provinsi::find($customer->provinsi);
            if (empty($provinsi)) {
                Alert::html("Error", "Pastikan <b>Provinsi</b> pada Field <b>Pelanggan</b> sudah terisi!", "error")->autoClose(10000);
                return redirect()->back();
            }

            $proyekStage->is_need_approval_terkontrak = true;

            if ($proyekStage->nilai_perolehan != null && $proyekStage->porsi_jo != null) {
                $nilaiPerolehan = (int) str_replace('.', '', $proyekStage->nilai_perolehan);
                $kontrakKeseluruhan = ($nilaiPerolehan * 100) / (float) $proyekStage->porsi_jo;

                $proyekStage->nilai_kontrak_keseluruhan = round($kontrakKeseluruhan);
                $proyekStage->save();
            }
            if ($proyekAttach->count() == 0) {
                Alert::error("Error", "Silahkan Isi Attachment Menang Terlebih Dahulu !");
                return redirect()->back();
            } else {
                $contractManagements = ContractManagements::get()->where("project_id", "=", $proyekStage->kode_proyek)->first();
                // $request->stage = 6;
                if (!empty($contractManagements)) {
                    $contractManagements->stages = (int) 2;
                    $contractManagements->save();
                }
            }
        };

        if (!$request->is_ajax) {
            $data = $request->all();

            if ($proyekStage->stage == 8) {
                Alert::error("Error", "Proyek sudah tidak dapat dikembalikan. Hubungi admin!");
                return redirect()->back();
            }

            // Check kalo variable di bawah ini ada
            if (!empty($data["stage-menang"]) && $data["stage-menang"] == "Menang") {
                if ($proyekStage->nilai_perolehan == 0) {
                    Alert::error("Error", "Nilai Perolehan Belum Diisi !");
                    return redirect()->back();
                } else {
                    $request->stage = 6;
                }
            } elseif (!empty($data["stage-kalah"]) && $data["stage-kalah"] == "Kalah") {
                $proyekStage->nilai_perolehan = 0;
                $proyekStage->save();

                if (!empty($forecasts)) {
                    $forecasts->realisasi_forecast = 0;
                    $forecasts->save();
                }

                $request->stage = 7;
            } elseif (!empty($data["stage-terkontrak"]) && $data["stage-terkontrak"] == "Terkontrak") {
                $customer = $proyekStage->ProyekBerjalan->Customer ?? null;
                if (!empty($customer)) {
                    $error_msg = collect();
                    if (empty($customer->kode_nasabah) && $proyekStage->UnitKerja->dop != 'EA') {
                        $error_msg->push("Kode Nasabah");
                    }
                    if (empty($customer->email)) {
                        $error_msg->push("Email");
                    }
                    if (empty($customer->address_1)) {
                        $error_msg->push("Alamat");
                    }
                    if (empty($customer->kode_pos)) {
                        $error_msg->push("Kode Pos");
                    }
                    if (empty($customer->fax)) {
                        $error_msg->push("Fax");
                    }
                    if (empty($customer->phone_number)) {
                        $error_msg->push("No Telp");
                    }
                    if (empty($customer->handphone)) {
                        $error_msg->push("Handphone");
                    }
                    if (empty($customer->industry_sector)) {
                        $error_msg->push("Industry Sector");
                    }
                    if (empty($customer->jenis_instansi)) {
                        $error_msg->push("Instansi");
                    }
                    if (empty($customer->jenis_perusahaan)) {
                        $error_msg->push("Jenis Perusahaan");
                    }
                    if (empty($customer->provinsi)) {
                        $error_msg->push("Provinsi");
                    }
                    if (empty($customer->kota_kabupaten) && $proyekStage->UnitKerja->dop != 'EA') {
                        $error_msg->push("Kota/Kabupaten");
                    }
                    if (empty($customer->npwp_company)) {
                        $error_msg->push("NPWP");
                    }
                    // if (empty($proyekStage->Departemen)) {
                    //     $error_msg->push("Departemen");
                    // }
                    if (empty($customer->syarat_pembayaran)) {
                        $error_msg->push("Term Payment");
                    }
                    if ($customer->tax == null) {
                        $error_msg->push("Tax");
                    }
                    if ($error_msg->isNotEmpty()) {
                        Alert::html("Error - Pelanggan !", "Untuk pindah ke stage terkontrak, pastikan data <b>Pelanggan</b> dengan field <b>" . $error_msg->join(", ", " </b>dan<b> ") . "</b> sudah terisi!", "error")->autoClose(10000);
                        return redirect()->back();
                    }
                } else if (empty($customer)) {
                    Alert::html("Error - Proyek !", "Untuk pindah ke stage terkontrak, pastikan field <b>Pelanggan</b> pada stage Pasar Dini sudah terpilih!", "error")->autoClose(10000);
                    return redirect()->back();
                }
                $sap = $customer->sap;
                $pic = $customer->pic->filter( function ($p) {
                    return (!empty($p->nama_pic) && !empty($p->jabatan_pic) && !empty($p->email_pic) && !empty($p->phone_pic));
                })->first();

                if (empty($pic)) {
                    Alert::html("Error - PIC Pelanggan !", "Untuk pindah ke stage terkontrak, pastikan mengisi minimal <b>1 PIC Pelanggan</b> !", "error")->autoClose(10000);
                    return redirect()->back();
                }

                // dump($sap, $pic);
                // dd();
                if (empty($customer)) {
                    Alert::error("Error", "Pastikan Data Pelanggan sudah terisi!")->autoClose(10000);
                    return redirect()->back();
                }
                // http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm_dev
                // Begin :: Ngirim data ke nasabah online WIKA
                $provinsi = Provinsi::where("province_name", "=", $customer->provinsi)->first() ?? Provinsi::find($customer->provinsi);
                if (empty($provinsi)) {
                    Alert::html("Error", "Pastikan <b>Provinsi</b> pada Field <b>Pelanggan</b> sudah terisi!", "error")->autoClose(10000);
                    return redirect()->back();
                }
                // dd($customer);
                $grouping = "";
                $kdgrp = "";
                $ktgrd = "";
                $cust_akont = "";
                $witht = "";
                if($customer->jenis_instansi == "Kementrian / Pemerintah Pusat" || $customer->jenis_instansi == "Pemerintah Provinsi" || $customer->jenis_instansi == "Pemerintah Kota / Kabupaten") {
                    $kdgrp = "03";
                    $grouping = "ZN01";
                    $ktgrd = "Z1";
                    $cust_akont = "1104111000";
                    $witht = "J7";
                } else if($customer->jenis_instansi == "BUMN") {
                    $kdgrp = "04";
                    $grouping = "ZN01";
                    $ktgrd = "Z1";
                    $cust_akont = "1104111000";
                    $witht = "J7";
                } else if($customer->jenis_instansi == "BUMD" || $customer->jenis_instansi == "Swasta Nasional") {
                    $kdgrp = "05";
                    $grouping = "ZN02";
                    $ktgrd = "Z2";
                    $cust_akont = "1104211000";
                    $witht = "J7";
                } else if($customer->jenis_instansi == "Pemerintah Asing" || $customer->jenis_instansi == "Swasta Asing") {
                    $kdgrp = "06";
                    $grouping = "ZN02";
                    $ktgrd = "Z2";
                    $cust_akont = "1104211000";
                    $witht = "J7";
                } else if($customer->jenis_instansi == "Perusahaan JO") {
                    $kdgrp = "08";
                    $grouping = "ZN05";
                    $ktgrd = "Z4";
                    $cust_akont = "";
                    $witht = "";
                }

                if ($proyekStage->UnitKerja->dop != 'EA') {
                    $data_nasabah_online = collect([
                        "nmnasabah" => "$customer->name",
                        "alamat" => "$customer->address_1",
                        "kota" => "$customer->kota_kabupaten",
                        "email" => "$customer->email",
                        "ext" => "-",
                        "telepon" => "$customer->phone_number",
                        "fax" => "$customer->fax",
                        "npwp" => "$customer->npwp_company",
                        "nama_kontak" => $pic->nama_pic ?? "",
                        "jenisperusahaan" => "$customer->jenis_instansi",
                        "jabatan" => $pic->jabatan_pic ?? "",
                        "email1" => $pic->email_pic ?? "",
                        "telpon1" => $pic->phone_pic ?? "",
                        "handphone" => $pic->phone_pic ?? "",
                        "tipe_perusahaan" => "$customer->jenis_perusahaan",
                        "tipe_lain_perusahaan" => "-",
                        "cotid" => "11",
                        "dtsap" => [
                            [
                                "devid" => "YMMI002",
                                "packageid" => $this->GUID(),
                                "cocode" => "A000",
                                "prctr" => "",
                                // "timestamp" => "20221013100000",
                                "timestamp" => date("y") . date("m") . date("d") . "10000",
                                "data" => [
                                    [
                                        "BPARTNER" => "$customer->kode_nasabah",

                                        "GROUPING" => "$grouping",

                                        "LVORM" => "",

                                        "TITLE" => "Z001",

                                        "NAME" => "$customer->name",

                                        "TITLELETTER" => "",

                                        "SEARCHTERM1" => substr($customer->name, 0, 40) ?? "",

                                        "SEARCHTERM2" => substr($customer->name, 0, 40) ?? "",

                                        "STREET" => $sap->street ?? "",

                                        "HOUSE_NO" => "",

                                        "POSTL_COD1" => "$customer->kode_pos",

                                        "CITY" => explode("-", $provinsi->province_id)[1],

                                        // "ADDR_COUNTRY" => $provinsi->country_id ?? "ID",
                                        "ADDR_COUNTRY" => "ID",

                                        "REGION" => explode("-", $provinsi->province_id)[1],

                                        "PO_BOX" => "",

                                        "POSTL_COD3" => "",

                                        "LANGU" => "E",

                                        "TELEPHONE" => "$customer->phone_number",

                                        "PHONE_EXTENSION" => "",

                                        "MOBPHONE" => "$customer->handphone",

                                        "FAX" => "$customer->fax",

                                        "FAX_EXTENSION" => "",

                                        "E_MAIL" => "$customer->email",

                                        "VALIDFROMDATE" => now()->translatedFormat("d-m-Y"),

                                        "VALIDTODATE" => now()->addMonths(5)->translatedFormat("d-m-Y"),

                                        "IDENTIFICATION" => [
                                            [

                                                // "TAXTYPE" => "$sap->tax_number_category",
                                                "TAXTYPE" => $provinsi->country_id == "ID" ? "ID1" : "ID2",

                                                "TAXNUMBER" => "$customer->npwp_company"
                                            ]
                                        ],

                                        "BANK" => [
                                            [
                                                "BANK_DET_ID" => "",

                                                "BANK_CTRY" => "",

                                                "BANK_KEY" => "CRM",

                                                "BANK_ACCT" => "",

                                                "BK_CTRL_KEY" => "",

                                                "BANK_REF" => "",

                                                "EXTERNALBANKID" => "",

                                                "ACCOUNTHOLDER" => "",

                                                "BANKACCOUNTNAME" => ""
                                            ]
                                        ],

                                        "CUST_BUKRS" => "",

                                        "KUNNR" => "",

                                        "CUST_AKONT" => "$cust_akont",

                                        "CUST_C_ZTERM" => "$customer->syarat_pembayaran",

                                        "CUST_WTAX" => [
                                            [

                                                "WITHT" => "$witht",

                                                "WT_AGENT" => "",

                                                "WT_AGTDF" => "",

                                                "WT_AGTDT" => ""
                                            ]
                                        ],

                                        "VKORG" => "",

                                        "VTWEG" => "",

                                        "SPART" => "",

                                        "KDGRP" => "$kdgrp",

                                        "CUST_WAERS" => "IDR",

                                        "KALKS" => "",

                                        "VERSG" => "",

                                        "VSBED" => "",

                                        "INCO1" => "",

                                        "INCO2_L" => "",

                                        "CUST_S_ZTERM" => "$customer->syarat_pembayaran",

                                        "KTGRD" => "$ktgrd",

                                        "TAXKD" => "$customer->tax",

                                        "VEND_BUKRS" => "",

                                        "LIFNR" => "",

                                        "VEND_AKONT" => "",

                                        "VEND_C_ZTERM" => "",

                                        "REPRF" => "X",

                                        "VEND_WTAX" => [[]],
                                        // "VEND_WTAX" => [

                                        //     "WITHT" => "J3",

                                        //     "WT_SUBJCT" => "X"

                                        // ],

                                        "EKORG" => "",

                                        "VEND_P_ZTERM" => "",

                                        "WEBRE" => "",

                                        "VEND_WAERS" => "",

                                        "LEBRE" => "",

                                        "BRAN2" => $customer->IndustrySector->id_industry_sector,
                                    ]
                                ]
                            ]
                        ]
                    ]);

                    $proyekStage->is_need_approval_terkontrak = true;
                }
                // dd($data_nasabah_online);
                // End :: Ngirim data ke nasabah online WIKA

                // dd($proyekStage->nilai_perolehan, $proyekStage->porsi_jo, $proyekStage->nilai_kontrak_keseluruhan);
                if ($proyekStage->nilai_perolehan != null && $proyekStage->porsi_jo != null) {
                    $nilaiPerolehan = (int) str_replace('.', '', $proyekStage->nilai_perolehan);
                    $kontrakKeseluruhan = ($nilaiPerolehan * 100) / (float) $proyekStage->porsi_jo;

                    $proyekStage->nilai_kontrak_keseluruhan = round($kontrakKeseluruhan);
                    $proyekStage->save();
                }
                if ($proyekAttach->count() == 0) {
                    Alert::error("Error", "Silahkan Isi Attachment Menang Terlebih Dahulu !");
                    return redirect()->back();
                } else {
                    $contractManagements = ContractManagements::get()->where("project_id", "=", $proyekStage->kode_proyek)->first();
                    // if (str_contains(URL::full() , 'crm.wika.co.id')) {
                    //     // setLogging();
                    //     if ($proyekStage->UnitKerja->dop != 'EA') {
                    //         $nasabah_online_response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm", $data_nasabah_online)->json();
                    //         setLogging("Send_Nasabah_Online", "[Nasabah Online => $customer->name] => ", $data_nasabah_online->toArray());
                    //         // dd($nasabah_online_response);
                    //         if (!$nasabah_online_response["status"] && !str_contains($nasabah_online_response["msg"], "sudah ada dalam nasabah online")) {
                    //             Alert::error("Error", $nasabah_online_response["msg"]);
                    //             return redirect()->back();
                    //         }
                    //         // $nasabah_online_response = Http::post("http://nasabah.wika.co.id/index.php/mod_excel/post_json_crm_dev", $data_nasabah_online)->json();
                    //     }
                    //     $request->stage = 8;
                    //     if (!empty($contractManagements)) {
                    //             $contractManagements->stages = (int) 2;
                    //         $contractManagements->save();
                    //     }
                    // } else {
                        $request->stage = 8;
                        if (!empty($contractManagements)) {
                                $contractManagements->stages = (int) 2;
                            $contractManagements->save();
                        }
                    // }
                }
            } elseif (!empty($data["stage-terendah"]) && $data["stage-terendah"] == "Terendah") {
                if ($proyekAttach->count() == 0) {
                    Alert::error("Error", "Silahkan Isi Attachment Menang Lebih Dahulu !");
                    return redirect()->back();
                } else {
                    $request->stage = 9;
                }
            } else if (isset($data["stage-tidak-lulus-pq"])) {
                $proyekStage->is_tidak_lulus_pq = true;
                $request->stage = 3;
            } else if (isset($data["stage-prakualifikasi"])) {
                $proyekStage->is_tidak_lulus_pq = false;
                $request->stage = 3;
            }
        }
        $proyekStage->stage = $request->stage;

        $teamProyek = TeamProyek::where('kode_proyek', "=", $proyekStage->kode_proyek)->get();
        if ($teamProyek != null) {
            $teamProyek->each(function ($stage) use ($proyekStage) {
                if ($proyekStage->stage > 8) {
                    $stage->proyek_selesai = true;
                    $stage->save();
                }
            });
        }

        $proyekBerjalans = ProyekBerjalans::where('kode_proyek', "=", $proyekStage->kode_proyek)->get()->first();
        if ($proyekBerjalans == null) {
            $proyekStage->save();
            if ($request->is_ajax) {
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }
            Alert::success("Success", "Stage berhasil diperbarui");
            return back();
        } else {
            $proyekBerjalans->stage = $request->stage;
            $proyekBerjalans->save();
            $proyekStage->save();
            if ($request->is_ajax) {
                return response()->json([
                    "status" => "success",
                    "link" => true,
                ]);
            }
            Alert::success("Success", "Stage berhasil diperbarui");
            return back();
        }

        Alert::error("Error", "Stage gagal diperbarui");
        return back();
    }

    public function getKriteria(Request $request)
    {
        $data = $request->all();
        $kriteria = KriteriaPasar::where("kategori", "=", $data["kategori"])->get();
        // $kriteria = KriteriaPasar::select("kriteria", "bobot")->where("kategori", "=", $data["kategori"])->get();
        // dd($kriteria);
        return $kriteria->toJson();
    }

    public function tambahKriteria(Request $request)
    {
        $dataKriteria = $request->all();
        // dd($dataKriteria);

        $arrayKategori = collect($dataKriteria["kategori-pasar"]);
        $arrayKriteria = collect($dataKriteria["kriteria-pasar"]);
        $arrayBobot = collect($dataKriteria["bobot"]);
        $kodeProyek = $dataKriteria["data-kriteria-proyek"];

        $isKriteriaNull = $arrayKriteria->contains(function ($kriteria) {
            return $kriteria == null;
        });

        if ($isKriteriaNull) {
            Alert::error('Error', "Kriteria Pasar Gagal Ditambahkan, Periksa Kembali !");
            return redirect()->back();
        }
        // dd($isKriteriaNull, $arrayKriteria);



        for ($i = 0; $i < count($arrayKategori); $i++) {
            $newKriteria = new KriteriaPasarProyek();
            // dd($newKriteria);

            // $messages = [
            //     "required" => "*Kolom Ini Harus Diisi !",
            // ];
            // $rules = [
            //     $kodeProyek[$i] => "required",
            //     $arrayKategori[$i] => "required",
            //     $arrayKriteria[$i] => "required",
            // ];
            // $validation = Validator::make($newKriteria, $rules, $messages);
            // if ($validation->fails()) {
            //     Alert::error('Error', "Kriteria Pasar Gagal Ditambahkan, Periksa Kembali !");
            // }
            // $validation->validate();

            $newKriteria->kode_proyek = $kodeProyek;
            $newKriteria->kategori = $arrayKategori[$i];
            $newKriteria->kriteria = $arrayKriteria[$i];
            $newKriteria->bobot = $arrayBobot[$i];
            $newKriteria->save();
        }

        // $newKriteria->kode_proyek = $dataKriteria["data-kriteria-proyek"];
        // $newKriteria->kategori = $dataKriteria["kategori-pasar"];
        // $newKriteria->kriteria = $dataKriteria["kriteria-pasar"];
        // $newKriteria->bobot = $dataKriteria["bobot"];
        // foreach ($dataKriteria as $key => $kriteria) {
        //     dd($dataKriteria, $key, $kriteria);
        // }

        // $newKriteria->save();
        Alert::success("Success", "Kriteria Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function editKriteria(Request $request, $id)
    {
        $dataKriteria = $request->all();
        $newKriteria = KriteriaPasarProyek::find($id);
        $newKriteria->kode_proyek = $dataKriteria["edit-kriteria-proyek"];
        $newKriteria->kategori = $dataKriteria["edit-kategori-pasar"];
        $newKriteria->kriteria = $dataKriteria["edit-kriteria-pasar"];
        $newKriteria->bobot = $dataKriteria["edit-bobot"];

        $newKriteria->save();
        Alert::success("Success", "Kriteria Berhasil Diubah");
        return redirect()->back();
    }

    public function deleteKriteria($id)
    {
        $deleteKriteria = KriteriaPasarProyek::find($id);
        // dd($deleteKriteria);
        $deleteKriteria->delete();
        Alert::success("Success", "Kriteria Berhasil Dihapus");
        return redirect()->back();
    }

    public function tambahJO(Request $request, PorsiJO $newPorsiJO)
    {
        $dataPorsiJO = $request->all();
        // dd($dataPorsiJO);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "company-jo" => "required",
            "porsijo-company" => "required",
            "kekuatan-partner" => "required",
            "kelemahan-partner" => "required",
        ];
        $validation = Validator::make($dataPorsiJO, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Partner JO Gagal Dibuat, Periksa Kembali !");
        }
        $validation->validate();
        $customer = Customer::find($dataPorsiJO["company-jo"]);

        $file = $request->file('file-consent-npwp');

        $newPorsiJO->kode_proyek = $dataPorsiJO["porsi-kode-proyek"];
        $newPorsiJO->company_jo = $customer->name;
        $newPorsiJO->id_company_jo = $customer->id_customer;
        $newPorsiJO->porsi_jo = $dataPorsiJO["porsijo-company"];
        $newPorsiJO->kekuatan_partner = $dataPorsiJO["kekuatan-partner"];
        $newPorsiJO->kelemahan_partner = $dataPorsiJO["kelemahan-partner"];

        //Check Partner di Master BUMN
        $kriteria_partner = MasterGrupTierBUMN::where('id_pelanggan', $customer->id_customer)->first();

        //Check Partner di Master Kriteria Greenlane Partner
        $kriteria_partner_greenlane = MasterKriteriaGreenlanePartner::where('id_pelanggan', $customer->id_customer)->first();

        if (!empty($kriteria_partner)) {
            $newPorsiJO->is_greenlane = true;
            $newPorsiJO->is_disetujui = true;
            $newPorsiJO->is_hasil_assessment = true;
            $newPorsiJO->hasil_assessment = "Disetujui";
        } else {
            if ($kriteria_partner_greenlane) {
                $newPorsiJO->is_greenlane = true;
                $newPorsiJO->is_disetujui = true;
                $newPorsiJO->is_hasil_assessment = true;
                $newPorsiJO->hasil_assessment = "Disetujui";
            } else {
                $newPorsiJO->is_greenlane = false;
            }            
        }

        if (!$newPorsiJO->is_greenlane) {
            //Check Partner di Pefindo
            $checkPefindo = MasterPefindo::where('id_pelanggan', $dataPorsiJO['company-jo'])->first();

            if (!empty($checkPefindo)) {
                $newPorsiJO->score_pefindo_jo = $checkPefindo->score;
                $newPorsiJO->file_pefindo_jo = $checkPefindo->id_document;
                $newPorsiJO->grade = $checkPefindo->grade;
                $newPorsiJO->keterangan = $checkPefindo->keterangan;

                if (str_contains($checkPefindo->grade, 'E')) {
                    $newPorsiJO->is_disetujui = false;
                } else {
                    $newPorsiJO->is_disetujui = true;
                }
            }
        }


        // $newPorsiJO->max_jo = $dataPorsiJO["max-porsi"];
        $nama_file = collect([]);
        if (empty($file)) {
            Alert::error('Error', 'Silahkan upload Dokumen terlebih dahulu!');
            return redirect()->back();
        }
        foreach ($file as $f) {
            $id_document = date("His_") . str_replace(' ', '_', $f->getClientOriginalName());
            $nama_file->push($id_document);
            $f->move(public_path('consent-npwp'), $id_document);
        }
        $newPorsiJO->file_consent_npwp = $nama_file;

        

        $proyek = Proyek::find($dataPorsiJO["porsi-kode-proyek"]);
        $proyek->porsi_jo = $dataPorsiJO["sisa-input"] ?? 100;
        // dd($proyek->porsi_jo);

        if ($proyek->nilai_perolehan != null && $proyek->stage == 8) {
            $nilaiPerolehan = (int) str_replace('.', '', $proyek->nilai_perolehan);
            $kontrakKeseluruhan = ($nilaiPerolehan * 100) / $proyek->porsi_jo;

            $proyek->nilai_kontrak_keseluruhan = round($kontrakKeseluruhan);
        } else {
            $proyek->nilai_kontrak_keseluruhan = 0;
        }



        if (($dataPorsiJO["sisa-input"] + $dataPorsiJO["porsijo-company"]) > 100) {
            // dd($dataPorsiJO["sisa-input"], $dataPorsiJO["porsijo-company"]); 
            Alert::error('Error', "Partner JO Gagal Ditambahkan, Hubungi Admin !");
            return redirect()->back();
        }
        // dd($dataPorsiJO);

        $proyek->save();
        $newPorsiJO->save();
        Alert::success("Success", "Porsi JO Berhasil Ditambahkan");

        return redirect()->back();
    }

    public function editJO(Request $request, $id)
    {
        $dataPorsiJO = $request->all();
        // dd($dataPorsiJO);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "company-jo" => "required",
            "porsijo-company" => "required",
        ];
        $validation = Validator::make($dataPorsiJO, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Partner JO Gagal Diubah, Periksa Kembali !");
        }
        $validation->validate();

        $editPorsiJO = PorsiJO::find($id);

        $editPorsiJO->kode_proyek = $dataPorsiJO["porsi-kode-proyek"];
        $editPorsiJO->company_jo = $dataPorsiJO["company-jo"];
        $editPorsiJO->porsi_jo = $dataPorsiJO["porsijo-company"];
        // $editPorsiJO->max_jo = $dataPorsiJO["max-porsi"];

        $proyek = Proyek::find($dataPorsiJO["porsi-kode-proyek"]);
        $sisaJo = ($proyek->porsi_jo + $dataPorsiJO["porsijo-company-sebelumnya"]) - $dataPorsiJO["porsijo-company"];
        $proyek->porsi_jo = $sisaJo;

        if (($sisaJo + $dataPorsiJO["porsijo-company"]) > 100) {
            // dd($dataPorsiJO["sisa-input"], $dataPorsiJO["porsijo-company"]); 
            Alert::error('Error', "Partner JO Gagal Diubah, Hubungi Admin !");
            return redirect()->back();
        }
        $proyek->save();
        $editPorsiJO->save();
        Alert::success("Success", "Porsi JO Berhasil Diubah");

        return redirect()->back();
    }

    public function deleteJO($id)
    {
        $deleteJO = PorsiJO::find($id);
        $proyek = Proyek::find($deleteJO->kode_proyek);
        $dokumenKelengkapanPartner = DokumenKelengkapanPartnerKSO::where('kode_proyek', $deleteJO->kode_proyek)->where('id_partner', $deleteJO->id)->get();
        // dd($deleteJO->porsi_jo, $deleteJO->kode_proyek);
        $filesKelengkapan = $dokumenKelengkapanPartner->mapWithKeys(function ($item, $key) {
            return [$item->kategori => $item->id_document];
        });
        $maxPorsiJo = $proyek->porsi_jo + $deleteJO->porsi_jo;
        $files = collect(json_decode($deleteJO->file_consent_npwp));
        if ($maxPorsiJo > 100) {
            // dd($maxPorsiJo);
            $proyek->porsi_jo = 100;
            $proyek->save();
            $deleteJO->delete();
            
            Alert::warning('Error', "Partner JO Berhasil Dihapus, Hubungi Admin !");
            return redirect()->back();
        }
        $proyek->porsi_jo = $maxPorsiJo;
        
        $proyek->save();
        $deleteJO->delete();
        $dokumenKelengkapanPartner->each(function ($item) {
            return $item->delete();
        });
        try {
            if ($filesKelengkapan->isNotEmpty()) {
                $filesKelengkapan->each(function ($file, $key) {
                    $formatKeyToFolder = strtolower(str_replace(' ', '-', $key));
                    File::delete(public_path(public_path("dokumen-kelengkapan-partner/$formatKeyToFolder/$file")));
                });
            }
            if ($files->isNotEmpty()) {
                $files->each(function ($file) {
                    File::delete(public_path(public_path("consent-npwp/$file")));
                });
            }
            Alert::success("Success", "Partner JO Berhasil Dihapus");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function uploadDokumenKelengkapanPartner(Request $request, $id_partner)
    {
        $partnerJO = PorsiJO::find($id_partner);

        if (empty($partnerJO)) {
            Alert::error("Error", "Partner Tidak Ditemukan. Hubungi Admin!");
            return redirect()->back();
        }

        $data = $request->all();
        $collectData = collect([]);

        if (isset($data["dokumen-ahu-partner"])) {
            $nama_file = $data["dokumen-ahu-partner"]->getClientOriginalName();
            $id_document = date("His_") . str_replace(' ', '_', $nama_file);
            $data["dokumen-ahu-partner"]->move(public_path('dokumen-kelengkapan-partner/dokumen-ahu'), $id_document);

            $collectData->push([
                "kategori" => "Dokumen AHU",
                "id_partner" => $id_partner,
                "kode_proyek" => $partnerJO->kode_proyek,
                "id_document" => $id_document,
                "nama_document" => $nama_file,
            ]);
        }

        if (isset($data["dokumen-keuangan-partner"])) {
            $nama_file = $data["dokumen-keuangan-partner"]->getClientOriginalName();
            $id_document = date("His_") . str_replace(' ', '_', $nama_file);
            $data["dokumen-keuangan-partner"]->move(public_path('dokumen-kelengkapan-partner/dokumen-laporan-keuangan'), $id_document);

            $collectData->push([
                "kategori" => "Dokumen Laporan Keuangan",
                "id_partner" => $id_partner,
                "kode_proyek" => $partnerJO->kode_proyek,
                "id_document" => $id_document,
                "nama_document" => $nama_file,
            ]);
        }

        if (isset($data["dokumen-pengalaman-partner"])) {
            $nama_file = $data["dokumen-pengalaman-partner"]->getClientOriginalName();
            $id_document = date("His_") . str_replace(' ', '_', $nama_file);
            $data["dokumen-pengalaman-partner"]->move(public_path('dokumen-kelengkapan-partner/dokumen-pengalaman'), $id_document);

            $collectData->push([
                "kategori" => "Dokumen Pengalaman",
                "id_partner" => $id_partner,
                "kode_proyek" => $partnerJO->kode_proyek,
                "id_document" => $id_document,
                "nama_document" => $nama_file,
            ]);
        }

        if (isset($data["dokumen-spt-partner"])) {
            $nama_file = $data["dokumen-spt-partner"]->getClientOriginalName();
            $id_document = date("His_") . str_replace(' ', '_', $nama_file);
            $data["dokumen-spt-partner"]->move(public_path('dokumen-kelengkapan-partner/dokumen-laporan-spt'), $id_document);

            $collectData->push([
                "kategori" => "Dokumen Laporan SPT",
                "id_partner" => $id_partner,
                "kode_proyek" => $partnerJO->kode_proyek,
                "id_document" => $id_document,
                "nama_document" => $nama_file,
            ]);
        }

        try {
            DokumenKelengkapanPartnerKSO::insert($collectData->toArray());
            Alert::success('Success', "Dokumen berhasil diupload");
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage());
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function downloadDokumenKelengkapanPartner($id_kelengkapan)
    {
        $getDokumen = DokumenKelengkapanPartnerKSO::find($id_kelengkapan);
        if (empty($getDokumen)) {
            Alert::error('Error', "Dokumen tidak ditemukan. Hubungi Admin!");
            return redirect()->back();
        }
        $kategori = strtolower(str_replace(' ', '-', $getDokumen->kategori));
        $id_document = $getDokumen->id_document;

        return response()->download(public_path("dokumen-kelengkapan-partner/$kategori/$id_document"), $getDokumen->nama_document);
    }

    public function deleteDokumenKelengkapanPartner(Request $request, $id)
    {
        $getDokumen = DokumenKelengkapanPartnerKSO::find($id);

        if (empty($getDokumen)) {
            Alert::error('Error', "Dokumen tidak ditemukan. Hubungi Admin!");
            return redirect()->back();
        }

        if ($getDokumen->delete()) {
            try {
                File::delete(public_path("consent-npwp/$getDokumen->id_document"));
                return response()->json([
                    "Success" => true,
                    "Message" => null
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "Success" => false,
                    "Message" => $e->getMessage()
                ]);
            }
        }
    }

    public function updatePefindoExpired(PorsiJO $partner)
    {

        try {
            if (empty($partner)) {
                return response()->json([
                    'Success' => false,
                    'Message' => 'Data tidak ditemukan'
                ], 400);
            }

            $pefindoSelectedActive = MasterPefindo::where('id_pelanggan', $partner->id_company_jo)->where('is_active', true)->first();

            if (empty($pefindoSelectedActive)) {
                return response()->json([
                    'Success' => false,
                    'Message' => 'Data pefindo tidak ditemukan'
                ], 400);
            }

            $partner->score_pefindo_jo = $pefindoSelectedActive->score;
            $partner->file_pefindo_jo = $pefindoSelectedActive->id_document;
            $partner->grade = $pefindoSelectedActive->grade;
            $partner->keterangan = $pefindoSelectedActive->keterangan;
            if (str_contains($pefindoSelectedActive->grade, "E")) {
                $partner->is_disetujui = false;
            }

            if ($partner->save()) {
                return response()->json([
                    'Success' => true,
                    'Message' => 'Data berhasil diperbaharui'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => $e->getMessage()
            ], 400);
        }
    }

    public function assignTeam(Request $request, TeamProyek $newTeam)
    {
        $assignTeam = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nama-team" => "required",
            "role-team" => "required",
        ];
        $validation = Validator::make($assignTeam, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Assign Personil Gagal, Periksa Kembali !");
        }
        $validation->validate();
        $newTeam->id_user = $assignTeam["nama-team"];
        $newTeam->role = $assignTeam["role-team"];
        $newTeam->kode_proyek = $assignTeam["assign-kode-proyek"];

        $newTeam->save();
        Alert::success("Success", "Team Berhasil Di-Assign");
        return redirect()->back();
    }

    public function deleteTeam($id)
    {
        $deleteTeam = TeamProyek::find($id);
        $deleteTeam->delete();
        Alert::success("Success", "Team Berhasil Dihapus");
        return redirect()->back();
    }

    public function tambahTender(Request $request,  PesertaTender $newTender)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "peserta-tender" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Peserta Tender Gagal Ditambahkan, Periksa Kembali !");
        }

        $validation->validate();
        $newTender->peserta_tender = $data["peserta-tender"];
        $newTender->kode_proyek = $data["tender-kode-proyek"];
        // if ($data["stage-proyek"] >= 5) {
        //     $newTender->nilai_tender_peserta = $data["nilai-tender"];
        //     $newTender->status = $data["status-tender"];
        //     $oe_wika = 0;
        //     if (!empty($data["nilai-tender"]) && !empty($data["tender-pagu"])) {
        //         $nilai_tender = (int)  str_replace('.', '', $data["nilai-tender"]);
        //         $nilai_pagu = (int)  str_replace('.', '', $data["tender-pagu"]);
        //         $oe_wika = ($nilai_tender / $nilai_pagu) * 100;
        //     };
        //     $newTender->oe_tender = (int) number_format($oe_wika, 0, "", "");
        // }
        $newTender->save();
        Alert::success("Success", "Peserta Tender Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function editTender(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        // $messages = [
        //     "required" => "*Kolom Ini Harus Diisi !",
        // ];
        // $rules = [
        //     "edit-peserta-tender" => "required",
        // ];
        // $validation = Validator::make($data, $rules, $messages);
        // if ($validation->fails()) {
        //     Alert::error('Error', "Peserta Tender Gagal Diubah, Periksa Kembali !");
        // }

        // $validation->validate();

        $editTender = PesertaTender::find($id);
        // $editTender->peserta_tender = $data["edit-peserta-tender"];
        $editTender->kode_proyek = $data["tender-kode-proyek"];

        if ($data["stage-proyek"] >= 5) {
            $editTender->nilai_tender_peserta = $data["nilai-tender"];
            $editTender->status = $data["status-tender"];
            $editTender->keterangan = $data["keterangan-tender"];
            $oe_wika = 0;
            $nilai_tender = (int)  str_replace('.', '', $data["nilai-tender"]);
            $nilai_pagu = (int)  str_replace('.', '', $data["tender-pagu"]);
            if (!empty($data["nilai-tender"]) && !empty($data["tender-pagu"])) {
                $oe_wika = ($nilai_tender / $nilai_pagu) * 100;
            };
            $editTender->oe_tender = $oe_wika;
        }

        $editTender->save();
        Alert::success("Success", "Peserta Tender Berhasil Diubah");
        return redirect()->back();
    }

    public function noteTender(Request $request, $id)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "catatan" => "required",
        ];

        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Catatan Peserta Tender Gagal Diubah, Periksa Kembali !");
        }

        $validation->validate();

        $editTender = PesertaTender::find($id);

        $editTender->catatan = $data['catatan'];

        if ($editTender->save()) {
            Alert::success("Success", "Catatan Peserta Tender Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error("Error", "Catatan Peserta Tender Gagal Diubah");
        return redirect()->back();
    }

    public function deleteTender($id)
    {
        $deleteTender = PesertaTender::find($id);
        $deleteTender->delete();
        Alert::success("Success", "Peserta Tender Berhasil Dihapus");
        return redirect()->back();
    }

    public function tambahTimTender(Request $request,  TimTender $newTimTender)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nama_pegawai" => "required",
            "posisi" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Tim Tender Gagal Ditambahkan, Periksa Kembali !");
        }

        $validation->validate();
        $newTimTender->nip_pegawai = $data["nama_pegawai"];
        $newTimTender->posisi = $data["posisi"];
        $newTimTender->kode_proyek = $data["kode-proyek"];

        $newTimTender->save();
        Alert::success("Success", "Tim Tender Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function editTimTender(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nama_pegawai" => "required",
            "posisi" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Tim Tender Gagal Diubah, Periksa Kembali !");
        }

        $validation->validate();

        $editTim = TimTender::find($id);
        $editTim->nip_pegawai = $data["nama_pegawai"];
        $editTim->posisi = $data["posisi"];
        $editTim->kode_proyek = $data["kode-proyek"];

        $editTim->save();
        Alert::success("Success", "Tim Tender Berhasil Diubah");
        return redirect()->back();
    }

    public function deleteTimTender($id)
    {
        $deleteTender = TimTender::find($id);
        $deleteTender->delete();
        Alert::success("Success", "Tim Tender Berhasil Dihapus");
        return redirect()->back();
    }

    public function tambahPersonelTender(Request $request,  PersonelTenderProyek $personel)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nama_pegawai" => "required",
            "kategori_personel" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Personel Tender Gagal Ditambahkan, Periksa Kembali !");
            return redirect()->back();
        }

        $proyek = Proyek::find($data["kode-proyek"]);
        $pelanggan = $proyek->proyekBerjalan->customer;
        $validation->validate();

        if (empty($pelanggan)) {
            Alert::error('Error', "Pelanggan Belum ditentukan. Mohon isi terlebih dahulu !");
            return redirect()->back();
        }

        $personel->nip = $data["nama_pegawai"];
        $personel->kategori = $data["kategori_personel"];
        $personel->kode_proyek = $data["kode-proyek"];

        $personel->save();
        Alert::success("Success", "Personel Tender Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function editPersonelTender(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nama_pegawai" => "required",
            "kategori_personel" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Personel Tender Gagal Diubah, Periksa Kembali !");
        }

        $validation->validate();

        $proyek = Proyek::find($data["kode-proyek"]);
        $pelanggan = $proyek->proyekBerjalan->customer;
        if (empty($pelanggan)) {
            Alert::error('Error', "Pelanggan Belum ditentukan. Mohon isi terlebih dahulu !");
            return redirect()->back();
        }

        $editPersonel = PersonelTenderProyek::find($id);
        if (!empty($editPersonel->dokumen_cv_upload)) {
            File::delete(public_path('dokumen-cv-upload/upload/' . $editPersonel->dokumen_cv_upload));
        }
        $editPersonel->nip = $data["nama_pegawai"];
        $editPersonel->kategori = $data["kategori_personel"];
        $editPersonel->kode_proyek = $data["kode-proyek"];

        $editPersonel->save();
        Alert::success("Success", "Personel Tender Berhasil Diubah");
        return redirect()->back();
    }

    public function deletePersonelTender($id)
    {
        $deletePersonel = PersonelTenderProyek::find($id);
        if (!empty($deletePersonel->dokumen_cv_upload)) {
            File::delete(public_path('dokumen-cv-personel/upload/' . $deletePersonel->dokumen_cv_upload));
        }
        $deletePersonel->delete();
        Alert::success("Success", "Personel Tender Berhasil Dihapus");
        return redirect()->back();
    }

    public function tambahKonsultan(Request $request,  ProyekKonsultanPerencana $newKonsultan)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "konsultan-perencana" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Konsultan Perencana Gagal Ditambahkan, Periksa Kembali !");
        }

        $validation->validate();
        $newKonsultan->nama_konsultan = $data["konsultan-perencana"];
        $newKonsultan->kode_proyek = $data["kode-proyek"];

        $newKonsultan->save();
        Alert::success("Success", "Konsultan Perencana Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function editKonsultan(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "konsultan-perencana" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            Alert::error('Error', "Konsultan Perencana Gagal Diubah, Periksa Kembali !");
        }

        $validation->validate();

        $editKonsultan = ProyekKonsultanPerencana::find($id);
        $editKonsultan->nama_konsultan = $data["konsultan-perencana"];
        $editKonsultan->kode_proyek = $data["kode-proyek"];

        $editKonsultan->save();
        Alert::success("Success", "Konsultan Perencana Berhasil Diubah");
        return redirect()->back();
    }

    public function deleteKonsultan($id)
    {
        $deleteTender = ProyekKonsultanPerencana::find($id);
        $deleteTender->delete();
        Alert::success("Success", "Konsultan Perencana Berhasil Dihapus");
        return redirect()->back();
    }

    public function tambahAlatProyek(Request $request)
    {
        $data = $request->all();
        $collectFile = collect([]);

        $newAlat = new AlatProyek();
        $newAlat->kode_proyek = $data["kode-proyek"];
        $newAlat->nomor_rangka = $data["nomor_rangka"];
        $newAlat->kategori = $data["nomor_rangka"];

        if (isset($data["file_perjanjian"])) {
            $files = $data["file_perjanjian"];

            foreach ($files as $file) {
                $nama_file = $file->getClientOriginalName();
                $id_document = date("His_") . str_replace(' ', '_', $nama_file);
                $file->move(public_path('dokumen-perjanjian-alat'), $id_document);
                $collectFile->push([
                    "id_document" => $id_document,
                    "nama_file" => $nama_file,
                ]);
            }
        }
        $newAlat->id_document = json_encode($collectFile->toArray());


        if ($newAlat->save()) {
            Alert::success('Success', "Alat Berhasil Ditambahkan!");
            return redirect()->back();
        }
        Alert::error('Error', "Alat Gagal Ditambahkan!");
        return redirect()->back();
    }

    public function editAlatProyek(Request $request, AlatProyek $alat)
    {
        $data = $request->all();
        if (empty($alat)) {
            Alert::error('Error', "Data Alat Tidak Dapat Ditemukan, Hubungi Admin!");
            return redirect()->back();
        };
        $collectFile = collect(json_decode($alat->id_document));

        if (isset($data["file_perjanjian"])) {
            $files = $data["file_perjanjian"];

            foreach ($files as $file) {
                $nama_file = $file->getClientOriginalName();
                $id_document = date("His_") . str_replace(' ', '_', $nama_file);
                $file->move(public_path('dokumen-perjanjian-alat'), $id_document);
                $collectFile->push([
                    "id_document" => $id_document,
                    "nama_file" => $nama_file,
                ]);
            }
        }

        $alat->id_document = $collectFile;

        if ($alat->save()) {
            Alert::success('Success', "Alat Berhasil Diubah!");
            return redirect()->back();
        }
        Alert::error('Error', "Alat Gagal Diubah!");
        return redirect()->back();
    }

    public function deleteAlatProyek(AlatProyek $alat)
    {
        if (empty($alat)) {
            return response()->json([
                "Success" => false,
                "Message" => "Data Alat Tidak Dapat Ditemukan, Hubungi Admin!"
            ]);
        }

        $collectFile = collect(json_decode($alat->id_document));
        if ($alat->delete()) {
            try {
                $collectFile->each(function ($file) {
                    File::delete(public_path("dokumen-perjanjian-alat/$file->id_document"));
                });
                return response()->json([
                    "Success" => true,
                    "Message" => "Data Alat Berhasil Dihapus"
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "Success" => false,
                    "Message" => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            "Success" => false,
            "Message" => "Data tidak dapat dihapus. Hubungi Admin!"
        ]);
    }

    public function downloadFilePerjanjianAlat($id, $id_document)
    {
        $getAlat = AlatProyek::find($id);
        if (empty($getAlat)) {
            Alert::error('Error', 'Data Alat tidak ditemukan. Hubungi Admin!');
            return redirect()->back();
        }
        $collectDokumen = collect(json_decode($getAlat->id_document));
        $filterDokumen = $collectDokumen->where('id_document', $id_document)->first();
        if (File::exists(public_path("dokumen-perjanjian-alat/$id_document")) && !empty($filterDokumen)) {
            return response()->download(public_path("dokumen-perjanjian-alat/$id_document"), $filterDokumen->nama_file);
        } else {
            Alert::error('Error', 'File tidak ditemukan. Hubungi Admin!');
            return redirect()->back();
        }
    }

    public function deleteFileAlatProyek(Request $request)
    {
        $data = $request->all();
        $getAlat = AlatProyek::find($data["id"]);

        if (empty($getAlat)) {
            return response()->json([
                "Success" => false,
                "Message" => "Data Alat Tidak Dapat Ditemukan, Hubungi Admin!"
            ]);
        }

        $collectFile = collect(json_decode($getAlat->id_document));

        try {
            $finishCollectFile = $collectFile->reject(function ($file) use ($data) {
                return $file->id_document == $data["id_document"];
            });
            $getAlat->id_document = $finishCollectFile;
            if ($getAlat->save()) {
                File::delete(public_path("dokumen-perjanjian-alat/" . $data['id_document']));
                return response()->json([
                    "Success" => true,
                    "Message" => "Dokumen berhasil dihapus"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "Success" => false,
                "Message" => $e->getMessage()
            ]);
        }
    }

    public function tambahAdendum(Request $request, ProyekAdendum $newAdendum)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nomor-adendum" => "required",
            "nilai-adendum" => "required",
            "pelanggan-adendum" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-adendum");
            $request->old("nilai-adendum");
            $request->old("pelanggan-adendum");
            Alert::error('Error', "History Adendum Gagal Ditambahkan, Periksa Kembali !");
        }
        $validation->validate();

        $newAdendum->kode_proyek = $data["adendum-kode-proyek"];
        $newAdendum->nomor_adendum = $data["nomor-adendum"];
        $newAdendum->nilai_adendum = $data["nilai-adendum"];
        $newAdendum->pelanggan_adendum = $data["pelanggan-adendum"];
        $newAdendum->tanggal_adendum = $data["tanggal-adendum"];
        $newAdendum->tanggal_selesai_proyek = $data["tanggal-selesai-adendum-proyek"];

        $newAdendum->save();
        Alert::success("Success", "History Adendum Berhasil Ditambahkan");
        return redirect()->back();
    }

    public function editAdendum(Request $request, $id)
    {
        $data = $request->all();
        $messages = [
            "required" => "*Kolom Ini Harus Diisi !",
        ];
        $rules = [
            "nomor-adendum" => "required",
            "nilai-adendum" => "required",
            "pelanggan-adendum" => "required",
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            $request->old("nomor-adendum");
            $request->old("nilai-adendum");
            $request->old("pelanggan-adendum");
            Alert::error('Error', "History Adendum Gagal Diubah, Periksa Kembali !");
        }
        $validation->validate();

        $newAdendum = ProyekAdendum::find($id);

        $newAdendum->kode_proyek = $data["adendum-kode-proyek"];
        $newAdendum->nomor_adendum = $data["nomor-adendum"];
        $newAdendum->nilai_adendum = $data["nilai-adendum"];
        $newAdendum->pelanggan_adendum = $data["pelanggan-adendum"];
        $newAdendum->tanggal_adendum = $data["tanggal-adendum"];
        $newAdendum->tanggal_selesai_proyek = $data["tanggal-selesai-adendum-proyek"];

        $newAdendum->save();
        Alert::success("Success", "History Adendum Berhasil Diubah");
        return redirect()->back();
    }
    
    // public function updateRfaDocument($kode_proyek, $kategori)
    // {
    //     $proyek = Proyek::where('kode_proyek', '=', $kode_proyek)->first();
    //     switch ($kategori) {
    //         case "nda":
    //             $proyek->is_rfa_nda = true;
    //             $proyek->tgl_rfa_nda = new DateTime();
    //             break;
    //         case "mou":
    //             $proyek->is_rfa_mou = true;
    //             $proyek->tgl_rfa_mou = new DateTime();
    //             break;
    //         case "eca":
    //             $proyek->is_rfa_eca = true;
    //             $proyek->tgl_rfa_eca = new DateTime();
    //             break;
    //         case "ica":
    //             $proyek->is_rfa_ica = true;
    //             $proyek->tgl_rfa_ica = new DateTime();
    //             break;
    //         case "rks":
    //             $proyek->is_rfa_rks = true;
    //             $proyek->tgl_rfa_rks = new DateTime();
    //             break;
    //         case "itb-tor":
    //             $proyek->is_rfa_itb_tor = true;
    //             $proyek->tgl_rfa_itb_tor = new DateTime();
    //             break;
    //         case "risk":
    //             $proyek->is_rfa_risk = true;
    //             $proyek->tgl_rfa_risk = new DateTime();
    //             break;
    //     }
    //     if ($proyek->save()) {
    //         Alert::success("Success", "Request for Approval Berhasil");
    //         return redirect()->back();
    //     }
    // }

    public function deleteAdendum($id)
    {
        $delete = ProyekAdendum::find($id);
        $delete->delete();
        Alert::success("Success", "History Adendum Berhasil Dihapus");
        return redirect()->back();
    }

    public static function getProyekStage($stage)
    {
        switch ($stage) {
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

    public static function getUnitKerjaProyek($unit_kerja)
    {
        $nama_unit = UnitKerja::where("divcode", "=", $unit_kerja)->first();
        return $nama_unit->unit_kerja;
        // dd($nama_unit, $unit_kerja);
        // if (condition) {
        //     # code...
        // }
        // return UnitKerja::find($divcode)->unit_kerja;
    }

    private static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function updateRfaDocument(Request $request, $kode_proyek, $kategori)
    {
        // $proyek = Proyek::where('kode_proyek', '=', $kode_proyek)->first();

        // switch ($kategori) {
        //     case "nda":
        //         $proyek->is_rfa_nda = true;
        //         $proyek->tgl_rfa_nda = new DateTime();
        //         break;
        //     case "mou":
        //         $proyek->is_rfa_mou = true;
        //         $proyek->tgl_rfa_mou = new DateTime();
        //         break;
        //     case "eca":
        //         $proyek->is_rfa_eca = true;
        //         $proyek->tgl_rfa_eca = new DateTime();
        //         break;
        //     case "ica":
        //         $proyek->is_rfa_ica = true;
        //         $proyek->tgl_rfa_ica = new DateTime();
        //         break;
        //     case "rks":
        //         $proyek->is_rfa_rks = true;
        //         $proyek->tgl_rfa_rks = new DateTime();
        //         break;
        //     case "itb-tor":
        //         $proyek->is_rfa_itb_tor = true;
        //         $proyek->tgl_rfa_itb_tor = new DateTime();
        //         break;
        //     case "risk":
        //         $proyek->is_rfa_risk = true;
        //         $proyek->tgl_rfa_risk = new DateTime();
        //         break;
        // }

        $newContractRFA = new ContractRFADocument();
        $newContractRFA->kode_proyek = $kode_proyek;
        $newContractRFA->kategori = $request->get('kategori');
        $newContractRFA->tanggal = new DateTime();
        $newContractRFA->tgl_komitmen = $request->get('tgl_komitmen');

        if ($newContractRFA->save()) {
            Alert::success("Success", "Request for Approval Berhasil");
            return redirect()->back();
        }
    }

    public function viewSyaratPrakualifikasi(Proyek $proyek)
    {

        $aspek = ChecklistCalonMitraKSO::all()->groupBy('aspek');
        $aspekLegal = $aspek["Aspek Legal"]->groupBy('kategori');
        $aspekLegalLokal = $aspekLegal["Badan Usaha Lokal (Indonesia)"]->sortBy('posisi');
        $aspekLegalAsing = $aspekLegal["Badan Usaha Asing"]->sortBy('posisi');

        $aspekTeknikal = $aspek["Aspek Teknikal"]->sortBy('posisi');

        $aspekKomersial = $aspek["Aspek Komersial"]->sortBy('posisi');
        // dd($aspekTeknikal);

        return view('SyaratPrakualifikasi.view', compact(['aspekLegalLokal', 'aspekLegalAsing', 'proyek', 'aspekTeknikal', 'aspekKomersial']));
    }

    public function viewEditSyaratPrakualifikasi(Proyek $proyek)
    {

        $aspek = ChecklistCalonMitraKSO::all()->groupBy('aspek');
        $aspekLegal = $aspek["Aspek Legal"]->groupBy('kategori');
        $aspekLegalLokal = $aspekLegal["Badan Usaha Lokal (Indonesia)"]->sortBy('posisi');
        $aspekLegalAsing = $aspekLegal["Badan Usaha Asing"]->sortBy('posisi');

        $aspekTeknikal = $aspek["Aspek Teknikal"]->sortBy('posisi');

        $aspekKomersial = $aspek["Aspek Komersial"]->sortBy('posisi');

        $syaratProyek = SyaratPrakualifikasi::where('kode_proyek', $proyek->kode_proyek)->first();

        if (empty($syaratProyek)) {
            Alert::error('Error', "Data tidak ditemukan");
            return redirect()->back();
        }

        $collectData = collect(json_decode($syaratProyek->data));

        $dataAspekLegalLokalWika = $collectData->filter(function ($data) {
            return $data->code == 0 && $data->aspek == "Badan Usaha Lokal (Indonesia)";
        })->values();
        $dataAspekLegalAsingWika = $collectData->filter(function ($data) {
            return $data->code == 0 && $data->aspek == "Badan Usaha Asing";
        })->values();
        $dataAspekTeknikalWika = $collectData->filter(function ($data) {
            return $data->code == 0 && $data->aspek == "Aspek Teknikal";
        })->values();
        $dataAspekKomersialWika = $collectData->filter(function ($data) {
            return $data->code == 0 && $data->aspek == "Aspek Komersial";
        })->values();
        // dd($dataAspekLegalLokalWika, $dataAspekLegalAsingWika, $dataAspekTeknikalWika, $dataAspekKomersialWika);

        return view('SyaratPrakualifikasi.edit', compact(['aspekLegalLokal', 'aspekLegalAsing', 'proyek', 'aspekTeknikal', 'aspekKomersial', 'dataAspekLegalLokalWika', 'dataAspekLegalAsingWika', 'dataAspekTeknikalWika', 'dataAspekKomersialWika']));
    }

    public function saveSyaratPrakualifikasi(Request $request, Proyek $proyek)
    {
        $data = $request->all();
        $newSyarat = new SyaratPrakualifikasi();
        $collect = [];
        foreach ($data["aspek_wika"] as $key => $value) {
            if ($value == "Badan Usaha Lokal (Indonesia)") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_legal_lokal_wika"][$key],
                    "syarat_prakualifikasi_isian" => null,
                ];
            } elseif ($value == "Badan Usaha Asing") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_legal_asing_wika"][(int)$data["index_wika"][$key] - 1],
                    "syarat_prakualifikasi_isian" => null,
                ];
            } elseif ($value == "Aspek Teknikal") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_teknikal_wika"][(int)$data["index_wika"][$key] - 1],
                    "syarat_prakualifikasi_isian" => $data["aspek_teknikal_isi_wika"][(int)$data["index_wika"][$key] - 1] ?? null,
                ];
            } elseif ($value == "Aspek Komersial") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_komersial_wika"][(int)$data["index_wika"][$key] - 1],
                    "syarat_prakualifikasi_isian" => $data["aspek_komersial_isi_wika"][(int)$data["index_wika"][$key] - 1] ?? null,
                ];
            }
        }
        $newSyarat->kode_proyek = $proyek->kode_proyek;
        $newSyarat->data = json_encode($collect);
        if ($newSyarat->save()) {
            Alert::success('Success', "Syarat Prakualifikasi berhasil disimpan!");
            return redirect()->back();
        }
    }

    public function editSyaratPrakualifikasi(Request $request, Proyek $proyek)
    {
        $data = $request->all();
        $newSyarat = SyaratPrakualifikasi::where('kode_proyek', $proyek->kode_proyek)->first();
        if (empty($newSyarat)) {
            Alert::error('Error', 'Syarat Prakualifikasi gagal diperbaharui');
            return redirect()->back();
        }
        $collect = [];
        foreach ($data["aspek_wika"] as $key => $value) {
            if ($value == "Badan Usaha Lokal (Indonesia)") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_legal_lokal_wika"][$key],
                    "syarat_prakualifikasi_isian" => null,
                ];
            } elseif ($value == "Badan Usaha Asing") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_legal_asing_wika"][(int)$data["index_wika"][$key] - 1],
                    "syarat_prakualifikasi_isian" => null,
                ];
            } elseif ($value == "Aspek Teknikal") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_teknikal_wika"][(int)$data["index_wika"][$key] - 1],
                    "syarat_prakualifikasi_isian" => $data["aspek_teknikal_isi_wika"][(int)$data["index_wika"][$key] - 1] ?? null,
                ];
            } elseif ($value == "Aspek Komersial") {
                $collect[]  = [
                    "code" => 0,
                    "index" => $data["index_wika"][$key],
                    "kode_proyek" => $proyek->kode_proyek,
                    "aspek" => $value,
                    "syarat_prakualifikasi" => $data["aspek_komersial_wika"][(int)$data["index_wika"][$key] - 1],
                    "syarat_prakualifikasi_isian" => $data["aspek_komersial_isi_wika"][(int)$data["index_wika"][$key] - 1] ?? null,
                ];
            }
        }
        $newSyarat->kode_proyek = $proyek->kode_proyek;
        $newSyarat->data = json_encode($collect);
        if ($newSyarat->save()) {
            Alert::success('Success', "Syarat Prakualifikasi berhasil diperbaharui");
            return redirect()->back();
        }
    }

    public function getDataPefindo(Request $request)
    {
        $data = $request->all();
        $pefindo = MasterPefindo::where('id_pelanggan', $data['id_customer'])->first();

        if (!empty($pefindo)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'score' => $pefindo->score,
                    'file' => $pefindo->id_document,
                ]
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => null
            ]);
        }
    }

    public function downloadCVPersonel(PersonelTenderProyek $personel)
    {
        if (empty($personel)) {
            return response()->json([
                'Success' => false,
                'Message' => 'Personel Tender tidak ditemukan. Hubungi Admin!'
            ]);
        }

        try {
            $response = Http::withOptions([
                "verify" => false
            ])->get('https://hcms-dev.wika.co.id/apiwika/get_cvcrm.php?nip=' . $personel->nip);
            // dd($response->collect());
            if ($response->failed()) {
                return response()->json([
                    'Success' => false,
                    'Message' => "Dokumen belum tersedia di database HCMS"
                ]);
            } elseif ($response->successful()) {
                $fileName = date('HisdmY_') . 'CV-Personel-' . $personel->nip . '.pdf';
                $filePath = public_path('dokumen-cv-personel/download' . $fileName);
                $fileContent = file_get_contents($response->body());
                dd($fileContent);

                file_put_contents($filePath, $fileContent);

                $downloadResponse = Response::make($fileContent);
                $downloadResponse->header('Content-Type', 'application/octet-stream');
                $downloadResponse->header('Content-Disposition', 'attachment; filename="CV Personel - ' . $personel->nip . '.pdf' . '"');
                $responseJSON = response()->json([
                    'Success' => true,
                    'Message' => 'Dokumen dengan nama "CV Personel - ' . $personel->nip . '" berhasil di download'
                ]);

                $responses = [$downloadResponse, $responseJSON];
                return $responses;
            }
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadCVPersonel(Request $request, PersonelTenderProyek $personel)
    {
        $data = $request->all();

        if (empty($personel)) {
            Alert::error('Personel Tender tidak ditemukan. Hubungi Admin!');
            return redirect()->back();
        }

        if (!isset($data['upload-cv'])) {
            Alert::error('Upload dokumen tidak boleh kosong!');
            return redirect()->back();
        }

        try {
            $file = $request->file('upload-cv');

            $fileName = date('dmyHis_') . 'CV-Personel-Final_' . $personel->nip . '.' . $file->getClientOriginalExtension();

            if (!empty($personel->dokumen_cv_upload)) {
                File::delete(public_path('dokumen-cv-personel/upload/' . $personel->dokumen_cv_upload));
            }

            $file->move(public_path('dokumen-cv-personel/upload'), $fileName);

            $personel->dokumen_cv_upload = $fileName;

            $personel->save();

            Alert::success('Success', 'Dokumen CV Personel Tender Berhasil Ditambahkan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }
}
