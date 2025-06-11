@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')
<h2 class="mb-4">Editar Proveedor</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre_empresa" class="form-label">Nombre de la Empresa *</label>
            <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror" 
                   id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa', $proveedor->nombre_empresa) }}" required>
            @error('nombre_empresa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="pais_origen" class="form-label">País de Origen *</label>
            <input type="text" class="form-control @error('pais_origen') is-invalid @enderror" 
                   id="pais_origen" name="pais_origen" value="{{ old('pais_origen', $proveedor->pais_origen) }}" required>
            @error('pais_origen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="persona_contacto" class="form-label">Persona de Contacto *</label>
            <input type="text" class="form-control @error('persona_contacto') is-invalid @enderror" 
                   id="persona_contacto" name="persona_contacto" value="{{ old('persona_contacto', $proveedor->persona_contacto) }}" required>
            @error('persona_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="correo_electronico" class="form-label">Correo Electrónico *</label>
            <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror" 
                   id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico', $proveedor->correo_electronico) }}" required>
            @error('correo_electronico')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono_contacto" class="form-label">Teléfono de Contacto *</label>
            <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" 
                   id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto', $proveedor->telefono_contacto) }}" required>
            @error('telefono_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="direccion" class="form-label">Dirección *</label>
            <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                   id="direccion" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" required>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="marcas" class="form-label">Marcas que Maneja *</label>
            <select class="form-select @error('marcas') is-invalid @enderror" 
                    id="marcas" name="marcas[]" multiple required>
                @php
                    $marcasSeleccionadas = old('marcas', $proveedor->marcas);
                @endphp
                <option value="Toyota" {{ in_array('Toyota', $marcasSeleccionadas) ? 'selected' : '' }}>Toyota</option>
                <option value="Honda" {{ in_array('Honda', $marcasSeleccionadas) ? 'selected' : '' }}>Honda</option>
                <option value="Nissan" {{ in_array('Nissan', $marcasSeleccionadas) ? 'selected' : '' }}>Nissan</option>
                <option value="Mazda" {{ in_array('Mazda', $marcasSeleccionadas) ? 'selected' : '' }}>Mazda</option>
                <option value="Mitsubishi" {{ in_array('Mitsubishi', $marcasSeleccionadas) ? 'selected' : '' }}>Mitsubishi</option>
                <option value="Suzuki" {{ in_array('Suzuki', $marcasSeleccionadas) ? 'selected' : '' }}>Suzuki</option>
                <option value="Hyundai" {{ in_array('Hyundai', $marcasSeleccionadas) ? 'selected' : '' }}>Hyundai</option>
                <option value="Kia" {{ in_array('Kia', $marcasSeleccionadas) ? 'selected' : '' }}>Kia</option>
                <option value="Ford" {{ in_array('Ford', $marcasSeleccionadas) ? 'selected' : '' }}>Ford</option>
                <option value="Chevrolet" {{ in_array('Chevrolet', $marcasSeleccionadas) ? 'selected' : '' }}>Chevrolet</option>
            </select>
            @error('marcas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tipo_autopartes" class="form-label">Tipo de Autopartes *</label>
            <select class="form-select @error('tipo_autopartes') is-invalid @enderror" 
                    id="tipo_autopartes" name="tipo_autopartes[]" multiple required>
                @php
                    $tiposSeleccionados = old('tipo_autopartes', $proveedor->tipo_autopartes);
                @endphp
                <option value="Motor" {{ in_array('Motor', $tiposSeleccionados) ? 'selected' : '' }}>Motor</option>
                <option value="Transmisión" {{ in_array('Transmisión', $tiposSeleccionados) ? 'selected' : '' }}>Transmisión</option>
                <option value="Suspensión" {{ in_array('Suspensión', $tiposSeleccionados) ? 'selected' : '' }}>Suspensión</option>
                <option value="Frenos" {{ in_array('Frenos', $tiposSeleccionados) ? 'selected' : '' }}>Frenos</option>
                <option value="Eléctrico" {{ in_array('Eléctrico', $tiposSeleccionados) ? 'selected' : '' }}>Eléctrico</option>
                <option value="Carrocería" {{ in_array('Carrocería', $tiposSeleccionados) ? 'selected' : '' }}>Carrocería</option>
                <option value="Interior" {{ in_array('Interior', $tiposSeleccionados) ? 'selected' : '' }}>Interior</option>
                <option value="Accesorios" {{ in_array('Accesorios', $tiposSeleccionados) ? 'selected' : '' }}>Accesorios</option>
            </select>
            @error('tipo_autopartes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="persona_contacto_secundaria" class="form-label">Persona de Contacto Secundaria</label>
            <input type="text" class="form-control @error('persona_contacto_secundaria') is-invalid @enderror" 
                   id="persona_contacto_secundaria" name="persona_contacto_secundaria" value="{{ old('persona_contacto_secundaria', $proveedor->persona_contacto_secundaria) }}">
            @error('persona_contacto_secundaria')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono_contacto_secundario" class="form-label">Teléfono de Contacto Secundario</label>
            <input type="text" class="form-control @error('telefono_contacto_secundario') is-invalid @enderror" 
                   id="telefono_contacto_secundario" name="telefono_contacto_secundario" value="{{ old('telefono_contacto_secundario', $proveedor->telefono_contacto_secundario) }}">
            @error('telefono_contacto_secundario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light">Cancelar</a>
    </div>
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#marcas, #tipo_autopartes').select2({
            theme: 'default',
            width: '100%',
            placeholder: 'Seleccione las opciones',
            allowClear: true
        });
    });
</script>
@endsection 