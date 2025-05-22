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
      min-width: 900px;
    }

    thead tr {
      background-color: #6A4FBC;
      color: white;
      text-align: left;
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
    }

    .btn-agregar:hover {
      background-color: #4B367C;
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
    <h1 style="color: #4B367C; font-weight: 700; margin: 0;">Clientes</h1>

    <a class="btn-agregar" href="#">+ Agregar Cliente</a>

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
          <th>Email</th>
          <th>RFC</th>
          <th>Teléfono</th>
          <th>Dirección</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($clientes as $cliente)
        <tr>
          <td>{{ $cliente->PK_Id_Cliente }}</td>
          <td>{{ $cliente->Nombre }}</td>
          <td>{{ $cliente->Email }}</td>
          <td>{{ $cliente->RFC }}</td>
          <td>{{ $cliente->Telefono }}</td>
          <td>{{ $cliente->Direccion }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding: 20px 30px;">No hay clientes registrados.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>
@endsection
