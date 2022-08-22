<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'file', 'is_show', 'is_del'
    ];

    protected $casts = [
        'is_show' => 'boolean',
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getFileAttribute($value)
    {
        return asset('documents/official/' . $value);
    }
}
