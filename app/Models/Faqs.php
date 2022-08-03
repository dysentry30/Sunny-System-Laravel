<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class faqs extends Model
{
    use HasFactory, Sortable;

    public $sortable = [
        'judul', 'deskripsi'
    ];
}
