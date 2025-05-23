@extends('layout')

@section('content')
<main class="content fade-in">
  <h1>Reporte de Ventas por Período</h1>

  <form method="GET" action="{{ route('reportes.ventas.periodo') }}">
    <label>Desde:</label>
    <input type="date" name="inicio" value="{{ request('inicio') }}">
    <label>Hasta:</label>
    <input type="date" name="fin" value="{{ request('fin') }}">
    <button type="submit">Consultar</button>
  </form>

  @if($ventas)
    <h2>Ventas del {{ $inicio }} al {{ $fin }}</h2>

    @if($ventas->count())
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          @foreach($ventas as $venta)
            <tr>
              <td>{{ $venta->id }}</td>
              <td>{{ $venta->cliente->Nombre ?? 'N/A' }}</td>
              <td>${{ number_format($venta->total, 2) }}</td>
              <td>{{ $venta->created_at->format('d/m/Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p>No se encontraron ventas en este período.</p>
    @endif
  @endif
</main>
@endsection
