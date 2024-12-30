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
            $table->id(); 
            $table->string('id_reservasi', 6)->unique();
            $table->unsignedBigInteger('id_user'); 
            $table->dateTime('tanggal_reservasi'); 
            $table->enum('status_reservasi', ['pending', 'confirmed', 'completed', 'canceled'])->default('pending'); 
            $table->enum('status_pembayaran', ['dp', 'lunas'])->nullable();
            $table->timestamps(); 
        
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
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
