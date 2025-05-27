@extends('layout')

@section('title', 'Ventas Diarias')

@section('content')
<main class="content fade-in" style="max-width: 700px; margin: 0 auto;">
    <h2 class="mb-4">Ventas del día</h2>
    <form method="GET" action="{{ url('/reportes/venta_Diaria') }}" class="mb-4">
        <label>Selecciona una fecha:</label>
        <input type="date" name="fecha" value="{{ $fecha }}">
        <button type="submit" class="btn btn-primary btn-sm">Ver ventas</button>
    </form>

    @if($ventas->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->PK_Id_Venta }}</td>
                        <td>{{ $venta->cliente->Nombre ?? 'Sin cliente' }}</td>
                        <td>{{ $venta->Fecha }}</td>
                        <td>${{ number_format($venta->Total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay ventas para esta fecha.</p>
    @endif
</main>
@endsection