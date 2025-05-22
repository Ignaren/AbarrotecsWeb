@extends('layout')

@section('styles')
<style>
  .capture-view main.content {
    max-width: 750px;
    padding: 2rem 3rem;
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(106, 79, 188, 0.1);
    margin: 2rem auto 4rem;
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
    user-select: text;
  }

  .capture-view label {
    font-weight: 600;
    color: var(--color-principal);
    margin-bottom: 0.5rem;
    display: block;
    font-size: 1.1rem;
  }

  .capture-view input,
  .capture-view select,
  .capture-view textarea {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    border: 2px solid var(--color-principal-oscuro);
    border-radius: 10px;
    outline-offset: 2px;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    font-family: inherit;
    box-sizing: border-box;
  }

  .capture-view input:focus,
  .capture-view select:focus,
  .capture-view textarea:focus {
    border-color: var(--color-principal);
    box-shadow: 0 0 8px var(--color-principal);
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
    box-shadow: 0 6px 18px rgba(122, 95, 255, 0.6);
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.15s ease;
    user-select: none;
    align-self: flex-start;
  }

  .capture-view button:hover {
    background: linear-gradient(45deg, #664ddb, #7f5fe6);
    box-shadow: 0 10px 30px rgba(102, 77, 219, 0.8);
    transform: translateY(-2px);
  }

  .capture-view button:active {
    transform: translateY(0);
    box-shadow: 0 4px 12px rgba(102, 77, 219, 0.4);
  }

  .capture-view .error {
    color: #e74c3c;
    font-size: 0.9rem;
    margin-top: 0.25rem;
    font-weight: 600;
  }
</style>
@endsection

@section('content')
<div class="capture-view">
  <main class="content">
    <h1>Agregar Producto</h1>

    <form action="{{ url('/catalogos/productos/agregar') }}" method="POST">
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
        <label for="stock_minimo">Stock mínimo</label>
        <input type="number" name="stock_minimo" id="stock_minimo" value="{{ old('stock_minimo') }}" required min="0">
        @error('stock_minimo')
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
        <input type="date" name="fecha_entrada" id="fecha_entrada" value="{{ old('fecha_entrada') }}" required>
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
        <select name="categoria" id="categoria" required>
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

<script>
  const entrada = document.getElementById('fecha_entrada');
  const caducidad = document.getElementById('fecha_caducidad');

  entrada.addEventListener('change', () => {
    if (entrada.value) {
      caducidad.min = entrada.value;
    } else {
      caducidad.removeAttribute('min');
    }
  });
</script>
@endsection
