<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
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
            border-radius: 15px;
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
        <h2 class="text-center mb-4">Editar Empleado</h2>
        
        <form id="empleadoForm" action="{{ route('empleados.update', $empleado->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $empleado->nombre) }}" required>
                    <div class="invalid-feedback">El nombre no debe contener números ni caracteres especiales.</div>
                    @error('nombre') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido', $empleado->apellido) }}" required>
                    <div class="invalid-feedback">El apellido no debe contener números ni caracteres especiales.</div>
                    @error('apellido') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $empleado->correo) }}" required>
                    <div class="invalid-feedback">El correo debe contener una "@" y un punto ".".</div>
                    @error('correo') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $empleado->telefono) }}">
                    <div class="invalid-feedback">El teléfono solo debe contener números.</div>
                    @error('telefono') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $empleado->direccion) }}" required />
                <div class="invalid-feedback">
                    La dirección solo puede contener letras, números y espacios.
                </div>
                @error('direccion') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Identidad</label>
                    <input type="text" name="identidad" id="identidad" class="form-control @error('identidad') is-invalid @enderror" value="{{ old('identidad', $empleado->identidad) }}" required>
                    <div class="invalid-feedback">Número de Identidad inválido</div>
                    @error('identidad') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="puesto" class="form-label">Puesto</label>
                    <select class="form-control @error('puesto') is-invalid @enderror" id="puesto" name="puesto" required>
                        <option value="">Seleccione...</option>
                        @foreach(['Vendedor', 'Cajero', 'Motorista', 'Gerente', 'Contador', 'Aseador'] as $puesto)
                            <option value="{{ $puesto }}" {{ old('puesto', $empleado->puesto) == $puesto ? 'selected' : '' }}>{{ $puesto }}</option>
                        @endforeach
                    </select>
                    @error('puesto') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                        <option value="">Seleccione...</option>
                        @foreach(['Masculino', 'Femenino', 'Otro'] as $sexo)
                            <option value="{{ $sexo }}" {{ old('sexo', $empleado->sexo) == $sexo ? 'selected' : '' }}>{{ $sexo }}</option>
                        @endforeach
                    </select>
                    @error('sexo') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Salario</label>
                    <input type="number" step="0.01" name="salario" class="form-control @error('salario') is-invalid @enderror" value="{{ old('salario', $empleado->salario) }}" required>
                    @error('salario') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha de Contratación</label>
                <input type="date" name="fecha_contratacion" class="form-control @error('fecha_contratacion') is-invalid @enderror" value="{{ old('fecha_contratacion', $empleado->fecha_contratacion) }}" required>
                @error('fecha_contratacion') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('empleadoForm').addEventListener('submit', function(event) {
            const nombreInput = document.getElementById('nombre');
            const apellidoInput = document.getElementById('apellido');
            const correoInput = document.getElementById('correo');
            const telefonoInput = document.getElementById('telefono');
            const identidadInput = document.getElementById('identidad');

            let formIsValid = true;

            // Validar Nombre y Apellido
            const regexNombre = /^[a-zA-ZÀ-ÿ\s]+$/;
            if (!regexNombre.test(nombreInput.value.trim())) {
                nombreInput.classList.add('is-invalid');
                formIsValid = false;
            } else {
                nombreInput.classList.remove('is-invalid');
            }

            if (!regexNombre.test(apellidoInput.value.trim())) {
                apellidoInput.classList.add('is-invalid');
                formIsValid = false;
            } else {
                apellidoInput.classList.remove('is-invalid');
            }

            // Validar Correo
            const correoVal = correoInput.value.trim();
            if (!(correoVal.includes('@') && correoVal.includes('.'))) {
                correoInput.classList.add('is-invalid');
                formIsValid = false;
            } else {
                correoInput.classList.remove('is-invalid');
            }

            // Validar Teléfono
            const regexTelefono = /^\d*$/;
            if (!regexTelefono.test(telefonoInput.value.trim())) {
                telefonoInput.classList.add('is-invalid');
                formIsValid = false;
            } else {
                telefonoInput.classList.remove('is-invalid');
            }

            // Validar Identidad
            const identidad = identidadInput.value.replace(/\D/g, '');
            const regexIdentidad = /^\d{13}$/;
            if (!regexIdentidad.test(identidad)) {
                identidadInput.classList.add('is-invalid');
                formIsValid = false;
            } else {
                const primerosDos = parseInt(identidad.substring(0, 2), 10);
                if (primerosDos > 18) {
                    identidadInput.classList.add('is-invalid');
                    formIsValid = false;
                } else {
                    identidadInput.classList.remove('is-invalid');
                }
            }

            if (!formIsValid) {
                event.preventDefault();
            }
        });

        // Formatear número de identidad automáticamente
        document.getElementById('identidad').addEventListener('input', function (e) {
            let raw = e.target.value.replace(/\D/g, '');
            raw = raw.substring(0, 13);

            let formatted = raw;
            if (raw.length > 4 && raw.length <= 8) {
                formatted = raw.slice(0, 4) + '-' + raw.slice(4);
            } else if (raw.length > 8) {
                formatted = raw.slice(0, 4) + '-' + raw.slice(4, 8) + '-' + raw.slice(8);
            }

            e.target.value = formatted;
        });
    </script>
</body>
</html>
