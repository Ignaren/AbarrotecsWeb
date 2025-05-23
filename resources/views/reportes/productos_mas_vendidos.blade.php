@extends('layout')

@section('content')
<main class="content fade-in">
  <h1>Productos Más Vendidos</h1>

  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Total Vendido</th>
        <th>Unidades</th>
      </tr>
    </thead>
    <tbody>
      @forelse($productos as $producto)
        <tr>
          <td>{{ $producto->Nombre }}</td>
          <td>${{ number_format($producto->total_vendido, 2) }}</td>
          <td>{{ $producto->cantidad_total }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="3">No hay ventas registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</main>
@endsection
