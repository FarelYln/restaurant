<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'nama_menu',
        'harga',
        'description',
        'id_ulasan',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu', 'menu_id', 'category_id');
    }

    public function reservasis()
    {
        return $this->belongsToMany(Reservasi::class, 'reservasi_menu', 'id_menu', 'id_reservasi')
            ->withPivot('jumlah_pesanan')
            ->withTimestamps();
    }
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'id_menu', 'id'); // Menghubungkan dengan model Ulasan
    }
}
