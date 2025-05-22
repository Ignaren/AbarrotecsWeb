<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogosController extends Controller
{
    public function home(): View
    {
        return view('home', ["breadcrumbs" => []]);
    }

    // PRODUCTOS
    public function productosGet(): View
    {
        $productos = Producto::all();

        return view('catalogos.productosGet', [
            'productos' => $productos,
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Productos' => url('/catalogos/productos')
            ]
        ]);
    }

    public function productosAgregarGet(): View
    {
        $categorias = Categoria::all();

        return view('catalogos.productosAgregar', compact('categorias'));
    }

    public function productosAgregarPost(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'categoria' => 'required|exists:categoria,PK_Id_Categoria',
            'descripcion' => 'required',
            'stock_minimo' => 'required|numeric|min:0',
            'existencia' => 'required|numeric|min:0',
            'fecha_entrada' => 'required|date',
            'fecha_caducidad' => 'nullable|date|after_or_equal:fecha_entrada',
            'precio' => 'required|numeric|min:0',
        ]);

        Producto::create([
            'Nombre' => mb_convert_case($request->nombre, MB_CASE_TITLE, "UTF-8"),
            'Descripcion' => mb_convert_case($request->descripcion, MB_CASE_TITLE, "UTF-8"),
            'Stock_Minimo' => $request->stock_minimo,
            'Existencia' => $request->existencia,
            'Fecha_Entrada' => $request->fecha_entrada,
            'Fecha_Caducidad' => $request->fecha_caducidad ?: null,
            'Precio' => $request->precio,
            'FK_Id_Categoria' => $request->categoria,
            'Estado' => 'activo', // Por defecto activo
        ]);

        return redirect('/catalogos/productos')->with('success', 'Producto agregado correctamente.');
    }

    // Mostrar el formulario para editar un producto
    public function EditarProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();

        $breadcrumbs = [
            'Inicio' => url('/'),
            'Productos' => url('/catalogos/productos'),
            'Editar' => '',
        ];

        return view('editores.producto', compact('producto', 'categorias', 'breadcrumbs'));
    }

    // Procesar el formulario POST para actualizar el producto
public function EditarProductoPost(Request $request, $id)
{
    $request->validate([
        'Nombre' => 'required|string|max:255',
        'Descripcion' => 'nullable|string|max:1000',
        'Existencia' => 'required|integer|min:0',
        'Fecha_Caducidad' => 'nullable|date',
        'Precio' => 'required|numeric|min:0',
        'FK_Id_Categoria' => 'required|exists:categoria,PK_Id_Categoria',
        'Estado' => 'required|string|in:activo,inactivo',
    ]);

    $producto = Producto::findOrFail($id);

    // Convertir texto a Title Case según lo solicitado
    $producto->Nombre = ucwords(strtolower($request->Nombre));
    $producto->Descripcion = $request->Descripcion ? ucwords(strtolower($request->Descripcion)) : null;
    $producto->Existencia = $request->Existencia;
    $producto->Fecha_Caducidad = $request->Fecha_Caducidad;
    $producto->Precio = $request->Precio;
    $producto->FK_Id_Categoria = $request->FK_Id_Categoria;
    $producto->Estado = $request->Estado;

    $producto->save();

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}


    // Método para eliminar producto (sin vista)
