<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta; // Importa el modelo DetalleVenta
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
            'cantidad_salida' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'precio' => 'required|numeric|min:0',
        ]);

        Producto::create([
            'Nombre' => $request->nombre,
            'Descripcion' => $request->descripcion,
            'Stock_Minimo' => $request->stock_minimo,
            'Existencia' => $request->existencia,
            'Cantidad_Salida' => $request->cantidad_salida,
            'Fecha' => $request->fecha,
            'Precio' => $request->precio,
            'FK_Id_Categoria' => $request->categoria,
        ]);

        return redirect('/catalogos/productos')->with('success', 'Producto agregado correctamente.');
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
        return view('catalogos.categoriasAgregar');
    }

    public function categoriasAgregarPost(Request $request)
    {
        $validated = $request->validate([
            'Nombre' => 'required|max:50',
            'Descripcion' => 'required',
        ]);

        Categoria::create([
            'Nombre' => $validated['Nombre'],
            'Descripcion' => $validated['Descripcion'],
        ]);

        return redirect('/catalogos/categorias')->with('success', 'Categoría agregada correctamente.');
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

        Proveedor::create($validated);

        return redirect('/catalogos/proveedores')->with('success', 'Proveedor agregado correctamente.');
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

        Cliente::create($validated);

        return redirect('/catalogos/clientes')->with('success', 'Cliente agregado correctamente.');
    }

    // VENTAS - listado de ventas
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

    // DETALLE DE VENTA
public function detalleVenta(int $id): View
{
    $detalles = DetalleVenta::with(['venta.cliente', 'producto'])
        ->where('FK_Id_Venta', $id)
        ->get();

    return view('catalogos.detalleVenta', [
        'detalles' => $detalles,
        'idVenta' => $id,
        'breadcrumbs' => [
            'Inicio' => url('/'),
            'Ventas' => url('/catalogos/ventas'),
            'Detalle' => ''
        ]
    ]);
}

}
