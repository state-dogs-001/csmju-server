<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_id',
        'image',
    ];

    public function information()
    {
        return $this->belongsTo('App\Models\Information', 'information_id');
    }
}
