<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AddendumContractDrafts extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'uraian_perubahan'
    ];

    protected $primaryKey = "id_addendum_draft";
    protected $table = "addendum_contract_drafts";
    // protected $fillable = ["id_addendum", "id_document", "document_name_addendum", "note_addendum"];
}
