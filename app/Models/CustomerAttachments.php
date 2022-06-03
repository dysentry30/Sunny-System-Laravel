<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAttachments extends Model
{
    use HasFactory;
    // protected $primaryKey   = 'id_attachment';
    // protected $guarded   = ['id_attachment','id_customer'];
    protected $table = "customer_attachments";
    


}
