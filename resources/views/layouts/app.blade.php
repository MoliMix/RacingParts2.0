<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RacingParts</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
        /* Estilos para Select2 en tema oscuro */
        .select2-container--default .select2-selection--single {
            background-color: #1f1f1f;
            border: 1px solid #333;
            color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            background-color: #1f1f1f;
        }
        .select2-dropdown {
            background-color: #1f1f1f;
            border: 1px solid #333;
        }
        .select2-container--default .select2-results__option {
            color: #fff;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #333;
        }
        .select2-container--default .select2-reslection--multiple {
            background-color: #1f1f1f;
            border: 1px solid #333;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #333;
            border: 1px solid #444;
            color: #fff;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff4444;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #1f1f1f;
            color: #fff;
            border: 1px solid #333;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #444;
        }

        .pagination .page-link {
            background-color: transparent;
            color: #4caf50;
            border: 1px solid #4caf50;
        }

        .pagination .page-item.active .page-link {
            background-color: #4caf50;
            color: #121212;
            border-color: #4caf50;
        }

        .pagination .page-link:hover {
            background-color: #43a047;
            color: white;
            border-color: #43a047;
        }

    </style>
</head>
<body>
    <div class="container py-5">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('scripts')
</body>
</html>
