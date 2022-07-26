<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AddendumContracts extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'no_addendum', 'created_at'
    ];

    protected $primaryKey = "id_addendum";

    public function addendumContractDrafts()
    {
        return $this->hasMany(AddendumContractDrafts::class, "id_addendum");
    }

    public function addendumContractDiajukan()
    {
        return $this->hasMany(AddendumContractDiajukan::class, "id_addendum");
    }

    public function addendumContractNegoisasi()
    {
        return $this->hasMany(AddendumContractNegoisasi::class, "id_addendum");
    }
    
    public function addendumContractDisetujui()
    {
        return $this->hasMany(AddendumContractDisetujui::class, "id_addendum");
    }

    public function addendumContractAmandemen()
    {
        return $this->hasMany(AddendumContractAmandemen::class, "id_addendum");
    }
}
