<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'images',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'activity_id' => 'integer',
    ];

    //? One to many
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity', 'activity_id');
    }

    public function getImagesAttribute($value)
    {
        if ($value) {
            return asset('images/activities/images/' . $value);
        }
    }
}
