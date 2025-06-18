<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de empleados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
        }
        .table-container {
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }
        th {
            background-color: #2e2e2e;
            color: #ccc;
        }
        tr:nth-child(even) {
            background-color: #2a2a2a;
        }
        tr:hover {
            background-color: #333;
        }
        .alert {
            margin-bottom: 1rem;
            border: none;
            border-radius: 8px;
        }
        .alert-success {
            background-color: #28a745;
            color: #fff;
        }
        .alert-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .alert-info {
            background-color: #17a2b8;
            color: #fff;
        }
        .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Estilos para la paginación personalizada (Copiar y pegar desde el archivo de proveedores) */
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
</head>
<body>
<div class="container py-5">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Lista de empleados</h2>
            <span class="text-muted">Total: <strong>{{ $empleados->total() }}</strong></span>
        </div>

        {{-- Mensajes de éxito y error --}}
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

        <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">+ Nuevo empleado</a>

        <form action="{{ route('empleados.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar empleado por Nombre, Apellido o Identidad" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Identidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($empleados as $empleado)
                        <tr>
                            <td>{{ $loop->iteration + ($empleados->currentPage() - 1) * $empleados->perPage() }}</td>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->apellido }}</td>
                            <td>{{ $empleado->identidad }}</td>
                            <td>
                                <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-info btn-sm">Ver mas</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay empleados registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación personalizada (¡IMPORTANTE: usa la vista 'vendor.pagination.bootstrap-5'!) --}}
        <div class="d-flex justify-content-center mt-4 mb-4">
            {{ $empleados->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>

        <a href="{{ route('welcome') }}" class="btn btn-outline-light mt-3">Inicio</a>
    </div>
</div>
</body>
</html>