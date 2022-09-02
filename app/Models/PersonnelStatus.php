<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelStatus extends Model
{
    use HasFactory;

    protected $table = 'personnel_status';

    protected $fillable = [
        'status',
    ];
}
