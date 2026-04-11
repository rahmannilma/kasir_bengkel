<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\MechanicSalaryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page - redirect to login or dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->role === 'admin' ? '/admin/dashboard' : '/kasir');
    }
    return redirect('/login');
});

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Kasir routes
Route::middleware(['auth', 'kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [DashboardController::class, 'kasirDashboard'])->name('index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Products
    Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('products.low-stock');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product}/stock', [ProductController::class, 'stockAdjustment'])->name('products.stock');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Distributors
    Route::get('/distributors', [DistributorController::class, 'index'])->name('distributors.index');
    Route::post('/distributors', [DistributorController::class, 'store'])->name('distributors.store');
    Route::put('/distributors/{distributor}', [DistributorController::class, 'update'])->name('distributors.update');
    Route::delete('/distributors/{distributor}', [DistributorController::class, 'destroy'])->name('distributors.destroy');

    // Distributor Notes
    Route::get('/distributor-notes', [DistributorController::class, 'notes'])->name('distributor-notes.index');
    Route::get('/distributor-notes/create', [DistributorController::class, 'createNote'])->name('distributor-notes.create');
    Route::post('/distributor-notes', [DistributorController::class, 'storeNote'])->name('distributor-notes.store');
    Route::get('/distributor-notes/{distributorNote}/edit', [DistributorController::class, 'editNote'])->name('distributor-notes.edit');
    Route::put('/distributor-notes/{distributorNote}', [DistributorController::class, 'updateNote'])->name('distributor-notes.update');
    Route::delete('/distributor-notes/{distributorNote}', [DistributorController::class, 'destroyNote'])->name('distributor-notes.destroy');
    Route::post('/distributor-notes/{distributorNote}/pay', [DistributorController::class, 'payNote'])->name('distributor-notes.pay');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/void', [TransactionController::class, 'void'])->name('transactions.void');

    // Reports
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales-export', [ReportController::class, 'salesExport'])->name('reports.sales-export');
    Route::get('/reports/product-sales', [ReportController::class, 'productSales'])->name('reports.product-sales');
    Route::get('/reports/service-sales', [ReportController::class, 'serviceSales'])->name('reports.service-sales');
    Route::get('/reports/daily-sales', [ReportController::class, 'dailySales'])->name('reports.daily-sales');
    Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    Route::get('/reports/summary', [ReportController::class, 'summary'])->name('reports.summary');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Mechanics
    Route::get('/mechanics', [MechanicController::class, 'index'])->name('mechanics.index');
    Route::get('/mechanics/create', [MechanicController::class, 'create'])->name('mechanics.create');
    Route::post('/mechanics', [MechanicController::class, 'store'])->name('mechanics.store');
    Route::get('/mechanics/{mechanic}/edit', [MechanicController::class, 'edit'])->name('mechanics.edit');
    Route::put('/mechanics/{mechanic}', [MechanicController::class, 'update'])->name('mechanics.update');
    Route::delete('/mechanics/{mechanic}', [MechanicController::class, 'destroy'])->name('mechanics.destroy');
    Route::get('/mechanics/salary', [MechanicSalaryController::class, 'index'])->name('mechanics.salary');
    Route::put('/mechanics/{mechanic}/commission', [MechanicSalaryController::class, 'updateCommission'])->name('mechanics.commission.update');
    Route::post('/mechanics/{mechanic}/salary/paid', [MechanicSalaryController::class, 'markAsPaid'])->name('mechanics.salary.paid');
});

// Transaction store (accessible from kasir)
Route::middleware(['auth'])->group(function () {
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/receipt/{transaction}', [TransactionController::class, 'printReceipt'])->name('receipt');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
});
