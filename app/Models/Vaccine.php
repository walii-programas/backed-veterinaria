<?php

namespace App\Models;

use App\Models\PetVaccinationCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 'stock'
    ];

    // relations
    public function petVaccinationCards() {
        return $this->belongsToMany(PetVaccinationCard::class);
    }
}
