<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'doc',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'activity_id' => 'integer',
    ];

    //? One to One
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity', 'activity_id');
    }

    public function getDocAttribute($value)
    {
        if ($value) {
            return asset('documents/activities/' . $value);
        }
    }
}
