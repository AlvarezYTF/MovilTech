<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador (safe - won't duplicate if exists)
        $admin = User::firstOrCreate(
            ['email' => 'admin@moviltech.com'],
            [
                'name' => 'Administrador',
                'username' => 'admin',
                'password' => Hash::make('Brandon-Administrador-2025#'),
            ]
        );
        if (!$admin->hasRole('Administrador')) {
            $admin->assignRole('Administrador');
        }

        // Usuario vendedor (safe - won't duplicate if exists)
        $seller = User::firstOrCreate(
            ['email' => 'vendedor@moviltech.com'],
            [
                'name' => 'Vendedor',
                'username' => 'vendedor',
                'password' => Hash::make('Vendedor2025#'),
            ]
        );
        if (!$seller->hasRole('Vendedor')) {
            $seller->assignRole('Vendedor');
        }
    }
}
