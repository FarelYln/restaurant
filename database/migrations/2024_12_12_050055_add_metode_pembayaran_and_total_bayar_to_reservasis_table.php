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
        Schema::table('reservasis', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['scan', 'kartu_kredit', 'e_wallet'])->nullable();
            $table->string('media_pembayaran')->nullable();
            $table->string('nomor_media')->nullable(); 
            $table->integer('total_bayar')->nullable();
        });
    }

    public function down()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
            $table->dropColumn('total_bayar');
        });
    }
};
