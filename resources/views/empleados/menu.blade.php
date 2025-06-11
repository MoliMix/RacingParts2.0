@extends('layouts.app')

@section('title', 'Sistema de Registro de Empleados')

@section('content')
<div class="text-center">
    <h1 class="mb-5">Sistema de Registro de Empleados</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title mb-4">Registrar Empleado</h3>
                    <p class="card-text mb-4">Registre un nuevo empleado en el sistema.</p>
                    <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-lg w-100">Registrar</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title mb-4">Lista de Empleados</h3>
                    <p class="card-text mb-4">Vea la lista completa de empleados registrados.</p>
                    <a href="{{ route('empleados.index') }}" class="btn btn-primary btn-lg w-100">Ver Lista</a>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('welcome') }}" class="btn btn-outline-light mt-3">Volver al Inicio</a>
</div>
@endsection 