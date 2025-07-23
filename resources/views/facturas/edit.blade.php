@extends('layouts.app')

@section('title', 'Editar Factura de Venta')

@section('content')
    <div class="container py-5">
        <div class="table-container">
            <h2 class="mb-4">Editar Factura de Venta #{{ $factura->codigo }}</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('facturas.update', $factura->id) }}" id="formFactura" novalidate>
                @csrf
                @method('PUT') {{-- Importante para el método PUT --}}

                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" name="cliente" id="cliente"
                           value="{{ old('cliente', $factura->cliente) }}"
                           class="form-control bg-dark text-white @error('cliente') is-invalid @enderror"
                           placeholder="Nombre del cliente"
                           required
                           pattern="^[^\s\d][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]*$"
                           title="No debe iniciar con espacio ni número">
                    @error('cliente')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha"
                           value="{{ old('fecha', $factura->fecha ? $factura->fecha->format('Y-m-d') : '') }}" {{-- Formatear la fecha de forma segura --}}
                           class="form-control bg-dark text-white @error('fecha') is-invalid @enderror"
                           required>
                    @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProductos">
                        + Agregar/Modificar Producto
                    </button>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-dark table-striped table-hover text-center align-middle" id="tablaProductos">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario (L.)</th>
                            <th>IVA (L.)</th>
                            <th>Subtotal (L.)</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- Aquí se agregarán productos dinámicamente --}}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total:</th>
                            <th id="totalFactura">L. 0.00</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <button type="submit" class="btn btn-success">Actualizar Factura</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-light">Cancelar</a>
            </form>
        </div>
    </div>

    {{-- Aquí incluimos el modal de selección de productos --}}
    @include('facturas.modal-producto')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('formFactura');
            const tbody = document.querySelector('#tablaProductos tbody');
            const totalFacturaEl = document.getElementById('totalFactura');

            // Inicializar productosSeleccionados con los detalles de la factura existente
            // Usamos json_encode con flags para una serialización más robusta
            const rawJsonString = '{!! json_encode($factura->detalles->map(function($detalle) {
                return [
                    'id' => $detalle->producto_id,
                    // Usar el operador null-safe (?->) para acceder a propiedades de producto
                    // y el operador de fusión de null (??) para un valor por defecto.
                    'nombre' => $detalle->producto?->nombre ?? 'Producto Desconocido',
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => $detalle->precio_unitario,
                    'iva' => $detalle->iva,
                    'subtotal' => $detalle->subtotal,
                ];
            })->toArray(), JSON_HEX_APOS | JSON_HEX_QUOT) !!}';

            console.log("Raw JSON string from Blade:", rawJsonString);

            let productosSeleccionados;
            try {
                productosSeleccionados = JSON.parse(rawJsonString);
                console.log("Parsed productosSeleccionados:", productosSeleccionados);
            } catch (e) {
                console.error("Error parsing JSON for productosSeleccionados:", e);
                console.error("Problematic JSON string:", rawJsonString);
                productosSeleccionados = []; // Fallback a un array vacío para que la aplicación no se rompa
            }


            // --- Lógica de la Tabla Principal de Factura ---

            function calcularSubtotal(precio, cantidad, iva) {
                const p = parseFloat(precio) || 0;
                const c = parseInt(cantidad) || 0;
                const i = parseFloat(iva) || 0;
                return (p * c) + i;
            }

            function actualizarTotal() {
                let total = productosSeleccionados.reduce((acc, p) => {
                    return acc + calcularSubtotal(p.precio_unitario, p.cantidad, p.iva);
                }, 0);
                totalFacturaEl.textContent = 'L. ' + total.toFixed(2);
            }

            // Renderizar la tabla principal (solo muestra texto, no editable)
            function renderizarTabla() {
                tbody.innerHTML = '';

                if (productosSeleccionados.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7">No hay productos seleccionados.</td></tr>`;
                    actualizarTotal();
                    return;
                }

                productosSeleccionados.forEach((p, index) => {
                    const subtotal = calcularSubtotal(p.precio_unitario, p.cantidad, p.iva);
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${index + 1}</td>
                        <td>
                            ${p.nombre}
                            <input type="hidden" name="detalles[${index}][producto_id]" value="${p.id}">
                        </td>
                        <td>
                            ${p.cantidad}
                            <input type="hidden" name="detalles[${index}][cantidad]" value="${p.cantidad}">
                        </td>
                        <td>
                            L. ${p.precio_unitario.toFixed(2)}
                            <input type="hidden" name="detalles[${index}][precio_unitario]" value="${p.precio_unitario}">
                        </td>
                        <td>
                            L. ${p.iva.toFixed(2)}
                            <input type="hidden" name="detalles[${index}][iva]" value="${p.iva}">
                        </td>
                        <td>L. ${subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm eliminar" data-index="${index}">Eliminar</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
                actualizarTotal();
            }

            // Función para mostrar alertas personalizadas
            function showAlert(message, type = 'danger') {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
                alertDiv.innerHTML = `${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>`;
                form.prepend(alertDiv);
                setTimeout(() => alertDiv.remove(), 3000);
            }

            // Listener para el evento personalizado 'productSelected' desde modal-producto.blade.php
            document.addEventListener('productSelected', function(e) {
                const selectedProduct = e.detail;

                const yaAgregado = productosSeleccionados.some(p => p.id === selectedProduct.id);

                if (!yaAgregado) {
                    productosSeleccionados.push(selectedProduct);
                    renderizarTabla();
                } else {
                    showAlert('El producto ya está agregado en la factura principal.', 'warning');
                }
            });

            // Evento para eliminar producto de la tabla principal
            tbody.addEventListener('click', function(e) {
                if (e.target.classList.contains('eliminar')) {
                    const index = parseInt(e.target.dataset.index);
                    if (!isNaN(index) && index >= 0 && index < productosSeleccionados.length) {
                        productosSeleccionados.splice(index, 1);
                        renderizarTabla();
                    }
                }
            });

            // Validación al enviar el formulario
            form.addEventListener('submit', function(e) {
                // Validar campo Cliente
                const clienteInput = document.getElementById('cliente');
                const clienteVal = clienteInput.value.trim();
                if (!clienteVal) {
                    e.preventDefault();
                    clienteInput.classList.add('is-invalid');
                    showAlert('El campo Cliente es obligatorio.', 'danger');
                    return;
                } else {
                    clienteInput.classList.remove('is-invalid');
                }

                // Validar campo Fecha
                const fechaInput = document.getElementById('fecha');
                if (!fechaInput.value) {
                    e.preventDefault();
                    fechaInput.classList.add('is-invalid');
                    showAlert('El campo Fecha es obligatorio.', 'danger');
                    return;
                } else {
                    fechaInput.classList.remove('is-invalid');
                }

                // Validar que haya al menos un producto seleccionado
                if (productosSeleccionados.length === 0) {
                    e.preventDefault();
                    showAlert('Debe agregar al menos un producto a la factura.', 'danger');
                    return;
                }

                // Si todas las validaciones pasan, el formulario se enviará
            });

            // Renderizar la tabla con los productos de la factura al cargar la página
            renderizarTabla();
        });
    </script>

    <style>
        /* Estilos para los campos de formulario */
        .form-control.bg-dark.text-white::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .form-control.bg-dark.text-white {
            color: #fff !important;
            background-color: #343a40 !important;
        }
        input[type="date"].bg-dark.text-white {
            color: #fff !important;
        }
        input[type="date"].bg-dark.text-white::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
        .form-select.bg-dark.text-white {
            color: #fff !important;
            background-color: #343a40 !important;
        }
        .form-select.bg-dark.text-white option {
            background-color: #343a40 !important;
            color: #fff !important;
        }

        /* Estilos para los mensajes de error de validación personalizados */
        .invalid-feedback-custom {
            display: none; /* Oculto por defecto */
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545; /* Rojo de error de Bootstrap */
        }
        .form-control.is-invalid + .invalid-feedback-custom {
            display: block; /* Mostrar cuando el input tiene la clase is-invalid */
        }
    </style>
@endsection
