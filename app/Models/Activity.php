<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organizer',
        'date_start',
        'date_end',
        'detail',
        'image',
        'is_show',
        'is_del',
    ];

    protected $casts = [
        'date_start' => 'date:Y-m-d',
        'date_end' => 'date:Y-m-d',
        'is_show' => 'boolean',
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getDateStartAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::parse($value)->format('d/m/Y');
        }
    }

    public function getDateEndAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::parse($value)->format('d/m/Y');
        }
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/activities/' . $value);
        }
    }
}
