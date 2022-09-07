<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'equip_id',
        'serial_number',
        'name',
        'model',
        'detail',
        'price',
        'quantity',
        'main_type',
        'sub_type',
        'purchase_date',
        'purchase_from',
        'budget',
        'note',
        'status_id',
        'personnel_id',
        'room_id',
        'is_del',
    ];

    protected $casts = [
        'price' => 'double',
        'status_id' => 'integer',
        'personnel_id' => 'integer',
        'purchase_date' => 'date',
        'is_del' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
