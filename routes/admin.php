<?php

use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;

use Illuminate\Support\Facades\Route;
//hay que registrar el archivo de rutas en el archivo bootstrap/app.php
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('families',FamilyController::class);
Route::resource('categories',CategoryController::class);
Route::resource('subcategories',SubcategoryController::class);
Route::resource('products',ProductController::class);
    // ->parameters(['familier' => 'family'])
    // ->names('admin.families')
    // ->middleware('auth');
