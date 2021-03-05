<?php

namespace App\Models;

use App\Models\Vet;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // vars
    const USER_VERIFICADO = 'Si';
    const USER_NO_VERIFICADO = 'No';

    const USER_HABILITADO = 'Habilitado';
    const USER_DESHABILITADO = 'Deshabilitado';

    // general methods
    public static function generateVerificationToken() {
        return Str::random(40);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'dni',
        'phone',
        'address',
        'email',
        'password',
        'verification_token',
        'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'verification_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }  

    // relations
    public function vet() {
        return $this->hasOne(Vet::class, 'fk_id_user');
    }

    public function client() {
        return $this->hasOne(Client::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}
