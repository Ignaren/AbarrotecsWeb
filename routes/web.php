<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\VentasController;
use App\Models\Venta; // Asegúrate de importar tu modelo Venta

// Ruta de inicio home (NO TOCAR!!!)
Route::get('/', [CatalogosController::class, 'home'])->name('inicio');

//-------------------
// RUTAS DE INFORMACION (NO TOCAR!!!)
Route::get('/informacion', function () {
    return view('informacion');
})->name('informacion');

Route::get('/sobre-nosotros', function () {
    return view('sobreNosotros');
})->name('sobreNosotros');

//-------------------------
// Vistas de catálogos
Route::get('/catalogos/categorias', [CatalogosController::class, 'categoriasGet'])->name('categorias.index');
Route::get('/catalogos/productos', [CatalogosController::class, 'productosGet'])->name('productos.index');
Route::get('/catalogos/proveedores', [CatalogosController::class, 'proveedoresGet'])->name('proveedores.index');
Route::get('/catalogos/clientes', [CatalogosController::class, 'clientesGet'])->name('clientes.index');
Route::get('/catalogos/ventas', [CatalogosController::class, 'ventasGet'])->name('ventas.index');
Route::get('/detalleVenta/{id}', [CatalogosController::class, 'detalleVenta'])->name('detalleVenta');

// Formularios (captura de datos)
// Categorías
Route::get('/catalogos/categorias/agregar', [CatalogosController::class, 'categoriasAgregarGet'])->name('categorias.agregar');
Route::post('/catalogos/categorias/agregar', [CatalogosController::class, 'categoriasAgregarPost'])->name('categorias.guardar');
// Clientes
Route::get('/catalogos/clientes/agregar', [CatalogosController::class, 'clientesAgregarGet'])->name('clientes.agregar');
Route::post('/catalogos/clientes/agregar', [CatalogosController::class, 'clientesAgregarPost'])->name('clientes.guardar');
// Productos
Route::get('/catalogos/productos/agregar', [CatalogosController::class, 'productosAgregarGet'])->name('productos.agregar');
Route::post('/catalogos/productos/agregar', [CatalogosController::class, 'productosAgregarPost'])->name('productos.guardar');
// Proveedores
Route::get('/catalogos/proveedores/agregar', [CatalogosController::class, 'proveedoresAgregarGet'])->name('proveedores.agregar');
Route::post('/catalogos/proveedores/agregar', [CatalogosController::class, 'proveedoresAgregarPost'])->name('proveedores.guardar');

// Ventas
Route::get('/ventas/crear', [VentasController::class, 'create'])->name('ventas.create');
Route::post('/ventas/guardar', [VentasController::class, 'store'])->name('ventas.store');

// Editores
Route::get('/catalogos/categorias/editar/{id}', [CatalogosController::class, 'editarCategoria'])->name('categorias.editar');
Route::post('/catalogos/categorias/editar/{id}', [CatalogosController::class, 'actualizarCategoria'])->name('categorias.actualizar');
// Rutas para editar producto
Route::get('/catalogos/productos/editar/{id}', [CatalogosController::class, 'EditarProducto'])->name('productos.editar');
Route::put('/catalogos/productos/editar/{id}', [CatalogosController::class, 'EditarProductoPost'])->name('productos.actualizar');



// Eliminadores (usando GET para facilitar)
Route::get('/catalogos/categorias/eliminar/{id}', [CatalogosController::class, 'eliminarCategoria'])->name('categorias.eliminar');
Route::delete('/catalogos/productos/eliminar/{id}', [CatalogosController::class, 'EliminarProducto'])->name('productos.eliminar');


// Reabastecer productos
Route::get('/catalogos/productos/reabastecer/{id}', [CatalogosController::class, 'ReabastecerProducto'])->name('productos.reabastecer');
Route::post('/catalogos/productos/reabastecer/{id}', [CatalogosController::class, 'ReabastecerProductoPost'])->name('productos.reabastecer.post');

// Editar proveedor
Route::get('/catalogos/proveedores/editar/{id}', [CatalogosController::class, 'EditarProveedor'])->name('proveedores.editar');
Route::put('/catalogos/proveedores/editar/{id}', [CatalogosController::class, 'ActualizarProveedor'])->name('proveedores.actualizar');

// Eliminar proveedor
Route::delete('/catalogos/proveedores/eliminar/{id}', [CatalogosController::class, 'EliminarProveedor'])->name('proveedores.eliminar');

// Editar cliente
Route::get('/catalogos/clientes/editar/{id}', [CatalogosController::class, 'editarCliente'])->name('clientes.editar');
Route::put('/catalogos/clientes/editar/{id}', [CatalogosController::class, 'actualizarCliente'])->name('clientes.actualizar');

// Eliminar cliente
Route::get('/catalogos/clientes/eliminar/{id}', [CatalogosController::class, 'eliminarCliente'])->name('clientes.eliminar');


//rutas para ver la vista de reportes
Route::get('/reportes', [CatalogosController::class, 'reportes'])->name('reportes.index');
Route::get('/reportes/venta_diaria', [CatalogosController::class, 'ventaDiaria'])->name('reportes.venta_diaria');
Route::get('/reportes/ventas_periodo', [CatalogosController::class, 'ventasPeriodo'])->name('reportes.ventas_periodo');
Route::get('/reportes/productos_mas_vendidos', [CatalogosController::class, 'productosMasVendidos'])->name('reportes.productos_mas_vendidos');
Route::get('/reportes/clientes_frecuentes', [CatalogosController::class, 'clientesFrecuentes'])->name('reportes.clientes_frecuentes');