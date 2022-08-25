<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDisbursal extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'material_id',
        'quantity',
        'is_del'
    ];

    protected $casts = [
        'material_id' => 'integer',
        'is_del' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
