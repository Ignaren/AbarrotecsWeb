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
        $productos = Producto::all();
        $clientes = Cliente::all();
        return view('ventas.create', compact('productos', 'clientes'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validación
            $request->validate([
                'Fecha' => 'required|date',
                'FK_Id_Cliente' => 'required|integer',
                'productos' => 'required|array|min:1',
                'productos.*.FK_Id_Producto' => 'required|integer',
                'productos.*.Cantidad' => 'required|integer|min:1',
            ]);

            $venta = Venta::create([
                'Fecha' => $request->Fecha,
                'Total' => 0,
                'FK_Id_Cliente' => $request->FK_Id_Cliente,
            ]);

            $totalVenta = 0;

            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['FK_Id_Producto']);

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
