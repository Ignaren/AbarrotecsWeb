<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\VentasController;

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

//formularios (captura de datos)
// Mostrar el formulario
//categoria
Route::get('/catalogos/categorias/agregar', [CatalogosController::class, 'categoriasAgregarGet']);
Route::post('/catalogos/categorias/agregar', [CatalogosController::class, 'categoriasAgregarPost']);
//clientes
Route::get('/catalogos/clientes/agregar', [CatalogosController::class, 'clientesAgregarGet']);
Route::post('/catalogos/clientes/agregar', [CatalogosController::class, 'clientesAgregarPost']);
//productos
Route::get('/catalogos/productos/agregar', [CatalogosController::class, 'productosAgregarGet']);
Route::post('/catalogos/productos/agregar', [CatalogosController::class, 'productosAgregarPost']);
//proveedores
Route::get('/catalogos/proveedores/agregar', [CatalogosController::class, 'proveedoresAgregarGet']);
Route::post('/catalogos/proveedores/agregar', [CatalogosController::class, 'proveedoresAgregarPost']);

//ventas
Route::get('/ventas/crear', [VentasController::class, 'create'])->name('ventas.create');
Route::post('/ventas/guardar', [VentasController::class, 'store'])->name('ventas.store');


//editores
Route::get('/catalogos/categorias/editar/{id}', [CatalogosController::class, 'editarCategoria'])->name('categorias.editar');
Route::post('/catalogos/categorias/editar/{id}', [CatalogosController::class, 'actualizarCategoria'])->name('categorias.actualizar');


//eliminadores
Route::get('/catalogos/categorias/eliminar/{id}', [CatalogosController::class, 'eliminarCategoria'])->name('categorias.eliminar');


