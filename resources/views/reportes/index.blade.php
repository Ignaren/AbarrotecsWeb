@extends('layout')

@section('title', 'Reportes')

@section('content')
<main class="content fade-in" style="display: flex; flex-direction: column; align-items: center;">
  <h1 style="margin-bottom: 2rem;">Reportes del Sistema</h1>

  <div class="center-buttons">
    <div class="btn-large-group fade-in" style="margin-top: 20px;">
      <a href="{{ route('reportes.ventasDiarias') }}" class="btn-large">
        Ventas Diarias
        <div class="tooltip-below">Consulta las ventas por día</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 20px;">
      <a href="{{ route('reportes.ventasPeriodo') }}" class="btn-large">
        Ventas por Periodo
        <div class="tooltip-below">Filtra ventas por rango de fechas</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 20px;">
      <a href="{{ route('reportes.productosMasVendidos') }}" class="btn-large">
        Productos Más Vendidos
        <div class="tooltip-below">Top productos por cantidad vendida</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 20px;">
      <a href="{{ route('reportes.clientesFrecuentes') }}" class="btn-large">
        Clientes Más Frecuentes
        <div class="tooltip-below">Clientes con más compras</div>
      </a>
    </div>
  </div>

  <!-- Botón para volver al inicio -->
  <div style="margin-top: 40px;">
    <a href="{{ url('/') }}" class="btn">Volver al Inicio</a>
  </div>
</main>
@endsection
