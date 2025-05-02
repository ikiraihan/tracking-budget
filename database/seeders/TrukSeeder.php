<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrukSeeder extends Seeder
{
    public function run()
    {
        DB::table('truk')->insert([
            [
                'no_polisi' => 'B1234CD',
                'nama' => 'Truk 1',
                'path_photo' => '/uploads/truk/truk.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_polisi' => 'D5678EF',
                'nama' => 'Truk 2',
                'path_photo' => '/uploads/truk/truk_2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_polisi' => 'F9012GH',
                'nama' => 'Truk 3',
                'path_photo' => '/uploads/truk/truk.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_polisi' => 'Z3456IJ',
                'nama' => 'Truk 4',
                'path_photo' => '/uploads/truk/truk_2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_polisi' => 'E7890KL',
                'nama' => 'Truk 5',
                'path_photo' => '/uploads/truk/truk.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
