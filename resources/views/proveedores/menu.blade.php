@extends('layouts.app')

@section('title', 'Sistema de Proveedores')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-4 mb-4">Sistema de Proveedores</h1>
    <p class="lead">Seleccione la operación que desea realizar</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-5 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="system-icon mb-4">
                    <i class="fas fa-truck-loading fa-4x text-success"></i>
                </div>
                <h3 class="card-title mb-4">Registrar Proveedor</h3>
                <p class="card-text mb-4">Registre un nuevo proveedor en el sistema con su información de contacto y productos.</p>
                <a href="{{ route('proveedores.create') }}" class="btn btn-success btn-lg w-100">Registrar</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-5 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="system-icon mb-4">
                    <i class="fas fa-list fa-4x text-success"></i>
                </div>
                <h3 class="card-title mb-4">Lista de Proveedores</h3>
                <p class="card-text mb-4">Visualice y gestione la lista completa de proveedores registrados en el sistema.</p>
                <a href="{{ route('proveedores.index') }}" class="btn btn-success btn-lg w-100">Ver Lista</a>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <a href="{{ route('welcome') }}" class="btn btn-outline-light btn-lg">
        <i class="fas fa-arrow-left me-2"></i>Volver al Inicio
    </a>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 15px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .system-icon {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .card-text {
        font-size: 1.1rem;
        color: #6c757d;
    }
    .btn {
        padding: 12px 30px;
        font-weight: 500;
        border-radius: 8px;
    }
</style>
@endsection 