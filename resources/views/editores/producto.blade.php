@extends('layout')

@section('content')
<main class="content fade-in">
  <h1 style="color: #4B367C; font-weight: bold;">Editar Producto</h1>

  @if ($errors->any())
    <div style="color: red;">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('productos.actualizar', $producto->PK_Id_Producto) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
      <label>Nombre</label>
      <input type="text" name="Nombre" value="{{ old('Nombre', $producto->Nombre) }}" required>
    </div>

    <div>
      <label>Descripción</label>
      <input type="text" name="Descripcion" value="{{ old('Descripcion', $producto->Descripcion) }}">
    </div>

    <div>
      <label>Existencia</label>
      <input type="number" name="Existencia" value="{{ old('Existencia', $producto->Existencia) }}" min="0" required>
    </div>

    <div>
      <label>Precio</label>
      <input type="number" step="0.01" name="Precio" value="{{ old('Precio', $producto->Precio) }}" required>
    </div>

    <div>
      <label>Fecha de Caducidad</label>
      <input type="date" name="Fecha_Caducidad" value="{{ old('Fecha_Caducidad', $producto->Fecha_Caducidad) }}">
    </div>

    <div>
      <label>Categoría</label>
      <select name="FK_Id_Categoria" required>
        @foreach ($categorias as $categoria)
          <option value="{{ $categoria->PK_Id_Categoria }}"
            {{ $categoria->PK_Id_Categoria == old('FK_Id_Categoria', $producto->FK_Id_Categoria) ? 'selected' : '' }}>
            {{ $categoria->Nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Estado</label>
      <select name="Estado" required>
        <option value="activo" {{ old('Estado', $producto->Estado) == 'activo' ? 'selected' : '' }}>Activo</option>
        <option value="inactivo" {{ old('Estado', $producto->Estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>

    <button type="submit">Guardar Cambios</button>
  </form>
</main>
@endsection
