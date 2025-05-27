@extends('layout')

@section('styles')
  <style>
    .filtros-reporte {
      display: flex;
      gap: 1rem;
      align-items: flex-end;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }
    .filtros-reporte label {
      font-weight: 600;
      color: #4B367C;
    }
    .filtros-reporte select, .filtros-reporte input {
      padding: 0.4rem 0.8rem;
      border-radius: 8px;
      border: 1px solid #bdbdbd;
      font-size: 1rem;
    }
    .filtros-reporte button {
      background-color: #6A4FBC;
      color: white;
      font-weight: 700;
      padding: 0.45rem 1.2rem;
      border-radius: 8px;
      border: none;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.2s;
    }
    .filtros-reporte button:hover {
      background-color: #4B367C;
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
    thead th, tbody td {
      padding: 18px 25px;
      white-space: nowrap;
      vertical-align: middle;
    }
    .precio {
      font-weight: 700;
      color: #4B367C;
    }
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
  </style>
@endsection

@section('content')
<main class="content fade-in">

  <h1 style="color: #4B367C; font-weight: 700; margin-bottom: 2rem;">Ventas por periodo</h1>

   <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
    <a href="{{ url('/catalogos/reportes') }}" class="btn-agregar" style="background-color: #6A4FBC; color: white; font-weight: 700; padding: 0.35rem 0.9rem; border-radius: 12px; box-shadow: 0 3px 8px rgba(106, 79, 188, 0.6); text-decoration: none; font-size: 0.85rem; transition: background-color 0.3s ease; white-space: nowrap; margin-bottom: 1.5rem; display: inline-block;" onmouseover="this.style.backgroundColor='#4B367C'" onmouseout="this.style.backgroundColor='#6A4FBC'">
      ← Regresar
    </a>
  </div>

  <form method="GET" class="filtros-reporte" id="filtroPeriodoForm">
    <div>
      <label for="tipo">Tipo de reporte:</label>
      <select name="tipo" id="tipo" onchange="mostrarSelectorPeriodo()">
        <option value="semana" {{ request('tipo') == 'semana' ? 'selected' : '' }}>Por semana</option>
        <option value="mes" {{ request('tipo') == 'mes' ? 'selected' : '' }}>Por mes</option>
        <option value="anio" {{ request('tipo') == 'anio' ? 'selected' : '' }}>Por año</option>
      </select>
    </div>
    <div id="selector-semana" style="display: none;">
      <label for="semana">Semana:</label>
      <select name="semana" id="semana">
        @for($i=1; $i<=4; $i++)
          <option value="{{ $i }}" {{ request('semana') == $i ? 'selected' : '' }}>Semana {{ $i }}</option>
        @endfor
      </select>
      <label for="mes_semana">Mes:</label>
      <select name="mes_semana" id="mes_semana">
        @foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $idx => $mes)
          <option value="{{ $idx+1 }}" {{ request('mes_semana') == ($idx+1) ? 'selected' : '' }}>{{ $mes }}</option>
        @endforeach
      </select>
      <label for="anio_semana">Año:</label>
      <select name="anio_semana" id="anio_semana">
        @for($y = date('Y'); $y >= date('Y')-10; $y--)
          <option value="{{ $y }}" {{ request('anio_semana') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>
    <div id="selector-mes" style="display: none;">
      <label for="mes">Mes:</label>
      <select name="mes" id="mes">
        @foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $idx => $mes)
          <option value="{{ $idx+1 }}" {{ request('mes') == ($idx+1) ? 'selected' : '' }}>{{ $mes }}</option>
        @endforeach
      </select>
      <label for="anio_mes">Año:</label>
      <select name="anio_mes" id="anio_mes">
        @for($y = date('Y'); $y >= date('Y')-10; $y--)
          <option value="{{ $y }}" {{ request('anio_mes') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>
    <div id="selector-anio" style="display: none;">
      <label for="anio">Año:</label>
      <select name="anio" id="anio">
        @for($y = date('Y'); $y >= date('Y')-10; $y--)
          <option value="{{ $y }}" {{ request('anio') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
    </div>
    <button type="submit">Filtrar</button>
  </form>

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
          <td colspan="6" style="text-align:center; padding: 20px 30px;">No hay ventas para este periodo.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>

<script>
function mostrarSelectorPeriodo() {
  const tipo = document.getElementById('tipo').value;
  document.getElementById('selector-semana').style.display = tipo === 'semana' ? 'inline-block' : 'none';
  document.getElementById('selector-mes').style.display = tipo === 'mes' ? 'inline-block' : 'none';
  document.getElementById('selector-anio').style.display = tipo === 'anio' ? 'inline-block' : 'none';
}
window.onload = mostrarSelectorPeriodo;
</script>
@endsection
