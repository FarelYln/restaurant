<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meja extends Model
{
    use HasFactory;

    protected $table = 'meja';

    protected $fillable = [
        'nomor_meja',
        'location_id', // Tambahkan location_id
        'kapasitas',
        'status'
    ];

    // Relasi Many to One ke Location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}