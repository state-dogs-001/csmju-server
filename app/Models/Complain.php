<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;

    protected $table = 'complains';

    protected $fillable = [
        'title',
        'detail',
        'image',
        'is_del',
    ];

    protected $casts = [
        'is_del' => 'boolean',
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset('images/complains/' . $value) : null;
    }
}
