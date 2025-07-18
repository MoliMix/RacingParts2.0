<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Actualizar Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    {{-- Font Awesome 6 CDN (for icons like fa-undo-alt) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs4u8rkxFRxTRjNGWPGQnpMNAwXsHwXuPWKqzB+sbuD/LkFovhXECyCkZtGssO8uX8Y3eT4yBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        .form-control, .form-select {
            background-color: #2c2c2c;
            border: none;
            color: #fff;
        }

        .form-control:focus, .form-select:focus {
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

        .btn-warning {
            background-color: #ffc107; /* Bootstrap's warning color */
            border-color: #ffc107;
            color: #212529; /* Dark text for contrast */
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        h1, h2 {
            color: #e0e0e0;
        }

        .alert-success {
            background-color: #28a745;
            color: #fff;
            border-color: #28a745;
        }

        .alert-danger {
            background-color: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        /* Styles for checkboxes */
        .form-check-input {
            background-color: #2c2c2c;
            border-color: #444;
        }

        .form-check-input:checked {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        .form-check-label {
            color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <h2 class="mb-4">Actualizar Cliente</h2>

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

                    <form id="formCliente" action="{{ route('clientes.update', $cliente->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Row for Nombre Completo --}}
                        <div class="row">
                            {{-- Para que la celda del nombre sea más corta, podemos reducir el col-md-X --}}
                            <div class="col-12 col-md-8 mb-3">
                                <label for="nombre_completo" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror" id="nombre_completo" name="nombre_completo"
                                    value="{{ old('nombre_completo', $cliente->nombre_completo) }}" required maxlength="40">
                                <div class="invalid-feedback" id="nombre_completo-feedback">
                                    El nombre completo es requerido y debe tener un máximo de 100 caracteres.
                                </div>
                                @error('nombre_completo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Row for Número de Identidad and Número de Teléfono --}}
                        <div class="row">
                            <div class="col-md-6 mb-3"> {{-- col-md-6 for side-by-side on medium+ screens --}}
                                <label for="numero_id" class="form-label">Número de Identidad</label>
                                <input type="text" class="form-control @error('numero_id') is-invalid @enderror" id="numero_id" name="numero_id"
                                    value="{{ old('numero_id', $cliente->numero_id) }}" required maxlength="15"> {{-- Ajusted maxlength to accommodate hyphens --}}
                                <div>
                                    El número de identidad debe contener 13 dígitos y ser un DNI hondureño válido (formato 0000-0000-00000).
                                </div>
                                @error('numero_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3"> {{-- col-md-6 for side-by-side on medium+ screens --}}
                                <label for="numero_telefono" class="form-label">Número de Teléfono</label>
                                <input type="tel" class="form-control @error('numero_telefono') is-invalid @enderror" id="numero_telefono" name="numero_telefono"
                                    value="{{ old('numero_telefono', $cliente->numero_telefono) }}" required maxlength="8"> {{-- Adjusted maxlength to 8 for Honduran phones --}}
                                <div class="invalid-feedback" id="numero_telefono-feedback">
                                    El número de teléfono es requerido y debe tener 8 dígitos numéricos.
                                </div>
                                @error('numero_telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Row for Correo Electrónico and Dirección del Cliente --}}
                        <div class="row">
                            <div class="col-md-6 mb-3"> {{-- col-md-6 for side-by-side on medium+ screens --}}
                                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror" id="correo_electronico" name="correo_electronico"
                                    value="{{ old('correo_electronico', $cliente->correo_electronico) }}" required maxlength="30">
                                <div class="invalid-feedback" id="correo_electronico-feedback">
                                    El correo electrónico es requerido y debe ser un formato válido.
                                </div>
                                @error('correo_electronico')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3"> {{-- col-md-6 for side-by-side on medium+ screens --}}
                                <label for="direccion_cliente" class="form-label">Dirección del Cliente</label>
                                <input type="text" class="form-control @error('direccion_cliente') is-invalid @enderror" id="direccion_cliente" name="direccion_cliente"
                                    value="{{ old('direccion_cliente', $cliente->direccion_cliente) }}" maxlength="80">
                                <div class="invalid-feedback" id="direccion_cliente-feedback">
                                    La dirección del cliente debe tener un máximo de 80 caracteres.
                                </div>
                                @error('direccion_cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
 <div class="col-md-6 mb-3"> {{-- col-md-6 for side-by-side on medium+ screens --}}
    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
    <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror" id="fecha_ingreso" name="fecha_ingreso"
        value="{{ old('fecha_ingreso', optional($cliente->fecha_ingreso)->format('Y-m-d')) }}">
    <div class="invalid-feedback" id="fecha_ingreso-feedback">
        Por favor, ingrese una fecha válida.
    </div>
    @error('fecha_ingreso')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        </div>

                        {{-- Row for Fecha de Ingreso --}}

                        {{-- Row for Sexo --}}
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Sexo:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sexo') is-invalid @enderror" type="radio" id="sexoMasculino" name="sexo" value="Masculino"
                                        {{ old('sexo', $cliente->sexo) == 'Masculino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sexoMasculino">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sexo') is-invalid @enderror" type="radio" id="sexoFemenino" name="sexo" value="Femenino"
                                        {{ old('sexo', $cliente->sexo) == 'Femenino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sexoFemenino">Femenino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sexo') is-invalid @enderror" type="radio" id="sexoOtros" name="sexo" value="Otro"
                                        {{ old('sexo', $cliente->sexo) == 'Otro' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sexoOtros">Otro</label>
                                </div>
                                <div class="invalid-feedback" id="sexo-feedback">
                                    Debe seleccionar una opción de sexo.
                                </div>
                                @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-warning">
                                <span class="fas fa-edit me-2"></span>Actualizar
                            </button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                                <span class="fas fa-undo-alt me-2"></span>Regresar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Bundle with Popper --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formCliente');
            const numeroIdInput = document.getElementById('numero_id');
            const numeroTelefonoInput = document.getElementById('numero_telefono');
            const sexoRadios = document.querySelectorAll('input[name="sexo"]');

            // --- Function to format DNI (0000-0000-00000) and limit to 13 digits ---
            function formatDNI(value) {
                let cleanedValue = value.replace(/\D/g, ''); // Elimina todo lo que no sea dígito

                // Limita a 13 dígitos
                if (cleanedValue.length > 13) {
                    cleanedValue = cleanedValue.substring(0, 13);
                }

                let formattedValue = '';
                if (cleanedValue.length > 0) {
                    // Agrega el primer guion después de los primeros 4 dígitos
                    if (cleanedValue.length > 4) {
                        formattedValue = cleanedValue.substring(0, 4) + '-' + cleanedValue.substring(4);
                    } else {
                        formattedValue = cleanedValue;
                    }

                    // Agrega el segundo guion si hay suficientes dígitos para el formato completo (0000-0000-00000)
                    // La longitud del valor formateado con el primer guion será 4 + 1 + 4 = 9 si ya tiene 8 dígitos
                    if (formattedValue.length > 9) { // Verifica si hay al menos 8 dígitos + 1 guion
                        formattedValue = formattedValue.substring(0, 9) + '-' + formattedValue.substring(9);
                    }
                }
                return formattedValue;
            }

            // --- Apply DNI formatting on input and on load ---
            numeroIdInput.addEventListener('input', function(e) {
                e.target.value = formatDNI(e.target.value);
            });
            // Apply format when the page loads, useful for `old()` values or existing data
            if (numeroIdInput.value) {
                numeroIdInput.value = formatDNI(numeroIdInput.value);
            }

            // --- Input cleanup for phone number (digits only, limit length) ---
            numeroTelefonoInput.addEventListener('input', function(e) {
                let val = e.target.value.replace(/\D/g, ''); // Only digits
                if(val.length > 8) { // Honduran phone numbers are 8 digits
                    val = val.slice(0, 8);
                }
                e.target.value = val;
            });
            // Ensure phone number is formatted on load as well
            if (numeroTelefonoInput.value) {
                numeroTelefonoInput.value = numeroTelefonoInput.value.replace(/\D/g, '').slice(0, 8);
            }


            // --- Client-side Validations on Form Submit ---
            form.addEventListener('submit', function(event) {
                let formIsValid = true;

                // Clear previous validation messages
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

                // Nombre Completo: required, max 100 characters
                const nombreCompletoInput = document.getElementById('nombre_completo');
                const nombreCompleto = nombreCompletoInput.value.trim();
                if (nombreCompleto.length === 0 || nombreCompleto.length > 40) {
                    nombreCompletoInput.classList.add('is-invalid');
                    document.getElementById('nombre_completo-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Número de Identidad: required, exactly 13 digits (after cleaning)
                const numeroIdCleaned = numeroIdInput.value.replace(/[^0-9]/g, ''); // Cleaned for validation
                if (numeroIdCleaned.length !== 13) { // Expecting exactly 13 digits
                    numeroIdInput.classList.add('is-invalid');
                    document.getElementById('numero_id-feedback').textContent = 'El número de identidad debe contener exactamente 13 dígitos numéricos.';
                    document.getElementById('numero_id-feedback').style.display = 'block';
                    formIsValid = false;
                } else {
                    // Re-format for display if it passed length validation
                    numeroIdInput.value = formatDNI(numeroIdInput.value);
                }


                // Número de Teléfono: required, exactly 8 digits, numbers only, starts with 3, 8, or 9
                const numeroTelefonoCleaned = numeroTelefonoInput.value.trim().replace(/\D/g, '');
                if (numeroTelefonoCleaned.length !== 8) {
                    numeroTelefonoInput.classList.add('is-invalid');
                    document.getElementById('numero_telefono-feedback').textContent = 'El número de teléfono debe contener exactamente 8 dígitos.';
                    document.getElementById('numero_telefono-feedback').style.display = 'block';
                    formIsValid = false;
                } else {
                    const startsWithValidDigit = ['2','3', '8', '9'].includes(numeroTelefonoCleaned.charAt(0));
                    if (!startsWithValidDigit) {
                        numeroTelefonoInput.classList.add('is-invalid');
                        document.getElementById('numero_telefono-feedback').textContent = 'El número de teléfono debe comenzar con 3, 8 o 9.';
                        document.getElementById('numero_telefono-feedback').style.display = 'block';
                        formIsValid = false;
                    }
                }


                // Correo Electrónico: required, valid email format, max 100 characters
                const correoElectronicoInput = document.getElementById('correo_electronico');
                const correoElectronico = correoElectronicoInput.value.trim();
                const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regexEmail.test(correoElectronico) || correoElectronico.length === 0 || correoElectronico.length > 60) {
                    correoElectronicoInput.classList.add('is-invalid');
                    document.getElementById('correo_electronico-feedback').style.display = 'block';
                    formIsValid = false;
                }

                // Dirección del Cliente: max 255 characters (optional, but validate length if provided)
                const direccionClienteInput = document.getElementById('direccion_cliente');
                const direccionCliente = direccionClienteInput.value.trim();
                if (direccionCliente.length > 255) {
                    direccionClienteInput.classList.add('is-invalid');
                    document.getElementById('direccion_cliente-feedback').style.display = 'block';
                    formIsValid = false;
                }
                if (direccionCliente.length < 10 && direccionCliente.length > 0) { // If entered, must be at least 10 chars
                        direccionClienteInput.classList.add('is-invalid');
                    document.getElementById('direccion_cliente-feedback').textContent = 'La dirección debe tener al menos 10 caracteres.';
                    document.getElementById('direccion_cliente-feedback').style.display = 'block';
                    formIsValid = false;
                }


                // Sexo: exactly one radio button must be checked
                let sexoChecked = false;
                sexoRadios.forEach(radio => {
                    if (radio.checked) {
                        sexoChecked = true;
                    }
                });

                if (!sexoChecked) {
                    sexoRadios.forEach(radio => {
                        radio.classList.add('is-invalid');
                    });
                    document.getElementById('sexo-feedback').style.display = 'block';
                    formIsValid = false;
                } else {
                    sexoRadios.forEach(radio => {
                        radio.classList.remove('is-invalid');
                    });
                    document.getElementById('sexo-feedback').style.display = 'none';
                }

                if (!formIsValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });

            // --- Cleanup validation on input change for most fields ---
            ['nombre_completo', 'numero_id', 'numero_telefono', 'correo_electronico', 'direccion_cliente'].forEach(id => {
                const el = document.getElementById(id);
                el.addEventListener('input', () => {
                    if (el.classList.contains('is-invalid')) {
                        el.classList.remove('is-invalid');
                        const feedback = document.getElementById(id + '-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                });
            });

            // Cleanup validation for Sexo radio buttons on change
            sexoRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    let anyChecked = false;
                    sexoRadios.forEach(r => {
                        if (r.checked) {
                            anyChecked = true;
                        }
                    });

                    if (anyChecked) {
                        sexoRadios.forEach(r => r.classList.remove('is-invalid'));
                        document.getElementById('sexo-feedback').style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>