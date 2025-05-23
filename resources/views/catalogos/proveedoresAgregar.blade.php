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
    color: var(--color-principal, #6A4FBC);
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
    border: 2px solid var(--color-principal-oscuro, #4B367C);
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
    color: var(--color-principal, #6A4FBC);
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
      <li><a href="{{ url('/catalogos/proveedores') }}">Proveedores</a></li>
      <li>›</li>
      <li>Agregar Proveedor</li>
    </ul>

    <h1>Agregar Proveedor</h1>

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

    <form action="{{ url('/catalogos/proveedores/agregar') }}" method="POST" novalidate>
      @csrf

      <div class="form-group">
        <label for="Nombre">Nombre</label>
        <input
          type="text"
          id="Nombre"
          name="Nombre"
          value="{{ old('Nombre') }}"
          maxlength="100"
          required
          pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
          title="Solo letras y espacios."
        >
        @error('Nombre')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="Direccion">Dirección</label>
        <input
          type="text"
          id="Direccion"
          name="Direccion"
          value="{{ old('Direccion') }}"
          maxlength="255"
          required
        >
        @error('Direccion')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="Email">Email</label>
        <input
          type="email"
          id="Email"
          name="Email"
          value="{{ old('Email') }}"
          maxlength="100"
          required
        >
        @error('Email')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="Telefono">Teléfono</label>
        <input
          type="text"
          id="Telefono"
          name="Telefono"
          value="{{ old('Telefono') }}"
          maxlength="15"
          required
        >
        @error('Telefono')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit">Guardar</button>
    </form>
  </main>
</div>
@endsection
