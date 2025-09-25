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
            'email' => 'admin@moviltech.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Administrador');

        // Usuario vendedor
        $seller = User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@moviltech.com',
            'password' => Hash::make('password'),
        ]);
        $seller->assignRole('Vendedor');

        // Usuario técnico
        $technician = User::create([
            'name' => 'Técnico',
            'email' => 'tecnico@moviltech.com',
            'password' => Hash::make('password'),
        ]);
        $technician->assignRole('Técnico');

        // Usuario cliente
        $customer = User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@moviltech.com',
            'password' => Hash::make('password'),
        ]);
        $customer->assignRole('Cliente');
    }
}
