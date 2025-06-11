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
                <h5 class="card-title mb-3">Información Principal</h5>
                <p><strong>Empresa:</strong> {{ $proveedor->nombre_empresa }}</p>
                <p><strong>País de Origen:</strong> {{ $proveedor->pais_origen }}</p>
                <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
            </div>
            <div class="col-md-6">
                <h5 class="card-title mb-3">Contacto Principal</h5>
                <p><strong>Persona de Contacto:</strong> {{ $proveedor->persona_contacto }}</p>
                <p><strong>Correo Electrónico:</strong> {{ $proveedor->correo_electronico }}</p>
                <p><strong>Teléfono:</strong> {{ $proveedor->telefono_contacto }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card bg-dark text-white mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title mb-3">Información de Productos</h5>
                <p><strong>Marcas que Maneja:</strong></p>
                @if($proveedor->marcas && count($proveedor->marcas) > 0)
                    <ul>
                        @foreach($proveedor->marcas as $marca)
                            <li>{{ $marca }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No hay marcas registradas.</p>
                @endif

                <p><strong>Tipo de Autopartes:</strong></p>
                @if($proveedor->tipo_autopartes && count($proveedor->tipo_autopartes) > 0)
                    <ul>
                        @foreach($proveedor->tipo_autopartes as $tipo)
                            <li>{{ $tipo }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No hay tipos de autopartes registrados.</p>
                @endif
            </div>
            <div class="col-md-6">
                <h5 class="card-title mb-3">Contacto Secundario</h5>
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
        <h5 class="card-title mb-3">Información Adicional</h5>
        <p><strong>Fecha de Registro:</strong> {{ $proveedor->created_at ? $proveedor->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
        <p><strong>Última Actualización:</strong> {{ $proveedor->updated_at ? $proveedor->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
    </div>
</div>
@endsection 