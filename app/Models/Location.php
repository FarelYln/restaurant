<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = [
        'name', 
        'floor'
    ];

    // Relasi One to Many ke Meja
    public function meja()
    {
        return $this->hasMany(Meja::class);
    }
}