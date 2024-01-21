<?php

namespace App\Http\Controllers;

use App\Models\KonsultanPerencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KonsultanPerencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData.KonsultanPerencana', ['data' => KonsultanPerencana::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $messages = [
            "required" => "Field :attribute di atas wajib diisi",
            "email" => "Field :attribute wajib diisi",
        ];
        $rules = [
            "nama-konsultan" => 'required|string',
            "email" => 'required|email:dns',
        ];
        $attributes = [
            "nama-konsultan" => "Nama Konsultan",
            "email" => "Email",
        ];
        $validation = Validator::make($data, $rules, $messages, $attributes);

        if ($validation->fails()) {
            Alert::error('Error', "Konsultan Perencana Gagal Ditambahkan. Periksa Kembali!");
            return redirect()
                ->back()
                ->withErrors($validation)
                ->withInput();
        }

        $validation->validate();

        $newKonsultan = new KonsultanPerencana();
        $newKonsultan->nama_konsultan = $data['nama-konsultan'];
        $newKonsultan->email = $data['email'];
        $newKonsultan->nomor_telpon = $data['nomor-telpon'];
        $newKonsultan->website = $data['website'];
        $newKonsultan->alamat = $data['alamat'];

        if ($newKonsultan->save()) {
            Alert::success('Success', "Konsultan Perencana Berhasil Ditambahkan");
            return redirect()->back();
        }
        Alert::error('Error', "Konsultan Perencana Gagal Ditambahkan");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KonsultanPerencana  $konsultanPerencana
     * @return \Illuminate\Http\Response
     */
    public function show(KonsultanPerencana $konsultanPerencana, $id)
    {
        $konsultanPerencana = $konsultanPerencana->find($id);
        return view('KonsultanPerencana/view', ['data' => $konsultanPerencana]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KonsultanPerencana  $konsultanPerencana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KonsultanPerencana $id)
    {
        $data = $request->all();
        $messages = [
            'required' => ':attribute wajib diisi'
        ];

        $rules = [
            'nama-konsultan' => 'required|string',
            'email' => 'required|email'
        ];

        $attributes = [
            "nama-konsultan" => "Nama Konsultan",
            "email" => "Email",
        ];
        $validation = Validator::make($data, $rules, $messages, $attributes);

        if ($validation->fails()) {
            Alert::error('Error', "Konsultan Perencana Gagal Ditambahkan. Periksa Kembali!");
            return redirect()
                ->back()
                ->withErrors($validation)
                ->withInput();
        }

        $validation->validate();

        $konsultanPerencana = $id;

        if (empty($konsultanPerencana)) {
            Alert::error('Error', "Konsultan Perencana tidak ditemukan");
            return redirect()->back();
        }

        $konsultanPerencana->nama_konsultan = $data['nama-konsultan'];
        $konsultanPerencana->email = $data['email'];
        $konsultanPerencana->nomor_telpon = $data['nomor-telpon'];
        $konsultanPerencana->website = $data['website'];
        $konsultanPerencana->alamat = $data['alamat'];

        if ($konsultanPerencana->save()) {
            Alert::success('Success', "Konsultan Perencana Berhasil Diubah");
            return redirect()->back();
        }
        Alert::error('Error', "Konsultan Perencana Gagal Diubah");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KonsultanPerencana  $konsultanPerencana
     * @return \Illuminate\Http\Response
     */
    public function destroy(KonsultanPerencana $id)
    {
        $konsultanPerencana = $id;

        if (empty($konsultanPerencana)) {
            // Alert::error('Error', "Konsultan Perencana tidak ditemukan");
            return response()->json([
                "Success" => true,
                "Message" => null
            ]);
        }

        $konsultanPerencana->delete();
        // Alert::success('Success', "Konsultan Perencana Berhasil Dihapus");
        return response()->json([
            "Success" => true,
            "Message" => null
        ]);
    }
}
