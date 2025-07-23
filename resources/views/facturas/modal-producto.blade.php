<div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable"> {{-- Modal más grande: modal-xl --}}
        <div class="modal-content bg-dark text-white">
            <div class="modal-header d-block"> {{-- d-block para que el row de filtros ocupe todo el ancho --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="modal-title" id="modalProductosLabel">Seleccionar productos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                {{-- Contenedor para filtros sin fondo oscuro, con espaciado --}}
                <div class="row g-2 mt-3 w-100"> {{-- g-2 para un mejor espaciado entre columnas --}}
                    <div class="col-md-6"> {{-- Dos filtros por fila en md y superior --}}
                        <input type="text" id="filtroNombre" class="form-control form-control-sm bg-dark text-white" placeholder="Buscar por Nombre">
                    </div>
                    <div class="col-md-6">
                        <select id="filtroMarca" class="form-select form-select-sm bg-dark text-white">
                            <option value="">Todas las Marcas</option>
                            {{-- Opciones se llenarán con JavaScript --}}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="filtroModelo" class="form-control form-control-sm bg-dark text-white" placeholder="Buscar por Modelo">
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="filtroAnio" class="form-control form-control-sm bg-dark text-white" placeholder="Buscar por Año">
                    </div>
                    <div class="col-md-12"> {{-- Último filtro ocupa todo el ancho --}}
                        <select id="filtroCategoria" class="form-select form-select-sm bg-dark text-white">
                            <option value="">Todas las Categorías</option>
                            {{-- Opciones se llenarán con JavaScript --}}
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-dark table-hover text-center align-middle">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Stock</th> {{-- Nueva columna --}}
                        <th>Cantidad a Vender</th> {{-- Nueva columna --}}
                        <th>Precio Unitario (L.)</th> {{-- Nueva columna --}}
                        <th>IVA (L.)</th> {{-- Nueva columna --}}
                        <th>Subtotal (L.)</th> {{-- Nueva columna --}}
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody id="modalProductosTbody"> {{-- ID para el tbody del modal --}}
                    {{-- Los productos se renderizarán aquí con JavaScript --}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript para manejar la tabla de productos en el modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 'productos' debe estar disponible globalmente o pasarse al script.
        // Si este script se incluye en create.blade.php, 'productos' ya está disponible.
        const todosLosProductos = @json($productos); // La lista completa de productos del controlador
        const modalProductosTbody = document.getElementById('modalProductosTbody');

        const filtroNombre = document.getElementById('filtroNombre');
        const filtroMarca = document.getElementById('filtroMarca');
        const filtroModelo = document.getElementById('filtroModelo');
        const filtroAnio = document.getElementById('filtroAnio');
        const filtroCategoria = document.getElementById('filtroCategoria');

        // Función para calcular subtotal de un producto (dentro del modal)
        function calcularSubtotalModal(precio, cantidad, iva) {
            const p = parseFloat(precio) || 0;
            const c = parseInt(cantidad) || 0;
            const i = parseFloat(iva) || 0;
            return (p * c) + i;
        }

        // Función para renderizar los productos en la tabla del modal
        function renderizarProductosModal(productosARenderizar) {
            modalProductosTbody.innerHTML = ''; // Limpiar la tabla

            if (productosARenderizar.length === 0) {
                modalProductosTbody.innerHTML = `<tr><td colspan="10">No se encontraron productos.</td></tr>`; // Ajuste colspan
                return;
            }

            productosARenderizar.forEach(producto => {
                const tr = document.createElement('tr');
                const defaultPrecio = parseFloat(producto.precio || 0).toFixed(2);
                const defaultCantidad = 1; // Cantidad inicial
                const defaultIva = 0; // IVA inicial
                const initialSubtotal = calcularSubtotalModal(defaultPrecio, defaultCantidad, defaultIva).toFixed(2);
                const stock = producto.stock !== undefined && producto.stock !== null ? producto.stock : 'N/A'; // Manejo de stock

                tr.innerHTML = `
                    <td>${producto.nombre}</td>
                    <td>${producto.marca}</td>
                    <td>${producto.modelo}</td>
                    <td>${producto.anio}</td>
                    <td>${stock}</td> {{-- Mostrar stock --}}
                <td>
                    <input type="number" min="1" value="${defaultCantidad}" class="form-control form-control-sm bg-dark text-white cantidad-venta-modal" data-id="${producto.id}" data-stock="${stock}">
                    </td>
                    <td>
                        <input type="number" min="0" step="0.01" value="${defaultPrecio}" class="form-control form-control-sm bg-dark text-white precio-unitario-modal" data-id="${producto.id}">
                    </td>
                    <td>
                        <input type="number" min="0" step="0.01" value="${defaultIva}" class="form-control form-control-sm bg-dark text-white iva-modal" data-id="${producto.id}">
                    </td>
                    <td class="subtotal-modal">L. ${initialSubtotal}</td> {{-- Subtotal dinámico --}}
                <td>
                    <button type="button" class="btn btn-success btn-sm agregar-producto"
                            data-id="${producto.id}"
                                data-nombre="${producto.nombre}"
                                data-precio-base="${defaultPrecio}" {{-- Precio base original --}}
                data-stock="${stock}"
                        >Agregar</button>
                    </td>
                `;
                modalProductosTbody.appendChild(tr);
            });

            // Añadir event listeners para los inputs de cantidad, precio, iva dentro del modal
            modalProductosTbody.querySelectorAll('.cantidad-venta-modal, .precio-unitario-modal, .iva-modal').forEach(input => {
                input.addEventListener('input', function() {
                    const row = this.closest('tr');
                    const cantidadInput = row.querySelector('.cantidad-venta-modal');
                    const precioInput = row.querySelector('.precio-unitario-modal');
                    const ivaInput = row.querySelector('.iva-modal');
                    const subtotalCell = row.querySelector('.subtotal-modal');
                    const stock = parseInt(cantidadInput.dataset.stock);

                    let cantidad = parseInt(cantidadInput.value) || 0;
                    let precio = parseFloat(precioInput.value) || 0;
                    let iva = parseFloat(ivaInput.value) || 0;

                    // Validar cantidad vs stock
                    if (stock !== 'N/A' && cantidad > stock) {
                        cantidad = stock; // Limitar la cantidad al stock disponible
                        cantidadInput.value = stock;
                        // Opcional: mostrar una alerta al usuario
                        // showAlert('La cantidad no puede exceder el stock disponible.', 'warning');
                    }
                    if (cantidad < 1) { // Asegurar cantidad mínima
                        cantidad = 1;
                        cantidadInput.value = 1;
                    }


                    const subtotal = calcularSubtotalModal(precio, cantidad, iva);
                    subtotalCell.textContent = 'L. ' + subtotal.toFixed(2);
                });
            });
        }

        // Función para filtrar los productos
        function filtrarProductos() {
            const nombre = filtroNombre.value.toLowerCase();
            const marca = filtroMarca.value.toLowerCase();
            const modelo = filtroModelo.value.toLowerCase();
            const anio = filtroAnio.value.toLowerCase();
            const categoria = filtroCategoria.value.toLowerCase();

            const productosFiltrados = todosLosProductos.filter(producto => {
                return (nombre === '' || (producto.nombre && producto.nombre.toLowerCase().includes(nombre))) &&
                    (marca === '' || (producto.marca && producto.marca.toLowerCase() === marca)) &&
                    (modelo === '' || (producto.modelo && producto.modelo.toLowerCase().includes(modelo))) &&
                    (anio === '' || (producto.anio && String(producto.anio).toLowerCase().includes(anio))) &&
                    (categoria === '' || (producto.categoria && producto.categoria.toLowerCase() === categoria));
            });
            renderizarProductosModal(productosFiltrados);
        }

        // Función para poblar los selectores de marca y categoría
        function poblarSelectores() {
            const uniqueMarcas = [...new Set(todosLosProductos.map(p => p.marca).filter(Boolean))].sort();
            const uniqueCategorias = [...new Set(todosLosProductos.map(p => p.categoria).filter(Boolean))].sort();

            uniqueMarcas.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca.toLowerCase();
                option.textContent = marca;
                filtroMarca.appendChild(option);
            });

            uniqueCategorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.toLowerCase();
                option.textContent = categoria;
                filtroCategoria.appendChild(option);
            });
        }

        // Añadir event listeners a los campos de filtro
        filtroNombre.addEventListener('input', filtrarProductos);
        filtroMarca.addEventListener('change', filtrarProductos);
        filtroModelo.addEventListener('input', filtrarProductos);
        filtroAnio.addEventListener('input', filtrarProductos);
        filtroCategoria.addEventListener('change', filtrarProductos);

        // Renderizar todos los productos al cargar el modal inicialmente
        renderizarProductosModal(todosLosProductos);
        // Poblar los selectores al cargar el modal
        poblarSelectores();


        // Limpiar filtros cuando se cierra el modal
        const modalProductosEl = document.getElementById('modalProductos');
        if (modalProductosEl) {
            modalProductosEl.addEventListener('hidden.bs.modal', function () {
                filtroNombre.value = '';
                filtroMarca.value = ''; // Resetear select a la opción "Todas"
                filtroModelo.value = '';
                filtroAnio.value = '';
                filtroCategoria.value = ''; // Resetear select a la opción "Todas"
                renderizarProductosModal(todosLosProductos); // Volver a mostrar todos los productos
            });
        }

        // Delegación de eventos para el botón 'Agregar' dentro del modal
        modalProductosTbody.addEventListener('click', function(e) {
            if (e.target.classList.contains('agregar-producto')) {
                const btn = e.target;
                const row = btn.closest('tr'); // Obtener la fila del botón
                const id = parseInt(btn.dataset.id);
                const nombre = btn.dataset.nombre;
                const precioBase = parseFloat(btn.dataset.precioBase) || 0;
                const stock = parseInt(btn.dataset.stock);

                // Obtener los valores actuales de los inputs de la fila
                const cantidadInput = row.querySelector('.cantidad-venta-modal');
                const precioUnitarioInput = row.querySelector('.precio-unitario-modal');
                const ivaInput = row.querySelector('.iva-modal');

                let cantidad = parseInt(cantidadInput.value) || 0;
                let precioUnitario = parseFloat(precioUnitarioInput.value) || 0;
                let iva = parseFloat(ivaInput.value) || 0;

                // Validación básica antes de agregar
                if (cantidad < 1 || isNaN(cantidad)) {
                    // Opcional: Mostrar una alerta al usuario
                    // showAlert('La cantidad a vender debe ser al menos 1.', 'warning');
                    cantidadInput.focus(); // Poner el foco en el campo
                    return;
                }
                if (stock !== 'N/A' && cantidad > stock) {
                    // showAlert('La cantidad a vender no puede exceder el stock disponible.', 'warning');
                    cantidadInput.focus();
                    return;
                }
                if (precioUnitario < 0 || isNaN(precioUnitario)) {
                    // showAlert('El precio unitario debe ser un número positivo.', 'warning');
                    precioUnitarioInput.focus();
                    return;
                }
                if (iva < 0 || isNaN(iva)) {
                    // showAlert('El IVA debe ser un número positivo.', 'warning');
                    ivaInput.focus();
                    return;
                }

                const subtotalCalculado = calcularSubtotalModal(precioUnitario, cantidad, iva);

                // Crear un objeto con los datos del producto seleccionado
                const productoSeleccionado = {
                    id: id,
                    nombre: nombre,
                    cantidad: cantidad,
                    precio_unitario: precioUnitario,
                    iva: iva,
                    subtotal: subtotalCalculado // Incluir el subtotal calculado
                };

                // Disparar un evento personalizado para que create.blade.php lo escuche
                const event = new CustomEvent('productSelected', { detail: productoSeleccionado });
                document.dispatchEvent(event);

                // Ocultar el modal de selección de productos
                const modal = bootstrap.Modal.getInstance(modalProductosEl) || new bootstrap.Modal(modalProductosEl);
                if (modal) {
                    modal.hide();
                }
            }
        });
    });
</script>

<style>
    /* Estilo para el color del placeholder en campos oscuros */
    .form-control.bg-dark.text-white::placeholder,
    .form-select.bg-dark.text-white::placeholder {
        color: rgba(255, 255, 255, 0.7) !important; /* Blanco con un poco de transparencia */
    }
    .form-select.bg-dark.text-white option {
        background-color: #343a40; /* Fondo oscuro para las opciones del select */
        color: #fff; /* Texto blanco para las opciones del select */
    }
    /* Asegura que el texto de los inputs en el modal también sea blanco */
    .form-control.bg-dark.text-white {
        color: #fff !important;
    }
</style>
