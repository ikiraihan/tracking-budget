<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JalurSeeder extends Seeder
{
    public function run()
    {
        DB::table('jalurs')->insert([
            [
                'nama' => 'Full Tol',
                'slug' => Str::slug('full-tol'),
                'uang_pengembalian_tol' => 4200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Setengah Tol',
                'slug' => Str::slug('setengah-tol'),
                'uang_pengembalian_tol' => 3725000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'nama' => 'Bawah',
                'slug' => Str::slug('bawah'),
                'uang_pengembalian_tol' => 3250000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
