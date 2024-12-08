<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ulasan extends Model
{

    
    protected $fillable = [
        'id_user',
        'id_menu',
        'rating',
        'description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id'); // Pastikan ini sesuai dengan nama kolom di database
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id'); // Menghubungkan dengan model Menu
    }
}
