<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSAP extends Model
{
    use HasFactory;
    protected $table = "customer_sap";
    protected $primaryKey = "id_sap_customer";

    public function Customer() {
        return $this->hasOne(Customer::class, "id_customer");
    }
}
