<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
    'asal_terminal_id',
    'tujuan_terminal_id',
    'jarak_km',
    'estimated_duration_minutes',
    'harga_dasar',
    'deskripsi',
];


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function asal_terminal()
    {
        return $this->belongsTo(Terminal::class, 'asal_terminal_id');
    }

    public function tujuan_terminal()
    { 
        return $this->belongsTo(Terminal::class, 'tujuan_terminal_id'); 
    }
}
