<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfileKnowladgeBase;
use App\Models\PeraturanKnowladgeBase;
use App\Models\PortofolioKnowladgeBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use stdClass;

class KnowladgeBaseController extends Controller
{
    public function view(string $kategori)
    {
        switch ($kategori) {
            case 'peraturan':
                $data = PeraturanKnowladgeBase::all();
                break;
            case 'company-profile':
                $data = CompanyProfileKnowladgeBase::all();
                break;
            case 'portofolio':
                $data = PortofolioKnowladgeBase::all();
                break;

            default:
                $data = [];
                break;
        }

        return view('8_Knowladge_Base_New', ['kategori' => $kategori, 'data' => $data]);
    }

    public function save(Request $request, string $kategori)
    {
        $data = $request->all();
        $kategori = $data['kategori'];

        $rules = [
            'title' => 'required|string',
            'url' => 'sometimes|required|url:http,https',
            'file.*' => 'sometimes|required|file|mimes:pdf'
        ];

        $message = [
            'required' => 'Field wajib diisi!',
            'url' => 'Mohon masukkan link yang valid',
            'size' => 'File max 15MB',
            'mimes' => 'File hanya dapat diinput dengan format PDF',
        ];


        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with("modal", "kt_modal_create")
                ->withErrors($validator)
                ->withInput();
        }

        try {
            switch ($kategori) {
                case 'peraturan':
                    $newKnowladge = new PeraturanKnowladgeBase();
                    break;
                case 'company-profile':
                    $newKnowladge = new CompanyProfileKnowladgeBase();
                    break;
                case 'portofolio':
                    $newKnowladge = new PortofolioKnowladgeBase();
                    break;
                default:
                    $newKnowladge = null;
                    break;
            }

            $newKnowladge->title = $data['title'];
            $newKnowladge->uuid = Str::uuid()->toString();
            $newKnowladge->url = $data['url'] ?? null;
            $newKnowladge->created_by = auth()->user()->nip;
            $newKnowladge->updated_by = auth()->user()->nip;

            if (isset($data['file'])) {
                $collectFile = collect([]);
                $files = $data['file'];

                foreach ($files as $key => $file) {
                    $nameFile = date('dmYHis_') . str_replace(' ', '', $file->getClientOriginalName());
                    $newStd = new stdClass();
                    $newStd->id_file = $nameFile;
                    $newStd->nama_file = $file->getClientOriginalName();
                    $newStd->position = $key;

                    $file->move(public_path("file-knowladge-base/$kategori"), $nameFile);

                    $collectFile->push($newStd);
                }

                $newKnowladge->documents = $collectFile->toJson();
            } else {
                $newKnowladge->documents = null;
            }

            $newKnowladge->save();

            Alert::success('Success', "Data Berhasil ditambahkan");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, string $kategori, string $idKnowladge)
    {
        $data = $request->all();

        $rules = [
            'title' => 'required|string',
            'url' => 'sometimes|required|url:http,https',
            'file.*' => 'sometimes|required|file|mimes:pdf'
        ];

        $message = [
            'required' => 'Field wajib diisi!',
            'url' => 'Mohon masukkan link yang valid',
            'size' => 'File max 15MB',
            'mimes' => 'File hanya dapat diinput dengan format PDF',
        ];


        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with("modal", "kt_modal_edit")
                ->withErrors($validator)
                ->withInput();
        }

