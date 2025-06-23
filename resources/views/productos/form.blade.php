<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
        }

        .form-container {
            background-color: #1e1e1e;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }

        .form-label {
            color: #ccc;
        }

        .form-control {
            background-color: #2c2c2c;
            border: none;
            color: #fff;
        }

        .form-control:focus {
            background-color: #2c2c2c;
            color: #fff;
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-primary {
            background-color: #4caf50;
            border: none;
        }

        .btn-primary:hover {
            background-color: #43a047;
        }

        h2 {
            color: #e0e0e0;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <h2 class="mb-4">Registrar producto</h2>

                {{-- Mensajes de éxito y error --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="formProducto" action="{{ route('productos.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="20" />
                            <div class="invalid-feedback" id="nombre-feedback">
                                El nombre solo puede contener letras y espacios, y debe tener un máximo de 20 caracteres.
                            </div>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" required maxlength="100">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="marca" class="form-label">Marca:</label>
                            <select class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" required>
                                <option value="">Seleccione una marca...</option>
                                <option value="Toyota" {{ old('marca') == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                <option value="Honda" {{ old('marca') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                <option value="Ford" {{ old('marca') == 'Ford' ? 'selected' : '' }}>Ford</option>
                                <option value="Chevrolet" {{ old('marca') == 'Chevrolet' ? 'selected' : '' }}>Chevrolet</option>
                                <option value="Nissan" {{ old('marca') == 'Nissan' ? 'selected' : '' }}>Nissan</option>
                                <option value="Volkswagen" {{ old('marca') == 'Volkswagen' ? 'selected' : '' }}>Volkswagen</option>
                                <option value="Hyundai" {{ old('marca') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                <option value="Mazda" {{ old('marca') == 'Mazda' ? 'selected' : '' }}>Mazda</option>
                                <option value="Kia" {{ old('marca') == 'Kia' ? 'selected' : '' }}>Kia</option>
                            </select>
                            <div class="invalid-feedback">Por favor, seleccione una marca.</div>
                            @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="modelo" class="form-label">Modelo:</label>
                            <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{ old('modelo') }}" required maxlength="20" />
                            <div class="invalid-feedback" id="modelo-feedback">
                                El modelo solo puede contener letras y números, máximo 20 caracteres.
                            </div>
                            @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="anio" class="form-label">Año:</label>
                            <input type="number" class="form-control @error('anio') is-invalid @enderror" id="anio" name="anio" value="{{ old('anio') }}" required min="1990" max="{{ date('Y') }}" />
                            <div class="invalid-feedback" id="anio-feedback">
                                El año debe ser entre 1990 y {{ date('Y') }}.
                            </div>
                            @error('anio')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ old('precio') }}" required min="0.01" max="99999" />
                            <div class="invalid-feedback" id="precio-feedback">
                                El precio debe ser un número positivo y no mayor a 99999.
                            </div>
                            @error('precio')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="stock" class="form-label">Stock:</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required min="0" />
                            <div class="invalid-feedback" id="stock-feedback">
                                El stock debe ser un número entero igual o mayor que cero.
                            </div>
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="categoria" class="form-label">Categoría:</label>
                            <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="">Seleccione una categoría...</option>
                                <option value="Motor" {{ old('categoria') == 'Motor' ? 'selected' : '' }}>Motor</option>
                                <option value="Frenos" {{ old('categoria') == 'Frenos' ? 'selected' : '' }}>Frenos</option>
                                <option value="Suspensión" {{ old('categoria') == 'Suspensión' ? 'selected' : '' }}>Suspensión</option>
                                <option value="Eléctrico" {{ old('categoria') == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                                <option value="Accesorios" {{ old('categoria') == 'Accesorios' ? 'selected' : '' }}>Accesorios</option>
                            </select>
                            <div class="invalid-feedback">Por favor, seleccione una categoría.</div>
                            @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-light ms-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formProducto');

        form.addEventListener('submit', function(event) {
            let formIsValid = true;

            // Limpiar clases y mensajes previos
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Validaciones

            // Nombre
            const nombre = document.getElementById('nombre');
            const regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,20}$/;
            if (!regexNombre.test(nombre.value.trim())) {
                nombre.classList.add('is-invalid');
                formIsValid = false;
            }

            // Descripción (no vacío y max 100)
            const descripcion = document.getElementById('descripcion');
            if (descripcion.value.trim() === '' || descripcion.value.length > 100) {
                descripcion.classList.add('is-invalid');
                formIsValid = false;
            }

            // Marca (select obligatorio)
            const marca = document.getElementById('marca');
            if (!marca.value) {
                marca.classList.add('is-invalid');
                formIsValid = false;
            }

            // Modelo (alfa num max 20)
            const modelo = document.getElementById('modelo');
            const regexModelo = /^[a-zA-Z0-9]{1,20}$/;
            if (!regexModelo.test(modelo.value.trim())) {
                modelo.classList.add('is-invalid');
                formIsValid = false;
            }

            // Año (1990 - actual)
            const anio = document.getElementById('anio');
            const anioVal = parseInt(anio.value, 10);
            const currentYear = new Date().getFullYear();
            if (isNaN(anioVal) || anioVal < 1990 || anioVal > currentYear) {
                anio.classList.add('is-invalid');
                formIsValid = false;
            }

            // Precio (positivo, max 99999)
            const precio = document.getElementById('precio');
            const precioVal = parseFloat(precio.value);
            if (isNaN(precioVal) || precioVal < 0.01 || precioVal > 99999) {
                precio.classList.add('is-invalid');
                formIsValid = false;
            }

            // Stock (entero >= 0)
            const stock = document.getElementById('stock');
            const stockVal = parseInt(stock.value, 10);
            if (isNaN(stockVal) || stockVal < 0) {
                stock.classList.add('is-invalid');
                formIsValid = false;
            }

            // Categoria (select obligatorio)
            const categoria = document.getElementById('categoria');
            if (!categoria.value) {
                categoria.classList.add('is-invalid');
                formIsValid = false;
            }

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        // Limpiar error cuando el usuario escribe o cambia selects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', () => {
                if(input.classList.contains('is-invalid')) {
                    input.classList.remove('is-invalid');
                }
            });
            if(input.tagName === 'SELECT') {
                input.addEventListener('change', () => {
                    if(input.classList.contains('is-invalid')) {
                        input.classList.remove('is-invalid');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
