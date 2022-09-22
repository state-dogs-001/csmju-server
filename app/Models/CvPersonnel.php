<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvPersonnel extends Model
{
    use HasFactory;

    protected $table = 'cv_personnels';

    protected $fillable = [
        'citizen_id',
        'workplace',
        'bio',
        'skills',
        'experts',
        'experiences',
        'researches',
    ];

    protected $casts = [
        'citizen_id' => 'integer',
        'skills' => 'array',
        'experts' => 'array',
        'experiences' => 'array',
        'researches' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    //? Imgage Profile join from personnels table
    public function getImageProfileAttribute($value)
    {
        if ($value) {
            return asset('images/personnels/' . $value);
        }
    }
}
