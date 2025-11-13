<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kota',
        'alamat',
    ];

    public function asal_routes()
    {
        return $this->hasMany(Route::class, 'asal_terminal_id');
    }

    public function tujuan_routes()
    {
        return $this->hasMany(Route::class, 'tujuan_terminal_id');
    }
}
