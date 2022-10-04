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
    public $primaryKey   = 'kode_proyek';
    public $keyType = 'string';
    protected $table = 'proyeks'; 
    protected $casts = [
        "kode_proyek" => "string"
    ];

    public $sortable = [
        'nama_proyek', 'kode_proyek', 'jenis_proyek', 'unit_kerja', 'tahun_perolehan', 'stage', 'bulan_pelaksanaan', 'nilai_rkap', 'nilai_kontrak_keseluruhan', 'forecast'
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
        return $this->hasOne(Dop::class);
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
        return $this->hasOne(ProyekBerjalans::class, "kode_proyek", "kode_proyek");
    }

    public function Users()
    {
        return $this->hasMany(User::class);
    }

    public function TeamProyek()
    {
        return $this->hasMany(TeamProyek::class, "kode_proyek", "kode_proyek");
    }

    public function AdendumProyek()
    {
        return $this->hasMany(ProyekAdendum::class, "kode_proyek");
    }

    public function DokumenPrakualifikasi()
    {
        return $this->hasMany(DokumenPrakualifikasi::class, "kode_proyek");
    }

    public function DokumenTender()
    {
        return $this->hasMany(DokumenTender::class, "kode_proyek");
    }

    public function AttachmentMenang()
    {
        return $this->hasMany(AttachmentMenang::class, "kode_proyek");
    }

    public function RiskTenderProyek()
    {
        return $this->hasMany(RiskTenderProyek::class, "kode_proyek");
    }
}
