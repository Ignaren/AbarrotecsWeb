@extends('layout')

@section('content')
<main class="content fade-in" style="max-width: 700px; margin: 0 auto; padding: 1rem;">

  <h1 style="color: #4B367C; font-weight: 700; margin-bottom: 1rem;">Editar Proveedor</h1>

  @if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 6px; margin-bottom: 1.2rem;">
      <ul style="margin: 0; padding-left: 1.2rem;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('proveedores.actualizar', $proveedor->PK_Id_Proveedor) }}">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.2rem;">
      <label for="Nombre" style="font-weight: 600;">Nombre:</label>
      <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre', $proveedor->Nombre) }}" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Telefono" style="font-weight: 600;">Teléfono:</label>
      <input type="text" id="Telefono" name="Telefono" value="{{ old('Telefono', $proveedor->Telefono) }}" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Direccion" style="font-weight: 600;">Dirección:</label>
      <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion', $proveedor->Direccion) }}" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Estado" style="font-weight: 600;">Estado:</label>
      <select id="Estado" name="Estado" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
        <option value="Activo" {{ old('Estado', $proveedor->Estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ old('Estado', $proveedor->Estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>

    <div style="display: flex; justify-content: flex-end;">
      <button type="submit"
        style="background-color: #6A4FBC; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
        Guardar Cambios
      </button>
    </div>
  </form>

</main>
@endsection
