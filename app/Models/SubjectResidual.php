<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectResidual extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_type',
        'subject_code',
        'subject_name',
        'section',
        'detail',
        'student_id',
        'advisor',
        'status',
        'is_del',
    ];

    protected $casts = [
        'student_id' => 'integer',
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'updated_at',
    ];
}
