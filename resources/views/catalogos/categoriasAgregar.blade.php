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

  .capture-view input[type="text"],
  .capture-view input[type="date"],
  .capture-view textarea {
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
      <li><a href="{{ url('/catalogos/categorias') }}">Categorías</a></li>
      <li>›</li>
      <li>Agregar Categoría</li>
    </ul>

    <h1>Agregar Categoría</h1>

    <form id="categoriaForm" action="{{ url('/catalogos/categorias/agregar') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="Nombre">Nombre</label>
        <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre') }}" required>
        @error('Nombre')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="Descripcion">Descripción</label>
        <textarea name="Descripcion" id="Descripcion" required>{{ old('Descripcion') }}</textarea>
        @error('Descripcion')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="Fecha">Fecha</label>
        <input type="date" name="Fecha" id="Fecha" value="{{ old('Fecha', date('Y-m-d')) }}" required>
        @error('Fecha')
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
  const soloLetrasRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

  const campos = [
    document.getElementById('Nombre'),
    document.getElementById('Descripcion')
  ];

  campos.forEach(campo => {
    campo.addEventListener('input', () => {
      campo.value = campo.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });

    campo.addEventListener('keypress', e => {
      if (!soloLetrasRegex.test(e.key)) {
        e.preventDefault();
      }
    });

    campo.addEventListener('paste', e => {
      const textoPegado = (e.clipboardData || window.clipboardData).getData('text');
      if (!soloLetrasRegex.test(textoPegado)) {
        e.preventDefault();
      }
    });
  });

  // Validar que la fecha sea hoy
  const fechaInput = document.getElementById('Fecha');
  if (fechaInput) {
    const hoy = new Date().toISOString().split('T')[0];
    fechaInput.setAttribute('min', hoy);
    fechaInput.setAttribute('max', hoy);

    fechaInput.addEventListener('change', () => {
      if (fechaInput.value !== hoy) {
        alert('La fecha debe ser hoy.');
        fechaInput.value = hoy;
      }
    });
  }

  document.getElementById('categoriaForm').addEventListener('submit', function(e) {
    let valido = true;
    campos.forEach(campo => {
      if (!soloLetrasRegex.test(campo.value.trim())) {
        valido = false;
        campo.style.borderColor = '#e74c3c';
      } else {
        campo.style.borderColor = '';
      }
    });

    if (!valido) {
      e.preventDefault();
      alert('Los campos solo deben contener letras y espacios, sin números ni caracteres especiales.');
    }
  });
});
</script>
@endsection
