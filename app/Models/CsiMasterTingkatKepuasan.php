<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsiMasterTingkatKepuasan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'csi_master_tingkat_kepuasan';
    public $incrementing = false;
}
