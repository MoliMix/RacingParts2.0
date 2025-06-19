<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Proveedor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
            /* Se eliminan: min-height, display: flex, align-items, justify-content, padding para no interferir con layout.app */
        }

        .form-container {
            background-color: #1e1e1e;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
            width: 100%;
            max-width: 950px; /* Ancho máximo aumentado, según tu solicitud */
            margin: 2rem auto; /* Añadir margen automático para centrar horizontalmente */
        }

        .form-label {
            color: #ccc;
        }

        .form-control, .form-select, textarea { /* Añadido textarea aquí para consistencia */
            background-color: #2c2c2c;
            border: none;
            color: #fff;
        }

        .form-control:focus, .form-select:focus, textarea:focus { /* Añadido textarea aquí */
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

        /* Estilos para los botones Limpiar y Cancelar (si tu layout.app no los maneja) */
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }


        h2 {
            color: #e0e0e0;
            text-align: center; /* Restaurado: centrar el título H2 */
        }

        /* Estilos para los mensajes de validación (esenciales) */
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .form-control.is-invalid ~ .invalid-feedback,
        .form-select.is-invalid ~ .invalid-feedback,
        textarea.is-invalid ~ .invalid-feedback {
            display: block;
        }

        /* Estilos para Select2 (esenciales para el tema oscuro) */
        .select2-container--default .select2-selection--multiple {
            background-color: #2c2c2c !important;
            border: none !important;
            border-radius: .375rem !important;
            padding: .375rem .75rem !important;
            min-height: calc(1.5em + .75rem + 2px);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: .2rem;
            padding: .2rem .5rem;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ddd;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #4caf50 !important;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: #fff;
        }
        .select2-dropdown {
            background-color: #2c2c2c;
            border: none;
            color: #fff;
        }
        .select2-results__option {
            color: #fff;
        }
        .select2-results__option--highlighted {
            background-color: #4caf50 !important;
            color: white !important;
        }
        .select2-search__field {
            background-color: #1e1e1e !important;
            color: #fff !important;
            border-color: #4caf50 !important;
        }
        /* Estilos para Select2 cuando está inválido (esenciales) */
        .is-invalid-select2 {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem) !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(0.375em + 0.1875rem) center !important;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <h2 class="mb-4">Registrar nuevo proveedor</h2>

                {{-- Mensajes de éxito y error de sesión --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="formProveedor" action="{{ route('proveedores.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_empresa" class="form-label">Nombre de la empresa *</label>
                            <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror"
                                   id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa') }}" required maxlength="30">
                            <div class="invalid-feedback" id="nombre_empresa-feedback">
                                @error('nombre_empresa')
                                    {{ $message }}
                                @else
                                    Este campo es obligatorio.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pais_origen" class="form-label">País de origen *</label>
                            <select class="form-select @error('pais_origen') is-invalid @enderror"
                                    id="pais_origen" name="pais_origen" required>
                                <option value="">Seleccione un país...</option>
                                {{-- Los países se generarán dinámicamente en el script JS --}}
                                @foreach($countries ?? [] as $code => $country)
                                    <option value="{{ $country['name'] }}" data-phone-code="{{ $country['phone_code'] }}" {{ old('pais_origen') == $country['name'] ? 'selected' : '' }}>
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="pais_origen-feedback">
                                @error('pais_origen')
                                    {{ $message }}
                                @else
                                    Por favor, seleccione el país de origen.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="persona_contacto" class="form-label">Persona de contacto *</label>
                            <input type="text" class="form-control @error('persona_contacto') is-invalid @enderror"
                                   id="persona_contacto" name="persona_contacto" value="{{ old('persona_contacto') }}"
                                   title="Solo se permiten letras y espacios" required maxlength="32">
                            <div class="invalid-feedback" id="persona_contacto-feedback">
                                @error('persona_contacto')
                                    {{ $message }}
                                @else
                                    Este campo es obligatorio.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo_electronico" class="form-label">Correo electrónico *</label>
                            <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror"
                                   id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}" required maxlength="30">
                            <div class="invalid-feedback" id="correo_electronico-feedback">
                                @error('correo_electronico')
                                    {{ $message }}
                                @else
                                    Este campo es obligatorio y debe ser un correo válido .
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono_contacto" class="form-label">Teléfono de contacto *</label>
                            <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror"
                                   id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto') }}"
                                   maxlength="12" required placeholder="Ej: +504XXXXXXXX">
                            <div class="invalid-feedback" id="telefono_contacto-feedback">
                                @error('telefono_contacto')
                                    {{ $message }}
                                @else
                                    Este campo es obligatorio .
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección *</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror"
                                      id="direccion" name="direccion" required maxlength="150" rows="3">{{ old('direccion') }}</textarea>
                            <div class="invalid-feedback" id="direccion-feedback">
                                @error('direccion')
                                    {{ $message }}
                                @else
                                    Este campo es obligatorio.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="marcas" class="form-label">Marcas que maneja *</label>
                            <select class="form-select @error('marcas') is-invalid @enderror"
                                    id="marcas" name="marcas[]" multiple required>
                                <option value="">Seleccione marcas...</option>
                                <option value="Toyota" {{ in_array('Toyota', old('marcas', [])) ? 'selected' : '' }}>Toyota</option>
                                <option value="Honda" {{ in_array('Honda', old('marcas', [])) ? 'selected' : '' }}>Honda</option>
                                <option value="Nissan" {{ in_array('Nissan', old('marcas', [])) ? 'selected' : '' }}>Nissan</option>
                                <option value="Mazda" {{ in_array('Mazda', old('marcas', [])) ? 'selected' : '' }}>Mazda</option>
                                <option value="Mitsubishi" {{ in_array('Mitsubishi', old('marcas', [])) ? 'selected' : '' }}>Mitsubishi</option>
                                <option value="Suzuki" {{ in_array('Suzuki', old('marcas', [])) ? 'selected' : '' }}>Suzuki</option>
                                <option value="Hyundai" {{ in_array('Hyundai', old('marcas', [])) ? 'selected' : '' }}>Hyundai</option>
                                <option value="Kia" {{ in_array('Kia', old('Kia', [])) ? 'selected' : '' }}>Kia</option>
                                <option value="Ford" {{ in_array('Ford', old('marcas', [])) ? 'selected' : '' }}>Ford</option>
                                <option value="Chevrolet" {{ in_array('Chevrolet', old('marcas', [])) ? 'selected' : '' }}>Chevrolet</option>
                            </select>
                            <div class="invalid-feedback" id="marcas-feedback">
                                @error('marcas')
                                    {{ $message }}
                                @else
                                    Por favor, seleccione al menos una marca.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_autopartes" class="form-label">Tipo de Autopartes *</label>
                            <select class="form-select @error('tipo_autopartes') is-invalid @enderror"
                                    id="tipo_autopartes" name="tipo_autopartes[]" multiple required>
                                <option value="">Seleccione tipos de autopartes...</option>
                                <option value="Motor" {{ in_array('Motor', old('tipo_autopartes', [])) ? 'selected' : '' }}>Motor</option>
                                <option value="Transmisión" {{ in_array('Transmisión', old('tipo_autopartes', [])) ? 'selected' : '' }}>Transmisión</option>
                                <option value="Suspensión" {{ in_array('Suspensión', old('tipo_autopartes', [])) ? 'selected' : '' }}>Suspensión</option>
                                <option value="Frenos" {{ in_array('Frenos', old('tipo_autopartes', [])) ? 'selected' : '' }}>Frenos</option>
                                <option value="Eléctrico" {{ in_array('Eléctrico', old('tipo_autopartes', [])) ? 'selected' : '' }}>Eléctrico</option>
                                <option value="Carrocería" {{ in_array('Carrocería', old('carroceria', [])) ? 'selected' : '' }}>Carrocería</option>
                                <option value="Interior" {{ in_array('Interior', old('interior', [])) ? 'selected' : '' }}>Interior</option>
                                <option value="Accesorios" {{ in_array('Accesorios', old('accesorios', [])) ? 'selected' : '' }}>Accesorios</option>
                            </select>
                            <div class="invalid-feedback" id="tipo_autopartes-feedback">
                                @error('tipo_autopartes')
                                    {{ $message }}
                                @else
                                    Por favor, seleccione al menos un tipo de autoparte.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="persona_contacto_secundaria" class="form-label">Persona de Contacto Secundaria</label>
                            <input type="text" class="form-control @error('persona_contacto_secundaria') is-invalid @enderror"
                                   id="persona_contacto_secundaria" name="persona_contacto_secundaria"
                                   value="{{ old('persona_contacto_secundaria') }}" maxlength="32">
                            <div class="invalid-feedback" id="persona_contacto_secundaria-feedback">
                                @error('persona_contacto_secundaria')
                                    {{ $message }}
                                @else
                                    Solo se permiten letras y espacios, máximo 32 caracteres.
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono_contacto_secundario" class="form-label">Teléfono de Contacto Secundario</label>
                            <input type="text" class="form-control @error('telefono_contacto_secundario') is-invalid @enderror"
                                   id="telefono_contacto_secundario" name="telefono_contacto_secundario"
                                   value="{{ old('telefono_contacto_secundario') }}" maxlength="12" placeholder="Ej: +504XXXXXXXX">
                            <div class="invalid-feedback" id="telefono_contacto_secundario-feedback">
                                @error('telefono_contacto_secundario')
                                    {{ $message }}
                                @else
                                    Este campo es obligatorio.
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Registrar Proveedor</button>
                        <button type="button" class="btn btn-secondary" id="limpiarFormulario">Limpiar</button>
                        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- CDN de Bootstrap JS (para funcionalidades interactivas de Bootstrap) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- jQuery (necesario para Select2) --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formProveedor');
    const nombreEmpresaInput = document.getElementById('nombre_empresa');
    const personaContactoInput = document.getElementById('persona_contacto');
    const telefonoContactoInput = document.getElementById('telefono_contacto');
    const correoInput = document.getElementById('correo_electronico');
    const direccionTextarea = document.getElementById('direccion');
    const paisOrigenSelect = document.getElementById('pais_origen');
    const marcasSelect = document.getElementById('marcas');
    const tipoAutopartesSelect = document.getElementById('tipo_autopartes');
    const personaContactoSecundariaInput = document.getElementById('persona_contacto_secundaria');
    const telefonoContactoSecundarioInput = document.getElementById('telefono_contacto_secundario');

    // --- PAÍSES (Asegúrate de que 'countries' esté definido, ya sea inyectado por Laravel o JS) ---
    // Si 'countries' no viene de Laravel, defínelo aquí completamente:
    const countries = [
        { "name": "Albania", "phone_code": "+355" },
        { "name": "Algeria", "phone_code": "+213" },
        { "name": "Andorra", "phone_code": "+376" },
        { "name": "Angola", "phone_code": "+244" },
        { "name": "Antigua and Barbuda", "phone_code": "+1-268" },
        { "name": "Argentina", "phone_code": "+54" },
        { "name": "Armenia", "phone_code": "+374" },
        { "name": "Australia", "phone_code": "+61" },
        { "name": "Austria", "phone_code": "+43" },
        { "name": "Azerbaijan", "phone_code": "+994" },
        { "name": "Bahamas", "phone_code": "+1-242" },
        { "name": "Bahrain", "phone_code": "+973" },
        { "name": "Bangladesh", "phone_code": "+880" },
        { "name": "Barbados", "phone_code": "+1-246" },
        { "name": "Belarus", "phone_code": "+375" },
        { "name": "Belgium", "phone_code": "+32" },
        { "name": "Belize", "phone_code": "+501" },
        { "name": "Benin", "phone_code": "+229" },
        { "name": "Bhutan", "phone_code": "+975" },
        { "name": "Bolivia", "phone_code": "+591" },
        { "name": "Bosnia and Herzegovina", "phone_code": "+387" },
        { "name": "Botswana", "phone_code": "+267" },
        { "name": "Brazil", "phone_code": "+55" },
        { "name": "Brunei", "phone_code": "+673" },
        { "name": "Bulgaria", "phone_code": "+359" },
        { "name": "Burkina Faso", "phone_code": "+226" },
        { "name": "Burundi", "phone_code": "+257" },
        { "name": "Cabo Verde", "phone_code": "+238" },
        { "name": "Cambodia", "phone_code": "+855" },
        { "name": "Cameroon", "phone_code": "+237" },
        { "name": "Canada", "phone_code": "+1" },
        { "name": "Central African Republic", "phone_code": "+236" },
        { "name": "Chad", "phone_code": "+235" },
        { "name": "Chile", "phone_code": "+56" },
        { "name": "China", "phone_code": "+86" },
        { "name": "Colombia", "phone_code": "+57" },
        { "name": "Comoros", "phone_code": "+269" },
        { "name": "Congo (Brazzaville)", "phone_code": "+242" },
        { "name": "Congo (Kinshasa)", "phone_code": "+243" },
        { "name": "Costa Rica", "phone_code": "+506" },
        { "name": "Croatia", "phone_code": "+385" },
        { "name": "Cuba", "phone_code": "+53" },
        { "name": "Cyprus", "phone_code": "+357" },
        { "name": "Czechia", "phone_code": "+420" },
        { "name": "Denmark", "phone_code": "+45" },
        { "name": "Djibouti", "phone_code": "+253" },
        { "name": "Dominica", "phone_code": "+1-767" },
        { "name": "Dominican Republic", "phone_code": "+1-809, +1-829, +1-849" },
        { "name": "Ecuador", "phone_code": "+593" },
        { "name": "Egypt", "phone_code": "+20" },
        { "name": "El Salvador", "phone_code": "+503" },
        { "name": "Equatorial Guinea", "phone_code": "+240" },
        { "name": "Eritrea", "phone_code": "+291" },
        { "name": "Estonia", "phone_code": "+372" },
        { "name": "Eswatini", "phone_code": "+268" },
        { "name": "Ethiopia", "phone_code": "+251" },
        { "name": "Fiji", "phone_code": "+679" },
        { "name": "Finland", "phone_code": "+358" },
        { "name": "France", "phone_code": "+33" },
        { "name": "Gabon", "phone_code": "+241" },
        { "name": "Gambia", "phone_code": "+220" },
        { "name": "Georgia", "phone_code": "+995" },
        { "name": "Germany", "phone_code": "+49" },
        { "name": "Ghana", "phone_code": "+233" },
        { "name": "Greece", "phone_code": "+30" },
        { "name": "Grenada", "phone_code": "+1-473" },
        { "name": "Guatemala", "phone_code": "+502" },
        { "name": "Guinea", "phone_code": "+224" },
        { "name": "Guinea-Bissau", "phone_code": "+245" },
        { "name": "Guyana", "phone_code": "+592" },
        { "name": "Haiti", "phone_code": "+509" },
        { "name": "Honduras", "phone_code": "+504" },
        { "name": "Hungary", "phone_code": "+36" },
        { "name": "Iceland", "phone_code": "+354" },
        { "name": "India", "phone_code": "+91" },
        { "name": "Indonesia", "phone_code": "+62" },
        { "name": "Iran", "phone_code": "+98" },
        { "name": "Iraq", "phone_code": "+964" },
        { "name": "Ireland", "phone_code": "+353" },
        { "name": "Israel", "phone_code": "+972" },
        { "name": "Italy", "phone_code": "+39" },
        { "name": "Jamaica", "phone_code": "+1-876" },
        { "name": "Japan", "phone_code": "+81" },
        { "name": "Jordan", "phone_code": "+962" },
        { "name": "Kazakhstan", "phone_code": "+7" },
        { "name": "Kenya", "phone_code": "+254" },
        { "name": "Kiribati", "phone_code": "+686" },
        { "name": "Kuwait", "phone_code": "+965" },
        { "name": "Kyrgyzstan", "phone_code": "+996" },
        { "name": "Laos", "phone_code": "+856" },
        { "name": "Latvia", "phone_code": "+371" },
        { "name": "Lebanon", "phone_code": "+961" },
        { "name": "Lesotho", "phone_code": "+266" },
        { "name": "Liberia", "phone_code": "+231" },
        { "name": "Libya", "phone_code": "+218" },
        { "name": "Liechtenstein", "phone_code": "+423" },
        { "name": "Lithuania", "phone_code": "+370" },
        { "name": "Luxembourg", "phone_code": "+352" },
        { "name": "Madagascar", "phone_code": "+261" },
        { "name": "Malawi", "phone_code": "+265" },
        { "name": "Malaysia", "phone_code": "+60" },
        { "name": "Maldives", "phone_code": "+960" },
        { "name": "Mali", "phone_code": "+223" },
        { "name": "Malta", "phone_code": "+356" },
        { "name": "Marshall Islands", "phone_code": "+692" },
        { "name": "Mauritania", "phone_code": "+222" },
        { "name": "Mauritius", "phone_code": "+230" },
        { "name": "Mexico", "phone_code": "+52" },
        { "name": "Micronesia", "phone_code": "+691" },
        { "name": "Moldova", "phone_code": "+373" },
        { "name": "Monaco", "phone_code": "+377" },
        { "name": "Mongolia", "phone_code": "+976" },
        { "name": "Montenegro", "phone_code": "+382" },
        { "name": "Morocco", "phone_code": "+212" },
        { "name": "Mozambique", "phone_code": "+258" },
        { "name": "Myanmar", "phone_code": "+95" },
        { "name": "Namibia", "phone_code": "+264" },
        { "name": "Nauru", "phone_code": "+674" },
        { "name": "Nepal", "phone_code": "+977" },
        { "name": "Netherlands", "phone_code": "+31" },
        { "name": "New Zealand", "phone_code": "+64" },
        { "name": "Nicaragua", "phone_code": "+505" },
        { "name": "Niger", "phone_code": "+227" },
        { "name": "Nigeria", "phone_code": "+234" },
        { "name": "North Korea", "phone_code": "+850" },
        { "name": "North Macedonia", "phone_code": "+389" },
        { "name": "Norway", "phone_code": "+47" },
        { "name": "Oman", "phone_code": "+968" },
        { "name": "Pakistan", "phone_code": "+92" },
        { "name": "Palau", "phone_code": "+680" },
        { "name": "Palestine State", "phone_code": "+970" },
        { "name": "Panama", "phone_code": "+507" },
        { "name": "Papua New Guinea", "phone_code": "+675" },
        { "name": "Paraguay", "phone_code": "+595" },
        { "name": "Peru", "phone_code": "+51" },
        { "name": "Philippines", "phone_code": "+63" },
        { "name": "Poland", "phone_code": "+48" },
        { "name": "Portugal", "phone_code": "+351" },
        { "name": "Qatar", "phone_code": "+974" },
        { "name": "Romania", "phone_code": "+40" },
        { "name": "Russia", "phone_code": "+7" },
        { "name": "Rwanda", "phone_code": "+250" },
        { "name": "Saint Kitts and Nevis", "phone_code": "+1-869" },
        { "name": "Saint Lucia", "phone_code": "+1-758" },
        { "name": "Saint Vincent and the Grenadines", "phone_code": "+1-784" },
        { "name": "Samoa", "phone_code": "+685" },
        { "name": "San Marino", "phone_code": "+378" },
        { "name": "Sao Tome and Principe", "phone_code": "+239" },
        { "name": "Saudi Arabia", "phone_code": "+966" },
        { "name": "Senegal", "phone_code": "+221" },
        { "name": "Serbia", "phone_code": "+381" },
        { "name": "Seychelles", "phone_code": "+248" },
        { "name": "Sierra Leone", "phone_code": "+232" },
        { "name": "Singapore", "phone_code": "+65" },
        { "name": "Slovakia", "phone_code": "+421" },
        { "name": "Slovenia", "phone_code": "+386" },
        { "name": "Solomon Islands", "phone_code": "+677" },
        { "name": "Somalia", "phone_code": "+252" },
        { "name": "South Africa", "phone_code": "+27" },
        { "name": "South Korea", "phone_code": "+82" },
        { "name": "South Sudan", "phone_code": "+211" },
        { "name": "Spain", "phone_code": "+34" },
        { "name": "Sri Lanka", "phone_code": "+94" },
        { "name": "Sudan", "phone_code": "+249" },
        { "name": "Suriname", "phone_code": "+597" },
        { "name": "Sweden", "phone_code": "+46" },
        { "name": "Switzerland", "phone_code": "+41" },
        { "name": "Syria", "phone_code": "+963" },
        { "name": "Taiwan", "phone_code": "+886" },
        { "name": "Tajikistan", "phone_code": "+992" },
        { "name": "Tanzania", "phone_code": "+255" },
        { "name": "Thailand", "phone_code": "+66" },
        { "name": "Timor-Leste", "phone_code": "+670" },
        { "name": "Togo", "phone_code": "+228" },
        { "name": "Tonga", "phone_code": "+676" },
        { "name": "Trinidad and Tobago", "phone_code": "+1-868" },
        { "name": "Tunisia", "phone_code": "+216" },
        { "name": "Turkey", "phone_code": "+90" },
        { "name": "Turkmenistan", "phone_code": "+993" },
        { "name": "Tuvalu", "phone_code": "+688" },
        { "name": "Uganda", "phone_code": "+256" },
        { "name": "Ukraine", "phone_code": "+380" },
        { "name": "United Arab Emirates", "phone_code": "+971" },
        { "name": "United Kingdom", "phone_code": "+44" },
        { "name": "United States", "phone_code": "+1" },
        { "name": "Uruguay", "phone_code": "+598" },
        { "name": "Uzbekistan", "phone_code": "+998" },
        { "name": "Vanuatu", "phone_code": "+678" },
        { "name": "Venezuela", "phone_code": "+58" },
        { "name": "Vietnam", "phone_code": "+84" },
        { "name": "Yemen", "phone_code": "+967" },
        { "name": "Zambia", "phone_code": "+260" },
        { "name": "Zimbabwe", "phone_code": "+263" }

    ];

    // Función para poblar el select de países (si no está ya poblado por Blade)
    function populateCountries() {
        // Solo poblar si no hay opciones cargadas por Blade (excepto la placeholder)
        if (paisOrigenSelect.options.length <= 1 || paisOrigenSelect.querySelector('option[value=""]')) {
            const currentSelectedValue = paisOrigenSelect.value; // Guardar valor seleccionado
            paisOrigenSelect.innerHTML = ''; // Limpiar opciones existentes
            const placeholderOption = document.createElement('option');
            placeholderOption.value = '';
            placeholderOption.textContent = 'Seleccione un país...';
            paisOrigenSelect.appendChild(placeholderOption);

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = country.name;
                option.setAttribute('data-phone-code', country.phone_code);
                if (currentSelectedValue === country.name) {
                    option.selected = true; // Restaurar selección
                }
                paisOrigenSelect.appendChild(option);
            });
        }
    }
    populateCountries(); // Llama para asegurar que los países estén ahí.


    // Inicialización de Select2 para campos multi-select
    $('#marcas, #tipo_autopartes').select2({
        theme: 'default',
        width: '100%',
        placeholder: 'Seleccione las opciones',
        allowClear: true // Permite deseleccionar todas las opciones
    });

    // Evento change para el selector de país para actualizar el código telefónico
    paisOrigenSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const phoneCode = selectedOption ? selectedOption.getAttribute('data-phone-code') : '';

        const updatePhoneNumberField = (inputElement, code) => {
            let currentValue = inputElement.value.trim();
            // Si el valor actual es solo un signo '+' o vacío, o no empieza con el nuevo código, se actualiza
            if (!currentValue || currentValue === '+' || !currentValue.startsWith(code)) {
                inputElement.value = code;
            }
            // Asegurarse de que el cursor esté al final del código
            // Solo si el campo no está vacío después de la actualización (para no poner el cursor en un campo vacío)
            if (inputElement.value) {
                inputElement.setSelectionRange(inputElement.value.length, inputElement.value.length);
            }
        };

        updatePhoneNumberField(telefonoContactoInput, phoneCode);
        updatePhoneNumberField(telefonoContactoSecundarioInput, phoneCode);
        // Disparar evento input para que la validación en tiempo real de formato de teléfono se actualice
        telefonoContactoInput.dispatchEvent(new Event('input'));
        telefonoContactoSecundarioInput.dispatchEvent(new Event('input'));
    });

    // Disparar el cambio de país al cargar si ya hay un valor seleccionado (útil con old())
    if (paisOrigenSelect.value) {
        paisOrigenSelect.dispatchEvent(new Event('change'));
    }

    // --- PREVENCIÓN DE ENTRADA EN TIEMPO REAL (Más estricta) ---

    // Nombre de Empresa: Limitar a 30 caracteres.
    nombreEmpresaInput.addEventListener('input', function() {
        if (this.value.length > 30) {
            this.value = this.value.substring(0, 30);
        }
    });

    // Persona de Contacto: Solo letras, espacios, y tildes/ñ, hasta 32 caracteres.
    const regexSoloLetrasEspacios = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;
    personaContactoInput.addEventListener('input', function() {
        let value = this.value;
        const originalSelectionStart = this.selectionStart;
        const originalSelectionEnd = this.selectionEnd;

        // Filtra caracteres no permitidos
        let filteredValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');

        // Limita la longitud
        if (filteredValue.length > 32) {
            filteredValue = filteredValue.substring(0, 32);
        }

        if (this.value !== filteredValue) {
            this.value = filteredValue;
            // Ajusta la posición del cursor si los caracteres fueron eliminados
            this.setSelectionRange(originalSelectionStart - (value.length - filteredValue.length), originalSelectionEnd - (value.length - filteredValue.length));
        }
    });
    personaContactoSecundariaInput.addEventListener('input', function() {
        let value = this.value;
        const originalSelectionStart = this.selectionStart;
        const originalSelectionEnd = this.selectionEnd;

        // Filtra caracteres no permitidos
        let filteredValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');

        // Limita la longitud
        if (filteredValue.length > 32) {
            filteredValue = filteredValue.substring(0, 32);
        }

        if (this.value !== filteredValue) {
            this.value = filteredValue;
            // Ajusta la posición del cursor si los caracteres fueron eliminados
            this.setSelectionRange(originalSelectionStart - (value.length - filteredValue.length), originalSelectionEnd - (value.length - filteredValue.length));
        }
    });

    // Teléfono: Solo números y un '+' inicial. Máx 12 caracteres.
    const restrictPhoneInput = (inputElement) => {
        inputElement.addEventListener('input', function (e) {
            let value = e.target.value;
            let startWithPlus = value.startsWith('+');

            // Elimina todo lo que no sea dígito o el primer '+'
            value = value.replace(/[^\d+]/g, '');
            if (startWithPlus && value[0] !== '+') {
                value = '+' + value;
            } else if (!startWithPlus && value.startsWith('+')) { // Si tenía '+' pero no se inició con él, quítalo
                value = value.substring(1);
            }

            // Limita a 12 caracteres (incluyendo el '+')
            if (value.length > 12) {
                value = value.substring(0, 12);
            }
            e.target.value = value;
        });
    };
    restrictPhoneInput(telefonoContactoInput);
    restrictPhoneInput(telefonoContactoSecundarioInput);


    // Correo: Limitar a 30 caracteres.
    correoInput.addEventListener('input', function() {
        if (this.value.length > 30) {
            this.value = this.value.substring(0, 30);
        }
    });

    // Dirección: Limitar a 150 caracteres.
    direccionTextarea.addEventListener('input', function() {
        if (this.value.length > 150) {
            this.value = this.value.substring(0, 150);
        }
    });


    // --- VALIDACIÓN EN EL ENVÍO DEL FORMULARIO (Se activa si JS permite el envío inicial) ---

    form.addEventListener('submit', function(event) {
        let formIsValid = true;

        // Limpiar mensajes de error previos (excepto los de Laravel que están marcados)
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            if (!element.dataset.laravelError) { // No ocultar si es un error de Laravel
                element.style.display = 'none';
                element.textContent = ''; // Limpiar el texto si no es de Laravel
            }
        });
        // Limpiar la clase de Select2 también
        $('.is-invalid-select2').removeClass('is-invalid-select2');


        // Validar Nombre de Empresa
        if (nombreEmpresaInput.value.trim() === '') {
            nombreEmpresaInput.classList.add('is-invalid');
            document.getElementById('nombre_empresa-feedback').textContent = 'Este campo es obligatorio.';
            document.getElementById('nombre_empresa-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar País de Origen
        if (paisOrigenSelect.value === "") {
            paisOrigenSelect.classList.add('is-invalid');
            document.getElementById('pais_origen-feedback').textContent = 'Por favor, seleccione el país de origen.';
            document.getElementById('pais_origen-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Persona de Contacto
        const personaContacto = personaContactoInput.value.trim();
        if (personaContacto === '') {
            personaContactoInput.classList.add('is-invalid');
            document.getElementById('persona_contacto-feedback').textContent = 'Este campo es obligatorio.';
            document.getElementById('persona_contacto-feedback').style.display = 'block';
            formIsValid = false;
        } else if (!regexSoloLetrasEspacios.test(personaContacto)) {
            personaContactoInput.classList.add('is-invalid');
            document.getElementById('persona_contacto-feedback').textContent = 'Solo se permiten letras y espacios.';
            document.getElementById('persona_contacto-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Correo
        const correo = correoInput.value.trim();
        const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (correo === '') {
            correoInput.classList.add('is-invalid');
            document.getElementById('correo_electronico-feedback').textContent = 'Este campo es obligatorio.';
            document.getElementById('correo_electronico-feedback').style.display = 'block';
            formIsValid = false;
        } else if (!regexCorreo.test(correo)) {
            correoInput.classList.add('is-invalid');
            document.getElementById('correo_electronico-feedback').textContent = 'Ingrese un correo electrónico válido.';
            document.getElementById('correo_electronico-feedback').style.display = 'block';
            formIsValid = false;
        } else if (correo.length > 30) {
            correoInput.classList.add('is-invalid');
            document.getElementById('correo_electronico-feedback').textContent = 'El correo no debe exceder los 30 caracteres.';
            document.getElementById('correo_electronico-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Teléfono de Contacto Principal
        const telefonoContacto = telefonoContactoInput.value.trim();
        const regexTelefonoFull = /^\+\d{7,11}$/; // + seguido de 7 a 11 dígitos, total 8 a 12 caracteres.
        if (telefonoContacto === '') {
            telefonoContactoInput.classList.add('is-invalid');
            document.getElementById('telefono_contacto-feedback').textContent = 'Este campo es obligatorio.';
            document.getElementById('telefono_contacto-feedback').style.display = 'block';
            formIsValid = false;
        } else if (!regexTelefonoFull.test(telefonoContacto)) {
            telefonoContactoInput.classList.add('is-invalid');
            document.getElementById('telefono_contacto-feedback').textContent = 'El teléfono debe incluir el código de país (ej. +504) y tener entre 8 y 12 caracteres (incluyendo el +).';
            document.getElementById('telefono_contacto-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Dirección
        if (direccionTextarea.value.trim() === '') {
            direccionTextarea.classList.add('is-invalid');
            document.getElementById('direccion-feedback').textContent = 'Este campo es obligatorio.';
            document.getElementById('direccion-feedback').style.display = 'block';
            formIsValid = false;
        } else if (direccionTextarea.value.length > 150) {
            direccionTextarea.classList.add('is-invalid');
            document.getElementById('direccion-feedback').textContent = 'La dirección no debe exceder los 150 caracteres.';
            document.getElementById('direccion-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Marcas que maneja (Select2)
        const selectedMarcas = $(marcasSelect).val();
        if (!selectedMarcas || selectedMarcas.length === 0) {
            $(marcasSelect).next('.select2-container').find('.select2-selection').addClass('is-invalid-select2'); // Clase para Select2
            document.getElementById('marcas-feedback').textContent = 'Por favor, seleccione al menos una marca.';
            document.getElementById('marcas-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Tipo de Autopartes (Select2)
        const selectedTipoAutopartes = $(tipoAutopartesSelect).val();
        if (!selectedTipoAutopartes || selectedTipoAutopartes.length === 0) {
            $(tipoAutopartesSelect).next('.select2-container').find('.select2-selection').addClass('is-invalid-select2'); // Clase para Select2
            document.getElementById('tipo_autopartes-feedback').textContent = 'Por favor, seleccione al menos un tipo de autoparte.';
            document.getElementById('tipo_autopartes-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Persona de Contacto Secundaria (Opcional, pero si se llena, validar formato y longitud)
        const personaContactoSecundaria = personaContactoSecundariaInput.value.trim();
        if (personaContactoSecundaria.length > 0 && (!regexSoloLetrasEspacios.test(personaContactoSecundaria) || personaContactoSecundaria.length > 32)) {
            personaContactoSecundariaInput.classList.add('is-invalid');
            document.getElementById('persona_contacto_secundaria-feedback').textContent = 'Solo se permiten letras y espacios, máximo 32 caracteres.';
            document.getElementById('persona_contacto_secundaria-feedback').style.display = 'block';
            formIsValid = false;
        }

        // Validar Teléfono de Contacto Secundario (Opcional, pero si se llena, validar formato y longitud)
        const telefonoContactoSecundario = telefonoContactoSecundarioInput.value.trim();
        if (telefonoContactoSecundario.length > 0 && (!regexTelefonoFull.test(telefonoContactoSecundario) || telefonoContactoSecundario.length < 8 || telefonoContactoSecundario.length > 12)) {
            telefonoContactoSecundarioInput.classList.add('is-invalid');
            document.getElementById('telefono_contacto_secundario-feedback').textContent = 'El teléfono debe incluir el código de país (ej. +504) y tener entre 8 y 12 caracteres (incluyendo el +).';
            document.getElementById('telefono_contacto_secundario-feedback').style.display = 'block';
            formIsValid = false;
        }


        if (!formIsValid) {
            event.preventDefault(); // Detener el envío si hay errores de JS
        }
    });

    // --- FUNCIONALIDAD DEL BOTÓN LIMPIAR ---
    document.getElementById('limpiarFormulario').addEventListener('click', function() {
        form.reset(); // Resetea el formulario a sus valores iniciales (old() si la página recargó)

        // Luego, asegúrate de que todos los campos relevantes estén vacíos y sin errores
        nombreEmpresaInput.value = '';
        personaContactoInput.value = '';
        correoInput.value = '';
        direccionTextarea.value = '';
        personaContactoSecundariaInput.value = '';

        // Limpiar clases de validación y ocultar mensajes de feedback
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.style.display = 'none';
            element.removeAttribute('data-laravel-error'); // Quitar marcador de error de Laravel
            // Restaurar mensajes por defecto (opcional, pero buena práctica si el contenido cambia)
            if (element.id === 'nombre_empresa-feedback') element.textContent = 'Este campo es obligatorio.';
            if (element.id === 'pais_origen-feedback') element.textContent = 'Por favor, seleccione el país de origen.';
            if (element.id === 'persona_contacto-feedback') element.textContent = 'Este campo es obligatorio y solo puede contener letras.';
            if (element.id === 'correo_electronico-feedback') element.textContent = 'Este campo es obligatorio y debe ser un correo válido.';
            if (element.id === 'telefono_contacto-feedback') element.textContent = 'Este campo es obligatorio y debe incluir el código de país (ej. +504) y tener entre 8 y 12 caracteres (incluyendo el +).';
            if (element.id === 'direccion-feedback') element.textContent = 'Este campo es obligatorio.';
            if (element.id === 'marcas-feedback') element.textContent = 'Por favor, seleccione al menos una marca.';
            if (element.id === 'tipo_autopartes-feedback') element.textContent = 'Por favor, seleccione al menos un tipo de autoparte.';
            if (element.id === 'persona_contacto_secundaria-feedback') element.textContent = 'Solo se permiten letras y espacios, máximo 32 caracteres.';
            if (element.id === 'telefono_contacto_secundario-feedback') element.textContent = 'El teléfono debe incluir el código de país (ej. +504) y tener entre 8 y 12 caracteres (incluyendo el +).';
        });

        // Limpiar Select2 manualmente y quitar clase de validación visual
        $('#marcas, #tipo_autopartes').val(null).trigger('change');
        $('.is-invalid-select2').removeClass('is-invalid-select2');

        // Restablecer el select de país a la opción por defecto y luego disparar su evento change
        // Esto limpiará automáticamente los campos de teléfono o los dejará con el código del país si la opción es la placeholder
        paisOrigenSelect.value = ''; // Selecciona la opción vacía
        paisOrigenSelect.dispatchEvent(new Event('change')); // Dispara el evento para actualizar los teléfonos
    });

    // --- MANEJO DE ERRORES DE LARAVEL AL CARGAR LA PÁGINA ---
    document.querySelectorAll('.form-control.is-invalid, textarea.is-invalid, .form-select.is-invalid').forEach(function(element) {
        let feedbackElement;
        if (element.id && document.getElementById(element.id + '-feedback')) {
            feedbackElement = document.getElementById(element.id + '-feedback');
        } else if (element.tagName === 'SELECT') {
            // Para Select2, el feedback puede estar junto al .select2-container
            $(element).next('.select2-container').find('.select2-selection').addClass('is-invalid-select2');
            feedbackElement = document.getElementById(element.id + '-feedback');
        } else {
            feedbackElement = element.nextElementSibling;
        }

        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
            feedbackElement.style.display = 'block';
            feedbackElement.setAttribute('data-laravel-error', 'true'); // Marca que es un error de Laravel
        }
    });

    // --- LISTENER GENERAL PARA LIMPIAR VALIDACIÓN CUANDO EL USUARIO CORRIGE ---
    document.querySelectorAll('.form-control, textarea').forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                let shouldClear = true;

                // Para campos obligatorios, no limpiar la validación si el campo sigue vacío
                if (this.hasAttribute('required') && this.value.trim().length === 0) {
                    shouldClear = false;
                } else if (this.id === 'nombre_empresa') {
                    if (this.value.length > 30) shouldClear = false;
                } else if (this.id === 'persona_contacto' || this.id === 'persona_contacto_secundaria') {
                    if (!regexSoloLetrasEspacios.test(this.value) || this.value.length > 32) shouldClear = false;
                } else if (this.id === 'telefono_contacto' || this.id === 'telefono_contacto_secundario') {
                    const regexTelefonoFullCheck = /^\+\d{7,11}$/;
                    if (this.value.trim().length > 0 && (!regexTelefonoFullCheck.test(this.value.trim()) || this.value.length < 8 || this.value.length > 12)) shouldClear = false;
                } else if (this.id === 'correo_electronico') {
                    const regexCorreoCheck = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    if (!regexCorreoCheck.test(this.value.trim()) || this.value.length > 30) shouldClear = false;
                } else if (this.id === 'direccion') {
                    if (this.value.length > 150) shouldClear = false;
                }

                if (shouldClear) {
                    this.classList.remove('is-invalid');
                    const feedbackElement = document.getElementById(this.id + '-feedback');
                    if (feedbackElement) {
                        feedbackElement.style.display = 'none';
                        feedbackElement.removeAttribute('data-laravel-error');
                        // Restaurar el mensaje por defecto si se limpió el error de Laravel
                        if (feedbackElement.id === 'nombre_empresa-feedback') feedbackElement.textContent = 'Este campo es obligatorio.';
                        // ... y así para los demás mensajes por defecto si son relevantes
                    }
                }
            }
        });
    });

    // Listener para select/Select2 para limpiar validación
    $('#pais_origen, #marcas, #tipo_autopartes').on('change', function() {
        if (this.classList.contains('is-invalid')) { // Para select HTML normal
            this.classList.remove('is-invalid');
            const feedbackElement = document.getElementById(this.id + '-feedback');
            if (feedbackElement) {
                feedbackElement.style.display = 'none';
                feedbackElement.removeAttribute('data-laravel-error');
            }
        }
        // Para el contenedor de Select2 (la parte visual)
        const select2Container = $(this).data('select2') ? $(this).next('.select2-container').find('.select2-selection') : null;
        if (select2Container && select2Container.hasClass('is-invalid-select2')) {
            select2Container.removeClass('is-invalid-select2');
            const feedbackElement = document.getElementById(this.id + '-feedback');
            if (feedbackElement) {
                feedbackElement.style.display = 'none';
                feedbackElement.removeAttribute('data-laravel-error');
            }
        }
    });
});
</script>
</body>
</html>
