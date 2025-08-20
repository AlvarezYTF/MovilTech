<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Juan Carlos Pérez',
                'email' => 'juan.perez@email.com',
                'phone' => '+1-555-0201',
                'address' => 'Calle Principal 123, Ciudad',
                'identification' => '12345678',
                'type' => 'individual',
                'is_active' => true,
            ],
            [
                'name' => 'María Elena García',
                'email' => 'maria.garcia@email.com',
                'phone' => '+1-555-0202',
                'address' => 'Avenida Central 456, Pueblo',
                'identification' => '87654321',
                'type' => 'individual',
                'is_active' => true,
            ],
            [
                'name' => 'Carlos Alberto López',
                'email' => 'carlos.lopez@email.com',
                'phone' => '+1-555-0203',
                'address' => 'Plaza Mayor 789, Villa',
                'identification' => '11223344',
                'type' => 'individual',
                'is_active' => true,
            ],
            [
                'name' => 'Empresa Tech Solutions',
                'email' => 'ventas@techsolutions.com',
                'phone' => '+1-555-0204',
                'address' => 'Zona Industrial 321, Ciudad',
                'identification' => 'EMP-001',
                'type' => 'business',
                'is_active' => true,
            ],
            [
                'name' => 'Ana Sofía Rodríguez',
                'email' => 'ana.rodriguez@email.com',
                'phone' => '+1-555-0205',
                'address' => 'Calle Nueva 654, Barrio',
                'identification' => '55667788',
                'type' => 'individual',
                'is_active' => true,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
