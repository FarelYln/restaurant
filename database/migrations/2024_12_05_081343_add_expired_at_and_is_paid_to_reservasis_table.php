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
            $table->timestamp('expired_at')->nullable()->after('status_reservasi');
            $table->boolean('is_paid')->default(false)->after('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn('expired_at');
            $table->dropColumn('is_paid');
        });
    }
};
