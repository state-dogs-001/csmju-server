<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRepair extends Model
{
    use HasFactory;

    protected $table = 'equipment_repairs';

    protected $fillable = [
        'equip_id',
        'equip_name',
        'room',
        'initial_symptoms',
        'image',
        'notifier_name',
        'is_repaired',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room', 'room_id');
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/equip-repair/' . $value);
        }
    }
}
