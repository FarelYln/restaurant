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
            $table->unsignedBigInteger('id_user'); // Foreign key ke tabel users
            $table->enum('rating', [1, 2, 3, 4, 5]); // Rating antara 1-5
            $table->text('description')->nullable(); // Deskripsi ulasan
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ulasans');
    }
};