@extends('layout')

@section('content')
<div class="container" style="max-width: 600px; margin-top: 2rem;">
    <h2>Editar Categoría</h2>

    @if ($errors->any())
        <div class="error">
            <strong>¡Error!</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('categorias.actualizar', $categoria->PK_Id_Categoria) }}" id="categoriaForm">
        @csrf

        <div class="mb-3">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" name="Nombre" id="Nombre" class="form-control" value="{{ old('Nombre', $categoria->Nombre) }}" required>
            <div id="errorNombre" class="error" style="display:none;">
              El campo Nombre solo debe contener letras y espacios.
            </div>
        </div>

        <div class="mb-3">
            <label for="Descripcion" class="form-label">Descripción</label>
            <textarea name="Descripcion" id="Descripcion" class="form-control">{{ old('Descripcion', $categoria->Descripcion) }}</textarea>
            <div id="errorDescripcion" class="error" style="display:none;">
              El campo Descripción solo debe contener letras y espacios.
            </div>
        </div>

        <div class="mb-3">
            <label for="Estado" class="form-label">Estado</label>
            <select name="Estado" id="Estado" class="form-select" required>
                <option value="activo" {{ old('Estado', $categoria->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('Estado', $categoria->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ url('/catalogos/categorias') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const soloLetrasRegex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/;

  const nombre = document.getElementById('Nombre');
  const descripcion = document.getElementById('Descripcion');
  const form = document.getElementById('categoriaForm');

  const errorNombre = document.getElementById('errorNombre');
  const errorDescripcion = document.getElementById('errorDescripcion');

  [nombre, descripcion].forEach(campo => {
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

  form.addEventListener('submit', e => {
    let valido = true;

    if (!soloLetrasRegex.test(nombre.value.trim()) || nombre.value.trim() === '') {
      errorNombre.style.display = 'block';
      nombre.style.borderColor = '#a1271f';
      valido = false;
    } else {
      errorNombre.style.display = 'none';
      nombre.style.borderColor = '';
    }

    if (descripcion.value.trim() !== '' && !soloLetrasRegex.test(descripcion.value.trim())) {
      errorDescripcion.style.display = 'block';
      descripcion.style.borderColor = '#a1271f';
      valido = false;
    } else {
      errorDescripcion.style.display = 'none';
      descripcion.style.borderColor = '';
    }

    if (!valido) {
      e.preventDefault();
      alert('Corrige los errores en el formulario.');
    }
  });
});
</script>
@endsection
