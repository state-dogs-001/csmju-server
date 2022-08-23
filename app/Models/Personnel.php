<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'name_title',
        'name_th',
        'name_en',
        'image_profile',
        'email',
        'tel_number',
        'occupation',
        'position',
        'position_type',
        'faculty',
        'edu_level',
        'edu_course_name',
        'edu_major',
        'edu_institute',
        'work_status',
        'is_del',
    ];

    protected $casts = [
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getImageProfileAttribute($value)
    {
        if ($value) {
            return asset('images/personnels/' . $value);
        }
    }
}
