<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de empleados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

        /* Estilos MEJORADOS para la paginación */
        .pagination-custom {
            display: flex;
            padding-left: 0;
            list-style: none; /* Elimina viñetas de lista */
            border-radius: 0.5rem; /* Bordes más redondeados para el contenedor */
            box-shadow: 0 4px 15px rgba(0,0,0,0.4); /* Sombra para resaltar */
            background-color: #2c2c2c; /* Fondo para el contenedor de paginación */
            padding: 8px; /* Espaciado interno */
        }

        .pagination-custom li {
            margin: 0 3px; /* Espacio entre los elementos de paginación */
        }

        .page-link-custom {
            position: relative;
            display: flex; /* Usar flexbox para centrar contenido */
            align-items: center; /* Centrar verticalmente */
            justify-content: center; /* Centrar horizontalmente */
            min-width: 40px; /* Ancho mínimo para todos los botones */
            height: 40px; /* Altura fija para todos los botones */
            font-weight: 600; /* Texto más audaz */
            font-size: 1rem; /* Tamaño de fuente ligeramente más grande */
            color: #0d6efd; /* Color del texto por defecto */
            background-color: #3a3a3a; /* Fondo de los botones */
            border: 1px solid #454d55; /* Borde sutil */
            border-radius: 0.35rem; /* Bordes redondeados */
            text-decoration: none;
            transition: all 0.25s ease; /* Transición suave para hover */
        }

        .page-link-custom:hover:not(.disabled) {
            color: #ffffff;
            background-color: #0d6efd; /* Color principal de Bootstrap para hover */
            border-color: #0d6efd;
            transform: translateY(-2px); /* Pequeño efecto de elevación */
            box-shadow: 0 6px 12px rgba(13, 110, 253, 0.3); /* Sombra más pronunciada al pasar el ratón */
        }

        .page-link-custom.active,
        .pagination-custom li.active .page-link-custom {
            color: #ffffff;
            background-color: #0d6efd; /* Fondo azul para la página activa */
            border-color: #0d6efd;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4); /* Sombra para la página activa */
            transform: none; /* Sin elevación para la activa */
        }

        .pagination-custom li.disabled .page-link-custom {
            color: #6c757d; /* Color más claro para deshabilitado */
            background-color: #3a3a3a;
            border-color: #454d55;
            cursor: not-allowed;
            opacity: 0.5; /* Más transparente */
            transform: none;
            box-shadow: none;
        }

        /* Estilos para el texto de resumen de paginación */
        .text-pagination-summary {
            color: #ced4da !important;
            font-size: 0.95rem; /* Tamaño de fuente legible */
            align-self: center;
            margin: 0 15px; /* Espacio alrededor del texto */
            font-weight: 400;
        }

        /* Estilo para los botones de paginación en móviles */
        .btn-dark-outline {
            color: #ced4da;
            border-color: #495057;
            background-color: #343a40;
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            transition: all 0.25s ease;
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
        /* Estilos para el botón de limpiar */
        #clearSearchBtn {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        #clearSearchBtn:hover {
            background-color: #5a6268;
            border-color: #545b62;
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

        <form action="{{ route('empleados.index') }}" method="GET" class="mb-3" id="searchForm">
            <div class="input-group">
                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Buscar empleado por nombre, apellido o identidad" value="{{ request('search') }}" list="employeeSuggestions">
                <datalist id="employeeSuggestions"></datalist>
                <button type="submit" class="btn btn-primary">Buscar</button>
                <button type="button" class="btn btn-secondary" id="clearSearchBtn" style="{{ request('search') ? 'display: block;' : 'display: none;' }}">Limpiar</button>
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
                                <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-info btn-sm me-1">Ver más</a>
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay empleados registrados que coincidan con la búsqueda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación personalizada (¡IMPORTANTE: Asegúrate de tener la vista 'vendor.pagination.bootstrap-5' actualizada!) --}}
        <div class="d-flex justify-content-center mt-4 mb-4">
            {{ $empleados->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>

        <a href="{{ route('welcome') }}" class="btn btn-outline-light mt-3">Inicio</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const employeeSuggestions = document.getElementById('employeeSuggestions');
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        const searchForm = document.getElementById('searchForm');

        let debounceTimeout;

        // Función para limpiar la búsqueda
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = ''; // Limpiar el input
            searchForm.submit(); // Enviar el formulario para recargar la página sin búsqueda
        });

        // Mostrar/ocultar el botón de limpiar basado en si hay texto en el input
        searchInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                clearSearchBtn.style.display = 'block';
            } else {
                clearSearchBtn.style.display = 'none';
            }

            // Lógica de autocompletado
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                const query = this.value.trim();
                console.log('Query para autocompletar:', query); // DEBUG: Muestra la consulta
                if (query.length > 1) { // Mínimo 2 caracteres para autocompletar
                    fetch(`/empleados/autocomplete?query=${encodeURIComponent(query)}`)
                        .then(response => {
                            console.log('Response status:', response.status); // DEBUG: Muestra el estado de la respuesta
                            if (!response.ok) {
                                // Intenta leer el cuerpo del error si la respuesta no es OK
                                return response.text().then(text => {
                                    throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Datos de autocompletado recibidos:', data); // DEBUG: Muestra los datos recibidos
                            employeeSuggestions.innerHTML = ''; // Limpiar sugerencias anteriores
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item;
                                    employeeSuggestions.appendChild(option);
                                });
                            } else {
                                console.log('No se encontraron sugerencias.');
                            }
                        })
                        .catch(error => console.error('Error al obtener datos de autocompletado:', error)); // DEBUG: Muestra cualquier error de fetch
                } else {
                    employeeSuggestions.innerHTML = ''; // Limpiar si el query es muy corto
                    console.log('Consulta muy corta para autocompletar.');
                }
            }, 300); // Debounce de 300ms
        });

        // Inicializar el estado del botón de limpiar al cargar la página
        if (searchInput.value.trim() !== '') {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
        }
    });
</script>
</body>
</html>
