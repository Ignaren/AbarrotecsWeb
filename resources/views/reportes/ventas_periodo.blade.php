@extends('layout')

@section('title', 'Ventas por Periodo')

@section('content')
<main class="content fade-in" style="max-width: 700px; margin: 0 auto;">
    {{-- Breadcrumbs dinámicos --}}
    @if(isset($breadcrumbs) && count($breadcrumbs))
        <nav style="margin-top: 20px; margin-bottom: 10px; font-size: 1.05em; color: #888;">
            @foreach($breadcrumbs as $label => $url)
                @if($loop->last)
                    <span style="color: #2c3e50; font-weight: bold;">{{ $label }}</span>
                @else
                    <a href="{{ $url }}" style="color: #3490dc; text-decoration: none;">{{ $label }}</a>
                    <span style="margin: 0 6px;">/</span>
                @endif
            @endforeach
        </nav>
    @endif

    <h2 class="mb-4" style="font-weight: bold; color: #2c3e50;">Ventas por periodo</h2>
    <form method="GET" action="{{ url('/reportes/ventas_periodo') }}" class="mb-4" style="display: flex; align-items: center; gap: 1rem;">
        <label style="margin-bottom: 0;">De:</label>
        <input type="date" name="fecha_inicio" value="{{ $fecha_inicio }}" style="padding: 0.3rem 0.7rem;">
        <label style="margin-bottom: 0;">a</label>
        <input type="date" name="fecha_fin" value="{{ $fecha_fin }}" style="padding: 0.3rem 0.7rem;">
        <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.3rem 1.2rem;">Ver ventas</button>
    </form>

    @if($ventas->count())
        <table class="table table-bordered" style="width: 100%; background: #fff;">
            <thead style="background: #f5f5f5;">
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
        <p style="color: #888;">No hay ventas para este periodo.</p>
    @endif
</main>
@endsection
