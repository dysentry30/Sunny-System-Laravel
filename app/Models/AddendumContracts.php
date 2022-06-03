<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddendumContracts extends Model
{
    use HasFactory;
    protected $primaryKey = "id_addendum";

    public function addendumContractDrafts()
    {
        return $this->hasMany(AddendumContractDrafts::class, "id_addendum");
    }
}
