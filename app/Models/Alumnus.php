<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnus extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_code',
        'name',
        'work_place',
        'job_title',
        'caption',
        'tel_number',
        'image_profile',
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
            return asset('images/alumnus/' . $value);
        }
    }
}
