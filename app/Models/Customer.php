<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Customer extends Model
{
    use HasFactory;
    use Sortable;

    protected $primaryKey   = 'id_customer';

    public $sortable = [
        'name', 'check_customer', 'check_partner', 'check_competitor', 'kode_pelanggan', 'kode_nasabah'
    ];
    
    
    public function customerAttachments()
    {
        return $this->hasMany(CustomerAttachments::class, "id_customer");
    }

    public function strukturAttachments()
    {
        return $this->hasMany(StrukturAttachment::class, "id_customer");
    }

    public function proyekBerjalans()
    {
        return $this->hasMany(ProyekBerjalans::class, "id_customer");
    }
    
    public function proyek()
    {
        return $this->hasMany(Proyek::class);
    }

    public function struktur()
    {
        return $this->hasMany(StrukturCustomer::class, "id_customer");
    }

    public function pic()
    {
        return $this->hasMany(CustomerPic::class, "id_customer");
    }

    public function sap()
    {
        return $this->hasOne(CustomerSAP::class, "id_customer", "id_customer");
    }

    public function IndustrySector()
    {
        return $this->hasOne(IndustrySector::class, "id_industry_sector", "industry_sector");
    }

    public function IndustryOwner()
    {
        return $this->hasOne(IndustryOwner::class, "code_owner", "industry_sector");
    }
    public function JenisPerusahaan()
    {
        return $this->hasOne(JenisPerusahaan::class, "kode_jenis", "jenis_perusahaan");
    }
    public function Tax()
    {
        return $this->hasOne(Tax::class, "kode", "tax");
    }
    public function SyaratPembayaran()
    {
        return $this->hasOne(SyaratPembayaran::class, "kode", "syarat_pembayaran");
    }
    public function MasalahHukum()
    {
        return $this->hasMany(MasalahHukum::class, "id_customer", "id_customer");
    }
    public function Csi()
    {
        return $this->hasMany(Csi::class, "id_customer", "id_customer");
    }
    public function Cli()
    {
        return $this->hasMany(Cli::class, "id_customer", "id_customer");
    }
    public function Nps()
    {
        return $this->hasMany(Nps::class, "id_customer", "id_customer");
    }
    public function KaryaInovasi()
    {
        return $this->hasMany(KaryaInovasi::class, "id_customer", "id_customer");
    }
    
    public function Piutang() {
        return $this->hasMany(Piutang::class, "debitor", "kode_nasabah");
    }

}