<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner',
        'link',
        'is_show',
        'is_del',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_show' => 'boolean',
        'is_del' => 'boolean',
    ];

    public function getBannerAttribute($value)
    {
        if ($value) {
            return asset('images/banners/' . $value);
        }
    }
}
