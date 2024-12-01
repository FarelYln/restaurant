<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('nama_menu');
            $table->decimal('harga', 10, 2);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_ulasan')->nullable();
            $table->foreign('id_ulasan')->references('id')->on('ulasans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
