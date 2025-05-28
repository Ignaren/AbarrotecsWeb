@extends('layout')

@section('title', 'Reportes')

@section('content')

<main class="content fade-in" style="max-width: 500px; margin: 0 auto;">

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

    {{-- Título --}}
    <h2 class="text-center mb-4" style="font-weight: bold; color: #2c3e50;">Reportes</h2>

    <div class="center-buttons" style="display: flex; flex-direction: column; align-items: stretch; gap: 50px; margin-top: 35px;">
        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/venta_diaria') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Venta diaria
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">Reporte de ventas del día</span>
            </a>
        </div>

        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/ventas_periodo') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Venta por periodo
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">Reporte de ventas por rango de fechas</span>
            </a>
        </div>

        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/productos_mas_vendidos') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Productos más vendidos
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">Reporte de productos más vendidos</span>
            </a>
        </div>

        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/clientes_frecuentes') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Clientes frecuentes
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">
                    Clientes con más ventas y el total vendido
                </span>
            </a>
        </div>
    </div>

</main>

@endsection