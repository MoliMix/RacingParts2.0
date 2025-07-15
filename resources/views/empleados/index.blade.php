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
        <form action="{{ route('clientes.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar cliente por nombre o teléfono" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Número de Identidad</th>
                        <th>Número de Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección de Envío</th>
                        <th>Tipo de Vehículo</th>
                        <th>Historial de Compras</th>
                        <th>Método de Pago</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($empleados as $empleado)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <a href="{{ route('clientes.show', $empleado->id) }}" class="text-white text-decoration-none">
                                    {{ $empleado->nombre_completo ?? $empleado->nombre }}
                                </a>
                            </td>
                            <td class="align-middle">{{ $empleado->numero_id ?? $empleado->numero_id }}</td>
                            <td class="align-middle">{{ $empleado->numero_telefono ?? $empleado->telefono }}</td>
                            <td class="align-middle">{{ $empleado->correo_electronico ?? $empleado->email }}</td>
                            <td class="align-middle">{{ $empleadoente->direccion_envio ?? $empleado->direccion }}</td>
                            <td class="align-middle">{{ $empleado->tipo_vehiculo }}</td>
                            <td class="align-middle">{{ $empleado->historial_compras }}</td>
                            <td class="align-middle">{{ $empleado->metodo_pago_preferido ?? $empleado->metodo_pago }}</td>
                            <td class="align-middle">{{ $empleado->fecha_registro }}</td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('clientes.show', $empleado->id) }}" class="btn btn-info btn-sm" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $empleado->id) }}" class="btn btn-warning btn-sm" title="Editar Cliente">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{$empleado->id}}" title="Eliminar Cliente">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="modalEliminar{{$empleado->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$empleado->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-dark" id="deleteModalLabel{{$empleado->id}}">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-dark">
                                                    ¿Estás seguro de que deseas eliminar a **{{ $empleado->nombre_completo ?? $empleado->nombre }}**? Esta acción no se puede deshacer.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('clientes.destroy', $empleado->id) }}" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-white py-4">No hay clientes registrados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (isset($empleado) && method_exists($empleado, 'links'))
            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $empleado->withQueryString()->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif

        <div class="d-flex gap-2 align-items-center mt-3 mb-4">
            <a href="{{ route('clientes.menu') }}" class="btn btn-outline-light">Inicio</a>
            <button type="button" class="btn btn-outline-light" onclick="window.history.back();">Volver</button>
        </div>
    </div>
@endsection
