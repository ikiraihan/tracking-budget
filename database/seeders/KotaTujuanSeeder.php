<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KotaTujuanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kota_tujuans')->insert([
            [
                'nama' => 'Banyuwangi',
                'slug' => Str::slug('banyuwangi'),
                'uang_setoran_tambahan' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Denpasar',
                'slug' => Str::slug('denpasar'),
                'uang_setoran_tambahan' => 200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
