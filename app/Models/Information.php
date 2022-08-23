<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'detail',
        'image',
        'link',
        'type',
        'is_show',
        'is_del',
    ];

    protected $casts = [
        'is_show' => 'boolean',
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/news/' . $value);
        }
    }
}
