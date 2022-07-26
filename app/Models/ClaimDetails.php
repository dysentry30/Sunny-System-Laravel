<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ClaimDetails extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'kode_proyek', 'id_contract'
    ];

    protected $primaryKey = "id_claim_detail";

}
