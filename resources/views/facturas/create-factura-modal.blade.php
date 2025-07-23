<div class="modal fade" id="createFacturaModal" tabindex="-1" aria-labelledby="createFacturaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="createFacturaModalLabel">Registrar Nueva Factura de Venta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('facturas.store') }}" id="formFacturaModal">
                    @csrf

                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input
                            type="text"
                            name="cliente"
                            id="cliente"
                            value="{{ old('cliente') }}"
                            class="form-control bg-dark text-white @error('cliente') is-invalid @enderror" {{-- Clases añadidas --}}
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
                            class="form-control bg-dark text-white @error('fecha') is-invalid @enderror" {{-- Clases añadidas --}}
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
                        <table class="table table-dark table-striped table-hover text-center align-middle" id="tablaProductosModal">
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
                                <th id="totalFacturaModal">L. 0.00</th>
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
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal de selección de productos --}}
@include('facturas.components.modal-producto')

{{-- JavaScript para manejar la tabla dinámica y la lógica del formulario dentro del modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productos = @json($productos);
        const form = document.getElementById('formFacturaModal');
        const tbody = document.querySelector('#tablaProductosModal tbody');
        const totalFacturaEl = document.getElementById('totalFacturaModal');

        let productosSeleccionados = [];

        function calcularSubtotal(precio, cantidad, iva) {
            const p = parseFloat(precio) || 0;
            const c = parseInt(cantidad) || 0;
            const i = parseFloat(iva) || 0;
            return (p * c) + i;
        }

        function actualizarTotal() {
            let total = 0;
            productosSeleccionados.forEach(p => {
                total += calcularSubtotal(p.precio_unitario, p.cantidad, p.iva);
            });
            totalFacturaEl.textContent = 'L. ' + total.toFixed(2);
        }

        // renderizarTabla ahora incluye los inputs ocultos directamente
        function renderizarTabla() {
            tbody.innerHTML = '';

            productosSeleccionados.forEach((p, index) => {
                const subtotal = calcularSubtotal(p.precio_unitario, p.cantidad, p.iva);

                const tr = document.createElement('tr');

                tr.innerHTML = `
                        <td>${p.nombre}
                            <input type="hidden" name="detalles[${index}][producto_id]" value="${p.id}">
                        </td>
                        <td>
                            <input type="number" min="1" value="${p.cantidad}" class="form-control form-control-sm cantidad" data-index="${index}" required>
                            <input type="hidden" name="detalles[${index}][cantidad]" value="${p.cantidad}">
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" value="${p.precio_unitario}" class="form-control form-control-sm precio_unitario" data-index="${index}" required>
                            <input type="hidden" name="detalles[${index}][precio_unitario]" value="${p.precio_unitario}">
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" value="${p.iva}" class="form-control form-control-sm iva" data-index="${index}" required>
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

        function showAlert(message, type = 'danger') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
            alertDiv.innerHTML = `${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>`;
            form.prepend(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        const modalProductosEl = document.getElementById('modalProductos');
        if (modalProductosEl) {
            modalProductosEl.addEventListener('click', function(e) {
                if (e.target.classList.contains('agregar-producto')) {
                    const btn = e.target;
                    const id = parseInt(btn.dataset.id);
                    const nombre = btn.dataset.nombre;
                    const precio = parseFloat(btn.dataset.precio) || 0;

                    const yaAgregado = productosSeleccionados.some(p => p.id === id);

                    if (!yaAgregado) {
                        productosSeleccionados.push({
                            id: id,
                            nombre: nombre,
                            cantidad: 1,
                            precio_unitario: precio,
                            iva: 0
                        });
                        renderizarTabla();
                        const modal = bootstrap.Modal.getInstance(modalProductosEl) || new bootstrap.Modal(modalProductosEl);
                        modal.hide();
                    } else {
                        showAlert('El producto ya está agregado.', 'warning');
                    }
                }
            });
        } else {
            console.warn("Modal de selección de productos no encontrado. Asegúrate de que el ID sea 'modalProductos'.");
        }

        // CORRECCIÓN CLAVE: Actualizar el input oculto correspondiente sin reconstruir la tabla
        tbody.addEventListener('input', function(e) {
            const target = e.target;
            const index = parseInt(target.dataset.index);

            if (isNaN(index) || index < 0 || index >= productosSeleccionados.length) {
                console.error("Índice de producto inválido:", index);
                return;
            }

            let currentProduct = productosSeleccionados[index];
            let updated = false;
            let hiddenInputName = ''; // Para identificar el input oculto

            if (target.classList.contains('cantidad')) {
                let val = parseInt(target.value);
                if (val < 1 || isNaN(val)) val = 1;
                if (currentProduct.cantidad !== val) {
                    currentProduct.cantidad = val;
                    hiddenInputName = `detalles[${index}][cantidad]`;
                    updated = true;
                }
            } else if (target.classList.contains('precio_unitario')) {
                let val = parseFloat(target.value);
                if (val < 0 || isNaN(val)) val = 0;
                if (currentProduct.precio_unitario !== val) {
                    currentProduct.precio_unitario = val;
                    hiddenInputName = `detalles[${index}][precio_unitario]`;
                    updated = true;
                }
            } else if (target.classList.contains('iva')) {
                let val = parseFloat(target.value);
                if (val < 0 || isNaN(val)) val = 0;
                if (currentProduct.iva !== val) {
                    currentProduct.iva = val;
                    hiddenInputName = `detalles[${index}][iva]`;
                    updated = true;
                }
            }

            if (updated) {
                // Actualizar el valor del input oculto correspondiente
                const hiddenInput = form.querySelector(`input[name="${hiddenInputName}"]`);
                if (hiddenInput) {
                    hiddenInput.value = target.value;
                }

                // Actualizar la visualización del subtotal de la fila específica
                const row = target.closest('tr');
                const subtotalCell = row.children[4]; // Asumiendo que es la quinta columna (índice 4)
                const newSubtotal = calcularSubtotal(currentProduct.precio_unitario, currentProduct.cantidad, currentProduct.iva);
                subtotalCell.textContent = 'L. ' + newSubtotal.toFixed(2);

                actualizarTotal(); // Recalcular el total general
            }
        });

        tbody.addEventListener('click', function(e) {
            if (e.target.classList.contains('eliminar')) {
                const index = parseInt(e.target.dataset.index);
                if (isNaN(index) || index < 0 || index >= productosSeleccionados.length) {
                    console.error("Índice de producto a eliminar inválido:", index);
                    return;
                }
                productosSeleccionados.splice(index, 1);
                renderizarTabla(); // Aquí sí se llama para reconstruir después de eliminar
            }
        });

        form.addEventListener('submit', function(e) {
            if (productosSeleccionados.length === 0) {
                e.preventDefault();
                showAlert('Debe agregar al menos un producto a la factura.');
            }
        });
    });
</script>

<style>
    /* Estilo para el color del placeholder en campos oscuros */
    .form-control.bg-dark.text-white::placeholder {
        color: rgba(255, 255, 255, 0.7) !important; /* Blanco con un poco de transparencia */
    }
    /* Asegura que el texto del input también sea blanco y el fondo oscuro */
    .form-control.bg-dark.text-white {
        color: #fff !important;
        background-color: #343a40 !important; /* Fondo oscuro específico */
    }
    /* Para el input de fecha, asegurar el color del texto */
    input[type="date"].bg-dark.text-white {
        color: #fff !important;
    }
    /* Ajuste para el icono del calendario en input type="date" */
    input[type="date"].bg-dark.text-white::-webkit-calendar-picker-indicator {
        filter: invert(1); /* Invierte el color del icono del calendario a blanco */
    }
    /* Asegurar que las opciones del select también tengan fondo oscuro y texto blanco */
    .form-select.bg-dark.text-white {
        color: #fff !important;
        background-color: #343a40 !important;
    }
    .form-select.bg-dark.text-white option {
        background-color: #343a40 !important; /* Fondo oscuro para las opciones del select */
        color: #fff !important; /* Texto blanco para las opciones del select */
    }
</style>
