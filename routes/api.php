<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BorrowingController;
use App\Http\Controllers\Api\ItemController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/borrowing', [BorrowingController::class, 'index']);
    Route::get('/borrowing/{id}', [BorrowingController::class, 'show']);
    Route::post('/borrowing', [BorrowingController::class, 'store']);

    Route::get('/item', [ItemController::class, 'index']);
    Route::get('/item/{id}', [ItemController::class, 'show']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


// Route::prefix('auth')->group(function () {
//     Route::post('/register', [AuthControllerApi::class, 'register']);
//     Route::post('/login', [AuthControllerApi::class, 'login']);


//     Route::middleware(['auth:api', 'role:User'])->group(function () {
//         Route::get('/profile', [AuthControllerApi::class, 'me']);
//         Route::post('/logout', [AuthControllerApi::class, 'logout']);
//         Route::get('/dashboard', [DashboardController::class, 'index']);
//     });
// });

