<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Empleado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #121212;
            color: #eaeaea;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background-color: #1f1f1f;
            border: none;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 0 30px rgba(0, 255, 170, 0.12);
            color: #f9f9f9;
        }

        .card h3 {
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .card p {
            margin: 0.6rem 0;
            font-size: 1.1rem;
            color: #f5f5f5;
        }

        .emoji {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .btn-outline-light,
        .btn-warning {
            margin: 0 0.5rem;
        }

        .btn-warning {
            color: #000;
        }

        strong {
            color: #c4ffc4;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card mx-auto" style="max-width: 900px;">
        <div class="text-center">
            <div class="emoji">👤</div>
            <h3>{{ $empleado->nombre }} {{ $empleado->apellido }}</h3>
        </div>

        <p><strong>Correo:</strong> {{ $empleado->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $empleado->telefono ?? 'No registrado' }}</p>
        <p><strong>Dirección:</strong> {{ $empleado->direccion ?? 'No registrada' }}</p>
        <p><strong>Sexo:</strong> {{ $empleado->sexo }}</p>
        <p><strong>Identidad:</strong> {{ $empleado->identidad }}</p>
        <p><strong>Puesto:</strong> {{ $empleado->puesto }}</p>
        <p><strong>Salario:</strong> L {{ number_format($empleado->salario, 2) }}</p>
        <p><strong>Fecha de Contratación:</strong> {{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') }}</p>

        <div class="mt-4 text-center">
            <a href="{{ route('empleados.index') }}" class="btn btn-outline-light">← Volver a la lista</a>
            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning">✏️ Editar</a>
        </div>
    </div>
</div>
</body>
</html>