public function EliminarProducto($id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
}


    // Mostrar formulario de reabastecer producto
    public function ReabastecerProducto($id)
    {
        $producto = Producto::findOrFail($id);

        return view('catalogos.productos.reabastecer', compact('producto'));
    }

    // Procesar el reabastecimiento
    public function ReabastecerProductoPost(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'fecha_entrada' => 'required|date',
            'fecha_caducidad' => 'nullable|date|after_or_equal:fecha_entrada',
        ]);

        $producto = Producto::findOrFail($id);

        // Sumar la cantidad ingresada a la existencia actual
        $producto->Existencia += $request->cantidad;
        $producto->Fecha_Entrada = $request->fecha_entrada;
        $producto->Fecha_Caducidad = $request->fecha_caducidad ?: null;

        $producto->save();

        return redirect('/catalogos/productos')->with('success', 'Producto reabastecido correctamente.');
    }


    // CATEGORÍAS
    public function categoriasGet(): View
    {
        $categorias = Categoria::all();

        return view('catalogos.categoriasGet', [
            'categorias' => $categorias,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Categorías" => url("/catalogos/categorias")
            ]
        ]);
    }

    public function categoriasAgregarGet(): View
    {
        return view('catalogos.categoriasAgregar', [
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Categorías' => url('/catalogos/categorias'),
                'Agregar' => url('/catalogos/categorias/agregar')
            ]
        ]);
    }

    public function categoriasAgregarPost(Request $request)
    {
        $validated = $request->validate([
            'Nombre' => 'required|max:50',
            'Descripcion' => 'required',
        ]);

        $nombreFormateado = mb_convert_case($validated['Nombre'], MB_CASE_TITLE, "UTF-8");
        $descripcionFormateada = mb_convert_case($validated['Descripcion'], MB_CASE_TITLE, "UTF-8");

        Categoria::create([
            'Nombre' => $nombreFormateado,
            'Descripcion' => $descripcionFormateada,
        ]);

        return redirect('/catalogos/categorias')->with('success', 'Categoría agregada correctamente.');
    }

    public function editarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);

        $breadcrumbs = [
            'Inicio' => url('/'),
            'Categorías' => url('/catalogos/categorias'),
            'Editar Categoría' => ''
        ];

        return view('editores.categorias', compact('categoria', 'breadcrumbs'));
    }

    public function actualizarCategoria(Request $request, $id)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'nullable|string',
            'Estado' => 'required|string|in:activo,inactivo',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->Nombre = mb_convert_case($request->Nombre, MB_CASE_TITLE, "UTF-8");
        $categoria->Descripcion = mb_convert_case($request->Descripcion, MB_CASE_TITLE, "UTF-8");
        $categoria->estado = $request->Estado;
        $categoria->save();

        return redirect('/catalogos/categorias')->with('success', 'Categoría actualizada correctamente.');
    }

    public function eliminarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect('/catalogos/categorias')->with('success', 'Categoría eliminada correctamente.');
    }

    // PROVEEDORES
    public function proveedoresGet(): View
    {
        $proveedores = Proveedor::all();

        return view('catalogos.proveedoresGet', [
            'proveedores' => $proveedores,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Proveedores" => url("/catalogos/proveedores")
            ]
        ]);
    }

    public function proveedoresAgregarGet(): View
    {
        return view('catalogos.proveedoresAgregar', [
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Proveedores' => url('/catalogos/proveedores'),
                'Agregar' => url('/catalogos/proveedores/agregar')
            ]
        ]);
    }

    public function proveedoresAgregarPost(Request $request)
    {
        $validated = $request->validate([
            'Nombre' => 'required|max:100',
            'Direccion' => 'required|max:255',
            'Email' => 'required|email|max:100',
            'Telefono' => 'required|max:15',
        ]);

        $validated['Nombre'] = mb_convert_case($validated['Nombre'], MB_CASE_TITLE, "UTF-8");
        $validated['Direccion'] = mb_convert_case($validated['Direccion'], MB_CASE_TITLE, "UTF-8");

        Proveedor::create($validated);

        return redirect('/catalogos/proveedores')->with('success', 'Proveedor agregado correctamente.');
    }

    // Mostrar formulario para editar proveedor
    public function EditarProveedor($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $breadcrumbs = [
            'Inicio' => '/',
            'Proveedores' => url('/catalogos/proveedores'),
            'Editar Proveedor' => '',
        ];
        return view('editores.proveedores', compact('proveedor', 'breadcrumbs'));
    }

    // Actualizar proveedor (procesar el form de editar)
