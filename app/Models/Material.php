<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'image',
        'status',
        'is_del'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'status' => 'boolean',
        'is_del' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/materials/' . $value);
        }
    }
}
