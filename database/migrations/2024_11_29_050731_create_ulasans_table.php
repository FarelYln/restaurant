<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_menu'); // Kolom untuk menyimpan ID menu
            $table->unsignedBigInteger('id_user'); // Kolom untuk menyimpan ID pengguna
            $table->integer('rating'); // Kolom untuk menyimpan rating
            $table->text('description'); // Kolom untuk menyimpan deskripsi ulasan
            $table->timestamps();
        
            // Definisikan foreign key
            $table->foreign('id_menu')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ulasans');
    }
};