public function ActualizarProveedor(Request $request, $id)
{
    $request->validate([
        'Nombre' => 'required|string|max:255',
        'Telefono' => 'required|string|max:20',
        'Direccion' => 'required|string|max:255',
        'Estado' => 'required|in:Activo,Inactivo',
    ]);

    $proveedor = Proveedor::findOrFail($id);

    $proveedor->Nombre = ucwords(strtolower($request->Nombre));
    $proveedor->Telefono = $request->Telefono;
    $proveedor->Direccion = ucwords(strtolower($request->Direccion));
    $proveedor->Estado = $request->Estado;

    $proveedor->save();

    return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
}


    // Eliminar proveedor
    public function EliminarProveedor($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect(url('/catalogos/proveedores'))->with('success', 'Proveedor eliminado correctamente.');
    }


    // CLIENTES
    public function clientesGet(): View
    {
        $clientes = Cliente::all();

        return view('catalogos.clientesGet', [
            'clientes' => $clientes,
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Clientes' => url('/catalogos/clientes'),
            ]
        ]);
    }

    public function clientesAgregarGet(): View
    {
        return view('catalogos.clientesAgregar', [
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Clientes' => url('/catalogos/clientes'),
                'Agregar' => url('/catalogos/clientes/agregar')
            ]
        ]);
    }

    public function clientesAgregarPost(Request $request)
    {
        $validated = $request->validate([
            'Nombre' => 'required|max:50',
            'Email' => 'nullable|email|max:50',
            'RFC' => 'nullable|max:50',
            'Telefono' => 'nullable|numeric',
            'Direccion' => 'nullable|max:100',
        ]);

        $validated['Nombre'] = mb_convert_case($validated['Nombre'], MB_CASE_TITLE, "UTF-8");
        if (!empty($validated['Direccion'])) {
            $validated['Direccion'] = mb_convert_case($validated['Direccion'], MB_CASE_TITLE, "UTF-8");
        }

        Cliente::create($validated);

        return redirect('/catalogos/clientes')->with('success', 'Cliente agregado correctamente.');
    }
    public function editarCliente($id)
{
    $cliente = Cliente::findOrFail($id);
    return view('editores.clientes', compact('cliente'));
}

public function actualizarCliente(Request $request, $id)
{
    $request->validate([
        'Nombre' => 'required|string|max:255',
        'Email' => 'required|email|max:255',
        'RFC' => 'required|string|max:13',
        'Telefono' => 'required|string|max:15',
        'Direccion' => 'required|string|max:255',
        'Estado' => 'required|in:Activo,Inactivo',
    ]);

    $cliente = Cliente::findOrFail($id);
    $cliente->Nombre = ucwords(strtolower($request->Nombre));
    $cliente->Email = $request->Email;
    $cliente->RFC = strtoupper($request->RFC);
    $cliente->Telefono = $request->Telefono;
    $cliente->Direccion = ucwords(strtolower($request->Direccion));
    $cliente->Estado = $request->Estado;
    $cliente->save();

    return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
}

public function eliminarCliente($id)
{
    $cliente = Cliente::findOrFail($id);
    $cliente->delete();

    return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
}


    // VENTAS
    public function ventasGet(): View
    {
        $ventas = Venta::all();

        return view('catalogos.ventasGet', [
            'ventas' => $ventas,
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Ventas' => url('/catalogos/ventas'),
            ],
        ]);
    }

    public function ventasAgregarGet(): View
    {
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('catalogos.ventasAgregar', compact('clientes', 'productos'));
    }

    public function ventasAgregarPost(Request $request)
    {
        $request->validate([
            'cliente' => 'required|exists:cliente,PK_Id_Cliente',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:producto,PK_Id_Producto',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Validar stock para cada producto
        foreach ($request->productos as $item) {
            $producto = Producto::findOrFail($item['producto_id']);
            if ($producto->Existencia < $item['cantidad']) {
                return back()->withErrors(["stock" => "No hay suficiente stock para el producto: " . $producto->Nombre]);
            }
        }

        // Crear venta
        $venta = Venta::create([
            'FK_Id_Cliente' => $request->cliente,
            'Fecha' => now(),
        ]);

        // Crear detalles y descontar stock
        foreach ($request->productos as $item) {
            DetalleVenta::create([
                'FK_Id_Venta' => $venta->PK_Id_Venta,
                'FK_Id_Producto' => $item['producto_id'],
                'Cantidad' => $item['cantidad'],
            ]);

            $producto = Producto::findOrFail($item['producto_id']);
            $producto->Existencia -= $item['cantidad'];
            $producto->save();
        }

        return redirect('/catalogos/ventas')->with('success', 'Venta registrada correctamente.');
    }

public function detalleVenta($id)
{
    // Obtener los detalles de venta con su producto y la venta con cliente
    $detalles = \App\Models\DetalleVenta::with(['producto', 'venta.cliente'])
        ->where('FK_Id_Venta', $id)
        ->get();

    if ($detalles->isEmpty()) {
        return redirect()->route('ventas.index')->with('error', 'Venta no encontrada o sin detalles.');
    }

    // Para breadcrumbs (opcional, ajusta según tu app)
    $breadcrumbs = [
        'Inicio' => url('/'),
        'Ventas' => route('ventas.index'),
        'Detalle Venta' => '',
    ];

    return view('catalogos.detalleVenta', compact('detalles', 'breadcrumbs'));
}
}