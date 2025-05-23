@extends('layout')

@section('content')
<main class="content fade-in">
  <h1>Reporte de Ventas Diarias</h1>

  <form method="GET" action="{{ route('reportes.ventas.diarias') }}">
    <label for="fecha">Selecciona la fecha:</label>
    <input type="date" name="fecha" id="fecha" value="{{ request('fecha') ?? date('Y-m-d') }}">
    <button type="submit">Consultar</button>
  </form>

  <h2>Ventas del {{ $fecha }}</h2>

  @if($ventas->count())
    <table>
      <thead>
        <tr>
          <th>ID Venta</th>
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
            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p>No hay ventas registradas en esta fecha.</p>
  @endif
</main>
@endsection
