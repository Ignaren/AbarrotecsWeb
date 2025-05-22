@extends('layout')

@section('content')
<div class="container" style="max-width: 600px; margin-top: 2rem;">
    <h2>Editar Categoría</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Error!</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('categorias.actualizar', $categoria->PK_Id_Categoria) }}">
        @csrf

        <div class="mb-3">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" name="Nombre" id="Nombre" class="form-control" value="{{ old('Nombre', $categoria->Nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="Descripcion" class="form-label">Descripción</label>
            <textarea name="Descripcion" id="Descripcion" class="form-control">{{ old('Descripcion', $categoria->Descripcion) }}</textarea>
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
