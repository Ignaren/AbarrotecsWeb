@extends('layout')

@section('title', 'Inicio')

@section('content')

<main class="content fade-in" style="flex-direction: column; align-items: center;">

  <!-- Logo centrado y 30% más grande -->
  <div style="margin-bottom: 2rem;">
    <img src="{{ asset('images/logo.png') }}" alt="Logo AbarroTecs" style="height: 182px; display: block; margin: 0 auto;" />
  </div>

  <div class="center-buttons">
    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/categorias') }}" class="btn-large">
        Categorías
        <div class="tooltip-below">Gestiona las categorías de productos</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/productos') }}" class="btn-large">
        Productos
        <div class="tooltip-below">Administra los productos disponibles</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/proveedores') }}" class="btn-large">
        Proveedores
        <div class="tooltip-below">Consulta y edita información de proveedores</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/clientes') }}" class="btn-large">
        Clientes
        <div class="tooltip-below">Visualiza y gestiona tus clientes</div>
      </a>
    </div>

    <div class="btn-large-group fade-in" style="margin-top: 40px;">
      <a href="{{ url('/catalogos/ventas') }}" class="btn-large">
        Ventas
        <div class="tooltip-below">Registra y consulta las ventas</div>
      </a>
    </div>
  </div>

</main>

<!-- Botones fijos en esquina inferior izquierda -->
<div class="fixed-bottom-buttons">
  <a href="{{ url('/informacion') }}" class="btn-info-fixed">Información</a>
  <a href="{{ url('/sobre-nosotros')}}" class="btn-info-fixed">Sobre Nosotros</a>
</div>

@endsection
