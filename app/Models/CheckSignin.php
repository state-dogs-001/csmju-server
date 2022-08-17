<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSignin extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'user_type',
        'device'
    ];

    protected $hidden = [
        'updated_at'
    ];
}
