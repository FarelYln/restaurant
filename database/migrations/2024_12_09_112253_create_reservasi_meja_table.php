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
        Schema::create('reservasi_meja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained('reservasis')->onDelete('cascade');
            $table->foreignId('meja_id')->constrained('meja')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reservasi_meja');
    }
};