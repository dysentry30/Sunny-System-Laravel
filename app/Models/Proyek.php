<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Proyek extends Model
{
    use HasFactory;
    protected $primaryKey   = 'kode_proyek';
    protected $casts = [
        "kode_proyek" => "string"
    ];

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
    
    public function ClaimManagements()
    {
        return $this->hasMany(ClaimManagements::class, "kode_proyek", "kode_proyek");
    }

    public function Customer()
    {
        return $this->hasOne(Customer::class);
    }
    
    public function ContractManagements()
    {
        return $this->hasOne(ContractManagements::class, "project_id", "kode_proyek");
    }
    
    public function Forecasts()
    {
        return $this->hasMany(Forecast::class, "kode_proyek");
    }

    public function proyekBerjalan()
    {
        return $this->hasOne(proyekBerjalan::class, "kode_proyek", "kode_proyek");
    }

    public function Users()
    {
        return $this->hasMany(User::class);
    }

    public function TeamProyek()
    {
        return $this->hasOne(TeamProyek::class);
    }
}
