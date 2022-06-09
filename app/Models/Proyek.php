<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Proyek extends Model
{
    use HasFactory;
    // protected $primaryKey   = 'kode_proyek';
    protected $table = "proyeks";

    public function Company()
    {
        return $this->hasMany(Company::class);
    }
    
    public function SumberDana()
    {
        return $this->hasMany(SumberDana::class);
    }
    
    public function Dop()
    {
        return $this->hasMany(Dop::class);
    }

    public function Sbu()
    {
        return $this->hasMany(Sbu::class);
    }
    
    public function UnitKerja()
    {
        return $this->hasOne(UnitKerja::class, "divcode", "unit_kerja");
    }

}
