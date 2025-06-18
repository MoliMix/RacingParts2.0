@extends('layouts.app')

@section('title', 'Lista de Proveedores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Lista de Proveedores</h2>
    <span class="text-muted">Total: <strong>{{ $proveedores->total() }}</strong></span>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">+ Nuevo Proveedor</a>

<form action="{{ route('proveedores.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control search-input" placeholder="Buscar por nombre de empresa, país o persona de contacto" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-dark table-striped table-hover text-center align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Empresa</th>
                <th>País</th>
                <th>Persona de Contacto</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proveedores as $proveedor)
                <tr>
                    <td>{{ $loop->iteration + ($proveedores->currentPage() - 1) * $proveedores->perPage() }}</td>
                    <td>{{ $proveedor->nombre_empresa }}</td>
                    <td>{{ $proveedor->pais_origen }}</td>
                    <td>{{ $proveedor->persona_contacto }}</td>
                    <td>{{ $proveedor->telefono_contacto }}</td>
                    <td>
                        <a href="{{ route('proveedores.show', $proveedor->id) }}" class="btn btn-info btn-sm">Ver más</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay proveedores registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

---

{{-- Paginación bonita y centrada (usa la vista personalizada que definimos) --}}
<div class="d-flex justify-content-center mt-4 mb-4">
    {{ $proveedores->withQueryString()->links('vendor.pagination.bootstrap-5') }} {{-- Asegúrate de usar 'bootstrap-5' o el nombre de tu archivo personalizado --}}
</div>

---

<a href="{{ route('welcome') }}" class="btn btn-outline-light mt-3">Inicio</a>

<style>
    /* Estilos para el campo de búsqueda */
    .search-input::placeholder {
        color: #ffffff !important;
        opacity: 0.7;
    }
    .search-input {
        background-color: #343a40 !important;
        color: #ffffff !important;
        border-color: #6c757d !important;
    }
    .search-input:focus {
        background-color: #343a40 !important;
        color: #ffffff !important;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }

    /* Estilos para la paginación personalizada (NUEVOS ESTILOS) */
    .pagination-custom {
        display: flex;
        padding-left: 0;
        border-radius: 0.25rem;
    }

    .pagination-custom li {
        margin: 0 4px;
        list-style: none; /* Asegura que no haya viñetas de lista */
    }

    .page-link-custom {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        color: #0d6efd;
        background-color: #343a40;
        border: 1px solid #454d55;
        border-radius: 0.25rem;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500; /* Un poco más de grosor en el texto */
    }

    .page-link-custom:hover {
        color: #ffffff;
        background-color: #0d6efd;
        border-color: #0d6efd;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2); /* Sombra sutil al pasar el ratón */
    }

    .page-link-custom.active,
    .pagination-custom li.active .page-link-custom {
        color: #ffffff;
        background-color: #0d6efd;
        border-color: #0d6efd;
        font-weight: bold; /* Más énfasis en la página activa */
    }

    .pagination-custom li.disabled .page-link-custom {
        color: #6c757d;
        background-color: #343a40;
        border-color: #454d55;
        cursor: not-allowed;
        opacity: 0.6;
        transform: none;
        box-shadow: none;
    }

    /* Estilos para el texto de resumen */
    .text-sm.text-gray-700.leading-5.text-muted {
        color: #ced4da !important;
        font-size: 0.875rem;
        align-self: center; /* Alinea el texto verticalmente en el centro */
    }

    /* Estilo para los botones de paginación en móviles */
    .btn-dark-outline {
        color: #ced4da;
        border-color: #495057;
        background-color: #343a40;
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }

    .btn-dark-outline:hover {
        color: #ffffff;
        background-color: #495057;
        border-color: #495057;
    }

    .btn-dark-outline.disabled {
        color: #6c757d;
        background-color: #343a40;
        border-color: #495057;
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@endsection