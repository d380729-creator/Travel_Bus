<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
      /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'kode_pemesanan',
        'jadwal_id',
        'nama_penumpang',
        'email_penumpang',
        'telepon_penumpang',
        'jumlah_kursi',
        'jumlah_total',
        'status',
        'notes',
    ];
}
