<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class RoleManagements extends Authenticatable
{
    use  HasFactory;
    protected $table = 'role_management';
    public $primaryKey = 'nama_pegawai';

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nama_pegawai', 'nip');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'nama_pegawai', 'nip');
    }
}
