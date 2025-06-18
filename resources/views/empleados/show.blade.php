@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="row">
    {{-- Columna Izquierda: Resumen del Empleado y Botones --}}
    <div class="col-md-4">
        <div class="card bg-dark text-white h-100">
            <div class="card-body text-center pb-2"> {{-- Ajuste de padding inferior --}}
                <div class="avatar-container mb-2"> {{-- Margen inferior más pequeño --}}
                    <i class="fas {{ $empleado->sexo === 'Masculino' ? 'fa-male' : 'fa-female' }} fa-4x {{ $empleado->sexo === 'Masculino' ? 'text-primary' : 'text-danger' }}"></i>
                </div>
                <h4 class="card-title mb-1">{{ $empleado->nombre }} {{ $empleado->apellido }}</h4> {{-- Margen inferior más pequeño --}}
                <p class="text-muted mb-2">{{ $empleado->puesto }}</p> {{-- Margen inferior más pequeño --}}
                <div class="empleado-status {{ $empleado->estado === 'Activo' ? 'status-activo' : 'status-inactivo' }} mb-3"> {{-- Margen inferior para separar de los botones --}}
                    {{ $empleado->estado }}
                </div>
                <div class="d-flex justify-content-center gap-2 mt-2"> {{-- Botones centrados y con un pequeño espacio --}}
                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a> {{-- Botones más pequeños --}}
                    <a href="{{ route('empleados.index') }}" class="btn btn-outline-light btn-sm">Volver</a> {{-- Botones más pequeños --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Columna Derecha: Información Personal y Laboral/Adicional --}}
    <div class="col-md-8">
        <div class="card bg-dark text-white h-100"> {{-- Ajuste de altura para que coincida con la tarjeta izquierda --}}
            <div class="card-body pb-0"> {{-- Ajuste de padding inferior --}}
                <h5 class="card-title mb-3">Información personal</h5>
                <div class="row gx-2"> {{-- Reducir el espacio entre columnas --}}
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-id-card me-2"></i><strong>identidad:</strong> {{ $empleado->identidad }}</p> {{-- Margen inferior más pequeño --}}
                        <p class="mb-2"><i class="fas fa-venus-mars me-2"></i><strong>sexo:</strong> {{ $empleado->sexo }}</p> {{-- Margen inferior más pequeño --}}
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i><strong>correo:</strong> {{ $empleado->correo }}</p> {{-- Margen inferior más pequeño --}}
                        <p class="mb-2"><i class="fas fa-phone me-2"></i><strong>teléfono:</strong> {{ $empleado->telefono }}</p> {{-- Margen inferior más pequeño --}}
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i><strong>dirección:</strong> {{ $empleado->direccion }}</p> {{-- Margen inferior más pequeño --}}
                    </div>
                </div>

                <h5 class="card-title mt-4 mb-3">Información laboral y adicional</h5> {{-- Un solo título para ambas secciones --}}
                <div class="row gx-2"> {{-- Reducir el espacio entre columnas --}}
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-briefcase me-2"></i><strong>puesto:</strong> {{ $empleado->puesto }}</p> {{-- Margen inferior más pequeño --}}
                        <p class="mb-2"><i class="fas fa-calendar-alt me-2"></i><strong>fecha contratación:</strong> {{ $empleado->fecha_contratacion }}</p> {{-- Margen inferior más pequeño --}}
                        <p class="mb-2"><i class="fas fa-calendar-plus me-2"></i><strong>registro:</strong> {{ $empleado->created_at ? $empleado->created_at->format('d/m/Y H:i') : 'No disponible' }}</p> {{-- Margen inferior más pequeño --}}
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-money-bill-wave me-2"></i><strong>salario:</strong> L. {{ number_format($empleado->salario, 2, '.', ',') }}</p> {{-- Margen inferior más pequeño --}}
                        <p class="mb-2"><i class="fas fa-calendar-check me-2"></i><strong>Última actualización:</strong> {{ $empleado->updated_at ? $empleado->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p> {{-- Margen inferior más pequeño --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-container {
        width: 120px; /* Reducir tamaño del avatar */
        height: 120px; /* Reducir tamaño del avatar */
        margin: 0 auto;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 3px solid rgba(255, 255, 255, 0.2);
    }
    .avatar-container:hover {
        transform: scale(1.05); /* Efecto hover más sutil */
        border-color: rgba(255, 255, 255, 0.4);
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.1); /* Sombra más pequeña */
    }
    .avatar-container .fas { /* Ajustar tamaño del icono dentro del avatar */
        font-size: 3em !important; /* Más pequeño que 4em */
    }
    .empleado-status {
        display: inline-block;
        padding: 4px 12px; /* Padding más pequeño */
        border-radius: 20px;
        font-size: 0.85rem; /* Fuente un poco más pequeña */
        font-weight: 500;
    }
    .status-activo {
        background-color: #28a745;
        color: white;
    }
    .status-inactivo {
        background-color: #dc3545;
        color: white;
    }
    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra más sutil */
    }
    .card-title {
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08); /* Borde más delgado */
        padding-bottom: 8px; /* Padding inferior más pequeño */
        margin-bottom: 15px; /* Margen inferior más pequeño */
        font-size: 1.15rem; /* Título un poco más pequeño */
    }
    .fas {
        width: 18px; /* Iconos un poco más pequeños */
        text-align: center;
    }
    p {
        margin-bottom: 0.6rem; /* Reducir el margen inferior de los párrafos */
        font-size: 0.95rem; /* Fuente ligeramente más pequeña para el texto de los detalles */
    }
</style>
@endsection