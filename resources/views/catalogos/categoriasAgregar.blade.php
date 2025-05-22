@extends('layout')

@section('styles')
<style>
  /* Usamos solo el estilo para formularios dentro de .capture-view */
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
    user-select: text;
  }

  .capture-view label {
    font-weight: 600;
    color: var(--color-principal);
    margin-bottom: 0.5rem;
    display: block;
    font-size: 1.1rem;
  }

  .capture-view input[type="text"],
  .capture-view textarea {
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    border: 2px solid var(--color-principal-oscuro);
    border-radius: 10px;
    outline-offset: 2px;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    font-family: inherit;
    resize: vertical;
    box-sizing: border-box;
  }

  .capture-view input[type="text"]:focus,
  .capture-view textarea:focus {
    border-color: var(--color-principal);
    box-shadow: 0 0 8px var(--color-principal);
  }

  .capture-view ::placeholder {
    color: var(--color-texto-claro);
    opacity: 1;
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

  /* Estilo para breadcrumb */
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

    <form action="{{ url('/catalogos/categorias/agregar') }}" method="POST">
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

      <button type="submit">Guardar</button>
    </form>
  </main>
</div>
@endsection
