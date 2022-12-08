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

}