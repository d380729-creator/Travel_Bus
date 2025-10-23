<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'asal',
        'tujuan',
        'jarak_km',
        'estimated_duration_minutes',
        'harga_dasar',
        'deskripsi',
    ];
}
