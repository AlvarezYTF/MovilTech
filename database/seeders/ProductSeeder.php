<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Smartphone Apple iPhone 15 Pro 128GB',
                'sku' => 'IPH15P-128',
                'category_id' => $categories->where('name', 'Teléfonos')->first()->id,
                'quantity' => 10,
                'price' => 999.99,
                'cost_price' => 800.00,
                'status' => 'active',
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Smartphone Samsung Galaxy S24 256GB',
                'sku' => 'SAMS24-256',
                'category_id' => $categories->where('name', 'Teléfonos')->first()->id,
                'quantity' => 15,
                'price' => 899.99,
                'cost_price' => 720.00,
                'status' => 'active',
            ],
            [
                'name' => 'Carcasa iPhone 15 Pro',
                'description' => 'Carcasa protectora para iPhone 15 Pro',
                'sku' => 'CARC-IPH15P',
                'category_id' => $categories->where('name', 'Accesorios')->first()->id,
                'quantity' => 50,
                'price' => 29.99,
                'cost_price' => 15.00,
                'status' => 'active',
            ],
            [
                'name' => 'Cable USB-C',
                'description' => 'Cable USB-C de alta velocidad 2m',
                'sku' => 'CABLE-USBC-2M',
                'category_id' => $categories->where('name', 'Cables y Cargadores')->first()->id,
                'quantity' => 100,
                'price' => 19.99,
                'cost_price' => 8.00,
                'status' => 'active',
            ],
            [
                'name' => 'Auriculares Bluetooth',
                'description' => 'Auriculares inalámbricos con cancelación de ruido',
                'sku' => 'AUR-BT-NC',
                'category_id' => $categories->where('name', 'Auriculares')->first()->id,
                'quantity' => 25,
                'price' => 79.99,
                'cost_price' => 45.00,
                'status' => 'active',
            ],
            [
                'name' => 'Pantalla iPhone 14',
                'description' => 'Pantalla de repuesto para iPhone 14',
                'sku' => 'PANT-IPH14',
                'category_id' => $categories->where('name', 'Repuestos')->first()->id,
                'quantity' => 8,
                'price' => 199.99,
                'cost_price' => 120.00,
                'status' => 'active',
            ],
            [
                'name' => 'Kit de herramientas',
                'description' => 'Kit completo de herramientas para reparación',
                'sku' => 'KIT-HERR-COMP',
                'category_id' => $categories->where('name', 'Herramientas')->first()->id,
                'quantity' => 12,
                'price' => 149.99,
                'cost_price' => 85.00,
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
