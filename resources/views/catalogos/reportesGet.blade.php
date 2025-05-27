@extends('layout')

@section('title', 'Reportes')

@section('content')

<main class="content fade-in" style="flex-direction: column; align-items: center;">

  <h1>Reportes</h1>

  <div class="center-buttons" style="display: flex; flex-direction: column; align-items: center;">
    @php
      $btnStyle = 'font-size: 2.4rem; padding: 2.5rem 5rem; height: 7.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center;';
    @endphp
    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/reportes/ventas-diaria') }}" class="btn-large" style="{{ $btnStyle }}">
        Venta diaria
        <div class="tooltip-below" style="font-size: 1.2rem;">Reporte de ventas del día</div>
      </a>
    </div>
    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/reportes/ventas-periodo') }}" class="btn-large" style="{{ $btnStyle }}">
        Por periodo
        <div class="tooltip-below" style="font-size: 1.2rem;">Reporte de ventas por rango de fechas</div>
      </a>
    </div>
    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/reportes/productos-mas-vendidos') }}" class="btn-large" style="{{ $btnStyle }}">
        Productos<br><span style="font-size: 2.4rem;">más vendidos</span>
        <div class="tooltip-below" style="font-size: 1.2rem;">Reporte de productos más vendidos</div>
      </a>
    </div>
  </div>

</main>

@endsection
