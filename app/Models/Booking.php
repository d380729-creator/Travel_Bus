<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'kode_pemesanan',
        'schedule_id',         // <- ubah dari 'jadwal_id'
        'nama_penumpang',
        'email_penumpang',
        'telepon_penumpang',
        'jumlah_kursi',
        'jumlah_total',
        'status',
        'notes',
    ];

    // Relationship ke Schedule
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
