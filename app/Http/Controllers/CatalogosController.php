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
        $productos = Producto::where('Eliminado', false)->paginate(5);

        return view('catalogos.productosGet', [
            'productos' => $productos,
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Productos' => url('/catalogos/productos')
            ]
        ]);
    }

<<<<<<< HEAD
    public function productosAgregarGet(): View
    {
        $categorias = Categoria::where('Eliminado', false)->get();
=======
 public function productosAgregarGet()
{
    // Solo categorías activas
    $categorias = \App\Models\Categoria::where('Estado', 'activo')->get();
>>>>>>> 1506bd1652317c221d18bca64d923b18487782f0

        return view('catalogos.productosAgregar', compact('categorias'));
    }

    public function productosAgregarPost(Request $request)
    {
        $hoy = date('Y-m-d');

        $request->validate([
            'nombre' => ['required', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/'],
            'categoria' => ['required', 'exists:categoria,PK_Id_Categoria'],
            'descripcion' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]+$/'],
            'existencia' => ['required', 'numeric', 'min:0'],
            'fecha_entrada' => ['required', 'date', "before_or_equal:$hoy"],
            'fecha_caducidad' => [
                'nullable',
                'date',
                'after:fecha_entrada'
            ],
            'precio' => ['required', 'numeric', 'min:0'],
        ], [
            'nombre.regex' => 'El nombre solo debe contener letras, números y espacios.',
            'descripcion.regex' => 'La descripción solo debe contener letras, números, espacios, comas, puntos o diagonales.',
            'fecha_entrada.before_or_equal' => 'La fecha de entrada no puede ser posterior a hoy.',
            'fecha_caducidad.after' => 'La fecha de caducidad debe ser mayor a la fecha de entrada.',
            'existencia.min' => 'La existencia debe ser mayor o igual a 0.',
        ]);

        Producto::create([
            'Nombre' => mb_strtoupper(trim($request->nombre), "UTF-8"),
            'Descripcion' => mb_strtoupper(trim($request->descripcion), "UTF-8"),
            'Existencia' => $request->existencia,
            'Fecha_Entrada' => $request->fecha_entrada,
            'Fecha_Caducidad' => $request->fecha_caducidad ?: null,
            'Precio' => $request->precio,
            'FK_Id_Categoria' => $request->categoria,
            'Estado' => 'activo',
        ]);

        return redirect('/catalogos/productos')->with('success', 'Producto agregado correctamente.');
    }

    // Mostrar formulario para editar
    public function EditarProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();

        return view('editores.producto', compact('producto', 'categorias'));
    }

    // Procesar formulario POST actualizar producto
    public function EditarProductoPost(Request $request, $id)
    {
        $hoy = date('Y-m-d');

        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/'],
            // Permite letras, números, espacios, comas, puntos y diagonales
            'descripcion' => ['nullable', 'string', 'max:1000', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]+$/'],
            'existencia' => 'required|integer|min:0',
            'fecha_entrada' => ['required', 'date', "before_or_equal:$hoy"],
            'fecha_caducidad' => 'nullable|date|after:fecha_entrada',
            'precio' => 'required|numeric|min:0',
            'fk_id_categoria' => 'required|exists:categoria,PK_Id_Categoria',
            'estado' => 'required|string|in:activo,inactivo',
        ], [
            'nombre.regex' => 'El nombre no debe contener caracteres especiales.',
            'descripcion.regex' => 'La descripción solo debe contener letras, números, espacios, comas, puntos o diagonales.',
            'fecha_entrada.before_or_equal' => 'La fecha de entrada no puede ser posterior a hoy.',
            'fecha_caducidad.after' => 'La fecha de caducidad debe ser mayor a la fecha de entrada.',
        ]);

        $producto = Producto::findOrFail($id);

        $producto->Nombre = mb_strtoupper($request->nombre, "UTF-8");
        $producto->Descripcion = $request->descripcion ? mb_strtoupper($request->descripcion, "UTF-8") : null;
        $producto->Existencia = $request->existencia;
        $producto->Fecha_Entrada = $request->fecha_entrada;
        $producto->Fecha_Caducidad = $request->fecha_caducidad;
        $producto->Precio = $request->precio;
        $producto->FK_Id_Categoria = $request->fk_id_categoria;
        $producto->Estado = $request->estado;

        $producto->save();

        return redirect('/catalogos/productos')->with('success', 'Producto actualizado correctamente.');
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
        $hoy = date('Y-m-d');

        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'fecha_entrada' => ['required', 'date', "before_or_equal:$hoy"],
            'fecha_caducidad' => 'nullable|date|after:fecha_entrada',
        ], [
            'fecha_entrada.before_or_equal' => 'La fecha de entrada no puede ser posterior a hoy.',
            'fecha_caducidad.after' => 'La fecha de caducidad debe ser mayor a la fecha de entrada.',
        ]);

        $producto = Producto::findOrFail($id);

        // Sumar la cantidad ingresada a la existencia actual
        $producto->Existencia += $request->cantidad;
        $producto->Fecha_Entrada = $request->fecha_entrada;
        $producto->Fecha_Caducidad = $request->fecha_caducidad ?: null;

        $producto->save();

        return redirect('/catalogos/productos')->with('success', 'Producto reabastecido correctamente.');
    }

    // Método para eliminar producto (sin vista)
    public function EliminarProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->Eliminado = true;
        $producto->save();

        return redirect('/catalogos/productos')->with('success', 'Producto eliminado correctamente.');
    }

    // CATEGORÍAS
    public function categoriasGet(): View
    {
        $categorias = Categoria::where('Eliminado', false)->paginate(5);

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
            'Nombre' => ['required', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u'],
            'Descripcion' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]+$/u'],
        ], [
            'Nombre.regex' => 'El campo Nombre solo debe contener letras y espacios.',
            'Descripcion.regex' => 'El campo Descripción solo debe contener letras, números, espacios, comas, puntos o diagonales.',
        ]);

        $nombreFormateado = mb_strtoupper($validated['Nombre'], "UTF-8");
        $descripcionFormateada = mb_strtoupper($validated['Descripcion'], "UTF-8");

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
            'Nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u'],
            // Permite letras, números, espacios, comas, puntos y diagonales
            'Descripcion' => ['nullable', 'string', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]*$/u'],
            'Estado' => ['required', 'string', 'in:activo,inactivo'],
        ], [
            'Nombre.regex' => 'El campo Nombre solo debe contener letras y espacios.',
            'Descripcion.regex' => 'El campo Descripción solo debe contener letras, números, espacios, comas, puntos o diagonales.',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->Nombre = mb_strtoupper($request->Nombre, "UTF-8");
        $categoria->Descripcion = mb_strtoupper($request->Descripcion, "UTF-8");
        $categoria->estado = $request->Estado;
        $categoria->save();

        return redirect('/catalogos/categorias')->with('success', 'Categoría actualizada correctamente.');
    }

    public function eliminarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->Eliminado = true;
        $categoria->save();

        return redirect('/catalogos/categorias')->with('success', 'Categoría eliminada correctamente.');
    }

    // PROVEEDORES
    public function proveedoresGet(): View
    {
        $proveedores = Proveedor::where('Eliminado', false)->get();

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
            'Nombre' => ['required', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'Direccion' => 'required|max:255',
            'Telefono' => 'required|max:15',
        ], [
            'Nombre.required' => 'El nombre es obligatorio.',
            'Nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'Nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'Direccion.required' => 'La dirección es obligatoria.',
            'Direccion.max' => 'La dirección no debe exceder los 255 caracteres.',
            'Email.email' => 'El email debe ser una dirección válida.',
            'Email.max' => 'El email no debe exceder los 100 caracteres.',
            'Telefono.required' => 'El teléfono es obligatorio.',
            'Telefono.max' => 'El teléfono no debe exceder los 15 caracteres.',
        ]);

        $validated['Nombre'] = mb_strtoupper($validated['Nombre'], "UTF-8");
        $validated['Direccion'] = mb_strtoupper($validated['Direccion'], "UTF-8");

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
            'Nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            // Permite letras, números, espacios, comas, puntos y diagonales en Dirección
            'Direccion' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]+$/'],
            'Telefono' => 'required|string|max:20',
            'Estado' => 'required|in:Activo,Inactivo',
        ], [
            'Nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'Direccion.regex' => 'La dirección solo puede contener letras, números, espacios, comas, puntos o diagonales.',
        ]);

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->Nombre = mb_strtoupper($request->Nombre, "UTF-8");
        $proveedor->Telefono = $request->Telefono;
        $proveedor->Direccion = mb_strtoupper($request->Direccion, "UTF-8");
        $proveedor->Estado = $request->Estado;

        $proveedor->save();

        return redirect('/catalogos/proveedores')->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar proveedor
    public function EliminarProveedor($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->Eliminado = true;
        $proveedor->save();

        return redirect('/catalogos/proveedores')->with('success', 'Proveedor eliminado correctamente.');
    }

    // CLIENTES
    public function clientesGet(): View
    {
        $clientes = Cliente::where('Eliminado', false)->get();

        return view('catalogos.clientesGet', [
            'clientes' => $clientes,
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Clientes' => url('/catalogos/clientes'),
            ]
        ]);
    }

    // Mostrar formulario para agregar cliente
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

    // Procesar el formulario para agregar cliente
    public function clientesAgregarPost(Request $request)
    {
        $validated = $request->validate([
            'Nombre' => ['required', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'Email' => 'nullable|email|max:50',
            'RFC' => 'nullable|max:50',
            // Permite letras, números, espacios, comas, puntos y diagonales en Dirección
            'Direccion' => 'nullable|max:100|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]*$/',
            'Telefono' => 'nullable|numeric',
        ], [
            'Nombre.regex' => 'No se permiten Numeros/Caracteres especiales',
            'Direccion.regex' => 'La dirección solo puede contener letras, números, espacios, comas, puntos o diagonales.',
        ]);

        $validated['Nombre'] = mb_strtoupper($validated['Nombre'], "UTF-8");
        if (!empty($validated['Direccion'])) {
            $validated['Direccion'] = mb_strtoupper($validated['Direccion'], "UTF-8");
        }

        $validated['Estado'] = 'Activo';

        Cliente::create($validated);

        return redirect('/catalogos/clientes')->with('success', 'Cliente agregado correctamente.');
    }

    // Mostrar formulario para editar cliente
    public function editarCliente($id): View
    {
        $cliente = Cliente::findOrFail($id);
        return view('editores.clientes', compact('cliente'));
    }

    // Procesar formulario para actualizar cliente
    public function actualizarCliente(Request $request, $id)
    {
        $request->validate([
            'Nombre' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'Email' => 'required|email|max:255',
            'RFC' => 'required|string|max:13',
            // Permite letras, números, espacios, comas, puntos y diagonales en Dirección
            'Direccion' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s,\.\/]*$/',
            'Telefono' => 'required|string|max:15',
            'Estado' => 'required|in:Activo,Inactivo',
        ], [
            'Nombre.regex' => 'No se permiten Numeros/Caracteres especiales',
            'Direccion.regex' => 'La dirección solo puede contener letras, números, espacios, comas, puntos o diagonales.',
        ]);

        $cliente = Cliente::findOrFail($id);

        $cliente->Nombre = mb_strtoupper($request->Nombre, "UTF-8");
        $cliente->Email = $request->Email;
        $cliente->RFC = strtoupper($request->RFC);
        $cliente->Telefono = $request->Telefono;
        $cliente->Direccion = mb_strtoupper($request->Direccion, "UTF-8");
        $cliente->Estado = $request->Estado;

        $cliente->save();

        return redirect('/catalogos/clientes')->with('success', 'Cliente actualizado correctamente.');
    }

    // (Opcional) Eliminar cliente
    public function eliminarCliente($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->Eliminado = true;
        $cliente->save();

        return redirect('/catalogos/clientes')->with('success', 'Cliente eliminado correctamente.');
    }

    //v
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

    public function detalleVenta($id)
    {
        // Obtener los detalles de venta con su producto y la venta con cliente
        $detalles = DetalleVenta::with(['producto', 'venta.cliente'])
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

    //seccion de metodos para reportes
    public function reportes()
    {
        return view('reportes.index', [
            'breadcrumbs' => [
                'Inicio' => url('/'),
                'Reportes' => url('/reportes')
            ]
        ]);
    }

    // Mostrar formulario y resultados de ventas diarias
    public function ventaDiaria(Request $request)
    {
        $fecha = $request->input('fecha', date('Y-m-d'));
        $ventas = Venta::whereDate('Fecha', $fecha)->with('cliente')->get();

        return view('reportes.venta_diaria', [
            'fecha' => $fecha,
            'ventas' => $ventas,
        ]);
    }
}