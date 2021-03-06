<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Kyslik\ColumnSortable\Sortable;

class Proyek extends Model
{
    use HasFactory;
    use Sortable;
    protected $primaryKey   = 'kode_proyek';
    protected $casts = [
        "kode_proyek" => "string"
    ];

    public $sortable = [
        'nama_proyek', 'kode_proyek', 'jenis_proyek', 'divcode', 'tahun_perolehan', 'stage', 'bulan_pelaksanaan', 'nilai_rkap', 'forecast', 'nilai_kontrak_keseluruhan'
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

    public function HistoryForecasts()
    {
        return $this->hasMany(HistoryForecast::class, "kode_proyek");
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
        return $this->hasMany(TeamProyek::class, "kode_proyek", "kode_proyek");
    }
}
