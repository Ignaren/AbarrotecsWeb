<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogosController;

// Ruta de inicio home (NO TOCAR!!!)
Route::get('/', [CatalogosController::class, 'home'])->name('inicio');
//-------------------
//RUTAS DE INFORMACION (NO TOCAR!!!)
Route::get('/informacion', function () {
    return view('informacion');
})->name('informacion');
Route::get('/sobre-nosotros', function () {
    return view('sobreNosotros');
})->name('sobreNosotros');
//-------------------------
//vistas de catalogos
Route::get('/catalogos/categorias', [CatalogosController::class, 'categoriasGet']);
Route::get('/catalogos/productos', [CatalogosController::class, 'productosGet']);
Route::get('/catalogos/proveedores', [CatalogosController::class, 'proveedoresGet']);
Route::get('/catalogos/clientes', [CatalogosController::class, 'clientesGet']);
Route::get('/catalogos/ventas', [CatalogosController::class, 'ventasGet']);
Route::get('/catalogos/ventas/detalle/{id}', [CatalogosController::class, 'detalleVenta']);


