<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(ShopController::class)->prefix('shop')->name('shop.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/{prod_slug}', 'product_details')->name('product.details');
});

Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'add_to_cart')->name('add');
    Route::put('/increase-quantity/{rowId}', 'increase_cart_quantity')->name('qty.increase');
    Route::put('/decrease-quantity/{rowId}', 'decrease_cart_quantity')->name('qty.decrease');
    Route::delete('/remove/{rowId}', 'remove_item')->name('item.remove');
    Route::delete('/clear', 'empty_cart')->name('empty');
});

Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/brands', [AdminController::class, 'brands'])->name("admin.brands");
    Route::get('admin/brands/add', [AdminController::class, 'brand_add'])->name('admin.brands.add');
    Route::post('admin/brands/store', [AdminController::class, 'brand_store'])->name('admin.brands.store');
    Route::get('admin/brands/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brands.edit');
    Route::put('admin/brands/update', [AdminController::class, 'brand_update'])->name('admin.brands.update');
    Route::delete('admin/brands/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brands.delete');

    // Route::controller(AdminController::class)->prefix('admin/brands')->name('admin.brands.')->group(function(){
    //     Route::get('add', 'brand_add')->name('add');
    //     Route::post('store', 'brand_store')->name('store');
    //     Route::get('admin/brands/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brands.edit');
    //     Route::put('admin/brands/update', [AdminController::class, 'brand_update'])->name('admin.brands.update');
    //     Route::delete('admin/brands/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brands.delete');
    // });

    Route::get('admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('admin/cateogry/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    Route::get('admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

});

Route::middleware(['auth'])->group(function(){
    Route::get('user', [UserController::class, 'index'])->name('user.index');
});

