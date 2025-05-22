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
    width: 100% !important; /* Que ocupe todo el ancho del contenedor */
    min-width: unset;       /* No limitar ancho mínimo */
  }

  /* Más espacio en celdas */
  table th,
  table td {
    padding: 20px 30px !important;
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

    <a href="#" class="btn-agregar" style="
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
      + Agregar Categoría
    </a>
  </div>

  @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 6px; border: 1px solid #c3e6cb; margin-bottom: 1.5rem;">
      {{ session('success') }}
    </div>
  @endif

  <div style="overflow-x: auto;">
    <table style="border-collapse: separate; border-spacing: 0 10px; font-family: Arial, sans-serif; font-size: 1rem; color: #333;">
      <thead>
        <tr style="background-color: #6A4FBC; color: white; text-align: left;">
          <th style="padding: 20px 30px; border-radius: 8px 0 0 8px;">ID</th>
          <th style="padding: 20px 30px;">Nombre</th>
          <th style="padding: 20px 30px; border-radius: 0 8px 8px 0;">Descripción</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($categorias as $categoria)
        <tr style="background: white; box-shadow: 0 2px 5px rgba(106, 79, 188, 0.1);">
          <td style="padding: 20px 30px;">{{ $categoria->PK_Id_Categoria }}</td>
          <td style="padding: 20px 30px;">{{ $categoria->Nombre }}</td>
          <td style="padding: 20px 30px;">{{ $categoria->Descripcion }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" style="text-align:center; padding: 20px 30px;">No hay categorías registradas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>
@endsection
