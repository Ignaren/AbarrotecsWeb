
@extends('layout')

@section('styles')
<style>
  main.content {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
    max-width: 100% !important;
    margin: 0 auto;
  }

  table {
    width: 100% !important;
    min-width: unset;
    border-collapse: separate;
    border-spacing: 0 10px;
    font-family: Arial, sans-serif;
    font-size: 1rem;
    color: #333;
  }

  th, td {
    padding: 20px 30px !important;
  }

  thead tr {
    background-color: #6A4FBC;
    color: white;
    text-align: left;
  }

  thead th:first-child {
    border-radius: 8px 0 0 8px;
  }
  thead th:last-child {
    border-radius: 0 8px 8px 0;
  }

  tbody tr {
    background: white;
    box-shadow: 0 2px 5px rgba(106, 79, 188, 0.1);
  }

  .acciones {
    display: flex;
    gap: 1rem;
  }
  .acciones span {
    cursor: pointer;
    font-size: 1.2rem;
    user-select: none;
  }
  .acciones span:hover {
    color: #6A4FBC;
  }

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
    <h1 style="color: #4B367C; font-weight: 700; margin: 0;">Categorías</h1>

    <a href="{{ url('/catalogos/categorias/agregar') }}" class="btn-agregar" style="
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

  <div style="overflow-x: auto;">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($categorias as $categoria)
        <tr>
          <td>{{ $categoria->PK_Id_Categoria }}</td>
          <td>{{ $categoria->Nombre }}</td>
          <td>{{ $categoria->Descripcion }}</td>
          <td>{{ ucfirst($categoria->estado) }}</td>
          <td class="acciones">
            <a href="{{ url('/catalogos/categorias/editar/'.$categoria->PK_Id_Categoria) }}" title="Editar">
              <span>✏️</span>
            </a>
            <a href="{{ url('/catalogos/categorias/eliminar/'.$categoria->PK_Id_Categoria) }}" title="Eliminar">
              <span>🗑️</span>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center; padding: 20px 30px;">No hay categorías registradas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación personalizada abajo --}}
  @if ($categorias->hasPages())
    <div class="pagination-summary">
      <div class="pagination-links">
        {{-- Previous --}}
        @if ($categorias->onFirstPage())
          <span aria-disabled="true">« Previous</span>
        @else
          <a href="{{ $categorias->previousPageUrl() }}">« Previous</a>
        @endif

        {{-- Next --}}
        @if ($categorias->hasMorePages())
          <a href="{{ $categorias->nextPageUrl() }}">Next »</a>
        @else
          <span aria-disabled="true">Next »</span>
        @endif
      </div>
      <div class="pagination-info">
        Showing {{ $categorias->firstItem() }} to {{ $categorias->lastItem() }} of {{ $categorias->total() }} results
      </div>
    </div>
  @endif

</main>
@endsection