@extends('layouts.app')

@section('title', 'Detalles del Proveedor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Detalles del Proveedor</h2>
    <div>
        <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light">Volver</a>
    </div>
</div>

<div class="card bg-dark text-white mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title mb-3">Información principal</h5>
                <p><strong>Empresa:</strong> {{ $proveedor->nombre_empresa }}</p>
                <p><strong>País de origen:</strong> {{ $proveedor->pais_origen }}</p>
                <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
            </div>
            <div class="col-md-6">
                <h5 class="card-title mb-3">Contacto principal</h5>
                <p><strong>Persona de contacto:</strong> {{ $proveedor->persona_contacto }}</p>
                <p><strong>Correo electrónico:</strong> {{ $proveedor->correo_electronico }}</p>
                <p><strong>Teléfono:</strong> {{ $proveedor->telefono_contacto }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card bg-dark text-white mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title mb-3">Marcas que maneja</h5>
                @if($proveedor->marcas && count($proveedor->marcas) > 0)
                    <div class="row row-cols-3 g-3">
                        @foreach($proveedor->marcas as $marca)
                            <div class="col">
                                <div class="marca-item">
                                    <div class="marca-logo-container">
                                        <img src="{{ asset('images/marcas/' . strtolower($marca) . '.png') }}" 
                                             alt="{{ $marca }}" 
                                             class="marca-logo"
                                             onerror="this.src='{{ asset('images/marcas/default.png') }}'">
                                    </div>
                                    <p class="marca-nombre mb-0">{{ $marca }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No hay marcas registradas.</p>
                @endif
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <h5 class="card-title mb-3">Tipo de autopartes</h5>
                    @if($proveedor->tipo_autopartes && count($proveedor->tipo_autopartes) > 0)
                        <div class="row row-cols-2 g-2">
                            @foreach($proveedor->tipo_autopartes as $tipo)
                                <div class="col">
                                    <div class="tipo-item">
                                        <i class="fas fa-cog me-2"></i>
                                        {{ $tipo }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No hay tipos de autopartes registrados.</p>
                    @endif
                </div>

                <h5 class="card-title mb-3">Contacto secundario</h5>
                @if($proveedor->persona_contacto_secundaria)
                    <p><strong>Persona de Contacto:</strong> {{ $proveedor->persona_contacto_secundaria }}</p>
                    <p><strong>Teléfono:</strong> {{ $proveedor->telefono_contacto_secundario }}</p>
                @else
                    <p class="text-muted">No hay contacto secundario registrado.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card bg-dark text-white">
    <div class="card-body">
        <h5 class="card-title mb-3">Información adicional</h5>
        <p><strong>Fecha de Registro:</strong> {{ $proveedor->created_at ? $proveedor->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
        <p><strong>Última Actualización:</strong> {{ $proveedor->updated_at ? $proveedor->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
    </div>
</div>

<style>
    .marca-logo-container {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        border-radius: 5px;
        padding: 10px;
        margin: 0 auto;
    }
    .marca-logo {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .marca-item {
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.1);
        transition: background-color 0.3s ease;
    }
    .marca-item:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .marca-item:hover .marca-logo {
        transform: scale(1.1);
    }
    .marca-nombre {
        margin-top: 8px;
        font-size: 0.9rem;
    }
    .tipo-item {
        padding: 8px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
        font-size: 0.9rem;
    }
</style>
@endsection 