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
        'name', 'check_customer', 'check_partner', 'check_competitor'
    ];
    
    
    public function customerAttachments()
    {
        return $this->hasMany(CustomerAttachments::class, "id_customer");
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

}