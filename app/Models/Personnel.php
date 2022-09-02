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
        'position_academic',
        'position_manager',
        'image_profile',
        'email',
        'tel_number',
        'education',
        'personnel_type',
        'academic_type',
        'work_status',
        'is_del',
    ];

    protected $casts = [
        'work_status' => 'integer',
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
