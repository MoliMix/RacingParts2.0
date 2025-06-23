@extends('layouts.app')

@section('title', 'Lista de Productos')

@section('content')
    <div class="container py-5">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Lista de productos</h2>
                <span class="text-white">Total: <strong>{{ $productos->total() }}</strong></span>
            </div>

            {{-- Mensajes de éxito y error --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">+ Nuevo producto</a>

            <form action="{{ route('productos.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar producto por nombre, marca o modelo" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover text-center align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $loop->iteration + ($productos->currentPage() - 1) * $productos->perPage() }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->modelo }}</td>
                            <td>L {{ number_format($producto->precio, 2) }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->anio }}</td>
                            <td>
                                <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm me-1">Ver</a>
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm me-1">Editar</a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-white">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación personalizada --}}
            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $productos->withQueryString()->links('vendor.pagination.bootstrap-5') }}
            </div>

            <div class="d-flex gap-2 align-items-center mt-3 mb-4">
                <a href="{{ route('welcome') }}" class="btn btn-outline-light">Inicio</a>
                <button type="button" class="btn btn-outline-light" onclick="window.history.back();">Volver</button>
            </div>

        </div>

        </div>
    </div>
@endsection



@if(request('search') && isset($productosFiltrados))
    <div class="fixed-bottom text-center mb-3">
        <div class="d-inline-block bg-dark text-white py-2 px-4 rounded shadow">
            Se encontraron <strong>{{ $productosFiltrados }}</strong> resultados de <strong>{{ $totalProductos }}</strong> productos en total.
        </div>

        <div class="mt-2">
            <a href="{{ route('productos.index') }}" class="btn btn-sm btn-outline-light">
                Ver todos los productos
            </a>
        </div>
    </div>
@endif
