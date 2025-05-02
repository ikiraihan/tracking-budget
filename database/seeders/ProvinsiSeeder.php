<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProvinsiSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/provinsi.csv');
        $data = array_map('str_getcsv', file($path));

        foreach ($data as $row) {
            DB::table('provinsi')->insert([
                'id' => $row[0],
                'nama' => $row[1],
                'slug' => Str::slug($row[1]),
            ]);
        }
    }
}
