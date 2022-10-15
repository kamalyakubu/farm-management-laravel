<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\CategorySubcategoriesController;
use App\Http\Controllers\Api\SubcategoryAllProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('categories', CategoryController::class);

        // Category Subcategories
        Route::get('/categories/{category}/subcategories', [
            CategorySubcategoriesController::class,
            'index',
        ])->name('categories.subcategories.index');
        Route::post('/categories/{category}/subcategories', [
            CategorySubcategoriesController::class,
            'store',
        ])->name('categories.subcategories.store');

        Route::apiResource('subcategories', SubcategoryController::class);

        // Subcategory All Products
        Route::get('/subcategories/{subcategory}/all-products', [
            SubcategoryAllProductsController::class,
            'index',
        ])->name('subcategories.all-products.index');
        Route::post('/subcategories/{subcategory}/all-products', [
            SubcategoryAllProductsController::class,
            'store',
        ])->name('subcategories.all-products.store');

        Route::apiResource('all-products', ProductsController::class);
    });
