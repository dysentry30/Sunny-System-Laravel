<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractManagements extends Model
{
    use HasFactory;

    protected $primaryKey   = "id_contract";
    public $timestamps      = false;
    protected $fillable     = ["*"];
    protected $visible      = ["*"];
    protected $casts        = [
        "contract_in" => "datetime:Y-m-d",
        "contract_out" => "datetime:Y-m-d"
    ];
    protected $dateFormat   = "Y-m-d";

    public function draftContracts()
    {
        return $this->hasMany(DraftContracts::class, "id_contract");
    }

    public function reviewProjects()
    {
        return $this->hasMany(ReviewContracts::class, "id_contract");
    }

    public function issueProjects()
    {
        return $this->hasMany(IssueProjects::class, "id_contract");
    }

    public function inputRisks()
    {
        return $this->hasMany(InputRisks::class, "id_contract");
    }

    public function questionsProjects()
    {
        return $this->hasMany(Questions::class, "id_contract");
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReports::class, "id_contract");
    }

    public function handOvers()
    {
        return $this->hasMany(HandOvers::class, "id_contract");
    }

    public function AddendumContracts()
    {
        return $this->hasMany(AddendumContracts::class, "id_contract");
    }

    public function project()
    {
        return $this->hasOne(Proyek::class, "kode_proyek", "project_id");
    }

    public function getAll()
    {
        $data = [];
        array_push($data, $this->draftContracts());
        array_push($data, $this->issueProjects());
        array_push($data, $this->inputRisks());
        array_push($data, $this->questionsProjects());
        array_push($data, $this->monthlyReports());
        return $data;
    }
}
