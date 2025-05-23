@extends('layout')

@section('content')
<main class="content fade-in">
  <h1>Clientes Más Frecuentes</h1>

  <table>
    <thead>
      <tr>
        <th>Cliente</th>
        <th>Cantidad de Compras</th>
        <th>Total Comprado</th>
      </tr>
    </thead>
    <tbody>
      @forelse($clientes as $cliente)
        <tr>
          <td>{{ $cliente->Nombre }}</td>
          <td>{{ $cliente->ventas_count }}</td>
          <td>${{ number_format($cliente->ventas_total, 2) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="3">No hay registros de clientes frecuentes.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</main>
@endsection
