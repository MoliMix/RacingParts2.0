<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Proveedores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #121212; /* Fondo oscuro */
            color: #f1f1f1; /* Texto claro */
            padding: 20px; /* Espacio alrededor del contenido */
        }

        h2, h3 {
            color: #e0e0e0;
        }

        .alert {
            margin-top: 15px;
        }

        .btn-primary {
            background-color: #4caf50; /* Verde principal */
            border-color: #4caf50;
        }
        .btn-primary:hover {
            background-color: #43a047;
            border-color: #43a047;
        }

        .btn-info {
            background-color: #2196f3; /* Azul para "Ver más" */
            border-color: #2196f3;
        }
        .btn-info:hover {
            background-color: #1976d2;
            border-color: #1976d2;
        }

        .btn-warning {
            background-color: #ffc107; /* Amarillo para "Editar" */
            border-color: #ffc107;
            color: #212529; /* Texto oscuro para el botón amarillo */
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .btn-outline-light {
            color: #f8f9fa;
            border-color: #f8f9fa;
        }
        .btn-outline-light:hover {
            background-color: #f8f9fa;
            color: #212529;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #f1f1f1;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .table-container {
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }

        .table-dark {
            --bs-table-bg: #212121;
            --bs-table-striped-bg: #2c2c2c;
            --bs-table-hover-bg: #3a3a3a;
            --bs-table-color: #f1f1f1;
            border-color: #444;
        }
        .table thead th {
            border-bottom: 2px solid #555;
            color: #e0e0e0;
        }
        .table tbody td {
            border-top: 1px solid #333;
            padding: 0.75rem;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* ESTILOS MODIFICADOS PARA EL INPUT DE BÚSQUEDA */
        .search-input::placeholder {
            color: #6c757d !important; /* Color más oscuro para el placeholder en fondo blanco */
            opacity: 0.8;
        }
        .search-input {
            background-color: #ffffff !important; /* Fondo blanco */
            color: #212529 !important; /* Texto oscuro */
            border-color: #ced4da !important; /* Borde claro */
        }
        .search-input:focus {
            background-color: #ffffff !important; /* Fondo blanco al enfocar */
            color: #212529 !important; /* Texto oscuro al enfocar */
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        .pagination {
            --bs-pagination-color: #f1f1f1;
            --bs-pagination-bg: #343a40;
            --bs-pagination-border-color: #495057;
            --bs-pagination-hover-color: #ffffff;
            --bs-pagination-hover-bg: #495057;
            --bs-pagination-hover-border-color: #495057;
            --bs-pagination-focus-shadow: none;
            --bs-pagination-active-color: #ffffff;
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
            --bs-pagination-disabled-color: #6c757d;
            --bs-pagination-disabled-bg: #343a40;
            --bs-pagination-disabled-border-color: #495057;
        }

        .page-item .page-link {
            border-radius: 0.25rem;
            margin: 0 2px;
            transition: all 0.2s ease-in-out;
        }
        .page-item .page-link:hover {
            transform: translateY(-1px);
        }
        .page-item.active .page-link {
            font-weight: bold;
        }
        .page-item.disabled .page-link {
            cursor: not-allowed;
            opacity: 0.7;
        }

        .text-pagination-summary {
            color: #ced4da;
            font-size: 0.95rem;
            align-self: center;
            margin: 0 15px;
            font-weight: 400;
        }
        /* Ajuste de tamaño de fuente para los botones sm */
        .btn-sm {
            padding: .25rem .5rem;
            font-size: .7rem; /* Tamaño de fuente más pequeño para los botones */
            border-radius: .2rem;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Lista de Proveedores</h2>
            <span class="text-pagination-summary">Total: <strong>{{ $proveedores->total() }}</strong></span>
        </div>

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

        <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">+ Nuevo Proveedor</a>

        <form action="{{ route('proveedores.index') }}" method="GET" class="mb-3" id="searchForm">
            <div class="input-group">
                <input type="text" name="search" id="searchInput" class="form-control search-input" placeholder="Buscar por empresa, país o teléfono" value="{{ request('search') }}" list="providerSuggestions">
                <datalist id="providerSuggestions"></datalist>
                <button type="submit" class="btn btn-primary">Buscar</button>
                <button type="button" class="btn btn-secondary" id="clearSearchBtn" style="{{ request('search') ? 'display: block;' : 'display: none;' }}">Limpiar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Empresa</th>
                        <th>País</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $loop->iteration + ($proveedores->currentPage() - 1) * $proveedores->perPage() }}</td>
                            <td>{{ $proveedor->nombre_empresa }}</td>
                            <td>{{ $proveedor->pais_origen }}</td>
                            <td>{{ $proveedor->telefono_contacto }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('proveedores.show', $proveedor->id) }}" class="btn btn-info btn-sm">Ver más</a>
                                    <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay proveedores registrados que coincidan con la búsqueda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4 mb-4">
            {{ $proveedores->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>

        <a href="{{ url('/') }}" class="btn btn-outline-light mt-3">Inicio</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const providerSuggestions = document.getElementById('providerSuggestions');
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        const searchForm = document.getElementById('searchForm');

        let debounceTimeout;

        // Mostrar/ocultar botón "Limpiar" al cargar la página si hay texto en el input
        if (searchInput.value.trim() !== '') {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
        }

        // Manejador para el botón "Limpiar"
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearSearchBtn.style.display = 'none';
            searchForm.submit(); // Envía el formulario para recargar sin búsqueda
        });

        // Manejador para el input de búsqueda (autocompletado)
        searchInput.addEventListener('input', function() {
            // Mostrar/ocultar botón "Limpiar" mientras se escribe
            if (this.value.trim() !== '') {
                clearSearchBtn.style.display = 'block';
            } else {
                clearSearchBtn.style.display = 'none';
            }

            clearTimeout(debounceTimeout); // Limpiar el timeout anterior
            debounceTimeout = setTimeout(() => {
                const query = this.value.trim();

                // Solo hacer la petición si la consulta tiene al menos 2 caracteres
                if (query.length > 1) {
                    fetch(`/proveedores/autocomplete?query=${encodeURIComponent(query)}`)
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            providerSuggestions.innerHTML = ''; // Limpiar sugerencias anteriores
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item;
                                    providerSuggestions.appendChild(option);
                                });
                            }
                        })
                        .catch(error => console.error('Error al obtener datos de autocompletado de proveedores:', error));
                } else {
                    providerSuggestions.innerHTML = ''; // Limpiar sugerencias si la consulta es muy corta
                }
            }, 300); // Retraso de 300ms (debounce) para evitar muchas peticiones
        });

        // NUEVO: Manejador para detectar cuándo se selecciona una sugerencia y enviar el formulario
        searchInput.addEventListener('change', function() {
            // Este evento 'change' se dispara cuando el usuario selecciona una opción de la datalist
            // o cuando el valor del input cambia y el foco sale.
            // Si el valor del input coincide con una opción del datalist, se considera una selección.
            
            // Un pequeño retraso asegura que el valor del input se haya actualizado
            // después de la selección del datalist.
            setTimeout(() => {
                const selectedValue = this.value;
                const options = Array.from(providerSuggestions.options).map(option => option.value);

                if (options.includes(selectedValue)) {
                    // Si el valor actual del input es una de las sugerencias,
                    // significa que el usuario seleccionó una.
                    searchForm.submit(); // Envía el formulario para buscar
                }
            }, 0); // Retraso mínimo
        });
    });
</script>
</body>
</html>