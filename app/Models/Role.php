<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    // variables
    const ROLE_HABILITADO = 'Habilitado';
    const ROLE_DESHABILITADO = 'Deshabilitado';

    protected $fillable = [
        'name',
        'state'
    ];

    // relations
    public function users() {
        return $this->belongsToMany(User::class);
    }
}
