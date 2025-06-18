<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExitItemController;
use App\Http\Controllers\IncomingItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('checkAuth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('borrowing')->as('borrowing.')->group(function () {
        Route::get('/', [BorrowingController::class, 'index'])->name('index');

        Route::get('/create', [BorrowingController::class, 'create'])->name('form-create');
        Route::post('/store', [BorrowingController::class, 'store'])->name('create');
        Route::get('/edit/{id}', [BorrowingController::class, 'edit'])->name('form-update');
        Route::put('/update/{id}', [BorrowingController::class, 'update'])->name('update');
        Route::put('/status/{id}', [BorrowingController::class, 'updateStatus'])->name('update-status');
        Route::delete('/destroy/{id}', [BorrowingController::class, 'destroy'])->name('delete');
    });

    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');

    Route::middleware('checkManajemen')->group(function () {
        Route::prefix('supplier')->as('supplier.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');

            Route::get('/create', [SupplierController::class, 'create'])->name('form-create');
            Route::post('/store', [SupplierController::class, 'store'])->name('create');
            Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('form-update');
            Route::put('/update/{id}', [SupplierController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [SupplierController::class, 'destroy'])->name('delete');
        });

        Route::prefix('item')->as('item.')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('index');

            Route::get('/create', [ItemController::class, 'create'])->name('form-create');
            Route::post('/store', [ItemController::class, 'store'])->name('create');
            Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('form-update');
            Route::put('/update/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ItemController::class, 'destroy'])->name('delete');
        });

        Route::prefix('incoming-item')->as('incoming-item.')->group(function () {
            Route::get('/', [IncomingItemController::class, 'index'])->name('index');

            Route::get('/create', [IncomingItemController::class, 'create'])->name('form-create');
            Route::post('/store', [IncomingItemController::class, 'store'])->name('create');
            Route::get('/edit/{id}', [IncomingItemController::class, 'edit'])->name('form-update');
            Route::put('/update/{id}', [IncomingItemController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [IncomingItemController::class, 'destroy'])->name('delete');
        });

        Route::prefix('exit-item')->as('exit-item.')->group(function () {
            Route::get('/', [ExitItemController::class, 'index'])->name('index');

            Route::get('/create', [ExitItemController::class, 'create'])->name('form-create');
            Route::post('/store', [ExitItemController::class, 'store'])->name('create');
            Route::get('/edit/{id}', [ExitItemController::class, 'edit'])->name('form-update');
            Route::put('/update/{id}', [ExitItemController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ExitItemController::class, 'destroy'])->name('delete');
        });

    });

    Route::middleware('checkAdmin')->group(function () {
        Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');

            Route::get('/create', [UserController::class, 'create'])->name('form-create');
            Route::post('/store', [UserController::class, 'store'])->name('create');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('form-update');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('delete');
            Route::post('/approve/{id}', [UserController::class, 'approve'])->name('approve');
        });

        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');

            Route::get('/create', [CategoryController::class, 'create'])->name('form-create');
            Route::post('/store', [CategoryController::class, 'store'])->name('create');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('form-update');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });
    });
});

Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
