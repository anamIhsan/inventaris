<?php

use App\Http\Controllers\Api\BorrowingController;
use App\Http\Controllers\Api\ExitItemController;
use App\Http\Controllers\Api\IncomingItemController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/supplier/{id}', [SupplierController::class, 'show']);

Route::get('/item', [ItemController::class, 'index']);
Route::get('/item/{id}', [ItemController::class, 'show']);

Route::get('/incoming-item', [IncomingItemController::class, 'index']);
Route::get('/incoming-item/{id}', [IncomingItemController::class, 'show']);

Route::get('/exit-item', [ExitItemController::class, 'index']);
Route::get('/exit-item/{id}', [ExitItemController::class, 'show']);

Route::get('/borrowing', [BorrowingController::class, 'index']);
Route::get('/borrowing/{id}', [BorrowingController::class, 'show']);

