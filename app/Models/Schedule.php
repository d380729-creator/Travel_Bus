<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
         /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'bus_id',
        'route_id',
        'waktu_keberangkatan',
        'waktu_kedatangan',
        'kursi_tersedia',
        'harga',
    ];

}
