<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftContracts extends Model
{
    use HasFactory;

    protected $primaryKey   = "id_draft";
    public $timestamps      = false;
    protected $fillable     = ["draft_name", "id_project", "draft_note", "tender_menang"];
}
