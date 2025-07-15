@extends('layouts.app')

@section('title', 'Gestión de Clientes')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Listado de Clientes</h2>
        </div>

        {{-- Consolidated Success and Error Messages --}}
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

        {{-- Add New Client Button --}}
        <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-user-plus me-2"></i>Agregar nuevo cliente
        </a>

       {{-- Search Form --}}
<form action="{{ route('clientes.index') }}" method="GET" class="mb-3" id="search-form">
    <div class="input-group">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Buscar cliente por nombre, identidad o teléfono"
            value="{{ request('search') }}"
            id="search-input"
        >
        <button type="submit" class="btn btn-primary">Buscar</button>

    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');
        let timeoutId; // Variable to store the timeout ID

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function() { // Use 'input' event for real-time changes
                clearTimeout(timeoutId); // Clear any previous timeout

                // Set a new timeout
                timeoutId = setTimeout(() => {
                    // Submit the form
                    searchForm.submit();
                }, 300); // 300ms delay: adjust as needed (e.g., 500ms for slower servers)
            });
        }
    });
</script>
@endpush

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Numero de Identidad</th>
                        <th>Número de Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección del cliente</th>
                        <th>Fecha de ingreso</th>
                        <th>Sexo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $cliente->nombre_completo ?? $cliente->nombre_completo }}</td>
                            <td class="align-middle">{{ $cliente->numero_id ?? $cliente->numero_id }}</td>
                            <td class="align-middle">{{ $cliente->numero_telefono ?? $cliente->telefonumero_telefonono }}</td>
                            <td class="align-middle">{{ $cliente->correo_electronico ?? $cliente->correo_electronico }}</td>
                            <td class="align-middle">{{ $cliente->direccion_cliente ?? $cliente->direccion_cliente }}</td>
                            <td class="align-middle">{{ $cliente->fecha_ingreso ?? $cliente->fecha_ingreso }}</td>
                             <td class="align-middle">{{ $cliente->sexo ?? $cliente->sexo }}</td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm" title="Editar Cliente">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                                                    </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-white py-4">No hay clientes registrados aún.</td>
                        </tr>
                    @endforelse
                    <br>
                    {{-- In your layouts/app.blade.php --}}
<script src="{{ asset('js/app.js') }}"></script> {{-- Your main JS file if you have one --}}
@stack('scripts') {{-- This is essential for the script to run --}}
</body>
</html>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (isset($cliente) && method_exists  ($cliente, 'links'))
            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $cliente->withQueryString()->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif

        <div class="d-flex gap-2 align-items-center mt-3 mb-4">
            <a href="{{ route('clientes.menu') }}" class="btn btn-outline-light">Volver</a>
            
        </div>
    </div>
@endsection
