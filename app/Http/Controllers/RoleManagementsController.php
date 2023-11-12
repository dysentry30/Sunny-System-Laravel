<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RoleManagements;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleManagementsController extends Controller
{
    public function index(Request $request)
    {
        $all_role = RoleManagements::all();
        $all_pegawai = Pegawai::all()->sortBy('nama_pegawai');

        return view('MasterData/RoleManagements', ['all_role' => $all_role, 'all_pegawai' => $all_pegawai]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $newRole = new RoleManagements();
        $newRole->nama_pegawai = $data['nama_pegawai'];
        $newRole->aplikasi = $data['aplikasi'];
        $newRole->role = $data['role'];
        $newRole->is_active = isset($data['isActive']) ? true : false;

        if ($newRole->save()) {
            Alert::success('Success', 'Role berhasil ditambahkan');
            return redirect()->back();
        }
        Alert::Error('Error', 'Role gagal ditambahkan');
        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $data = $request->all();

        $roleEdit = RoleManagements::find($id);
        if (empty($roleEdit)) {
            Alert::Error('Error', 'Data tidak ditemukan');
            return redirect()->back();
        }
        $roleEdit->nama_pegawai = $data["nama_pegawai"];
        $roleEdit->aplikasi = $data['aplikasi'];
        $roleEdit->role = $data['role'];
        $roleEdit->is_active = isset($data['isActive']) ? true : false;

        if ($roleEdit->save()) {
            Alert::success('Success', 'Role berhasil diubah');
            return redirect()->back();
        }
        Alert::Error('Error', 'Role gagal diubah');
        return redirect()->back();
    }

    public function delete($id)
    {
        $roleSelect = RoleManagements::find($id);
        if (empty($roleSelect)) {
            Alert::Error('Error', 'Data tidak ditemukan');
            return redirect()->back();
        }
        if ($roleSelect->delete()) {
            return [
                "Success" => true,
                "Message" => "Success"
            ];
        }

        return [
            "Success" => false,
            "Message" => "Failed"
        ];
    }
}
