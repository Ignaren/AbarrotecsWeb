@extends('layout')

@section('content')
<main class="content fade-in">
  <h1 style="color: #4B367C; font-weight: 700;">Editar Cliente</h1>

  <form method="POST" action="{{ url('/catalogos/clientes/editar/' . $cliente->PK_Id_Cliente) }}">
    @csrf
    @method('PUT')

    <div>
      <label>Nombre:</label>
      <input type="text" name="Nombre" value="{{ old('Nombre', $cliente->Nombre) }}" required>
    </div>

    <div>
      <label>Email:</label>
      <input type="email" name="Email" value="{{ old('Email', $cliente->Email) }}" required>
    </div>

    <div>
      <label>RFC:</label>
      <input type="text" name="RFC" value="{{ old('RFC', $cliente->RFC) }}" required>
    </div>

    <div>
      <label>Teléfono:</label>
      <input type="text" name="Telefono" value="{{ old('Telefono', $cliente->Telefono) }}" required>
    </div>

    <div>
      <label>Dirección:</label>
      <input type="text" name="Direccion" value="{{ old('Direccion', $cliente->Direccion) }}" required>
    </div>

    <div>
      <label>Estado:</label>
      <select name="Estado" required>
        <option value="Activo" {{ old('Estado', $cliente->Estado) === 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ old('Estado', $cliente->Estado) === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>

    <button type="submit">Actualizar</button>
  </form>
</main>
@endsection
