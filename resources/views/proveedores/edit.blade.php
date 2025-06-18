@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')
{{-- Contenedor principal con padding vertical y centrado --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Contenedor del formulario con estilos oscuros y sombra --}}
            <div class="form-container">
                <h2 class="mb-4">Editar Proveedor</h2>

                {{-- Mensajes de éxito y error de sesión (si se usan) --}}
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

                <form id="formProveedor" action="{{ route('proveedores.update', $proveedor->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_empresa" class="form-label">Nombre de la empresa *</label>
                            <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror"
                                   id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa', $proveedor->nombre_empresa) }}" required maxlength="100">
                            <div class="invalid-feedback" id="nombre_empresa-feedback">
                                El nombre de la empresa es requerido y debe tener un máximo de 100 caracteres.
                            </div>
                            @error('nombre_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pais_origen" class="form-label">País de origen *</label>
                            <select class="form-select @error('pais_origen') is-invalid @enderror"
                                    id="pais_origen" name="pais_origen" required>
                                <option value="">Seleccione un país...</option>
                                {{-- Las opciones se llenarán con JavaScript --}}
                            </select>
                            <div class="invalid-feedback" id="pais_origen-feedback">
                                Por favor, seleccione el país de origen.
                            </div>
                            @error('pais_origen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="persona_contacto" class="form-label">Persona de contacto *</label>
                            <input type="text" class="form-control @error('persona_contacto') is-invalid @enderror"
                                   id="persona_contacto" name="persona_contacto"
                                   value="{{ old('persona_contacto', $proveedor->persona_contacto) }}"
                                   title="Solo se permiten letras y espacios" required maxlength="32">
                            <div class="invalid-feedback" id="persona_contacto-feedback">
                                La persona de contacto es requerida, solo letras y espacios, máximo 32 caracteres.
                            </div>
                            @error('persona_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo_electronico" class="form-label">Correo electrónico *</label>
                            <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror"
                                   id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico', $proveedor->correo_electronico) }}" required maxlength="100">
                            <div class="invalid-feedback" id="correo_electronico-feedback">
                                Ingrese un correo válido (ej. usuario@dominio.com).
                            </div>
                            @error('correo_electronico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono_contacto" class="form-label">Teléfono de contacto *</label>
                            <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror"
                                   id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto', $proveedor->telefono_contacto) }}"
                                   maxlength="12" required placeholder="Ej: +504XXXXXXXX">
                            <div class="invalid-feedback" id="telefono_contacto-feedback">
                                El teléfono debe incluir el código de país (ej. +504) y tener entre 8 y 12 dígitos (incluyendo el +).
                            </div>
                            @error('telefono_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección *</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                   id="direccion" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" required maxlength="255">
                            <div class="invalid-feedback" id="direccion-feedback">
                                La dirección es requerida y puede contener letras, números, espacios y caracteres especiales como ., #, -.
                            </div>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="marcas" class="form-label">Marcas que maneja *</label>
                            <select class="form-select @error('marcas') is-invalid @enderror"
                                    id="marcas" name="marcas[]" multiple required>
                                <option value="">Seleccione marcas...</option>
                                @php
                                    $allMarcas = [
                                        'Toyota', 'Honda', 'Nissan', 'Mazda', 'Mitsubishi',
                                        'Suzuki', 'Hyundai', 'Kia', 'Ford', 'Chevrolet'
                                    ];
                                    $selectedMarcas = old('marcas', $proveedor->marcas ?? []);
                                    if (is_string($selectedMarcas)) {
                                        $selectedMarcas = json_decode($selectedMarcas, true);
                                    }
                                    if (!is_array($selectedMarcas)) {
                                        $selectedMarcas = [];
                                    }
                                @endphp
                                @foreach($allMarcas as $marca)
                                    <option value="{{ $marca }}"
                                        {{ in_array($marca, $selectedMarcas) ? 'selected' : '' }}>
                                        {{ $marca }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="marcas-feedback">
                                Por favor, seleccione al menos una marca.
                            </div>
                            @error('marcas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_autopartes" class="form-label">Tipo de Autopartes *</label>
                            <select class="form-select @error('tipo_autopartes') is-invalid @enderror"
                                    id="tipo_autopartes" name="tipo_autopartes[]" multiple required>
                                <option value="">Seleccione tipos de autopartes...</option>
                                @php
                                    $allTiposAutopartes = [
                                        'Motor', 'Transmisión', 'Suspensión', 'Frenos',
                                        'Eléctrico', 'Carrocería', 'Interior', 'Accesorios'
                                    ];
                                    $selectedTiposAutopartes = old('tipo_autopartes', $proveedor->tipo_autopartes ?? []);
                                    if (is_string($selectedTiposAutopartes)) {
                                        $selectedTiposAutopartes = json_decode($selectedTiposAutopartes, true);
                                    }
                                    if (!is_array($selectedTiposAutopartes)) {
                                        $selectedTiposAutopartes = [];
                                    }
                                @endphp
                                @foreach($allTiposAutopartes as $tipo)
                                    <option value="{{ $tipo }}"
                                        {{ in_array($tipo, $selectedTiposAutopartes) ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="tipo_autopartes-feedback">
                                Por favor, seleccione al menos un tipo de autoparte.
                            </div>
                            @error('tipo_autopartes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="persona_contacto_secundaria" class="form-label">Persona de Contacto Secundaria</label>
                            <input type="text" class="form-control @error('persona_contacto_secundaria') is-invalid @enderror"
                                   id="persona_contacto_secundaria" name="persona_contacto_secundaria"
                                   value="{{ old('persona_contacto_secundaria', $proveedor->persona_contacto_secundaria) }}" maxlength="32">
                            <div class="invalid-feedback" id="persona_contacto_secundaria-feedback">
                                Solo se permiten letras y espacios, máximo 32 caracteres.
                            </div>
                            @error('persona_contacto_secundaria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono_contacto_secundario" class="form-label">Teléfono de Contacto Secundario</label>
                            <input type="text" class="form-control @error('telefono_contacto_secundario') is-invalid @enderror"
                                   id="telefono_contacto_secundario" name="telefono_contacto_secundario"
                                   value="{{ old('telefono_contacto_secundario', $proveedor->telefono_contacto_secundario) }}" maxlength="12" placeholder="Ej: +504XXXXXXXX">
                            <div class="invalid-feedback" id="telefono_contacto_secundaria-feedback">
                                El teléfono debe incluir el código de país (ej. +504) y tener entre 8 y 12 dígitos (incluyendo el +).
                            </div>
                            @error('telefono_contacto_secundario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
                        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light ms-2">Cancelar</a>
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
{{-- Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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

    h2 {
        color: #e0e0e0;
    }

    /* Estilos para Select2 para que coincidan con el tema oscuro */
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
</style>

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formProveedor');
    const paisOrigenSelect = document.getElementById('pais_origen');
    const telefonoContactoInput = document.getElementById('telefono_contacto');
    const telefonoContactoSecundarioInput = document.getElementById('telefono_contacto_secundario');

    const countries = [
        { "name": "Afghanistan", "phone_code": "+93" },
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

    function populateCountries() {
        const fragment = document.createDocumentFragment();
        const placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.textContent = 'Seleccione un país...';
        fragment.appendChild(placeholderOption);

        const currentCountry = "{{ old('pais_origen', $proveedor->pais_origen) }}";

        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name;
            option.textContent = country.name;
            option.setAttribute('data-phone-code', country.phone_code);
            if (currentCountry === country.name) {
                option.selected = true;
            }
            fragment.appendChild(option);
        });
        paisOrigenSelect.appendChild(fragment);
    }
    populateCountries();

    $('#marcas, #tipo_autopartes').select2({
        theme: 'default',
        width: '100%',
        placeholder: 'Seleccione las opciones',
        allowClear: true
    });

    paisOrigenSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const phoneCode = selectedOption.getAttribute('data-phone-code');

        const updatePhoneNumberField = (inputElement, code) => {
            let currentValue = inputElement.value.trim();
            const regexStartsWithPlus = /^\+\d*$/;
            const isCodeOnly = currentValue === '' || regexStartsWithPlus.test(currentValue);

            if (code) {
                if (isCodeOnly || !currentValue.startsWith(code)) {
                    inputElement.value = code;
                }
            } else {
                if (isCodeOnly) {
                    inputElement.value = '';
                }
            }
            inputElement.dispatchEvent(new Event('input'));
        };

        updatePhoneNumberField(telefonoContactoInput, phoneCode);
        updatePhoneNumberField(telefonoContactoSecundarioInput, phoneCode);
    });

    if (paisOrigenSelect.value) {
        paisOrigenSelect.dispatchEvent(new Event('change'));
    }


    form.addEventListener('submit', function(event) {
        let formIsValid = true;

        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.style.display = 'none';
        });

        const nombreEmpresaInput = document.getElementById('nombre_empresa');
        const nombreEmpresa = nombreEmpresaInput.value.trim();
        if (nombreEmpresa.length === 0 || nombreEmpresa.length > 100) {
            nombreEmpresaInput.classList.add('is-invalid');
            document.getElementById('nombre_empresa-feedback').style.display = 'block';
            formIsValid = false;
        }

        const paisOrigen = paisOrigenSelect.value;
        if (paisOrigen === "") {
            paisOrigenSelect.classList.add('is-invalid');
            document.getElementById('pais_origen-feedback').style.display = 'block';
            formIsValid = false;
        }

        const personaContactoInput = document.getElementById('persona_contacto');
        const personaContacto = personaContactoInput.value.trim();
        const regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (personaContacto.length === 0 || personaContacto.length > 32 || !regexNombre.test(personaContacto)) {
            personaContactoInput.classList.add('is-invalid');
            document.getElementById('persona_contacto-feedback').style.display = 'block';
            formIsValid = false;
        }

        const correoElectronicoInput = document.getElementById('correo_electronico');
        const correoElectronico = correoElectronicoInput.value.trim();
        const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!correoElectronico || !regexCorreo.test(correoElectronico) || correoElectronico.length > 100) {
            correoElectronicoInput.classList.add('is-invalid');
            document.getElementById('correo_electronico-feedback').style.display = 'block';
            formIsValid = false;
        }

        const telefonoContacto = telefonoContactoInput.value.trim();
        // CAMBIO: Regex para + seguido de 7 a 11 dígitos, total 8 a 12 caracteres.
        const regexTelefonoFull = /^\+\d{7,11}$/;

        if (!telefonoContacto || !regexTelefonoFull.test(telefonoContacto) || telefonoContacto.length < 8 || telefonoContacto.length > 12) {
            telefonoContactoInput.classList.add('is-invalid');
            document.getElementById('telefono_contacto-feedback').style.display = 'block';
            formIsValid = false;
        }


        const direccionInput = document.getElementById('direccion');
        const direccion = direccionInput.value.trim();
        const regexDireccion = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,#\-\/]+$/;
        if (!direccion || direccion.length > 255 || !regexDireccion.test(direccion)) {
            direccionInput.classList.add('is-invalid');
            document.getElementById('direccion-feedback').style.display = 'block';
            formIsValid = false;
        }

        const marcasSelect = document.getElementById('marcas');
        const selectedMarcas = $('#marcas').val();
        if (!selectedMarcas || selectedMarcas.length === 0) {
            marcasSelect.classList.add('is-invalid');
            document.getElementById('marcas-feedback').style.display = 'block';
            formIsValid = false;
        }

        const tipoAutopartesSelect = document.getElementById('tipo_autopartes');
        const selectedTipoAutopartes = $('#tipo_autopartes').val();
        if (!selectedTipoAutopartes || selectedTipoAutopartes.length === 0) {
            tipoAutopartesSelect.classList.add('is-invalid');
            document.getElementById('tipo_autopartes-feedback').style.display = 'block';
            formIsValid = false;
        }

        const personaContactoSecundariaInput = document.getElementById('persona_contacto_secundaria');
        const personaContactoSecundaria = personaContactoSecundariaInput.value.trim();
        if (personaContactoSecundaria.length > 0 && (!regexNombre.test(personaContactoSecundaria) || personaContactoSecundaria.length > 32)) {
            personaContactoSecundariaInput.classList.add('is-invalid');
            document.getElementById('persona_contacto_secundaria-feedback').style.display = 'block';
            formIsValid = false;
        }

        const telefonoContactoSecundario = telefonoContactoSecundarioInput.value.trim();
        // CAMBIO: Regex para + seguido de 7 a 11 dígitos, total 8 a 12 caracteres.
        if (telefonoContactoSecundario.length > 0 && (!regexTelefonoFull.test(telefonoContactoSecundario) || telefonoContactoSecundario.length < 8 || telefonoContactoSecundario.length > 12)) {
            telefonoContactoSecundarioInput.classList.add('is-invalid');
            document.getElementById('telefono_contacto_secundaria-feedback').style.display = 'block';
            formIsValid = false;
        }

        if (!formIsValid) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    const restrictPhoneInput = (inputElement) => {
        inputElement.addEventListener('input', function (e) {
            let value = e.target.value;
            let startWithPlus = value.startsWith('+');

            value = value.replace(/[^\d+]/g, '');
            if (startWithPlus && value[0] !== '+') {
                value = '+' + value;
            }
            if (!startWithPlus && value.startsWith('+')) {
                value = value.substring(1);
            }

            e.target.value = value.substring(0, 12); // Max 12 caracteres (incluyendo el '+')
        });
    };

    restrictPhoneInput(telefonoContactoInput);
    restrictPhoneInput(telefonoContactoSecundarioInput);


    document.querySelectorAll('.form-control, .form-select').forEach(input => {
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
            $(input).on('change', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });
});
</script>
@endsection