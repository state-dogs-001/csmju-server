<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairmanLineToken extends Model
{
    use HasFactory;

    protected $table = 'repairman_line_tokens';

    protected $fillable = [
        'personnel_id',
        'line_token',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id');
    }
}
