@extends('layout')

@section('styles')
<style>
  .pagination-summary {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 0.95rem;
    margin: 0.5rem 0 0.5rem;
    color: #4B367C;
  }
  .pagination-summary .pagination-links {
    margin-bottom: 0.2rem;
  }
  .pagination-summary .pagination-links a,
  .pagination-summary .pagination-links span {
    color: #4B367C;
    font-weight: 600;
    font-size: 1rem;
    margin: 0 0.2rem;
    text-decoration: underline;
    cursor: pointer;
  }
  .pagination-summary .pagination-links span[aria-disabled="true"] {
    color: #aaa;
    text-decoration: none;
    cursor: default;
  }
  .pagination-summary .pagination-info {
    font-size: 0.95rem;
    color: #333;
    margin-top: 0.1rem;
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

  {{-- Paginación personalizada abajo --}}
  @if ($productos->hasPages())
    <div class="pagination-summary">
      <div class="pagination-links">
        {{-- Previous --}}
        @if ($productos->onFirstPage())
          <span aria-disabled="true">« anterior</span>
        @else
          <a href="{{ $productos->previousPageUrl() }}">« anterior</a>
        @endif

        {{-- Next --}}
        @if ($productos->hasMorePages())
          <a href="{{ $productos->nextPageUrl() }}">siguiente »</a>
        @else
          <span aria-disabled="true">Next »</span>
        @endif
      </div>
      <div class="pagination-info">
        Showing {{ $productos->firstItem() }} to {{ $productos->lastItem() }} of {{ $productos->total() }} results
      </div>
    </div>
  @endif

</main>
@endsection