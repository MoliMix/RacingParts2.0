@extends('layouts.app')

@section('title', 'Lista de Productos')

@section('content')
    <div class="container py-5">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Lista de productos</h2>
                <span class="text-white">Total: <strong>{{ $productos->total() }}</strong></span>
            </div>

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

            <form action="{{ route('productos.index') }}" method="GET" class="mb-4">
                @if(request()->hasAny(['nombre', 'modelo', 'anio', 'marca', 'categoria']))
                    <div class="mb-2 d-flex justify-content-end">
                        <a href="{{ route('productos.index') }}" class="btn btn-outline-light btn-sm">
                            Ver todos los productos
                        </a>
                    </div>
                @endif

                <div class="row g-2">
                    <div class="col-md-3">
                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            placeholder="Buscar por nombre"
                            value="{{ request('nombre') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <input
                            type="text"
                            name="modelo"
                            class="form-control"
                            placeholder="Buscar por modelo"
                            value="{{ request('modelo') }}"
                        >
                    </div>

                    <div class="col-md-2">
                        <input
                            type="number"
                            name="anio"
                            class="form-control"
                            placeholder="Buscar por año"
                            value="{{ request('anio') }}"
                            min="1990"
                            max="{{ date('Y') }}"
                        >
                    </div>

                    <div class="col-md-2">
                        <select name="marca" class="form-control">
                            <option value="">Marca (todas)</option>
                            @php
                                $marcas = ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'];
                            @endphp
                            @foreach($marcas as $marca)
                                <option value="{{ $marca }}" {{ request('marca') == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="categoria" class="form-control">
                            <option value="">Categoría (todas)</option>
                            @php
                                $categorias = ['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'];
                            @endphp
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>{{ $categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 d-grid">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
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
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->anio }}</td>
                            <td>
                                <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm me-1">Ver</a>
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm me-1">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-white">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(request()->hasAny(['nombre', 'modelo', 'anio', 'marca', 'categoria']) && isset($productosFiltrados))
                <div class="mt-4 mb-4 text-center">
                    <div class="d-inline-block bg-dark text-white py-2 px-4 rounded shadow">
                        Se encontraron <strong>{{ $productosFiltrados }}</strong> resultados de <strong>{{ $totalProductos }}</strong> productos en total.
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $productos->withQueryString()->links('vendor.pagination.bootstrap-5') }}
            </div>

            <div class="d-flex gap-2 align-items-center mt-3 mb-4">
                <a href="{{ route('welcome') }}" class="btn btn-outline-light">Inicio</a>
                <button type="button" class="btn btn-outline-light" onclick="window.history.back();">Volver</button>
            </div>
        </div>
    </div>
@endsection
