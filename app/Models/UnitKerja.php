<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class UnitKerja extends Model
{
    use HasFactory;
    use Sortable;

    protected $primaryKey = "divcode";
    protected $keyType = "string";

    public $sortable = [
        'nomor_unit', 'unit_kerja', 'divcode', 'dop', 'company', 'divisi', 'is_active'
    ];
    
    public function proyeks() {
        return $this->hasMany(Proyek::class, "unit_kerja", "divcode");
    }

    public function Users() {
        return $this->hasMany(User::class, "unit_kerja", "divcode");;
    }
    public function User_1() {
        return $this->hasOne(User::class, "id", "user_1");;
    }
    public function User_2() {
        return $this->hasOne(User::class, "id", "user_2");;
    }
    public function User_3() {
        return $this->hasOne(User::class, "id", "user_3");;
    }
    public function Dop() {
        return $this->belongsTo(Dop::class, "dop", "dop");
    }
    public function Departemen(){
        return $this->hasMany(Departemen::class, "kode_sap", "kode_divisi");
    }
    public function Divisi() {
        return $this->hasOne(Divisi::class, "kode_sap", "kode_sap");
    }
}
