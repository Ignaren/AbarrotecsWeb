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
      min-width: 700px;
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

    /* Estilo para el enlace Detalles */
    .detalle-link {
      color: #6A4FBC;
      font-weight: 700;
      text-decoration: none;
      transition: color 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }
    .detalle-link:hover {
      color: #4B367C;
      text-decoration: underline;
    }
    .precio {
      font-weight: 700;
      color: #4B367C;
    }
  </style>
@endsection

@section('content')
<main class="content fade-in">

  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
    <h1 style="color: #4B367C; font-weight: 700; margin: 0;">Ventas Diarias</h1>
    <a href="{{ url('/catalogos/reportes') }}" class="btn-agregar" style="background-color: #6A4FBC; color: white; font-weight: 700; padding: 0.35rem 0.9rem; border-radius: 12px; box-shadow: 0 3px 8px rgba(106, 79, 188, 0.6); text-decoration: none; font-size: 0.85rem; transition: background-color 0.3s ease; white-space: nowrap;" onmouseover="this.style.backgroundColor='#4B367C'" onmouseout="this.style.backgroundColor='#6A4FBC'">
      ← Regresar
    </a>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>ID venta</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>ID Cliente</th>
          <th>Nombre Cliente</th>
          <th>Más...</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($ventas as $venta)
        <tr>
          <td>{{ $venta->PK_Id_Venta }}</td>
          <td>{{ $venta->Fecha }}</td>
          <td class="precio">${{ number_format($venta->Total, 2) }}</td>
          <td>{{ $venta->FK_Id_Cliente }}</td>
          <td>{{ $venta->cliente_nombre ?? '---' }}</td>
          <td>
            <a href="{{ url('/reportes/detallesReportes/'.$venta->PK_Id_Venta) }}" class="detalle-link">
              Detalles
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                <rect width="18" height="20" x="3" y="2" rx="4" fill="#f5b041" stroke="#b9770e" stroke-width="1.5"/>
                <rect width="10" height="2" x="7" y="4" rx="1" fill="#fff"/>
                <rect width="14" height="12" x="5" y="8" rx="2" fill="#fff" stroke="#b9770e" stroke-width="1"/>
              </svg>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding: 20px 30px;">No hay ventas registradas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>
@endsection
