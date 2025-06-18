<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar empleado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-container {
            background-color: #1e1e1e;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
            width: 100%;
            max-width: 700px;
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

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        h2 {
            color: #e0e0e0;
        }

        .invalid-feedback {
            display: none;
            color: #ff6b6b;
        }

        input.is-invalid ~ .invalid-feedback,
        select.is-invalid ~ .invalid-feedback {
            display: block;
        }

        .error-msg {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-center mb-4">Editar empleado</h2>

        {{-- Mensajes de éxito y error de Laravel --}}
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

        <form id="empleadoForm" action="{{ route('empleados.update', $empleado->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $empleado->nombre) }}" required maxlength="30">
                    <div class="invalid-feedback" id="nombre-feedback">
                        El nombre solo puede contener letras y espacios, y debe tener un máximo de 30 caracteres.
                    </div>
                    @error('nombre') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido', $empleado->apellido) }}" required maxlength="30">
                    <div class="invalid-feedback" id="apellido-feedback">
                        El apellido solo puede contener letras y espacios, y debe tener un máximo de 30 caracteres.
                    </div>
                    @error('apellido') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="correo">Correo:</label>
                    <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $empleado->correo) }}" required>
                    <div class="invalid-feedback" id="correo-feedback">
                        Ingrese un correo válido (debe contener '@' y al menos un punto, ej. usuario@dominio.com).
                    </div>
                    @error('correo') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $empleado->telefono) }}" maxlength="8">
                    <div class="invalid-feedback" id="telefono-feedback">
                        El teléfono debe tener 8 dígitos y empezar con 8, 3, 9, o 2.
                    </div>
                    @error('telefono') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" required />
                <div class="invalid-feedback" id="direccion-feedback">
                    La dirección es requerida y puede contener letras, números, espacios y caracteres especiales como ., #, -.
                </div>
                @error('direccion') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="identidad">Identidad:</label>
                    <input type="text" name="identidad" id="identidad" class="form-control @error('identidad') is-invalid @enderror" value="{{ old('identidad', $empleado->identidad) }}" required maxlength="15" title="Debe ingresar 13 dígitos numéricos en formato ####-####-#####">
                    <div class="invalid-feedback" id="identidad-feedback">
                        Número de identidad inválido (debe ser ####-####-#####).
                    </div>
                    @error('identidad') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="puesto" class="form-label">Puesto:</label>
                    <select class="form-control @error('puesto') is-invalid @enderror" id="puesto" name="puesto" required>
                        <option value="">Seleccione...</option>
                        @foreach(['Vendedor', 'Cajero', 'Motorista', 'Gerente', 'Contador', 'Aseador'] as $puesto)
                            <option value="{{ $puesto }}" {{ old('puesto', $empleado->puesto) == $puesto ? 'selected' : '' }}>{{ $puesto }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                    @error('puesto') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sexo" class="form-label">Sexo:</label>
                    <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                        <option value="">Seleccione...</option>
                        @foreach(['Masculino', 'Femenino', 'Otro'] as $sexo)
                            <option value="{{ $sexo }}" {{ old('sexo', $empleado->sexo) == $sexo ? 'selected' : '' }}>{{ $sexo }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                    @error('sexo') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="salario">Salario:</label>
                    <input type="number" step="0.01" name="salario" id="salario" class="form-control @error('salario') is-invalid @enderror" value="{{ old('salario', $empleado->salario) }}" required min="0">
                    <div class="invalid-feedback" id="salario-feedback">
                        El salario debe ser un número positivo y no debe tener más de 5 cifras.
                    </div>
                    @error('salario') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="fecha_contratacion">Fecha de Contratación:</label>
                <input type="date" name="fecha_contratacion" id="fecha_contratacion" class="form-control @error('fecha_contratacion') is-invalid @enderror" value="{{ old('fecha_contratacion', $empleado->fecha_contratacion) }}" required>
                <div class="invalid-feedback" id="fecha_contratacion-feedback">
                    La fecha de contratación no puede ser anterior al 1 de enero de 2000 ni una fecha futura.
                </div>
                @error('fecha_contratacion') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('empleadoForm');

            form.addEventListener('submit', function(event) {
                let formIsValid = true;

                // Limpiar mensajes de error previos
                document.querySelectorAll('.is-invalid').forEach(element => {
                    element.classList.remove('is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(element => {
                    element.style.display = 'none';
                });

                // Validaciones para Nombre y Apellido (máximo 30 caracteres, solo letras y espacios)
                const nombreInput = document.getElementById('nombre');
                const apellidoInput = document.getElementById('apellido');
                const nombre = nombreInput.value.trim();
                const apellido = apellidoInput.value.trim();
                const regexNombreApellido = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

                if (nombre.length === 0 || nombre.length > 30 || !regexNombreApellido.test(nombre)) {
                    nombreInput.classList.add('is-invalid');
                    document.getElementById('nombre-feedback').style.display = 'block';
                    formIsValid = false;
                }

                if (apellido.length === 0 || apellido.length > 30 || !regexNombreApellido.test(apellido)) {
                    apellidoInput.classList.add('is-invalid');
                    document.getElementById('apellido-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Validaciones para Correo Electrónico
                const correoInput = document.getElementById('correo');
                const correo = correoInput.value.trim();
                const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (!correo || !regexCorreo.test(correo) || correo.indexOf('.') === -1) {
                    correoInput.classList.add('is-invalid');
                    document.getElementById('correo-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Validaciones para Teléfono (8 dígitos, empieza con 8, 3, 9, o 2)
                const telefonoInput = document.getElementById('telefono');
                const telefono = telefonoInput.value.trim();
                const regexTelefono = /^[2389]\d{7}$/;

                if (telefono.length > 0 && (!regexTelefono.test(telefono) || telefono.length !== 8)) {
                    telefonoInput.classList.add('is-invalid');
                    document.getElementById('telefono-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Validación de Identidad (####-####-#####)
                const identidadInput = document.getElementById('identidad');
                const identidad = identidadInput.value.trim();
                const regexIdentidad = /^\d{4}-\d{4}-\d{5}$/;

                if (!identidad || !regexIdentidad.test(identidad)) {
                    identidadInput.classList.add('is-invalid');
                    document.getElementById('identidad-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Validación de Dirección (no vacía, caracteres alfanuméricos y especiales)
                const direccionInput = document.getElementById('direccion');
                const direccion = direccionInput.value.trim();
                const regexDireccion = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,#-]+$/;

                if (!direccion || !regexDireccion.test(direccion)) {
                    direccionInput.classList.add('is-invalid');
                    document.getElementById('direccion-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Validaciones para select (Sexo y Puesto)
                const sexoInput = document.getElementById('sexo');
                if (!sexoInput.value) {
                    sexoInput.classList.add('is-invalid');
                    formIsValid = false;
                }

                const puestoInput = document.getElementById('puesto');
                if (!puestoInput.value) {
                    puestoInput.classList.add('is-invalid');
                    formIsValid = false;
                }

                // Validaciones para Salario (positivo, no más de 5 cifras)
                const salarioInput = document.getElementById('salario');
                const salario = parseFloat(salarioInput.value);
                const salarioStr = salarioInput.value.split('.')[0];

                if (isNaN(salario) || salario <= 0 || salarioStr.length > 5) {
                    salarioInput.classList.add('is-invalid');
                    document.getElementById('salario-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Validaciones para Fecha de Contratación (no antes del 2000, no futura)
                const fechaContratacionInput = document.getElementById('fecha_contratacion');
                const fechaSeleccionada = new Date(fechaContratacionInput.value + 'T00:00:00');
                const fechaLimiteInferior = new Date('2000-01-01T00:00:00');
                const fechaActual = new Date();
                fechaActual.setHours(0, 0, 0, 0);

                if (!fechaContratacionInput.value || fechaSeleccionada < fechaLimiteInferior || fechaSeleccionada > fechaActual) {
                    fechaContratacionInput.classList.add('is-invalid');
                    document.getElementById('fecha_contratacion-feedback').style.display = 'block';
                    formIsValid = false;
                }

                if (!formIsValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });

            // Formateo automático para el campo de identidad
            document.getElementById('identidad').addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                let formattedValue = '';
                if (value.length > 0) {
                    formattedValue += value.substring(0, Math.min(value.length, 4));
                    if (value.length > 4) {
                        formattedValue += '-' + value.substring(4, Math.min(value.length, 8));
                    }
                    if (value.length > 8) {
                        formattedValue += '-' + value.substring(8, Math.min(value.length, 13));
                    }
                }
                e.target.value = formattedValue;
            });

            // Limitar el teléfono a 8 dígitos y solo números
            document.getElementById('telefono').addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 8);
            });

            // Listener para limpiar validación cuando el usuario corrige
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                        const feedbackId = this.id + '-feedback';
                        const feedbackElement = document.getElementById(feedbackId);
                        if (feedbackElement) {
                            feedbackElement.style.display = 'none';
                        }
                    }
                });
                if (input.tagName === 'SELECT') {
                    input.addEventListener('change', function() {
                        if (this.classList.contains('is-invalid')) {
                            this.classList.remove('is-invalid');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>