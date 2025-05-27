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
Route::get('/catalogos/ventas/detalle/{id}', [CatalogosController::class, 'detalleVenta'])->name('ventas.detalle');

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

// Rutas de reportes
Route::get('/catalogos/reportes', function () {
    return view('catalogos.reportesGet');
})->name('reportes.index');

Route::get('/detalleVenta/{id}', function($id) {
    // Obtén los detalles de la venta por ID
    $detalles = \App\Models\DetalleVenta::where('FK_Id_Venta', $id)->with(['producto', 'venta.cliente'])->get();
    // Puedes agregar breadcrumbs si lo deseas
    return view('catalogos.detalleVenta', compact('detalles', 'id'));
})->name('detalleVenta');

Route::get('/reportes/detallesReportes/{id}', function($id) {
    // Obtén los detalles de la venta por ID
    $detalles = \App\Models\DetalleVenta::where('FK_Id_Venta', $id)->with(['producto', 'venta.cliente'])->get();
    return view('reportes.detallesReportes', compact('detalles', 'id'));
})->name('reportes.detalles');

Route::get('/catalogos/reportes/ventas-diaria', function () {
   
    $hoy = date('Y-m-d');
    $ventas = \App\Models\Venta::whereDate('Fecha', $hoy)->get();
  
    foreach ($ventas as $venta) {
        $venta->cliente_nombre = $venta->cliente->Nombre ?? '---';
    }
    return view('reportes.ventas-diaria', compact('ventas'));
})->name('reportes.venta_diaria');

Route::get('/catalogos/reportes/ventas-periodo', function (\Illuminate\Http\Request $request) {
    $tipo = $request->input('tipo', 'semana');
    $ventas = \App\Models\Venta::query();

    if ($tipo === 'semana' && $request->filled(['semana', 'mes_semana', 'anio_semana'])) {
        $semana = (int)$request->input('semana');
        $mes = (int)$request->input('mes_semana');
        $anio = (int)$request->input('anio_semana');
        // Primer día del mes
        $fechaInicioMes = \Carbon\Carbon::create($anio, $mes, 1);
        // Calcular el rango de la semana seleccionada dentro del mes
        $fechaInicio = $fechaInicioMes->copy()->addWeeks($semana-1)->startOfWeek();
        $fechaFin = $fechaInicio->copy()->endOfWeek();
        // Limitar el rango al mes seleccionado
        if ($fechaInicio < $fechaInicioMes) $fechaInicio = $fechaInicioMes;
        $fechaFinMes = $fechaInicioMes->copy()->endOfMonth();
        if ($fechaFin > $fechaFinMes) $fechaFin = $fechaFinMes;
        $ventas = $ventas->whereBetween('Fecha', [$fechaInicio->toDateString(), $fechaFin->toDateString()]);
    } elseif ($tipo === 'mes' && $request->filled(['mes', 'anio_mes'])) {
        $mes = (int)$request->input('mes');
        $anio = (int)$request->input('anio_mes');
        $fechaInicio = \Carbon\Carbon::create($anio, $mes, 1)->startOfMonth();
        $fechaFin = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth();
        $ventas = $ventas->whereBetween('Fecha', [$fechaInicio->toDateString(), $fechaFin->toDateString()]);
    } elseif ($tipo === 'anio' && $request->filled('anio')) {
        $anio = (int)$request->input('anio');
        $fechaInicio = \Carbon\Carbon::create($anio, 1, 1)->startOfYear();
        $fechaFin = \Carbon\Carbon::create($anio, 1, 1)->endOfYear();
        $ventas = $ventas->whereBetween('Fecha', [$fechaInicio->toDateString(), $fechaFin->toDateString()]);
    } else {
        // Por defecto, muestra la semana actual del mes actual
        $fechaInicio = \Carbon\Carbon::now()->startOfWeek();
        $fechaFin = \Carbon\Carbon::now()->endOfWeek();
        $ventas = $ventas->whereBetween('Fecha', [$fechaInicio->toDateString(), $fechaFin->toDateString()]);
    }

    $ventas = $ventas->get();

    foreach ($ventas as $venta) {
        $venta->cliente_nombre = $venta->cliente->Nombre ?? '---';
    }

    return view('reportes.ventas-periodo', compact('ventas'));
})->name('reportes.ventas_periodo');
Route::get('/catalogos/reportes/productos-mas-vendidos', function () {
  
    $productos = \App\Models\Producto::select('producto.*')
        ->withSum('ventas as cantidad_vendida', 'Cantidad')
        ->orderByDesc('cantidad_vendida')
        ->limit(20)
        ->get();

    return view('reportes.productos-mas-vendidos', compact('productos'));
})->name('reportes.productos_mas_vendidos');


