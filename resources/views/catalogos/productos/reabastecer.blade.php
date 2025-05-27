@extends('layout')

@section('content')
<main class="content fade-in">
  <h1 style="color: #28a745; font-weight: bold;">Reabastecer Producto</h1>

  <p>Producto: <strong>{{ $producto->Nombre }}</strong></p>
  <p>Existencia actual: {{ $producto->Existencia }}</p>

  @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:1rem;">
      <ul style="margin-bottom:0;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ url('/catalogos/productos/reabastecer/' . $producto->PK_Id_Producto) }}" method="POST" id="reabastecerForm">
    @csrf

    <label for="cantidad">Cantidad a añadir</label>
    <input type="number" id="cantidad" name="cantidad" min="1" required value="{{ old('cantidad') }}">

    <label for="fecha_entrada" style="margin-top: 1rem;">Fecha de Entrada</label>
    <input type="date" id="fecha_entrada" name="fecha_entrada" 
           value="{{ old('fecha_entrada', date('Y-m-d')) }}" 
           max="{{ date('Y-m-d') }}" required>

    <label for="fecha_caducidad" style="margin-top: 1rem;">Fecha de Caducidad (opcional)</label>
    <input type="date" id="fecha_caducidad" name="fecha_caducidad" value="{{ old('fecha_caducidad') }}">

    <button type="submit" style="background-color: #28a745; color: white; margin-top: 1rem;">Reabastecer</button>
    <a href="{{ url('/catalogos/productos') }}" style="margin-left: 1rem;">Cancelar</a>
  </form>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const entrada = document.getElementById('fecha_entrada');
  const caducidad = document.getElementById('fecha_caducidad');

  if (entrada && caducidad) {
    function actualizarMinCaducidad() {
      if (entrada.value) {
        // La fecha mínima de caducidad es un día después de la fecha de entrada
        const entradaDate = new Date(entrada.value);
        entradaDate.setDate(entradaDate.getDate() + 1);
        const minCaducidad = entradaDate.toISOString().split('T')[0];
        caducidad.min = minCaducidad;
        if (caducidad.value && caducidad.value < minCaducidad) {
          caducidad.value = '';
        }
      } else {
        caducidad.min = '';
      }
    }

    entrada.addEventListener('change', actualizarMinCaducidad);
    actualizarMinCaducidad();
  }
});
</script>
@endsection