<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

Route::prefix('V1')->group(function(){
    Route::middleware(['auth.guard:user-api'])->prefix('user')->group(function (){
        Route::post('login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::get('/brands', [BrandController::class, 'index']);
        Route::get('/brands/{id}', [BrandController::class, 'show']);
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/categories/{id}', [CategoryController::class, 'show']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);
        Route::post('/orders/create', [OrderController::class, 'store']);
        Route::put('/orders/update', [OrderController::class, 'update']);
        Route::delete('/orders/delete', [OrderController::class, 'delete']);
        Route::get('/carts/{userid}', [CartController::class, 'index']);
        Route::post('/carts/create', [CartController::class, 'store']);
        Route::put('/carts/update', [CartController::class, 'update']);
        Route::delete('/carts/delete', [CartController::class, 'delete']);

        Route::prefix('profile')->group(function() {
            Route::post('/user-name-email', [ProfileController::class, 'getNameAndEmailUsers']);
        });
    });
});