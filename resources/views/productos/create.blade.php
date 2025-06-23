<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar un nuevo producto</title>
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

        .invalid-feedback {
            display: none;
            color: #f44336;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <h2 class="mb-4">Registrar un nuevo producto</h2>

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
                        {{-- Nombre --}}
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="20" />
                            <div class="invalid-feedback" id="nombre-feedback">
                                El nombre solo puede contener letras y espacios, y debe tener un máximo de 20 caracteres.
                            </div>
                            @error('nombre')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3 col-md-6">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required maxlength="100" />
                            <div class="invalid-feedback" id="descripcion-feedback">
                                La descripción debe tener máximo 100 caracteres.
                            </div>
                            @error('descripcion')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Marca --}}
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
                            <div class="invalid-feedback" id="marca-feedback">
                                Por favor, seleccione una marca.
                            </div>
                            @error('marca')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Modelo --}}
                        <div class="mb-3 col-md-6">
                            <label for="modelo" class="form-label">Modelo:</label>
                            <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{ old('modelo') }}" required maxlength="20" />
                            <div class="invalid-feedback" id="modelo-feedback">
                                El modelo debe tener máximo 20 caracteres y puede contener letras y números.
                            </div>
                            @error('modelo')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Año --}}
                        <div class="mb-3 col-md-6">
                            <label for="anio" class="form-label">Año:</label>
                            <input type="number" class="form-control @error('anio') is-invalid @enderror" id="anio" name="anio" value="{{ old('anio') }}" required min="1990" max="{{ date('Y') }}" maxlength="4" />
                            <div class="invalid-feedback" id="anio-feedback">
                                El año debe ser igual o mayor a 1990, no mayor al año actual .
                            </div>
                            @error('anio')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Precio --}}
                        <div class="mb-3 col-md-6">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="number" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ old('precio') }}" required max="99999" step="0.01" />
                            <div class="invalid-feedback" id="precio-feedback">
                                El precio debe ser un número positivo con máximo 5 dígitos antes del decimal.
                            </div>
                            @error('precio')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div class="mb-3 col-md-6">
                            <label for="stock" class="form-label">Stock:</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required min="0" max="999" />
                            <div class="invalid-feedback" id="stock-feedback">
                                El stock debe ser un número entero positivo y tener máximo 3 dígitos.
                            </div>
                            @error('stock')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="mb-3 col-md-6">
                            <label for="categoria" class="form-label">Categoría:</label>
                            <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="">Seleccione...</option>
                                <option value="Motor" {{ old('categoria') == 'Motor' ? 'selected' : '' }}>Motor</option>
                                <option value="Frenos" {{ old('categoria') == 'Frenos' ? 'selected' : '' }}>Frenos</option>
                                <option value="Suspensión" {{ old('categoria') == 'Suspensión' ? 'selected' : '' }}>Suspensión</option>
                                <option value="Eléctrico" {{ old('categoria') == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                                <option value="Accesorios" {{ old('categoria') == 'Accesorios' ? 'selected' : '' }}>Accesorios</option>
                            </select>
                            <div class="invalid-feedback" id="categoria-feedback">
                                Por favor, seleccione una categoría.
                            </div>
                            @error('categoria')
                            <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="reset" class="btn btn-outline-light">Limpiar</button>
                        <button type="button" class="btn btn-outline-light" onclick="window.history.back();">Volver</button>
                    </div>
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

            // Limpiar errores previos
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

            // Validaciones

            // Nombre
            const nombreInput = document.getElementById('nombre');
            const nombre = nombreInput.value.trim();
            const regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
            if (nombre.length === 0 || nombre.length > 20 || !regexNombre.test(nombre)) {
                nombreInput.classList.add('is-invalid');
                document.getElementById('nombre-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Descripción
            const descripcionInput = document.getElementById('descripcion');
            const descripcion = descripcionInput.value.trim();
            if (descripcion.length === 0 || descripcion.length > 100) {
                descripcionInput.classList.add('is-invalid');
                document.getElementById('descripcion-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Marca
            const marcaInput = document.getElementById('marca');
            if (!marcaInput.value) {
                marcaInput.classList.add('is-invalid');
                document.getElementById('marca-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Modelo
            const modeloInput = document.getElementById('modelo');
            const modelo = modeloInput.value.trim();
            const regexModelo = /^[a-zA-Z0-9]+$/;
            if (modelo.length === 0 || modelo.length > 20 || !regexModelo.test(modelo)) {
                modeloInput.classList.add('is-invalid');
                document.getElementById('modelo-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Año
            const anioInput = document.getElementById('anio');
            const anio = anioInput.value.trim();
            const anioNum = parseInt(anio, 10);
            const anioActual = new Date().getFullYear();
            if (!anio || isNaN(anioNum) || anioNum < 1990 || anioNum > anioActual) {
                anioInput.classList.add('is-invalid');
                document.getElementById('anio-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Precio
            const precioInput = document.getElementById('precio');
            const precioStr = precioInput.value.trim();
            const precio = parseFloat(precioStr);
            const parteEntera = precioStr.split('.')[0];
            if (isNaN(precio) || precio <= 0 || parteEntera.length > 5) {
                precioInput.classList.add('is-invalid');
                document.getElementById('precio-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Stock
            const stockInput = document.getElementById('stock');
            const stockStr = stockInput.value.trim();
            const stock = parseInt(stockStr, 10);
            const regexStock = /^\d{1,3}$/;
            if (!regexStock.test(stockStr) || isNaN(stock) || stock < 0) {
                stockInput.classList.add('is-invalid');
                document.getElementById('stock-feedback').style.display = 'block';
                formIsValid = false;
            }

            // Categoría
            const categoriaInput = document.getElementById('categoria');
            if (!categoriaInput.value) {
                categoriaInput.classList.add('is-invalid');
                document.getElementById('categoria-feedback').style.display = 'block';
                formIsValid = false;
            }

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        // Limpieza de validación al modificar inputs
        ['nombre', 'descripcion', 'marca', 'modelo', 'anio', 'precio', 'stock', 'categoria'].forEach(id => {
            const el = document.getElementById(id);
            el.addEventListener('input', () => {
                if(el.classList.contains('is-invalid')) {
                    el.classList.remove('is-invalid');
                    const feedback = document.getElementById(id + '-feedback');
                    if(feedback) feedback.style.display = 'none';
                }
            });
            if(el.tagName === 'SELECT') {
                el.addEventListener('change', () => {
                    if(el.classList.contains('is-invalid')) {
                        el.classList.remove('is-invalid');
                        const feedback = document.getElementById(id + '-feedback');
                        if(feedback) feedback.style.display = 'none';
                    }
                });
            }
        });

        document.getElementById('anio').addEventListener('input', e => {
            let val = e.target.value.replace(/\D/g, '');
            val = val.replace(/^0+/, ''); // quitar ceros iniciales
            if(val.length > 4) val = val.slice(0, 4);
            e.target.value = val;
        });

// Stock - sin ceros al inicio y máximo 3 dígitos
        document.getElementById('stock').addEventListener('input', e => {
            let val = e.target.value.replace(/\D/g, '');
            val = val.replace(/^0+/, '');
            if(val.length > 3) val = val.slice(0, 3);
            e.target.value = val;
        });

        // Limitar Precio máximo 5 dígitos enteros, permite decimal con 2 cifras
        document.getElementById('precio').addEventListener('input', e => {
            let val = e.target.value;
            val = val.replace(/[^0-9.]/g, '');

            let partes = val.split('.');
            if(partes[0].length > 5) partes[0] = partes[0].slice(0, 5);

            if(partes.length > 2) {
                val = partes[0] + '.' + partes.slice(1).join('');
            } else {
                val = partes.join('.');
            }

            e.target.value = val;
        });

        // Eliminar espacios al inicio para campos de texto
        ['nombre', 'descripcion', 'modelo'].forEach(id => {
            const el = document.getElementById(id);
            el.addEventListener('input', () => {
                el.value = el.value.replace(/^\s+/, '');
            });
        });

        // Bloquear números al inicio en nombre, descripción y modelo
        ['nombre', 'descripcion', 'modelo'].forEach(id => {
            const el = document.getElementById(id);
            el.addEventListener('input', () => {
                // Eliminar espacios al inicio
                el.value = el.value.replace(/^\s+/, '');

                // Verificar si empieza con número
                if (/^\d/.test(el.value)) {
                    el.value = el.value.replace(/^\d+/, ''); // elimina los números iniciales
                }
            });
        });

    });
</script>

</body>
</html>
