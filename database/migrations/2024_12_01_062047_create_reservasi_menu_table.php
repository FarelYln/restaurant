<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservasi_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_menu')->nullable()->constrained('menus')->onDelete('cascade'); // Menghubungkan ke tabel menu
            $table->foreignId('id_reservasi')->constrained('reservasis')->onDelete('cascade'); // Menghubungkan ke tabel reservasi
            $table->integer('jumlah_pesanan'); // Menyimpan jumlah pesanan menu
            $table->timestamps(); // Waktu pembuatan dan pembaruan
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservasi_menu');
    }
};
