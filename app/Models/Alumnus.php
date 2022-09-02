<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'generation',
        'work_place',
        'job_title',
        'caption',
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
