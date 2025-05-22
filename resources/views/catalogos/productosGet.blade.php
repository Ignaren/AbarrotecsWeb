@extends('layout')

@section('styles')
<style>
  main.content {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
    max-width: 100% !important;
    margin: 0 auto;
  }

  .table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(106, 79, 188, 0.15);
    background: white;
    border: 1px solid #6A4FBC;
  }

  table {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0 15px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 1rem;
    color: #333;
    min-width: 850px;
  }

  thead tr {
    background-color: #6A4FBC;
    color: white;
    text-align: left;
    border-radius: 12px;
  }

  thead th {
    padding: 18px 25px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
  }

  thead th:first-child {
    border-radius: 12px 0 0 12px;
  }

  thead th:last-child {
    border-radius: 0 12px 12px 0;
  }

  tbody tr {
    background: #f9f9fb;
    box-shadow: 0 2px 7px rgba(106, 79, 188, 0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
    cursor: default;
  }

  tbody tr:hover {
    background-color: #e5defb;
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(106, 79, 188, 0.3);
  }

  tbody td {
    padding: 18px 25px;
    border-left: 4px solid transparent;
    transition: border-color 0.3s ease;
    white-space: nowrap;
    vertical-align: middle;
  }

  tbody tr:hover td {
    border-left-color: #6A4FBC;
  }

  tbody td.precio {
    font-weight: 700;
    color: #4B367C;
  }

  .btn-editar, .btn-eliminar, .btn-reabastecer {
    font-weight: 700;
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(106, 79, 188, 0.6);
    text-decoration: none;
    font-size: 0.85rem;
    display: inline-block;
    margin-right: 0.5rem;
  }

  .btn-editar {
    background-color: #6A4FBC;
    color: white;
  }

  .btn-editar:hover {
    background-color: #4B367C;
  }

  .btn-eliminar {
    background-color: #dc3545;
    color: white;
    box-shadow: 0 3px 8px rgba(220, 53, 69, 0.6);
  }

  .btn-eliminar:hover {
    background-color: #b02a37;
  }

  .btn-reabastecer {
    background-color: #28a745;
    color: white;
    box-shadow: 0 3px 8px rgba(40, 167, 69, 0.6);
  }

  .btn-reabastecer:hover {
    background-color: #1e7e34;
  }

  .table-wrapper::-webkit-scrollbar {
    height: 8px;
  }

  .table-wrapper::-webkit-scrollbar-thumb {
    background: #6A4FBC;
    border-radius: 10px;
  }
</style>
@endsection

@section('content')
<main class="content fade-in">

  {{-- Breadcrumbs --}}
  <nav aria-label="breadcrumb" style="margin-bottom: 1rem;">
    <ol style="list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; font-size: 0.9rem; color: #4B367C;">
      @foreach ($breadcrumbs as $label => $link)
        @if ($loop->last)
          <li style="font-weight: 700;">{{ $label }}</li>
        @else
          <li>
            <a href="{{ $link }}" style="color: #6A4FBC; text-decoration: none; font-weight: 600;">{{ $label }}</a>
            <span style="margin: 0 0.4rem;">/</span>
          </li>
        @endif
      @endforeach
    </ol>
  </nav>

  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
    <h1 style="color: #4B367C; font-weight: 700; margin: 0;">Productos</h1>

    <a href="/catalogos/productos/agregar" class="btn-agregar" style="
      background-color: #6A4FBC;
      color: white;
      font-weight: 700;
      padding: 0.35rem 0.9rem;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(106, 79, 188, 0.6);
      text-decoration: none;
      font-size: 0.85rem;
      transition: background-color 0.3s ease;
      white-space: nowrap;
    "
    onmouseover="this.style.backgroundColor='#4B367C'"
    onmouseout="this.style.backgroundColor='#6A4FBC'">
      + Agregar
    </a>
  </div>

  @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 6px; border: 1px solid #c3e6cb; margin-bottom: 1.5rem;">
      {{ session('success') }}
    </div>
  @endif

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Existencia</th>
          <th>Caducidad</th>
          <th>Precio</th>
          <th>Categoría</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($productos as $producto)
        <tr>
          <td>{{ $producto->PK_Id_Producto }}</td>
          <td>{{ $producto->Nombre }}</td>
          <td>{{ $producto->Descripcion }}</td>
          <td>{{ $producto->Existencia }}</td>
          <td>{{ $producto->Fecha_Caducidad ? \Carbon\Carbon::parse($producto->Fecha_Caducidad)->format('d/m/Y') : '---' }}</td>
          <td class="precio">${{ number_format($producto->Precio, 2) }}</td>
          <td>{{ $producto->categoria->Nombre ?? 'Sin categoría' }}</td>
          <td>{{ ucfirst($producto->Estado ?? 'activo') }}</td>
          <td>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
              <a href="{{ url('/catalogos/productos/reabastecer/'.$producto->PK_Id_Producto) }}" 
                 class="btn-reabastecer" title="Reabastecer">
                 Reabastecer
              </a>
              <a href="{{ url('/catalogos/productos/editar/'.$producto->PK_Id_Producto) }}" class="btn-editar" title="Editar">✏️</a>
              <form action="{{ url('/catalogos/productos/eliminar/'.$producto->PK_Id_Producto) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn-eliminar" title="Eliminar">🗑️</button>
</form>

            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" style="text-align:center; padding: 20px 30px;">No hay productos registrados.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>
@endsection
