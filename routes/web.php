<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogosController;

// Ruta de inicio (home)
Route::get('/', [CatalogosController::class, 'home'])->name('inicio');
//RUTAS DE INFORMACION
Route::get('/informacion', function () {
    return view('informacion');
})->name('informacion');

Route::get('/sobre-nosotros', function () {
    return view('sobreNosotros');
})->name('sobreNosotros');
