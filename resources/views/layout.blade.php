<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'AbarroTecs')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
    .logo a {
      transition: transform 0.3s ease;
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      color: inherit;
    }

    .logo a:hover {
      transform: translateY(-3px) scale(1.05);
    }

    .logo-text {
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-left: 8px;
      font-weight: bold;
      font-size: 1.2rem;
      user-select: none;
    }
  </style>
</head>
<body>
  <div id="app">
    <nav class="navbar">
      <div class="logo" style="width: 180px; cursor: pointer;">
        <a href="{{ url('/') }}">
          <img src="{{ asset('images/logo.png') }}" alt="Logo AbarroTecs" style="height: 40px; display: block;" />
          <span class="logo-text">ABARROTECS</span>
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



