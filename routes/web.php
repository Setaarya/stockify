<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\UserController;
use App\Http\Controllers\CRUD\SupplierController;
use App\Http\Controllers\CRUD\ProductController;
use App\Http\Controllers\CRUD\CategoryController;
use App\Http\Controllers\CRUD\ProductAttributeController;
use App\Http\Controllers\CRUD\StockTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\manager\ManajerController;
use App\Http\Controllers\staff\StaffController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\SettingController;


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
Route::get('/', [LandingPageController::class, 'index'])->name('index');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginform');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('registerform');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
////////////////////////////////////////////////////////////////////////


Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/home', [AdminController::class, 'index'])->name('admin_home');
        
        Route::get('/admin/products/index', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        Route::get('/admin/stock_transactions/index', [StockTransactionController::class, 'Indexadmin'])->name('admin.stock_transactions.index');
        
        Route::get('/admin/categories', [CategoryController::class, 'adminindex'])->name('admin.categories.index'); 
        Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::get('/admin/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
        Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/admin/suppliers/index', [SupplierController::class, 'adminindex'])->name('admin.suppliers.index');
        Route::get('/admin/suppliers/create', [SupplierController::class, 'admincreate'])->name('admin.suppliers.create');
        Route::get('/admin/suppliers/{supplier}', [SupplierController::class, 'adminshow'])->name('admin.suppliers.show');
        Route::get('/admin/suppliers/{supplier}/edit', [SupplierController::class, 'adminedit'])->name('admin.suppliers.edit');
        Route::post('/admin/suppliers', [SupplierController::class, 'adminstore'])->name('admin.suppliers.store');
        Route::put('/admin/suppliers/{supplier}', [SupplierController::class, 'adminupdate'])->name('admin.suppliers.update'); // Update supplier
        Route::delete('/admin/suppliers/{supplier}', [SupplierController::class, 'admindestroy'])->name('admin.suppliers.destroy');
        
        Route::get('/admin/product_attributes', [ProductAttributeController::class, 'index'])->name('admin.product_attributes.index'); 
        Route::get('/admin/product_attributes/create', [ProductAttributeController::class, 'create'])->name('admin.product_attributes.create');
        Route::get('/admin/product_attributes/{productAttribute}', [ProductAttributeController::class, 'show'])->name('admin.product_attributes.show');
        Route::get('/admin/product_attributes/{productAttribute}/edit', [ProductAttributeController::class, 'edit'])->name('admin.product_attributes.edit');
        Route::post('/admin/product_attributes', [ProductAttributeController::class, 'store'])->name('admin.product_attributes.store');
        Route::put('/admin/product_attributes/{productAttribute}', [ProductAttributeController::class, 'update'])->name('admin.product_attributes.update');
        Route::delete('/admin/product_attributes/{productAttribute}', [ProductAttributeController::class, 'destroy'])->name('admin.product_attributes.destroy');        
        
        Route::get('/admin/users/index', [UserController::class, 'adminindex'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/admin/reports/index', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/admin/reports/stock_transaction', [ReportController::class, 'stockindex'])->name('admin.reports.stock_report');
        Route::get('/admin/reports/stock', [ReportController::class, 'transactionindex'])->name('admin.reports.transaction_report');
        Route::get('/admin/reports/export/stock_transactions', [ReportController::class, 'exportTransactionReport'])->name('admin.reports.export.transactions');
        Route::get('/admin/reports/export/products', [ReportController::class, 'exportStockReport'])->name('admin.reports.export.stocks');
        
        Route::get('/admin/reports/user_activities', [UserActivityController::class, 'index'])->name('admin.reports.user_activities');

        Route::get('/export-products', [ProductController::class, 'export'])->name('admin.export.products');
    
        Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');

        Route::get('/admin/stock_opname/export', [StockOpnameController::class, 'exportStockOpname'])->name('admin.stock_opname.export');
        Route::get('/admin/stock_opname', [StockOpnameController::class, 'showLatestStockOpname'])->name('admin.stock_opname.index');
        Route::post('/admin/stock_opname/adjust/{id}', [StockOpnameController::class, 'adjustStock']);
    });

    Route::middleware(['role:Manajer Gudang'])->group(function () {
        Route::get('/manager/home', [ManajerController::class, 'index'])->name('manager_home');
        
        Route::get('/manager/products/index', [ProductController::class, 'managerIndex'])->name('manager.products.index');
        Route::get('/manager/products/{product}', [ProductController::class, 'managerShow'])->name('manager.products.show');
        
        Route::get('/manager/suppliers/index', [SupplierController::class, 'managerIndex'])->name('manager.suppliers.index');
        
        Route::get('/manager/stock_transactions/index', [StockTransactionController::class, 'managerindex'])->name('manager.stock_transactions.index');
        Route::get('/manager/stock_transactions/create', [StockTransactionController::class, 'create'])->name('manager.stock_transactions.create');
        Route::post('/manager/stock_transactions', [StockTransactionController::class, 'store'])->name('manager.stock_transactions.store');
        Route::get('/manager/stock_transactions/{stockTransaction}', [StockTransactionController::class, 'managerShow'])->name('manager.stock_transactions.show');
        Route::get('/manager/stock_transactions/{stockTransaction}/edit', [StockTransactionController::class, 'manageredit'])->name('manager.stock_transactions.edit');
        Route::put('/manager/stock_transactions/{stockTransaction}', [StockTransactionController::class, 'managerupdate'])->name('manager.stock_transactions.update');

        Route::get('/manager/reports/index', [ReportController::class, 'managerindex'])->name('manager.reports.index');
        Route::get('/manager/reports/stock_transaction', [ReportController::class, 'managerstockindex'])->name('manager.reports.stock_report');
        Route::get('/manager/reports/stock', [ReportController::class, 'managertransactionindex'])->name('manager.reports.transaction_report');

        Route::get('/manager/stock_opname/', [StockOpnameController::class, 'index'])->name('manager.stock_opname.index');
        Route::post('/manager/stock_opname/update/{id}', [StockOpnameController::class, 'updateManualCount'])->name('manager.stock.opname.update');
        Route::get('/manager/export_stock_opname', [StockOpnameController::class, 'exportToExcel'])->name('manager.export.stock.opname');
        Route::post('/manager/stock-opname/save', [StockOpnameController::class, 'saveStockOpname'])->name('manager.stock.opname.save');
    });

    Route::middleware(['role:Staff Gudang'])->group(function () {
        Route::get('/staff/home', [StaffController::class, 'index'])->name('staff_home');
        
        Route::get('/stock-transactions/pending', [StockTransactionController::class, 'pending'])->name('stock_transactions.pending');
        Route::patch('/stock-transactions/{id}/confirm', [StockTransactionController::class, 'confirm'])->name('stock_transactions.confirm');
        Route::get('/staff/stock_transactions/index', [StockTransactionController::class, 'staffIndex'])->name('stock_transactions.staff_index');
    });
});
?>
