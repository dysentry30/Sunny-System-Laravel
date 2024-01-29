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
        'nama_proyek', 'kode_proyek', 'jenis_proyek', 'tipe_proyek', 'unit_kerja', 'tahun_perolehan', 'stage', 'bulan_pelaksanaan', 'nilai_rkap', 'nilai_kontrak_keseluruhan', 'forecast'
    ];

    public function Company()
    {
        return $this->hasMany(Company::class);
    }

    public function SumberDana()
    {
        return $this->hasOne(SumberDana::class, "kode_sumber", "sumber_dana");
    }

    public function Dop()
    {
        return $this->hasOne(Dop::class, "dop", "dop");
    }

    public function Sbu()
    {
        return $this->hasOne(Sbu::class, "lingkup_kerja", "sbu");
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
        return $this->hasOne(Customer::class, "id_customer", "id_customer");
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

    public function PorsiJO()
    {
        return $this->hasMany(PorsiJO::class, "kode_proyek", "kode_proyek");
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
    
    public function DokumenNda()
    {
        return $this->hasMany(DokumenNda::class, "kode_proyek");
    }

    public function DokumenMou()
    {
        return $this->hasMany(DokumenMou::class, "kode_proyek");
    }

    public function DokumenEca()
    {
        return $this->hasMany(DokumenEca::class, "kode_proyek");
    }

    public function DokumenIca()
    {
        return $this->hasMany(DokumenIca::class, "kode_proyek");
    }

    public function DokumenRks()
    {
        return $this->hasMany(DokumenRks::class, "kode_proyek");
    }

    public function DokumenDraft()
    {
        return $this->hasMany(DokumenDraft::class, "kode_proyek");
    }

    public function DokumenItbTor()
    {
        return $this->hasMany(DokumenItbTor::class, "kode_proyek");
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

    public function ProyekProgress()
    {
        return $this->hasMany(ProyekProgress::class, "kode_proyek");
    }

    public function Provinsi()
    {
        return $this->hasOne(Provinsi::class, "province_id", "provinsi");
    }

    public function ContractApproval()
    {
        return $this->hasMany(ContractApproval::class, "kode_proyek");
    }

    public function PerubahanKontrak()
    {
        return $this->hasMany(PerubahanKontrak::class, "kode_proyek");
    }

    public function ProyekKonsultanPerencana()
    {
        return $this->hasMany(ProyekKonsultanPerencana::class, 'kode_proyek');
    }

    public function AlatProyek()
    {
        return $this->hasMany(AlatProyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function PersonelTender()
    {
        return $this->hasMany(PersonelTenderProyek::class, 'kode_proyek', 'kode_proyek');
    }

    public function MasterSubKlasifikasiSBU()
    {
        return $this->hasOne(MasterSubKlasifikasiSBU::class, 'kbli_2020', 'kode_kbli_2020');
    }
}
