@extends('layout')

@section('title', 'reportes')

@section('content')

<main class="content fade-in" style="max-width: 500px; margin: 0 auto;">

    {{-- Breadcrumbs personalizadas --}}
    <div style="margin-top: 20px; margin-bottom: 10px; font-size: 1.05em; color: #888;">
        <span>
            <a href="{{ url('/') }}" style="color: #3490dc; text-decoration: none;">Inicio</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: #2c3e50; font-weight: bold;">Reportes</span>
        </span>
    </div>

    {{-- Título --}}
    <h2 class="text-center mb-4" style="font-weight: bold; color: #2c3e50;">Reportes</h2>

    <div class="center-buttons" style="display: flex; flex-direction: column; align-items: stretch; gap: 50px; margin-top: 35px;">
        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/venta_Diaria') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Venta_Diaria 
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">Visualiza las ventas de un día</span>
            </a>
        </div>

        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/Periodo') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Venta por Periodo 
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">Visualiza las ventas en un periodo definido</span>
            </a>
        </div>

        <div class="btn-large-group fade-in">
            <a href="{{ url('/reportes/productos') }}" class="btn-large" style="text-align: left; white-space: nowrap;">
                Productos más vendidos 
                <span class="tooltip-below" style="font-size: 0.60em; color: #888; margin-left: 10px;">Visualiza los productos con más ventas</span>
            </a>
        </div>
    </div>

</main>

@endsection