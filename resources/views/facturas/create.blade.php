@extends('layouts.app')

@section('title', 'Registrar Factura de Venta')

@section('content')
    <div class="container py-5">
        <div class="table-container">
            <h2 class="mb-4">Registrar nueva factura de venta</h2>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('facturas.store') }}" id="formFactura">
                @csrf

                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input
                        type="text"
                        name="cliente"
                        id="cliente"
                        value="{{ old('cliente') }}"
                        class="form-control @error('cliente') is-invalid @enderror"
                        placeholder="Nombre del cliente"
                        required
                        pattern="^[^\s\d][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]*$"
                        title="No debe iniciar con espacio ni número"
                    >
                    @error('cliente')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input
                        type="date"
                        name="fecha"
                        id="fecha"
                        value="{{ old('fecha', date('Y-m-d')) }}"
                        class="form-control @error('fecha') is-invalid @enderror"
                        required
                    >
                    @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProductos">
                        + Agregar Producto
                    </button>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-dark table-striped table-hover text-center align-middle" id="tablaProductos">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario (L.)</th>
                            <th>IVA (L.)</th>
                            <th>Subtotal (L.)</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- Aquí se agregan los productos dinámicamente --}}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th id="totalFactura">L. 0.00</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Mostrar errores de validación para los detalles de la factura --}}
                @error('detalles')
                <div class="alert alert-danger mb-3">{{ $message }}</div>
                @enderror
                @error('detalles.*.producto_id')
                <div class="alert alert-danger mb-3">{{ $message }}</div>
                @enderror
                @error('detalles.*.cantidad')
                <div class="alert alert-danger mb-3">{{ $message }}</div>
                @enderror
                @error('detalles.*.precio_unitario')
                <div class="alert alert-danger mb-3">{{ $message }}</div>
                @enderror
                @error('detalles.*.iva')
                <div class="alert alert-danger mb-3">{{ $message }}</div>
                @enderror


                <button type="submit" class="btn btn-success">Guardar Factura</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-light">Cancelar</a>
            </form>
        </div>
    </div>

    {{-- Modal de selección de productos --}}
    @include('facturas.modal-producto')

    {{-- JavaScript para manejar la tabla dinámica --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Asegúrate de que $productos se haya pasado correctamente desde el controlador
            const productos = @json($productos);
            const tbody = document.querySelector('#tablaProductos tbody');
            const totalFacturaEl = document.getElementById('totalFactura');
            const form = document.getElementById('formFactura');

            let productosSeleccionados = [];

            // Función para calcular subtotal de un producto
            function calcularSubtotal(precio, cantidad, iva) {
                const p = parseFloat(precio) || 0;
                const c = parseInt(cantidad) || 0;
                const i = parseFloat(iva) || 0;
                return (p * c) + i;
            }

            // Función para actualizar total general
            function actualizarTotal() {
                let total = 0;
                productosSeleccionados.forEach(p => {
                    total += calcularSubtotal(p.precio_unitario, p.cantidad, p.iva);
                });
                totalFacturaEl.textContent = 'L. ' + total.toFixed(2);
            }

            // Función para renderizar la tabla
            function renderizarTabla() {
                tbody.innerHTML = ''; // Limpiar la tabla antes de renderizar

                productosSeleccionados.forEach((p, index) => {
                    const subtotal = calcularSubtotal(p.precio_unitario, p.cantidad, p.iva);

                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${p.nombre}</td>
                        <td>
                            <input type="number" min="1" value="${p.cantidad}" class="form-control form-control-sm cantidad" data-index="${index}" required>
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" value="${p.precio_unitario}" class="form-control form-control-sm precio_unitario" data-index="${index}" required>
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" value="${p.iva}" class="form-control form-control-sm iva" data-index="${index}" required>
                        </td>
                        <td>L. ${subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm eliminar" data-index="${index}">Eliminar</button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });

                actualizarTotal();
                agregarInputsOcultos();
            }

            // Añade inputs ocultos para enviar datos al backend
            function agregarInputsOcultos() {
                // Remover inputs ocultos previos para evitar duplicados
                document.querySelectorAll('input[name^="detalles"]').forEach(i => i.remove());

                productosSeleccionados.forEach((p, index) => {
                    // ¡CORRECCIÓN CLAVE AQUÍ! Usar 'detalles' en lugar de 'productos'
                    // y 'producto_id' en lugar de 'id' para la clave foránea
                    const inputProductoId = document.createElement('input');
                    inputProductoId.type = 'hidden';
                    inputProductoId.name = `detalles[${index}][producto_id]`;
                    inputProductoId.value = p.id;
                    form.appendChild(inputProductoId);

                    const inputCantidad = document.createElement('input');
                    inputCantidad.type = 'hidden';
                    inputCantidad.name = `detalles[${index}][cantidad]`;
                    inputCantidad.value = p.cantidad;
                    form.appendChild(inputCantidad);

                    const inputPrecio = document.createElement('input');
                    inputPrecio.type = 'hidden';
                    inputPrecio.name = `detalles[${index}][precio_unitario]`;
                    inputPrecio.value = p.precio_unitario;
                    form.appendChild(inputPrecio);

                    const inputIva = document.createElement('input');
                    inputIva.type = 'hidden';
                    inputIva.name = `detalles[${index}][iva]`;
                    inputIva.value = p.iva;
                    form.appendChild(inputIva);
                });
            }

            // Función para mostrar alertas personalizadas (reemplazo de alert())
            function showAlert(message, type = 'danger') {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
                alertDiv.innerHTML = `${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>`;
                form.prepend(alertDiv); // Añadir al inicio del formulario
                setTimeout(() => alertDiv.remove(), 3000); // Quitar después de 3 segundos
            }


            // Agregar producto desde el modal
            // Usamos delegación de eventos para los botones 'agregar-producto'
            document.getElementById('modalProductos').addEventListener('click', function(e) {
                if (e.target.classList.contains('agregar-producto')) {
                    const btn = e.target;
                    const id = parseInt(btn.dataset.id);
                    const nombre = btn.dataset.nombre;
                    const precio = parseFloat(btn.dataset.precio) || 0; // Asegura que el precio sea un número

                    const yaAgregado = productosSeleccionados.some(p => p.id === id);

                    if (!yaAgregado) {
                        productosSeleccionados.push({
                            id: id,
                            nombre: nombre,
                            cantidad: 1,
                            precio_unitario: precio,
                            iva: 0 // IVA inicial para el detalle, se puede ajustar o calcular en backend
                        });
                        renderizarTabla();
                        const modalElement = document.getElementById('modalProductos');
                        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                        modal.hide();
                    } else {
                        showAlert('El producto ya está agregado.', 'warning');
                    }
                }
            });


            // Delegación para inputs dentro de la tabla (cantidad, precio, iva)
            tbody.addEventListener('input', function(e) {
                const target = e.target;
                const index = parseInt(target.dataset.index);

                if (isNaN(index) || index < 0 || index >= productosSeleccionados.length) {
                    console.error("Índice de producto inválido:", index);
                    return;
                }

                if (target.classList.contains('cantidad')) {
                    let val = parseInt(target.value);
                    if (val < 1 || isNaN(val)) val = 1;
                    productosSeleccionados[index].cantidad = val;
                    target.value = val; // Asegura que el input muestre el valor corregido
                } else if (target.classList.contains('precio_unitario')) {
                    let val = parseFloat(target.value);
                    if (val < 0 || isNaN(val)) val = 0;
                    productosSeleccionados[index].precio_unitario = val;
                    target.value = val.toFixed(2); // Muestra 2 decimales
                } else if (target.classList.contains('iva')) {
                    let val = parseFloat(target.value);
                    if (val < 0 || isNaN(val)) val = 0;
                    productosSeleccionados[index].iva = val;
                    target.value = val.toFixed(2); // Muestra 2 decimales
                }

                renderizarTabla();
            });

            // Delegación para botón eliminar
            tbody.addEventListener('click', function(e) {
                if (e.target.classList.contains('eliminar')) {
                    const index = parseInt(e.target.dataset.index);
                    if (isNaN(index) || index < 0 || index >= productosSeleccionados.length) {
                        console.error("Índice de producto a eliminar inválido:", index);
                        return;
                    }
                    productosSeleccionados.splice(index, 1);
                    renderizarTabla();
                }
            });

            // Validar que al enviar el formulario haya productos agregados
            form.addEventListener('submit', function(e) {
                if (productosSeleccionados.length === 0) {
                    e.preventDefault(); // Previene el envío del formulario
                    showAlert('Debe agregar al menos un producto a la factura.');
                }
            });

            // Opcional: Si quieres cargar productos seleccionados previamente (ej. después de un error de validación)
            // if (productosSeleccionados.length > 0) {
            //     renderizarTabla();
            // }
        });
    </script>
@endsection
