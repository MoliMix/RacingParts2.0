@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="row g-3"> {{-- Gap entre columnas en Bootstrap 5 --}}
    {{-- Columna Izquierda: Resumen del Empleado y Botones --}}
    <div class="col-md-4">
        <div class="card bg-dark text-white h-100 shadow-lg">
            <div class="card-body text-center d-flex flex-column pb-3">
                <div class="avatar-container mb-3">
                    <i class="fas {{ $clientes->sexo === 'Masculino' ? 'fa-male' : 'fa-female' }} fa-4x {{ $clientes->sexo === 'Masculino' ? 'text-primary' : 'text-danger' }}"></i>
                </div>
                <h4 class="card-title mb-2">{{ $c->nombre_completo }} {{ $clientes->nombre_completo }}</h4>
                <p class="text-muted mb-3 text-wrap">{{ $clientes->puesto }}</p>
                <div class="empleado-status {{ $clientes->estado === 'Activo' ? 'status-activo' : 'status-inactivo' }} mb-4">
                    {{ $clientes->estado }}
                </div>
                <div class="d-flex justify-content-center gap-2 mt-auto pt-2">
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-light btn-sm">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Columna Derecha: Información Personal y Laboral --}}
    <div class="col-md-8">
        <div class="card bg-dark text-white h-100 shadow-lg">
            <div class="card-body pb-3">
                <h5 class="card-title mb-3 border-bottom border-secondary pb-2">Información personal</h5>
                <div class="row gx-3 gy-2">
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-id-card me-2"></i><strong>Nombre:</strong> {{ $cliente->nombre_completo }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-phone me-2"></i><strong>Número de teléfono:</strong> {{ $cliente->telefono }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-envelope me-2"></i><strong>Correo electrónico:</strong> {{ $c->correo_electronico }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-map-marker-alt me-2"></i><strong>Dirección de envío:</strong> {{ $cliente->direccion_envio }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-car me-2"></i><strong>Tipo de vehículo:</strong> {{ $cliente->tipo_vehiculo }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-history me-2"></i><strong>Historial de compra:</strong> {{ $cliente->historial_compras }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-credit-card me-2"></i><strong>Método de pago:</strong> {{ $cliente->metodo_pago_preferido }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #1a1a1a; /* Fondo oscuro */
        color: #e0e0e0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .card {
        background-color: #2b2b2b; /* Fondo de tarjeta oscuro */
        border: 1px solid #444; /* Borde sutil */
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); /* Sombra definida */
    }

    .avatar-container {
        width: 100px; /* Tamaño compacto */
        height: 100px;
        margin: 0 auto 1.5rem; /* Margen inferior */
        background-color: rgba(255, 255, 255, 0.08); /* Color oscuro */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 3px solid rgba(255, 255, 255, 0.15); /* Borde sutil */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Sombra para el avatar */
    }

    .avatar-container:hover {
        transform: scale(1.08); /* Efecto hover */
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
    }

    .empleado-status {
        display: inline-block;
        padding: 5px 15px; /* Padding ajustado */
        border-radius: 25px; /* Más redondeado */
        font-size: 0.9rem; /* Fuente más grande */
        font-weight: 600; /* Más audaz */
        text-transform: uppercase; /* Mayúsculas */
        letter-spacing: 0.5px; /* Espaciado entre letras */
    }

    .status-activo {
        background-color: #28a745; /* Verde */
        color: white;
    }

    .status-inactivo {
        background-color: #dc3545; /* Rojo */
        color: white;
    }

    .card-title {
        color: #ffffff;
        font-size: 1.25rem; /* Tamaño de título */
        font-weight: 600;
        margin-bottom: 1rem;
    }

    p {
        margin-bottom: 0.75rem; /* Espaciado entre párrafos */
        font-size: 0.95rem; /* Fuente más pequeña */
        line-height: 1.5; /* Altura de línea */
        white-space: normal; /* Asegura que el texto no se mantenga en una sola línea */
        word-wrap: break-word; /* Rompe palabras largas */
        overflow-wrap: break-word; /* Moderno para word-wrap */
    }

    .info-fecha {
        font-size: 0.85rem; /* Más pequeño para que quepa en una sola línea */
        white-space: nowrap; /* Intenta forzar a una sola línea */
        overflow: hidden; /* Oculta texto que se desborde */
        text-overflow: ellipsis; /* Añade puntos suspensivos si se desborda */
    }

    .info-fecha strong {
        font-size: 0.85rem; /* Ajuste para el strong */
    }

    p strong {
        color: #b0b0b0; /* Color más claro para etiquetas */
    }

    .fas {
        width: 20px; /* Ancho fijo para iconos */
        text-align: center;
        color: #0d6efd; /* Color por defecto para iconos */
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529; /* Texto oscuro */
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #212529;
    }

    .btn-outline-light {
        color: #f8f9fa;
        border-color: #f8f9fa;
    }

    .btn-outline-light:hover {
        background-color: #f8f9fa;
        color: #212529;
    }
</style>
@endsection
