<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLibrary extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code', 
        'name', 
        'years', 
        'file', 
        'type',
        'is_del',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at', 
    ];

    protected $casts = [
        'is_del' => 'boolean',
    ];

    public function getFileAttribute($value)
    {
        return asset('documents/projects/' . $value);
    }
}
