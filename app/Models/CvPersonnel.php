<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvPersonnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'bachelor_degree',
        'masters_degree',
        'doctoral_degree',
        'bio',
        'experience',
        'expertise'
    ];

    protected $casts = [
        'citizen_id' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
