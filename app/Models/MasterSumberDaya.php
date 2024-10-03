<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MasterSumberDaya extends Model
{
    use HasUuids;
    protected $table = "master_sumber_daya";

    protected $fillable = [
        "resources_code_id",
        "code",
        "parent_code",
        "material_id",
        "material_class",
        "uoms_id",
        "name",
        "unspsc",
        "unspsc_name",
        "description",
        "status",
        "sts_matgis",
        "sts_cm",
        "material_ap",
        "level",
        "image",
        "approve_date",
        "approve_by",
        "created_by",
        "input_date",
        "keterangan",
        "uoms_name",
        "jenis_material",
        "material_code",
        "material_name",
        "valuation_class_code",
        "valuation_class_name",
    ];

    public function MasterHargaSatuan()
    {
        return $this->hasOne(MasterHargaSatuan::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterProduktivitas()
    {
        return $this->hasOne(MasterProduktivitas::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterWaste()
    {
        return $this->hasOne(MasterWaste::class, "kode_sumber_daya", "kode_sumber_daya");
    }

    public function MasterFaktorLainLain()
    {
        return $this->hasOne(MasterFaktorLainLain::class, "kode_sumber_daya", "kode_sumber_daya");
    }
}
