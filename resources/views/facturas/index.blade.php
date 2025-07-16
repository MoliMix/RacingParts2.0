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
                            <td>{{ $factura->cliente }}</td>
                            <td>{{ $factura->fecha ? \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') : '' }}</td>
                            <td>L. {{ number_format($factura->total, 2) }}</td>
                            <td>
                                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-info btn-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-white">No hay facturas registradas.</td>
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
