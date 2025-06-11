@extends('layouts.app')

@section('title', 'Sistema de Gestión')

@section('content')
<div class="text-center">
    <h1 class="mb-5">Sistema de Gestión</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title mb-4">Gestión de Empleados</h3>
                    <p class="card-text mb-4">Administre la información de los empleados de la empresa.</p>
                    <a href="{{ route('empleados.menu') }}" class="btn btn-primary btn-lg w-100">Acceder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title mb-4">Gestión de Proveedores</h3>
                    <p class="card-text mb-4">Administre la información de los proveedores y sus productos.</p>
                    <a href="{{ route('proveedores.menu') }}" class="btn btn-primary btn-lg w-100">Acceder</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
