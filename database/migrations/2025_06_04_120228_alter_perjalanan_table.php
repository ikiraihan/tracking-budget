<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perjalanan', function (Blueprint $table) {
            $table->datetime('last_updated_bukti_pembayaran')->nullable()->after('path_bukti_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perjalanan', function (Blueprint $table) {
            $table->dropColumn('last_updated_bukti_pembayaran');  
        });
    }
};
