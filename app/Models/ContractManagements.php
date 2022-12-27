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
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable     = ["*"];
    protected $visible      = ["*"];
    protected $casts        = [
        "contract_in" => "datetime:Y-m-d",
        "contract_out" => "datetime:Y-m-d",
    ];
    protected $dateFormat   = "Y-m-d";

    public function draftContracts()
    {
        return $this->hasMany(DraftContracts::class, "id_contract");
    }

    public function ClaimManagements()
    {
        return $this->hasMany(ClaimManagements::class, "id_contract");
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
    public function KlarifikasiNegosiasiCDA()
    {
        return $this->hasMany(KlarifikasiNegosiasiCda::class, "id_contract");
    }
    public function KontrakTandaTangan()
    {
        return $this->hasMany(KontrakBertandatangan::class, "id_contract");
    }
    public function ReviewPembatalanKontrak()
    {
        return $this->hasMany(ReviewPembatalanKontrak::class, "id_contract");
    }
    public function PerjanjianKSO()
    {
        return $this->hasMany(PerjanjianKso::class, "id_contract");
    }
    public function DokumenPendukung()
    {
        return $this->hasMany(DokumenPendukung::class, "id_contract");
    }
    public function MoMMeeting()
    {
        return $this->hasMany(MomKickOffMeeting::class, "id_contract");
    }
    public function PendingIssue()
    {
        return $this->hasMany(PendingIssue::class, "id_contract");
    }
    public function UsulanPerubahanDraft()
    {
        return $this->hasMany(UsulanPerubahanDraft::class, "id_contract");
    }
    public function RencanaKerjaManajemen()
    {
        return $this->hasMany(RencanKerjaManajemenKontrak::class, "id_contract");
    }
    public function ContractBast()
    {
        return $this->hasMany(ContractBast::class, "id_contract");
    }
    public function SiteInstruction()
    {
        return $this->hasMany(SiteInstruction::class, "id_contract");
    }
    public function TechnicalForm()
    {
        return $this->hasMany(TechnicalForm::class, "id_contract");
    }
    public function TechnicalQuery()
    {
        return $this->hasMany(TechnicalQuery::class, "id_contract");
    }
    public function FieldChange()
    {
        return $this->hasMany(FieldChange::class, "id_contract");
    }
    public function ChangeNotice()
    {
        return $this->hasMany(ContractChangeNotice::class, "id_contract");
    }
    public function ChangeOrder()
    {
        return $this->hasMany(ContractChangeOrder::class, "id_contract");
    }
    public function ChangeProposal()
    {
        return $this->hasMany(ContractChangeProposal::class, "id_contract");
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
