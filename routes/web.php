<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubcategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('subcategories', SubcategoryController::class);
        Route::get('all-products', [ProductsController::class, 'index'])->name(
            'all-products.index'
        );
        Route::post('all-products', [ProductsController::class, 'store'])->name(
            'all-products.store'
        );
        Route::get('all-products/create', [
            ProductsController::class,
            'create',
        ])->name('all-products.create');
        Route::get('all-products/{products}', [
            ProductsController::class,
            'show',
        ])->name('all-products.show');
        Route::get('all-products/{products}/edit', [
            ProductsController::class,
            'edit',
        ])->name('all-products.edit');
        Route::put('all-products/{products}', [
            ProductsController::class,
            'update',
        ])->name('all-products.update');
        Route::delete('all-products/{products}', [
            ProductsController::class,
            'destroy',
        ])->name('all-products.destroy');
    });
