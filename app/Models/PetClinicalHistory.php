<?php

namespace App\Models;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PetClinicalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'weight',
        'temperature',
        'observations',
        'fk_id_pet'
    ];

    // relations
    public function pets() {
        return $this->belongsTo(Pet::class);
    }
}
