<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'play_nomor',
        'jumlah_kursi',
        'type',
        'is_active',
    ];
}
