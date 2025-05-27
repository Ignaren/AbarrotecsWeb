@extends('layout')

@section('styles')
  <style>
    .table-wrapper {
      overflow-x: auto;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(106, 79, 188, 0.15);
      background: white;
      border: 1px solid #6A4FBC;
      margin-bottom: 2rem;
    }
    table {
      width: 100% !important;
      border-collapse: separate;
      border-spacing: 0 15px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 1rem;
      color: #333;
      min-width: 700px;
    }
    thead tr {
      background-color: #6A4FBC;
      color: white;
      text-align: left;
    }
    thead th, tbody td {
      padding: 18px 25px;
      white-space: nowrap;
      vertical-align: middle;
    }
    .precio {
      font-weight: 700;
      color: #4B367C;
    }
    .btn-agregar {
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
      margin-bottom: 1.5rem;
      display: inline-block;
    }
    .btn-agregar:hover {
      background-color: #4B367C;
    }
  </style>
@endsection

@section('content')
<main class="content fade-in">

  <h1 style="color: #4B367C; font-weight: 700; margin-bottom: 2rem;">Productos más vendidos</h1>

   <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
    
    <a href="{{ url('/catalogos/reportes') }}" class="btn-agregar" style="background-color: #6A4FBC; color: white; font-weight: 700; padding: 0.35rem 0.9rem; border-radius: 12px; box-shadow: 0 3px 8px rgba(106, 79, 188, 0.6); text-decoration: none; font-size: 0.85rem; transition: background-color 0.3s ease; white-space: nowrap; margin-bottom: 1.5rem; display: inline-block;" onmouseover="this.style.backgroundColor='#4B367C'" onmouseout="this.style.backgroundColor='#6A4FBC'">
      ← Regresar
    </a>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>ID del producto</th>
          <th>Nombre del producto</th>
          <th>Existencia</th>
          <th>Precio</th>
          {{-- <th>ID Proveedor</th> --}}
          {{-- <th>Nombre Proveedor</th> --}}
        </tr>
      </thead>
      <tbody>
        @forelse ($productos as $producto)
        <tr>
          <td>{{ $producto->PK_Id_Producto }}</td>
          <td>{{ $producto->Nombre }}</td>
          <td>{{ $producto->Existencia }}</td>
          <td class="precio">${{ number_format($producto->Precio, 2) }}</td>
          {{-- <td>{{ $producto->FK_Id_Proveedor }}</td> --}}
          {{-- <td>{{ $producto->proveedor->Nombre ?? '---' }}</td> --}}
        </tr>
        @empty
        <tr>
          <td colspan="4" style="text-align:center; padding: 20px 30px;">No hay productos registrados en este periodo.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>
@endsection
