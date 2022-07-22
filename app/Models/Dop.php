<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Dop extends Model
{
    use HasFactory;
    use Sortable;
    
    public $sortable = [
        'dop'
    ];

    public function UnitKerjas() {
        return $this->hasMany(UnitKerja::class, "dop", "dop");
    }
}
