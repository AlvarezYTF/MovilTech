<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\ElectronicInvoiceController;
use App\Http\Controllers\CompanyTaxSettingController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

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
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
    
    // Password reset routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Productos (Inventario) - Resource route with rate limiting
    Route::resource('products', ProductController::class)->middleware('throttle:60,1');

    // Clientes - Resource route
    Route::resource('customers', CustomerController::class);

    // Categorías - con middleware de permisos para administradores
    Route::middleware('permission:view_categories')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    });

    Route::middleware('permission:create_categories')->group(function () {
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    });

    Route::middleware('permission:edit_categories')->group(function () {
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    });

    Route::middleware('permission:delete_categories')->group(function () {
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // Show debe ir al final para evitar conflictos con create y edit
    Route::middleware('permission:view_categories')->group(function () {
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    });

    // Ventas - con middleware de permisos
    Route::middleware('permission:view_sales')->group(function () {
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    });

    // Create
    Route::middleware('permission:create_sales')->group(function () {
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store')->middleware('throttle:30,1');
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

    // PDF de ventas - con middleware de permisos
    Route::middleware('permission:view_sales')->group(function () {
        Route::get('/sales/{sale}/pdf', [SaleController::class, 'pdf'])->name('sales.pdf');
    });

    // Facturas electrónicas
    Route::middleware('permission:create_sales')->group(function () {
        Route::post('/sales/{sale}/electronic-invoice/generate', [\App\Http\Controllers\ElectronicInvoiceController::class, 'generate'])
            ->name('electronic-invoices.generate');
    });

    Route::middleware('permission:view_sales')->group(function () {
        Route::get('/electronic-invoices', [\App\Http\Controllers\ElectronicInvoiceController::class, 'index'])
            ->name('electronic-invoices.index');
        Route::get('/electronic-invoices/{electronicInvoice}', [\App\Http\Controllers\ElectronicInvoiceController::class, 'show'])
            ->name('electronic-invoices.show');
        Route::post('/electronic-invoices/{electronicInvoice}/refresh-status', [\App\Http\Controllers\ElectronicInvoiceController::class, 'refreshStatus'])
            ->name('electronic-invoices.refresh-status');
        Route::get('/electronic-invoices/{electronicInvoice}/download-pdf', [\App\Http\Controllers\ElectronicInvoiceController::class, 'downloadPdf'])
            ->name('electronic-invoices.download-pdf');
    });

    Route::middleware('permission:create_sales')->group(function () {
        Route::post('/electronic-invoices/generate/{sale}', [\App\Http\Controllers\ElectronicInvoiceController::class, 'generate'])
            ->name('electronic-invoices.generate');
    });

    // Configuración Fiscal de la Empresa
    Route::middleware('permission:manage_roles')->group(function () {
        Route::get('/company-tax-settings/edit', [CompanyTaxSettingController::class, 'edit'])->name('company-tax-settings.edit');
        Route::put('/company-tax-settings', [CompanyTaxSettingController::class, 'update'])->name('company-tax-settings.update');
    });

    // Tax profile API endpoints (used from Blade views with JavaScript)
    Route::middleware('permission:create_sales')->group(function () {
        Route::get('/api/customers/{customer}/tax-profile', [CustomerController::class, 'getTaxProfile'])->name('api.customers.tax-profile.get');
        Route::post('/api/customers/{customer}/tax-profile', [CustomerController::class, 'saveTaxProfile'])->name('api.customers.tax-profile.save');
    });
});

/*
|--------------------------------------------------------------------------
| TEMPORARY DEPLOYMENT ROUTES - REMOVE AFTER DEPLOYMENT
|--------------------------------------------------------------------------
|
| ⚠️ WARNING: These routes are for deployment purposes only.
| Remove them immediately after completing the deployment.
|
| Usage:
| - /__deploy__?token=YOUR_TOKEN - Deployment dashboard
| - /__infra__/migrate?token=YOUR_TOKEN - Run migrations
| - /__infra__/seed?token=YOUR_TOKEN - Run seeders
| - /__infra__/status?token=YOUR_TOKEN - Check status
|
| IMPORTANT: Change DEPLOYMENT_TOKEN in DeploymentController.php
| before using these routes in production.
|
*/
Route::prefix('__deploy__')->group(function () {
    Route::get('/', [DeploymentController::class, 'index'])->name('deployment.index');
});

Route::prefix('__infra__')->group(function () {
    Route::post('/migrate', [DeploymentController::class, 'migrate'])->name('deployment.migrate');
    Route::get('/migrate', [DeploymentController::class, 'migrate'])->name('deployment.migrate.get');
    Route::post('/seed', [DeploymentController::class, 'seed'])->name('deployment.seed');
    Route::get('/seed', [DeploymentController::class, 'seed'])->name('deployment.seed.get');
    Route::post('/sync-municipalities', [DeploymentController::class, 'syncMunicipalities'])->name('deployment.sync-municipalities');
    Route::get('/sync-municipalities', [DeploymentController::class, 'syncMunicipalities'])->name('deployment.sync-municipalities.get');
    Route::post('/sync-numbering-ranges', [DeploymentController::class, 'syncNumberingRanges'])->name('deployment.sync-numbering-ranges');
    Route::get('/sync-numbering-ranges', [DeploymentController::class, 'syncNumberingRanges'])->name('deployment.sync-numbering-ranges.get');
    Route::post('/sync-measurement-units', [DeploymentController::class, 'syncMeasurementUnits'])->name('deployment.sync-measurement-units');
    Route::get('/sync-measurement-units', [DeploymentController::class, 'syncMeasurementUnits'])->name('deployment.sync-measurement-units.get');
    Route::get('/status', [DeploymentController::class, 'status'])->name('deployment.status');
});
