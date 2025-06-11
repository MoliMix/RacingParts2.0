<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Gestión')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
        }
        .container-custom {
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
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
        .table {
            color: #f1f1f1;
        }
        th {
            background-color: #2e2e2e;
            color: #ccc;
        }
        tr:nth-child(even) {
            background-color: #2a2a2a;
        }
        tr:hover {
            background-color: #333;
        }
        .alert {
            margin-bottom: 1rem;
            border: none;
            border-radius: 8px;
        }
        .alert-success {
            background-color: #28a745;
            color: #fff;
        }
        .alert-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-close {
            filter: brightness(0) invert(1);
        }
        .select2-container--default .select2-selection--multiple {
            background-color: #2c2c2c;
            border: none;
            color: #fff;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #4caf50;
            border: none;
            color: #fff;
        }
        .select2-container--default .select2-results__option {
            background-color: #2c2c2c;
            color: #fff;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4caf50;
            color: #fff;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container py-5">
        <div class="container-custom">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('scripts')
</body>
</html> 