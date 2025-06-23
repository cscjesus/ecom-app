<?php

use Illuminate\Support\Facades\Route;
//hay que registrar el archivo de rutas en el archivo bootstrap/app.php
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

