<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExceptGreenlane extends Model
{
    use HasFactory;

    public function Customers()
    {
        return $this->belongsTo(Customer::class, 'item', 'id_customer');
    }

    public function SumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'item', 'kode_sumber');
    }

    public function Provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'sub_item', 'province_id');
    }
}