        try {
            switch ($kategori) {
                case 'peraturan':
                    $knowladgeSelected = PeraturanKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                case 'company-profile':
                    $knowladgeSelected = CompanyProfileKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                case 'portofolio':
                    $knowladgeSelected = PortofolioKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                default:
                    $knowladgeSelected = null;
                    break;
            }

            if (empty($knowladgeSelected)) {
                Alert::error('Error', "Data Tidak Ditemukan");
                return redirect()->back();
            }

            $knowladgeSelected->title = $data['title'];
            $knowladgeSelected->url = $data['url'] ?? null;
            $knowladgeSelected->updated_by = auth()->user()->nip;

            if (isset($data['file'])) {
                $collectFile = collect(json_decode($knowladgeSelected->documents));
                $files = $data['file'];

                foreach ($files as $key => $file) {
                    $nameFile = date('dmYHis_') . str_replace(' ', '', $file->getClientOriginalName());
                    $newStd = new stdClass();
                    $newStd->id_file = $nameFile;
                    $newStd->nama_file = $file->getClientOriginalName();
                    $newStd->position = $key;

                    $file->move(public_path("file-knowladge-base/$kategori"), $nameFile);

                    $collectFile->push($newStd);
                }

                $knowladgeSelected->documents = $collectFile->toJson();
            } else {
                $knowladgeSelected->documents = null;
            }

            $knowladgeSelected->save();

            Alert::success('Success', "Data Berhasil Diubah");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function delete(string $kategori, string $idKnowladge)
    {
        try {
            switch ($kategori) {
                case 'peraturan':
                    $knowladgeSelected = PeraturanKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                case 'company-profile':
                    $knowladgeSelected = CompanyProfileKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                case 'portofolio':
                    $knowladgeSelected = PortofolioKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                default:
                    $knowladgeSelected = null;
                    break;
            }

            if (empty($knowladgeSelected)) {
                Alert::error('Error', "Data Tidak Ditemukan");
                return redirect()->back();
            }

            $documents = !empty($knowladgeSelected->documents) ? json_decode($knowladgeSelected->documents) : null;

            $knowladgeSelected->delete();

            if (!empty($documents)) {
                foreach ($documents as $document) {
                    File::delete(public_path("file-knowladge-base/$kategori/$document->id_file"));
                }
            }

            return response()->json([
                'success' => true,
                'message' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getData(Request $request, string $kategori, string $id)
    {
        try {
            switch ($kategori) {
                case 'peraturan':
                    $data = PeraturanKnowladgeBase::all();
                    break;
                case 'company-profile':
                    $data = CompanyProfileKnowladgeBase::all();
                    break;
                case 'portofolio':
                    $data = PortofolioKnowladgeBase::all();
                    break;

                default:
                    $data = [];
                    break;
            }

            $getData = $data->where('uuid', $id)->first();

            return response()->json([
                'success' => true,
                'data' => $getData,
                'message' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function downloadDocument(Request $request, string $kategori, string $idKnowladge, string $idDocument)
    {
        try {
            switch ($kategori) {
                case 'peraturan':
                    $knowladgeSelected = PeraturanKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                case 'company-profile':
                    $knowladgeSelected = CompanyProfileKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                case 'portofolio':
                    $knowladgeSelected = PortofolioKnowladgeBase::where('uuid', $idKnowladge)->first();
                    break;
                default:
                    $knowladgeSelected = null;
                    break;
            }

            $collectDocument = collect(json_decode($knowladgeSelected->documents));

            if (empty($collectDocument)) {
                Alert::error("Error", "Dokumen tidak ditemukan. Hubungi Admin!");
                return redirect()->back();
            }

            $documentSelected = $collectDocument->where('id_file', $idDocument)->first();

            return response()->download(public_path("/file-knowladge-base/$kategori/$idDocument"), $documentSelected->nama_file);
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteDocument(string $kategori, string $idKnwoladge, string $idDocument)
    {
        try {
            switch ($kategori) {
                case 'peraturan':
                    $dataSelected = PeraturanKnowladgeBase::where('uuid', $idKnwoladge)->first();
                    break;
                case 'company-profile':
                    $dataSelected = CompanyProfileKnowladgeBase::where('uuid', $idKnwoladge)->first();
                    break;
                case 'portofolio':
                    $dataSelected = PortofolioKnowladgeBase::where('uuid', $idKnwoladge)->first();
                    break;

                default:
                    $dataSelected = null;
                    break;
            }


            $fileParse = collect(json_decode($dataSelected->documents));
            if ($fileParse->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan. Hubungi Admin!'
                ]);
            }
            $fileParse = $fileParse->sortBy('position')->keyBy('id_file');
            $deleteItemFile = $fileParse->forget($idDocument);

            $dataSelected->documents = $deleteItemFile->toJson() != "[]" ? $deleteItemFile->toJson() : null;

            if ($dataSelected->save()) {
                File::delete(public_path("file-knowladge-base/$kategori/$idDocument"));
                return response()->json([
                    'success' => true,
                    'message' => null,
                    'isExistFile' => $deleteItemFile->toJson() != "[]" ? true : false
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
