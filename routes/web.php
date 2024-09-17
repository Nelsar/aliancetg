<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Cart\CartController;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Category\CategoryController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('admin.home.auth');
});



Route::resource('admin/categories', 'App\Http\Controllers\Admin\Category\CategoryController');
Route::resource('admin/products', 'App\Http\Controllers\Admin\Product\ProductController');
Route::resource('admin/brands', 'App\Http\Controllers\Admin\Brand\BrandController');
Route::resource('admin/orders', 'App\Http\Controllers\Admin\Order\OrderController');
Route::resource('admin/departments', 'App\Http\Controllers\Admin\Department\DepartmentController');

Route::get('admin/carts', [CartController::class, 'index'])->name('index');
Route::get('admin/carts/{id}', [CartController::class, 'show'])->name('show');


require __DIR__.'/auth.php';
