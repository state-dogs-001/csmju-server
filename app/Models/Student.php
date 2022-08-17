<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'citizen_id',
        'student_code',
        'name_th',
        'name_en',
        'image_profile',
        'email',
        'tel_number',
        'province',
        'district',
        'sub_district',
        'postcode',
        'address',
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
        return asset('images/students/' . $value);
    }
}
