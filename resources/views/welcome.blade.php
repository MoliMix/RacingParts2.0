@extends('layouts.app')

@section('title', 'Sistema de Gestión')

@section('content')
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Sistema de Gestión</h1>
        <p class="lead">Seleccione el sistema que desea gestionar</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="system-icon mb-4">
                        <i class="fas fa-users fa-4x text-primary"></i>
                    </div>
                    <h3 class="card-title mb-4">Sistema de Empleados</h3>
                    <p class="card-text mb-4">Gestione la información de los empleados, incluyendo datos personales,
                        laborales y estado.</p>
                    <a href="{{ route('empleados.menu') }}" class="btn btn-primary btn-lg w-100">Acceder</a>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="system-icon mb-4">
                        <i class="fas fa-truck fa-4x text-success"></i>
                    </div>
                    <h3 class="card-title mb-4">Sistema de Proveedores</h3>
                    <p class="card-text mb-4">Administre la información de proveedores, marcas y tipos de autopartes
                        disponibles.</p>
                    <a href="{{ route('proveedores.menu') }}" class="btn btn-success btn-lg w-100">Acceder</a>
                </div>
            </div>
        </div>

        {{-- Nueva tarjeta: Sistema de Productos --}}
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="system-icon mb-4">
                        <i class="fas fa-cogs fa-4x text-warning"></i>
                    </div>
                    <h3 class="card-title mb-4">Sistema de Productos</h3>
                    <p class="card-text mb-4">Gestione el inventario de autopartes, incluyendo nombre, marca, modelo, año,
                        precio y stock.</p>
                    <a href="{{ route('productos.menu') }}" class="btn btn-warning btn-lg w-100 text-white">Acceder</a>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-4">
    <div class="card h-100">  {{-- Removed shadow-sm --}}
        <div class="card-body text-center">
            <div class="system-icon mb-4">
                {{-- Changed color: red; to Bootstrap text-danger class for consistency --}}
                <i class="fas fa-users fa-4x text-danger"></i>
            </div>
            {{-- Removed font-weight-bold and aligned mb-4 with the other card --}}
            <h3 class="card-title mb-4">Gestión de Clientes</h3>
            {{-- Removed text-white from p tag to match default text color --}}
            <p class="card-text mb-4">Administra la información de los clientes, incluyendo sus datos de
                contacto, historial de compras y preferencias.</p>
            {{-- Changed to a standard Bootstrap button class, e.g., btn-danger --}}
            <a href="{{ route('clientes.menu') }}" class="btn btn-danger btn-lg w-100 text-white">Acceder</a>
        </div>
    </div>
</div>



    </div>

    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .system-icon {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .btn {
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 8px;
        }
    </style>
@endsection