<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

                {{-- Mostrar error duplicado en azul --}}
                @if ($errors->has('duplicado'))
                    <div class="alert alert-primary">
                        {{ $errors->first('duplicado') }}
                    </div>
                @endif

                {{-- Mostrar otros errores en rojo, excepto el duplicado --}}
                @if ($errors->any() && !$errors->has('duplicado'))
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
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
                            <input
                                type="text"
                                class="form-control @error('nombre') is-invalid @enderror"
                                id="nombre"
                                name="nombre"
                                value="{{ old('nombre') }}"
                                required
                                maxlength="50"
                                autocomplete="off"
                            />
                            <div class="invalid-feedback" id="nombre-feedback">
                                El nombre solo puede contener letras y espacios.
                            </div>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="modelo" class="form-label">Modelo:</label>
                            <input
                                type="text"
                                class="form-control @error('modelo') is-invalid @enderror"
                                id="modelo"
                                name="modelo"
                                value="{{ old('modelo') }}"
                                required
                                maxlength="50"
                                autocomplete="off"
                            />
                            <div class="invalid-feedback" id="modelo-feedback">
                                El modelo puede contener letras, números, espacios y guiones.
                            </div>
                            @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="marca" class="form-label">Marca:</label>
                            <select class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" required>
                                <option value="">Seleccione una marca...</option>
                                @php
                                    $marcas = ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'];
                                @endphp
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca }}" {{ old('marca') == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="marca-feedback">Por favor, seleccione una marca.</div>
                            @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="anio" class="form-label">Año:</label>
                            <input
                                type="number"
                                class="form-control @error('anio') is-invalid @enderror"
                                id="anio"
                                name="anio"
                                value="{{ old('anio') }}"
                                required
                                min="1990"
                                max="{{ date('Y') }}"
                                maxlength="4"
                                autocomplete="off"
                            />
                            <div class="invalid-feedback" id="anio-feedback">
                                El año debe ser igual o mayor a 1990, no mayor al año actual.
                            </div>
                            @error('anio')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="categoria" class="form-label">Categoría:</label>
                            <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="">Seleccione...</option>
                                @php
                                    $categorias = ['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'];
                                @endphp
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria }}" {{ old('categoria') == $categoria ? 'selected' : '' }}>
                                        {{ $categoria }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="categoria-feedback">Por favor, seleccione una categoría.</div>
                            @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea
                                class="form-control @error('descripcion') is-invalid @enderror"
                                id="descripcion"
                                name="descripcion"
                                required
                                maxlength="100"
                                rows="3"
                                autocomplete="off"
                            >{{ old('descripcion') }}</textarea>
                            <div class="invalid-feedback" id="descripcion-feedback">
                                No puede empezar con espacio o número.
                            </div>
                            @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <a href="{{ route('productos.index') }}" class="btn btn-outline-light">Cancelar</a>
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

            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

            const nombreInput = document.getElementById('nombre');
            const nombre = nombreInput.value.trim();
            const regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]{0,19}$/;
            if (!regexNombre.test(nombre)) {
                nombreInput.classList.add('is-invalid');
                document.getElementById('nombre-feedback').style.display = 'block';
                formIsValid = false;
            }

            const modeloInput = document.getElementById('modelo');
            const modelo = modeloInput.value.trim();
            const regexModelo = /^[a-zA-Z][a-zA-Z0-9\s\-]{0,49}$/;
            if (!regexModelo.test(modelo)) {
                modeloInput.classList.add('is-invalid');
                document.getElementById('modelo-feedback').style.display = 'block';
                formIsValid = false;
            }

            const marcaInput = document.getElementById('marca');
            if (!marcaInput.value) {
                marcaInput.classList.add('is-invalid');
                document.getElementById('marca-feedback').style.display = 'block';
                formIsValid = false;
            }

            const anioInput = document.getElementById('anio');
            const anio = anioInput.value.trim();
            const anioNum = parseInt(anio, 10);
            const anioActual = new Date().getFullYear();
            const regexAnio = /^[1-9]\d{3}$/;
            if (!regexAnio.test(anio) || isNaN(anioNum) || anioNum < 1990 || anioNum > anioActual) {
                anioInput.classList.add('is-invalid');
                document.getElementById('anio-feedback').style.display = 'block';
                formIsValid = false;
            }

            const categoriaInput = document.getElementById('categoria');
            if (!categoriaInput.value) {
                categoriaInput.classList.add('is-invalid');
                document.getElementById('categoria-feedback').style.display = 'block';
                formIsValid = false;
            }

            const descripcionInput = document.getElementById('descripcion');
            const descripcion = descripcionInput.value.trim();
            const regexDescripcion = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]{0,99}$/;
            if (!regexDescripcion.test(descripcion)) {
                descripcionInput.classList.add('is-invalid');
                document.getElementById('descripcion-feedback').style.display = 'block';
                formIsValid = false;
            }

            if (!formIsValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        ['nombre', 'modelo', 'marca', 'anio', 'categoria', 'descripcion'].forEach(id => {
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
                        const feedback = document.getElementById(el.id + '-feedback');
                        if(feedback) feedback.style.display = 'none';
                    }
                });
            }
        });

        document.getElementById('anio').addEventListener('input', e => {
            let val = e.target.value.replace(/\D/g, '');
            if(val.length > 4) val = val.slice(0, 4);
            while(val.startsWith('0')) val = val.slice(1);
            e.target.value = val;
        });

        ['nombre', 'descripcion', 'modelo'].forEach(id => {
            const el = document.getElementById(id);
            el.addEventListener('input', () => {
                let val = el.value;
                if(val.length > 0 && (/^[\s0-9]/.test(val.charAt(0)))) {
                    el.value = val.substring(1);
                }
            });
        });
    });
</script>

</body>
</html>
