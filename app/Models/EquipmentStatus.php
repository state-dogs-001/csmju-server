<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentStatus extends Model
{
    use HasFactory;

    protected $table = 'equipment_status';

    protected $fillable = [
        'status_name',
    ];
}
