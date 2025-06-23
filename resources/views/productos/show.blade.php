@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-white text-center">Detalle del Producto</h2>

        <div class="card bg-dark text-white">
            <div class="card-body">
                <h4 class="card-title">{{ $producto->nombre }}</h4>
                <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                <p class="card-text"><strong>Marca:</strong> {{ $producto->marca }}</p>
                <p class="card-text"><strong>Modelo:</strong> {{ $producto->modelo }}</p>
                <p class="card-text"><strong>Año:</strong> {{ $producto->anio }}</p>
                <p class="card-text"><strong>Precio:</strong> L {{ number_format($producto->precio, 2) }}</p>
                <p class="card-text"><strong>Stock:</strong> {{ $producto->stock }}</p>
                <p class="card-text"><strong>Categoría:</strong> {{ $producto->categoria }}</p>

                <a href="{{ route('productos.index') }}" class="btn btn-outline-light mt-4">
                    <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                </a>
            </div>
        </div>
    </div>
@endsection
