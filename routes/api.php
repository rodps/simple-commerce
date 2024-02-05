<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\ListProductsController;
use App\Http\Controllers\Product\ShowProductController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\User\CreateUserController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group([
    'prefix' => 'users'
], function () {
    Route::post('/', CreateUserController::class);
});

Route::group([
    'prefix' => 'products'
], function () {
    Route::post('/', CreateProductController::class);
    Route::put('/{product}', UpdateProductController::class);
    Route::get('/{product}', ShowProductController::class);
    Route::delete('/{product}', DeleteProductController::class);
    Route::get('/', ListProductsController::class);
});