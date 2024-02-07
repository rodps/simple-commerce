<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Product\CreateProductController;
use App\Http\Controllers\Admin\Product\DeleteProductController;
use App\Http\Controllers\Admin\Product\ListProductsController;
use App\Http\Controllers\Admin\Product\ShowProductController;
use App\Http\Controllers\Admin\Product\UpdateProductController;
use App\Http\Controllers\Admin\User\CreateUserController;
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

Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::prefix('users')->group(function () {
        Route::post('/', CreateUserController::class)->withoutMiddleware('auth:api');
    });

    Route::prefix('products')->group(function () {
        Route::post('/', CreateProductController::class);
        Route::put('/{product}', UpdateProductController::class);
        Route::get('/{product}', ShowProductController::class);
        Route::delete('/{product}', DeleteProductController::class);
        Route::get('/', ListProductsController::class);
    });
});