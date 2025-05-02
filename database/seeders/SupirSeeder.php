<?php

namespace Database\Seeders;

use App\Models\Supir;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SupirSeeder extends Seeder
{
    public function run()
    {
        // Mendapatkan user secara acak
        $users = User::where('role_id',3)->get();

        foreach ($users as $user) {
            Supir::create([
                'user_id' => $user->id, // Relasi ke user
                'truk_id' => rand(1, 5), // Pilih truk_id secara acak dari data truk yang ada
                'nama' => $user->name,
                'telepon' => fake()->phoneNumber(),
                'alamat' => fake()->address(),
                'no_ktp' => fake()->numerify('################'), 
                'no_sim' => fake()->bothify('SIM-####-####'),
                'path_photo_diri' => Arr::random([
                    '/uploads/supir/diri/diri.jpeg',
                    '/uploads/supir/diri/diri_2.jpg',
                ]),
                'path_photo_ktp' => Arr::random([
                    '/uploads/supir/ktp/ktp_1.png',
                    '/uploads/supir/ktp/ktp_2.jpeg',
                ]),
                'path_photo_sim' => Arr::random([
                    '/uploads/supir/sim/sim_1.png',
                    '/uploads/supir/sim/sim_2.jpg',
                ]),
                // 'sim_expired_at' => fake()->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                // 'jenis_sim' => fake()->randomElement(['A', 'B1', 'B2', 'C']),
                'is_active' => true,
                // 'catatan' => null,
            ]);
        }
    }
}
