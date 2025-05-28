@extends('layout')

@section('styles')
<style>
  .capture-view main.content {
    max-width: 700px;
    padding: 2rem 3rem;
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(106, 79, 188, 0.1);
    margin: 2rem auto 4rem;
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
  }

  .capture-view label {
    font-weight: 600;
    color: var(--color-principal);
    margin-bottom: 0.5rem;
    display: block;
    font-size: 1.1rem;
  }

  .capture-view input,
  .capture-view textarea,
  .capture-view select {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    border: 2px solid var(--color-principal-oscuro);
    border-radius: 10px;
    font-family: inherit;
    box-sizing: border-box;
  }

  .capture-view .error {
    color: #e74c3c;
    font-size: 0.9rem;
    margin-top: 0.25rem;
    font-weight: 600;
  }

  .capture-view .alert-errors {
    background-color: #f8d7da;
    border: 1px solid #f5c2c7;
    color: #842029;
    padding: 1rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
  }

  .capture-view .alert-errors ul {
    margin: 0;
    padding-left: 1.25rem;
  }

  .breadcrumb {
    margin-bottom: 1.5rem;
    list-style: none;
    padding: 0;
    display: flex;
    gap: 0.5rem;
    font-weight: 500;
  }

  .breadcrumb li a {
    color: var(--color-principal);
    text-decoration: none;
  }

  .capture-view button {
    background: linear-gradient(45deg, #7a5fff, #9e77ff);
    color: white;
    padding: 0.75rem 2rem;
    font-weight: 700;
    font-size: 1.1rem;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    align-self: flex-start;
  }
</style>
@endsection

@section('content')
<div class="capture-view">
  <main class="content">

    <ul class="breadcrumb">
      <li><a href="{{ url('/') }}">Inicio</a></li>
      <li>›</li>
      <li><a href="{{ url('/catalogos/productos') }}">Productos</a></li>
      <li>›</li>
      <li>Agregar Producto</li>
    </ul>

    <h1>Agregar Producto</h1>

    @if ($errors->any())
      <div class="alert-errors">
        <strong>Se encontraron los siguientes errores:</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="productoForm" action="{{ url('/catalogos/productos/agregar') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
        @error('nombre')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" required>{{ old('descripcion') }}</textarea>
        @error('descripcion')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="existencia">Existencia</label>
        <input type="number" name="existencia" id="existencia" value="{{ old('existencia') }}" required min="0">
        @error('existencia')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="fecha_entrada">Fecha de entrada</label>
        <input type="date" name="fecha_entrada" id="fecha_entrada" value="{{ old('fecha_entrada') }}" required max="{{ date('Y-m-d') }}">
        @error('fecha_entrada')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="fecha_caducidad">Fecha de caducidad (opcional)</label>
        <input type="date" name="fecha_caducidad" id="fecha_caducidad" value="{{ old('fecha_caducidad') }}">
        @error('fecha_caducidad')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" name="precio" id="precio" step="0.01" value="{{ old('precio') }}" required min="0">
        @error('precio')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="categoria">Categoría</label>
        <select name="categoria" id="FK_Id_Categoria" required>
          <option value="">Seleccionar categoría</option>
          @foreach ($categorias as $categoria)
            <option value="{{ $categoria->PK_Id_Categoria }}" {{ old('categoria') == $categoria->PK_Id_Categoria ? 'selected' : '' }}>
              {{ $categoria->Nombre }}
            </option>
          @endforeach
        </select>
        @error('categoria')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit">Guardar</button>
    </form>

  </main>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Permitir letras, números y espacios (no caracteres especiales)
  const soloLetrasNumerosRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/;

  const campos = [
    document.getElementById('nombre'),
    document.getElementById('descripcion')
  ];

  campos.forEach(campo => {
    campo.addEventListener('input', () => {
      campo.value = campo.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]/g, '');
    });

    campo.addEventListener('keypress', e => {
      if (!soloLetrasNumerosRegex.test(e.key)) {
        e.preventDefault();
      }
    });

    campo.addEventListener('paste', e => {
      const textoPegado = (e.clipboardData || window.clipboardData).getData('text');
      if (!soloLetrasNumerosRegex.test(textoPegado)) {
        e.preventDefault();
      }
    });
  });

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
        // Si la fecha de caducidad es menor a la mínima, la limpia
        if (caducidad.value && caducidad.value < minCaducidad) {
          caducidad.value = '';
        }
      } else {
        caducidad.min = '';
      }
    }

    entrada.addEventListener('change', actualizarMinCaducidad);

    // Ejecutar al cargar la página por si ya hay valor
    actualizarMinCaducidad();
  }
});
</script>
@endsection