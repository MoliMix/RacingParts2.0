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

                {{-- Mensaje de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="formEmpleado" action="{{ route('empleados.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required />
                            <div class="invalid-feedback">
                                El nombre solo puede contener letras y espacios.
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required />
                            <div class="invalid-feedback">
                                El apellido solo puede contener letras y espacios.
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required />
                            <div class="invalid-feedback">
                                Ingrese un correo válido (con @ y un punto).
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" />
                            <div class="invalid-feedback">
                                El teléfono solo puede contener números.
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="identidad" class="form-label">Número de Identidad:</label>
                            <input type="text" class="form-control" id="identidad" name="identidad" maxlength="15" required
                                title="Debe ingresar 13 dígitos numéricos en formato ####-####-#####"
                            />
                            <div class="invalid-feedback">
                             Número de identidad invalido
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required />
                            <div class="invalid-feedback">
                                La dirección solo puede contener letras, números y espacios.
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="sexo" class="form-label">Sexo:</label>
                            <select class="form-control" id="sexo" name="sexo" required>
                                <option value="">Seleccione...</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="puesto" class="form-label">Puesto:</label>
                            <select class="form-control" id="puesto" name="puesto" required>
                                <option value="">Seleccione...</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Cajero">Cajero</option>
                                <option value="Motorista">Motorista</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Contador">Contador</option>
                                <option value="Aseador">Aseador</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="salario" class="form-label">Salario:</label>
                            <input type="number" class="form-control" id="salario" name="salario" step="0.01" required />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="fecha_contratacion" class="form-label">Fecha de Contratación:</label>
                            <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" required />
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
    const regexNumeros = /^\d*$/;
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const identidadInput = document.getElementById('identidad');
    const identidadVal = identidadInput.value.replace(/-/g, '');

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
    if (!correoRegex.test(correoInput.value.trim())) {
        correoInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        correoInput.classList.remove('is-invalid');
    }

    // Teléfono
    const telefonoInput = document.getElementById('telefono');
    if (!regexNumeros.test(telefonoInput.value.trim())) {
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
    if (!/^\d{13}$/.test(identidadVal)) {
        identidadInput.classList.add('is-invalid');
        formIsValid = false;
    } else {
        const primerosDos = parseInt(identidadVal.substring(0, 2), 10);
        if (primerosDos > 18) {
            identidadInput.classList.add('is-invalid');
            formIsValid = false;
        } else {
            identidadInput.classList.remove('is-invalid');
        }
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
</script>

</body>
</html>
