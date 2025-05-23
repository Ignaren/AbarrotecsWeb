@extends('layout')

@section('content')
<main class="content fade-in" style="max-width: 700px; margin: 2rem auto; padding: 1rem; background: white; border-radius: 10px; box-shadow: 0 8px 20px rgba(106, 79, 188, 0.1);">
  <h1 style="color: #4B367C; font-weight: 700; margin-bottom: 1rem;">Editar Cliente</h1>

  <form method="POST" action="{{ url('/catalogos/clientes/editar/' . $cliente->PK_Id_Cliente) }}" novalidate>
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1rem;">
      <label for="Nombre" style="font-weight: 600;">Nombre:</label>
      <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre', $cliente->Nombre) }}" required
        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
        title="Solo letras y espacios, sin números ni caracteres especiales"
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Nombre')
        <div style="color:#e74c3c; margin-top:0.25rem; font-weight:600;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1rem;">
      <label for="Email" style="font-weight: 600;">Email:</label>
      <input type="email" name="Email" id="Email" value="{{ old('Email', $cliente->Email) }}" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Email')
        <div style="color:#e74c3c; margin-top:0.25rem; font-weight:600;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1rem;">
      <label for="RFC" style="font-weight: 600;">RFC:</label>
      <input type="text" name="RFC" id="RFC" value="{{ old('RFC', $cliente->RFC) }}" required maxlength="13"
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('RFC')
        <div style="color:#e74c3c; margin-top:0.25rem; font-weight:600;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1rem;">
      <label for="Telefono" style="font-weight: 600;">Teléfono:</label>
      <input type="text" name="Telefono" id="Telefono" value="{{ old('Telefono', $cliente->Telefono) }}" required
        pattern="^\d+$" title="Solo números"
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Telefono')
        <div style="color:#e74c3c; margin-top:0.25rem; font-weight:600;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1rem;">
      <label for="Direccion" style="font-weight: 600;">Dirección:</label>
      <input type="text" name="Direccion" id="Direccion" value="{{ old('Direccion', $cliente->Direccion) }}" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Direccion')
        <div style="color:#e74c3c; margin-top:0.25rem; font-weight:600;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Estado" style="font-weight: 600;">Estado:</label>
      <select name="Estado" id="Estado" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
        <option value="Activo" {{ old('Estado', $cliente->Estado) === 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ old('Estado', $cliente->Estado) === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
      @error('Estado')
        <div style="color:#e74c3c; margin-top:0.25rem; font-weight:600;">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit"
      style="background-color: #6A4FBC; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
      Actualizar
    </button>
  </form>
</main>
@endsection
