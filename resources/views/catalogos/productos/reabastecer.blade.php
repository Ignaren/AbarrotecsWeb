@extends('layout')

@section('content')
<main class="content fade-in">
  <h1 style="color: #28a745; font-weight: bold;">Reabastecer Producto</h1>

  <p>Producto: <strong>{{ $producto->Nombre }}</strong></p>
  <p>Existencia actual: {{ $producto->Existencia }}</p>

  <form action="{{ url('/catalogos/productos/reabastecer/' . $producto->PK_Id_Producto) }}" method="POST">
    @csrf

    <label for="cantidad">Cantidad a añadir</label>
    <input type="number" id="cantidad" name="cantidad" min="1" required>

    <label for="fecha_entrada" style="margin-top: 1rem;">Fecha de Entrada</label>
    <input type="date" id="fecha_entrada" name="fecha_entrada" value="{{ old('fecha_entrada', date('Y-m-d')) }}" required>

    <label for="fecha_caducidad" style="margin-top: 1rem;">Fecha de Caducidad (opcional)</label>
    <input type="date" id="fecha_caducidad" name="fecha_caducidad" value="{{ old('fecha_caducidad') }}">

    <button type="submit" style="background-color: #28a745; color: white; margin-top: 1rem;">Reabastecer</button>
    <a href="{{ url('/catalogos/productos') }}" style="margin-left: 1rem;">Cancelar</a>
  </form>
</main>
@endsection
