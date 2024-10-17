<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/brands', [AdminController::class, 'brands'])->name("admin.brands");
    Route::get('admin/brands/add', [AdminController::class, 'brand_add'])->name('admin.brands.add');
    Route::post('admin/brands/store', [AdminController::class, 'brand_store'])->name('admin.brands.store');
    Route::get('admin/brands/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brands.edit');
    Route::put('admin/brands/update', [AdminController::class, 'brand_update'])->name('admin.brands.update');
    Route::delete('admin/brands/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brands.delete');

    Route::get('admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    route::put('admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
});

Route::middleware(['auth'])->group(function(){
    Route::get('user', [UserController::class, 'index'])->name('user.index');
});

