<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class reservasi extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan (optional jika nama tabel mengikuti konvensi plural)
    protected $table = 'reservasis';

    // Menentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_user',
        'id_reservasi',
        'tanggal_reservasi',
        'status_reservasi',
        'metode_pembayaran', 
        'media_pembayaran', 
        'nomor_media', 
        'total_bayar', 
        'expired_at',
        'card_holder_name',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'datetime', // This ensures it's treated as a Carbon instance
        'expired_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Loop hingga ID acak unik ditemukan
            do {
                // ID acak 6 karakter yang terdiri dari huruf kapital dan angka
                $model->id_reservasi = strtoupper(Str::random(6));  // ID acak kapital
            } while (Reservasi::where('id_reservasi', $model->id_reservasi)->exists()); // Cek jika sudah ada
        });
    }

    // Menentukan relasi antara reservasi dan user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    // Menentukan relasi antara reservasi dan meja
    public function meja()
    {
        return $this->belongsToMany(Meja::class, 'reservasi_meja');
    }

    // Menentukan relasi antara reservasi dan pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_reservasi');
    }

     // Relasi Many-to-Many dengan Menu melalui pivot table
     public function menus()
     {
         return $this->belongsToMany(Menu::class, 'reservasi_menu', 'id_reservasi', 'id_menu')
             ->withPivot('jumlah_pesanan')
             ->withTimestamps();
     }
     protected $dates = ['expired_at', 'tanggal_reservasi'];

     public function isExpired()
     {
         return now() > $this->expired_at;
     }
 
     public function getRemainingTimeAttribute()
     {
         if ($this->expired_at && $this->status_reservasi == 'pending') {
             $remaining = now()->diffInSeconds($this->expired_at, false);
             return $remaining > 0 ? $this->formatTime($remaining) : 'Expired';
         }
         return null;
     }
 
     private function formatTime($seconds)
     {
         $hours = floor($seconds / 3600);
         $minutes = floor(($seconds % 3600) / 60);
         $secs = $seconds % 60;
         return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
     }
}
