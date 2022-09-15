<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Dop extends Model
{
    use HasFactory;
    use Sortable;
    
    // public $sortable = [
    //     'dops'
    // ];
    protected $table = 'dops'; 

    public function UnitKerjas() {
        return $this->hasMany(UnitKerja::class, "dop", "dop");
    }

    public function Proyek() {
        return $this->belongsTo(Proyek::class, "dop", "dop");
    }
}
