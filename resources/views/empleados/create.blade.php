<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar empleado</title> {{-- Título en la pestaña del navegador --}}
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Agrega el token CSRF para Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            text-align: center; /* Centrar el título */
        }

        /* Estilo para los mensajes de invalidación de Bootstrap */
        .invalid-feedback {
            display: none; /* Por defecto ocultos, se muestran con JS */
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545; /* Color de error de Bootstrap */
        }

        /* Mostrar el feedback cuando el input tiene la clase is-invalid */
        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }

        /* Estilo para los select que usan invalid-feedback directamente */
        select.is-invalid ~ .invalid-feedback {
            display: block;
        }

        /* Estilo para el spinner de carga */
        .loading-spinner {
            display: none;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #4caf50;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin-left: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <h2 class="mb-4">Registrar un empleado</h2> {{-- Título del formulario centrado --}}

                {{-- Mensajes de éxito y error generales, si Laravel los envía --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="formEmpleado" action="{{ route('empleados.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="30" />
                            <div class="invalid-feedback" id="nombre-feedback">
                                @error('nombre')
                                    {{ $message }}
                                @else
                                    El nombre es requerido.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="30" />
                            <div class="invalid-feedback" id="apellido-feedback">
                                @error('apellido')
                                    {{ $message }}
                                @else
                                    El apellido es requerido.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo') }}" required maxlength="30" />
                            <div class="invalid-feedback" id="correo-feedback">
                                @error('correo')
                                    {{ $message }}
                                @else
                                    El correo es requerido.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" maxlength="8" />
                            <div class="invalid-feedback" id="telefono-feedback">
                                @error('telefono')
                                    {{ $message }}
                                @else
                                    El teléfono es requerido.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="identidad" class="form-label">Número de Identidad:</label>
                            <input type="text" class="form-control @error('identidad') is-invalid @enderror" id="identidad" name="identidad" value="{{ old('identidad') }}" maxlength="15" required
                                title="Debe ingresar 13 dígitos numéricos en formato ####-####-#####" />
                            <div class="invalid-feedback" id="identidad-feedback">
                                @error('identidad')
                                    {{ $message }}
                                @else
                                    El número de identidad es requerido.
                                @enderror
                            </div>
                            {{-- Agrega este elemento para el spinner de carga --}}
                            <div id="numero_id_loading" class="loading-spinner"></div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" required maxlength="100" rows="3">{{ old('direccion') }}</textarea>
                            <div class="invalid-feedback" id="direccion-feedback">
                                @error('direccion')
                                    {{ $message }}
                                @else
                                    La dirección es requerida.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="sexo" class="form-label">Sexo:</label>
                            <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                                <option value="">Seleccione...</option>
                                <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('sexo')
                                    {{ $message }}
                                @else
                                    Por favor, seleccione una opción.
                                @enderror
                            </div>
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
                            <div class="invalid-feedback">
                                @error('puesto')
                                    {{ $message }}
                                @else
                                    Por favor, seleccione una opción.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="salario" class="form-label">Salario:</label>
                            <input type="number" class="form-control @error('salario') is-invalid @enderror" id="salario" name="salario" value="{{ old('salario') }}" step="0.01" required min="0" />
                            <div class="invalid-feedback" id="salario-feedback">
                                @error('salario')
                                    {{ $message }}
                                @else
                                    El salario es requerido, debe ser un número positivo y con un máximo de 5 cifras enteras.
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="fecha_contratacion" class="form-label">Fecha de Contratación:</label>
                            <input type="date" class="form-control @error('fecha_contratacion') is-invalid @enderror" id="fecha_contratacion" name="fecha_contratacion" value="{{ old('fecha_contratacion') }}" required />
                            <div class="invalid-feedback" id="fecha_contratacion-feedback">
                                @error('fecha_contratacion')
                                    {{ $message }}
                                @else
                                    La fecha de contratación es requerida.
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary ms-2" id="limpiarFormulario">Limpiar</button>
                    <a href="{{ route('empleados.index') }}" class="btn btn-outline-danger ms-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formEmpleado');
        const nombreInput = document.getElementById('nombre');
        const apellidoInput = document.getElementById('apellido');
        const salarioInput = document.getElementById('salario');
        const telefonoInput = document.getElementById('telefono');
        const correoInput = document.getElementById('correo');
        const fechaContratacionInput = document.getElementById('fecha_contratacion');
        const identidadInput = document.getElementById('identidad');
        const direccionInput = document.getElementById('direccion');
        const sexoInput = document.getElementById('sexo');
        const puestoInput = document.getElementById('puesto');

        // Define clienteId (ajusta según si es un formulario de creación o edición)
        // Si estás en un formulario de creación, clienteId será null.
        // Si estás en edición, asegúrate de que $cliente->id se pase correctamente.
        const clienteId = @json(isset($cliente) ? $cliente->id : null);


        // --- Función de utilidad para mostrar/ocultar errores ---
        function showValidationError(inputElement, message, isValid) {
            const feedbackElement = inputElement.nextElementSibling; // Asume que el feedback está justo después
            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                if (!isValid) {
                    inputElement.classList.add('is-invalid');
                    feedbackElement.textContent = message;
                    feedbackElement.style.display = 'block';
                } else {
                    inputElement.classList.remove('is-invalid');
                    feedbackElement.textContent = '';
                    feedbackElement.style.display = 'none';
                }
            }
        }

        // --- Función para validar Número de Identidad (DNI) ---
        async function validateNumeroId(input) {
            let message = '';
            const value = input.value.trim();
            const dniClean = value.replace(/-/g, ''); // Eliminar guiones para la validación

            // 1. Validación de campo obligatorio
            if (value === '') {
                message = 'El número de identidad es obligatorio.';
            }
            // 2. Validación de longitud y que sean solo dígitos
            else if (!/^\d{13}$/.test(dniClean)) {
                message = 'El número de identidad debe contener exactamente 13 dígitos numéricos.';
            }
            // 3. Validación de departamento y municipio (primeros 4 dígitos)
            else {
                const firstFour = dniClean.substring(0, 4);
                // Explicación de la regex:
                // ^(0[1-9]|1[0-8])  -> Primeros dos dígitos: 01-09 o 10-18 (departamentos válidos en Honduras)
                // [0-9]{2}$         -> Siguientes dos dígitos: cualquier número del 00 al 99 (municipios)
                if (!/^(0[1-9]|1[0-8])[0-9]{2}$/.test(firstFour)) {
                    message = 'Los primeros 4 dígitos del DNI no corresponden a un código de departamento y municipio válido (ej. 0101, 1801).';
                }
            }

            // Mostrar el resultado de la validación local inmediatamente
            showValidationError(input, message, message === '');

            // Si la validación local pasa y el valor ha cambiado, verificar unicidad vía AJAX
            if (message === '' && input.dataset.originalValue !== value) {
                const loadingSpinner = document.getElementById('numero_id_loading');
                if (loadingSpinner) { // Verificar si el spinner existe
                    loadingSpinner.style.display = 'block';
                }

                try {
                    const response = await fetch('{{ route('clientes.checkDniUniqueness') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            numero_id: dniClean, // Envía el DNI sin guiones al backend
                            id_cliente_to_ignore: typeof clienteId !== 'undefined' && clienteId !== null ? clienteId : null
                        })
                    });
                    const data = await response.json();
                    if (!data.unique) {
                        message = data.message; // Mensaje como "El DNI ya está registrado."
                        showValidationError(input, message, false);
                    } else {
                        showValidationError(input, '', true); // Limpiar error si es único
                    }
                } catch (error) {
                    console.error('Error al verificar unicidad del DNI:', error);
                    message = 'Error al verificar el DNI. Intente de nuevo.';
                    showValidationError(input, message, false);
                } finally {
                    if (loadingSpinner) {
                        loadingSpinner.style.display = 'none';
                    }
                }
            }
            // Si la validación local falló, o el valor no ha cambiado y no hay mensaje previo, no se hace AJAX
            else if (message !== '' || input.dataset.originalValue === value) {
                // No hacer nada, el showValidationError ya manejó el estado
            }

            return message === ''; // Retorna true si no hay errores, false si los hay
        }


        // --- Listeners de PREVENCIÓN de entrada en tiempo real ---

        // Configurar originalValue para la validación de unicidad al cargar el formulario
        if (identidadInput) {
            identidadInput.dataset.originalValue = identidadInput.value;
        }

        // Nombre y Apellido: Solo letras, espacios, guiones y tildes/ñ
        const regexSoloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]+$/;

        function enforceLettersOnly(event) {
            let value = event.target.value;
            const originalSelectionStart = event.target.selectionStart;
            const originalSelectionEnd = event.target.selectionEnd;

            // Filtra los caracteres no permitidos
            const filteredValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]/g, '');

            if (value !== filteredValue) {
                event.target.value = filteredValue;

                // Ajusta la posición del cursor si los caracteres fueron eliminados
                if (originalSelectionStart === originalSelectionEnd) {
                    event.target.setSelectionRange(originalSelectionStart - (value.length - filteredValue.length), originalSelectionEnd - (value.length - filteredValue.length));
                } else {
                    event.target.setSelectionRange(originalSelectionStart, originalSelectionEnd - (value.length - filteredValue.length));
                }
            }
        }

        nombreInput.addEventListener('input', enforceLettersOnly);
        apellidoInput.addEventListener('input', enforceLettersOnly);


        // Salario: Limita la entrada en tiempo real a 5 dígitos enteros
        salarioInput.addEventListener('input', function(e) {
            let value = e.target.value;
            const parts = value.split('.');
            let integerPart = parts[0];
            let decimalPart = parts[1];

            // Limitar la parte entera a 5 dígitos
            if (integerPart.length > 5) {
                integerPart = integerPart.substring(0, 5);
            }

            // Reconstruir el valor
            if (decimalPart !== undefined) {
                e.target.value = integerPart + '.' + decimalPart;
            } else {
                e.target.value = integerPart;
            }

            // Asegurarse de que no haya ceros iniciales si no es '0'
            if (e.target.value.length > 1 && e.target.value[0] === '0' && e.target.value[1] !== '.') {
                e.target.value = e.target.value.substring(1);
            }
        });

        // Teléfono: Limitar a 8 dígitos y solo números
        telefonoInput.addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 8);
        });

        // Identidad: Formateo automático (mantenido)
        identidadInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remover todo lo que no sea dígito
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

        // --- Listener para el SUBMIT del formulario (Validaciones al enviar) ---

        form.addEventListener('submit', async function(event) { // Añade 'async' aquí
            event.preventDefault(); // Evita el envío por defecto para manejar la validación

            let formIsValid = true;

            // Limpiar mensajes de error previos del cliente
            document.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(element => {
                // Solo ocultar si no es un mensaje de error de Laravel
                if (element.textContent.trim().length > 0 && !element.dataset.laravelError) {
                    element.style.display = 'none';
                }
            });

            // Validaciones para Nombre
            const nombre = nombreInput.value.trim();
            if (nombre.length === 0) {
                showValidationError(nombreInput, 'El nombre es requerido.', false);
                formIsValid = false;
            } else if (!regexSoloLetras.test(nombre)) {
                showValidationError(nombreInput, 'No se permiten números ni caracteres especiales en el nombre.', false);
                formIsValid = false;
            }

            // Validaciones para Apellido
            const apellido = apellidoInput.value.trim();
            if (apellido.length === 0) {
                showValidationError(apellidoInput, 'El apellido es requerido.', false);
                formIsValid = false;
            } else if (!regexSoloLetras.test(apellido)) {
                showValidationError(apellidoInput, 'No se permiten números ni caracteres especiales en el apellido.', false);
                formIsValid = false;
            }

            // Validaciones para Correo Electrónico
            const correo = correoInput.value.trim();
            const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (correo.length === 0) {
                showValidationError(correoInput, 'El correo es requerido.', false);
                formIsValid = false;
            } else if (!regexCorreo.test(correo) || correo.length > 30) {
                showValidationError(correoInput, 'Ingrese un correo válido (ej. usuario@dominio.com).', false);
                formIsValid = false;
            }

            // Validaciones para Teléfono
            const telefono = telefonoInput.value.trim();
            const regexTelefonoInicio = /^[2389]\d{7}$/;

            if (telefono.length === 0) {
                showValidationError(telefonoInput, 'El teléfono es requerido.', false);
                formIsValid = false;
            } else if (!regexTelefonoInicio.test(telefono)) {
                showValidationError(telefonoInput, 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.', false);
                formIsValid = false;
            }

            // Validar el campo de identidad (AHORA USA LA NUEVA FUNCIÓN)
            // Es importante que esta validación se ejecute antes de cualquier `form.submit()`
            // y que se espere su resultado si es asíncrona.
            const isIdentidadValid = await validateNumeroId(identidadInput);
            if (!isIdentidadValid) {
                formIsValid = false;
            }

            // Validación de Dirección (textarea)
            const direccion = direccionInput.value.trim();

            if (direccion.length === 0) {
                showValidationError(direccionInput, 'La dirección es requerida.', false);
                formIsValid = false;
            } else if (direccion.length > 100) {
                showValidationError(direccionInput, 'La dirección no puede exceder los 100 caracteres.', false);
                formIsValid = false;
            }

            // Validaciones para select (Sexo y Puesto)
            if (!sexoInput.value) {
                showValidationError(sexoInput, 'Por favor, seleccione una opción para el sexo.', false);
                formIsValid = false;
            } else {
                showValidationError(sexoInput, '', true); // Limpiar si es válido
            }

            if (!puestoInput.value) {
                showValidationError(puestoInput, 'Por favor, seleccione una opción para el puesto.', false);
                formIsValid = false;
            } else {
                showValidationError(puestoInput, '', true); // Limpiar si es válido
            }

            // Validaciones para Salario
            const salario = parseFloat(salarioInput.value);
            if (isNaN(salario) || salario <= 0) {
                showValidationError(salarioInput, 'El salario es requerido y debe ser un número positivo.', false);
                formIsValid = false;
            } else if (salario.toString().split('.')[0].length > 5) {
                showValidationError(salarioInput, 'El salario no puede tener más de 5 cifras enteras.', false);
                formIsValid = false;
            } else {
                showValidationError(salarioInput, '', true);
            }

            // Validaciones para Fecha de Contratación
            const fechaContratacion = fechaContratacionInput.value.trim();
            if (fechaContratacion.length === 0) {
                showValidationError(fechaContratacionInput, 'La fecha de contratación es requerida.', false);
                formIsValid = false;
            } else {
                showValidationError(fechaContratacionInput, '', true);
            }


            if (formIsValid) {
                form.submit(); // Si todo es válido, envía el formulario
            }
        });

        // Limpiar formulario
        document.getElementById('limpiarFormulario').addEventListener('click', function() {
            form.reset();
            document.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(element => {
                element.style.display = 'none';
                element.textContent = ''; // Clear text content
            });
        });

        // Listener para la validación del DNI al cambiar el input (no solo al enviar)
        identidadInput.addEventListener('blur', async function() {
            await validateNumeroId(identidadInput);
        });
    });
</script>
</body>
</html>