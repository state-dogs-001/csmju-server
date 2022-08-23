<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_code',
        'name',
        'floor',
        'building',
        'faculty',
        'univerity',
        'room_type',
        'reserve_seats',
        'image',
        'is_del',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'reserve_seats' => 'integer',
        'is_del' => 'boolean',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/classrooms/' . $value);
        }
    }
}
