@extends('layouts.app')

@section('title', 'Lista de Facturas')

@section('content')
    <div class="container py-5">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Lista facturas registradas</h2>
                <span class="text-white">Total: <strong>{{ $facturas->total() }}</strong></span>
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

            <a href="{{ route('facturas.create') }}" class="btn btn-primary mb-3">+ Nueva factura</a>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover text-center align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código</th> {{-- Columna para el código de factura --}}
                        <th scope="col">Cliente</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($facturas as $factura)
                        <tr>
                            <td>{{ $loop->iteration + ($facturas->currentPage() - 1) * $facturas->perPage() }}</td>
                            <td>{{ $factura->codigo }}</td> {{-- Mostrar el código de la factura --}}
                            <td>{{ $factura->cliente }}</td>
                            <td>{{ $factura->fecha ? \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') : '' }}</td>
                            <td>L. {{ number_format($factura->total, 2) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-info btn-sm" title="Ver Detalles">Ver</a>
                                    <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-warning btn-sm" title="Editar Factura">Editar</a>
                                    <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta factura?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Factura">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-white">No hay facturas registradas.</td> {{-- Colspan ajustado a 6 --}}
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $facturas->links('vendor.pagination.bootstrap-5') }}
            </div>

            <div class="d-flex gap-2 align-items-center mt-3 mb-4">
                <a href="{{ route('welcome') }}" class="btn btn-outline-light">Inicio</a>
                <button type="button" class="btn btn-outline-light" onclick="window.history.back();">Volver</button>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Estilos generales para el fondo y texto */
    body {
        background-color: #343a40; /* Fondo oscuro */
        color: #f8f9fa; /* Texto claro */
    }
    .table-container {
        background-color: #212529; /* Contenedor de tabla con fondo un poco más oscuro */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .table-dark th, .table-dark td {
        border-color: #454d55; /* Bordes de tabla más claros */
    }
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #212529; /* Texto oscuro para botón info */
    }
    .btn-info:hover {
        background-color: #31d2f2;
        border-color: #25cff2;
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529; /* Texto oscuro para botón warning */
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
    }
    .btn-outline-light {
        color: #f8f9fa;
        border-color: #f8f9fa;
    }
    .btn-outline-light:hover {
        color: #212529;
        background-color: #f8f9fa;
    }
</style>
