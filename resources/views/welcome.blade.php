<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .btn-custom {
            min-width: 200px;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h1 class="mb-5">Bienvenido al Sistema de Empleados</h1>
        <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-lg btn-custom">Registrar Empleado</a>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary btn-lg btn-custom">Lista de Empleados</a>
    </div>
</body>
</html>
