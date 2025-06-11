<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Empleado</title>
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
                <h2 class="mb-4">Registrar Empleado</h2>

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

                <form id="formEmpleado" action="{{ route('empleados.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required />
                            <div class="invalid-feedback">
                                El nombre solo puede contener letras y espacios.
                            </div>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required />
                            <div class="invalid-feedback">
                                El apellido solo puede contener letras y espacios.
                            </div>
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo') }}" required />
                            <div class="invalid-feedback">
                                Ingrese un correo válido (con @ y un punto).
                            </div>
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" />
                            <div class="invalid-feedback">
                                El teléfono solo puede contener números.
                            </div>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="identidad" class="form-label">Número de Identidad:</label>
                            <input type="text" class="form-control @error('identidad') is-invalid @enderror" id="identidad" name="identidad" value="{{ old('identidad') }}" maxlength="15" required
                                title="Debe ingresar 13 dígitos numéricos en formato ####-####-#####"
                            />
                            <div class="invalid-feedback">
                                Número de identidad inválido
                            </div>
                            @error('identidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion') }}" required />
                            <div class="invalid-feedback">
                                La dirección solo puede contener letras, números y espacios.
                            </div>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="sexo" class="form-label">Sexo:</label>
                            <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                                <option value="">Seleccione...</option>
                                <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="puesto" class="form-label">Puesto:</label>
                            <select class="form-control @error('puesto') is-invalid @enderror" id="puesto" name="puesto" required>
                                <option value="">Seleccione...</option>
                                <option value="Vendedor" {{ old('puesto') == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                                <option value="Cajero" {{ old('puesto') == 'Cajero' ? 'selected' : '' }}>Cajero</option>
                                <option value="Motorista" {{ old('puesto') == 'Motorista' ? 'selected' : '' }}>Motorista</option>
                                <option value="Gerente" {{ old('puesto') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                <option value="Contador" {{ old('puesto') == 'Contador' ? 'selected' : '' }}>Contador</option>
                                <option value="Aseador" {{ old('puesto') == 'Aseador' ? 'selected' : '' }}>Aseador</option>
                            </select>
                            @error('puesto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="salario" class="form-label">Salario:</label>
                            <input type="number" class="form-control @error('salario') is-invalid @enderror" id="salario" name="salario" value="{{ old('salario') }}" step="0.01" required />
                            @error('salario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="fecha_contratacion" class="form-label">Fecha de Contratación:</label>
                            <input type="date" class="form-control @error('fecha_contratacion') is-invalid @enderror" id="fecha_contratacion" name="fecha_contratacion" value="{{ old('fecha_contratacion') }}" required />
                            @error('fecha_contratacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('welcome') }}" class="btn btn-outline-light ms-2">Inicio</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('formEmpleado').addEventListener('submit', function(event) {
    let formIsValid = true;

    const regexLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    const regexDireccion = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,#-]+$/;
    const regexNumeros = /^\d+$/;
    const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexIdentidad = /^\d{4}-\d{4}-\d{5}$/;

    // Nombre
    const nombreInput = document.getElementById('nombre');
    if (!regexLetras.test(nombreInput.value.trim())) {
        nombreInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        nombreInput.classList.remove('is-invalid');
    }

    // Apellido
    const apellidoInput = document.getElementById('apellido');
    if (!regexLetras.test(apellidoInput.value.trim())) {
        apellidoInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        apellidoInput.classList.remove('is-invalid');
    }

    // Correo
    const correoInput = document.getElementById('correo');
    if (!regexCorreo.test(correoInput.value.trim())) {
        correoInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        correoInput.classList.remove('is-invalid');
    }

    // Teléfono
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput.value.trim() && !regexNumeros.test(telefonoInput.value.trim())) {
        telefonoInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        telefonoInput.classList.remove('is-invalid');
    }

    // Dirección
    const direccionInput = document.getElementById('direccion');
    if (!regexDireccion.test(direccionInput.value.trim())) {
        direccionInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        direccionInput.classList.remove('is-invalid');
    }

    // Identidad
    const identidadInput = document.getElementById('identidad');
    if (!regexIdentidad.test(identidadInput.value.trim())) {
        identidadInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        identidadInput.classList.remove('is-invalid');
    }

    // Sexo
    const sexoInput = document.getElementById('sexo');
    if (!sexoInput.value) {
        sexoInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        sexoInput.classList.remove('is-invalid');
    }

    // Puesto
    const puestoInput = document.getElementById('puesto');
    if (!puestoInput.value) {
        puestoInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        puestoInput.classList.remove('is-invalid');
    }

    // Salario
    const salarioInput = document.getElementById('salario');
    if (!salarioInput.value || parseFloat(salarioInput.value) <= 0) {
        salarioInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        salarioInput.classList.remove('is-invalid');
    }

    // Fecha de Contratación
    const fechaInput = document.getElementById('fecha_contratacion');
    const fechaActual = new Date();
    const fechaSeleccionada = new Date(fechaInput.value);
    
    if (!fechaInput.value || fechaSeleccionada > fechaActual) {
        fechaInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        fechaInput.classList.remove('is-invalid');
    }

    if (!formIsValid) {
        event.preventDefault();
        event.stopPropagation();
    }
});

// Formatear número de identidad automáticamente
document.getElementById('identidad').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '').substring(0, 13);
    if (value.length > 4 && value.length <= 8) {
        value = value.slice(0, 4) + '-' + value.slice(4);
    } else if (value.length > 8) {
        value = value.slice(0, 4) + '-' + value.slice(4, 8) + '-' + value.slice(8);
    }
    e.target.value = value;
});

// Formatear teléfono automáticamente
document.getElementById('telefono').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '');
});
</script>

</body>
</html>
