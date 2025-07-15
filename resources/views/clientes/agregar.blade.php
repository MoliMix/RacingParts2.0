<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>{{ isset($cliente) ? 'Editar Cliente' : 'Registrar Nuevo Cliente' }}</title>
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
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

        .form-select {
            background-color: #2c2c2c;
            border: none;
            color: #fff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ccc' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        }

        .form-select option {
            background-color: #2c2c2c;
            color: #fff;
        }

        .btn-primary {
            background-color: #4caf50;
            border: none;
        }

        .btn-primary:hover {
            background-color: #43a047;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        h2 {
            color: #e0e0e0;
            text-align: center;
        }

        /* Los estilos para invalid-feedback se mantienen ya que Bootstrap los usa por defecto,
           pero la gestión del "display: block" se deja en manos de Bootstrap
           cuando la clase is-invalid se aplica */
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <h2 class="mb-4">{{ isset($cliente) ? 'Editar Cliente' : 'Registrar Nuevo Cliente' }}</h2>

                    {{-- Mensajes de éxito y error de sesión --}}
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

                    {{-- Mensajes de error de validación de Laravel --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- El action del formulario debe ser dinámico si es para editar o crear --}}
                    <form id="formCliente" action="{{ isset($cliente) ? route('clientes.update', $cliente->id) : route('clientes.store') }}" method="POST" novalidate>
                        @csrf
                        {{-- Si estás editando, necesitas el método PUT/PATCH --}}
                        @isset($cliente)
                            @method('PUT')
                        @endisset

                        <div class="row">
                            {{-- Nombre Completo --}}
                            <div class="mb-3 col-md-6">
                                <label for="nombre_completo" class="form-label">Nombre Completo:</label>
                                <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror"
                                    id="nombre_completo" name="nombre_completo"
                                    value="{{ old('nombre_completo', $cliente->nombre_completo ?? '') }}" required
                                    maxlength="50" />
                                @error('nombre_completo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Número de Identidad --}}
                            <div class="mb-3 col-md-6">
    <label for="numero_id" class="form-label">Número de Identidad:</label>
    <input
        type="text"
        class="form-control @error('numero_id') is-invalid @enderror"
        id="numero_id"
        name="numero_id"
        value="{{ old('numero_id', $cliente->numero_id ?? '') }}"
        required
        maxlength="15" {{-- Max length for 0000-0000-00000 format (13 digits + 2 hyphens) --}}
        pattern="^\d{4}-\d{4}-\d{5}$" {{-- HTML5 pattern for client-side validation --}}
        placeholder="Ej: 0000-0000-00000"
        title="Formato: AAAA-BBBB-CCCCC" {{-- Provides a tooltip for the pattern --}}
    />
    @error('numero_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="invalid-feedback" id="numero_id-feedback" style="{{ $errors->has('numero_id') ? 'display:block;' : 'display:none;' }}">
        El número de identidad no es válido. {{-- More general error message --}}
    </div>
</div>

{{-- You'll need a script section for the JavaScript for masking --}}
@push('scripts')
<script>
    // JavaScript for input mask (optional but highly recommended)
    document.addEventListener('DOMContentLoaded', function() {
        const numeroIdInput = document.getElementById('numero_id');

        numeroIdInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, ''); // Remove non-digits
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue += value.substring(0, 4);
            }
            if (value.length > 4) {
                formattedValue += '-' + value.substring(4, 8);
            }
            if (value.length > 8) {
                formattedValue += '-' + value.substring(8, 13);
            }
            e.target.value = formattedValue;
        });

        // Ensure the general invalid-feedback is hidden if Laravel error takes over
        @if ($errors->has('numero_id'))
            document.getElementById('numero_id-feedback').style.display = 'none';
        @endif
    });
</script>
@endpush

                            {{-- Número de Teléfono --}}
                            <div class="mb-3 col-md-6">
                                <label for="numero_telefono" class="form-label">Número de Teléfono:</label>
                                <input type="text" class="form-control @error('numero_telefono') is-invalid @enderror"
                                    id="numero_telefono" name="numero_telefono"
                                    value="{{ old('numero_telefono', $cliente->numero_telefono ?? '') }}" required
                                    maxlength="8" placeholder="Ej: 00000000" />
                                @error('numero_telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Correo Electrónico --}}
                            <div class="mb-3 col-md-6">
                                <label for="correo_electronico" class="form-label">Correo Electrónico:</label>
                                <input type="email"
                                    class="form-control @error('correo_electronico') is-invalid @enderror"
                                    id="correo_electronico" name="correo_electronico"
                                    value="{{ old('correo_electronico', $cliente->correo_electronico ?? '') }}" required
                                    maxlength="40" placeholder="Ej: correo@ejemplo.com" />
                                @error('correo_electronico')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dirección del Cliente --}}
                            <div class="mb-3 col-md-6">
    <label for="direccion_cliente" class="form-label">Dirección del Cliente:</label>
    <input type="text"
        class="form-control @error('direccion_cliente') is-invalid @enderror"
        id="direccion_cliente"
        name="direccion_cliente"
        value="{{ old('direccion_cliente', $cliente->direccion_cliente ?? '') }}"
        required
        maxlength="255" {{-- Changed from 80 to 255 for more space --}}
        placeholder="Ej: Col. Las Brisas, Calle Principal #123" />
    @error('direccion_cliente')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                            <div class="mb-3 col-md-6">
    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
    <input
        type="date"
        class="form-control @error('fecha_ingreso') is-invalid @enderror"
        id="fecha_ingreso"
        name="fecha_ingreso"
        required
        {{-- Set min/max dates if needed, e.g., cannot be in the future --}}
        {{-- max="{{ now()->toDateString() }}" --}}
        value="{{ old('fecha_ingreso', isset($cliente) ? $cliente->fecha_ingreso : now()->toDateString()) }}"
    >
    <div class="invalid-feedback">
        @error('fecha_ingreso')
            {{ $message }}
        @else
            Por favor, seleccione la fecha de ingreso.
        @enderror
    </div>
