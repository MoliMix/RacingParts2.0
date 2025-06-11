
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<body>
<div class="container py-5">
    <div class="table-container">
        <h2 class="mb-4">Lista de Empleados</h2>

        <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">+ Nuevo Empleado</a>

        <!-- Búsqueda -->
        <form action="{{ route('empleados.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar empleado..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Identidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($empleados as $empleado)
                        <tr>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->apellido }}</td>
                            <td>{{ $empleado->identidad }}</td>
                            <td>
                                <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-info btn-sm">Ver mas</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay empleados registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $empleados->withQueryString()->links() }}

        <a href="{{ route('welcome') }}" class="btn btn-outline-light mt-3">Inicio</a>
    </div>
</div>
</body>
</html>