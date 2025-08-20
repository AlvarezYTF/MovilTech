<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Inventario
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            'view_suppliers',
            'create_suppliers',
            'edit_suppliers',
            'delete_suppliers',
            
            // Ventas
            'view_sales',
            'create_sales',
            'edit_sales',
            'delete_sales',
            'view_customers',
            'create_customers',
            'edit_customers',
            'delete_customers',
            
            // Facturación
            'generate_invoices',
            'download_invoices',
            
            // Reparaciones
            'view_repairs',
            'create_repairs',
            'edit_repairs',
            'delete_repairs',
            'update_repair_status',
            
            // Reportes
            'view_reports',
            'export_reports',
            
            // Usuarios y roles
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $sellerRole = Role::create(['name' => 'Vendedor']);
        $technicianRole = Role::create(['name' => 'Técnico']);
        $customerRole = Role::create(['name' => 'Cliente']);

        // Asignar permisos al administrador (todos)
        $adminRole->givePermissionTo(Permission::all());

        // Asignar permisos al vendedor
        $sellerRole->givePermissionTo([
            'view_products',
            'view_categories',
            'view_suppliers',
            'view_sales',
            'create_sales',
            'edit_sales',
            'view_customers',
            'create_customers',
            'edit_customers',
            'generate_invoices',
            'download_invoices',
            'view_reports',
        ]);

        // Asignar permisos al técnico
        $technicianRole->givePermissionTo([
            'view_products',
            'view_categories',
            'view_suppliers',
            'view_repairs',
            'create_repairs',
            'edit_repairs',
            'update_repair_status',
            'view_customers',
            'view_reports',
        ]);

        // Asignar permisos al cliente
        $customerRole->givePermissionTo([
            'view_sales',
            'download_invoices',
        ]);
    }
}
