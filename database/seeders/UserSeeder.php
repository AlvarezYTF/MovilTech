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
        // Usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@moviltech.com',
            'password' => Hash::make('Brandon-Administrador-2025#'),
        ]);
        $admin->assignRole('Administrador');

        // Usuario vendedor
        $seller = User::create([
            'name' => 'Vendedor',
            'username' => 'vendedor',
            'email' => 'vendedor@moviltech.com',
            'password' => Hash::make('Vendedor2025#'),
        ]);
        $seller->assignRole('Vendedor');
    }
}
