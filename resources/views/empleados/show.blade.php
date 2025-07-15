@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="row g-3"> {{-- Usar g-3 para un gap entre columnas en Bootstrap 5 --}}
    {{-- Columna Izquierda: Resumen del Empleado y Botones --}}
    <div class="col-md-4">
        <div class="card bg-dark text-white h-100 shadow-lg"> {{-- Añadir sombra para mejor estética --}}
            <div class="card-body text-center pb-3 d-flex flex-column"> {{-- Añadir flex-column para empujar el contenido hacia abajo --}}
                <div class="avatar-container mb-3"> {{-- Margen inferior adecuado --}}
                    {{-- Usar Font Awesome para iconos de género --}}
                    <i class="fas {{ $empleado->sexo === 'Masculino' ? 'fa-male' : 'fa-female' }} fa-4x {{ $empleado->sexo === 'Masculino' ? 'text-primary' : 'text-danger' }}"></i>
                </div>
                <h4 class="card-title mb-2">{{ $empleado->nombre }} {{ $empleado->apellido }}</h4>
                <p class="text-muted mb-3 text-wrap">{{ $empleado->puesto }}</p> {{-- Asegurar text-wrap también aquí --}}
                <div class="empleado-status {{ $empleado->estado === 'Activo' ? 'status-activo' : 'status-inactivo' }} mb-4">
                    {{ $empleado->estado }}
                </div>
                <div class="d-flex justify-content-center gap-2 mt-auto pt-2"> {{-- mt-auto y pt-2 para empujar los botones abajo --}}
                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <a href="{{ route('empleados.index') }}" class="btn btn-outline-light btn-sm">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Columna Derecha: Información Personal y Laboral/Adicional --}}
    <div class="col-md-8">
        <div class="card bg-dark text-white h-100 shadow-lg"> {{-- Añadir sombra --}}
            <div class="card-body pb-3"> {{-- Ajuste de padding inferior --}}
                <h5 class="card-title mb-3 border-bottom border-secondary pb-2">Información personal</h5>
                <div class="row gx-3 gy-2"> {{-- g-x y g-y para gap entre filas y columnas --}}
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-id-card me-2"></i><strong>Identidad:</strong> {{ $empleado->identidad }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-venus-mars me-2"></i><strong>Sexo:</strong> {{ $empleado->sexo }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-envelope me-2"></i><strong>Correo:</strong> {{ $empleado->correo }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-phone me-2"></i><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-map-marker-alt me-2"></i><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
                    </div>
                </div>

                <h5 class="card-title mt-4 mb-3 border-bottom border-secondary pb-2">Información laboral y adicional</h5>
                <div class="row gx-3 gy-2">
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-briefcase me-2"></i><strong>Puesto:</strong> {{ $empleado->puesto }}</p>
                        <p class="mb-2 text-wrap"><i class="fas fa-calendar-alt me-2"></i><strong>Fecha contratación:</strong> {{ $empleado->fecha_contratacion }}</p>
                        {{-- **FOCUS DE LA CORRECCIÓN:** Aplicar clase para tamaño de fuente más pequeño --}}
                        <p class="mb-2 text-wrap info-fecha"><i class="fas fa-calendar-plus me-2"></i><strong>Registro:</strong> {{ $empleado->created_at ? $empleado->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2 text-wrap"><i class="fas fa-money-bill-wave me-2"></i><strong>Salario:</strong> L. {{ number_format($empleado->salario, 2, '.', ',') }}</p>
                        {{-- **FOCUS DE LA CORRECCIÓN:** Aplicar clase para tamaño de fuente más pequeño --}}
                        <p class="mb-2 text-wrap info-fecha"><i class="fas fa-calendar-check me-2"></i><strong>Última actualización:</strong> {{ $empleado->updated_at ? $empleado->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Asegúrate de que Font Awesome esté cargado en tu layout principal (layouts.app) */
    /* Ejemplo de cómo incluirlo si no está: */
    /* <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" xintegrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" /> */

    body {
        background-color: #1a1a1a; /* Un fondo ligeramente diferente para más contraste */
        color: #e0e0e0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .card {
        background-color: #2b2b2b; /* Fondo de tarjeta más oscuro */
        border: 1px solid #444; /* Borde sutil */
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); /* Sombra más definida */
    }

    .avatar-container {
        width: 100px; /* Tamaño más compacto */
        height: 100px;
        margin: 0 auto 1.5rem; /* Margen inferior más claro */
        background-color: rgba(255, 255, 255, 0.08); /* Color más oscuro */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 3px solid rgba(255, 255, 255, 0.15); /* Borde más sutil */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Sombra para el avatar */
    }
    .avatar-container:hover {
        transform: scale(1.08); /* Efecto hover un poco más notorio */
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
    }
    .avatar-container .fas {
        font-size: 3.5em !important; /* Ajuste para el icono */
    }

    .empleado-status {
        display: inline-block;
        padding: 5px 15px; /* Padding ajustado */
        border-radius: 25px; /* Más redondeado */
        font-size: 0.9rem; /* Fuente un poco más grande */
        font-weight: 600; /* Más audaz */
        text-transform: uppercase; /* Mayúsculas para el estado */
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
        font-size: 1.25rem; /* Tamaño de título estándar */
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    /* Asegurar que el texto largo no se corte - Propiedades principales */
    p {
        margin-bottom: 0.75rem; /* Espaciado estándar entre párrafos */
        font-size: 0.95rem; /* Fuente ligeramente más pequeña para texto de detalles */
        line-height: 1.5; /* Altura de línea para mejor legibilidad */
        white-space: normal; /* Asegura que el texto no se mantenga en una sola línea */
        word-wrap: break-word; /* Rompe palabras largas que desborden */
        overflow-wrap: break-word; /* Moderno para word-wrap */
    }

    /* **NUEVA REGLA:** Reducir tamaño de fuente específicamente para fechas de registro/actualización */
    .info-fecha {
        font-size: 0.85rem; /* Más pequeño para que quepa en una sola línea */
        white-space: nowrap; /* Intenta forzar a una sola línea */
        overflow: hidden; /* Oculta cualquier texto que se desborde */
        text-overflow: ellipsis; /* Añade puntos suspensivos si se desborda */
        /* Nota: 'text-wrap' se elimina en el HTML para estos elementos si queremos 'nowrap' */
    }

    /* Asegurarse de que el strong dentro de info-fecha también se ajuste */
    .info-fecha strong {
        font-size: 0.85rem; /* Para que el strong no sea más grande que el texto del valor */
    }

    p strong {
        color: #b0b0b0; /* Un color ligeramente más claro para las etiquetas */
    }

    .fas {
        width: 20px; /* Asegurar que los iconos tengan un ancho fijo */
        text-align: center;
        color: #0d6efd; /* Color por defecto para los iconos de información */
    }

    /* Estilos de botones más consistentes con el tema oscuro */
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529; /* Texto oscuro para el botón de advertencia */
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

    /* Pequeño ajuste para móviles si las columnas se vuelven demasiado estrechas */
    @media (max-width: 767.98px) {
        .avatar-container {
            margin-bottom: 1rem; /* Menos espacio en móviles */
        }
        .card-body {
            padding: 1.5rem; /* Menos padding en móviles */
        }
        .card-title {
            font-size: 1.1rem;
        }
        p {
            font-size: 0.88rem; /* Fuente un poco más pequeña para detalles en móviles */
        }
        /* Ajuste específico para las fechas en móviles si aún se cortan */
        .info-fecha {
            font-size: 0.8rem; /* Aún más pequeño en móviles si es necesario */
        }
    }
</style>
@endsection
