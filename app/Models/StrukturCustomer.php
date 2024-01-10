<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturCustomer extends Model
{
    use HasFactory;
    protected $primaryKey   = 'id';
    protected $table = "struktur_customer";

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id_customer', 'id_customer');
    }
}
