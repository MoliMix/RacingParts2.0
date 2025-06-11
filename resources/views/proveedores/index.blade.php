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

{{ $proveedores->withQueryString()->links() }}

<a href="{{ route('welcome') }}" class="btn btn-outline-light mt-3">Inicio</a>

<style>
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
</style>
@endsection 