</div>

                            {{-- Sexo --}}
                            <div class="mb-3 col-md-6">
                                <label for="sexo" class="form-label">Sexo:</label>
                                <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo"
                                    required>
                                    <option value="">Seleccione el sexo...</option>
                                    <option value="Masculino"
                                        {{ old('sexo', $cliente->sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino
                                    </option>
                                    <option value="Femenino"
                                        {{ old('sexo', $cliente->sexo ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino
                                    </option>
                                    <option value="Otro" {{ old('sexo', $cliente->sexo ?? '') == 'Otro' ? 'selected' : '' }}>
                                        Otro</option>
                                </select>
                                @error('sexo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="reset" class="btn btn-secondary">Limpiar</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.history.back();">Volver</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formCliente');
            const numeroIdInput = document.getElementById('numero_id');
            const numeroIdFeedback = document.getElementById('numero_id-feedback');

            // Función para formatear el DNI hondureño con guiones
            function formatNumeroId(inputElement) {
                let value = inputElement.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
                let formattedValue = '';
                if (value.length > 0) {
                    if (value.length > 4) {
                        formattedValue = value.substring(0, 4) + '-';
                        if (value.length > 8) {
                            formattedValue += value.substring(4, 8) + '-';
                            formattedValue += value.substring(8, Math.min(value.length, 13)); // Limitar a 13 dígitos
                        } else {
                            formattedValue += value.substring(4);
                        }
                    } else {
                        formattedValue = value;
                    }
                }
                inputElement.value = formattedValue;
            }

            // Función simplificada para validar el DNI hondureño (solo formato, la lógica completa en backend)
            function isValidHonduranIDFormat(dni) {
                dni = dni.replace(/-/g, ''); // Eliminar guiones para la validación
                return /^\d{13}$/.test(dni); // Debe tener exactamente 13 dígitos
            }

            // Event listener para el input de Número de Identidad (formato y validación básica)
            numeroIdInput.addEventListener('input', function() {
                formatNumeroId(this); // Aplicar formato mientras el usuario escribe
                const cleanNumeroId = this.value.replace(/\D/g, ''); // Solo dígitos para validación

                // Limpiar estado de validación previo
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                    numeroIdFeedback.style.display = 'none';
                }
                if (this.classList.contains('is-valid')) {
                    this.classList.remove('is-valid');
                }

                if (cleanNumeroId.length > 0 && cleanNumeroId.length < 13) {
                    this.classList.add('is-invalid');
                    // Corrected feedback message for insufficient digits
                    numeroIdFeedback.textContent = 'El número de identidad es invalido.';
                    numeroIdFeedback.style.display = 'block';
                } else if (cleanNumeroId.length === 13) {
                    if (!isValidHonduranIDFormat(cleanNumeroId)) {
                        this.classList.add('is-invalid');
                        // Corrected feedback message for invalid format
                        numeroIdFeedback.textContent = 'El número de identidad no tiene un formato válido (Ej: 0000-0000-00000).';
                        numeroIdFeedback.style.display = 'block';
                    } else {
                        this.classList.add('is-valid');
                    }
                }
            });

            // Aplicar formato al cargar la página si el campo está pre-llenado
            if (numeroIdInput.value) {
                formatNumeroId(numeroIdInput);
                const cleanNumeroId = numeroIdInput.value.replace(/\D/g, '');
                if (cleanNumeroId.length === 13 && isValidHonduranIDFormat(cleanNumeroId)) {
                    numeroIdInput.classList.add('is-valid');
                } else {
                    numeroIdInput.classList.add('is-invalid');
                    // Corrected feedback message for invalid format on load
                    numeroIdFeedback.textContent = 'El número de identidad no tiene un formato válido (Ej: 0000-0000-00000).';
                    numeroIdFeedback.style.display = 'block';
                }
            }


            // Validación al enviar el formulario (complementaria a la de Laravel)
            form.addEventListener('submit', function(event) {
                // Eliminar clases de validación previas para una nueva comprobación
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

                let formIsValid = true;

                // Validar Nombre Completo
                const nombreCompletoInput = document.getElementById('nombre_completo');
                const nombreCompleto = nombreCompletoInput.value.trim();
                const regexNombreCompleto = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
                if (nombreCompleto.length === 0 || nombreCompleto.length > 50 || !regexNombreCompleto.test(nombreCompleto)) {
                    nombreCompletoInput.classList.add('is-invalid');
                    // No necesitamos un feedback específico aquí porque Laravel lo manejará.
                    formIsValid = false;
                } else {
                    nombreCompletoInput.classList.add('is-valid');
                }

                // Validar Número de Identidad
                const cleanNumeroId = numeroIdInput.value.replace(/\D/g, '');
                if (cleanNumeroId.length === 0) {
                    numeroIdInput.classList.add('is-invalid');
                    numeroIdFeedback.textContent = 'El número de identidad es requerido.';
                    numeroIdFeedback.style.display = 'block';
                    formIsValid = false;
                } else if (cleanNumeroId.length !== 13) {
                    numeroIdInput.classList.add('is-invalid');
                    // Corrected feedback message for insufficient digits on submit
                    numeroIdFeedback.textContent = 'El número de identidad invalido.';
                    numeroIdFeedback.style.display = 'block';
                    formIsValid = false;
                } else if (!isValidHonduranIDFormat(cleanNumeroId)) {
                    numeroIdInput.classList.add('is-invalid');
                    // Corrected feedback message for invalid format on submit
                    numeroIdFeedback.textContent = 'El número de identidad no tiene un formato válido (Ej: 0000-0000-00000).';
                    numeroIdFeedback.style.display = 'block';
                    formIsValid = false;
                } else {
                    // Si pasa el formato básico de cliente, añadir is-valid. La validación real la hace el backend.
                    numeroIdInput.classList.add('is-valid');
                }


                // Validar Número de Teléfono
                const numeroTelefonoInput = document.getElementById('numero_telefono');
                const numeroTelefono = numeroTelefonoInput.value.trim();
                const regexNumeroTelefono = /^\d{8}$/;
                if (numeroTelefono.length === 0 || !regexNumeroTelefono.test(numeroTelefono)) {
                    numeroTelefonoInput.classList.add('is-invalid');
                    formIsValid = false;
                } else {
                    numeroTelefonoInput.classList.add('is-valid');
                }

                // Validar Correo Electrónico
                const correoElectronicoInput = document.getElementById('correo_electronico');
                const correoElectronico = correoElectronicoInput.value.trim();
                const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (correoElectronico.length === 0 || !regexCorreo.test(correoElectronico) || correoElectronico.length > 40) {
                    correoElectronicoInput.classList.add('is-invalid');
                    formIsValid = false;
                } else {
                    correoElectronicoInput.classList.add('is-valid');
                }

                // Validar Dirección del Cliente
                const direccionClienteInput = document.getElementById('direccion_cliente');
                const direccionCliente = direccionClienteInput.value.trim();
                if (direccionCliente.length === 0 || direccionCliente.length > 80) {
                    direccionClienteInput.classList.add('is-invalid');
                    formIsValid = false;
                } else {
                    direccionClienteInput.classList.add('is-valid');
                }

                // Validar Sexo
                const sexoInput = document.getElementById('sexo');
                if (!sexoInput.value) {
                    sexoInput.classList.add('is-invalid');
                    formIsValid = false;
                } else {
                    sexoInput.classList.add('is-valid');
                }

                if (!formIsValid) {
                    event.preventDefault(); // Detener el envío si hay errores de JS
                } else {
                    // Si todo es válido en el frontend, el formulario se enviará y Laravel validará en el backend.
                }
            });

            // Limpiar el estado de validación al escribir en los campos
            ['nombre_completo', 'numero_telefono', 'correo_electronico', 'direccion_cliente', 'sexo'].forEach(id => {
                const el = document.getElementById(id);
                el.addEventListener('input', () => {
                    if (el.classList.contains('is-invalid') || el.classList.contains('is-valid')) {
                        el.classList.remove('is-invalid', 'is-valid');
                        // Solo ocultamos el feedback específico del DNI, los demás son manejados por Laravel.
                        if (id === 'numero_id') {
                             document.getElementById('numero_id-feedback').style.display = 'none';
                        }
                    }
                });
                // Para el select de sexo, usar 'change' en lugar de 'input'
                if (id === 'sexo') {
                    el.addEventListener('change', () => {
                        if (el.classList.contains('is-invalid') || el.classList.contains('is-valid')) {
                            el.classList.remove('is-invalid', 'is-valid');
                        }
                    });
                }
            });

            // Restringir a solo números para numero_telefono
            document.getElementById('numero_telefono').addEventListener('input', e => {
                let val = e.target.value.replace(/\D/g, ''); // Eliminar todos los no dígitos
                e.target.value = val;
            });

            // Eliminar espacios iniciales y números iniciales para campos de texto
            ['nombre_completo', 'direccion_cliente'].forEach(id => {
                const el = document.getElementById(id);
                el.addEventListener('input', () => {
                    el.value = el.value.replace(/^\s+/, ''); // Eliminar espacios iniciales
                    if (/^\d/.test(el.value)) { // Eliminar números iniciales
                        el.value = el.value.replace(/^\d+/, '');
                    }
                });
            });
        });
    </script>
</body>

</html>