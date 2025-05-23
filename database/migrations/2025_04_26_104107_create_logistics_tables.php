<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kota_tujuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->bigInteger('uang_setoran_tambahan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('jalurs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->bigInteger('uang_pengembalian_tol')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        // TRUK table
        Schema::create('truk', function (Blueprint $table) {
            $table->id();
            $table->string('no_polisi')->nullable();
            $table->string('nama')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('path_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // SUPIR table
        Schema::create('supir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truk_id')->nullable()->constrained('truk')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('no_sim')->nullable();
            $table->string('path_photo_diri')->nullable();
            $table->string('path_photo_ktp')->nullable();
            $table->string('path_photo_sim')->nullable();
            // $table->date('sim_expired_at')->nullable();
            // $table->enum('jenis_sim', ['A', 'B1', 'B2', 'C'])->default('A');
            $table->boolean('is_active')->default(true);
            // $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('perjalanan', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->foreignId('truk_id')->nullable()->constrained('truk')->onDelete('cascade');
            $table->foreignId('supir_id')->nullable()->constrained('supir')->onDelete('cascade');
            $table->string('jalur_slug')->nullable();
            $table->foreign('jalur_slug')->references('slug')->on('jalurs')->onDelete('cascade');
            $table->string('kota_tujuan_slug')->nullable();
            $table->foreign('kota_tujuan_slug')->references('slug')->on('kota_tujuans')->onDelete('cascade');
            $table->date('tanggal_berangkat')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('muatan')->nullable();
            // $table->enum('jalur',['full-tol','setengah-tol','bawah'])->nullable();
            $table->bigInteger('uang_pengembalian_tol')->default(0);
            $table->bigInteger('uang_subsidi_tol')->default(0);
            $table->bigInteger('uang_kembali')->default(0);
            $table->bigInteger('uang_setoran')->default(0);
            $table->bigInteger('uang_setoran_tambahan')->default(0);
            $table->string('path_struk_kembali')->nullable();
            $table->string('path_bukti_pembayaran')->nullable();
            $table->string('status_slug')->nullable();
            $table->foreign('status_slug')->references('slug')->on('statuses')->onDelete('cascade');
            $table->boolean('is_done')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perjalanan_id')->nullable()->constrained('perjalanan')->onDelete('cascade');
            $table->foreignId('truk_id')->nullable()->constrained('truk')->onDelete('cascade');
            $table->foreignId('supir_id')->nullable()->constrained('supir')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->text('deskripsi')->nullable();
            $table->bigInteger('uang_pengeluaran')->default(0);
            $table->string('path_photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        // PROVINSI table
        // Schema::create('provinsi', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nama')->nullable();
        //     $table->string('slug')->nullable()->unique();
        //     $table->timestamps();
        // });

        // KOTA table
        // Schema::create('kota', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('provinsi_id')->nullable()->constrained('provinsi')->onDelete('cascade');
        //     $table->string('nama')->nullable();
        //     $table->string('slug')->nullable()->unique();
        //     $table->timestamps();
        // });

        // PERJALANAN table
        // Schema::create('perjalanan', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('truk_id')->nullable()->constrained('truk')->onDelete('cascade');
        //     $table->foreignId('supir_id')->nullable()->constrained('supir')->onDelete('cascade');
        //     $table->foreignId('depart_provinsi_id')->nullable()->constrained('provinsi')->onDelete('cascade');
        //     $table->foreignId('depart_kota_id')->nullable()->constrained('kota')->onDelete('cascade');
        //     $table->foreignId('return_provinsi_id')->nullable()->constrained('provinsi')->onDelete('cascade');
        //     $table->foreignId('return_kota_id')->nullable()->constrained('kota')->onDelete('cascade');
        //     $table->date('tanggal_berangkat')->nullable();
        //     $table->date('tanggal_kembali')->nullable();
        //     $table->bigInteger('budget')->default(0);
        //     $table->bigInteger('income')->default(0);
        //     $table->bigInteger('expenditure')->default(0);
        //     $table->boolean('is_done')->default(false);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjalanan');
        Schema::dropIfExists('kota');
        Schema::dropIfExists('provinsi');
        Schema::dropIfExists('supir');
        Schema::dropIfExists('truk');
    }
}
