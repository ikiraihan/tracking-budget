<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class KotaSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/kota.csv');
        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
            DB::table('kota')->insert([
                'id' => $row[0],
                'provinsi_id' => $row[1],
                'nama' => $row[2],
                'slug' => Str::slug($row[2]),
            ]);
        }
    }
}
