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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id(); // Auto increment ID
            $table->string('id_reservasi', 6)->unique();
            $table->unsignedBigInteger('id_user'); // Foreign key for the user
            $table->dateTime('tanggal_reservasi'); // Tanggal dan waktu reservasi
            $table->enum('status_reservasi', ['pending', 'confirmed', 'completed', 'canceled'])->default('pending'); // Status reservasi
            $table->boolean('is_paid')->default(false); // Kolom untuk status pembayaran, default false
            $table->timestamps(); // created_at dan updated_at
            
            // Foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); // Referensi ke tabel users
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservasis');
    }
};
