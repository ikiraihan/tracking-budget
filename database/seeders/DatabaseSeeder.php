<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // ProvinsiSeeder::class,
            // KotaSeeder::class,
            JalurSeeder::class,
            KotaTujuanSeeder::class,
            StatusSeeder::class,
            TrukSeeder::class,
            SupirSeeder::class,
        ]);
    }
}
