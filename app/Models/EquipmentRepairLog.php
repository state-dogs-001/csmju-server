<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRepairLog extends Model
{
    use HasFactory;

    protected $table = 'equipment_repair_logs';

    protected $fillable = [
        'repair_id',
        'repairman_name',
        'log',
        'spare_part',
        'price',
        'quantity',
        'image',
        'note',
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function repair()
    {
        return $this->belongsTo(EquipmentRepair::class, 'repair_id');
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return $value;
        }
    }
}
