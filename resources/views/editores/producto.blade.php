@extends('layout')

@section('styles')
<style>
  main.content {
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

  label {
    font-weight: 600;
    color: #4B367C;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 1.1rem;
  }

  input[type="text"],
  input[type="number"],
  input[type="date"],
  select {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    border: 2px solid #4B367C;
    border-radius: 10px;
    font-family: inherit;
    box-sizing: border-box;
  }

  input.error-border,
  select.error-border {
    border-color: #e74c3c;
  }

  .error {
    color: #e74c3c;
    font-size: 0.9rem;
    margin-top: 0.25rem;
    font-weight: 600;
    display: none;
  }

  .error.visible {
    display: block;
  }

  button {
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
<main class="content fade-in">
  <h1>Editar Producto</h1>

  <form id="productoForm" action="{{ route('productos.actualizar', $producto->PK_Id_Producto) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->Nombre) }}">
      @error('nombre')
        <div class="error visible">{{ $message }}</div>
      @enderror
      <div id="error-nombre" class="error" style="display:none;"></div>
    </div>

    <div>
      <label for="descripcion">Descripción</label>
      <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $producto->Descripcion) }}">
      @error('descripcion')
        <div class="error visible">{{ $message }}</div>
      @enderror
      <div id="error-descripcion" class="error" style="display:none;"></div>
    </div>

    <div>
      <label for="existencia">Existencia</label>
      <input type="number" id="existencia" name="existencia" value="{{ old('existencia', $producto->Existencia) }}" min="0" required>
      @error('existencia')
        <div class="error visible">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="precio">Precio</label>
      <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio', $producto->Precio) }}" required>
      @error('precio')
        <div class="error visible">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="fecha_caducidad">Fecha de Caducidad</label>
      <input type="date" id="fecha_caducidad" name="fecha_caducidad"
             value="{{ old('fecha_caducidad', $producto->Fecha_Caducidad) }}"
             min="{{ date('Y-m-d') }}">
      @error('fecha_caducidad')
        <div class="error visible">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="fk_id_categoria">Categoría</label>
      <select id="fk_id_categoria" name="fk_id_categoria" required>
        @foreach ($categorias as $categoria)
          <option value="{{ $categoria->PK_Id_Categoria }}"
            {{ $categoria->PK_Id_Categoria == old('fk_id_categoria', $producto->FK_Id_Categoria) ? 'selected' : '' }}>
            {{ $categoria->Nombre }}
          </option>
        @endforeach
      </select>
      @error('fk_id_categoria')
        <div class="error visible">{{ $message }}</div>
      @enderror
    </div>

    <div>
      <label for="estado">Estado</label>
      <select id="estado" name="estado" required>
        <option value="activo" {{ old('estado', $producto->Estado) == 'activo' ? 'selected' : '' }}>Activo</option>
        <option value="inactivo" {{ old('estado', $producto->Estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
      @error('estado')
        <div class="error visible">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit">Guardar Cambios</button>
  </form>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const soloLetrasNumerosRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/;

  const campos = [
    { input: document.getElementById('nombre'), errorId: 'error-nombre' },
    { input: document.getElementById('descripcion'), errorId: 'error-descripcion' }
  ];

  campos.forEach(({ errorId }) => {
    const errorDiv = document.getElementById(errorId);
    if (!errorDiv.textContent.trim()) {
      errorDiv.classList.remove('visible');
      errorDiv.style.display = 'none';
    }
  });

  campos.forEach(({ input, errorId }) => {
    input.addEventListener('input', () => {
      const original = input.value;
      const filtrado = original.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]/g, '');
      if (original !== filtrado) {
        input.value = filtrado;
      }

      const errorDiv = document.getElementById(errorId);
      if (soloLetrasNumerosRegex.test(input.value.trim()) || input.value.trim() === '') {
        input.classList.remove('error-border');
        errorDiv.textContent = '';
        errorDiv.classList.remove('visible');
        errorDiv.style.display = 'none';
      }
    });
  });

  document.getElementById('productoForm').addEventListener('submit', function(e) {
    let valido = true;

    campos.forEach(({ input, errorId }) => {
      const valor = input.value.trim();
      const errorDiv = document.getElementById(errorId);

      if (!soloLetrasNumerosRegex.test(valor) || valor === '') {
        valido = false;
        input.classList.add('error-border');
        errorDiv.textContent = 'Solo se permiten letras, números y espacios. No puede estar vacío.';
        errorDiv.classList.add('visible');
        errorDiv.style.display = 'block';
      } else {
        input.classList.remove('error-border');
        errorDiv.textContent = '';
        errorDiv.classList.remove('visible');
        errorDiv.style.display = 'none';
      }
    });

    if (!valido) {
      e.preventDefault();
    }
  });
});
</script>
@endsection
