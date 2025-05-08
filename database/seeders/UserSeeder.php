<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'slug' => Str::slug('Admin'),
        ]);
        Role::create([
            'name' => 'Owner',
            'slug' => Str::slug('owner'),
        ]);
        Role::create([
            'name' => 'Supir',
            'slug' => Str::slug('supir'),
        ]);

        User::create([
            'name' => 'Owner',
            'username' => 'owner',
            'password' => Hash::make('owner123'),
            'role_id' => 2,
            'is_active' => true
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'is_active' => true
        ]);
        User::create([
            'name' => 'Joko Anwar',
            'username' => 'joko_anwar',
            'password' => Hash::make('supir123'),
            'role_id' => 3,
            'is_active' => true
        ]);
        User::create([
            'name' => 'Lionel Messi',
            'username' => 'lionel_messi',
            'password' => Hash::make('supir123'),
            'role_id' => 3,
            'is_active' => true
        ]);
    }
}
