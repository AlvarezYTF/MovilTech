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

    // Productos (Inventario) - Resource route
    Route::resource('products', ProductController::class);

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


    // Reparaciones - Resource route
    Route::resource('repairs', RepairController::class);

    // Reportes
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/repairs', [ReportController::class, 'repairsReport'])->name('reports.repairs');
    Route::post('reports/pdf', [ReportController::class, 'generatePDF'])->name('reports.pdf');

    // Facturación - con middleware de permisos
    Route::middleware('permission:generate_invoices')->group(function () {
        Route::get('/sales/{sale}/invoice', [SaleController::class, 'generateInvoice'])->name('sales.invoice');
        Route::get('/sales/{sale}/download', [SaleController::class, 'downloadInvoice'])->name('sales.download');
    });
});
