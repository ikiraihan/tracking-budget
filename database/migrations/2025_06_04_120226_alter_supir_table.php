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
        Schema::table('supir', function (Blueprint $table) {
            $table->string('nama_bank')->nullable()->after('alamat');
            $table->bigInteger('rekening')->nullable()->after('nama_bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supir', function (Blueprint $table) {
            $table->dropColumn('rekening');  
            $table->dropColumn('nama_bank');  
        });
    }
};
