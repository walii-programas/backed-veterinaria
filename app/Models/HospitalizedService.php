<?php

namespace App\Models;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalizedService extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'diagnosis',
        'description',
        'treatment',
        'cost',
        'weight',
        'temperature',
        'symptoms',
        'observations',
        // 'initial_date',
        // 'final_date',
        'fk_id_pet',
        'fk_id_vet'
    ];

    // relations
    public function pet() {
        return $this->belongsTo(Pet::class);
    }
}
