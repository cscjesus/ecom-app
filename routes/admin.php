<?php

use Illuminate\Support\Facades\Route;
//hay que registrar el archivo de rutas en el archivo bootstrap/app.php
Route::get('/', function () {
    return "Hola desde el administrador";
})->name('dashboard');

