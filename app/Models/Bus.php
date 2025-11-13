<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'nama',
        'plat_nomor',
        'jumlah_kursi',
        'type',
        'is_active',
        'current_location',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
