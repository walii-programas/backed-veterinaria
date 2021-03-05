<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vet extends User
{
    use HasFactory;

    protected $fillable = [
        'fk_id_user',
        'cmvp',
    ];

    // relations
    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function petVaccinationCardsDetails() {
    //     return $this->hasMany(PetVaccinationCardDetail::class);
    // }

    // public function simpleservices() {
    //     return $this->hasMany(SimpleServices::class);
    // }

    // public function hospitalizationservices() {
    //     return $this->hasMany(HospitalizationServices::class);
    // }
}
