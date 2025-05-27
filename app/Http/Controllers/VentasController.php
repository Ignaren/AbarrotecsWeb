<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function create()
    {
        // Solo productos activos y no eliminados
        $productos = Producto::where('Estado', 'activo')->where('Eliminado', false)->get();

        // Solo clientes activos y no eliminados
        $clientes = Cliente::where('Estado', 'Activo')->where('Eliminado', false)->get();

        return view('ventas.create', compact('productos', 'clientes'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $hoy = date('Y-m-d');
            $request->validate([
                'Fecha' => ['required', 'date', "before_or_equal:$hoy"],
                'FK_Id_Cliente' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) {
                        $cliente = Cliente::find($value);
                        if (!$cliente || $cliente->Eliminado || $cliente->Estado !== 'Activo') {
                            $fail('El cliente seleccionado no es válido.');
                        }
                    }
                ],
                'productos' => 'required|array|min:1',
                'productos.*.FK_Id_Producto' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) {
                        $producto = Producto::find($value);
                        if (!$producto || $producto->Eliminado || $producto->Estado !== 'activo') {
                            $fail('Uno de los productos seleccionados no es válido.');
                        }
                    }
                ],
                'productos.*.Cantidad' => 'required|integer|min:1',
            ], [
                'Fecha.before_or_equal' => 'La fecha de la venta no puede ser posterior a hoy.',
            ]);

            $venta = Venta::create([
                'Fecha' => $request->Fecha,
                'Total' => 0,
                'FK_Id_Cliente' => $request->FK_Id_Cliente,
            ]);

            $totalVenta = 0;

            foreach ($request->productos as $item) {
                $producto = Producto::where('PK_Id_Producto', $item['FK_Id_Producto'])
                                    ->where('Estado', 'activo')
                                    ->where('Eliminado', false)
                                    ->firstOrFail();

                if ($producto->Existencia < $item['Cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->Nombre}");
                }

                $subtotal = $producto->Precio * $item['Cantidad'];
                $totalVenta += $subtotal;

                DetalleVenta::create([
                    'FK_Id_Venta' => $venta->PK_Id_Venta,
                    'FK_Id_Producto' => $producto->PK_Id_Producto,
                    'Cantidad' => $item['Cantidad'],
                    'Precio_Unitario' => $producto->Precio,
                ]);

                $producto->Existencia -= $item['Cantidad'];
                $producto->save();
            }

            $venta->Total = $totalVenta;
            $venta->save();

            DB::commit();

            return redirect('/catalogos/ventas')->with('success', 'Venta registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}