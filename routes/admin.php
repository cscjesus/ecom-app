<?php

use App\Http\Controllers\Admin\FamilyController;
use Illuminate\Support\Facades\Route;
//hay que registrar el archivo de rutas en el archivo bootstrap/app.php
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('families',FamilyController::class);
    // ->parameters(['familier' => 'family'])
    // ->names('admin.families')
    // ->middleware('auth');
