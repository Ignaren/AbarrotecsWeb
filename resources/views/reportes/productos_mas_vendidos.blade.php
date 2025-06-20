@extends('layout')

@section('title', 'Productos más vendidos')

@section('content')
<main class="content fade-in" style="max-width: 700px; margin: 0 auto;">
    {{-- Breadcrumbs dinámicos --}}
    @if(isset($breadcrumbs) && count($breadcrumbs))
        <nav style="margin-top: 20px; margin-bottom: 10px; font-size: 1.05em; color: #888;">
            @foreach($breadcrumbs as $label => $url)
                @if($loop->last)
                    <span style="color: #2c3e50; font-weight: bold;">{{ $label }}</span>
                @else
                    <a href="{{ $url }}" style="color: #3490dc; text-decoration: none;">{{ $label }}</a>
                    <span style="margin: 0 6px;">/</span>
                @endif
            @endforeach
        </nav>
    @endif

    <h2 class="mb-4" style="font-weight: bold; color: #2c3e50;">Productos más vendidos</h2>

    @if($productos->count())
        <table class="table table-bordered" style="width: 100%; background: #fff;">
            <thead style="background: #f5f5f5;">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad vendida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->Nombre }}</td>
                        <td>{{ $producto->total_vendidos }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #888;">No hay ventas registradas.</p>
    @endif
</main>
@endsection