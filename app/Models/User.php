<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'apellidos',
        'direccion',
        'telefono',
        'email',
        'password',
        'terapeuta_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getTherapistName(int $terId): string {
        $data = self::select('name')->find($terId);
        return $data->name;
    }

    public static function getTherapistList() {
        $therapists = self::select('users.id', 'users.name', 'users.apellidos')
            ->join('model_has_roles', "users.id", "=", "model_has_roles.model_id")
            ->where('model_has_roles.role_id', PR_ROL_TERAPEUTA_ID)->get();

        return $therapists;
    }
    
}
