@extends('layout')

@section('styles')
<style>
  main.content {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
    max-width: 100% !important;
    margin: 0 auto;
  }

  form {
    max-width: 600px;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(106, 79, 188, 0.15);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #4B367C;
  }

  label {
    display: block;
    margin-bottom: 0.3rem;
    font-weight: 600;
  }

  input[type="text"],
  input[type="email"] {
    width: 100%;
    padding: 0.5rem 0.75rem;
    margin-bottom: 1.2rem;
    border: 1px solid #6A4FBC;
    border-radius: 8px;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s ease;
  }

  input[type="text"]:focus,
  input[type="email"]:focus {
    border-color: #4B367C;
    outline: none;
  }

  button[type="submit"] {
    background-color: #6A4FBC;
    color: white;
    font-weight: 700;
    padding: 0.5rem 1.5rem;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
  }

  button[type="submit"]:hover {
    background-color: #4B367C;
  }

  .errors {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
  }

  nav.breadcrumbs {
    font-size: 0.9rem;
    color: #4B367C;
    margin-bottom: 1rem;
  }
  nav.breadcrumbs a {
    color: #6A4FBC;
    font-weight: 600;
    text-decoration: none;
  }
  nav.breadcrumbs span.separator {
    margin: 0 0.4rem;
  }
  nav.breadcrumbs span.current {
    font-weight: 700;
  }
</style>
@endsection

@section('content')
<main class="content fade-in">

  {{-- Breadcrumbs --}}
  <nav aria-label="breadcrumb" class="breadcrumbs">
    @foreach ($breadcrumbs as $label => $link)
      @if ($loop->last)
        <span class="current">{{ $label }}</span>
      @else
        <a href="{{ $link }}">{{ $label }}</a><span class="separator">/</span>
      @endif
    @endforeach
  </nav>

  <h1 style="color: #4B367C; font-weight: 700; margin-bottom: 1.5rem;">Agregar Proveedor</h1>

  {{-- Mostrar errores de validación --}}
  @if ($errors->any())
    <div class="errors">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ url('/catalogos/proveedores/agregar') }}" method="POST" novalidate>
    @csrf

    <label for="Nombre">Nombre</label>
    <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" maxlength="100" required>

    <label for="Direccion">Dirección</label>
    <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion') }}" maxlength="255" required>

    <label for="Email">Email</label>
    <input type="email" id="Email" name="Email" value="{{ old('Email') }}" maxlength="100" required>

    <label for="Telefono">Teléfono</label>
    <input type="text" id="Telefono" name="Telefono" value="{{ old('Telefono') }}" maxlength="15" required>

    <button type="submit">Guardar</button>
  </form>
</main>
@endsection
