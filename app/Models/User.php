<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'personnel_id',
        'role',
    ];

    protected $hidden = [
        'remember_token',
        'created_at',
        'updated_at',
    ];

    //? Personnel relationship
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function getImageProfileAttribute($value)
    {
        if ($value) {
            return asset('images/personnels/' . $value);
        }
    }
}
