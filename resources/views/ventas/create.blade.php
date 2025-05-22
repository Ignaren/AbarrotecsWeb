@extends('layout')

@section('content')
<div class="container">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/catalogos/ventas') }}">Ventas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Venta</li>
        </ol>
    </nav>

    <h2>Registrar Venta</h2>

    @if ($errors->any())
        <div class="alert alert-danger" style="font-weight: bold; color: #b00020; background-color: #fddede; padding: 10px; border-radius: 5px;">
            <strong>¡Error!</strong> {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" style="font-weight: bold; color: #1e4620; background-color: #d4edda; padding: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf

        <div class="mb-3">
            <label for="Fecha" class="form-label">Fecha</label>
            <input type="date" name="Fecha" id="Fecha" class="form-control" value="{{ old('Fecha', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="FK_Id_Cliente" class="form-label">Cliente</label>
            <select name="FK_Id_Cliente" id="FK_Id_Cliente" class="form-select" required>
                <option value="">-- Seleccione un cliente --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->PK_Id_Cliente }}" {{ old('FK_Id_Cliente') == $cliente->PK_Id_Cliente ? 'selected' : '' }}>
                        {{ $cliente->Nombre }} {{ $cliente->Apellido ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <h4>Productos</h4>

        <table class="table table-bordered" style="min-width: 900px;" id="productos-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Producto</th>
                    <th style="width: 15%;">Cantidad</th>
                    <th style="width: 15%;">Precio Unitario</th>
                    <th style="width: 15%;">Subtotal</th>
                    <th style="width: 15%;"></th>
                </tr>
            </thead>
            <tbody id="productos-container">
                <!-- Filas se agregan dinámicamente -->
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary mb-3" onclick="agregarProducto()">Agregar Producto</button>

        <div class="mb-3">
            <label for="Total" class="form-label">Total:</label>
            <input type="text" id="total" class="form-control" readonly>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar Venta</button>
            <a href="{{ url('/catalogos/ventas') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<style>
  #productos-table td select,
  #productos-table td input {
    min-width: 150px;
  }
</style>

<script>
    const productosData = @json($productos);
    let index = 0;

    function agregarProducto() {
        const container = document.getElementById('productos-container');

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="productos[${index}][FK_Id_Producto]" class="form-select w-100" onchange="actualizarPrecio(${index})" required>
                    <option value="">-- Selecciona --</option>
                    ${productosData.map(p => `<option value="${p.PK_Id_Producto}" data-precio="${p.Precio}">${p.Nombre}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="productos[${index}][Cantidad]" class="form-control w-100" min="1" value="1" oninput="actualizarSubtotal(${index})" required></td>
            <td><input type="text" id="precio-${index}" class="form-control w-100" readonly></td>
            <td><input type="text" id="subtotal-${index}" class="form-control w-100" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this)">X</button></td>
        `;

        container.appendChild(row);
        index++;
    }

    function actualizarPrecio(i) {
        const select = document.querySelector(`select[name="productos[${i}][FK_Id_Producto]"]`);
        const precio = select.selectedOptions[0]?.dataset.precio || 0;

        document.getElementById(`precio-${i}`).value = parseFloat(precio).toFixed(2);
        actualizarSubtotal(i);
    }

    function actualizarSubtotal(i) {
        const cantidad = parseInt(document.querySelector(`input[name="productos[${i}][Cantidad]"]`).value) || 0;
        const precio = parseFloat(document.getElementById(`precio-${i}`).value) || 0;

        const subtotal = cantidad * precio;
        document.getElementById(`subtotal-${i}`).value = subtotal.toFixed(2);

        actualizarTotal();
    }

    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll('[id^="subtotal-"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total').value = total.toFixed(2);
    }

    function eliminarProducto(btn) {
        btn.closest('tr').remove();
        actualizarTotal();
    }

    window.onload = function () {
        agregarProducto();
    }
</script>
@endsection
