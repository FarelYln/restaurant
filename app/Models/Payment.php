<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'reservasi_id', 
        'payment_method', 
        'total_bayar', 
        'status',
        'nomor_referensi'
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    // Generate nomor referensi sederhana
    public static function generateReferenceNumber()
    {
        return 'PAY-' . strtoupper(Str::random(6)) . '-' . date('Ymd');
    }
}