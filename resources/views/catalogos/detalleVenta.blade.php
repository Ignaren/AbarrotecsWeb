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
      text-align: center;
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
      text-align: center;
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
      text-align: center;
    }

    tbody tr:hover td {
      border-left-color: #6A4FBC;
    }

    tfoot td {
      padding: 18px 25px;
      font-weight: bold;
      background-color: #eee;
      text-align: center;
    }

    /* Scrollbar */
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

  <div style="margin-bottom: 1.2rem;">
    <h1 style="color: #4B367C; font-weight: 700; margin: 0; text-align: center;">
      Detalle de la Venta
    </h1>
    <p style="text-align: center; margin-top: 0.5rem; color: #6A4FBC;">
      Cliente: <strong>{{ optional($detalles->first()->venta->cliente)->Nombre ?? 'Desconocido' }}</strong>
    </p>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio Unitario</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @forelse ($detalles as $detalle)
          @php
            $subtotal = $detalle->Cantidad * $detalle->Precio_Unitario;
            $total += $subtotal;
          @endphp
          <tr>
            <td>{{ optional($detalle->producto)->Nombre ?? 'Producto no encontrado' }}</td>
            <td>${{ number_format($detalle->Precio_Unitario, 2) }}</td>
            <td>{{ $detalle->Cantidad }}</td>
            <td>${{ number_format($subtotal, 2) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="text-align:center; padding: 20px 30px;">No hay detalles para esta venta.</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" style="text-align: right;">Total:</td>
          <td>${{ number_format($total, 2) }}</td>
        </tr>
      </tfoot>
    </table>
  </div>

</main>
@endsection
