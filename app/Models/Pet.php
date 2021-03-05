<?php

namespace App\Models;

use App\Models\SimpleService;
use App\Models\PetClinicalHistory;
use App\Models\PetVaccinationCard;
use App\Models\HospitalizedService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory;

    // variables
    const PET_MALE = 'Macho';
    const PET_FEMALE = 'Hembra';

    protected $fillable = [
        'name',
        'species',
        'breed',
        'color',
        'birthdate',
        'sex',
        'photo',
        'fk_id_user'
    ];

    // relations
    public function clients() {
        return $this->belongsTo(Client::class);
    }

    public function petClinicalHistories() {
        return $this->hasMany(PetClinicalHistory::class);
    }

    public function petVaccinationCards() {
        return $this->hasMany(PetVaccinationCard::class);
    }

    public function simpleServices() {
        return $this->hasMany(SimpleService::class);
    }

    public function hospitalizedServices() {
        return $this->hasMany(HospitalizedService::class);
    }
}
