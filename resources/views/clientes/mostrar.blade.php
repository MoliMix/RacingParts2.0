@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <div class="container py-4"> {{-- Added a container for overall padding and centering --}}
        <div class="row g-3"> {{-- Gap between columns in Bootstrap 5 --}}

            {{-- Columna Izquierda: Resumen del Cliente y Botones --}}
            <div class="col-md-4">
                <div class="card bg-dark text-white h-100 shadow-lg border-0"> {{-- Removed default border --}}
                    <div class="card-body text-center d-flex flex-column pb-3">
                        <div class="avatar-container mb-3">
                            {{-- Dynamic Sex Icon --}}
                            <i
                                class="fas {{ $cliente->sexo === 'Masculino' ? 'fa-male' : 'fa-female' }} fa-4x {{ $cliente->sexo === 'Masculino' ? 'text-primary' : 'text-danger' }}"></i>
                        </div>
                        <h4 class="card-title mb-2">{{ $cliente->nombre_completo }}</h4>
                        {{-- Removed {{ $clientes->puesto }} as it's not in your clientes schema --}}
                        {{-- Consider adding a default placeholder or removing if not applicable to client --}}
                        {{-- <p class="text-muted mb-3 text-wrap">Cliente Registrado</p> --}}
                        {{-- The 'estado' field is also not in your clientes schema. Remove or add if client status is
                        managed. --}}
                        {{-- <div
                            class="empleado-status {{ $clientes->estado === 'Activo' ? 'status-activo' : 'status-inactivo' }} mb-4">
                            {{ $clientes->estado }}
                        </div> --}}

                        <div class="d-flex justify-content-center gap-2 mt-auto pt-2">
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-light btn-sm">Volver a la
                                lista</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-8">
                <div class="card bg-dark text-white h-100 shadow-lg border-0">
                    <div class="card-body pb-3">
                        <h5 class="card-title mb-3 border-bottom border-secondary pb-2">Información del Cliente</h5>
                        <div class="row gx-3 gy-2">


                            <div class="col-12">
                                <p class="mb-2 text-wrap">
                                    <i class="fas fa-user-circle me-2"></i><strong>Nombre Completo:</strong>
                                    {{ $cliente->nombre_completo }}
                                </p>
                            </div>

                            {{-- ID Number --}}
                            <div class="col-md-6">
                                <p class="mb-2 text-wrap">
                                    <i class="fas fa-id-card me-2"></i><strong>Número de Identidad:</strong>
                                    {{ $cliente->numero_id }}
                                </p>
                            </div>

                            {{-- Phone Number --}}
                            <div class="col-md-6">
                                <p class="mb-2 text-wrap">
                                    <i class="fas fa-phone me-2"></i><strong>Número de Teléfono:</strong>
                                    {{ $cliente->numero_telefono }}
                                </p>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <p class="mb-2 text-wrap">
                                    <i class="fas fa-envelope me-2"></i><strong>Correo Electrónico:</strong>
                                    {{ $cliente->correo_electronico }}
                                </p>
                            </div>

                            {{-- Address --}}
                            <div class="col-md-6"> {{-- Moved Address to its own col-md-6 --}}
                                <p class="mb-2 text-wrap">
                                    <i class="fas fa-map-marker-alt me-2"></i><strong>Dirección del Cliente:</strong>
                                    {{ $cliente->direccion_cliente }}
                                </p>
                            </div>

    <div class="col-md-6"> {{-- Moved Address to its own col-md-6 --}}
        <p class="mb-2 text-wrap">
         <i class="fas fa-map-marker-alt me-2"></i><strong>Dirección del Cliente:</strong>
             {{ $cliente->direccion_cliente }}
               </p>
               <p class="mb-2 text-wrap">
        <i class="fas fa-calendar-alt me-2"></i><strong>Fecha de Ingreso:</strong>
        {{ $cliente->fecha_ingreso ? $cliente->fecha_ingreso->format('d/m/Y') : 'No disponible' }}
      </p>
    </div>

    <div class="col-md-6">
    <p class="mb-2 text-wrap">
        <i class="fas fa-calendar-alt me-2"></i><strong>Fecha de Ingreso:</strong>
        {{ $cliente->fecha_ingreso ? $cliente->fecha_ingreso->format('d/m/Y') : 'No disponible' }}
    </p>
</div>



                            {{-- Sex --}}
                            <div class="col-md-6">
                                <p class="mb-2 text-wrap">
                                    {{-- Icon for Sex (Optional here, as you have it prominently on the left) --}}
                                    <i class="fas fa-venus-mars me-2"></i><strong>Sexo:</strong>
                                    {{ $cliente->sexo }}
                                </p>
                            </div>

                            {{-- You might want to add other client-specific information here --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #1a1a1a;
            color: #e0e0e0;
            min-height: 100vh;
            padding: 2rem;
        }

        .card {
            background-color: #2b2b2b;
            border: 1px solid #444;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .avatar-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 3px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .avatar-container:hover {
            transform: scale(1.08);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
        }

        /* Removed .empleado-status, status-activo, status-inactivo as 'estado' is not in client schema */
        /* If you add a 'status' field for clients, you can re-introduce these styles. */

        .card-title {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            line-height: 1.5;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        p strong {
            color: #b0b0b0;
        }

        .fas {
            width: 20px;
            text-align: center;
            color: #0d6efd;
            /* Default icon color */
        }

        /* Specific icon colors if you want them different from default .fas color */
        .text-primary {
            color: #0d6efd !important;
            /* Bootstrap primary blue */
        }

        .text-danger {
            color: #dc3545 !important;
            /* Bootstrap danger red */
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
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