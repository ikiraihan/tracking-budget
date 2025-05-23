<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'nama' => 'Dalam perjalanan',
                'slug' => Str::slug('dalam-perjalanan'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Proses Reimburse',
                'slug' => Str::slug('proses-reimburse'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Proses Pembayaran',
                'slug' => Str::slug('proses-pembayaran'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Selesai',
                'slug' => Str::slug('selesai'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
