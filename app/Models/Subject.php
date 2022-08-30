<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'name_th',
        'name_en',
        'detail',
        'credit',
        'theory_hour',
        'practical_hour',
        'self_hour',
        'term',
        'is_del',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_del' => 'boolean',
    ];
}
