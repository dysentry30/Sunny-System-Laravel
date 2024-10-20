<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Imports\AhsImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MasterSumberDaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AnalisaHargaSatuanDetail;
use App\Models\MasterAnalisaHargaSatuan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class MasterAnalisaHargaSatuanController extends Controller
{
    public function index()
    {
        $masterHargaSatuanAll = MasterAnalisaHargaSatuan::all();
        return view("MasterData.MasterAnalisaHargaSatuan", ['masterHargaSatuanAll' => $masterHargaSatuanAll]);
    }

    public function view(Request $request, MasterAnalisaHargaSatuan $masterAHS)
    {
        $masterSumberDaya = MasterSumberDaya::select(['code', 'parent_code', 'description', 'uoms_name', 'material_code', 'jenis_material', 'material_name', 'valuation_class_code', 'valuation_class_name', 'keterangan'])->get();
        $masterSumberDayaDetail = AnalisaHargaSatuanDetail::where("kode_ahs", $masterAHS->kode_ahs)->get();
        return view('MasterData.MasterAnalisaHargaDetail', ['masterSumberDaya' => $masterSumberDaya, 'masterAHS' => $masterAHS, 'masterSumberDayaDetail' => $masterSumberDayaDetail]);
    }

    public function insert(Request $request)
    {
        $data = $request->all();

        $newMaster = new MasterAnalisaHargaSatuan();
        $newMaster->kode_ahs = $data["kode-ahs"];
        $newMaster->uraian = $data["uraian"];

        if ($newMaster->save()) {
            Alert::success("Success", "Data berhasil ditambahkan");
            return redirect()->back();
        }

        Alert::error("Error", "Data gagal ditambahkan");
        return redirect()->back();
    }

    public function insertDetail(Request $request, MasterAnalisaHargaSatuan $masterAHS)
    {
        $data = $request->all();
        $collectChecklist = $request->get("checklist-sumber-daya");
        $collectDataInsert = [];

        try {
            if (!empty($collectChecklist)) {
                foreach ($collectChecklist as $sumber_daya) {
                    $dataReal = [
                        "id" => Str::uuid()->toString(),
                        "kode_sumber_daya" => $sumber_daya,
                        "kode_ahs" => $masterAHS->kode_ahs,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    ];

                    array_push($collectDataInsert, $dataReal);
                }

                // dd($collectDataInsert);
                AnalisaHargaSatuanDetail::insert($collectDataInsert);
            }
            $masterAHS->kode_ahs = $data["kode-ahs"];
            $masterAHS->uraian = $data["uraian"];
            $masterAHS->save();

            Alert::success("Success", "Data berhasil diubah");
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            Alert::error("Error", "Terjadi Kesalahan. Hubungi Admin");
            return redirect()->back();
        }
    }

    public function insertSumberDaya(Request $request, MasterAnalisaHargaSatuan $masterAHS)
    {
        $selectedSumberDaya = $request->get("selectedId");

        try {
            DB::beginTransaction();

            if (!empty($selectedSumberDaya)) {
                $collectIdSumberDaya = collect(json_decode($selectedSumberDaya));

                $collectIdSumberDaya->each(function ($id) use ($masterAHS) {
                    $masterSumberDaya = MasterSumberDaya::find($id);
                    $saveMasterAnalisaDetail = AnalisaHargaSatuanDetail::updateOrCreate([
                        "kode_ahs" => $masterAHS->kode_ahs,
                        "resource_code" => $masterSumberDaya->code
                    ]);
                });
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Tidak ada data yang dipilih"
                ]);
            }

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data Berhasil Diupdate"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function insertFromFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx',
            ]);

            // Lakukan import dan masukkan kode proyek ke dalam BoqImport
            Excel::import(new AhsImport($request), $request->file('file'));

            Alert::success("Success", "Data Berhasil Di Upload");
            return redirect()->back();
        } catch (\Throwable $th) {
            // Alert::error("Error", $th->getMessage());
            // return redirect()->back();
            throw $th;
        }
    }

    public function getFormulaSumberDaya(Request $request, $resourceCode)
    {
        try {
            $search = $request->input('search');
            $page = $request->input(
                'page',
                1
            );
            $perPage = 10;
            $maxResults = 10;

            $dataAHS = AnalisaHargaSatuanDetail::with('MasterAnalisaHargaSatuan')
            ->where('resource_code', $resourceCode)
                ->whereNotNull('formula') // Menggunakan whereNotNull untuk kejelasan
                ->when(!empty($search), function ($query) use ($search) {
                    // Mencari dalam tabel utama
                    $query->where('kode_ahs', 'ILIKE', '%' . $search . '%');
                });

            $data = $dataAHS->paginate($perPage, ['*'], 'page', $page);

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function saveFormulaSumberDaya(Request $request, AnalisaHargaSatuanDetail $sumberDayaAHS)
    {
        try {
            $rules = [
                'nilai-formula' => 'required|array',
                'nilai-formula.*' => 'required|numeric',
                'satuan-formula' => 'required|array',
                'satuan-formula.*' => 'required|string',
                'deskripsi-formula' => 'required|array',
                'deskripsi-formula.*' => 'required|string',
                'parameter-formula' => 'required|array',
                'parameter-formula.*' => 'required|string',
                'formula' => 'required|string'
            ];

            $messages = [
                'nilai-formula.required' => 'Kolom Nilai wajib diisi.',
                'nilai-formula.*.numeric' => 'Nilai harus berupa angka.',
                'satuan-formula.required' => 'Kolom Satuan wajib diisi.',
                'satuan-formula.*.string' => 'Satuan harus berupa teks.',
                'deskripsi-formula.required' => 'Kolom Deskripsi wajib diisi.',
                'deskripsi-formula.*.string' => 'Deskripsi harus berupa teks.',
                'parameter-formula.required' => 'Kolom Parameter formula wajib diisi.',
                'formula.required' => 'Kolom Formula wajib diisi.',
                'formula.string' => 'Formula harus berupa teks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            // Jika validasi gagal
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            if (empty($sumberDayaAHS)) {
                Alert::error("Error", "Data tidak ditemukan. Hubungi Admin");
                return redirect()->back();
            }

            $collectData = collect([]);

            $parameterFormula = $request->get("parameter-formula");
            $deskripsiFormula = $request->get("deskripsi-formula");
            $nilaiFormula = $request->get("nilai-formula");
            $satuanFormula = $request->get("satuan-formula");
            $formula = preg_replace('/\s+/', '', $request->get("formula"));

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $calculation = Calculation::getInstance($spreadsheet);

            foreach ($parameterFormula as $index => $parameter) {
                $collectData->push([
                    'parameter' => $parameter,
                    'deskripsi' => $deskripsiFormula[$index],
                    'nilai' => (float) $nilaiFormula[$index],
                    'satuan' => $satuanFormula[$index],
                    'formula' => $formula
                ]);

                $sheet->setCellValue($parameter, (float) $nilaiFormula[$index]);
            }

            $koef = $calculation->calculateFormula($formula, null, null);

            if (is_string($koef)) {
                Alert::warning("Kesalahan Formula", "Formula yang anda masukkan salah. Mohon periksa kembali.");
                return redirect()->back();
            }

            DB::beginTransaction();

            $sumberDayaAHS->formula = $collectData->toJson();
            $sumberDayaAHS->koef = number_format($koef, 2);

            if ($sumberDayaAHS->save()) {
                DB::commit();

                Alert::success("Success", "Data berhasil disimpan");
                return redirect()->back();
            }

            Alert::error("Error", "Terjadi kesalahan, Hubungi admin.");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function editFormulaSumberDaya(Request $request, AnalisaHargaSatuanDetail $sumberDayaAHS)
    {
        try {
            $rules = [
                'nilai-formula' => 'required|array',
                'nilai-formula.*' => 'required|numeric',
                'satuan-formula' => 'required|array',
                'satuan-formula.*' => 'required|string',
                'deskripsi-formula' => 'required|array',
                'deskripsi-formula.*' => 'required|string',
                'parameter-formula' => 'required|array',
                'parameter-formula.*' => 'required|string',
                'formula' => 'required|string'
            ];

            $messages = [
                'nilai-formula.required' => 'Kolom Nilai wajib diisi.',
                'nilai-formula.*.numeric' => 'Nilai harus berupa angka.',
                'satuan-formula.required' => 'Kolom Satuan wajib diisi.',
                'satuan-formula.*.string' => 'Satuan harus berupa teks.',
                'deskripsi-formula.required' => 'Kolom Deskripsi wajib diisi.',
                'deskripsi-formula.*.string' => 'Deskripsi harus berupa teks.',
                'parameter-formula.required' => 'Kolom Parameter formula wajib diisi.',
                'formula.required' => 'Kolom Formula wajib diisi.',
                'formula.string' => 'Formula harus berupa teks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            // Jika validasi gagal
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            if (empty($sumberDayaAHS)) {
                Alert::error("Error", "Data tidak ditemukan. Hubungi Admin");
                return redirect()->back();
            }

            $collectData = collect([]);

            $parameterFormula = $request->get("parameter-formula");
            $deskripsiFormula = $request->get("deskripsi-formula");
            $nilaiFormula = $request->get("nilai-formula");
            $satuanFormula = $request->get("satuan-formula");
            $formula = preg_replace('/\s+/', '', $request->get("formula"));

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $calculation = Calculation::getInstance($spreadsheet);

            foreach ($parameterFormula as $index => $parameter) {
                $collectData->push([
                    'parameter' => $parameter,
                    'deskripsi' => $deskripsiFormula[$index],
                    'nilai' => (float) $nilaiFormula[$index],
                    'satuan' => $satuanFormula[$index],
                    'formula' => $formula
                ]);

                $sheet->setCellValue($parameter, (float) $nilaiFormula[$index]);
            }

            $koef = $calculation->calculateFormula($formula, null, null);

            if (is_string($koef)) {
                Alert::warning("Kesalahan Formula", "Formula yang anda masukkan salah. Mohon periksa kembali.");
                return redirect()->back();
            }

            DB::beginTransaction();

            $sumberDayaAHS->formula = $collectData->toJson();
            $sumberDayaAHS->koef = number_format($koef, 2);

            if ($sumberDayaAHS->save()) {
                DB::commit();

                Alert::success("Success", "Data berhasil disimpan");
                return redirect()->back();
            }

            Alert::error("Error", "Terjadi kesalahan, Hubungi admin.");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error("Error", $e->getMessage());
            return redirect()->back();
        }
    }
}
