<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas de autenticación
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Productos (Inventario) - con middleware de permisos
    Route::middleware('permission:view_products')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    });

    Route::middleware('permission:create_products')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    });

    Route::middleware('permission:edit_products')->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    Route::middleware('permission:delete_products')->group(function () {
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Ventas - con middleware de permisos
    Route::middleware('permission:view_sales')->group(function () {
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    });

    // Create
    Route::middleware('permission:create_sales')->group(function () {
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    });

    // Edit
    Route::middleware('permission:edit_sales')->group(function () {
        Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
        Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    });

    // Show (debe ir al final de los GET)
    Route::middleware('permission:view_sales')->group(function () {
        Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    });

    // Delete
    Route::middleware('permission:delete_sales')->group(function () {
        Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    });


    // Reparaciones - con middleware de permisos
    Route::middleware('permission:view_repairs')->group(function () {
        Route::get('/repairs', [RepairController::class, 'index'])->name('repairs.index');
        Route::get('/repairs/{repair}', [RepairController::class, 'show'])->name('repairs.show');
    });

    Route::middleware('permission:create_repairs')->group(function () {
        Route::get('/repairs/create', [RepairController::class, 'create'])->name('repairs.create');
        Route::post('/repairs', [RepairController::class, 'store'])->name('repairs.store');
    });

    Route::middleware('permission:edit_repairs')->group(function () {
        Route::get('/repairs/{repair}/edit', [RepairController::class, 'edit'])->name('repairs.edit');
        Route::put('/repairs/{repair}', [RepairController::class, 'update'])->name('repairs.update');
    });

    Route::middleware('permission:delete_repairs')->group(function () {
        Route::delete('/repairs/{repair}', [RepairController::class, 'destroy'])->name('repairs.destroy');
    });

    // Reportes - con middleware de permisos
    Route::middleware('permission:view_reports')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
        Route::get('/reports/repairs', [ReportController::class, 'repairs'])->name('reports.repairs');
    });

    // Facturación - con middleware de permisos
    Route::middleware('permission:generate_invoices')->group(function () {
        Route::get('/sales/{sale}/invoice', [SaleController::class, 'generateInvoice'])->name('sales.invoice');
        Route::get('/sales/{sale}/download', [SaleController::class, 'downloadInvoice'])->name('sales.download');
    });
});
