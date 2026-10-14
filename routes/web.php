<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas web
|--------------------------------------------------------------------------
| El registro público está desactivado: los usuarios los crea un
| administrador desde "Administrar > Usuarios".
*/

Auth::routes(['register' => false]);

Route::redirect('/', '/home');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Perfil del usuario conectado
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');

    // Administración
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('business', [BusinessController::class, 'index'])->name('business.index');
    Route::put('business', [BusinessController::class, 'update'])->name('business.update');
    Route::get('printer', [PrinterController::class, 'index'])->name('printer.index');
    Route::put('printer', [PrinterController::class, 'update'])->name('printer.update');
    Route::post('printer/test', [PrinterController::class, 'test'])->name('printer.test');

    // Catálogos
    Route::resource('categories', CategoryController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('providers', ProviderController::class);
    Route::get('products/lookup', [ProductController::class, 'lookup'])->name('products.lookup');
    Route::resource('products', ProductController::class);
    Route::patch('change_status/products/{product}', [ProductController::class, 'change_status'])->name('change.status.products');

    // Compras
    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('purchases/pdf/{purchase}', [PurchaseController::class, 'pdf'])->name('purchases.pdf');
    Route::post('purchases/upload/{purchase}', [PurchaseController::class, 'upload'])->name('upload.purchases');
    Route::patch('change_status/purchases/{purchase}', [PurchaseController::class, 'change_status'])->name('change.status.purchases');

    // Ventas
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('sales/pdf/{sale}', [SaleController::class, 'pdf'])->name('sales.pdf');
    Route::post('sales/print/{sale}', [SaleController::class, 'print'])->name('sales.print');
    Route::patch('change_status/sales/{sale}', [SaleController::class, 'change_status'])->name('change.status.sales');

    // Reportes
    Route::get('reports/day', [ReportController::class, 'reports_day'])->name('reports.day');
    Route::get('reports/date', [ReportController::class, 'reports_date'])->name('reports.date');
});
