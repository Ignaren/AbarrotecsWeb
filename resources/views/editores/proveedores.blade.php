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

  <form method="POST" action="{{ route('proveedores.actualizar', $proveedor->PK_Id_Proveedor) }}" id="editarProveedorForm">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.2rem;">
      <label for="Nombre" style="font-weight: 600;">Nombre:</label>
      <input type="text" id="Nombre" name="Nombre" value="{{ old('Nombre', $proveedor->Nombre) }}" required maxlength="100"
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Nombre')
        <div style="color: #e74c3c; font-weight: 600; margin-top: 0.25rem;">{{ $message }}</div>
      @enderror
      <div id="errorNombre" style="color: #e74c3c; font-weight: 600; margin-top: 0.25rem; display:none;">Solo letras y espacios.</div>
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Telefono" style="font-weight: 600;">Teléfono:</label>
      <input type="text" id="Telefono" name="Telefono" value="{{ old('Telefono', $proveedor->Telefono) }}" required maxlength="15"
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Telefono')
        <div style="color: #e74c3c; font-weight: 600; margin-top: 0.25rem;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Direccion" style="font-weight: 600;">Dirección:</label>
      <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion', $proveedor->Direccion) }}" required maxlength="255"
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
      @error('Direccion')
        <div style="color: #e74c3c; font-weight: 600; margin-top: 0.25rem;">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-bottom: 1.2rem;">
      <label for="Estado" style="font-weight: 600;">Estado:</label>
      <select id="Estado" name="Estado" required
        style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc;">
        <option value="Activo" {{ old('Estado', $proveedor->Estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ old('Estado', $proveedor->Estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
      @error('Estado')
        <div style="color: #e74c3c; font-weight: 600; margin-top: 0.25rem;">{{ $message }}</div>
      @enderror
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const nombreInput = document.getElementById('Nombre');
  const errorNombre = document.getElementById('errorNombre');
  const soloLetrasEspacios = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

  nombreInput.addEventListener('input', () => {
    if (nombreInput.value !== '' && !soloLetrasEspacios.test(nombreInput.value)) {
      errorNombre.style.display = 'block';
      nombreInput.setCustomValidity('Solo letras y espacios.');
    } else {
      errorNombre.style.display = 'none';
      nombreInput.setCustomValidity('');
    }
  });
});
</script>
@endsection
