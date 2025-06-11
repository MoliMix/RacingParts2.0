@extends('layouts.app')

@section('title', 'Registrar Proveedor')

@section('content')
<h2 class="mb-4">Registrar Nuevo Proveedor</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('proveedores.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre_empresa" class="form-label">Nombre de la Empresa *</label>
            <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror" 
                   id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa') }}" required>
            @error('nombre_empresa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="pais_origen" class="form-label">País de Origen *</label>
            <input type="text" class="form-control @error('pais_origen') is-invalid @enderror" 
                   id="pais_origen" name="pais_origen" value="{{ old('pais_origen') }}" required>
            @error('pais_origen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="persona_contacto" class="form-label">Persona de Contacto *</label>
            <input type="text" class="form-control @error('persona_contacto') is-invalid @enderror" 
                   id="persona_contacto" name="persona_contacto" value="{{ old('persona_contacto') }}" required>
            @error('persona_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="correo_electronico" class="form-label">Correo Electrónico *</label>
            <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror" 
                   id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}" required>
            @error('correo_electronico')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono_contacto" class="form-label">Teléfono de Contacto *</label>
            <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" 
                   id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto') }}" required>
            @error('telefono_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="direccion" class="form-label">Dirección *</label>
            <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                   id="direccion" name="direccion" value="{{ old('direccion') }}" required>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="marcas" class="form-label">Marcas que Maneja *</label>
            <select class="form-select @error('marcas') is-invalid @enderror" 
                    id="marcas" name="marcas[]" multiple required>
                <option value="Toyota">Toyota</option>
                <option value="Honda">Honda</option>
                <option value="Nissan">Nissan</option>
                <option value="Mazda">Mazda</option>
                <option value="Mitsubishi">Mitsubishi</option>
                <option value="Suzuki">Suzuki</option>
                <option value="Hyundai">Hyundai</option>
                <option value="Kia">Kia</option>
                <option value="Ford">Ford</option>
                <option value="Chevrolet">Chevrolet</option>
            </select>
            @error('marcas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tipo_autopartes" class="form-label">Tipo de Autopartes *</label>
            <select class="form-select @error('tipo_autopartes') is-invalid @enderror" 
                    id="tipo_autopartes" name="tipo_autopartes[]" multiple required>
                <option value="Motor">Motor</option>
                <option value="Transmisión">Transmisión</option>
                <option value="Suspensión">Suspensión</option>
                <option value="Frenos">Frenos</option>
                <option value="Eléctrico">Eléctrico</option>
                <option value="Carrocería">Carrocería</option>
                <option value="Interior">Interior</option>
                <option value="Accesorios">Accesorios</option>
            </select>
            @error('tipo_autopartes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="persona_contacto_secundaria" class="form-label">Persona de Contacto Secundaria</label>
            <input type="text" class="form-control @error('persona_contacto_secundaria') is-invalid @enderror" 
                   id="persona_contacto_secundaria" name="persona_contacto_secundaria" value="{{ old('persona_contacto_secundaria') }}">
            @error('persona_contacto_secundaria')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono_contacto_secundario" class="form-label">Teléfono de Contacto Secundario</label>
            <input type="text" class="form-control @error('telefono_contacto_secundario') is-invalid @enderror" 
                   id="telefono_contacto_secundario" name="telefono_contacto_secundario" value="{{ old('telefono_contacto_secundario') }}">
            @error('telefono_contacto_secundario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Registrar Proveedor</button>
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