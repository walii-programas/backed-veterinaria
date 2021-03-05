<?php

namespace App\Models;

use App\Models\Pet;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PetVaccinationCard extends Model
{
    // variables
    const NO_VACUNADO = 'No vacunado';
    const VACUNADO = 'Vacunado';

    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'cost',
        'fk_id_pet'
    ];

    // relations
    public function pet() {
        return $this->hasOne(Pet::class);
    }

    public function vaccines() {
        return $this->belongsToMany(Vaccine::class)->withPivot('fk_id_vet', 'date', 'state');
    }
}
