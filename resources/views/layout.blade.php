<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'AbarroTecs')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <div id="app">
    <nav class="navbar">
      <div class="logo" style="width: 150px;">
        <a href="{{ url('/') }}" style="display: block;">
          <img src="{{ asset('images/logo.png') }}" alt="Logo AbarroTecs" style="height: 40px; display: block;" />
        </a>
      </div>
      <div class="nav-links">
        <a href="{{ url('/') }}">Inicio</a>
        <a href="{{ url('/catalogos/categorias') }}">Categorías</a>
        <a href="{{ url('/catalogos/productos') }}">Productos</a>
        <a href="{{ url('/catalogos/proveedores') }}">Proveedores</a>
        <a href="{{ url('/catalogos/clientes') }}">Clientes</a>
        <a href="{{ url('/catalogos/ventas') }}">Ventas</a>
      </div>
    </nav>

    @yield('content')

    <footer class="footer">
      &copy; {{ date('Y') }} AbarroTecs INC. Todos los derechos reservados.
    </footer>
  </div>
</body>
</html>
