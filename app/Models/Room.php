<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'room_id',
        'room_name_th',
        'room_name_en',
        'personnel_id',
        'building_id',
        'floor',
        'amount_seat',
        'image',
        'type_room_id',
        'is_del',
    ];

    protected $casts = [
        'personnel_id' => 'integer',
        'building_id' => 'integer',
        'amount_seat' => 'integer',
        'type_room_id' => 'integer',
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/rooms/' . $value);
        }
    }
}
