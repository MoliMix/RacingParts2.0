<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta; // Necesario para crear detalles
use App\Models\Producto;           // Necesario para relacionar productos
use Illuminate\Http\Request;       // ¡Importante para manejar las peticiones!
use Illuminate\Support\Facades\DB; // Para transacciones de base de datos

class FacturaController extends Controller
{
    /**
     * Muestra una lista de todas las facturas de venta.
     * Incluye los detalles y productos relacionados, y las pagina.
     */
    public function index()
    {
        // Obtiene las facturas con sus detalles y productos, paginadas
        // La cadena 'detalles.producto' indica que quieres cargar la relación 'detalles'
        // y dentro de cada detalle, la relación 'producto'.
        $facturas = FacturaVenta::with('detalles.producto')
            ->orderBy('created_at', 'desc') // Ordena las facturas por fecha de creación descendente
            ->paginate(5); // Pagina los resultados, mostrando 5 facturas por página

        // Retorna la vista 'facturas.index' enviando las facturas
        return view('facturas.index', compact('facturas'));
    }

    /**
     * Muestra el formulario para crear una nueva factura.
     * Aquí podrías pasar datos necesarios para el formulario, como una lista de productos.
     */
    public function create()
    {
        // Selecciona solo los atributos necesarios de los productos para evitar problemas de serialización
        // Esto asegura que @json($productos) en la vista genere un JSON limpio y válido.
        $productos = Producto::select('id', 'nombre', 'marca', 'modelo', 'anio', 'categoria', 'precio')->get();
        return view('facturas.create', compact('productos'));
    }

    /**
     * Almacena una nueva factura de venta en la base de datos.
     * Maneja la creación de la factura principal y sus detalles.
     */
    public function store(Request $request)
    {
        // Valida los datos de la petición
        $request->validate([
            'fecha' => 'required|date',
            'cliente' => 'required|string|max:255',
            'detalles' => 'required|array|min:1', // Debe haber al menos un detalle
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.iva' => 'required|numeric|min:0', // Asegurarse de validar el IVA del detalle
        ]);

        // Usar una transacción para asegurar que tanto la factura como sus detalles se guarden correctamente
        // Si algo falla, se revierte todo.
        DB::transaction(function () use ($request) {
            $subtotalFactura = 0; // Subtotal de la factura antes de IVA
            $ivaTotalFactura = 0; // IVA total de la factura
            $totalFactura = 0;   // Total final de la factura (Subtotal + IVA)

            // Recorrer los detalles para calcular subtotales y total
            foreach ($request->detalles as $detalleData) {
                $cantidad = $detalleData['cantidad'];
                $precioUnitario = $detalleData['precio_unitario'];
                $ivaDetalle = $detalleData['iva']; // Usar el IVA enviado desde el formulario para el detalle

                $subtotalDetalle = $cantidad * $precioUnitario; // Subtotal por detalle
                $subtotalFactura += $subtotalDetalle;

                $ivaTotalFactura += $ivaDetalle; // Sumar el IVA de cada detalle
            }

            $totalFactura = $subtotalFactura + $ivaTotalFactura; // Calcular el total final

            // Crear la factura principal
            $factura = FacturaVenta::create([
                'fecha' => $request->fecha,
                'cliente' => $request->cliente,
                'subtotal' => $subtotalFactura, // ¡Añadido el subtotal de la factura principal!
                'iva' => $ivaTotalFactura,     // Añadimos el IVA total de la factura
                'total' => $totalFactura,      // Usamos el campo 'total' según tu modelo
            ]);

            // Guardar los detalles de la factura
            foreach ($request->detalles as $detalleData) {
                $cantidad = $detalleData['cantidad'];
                $precioUnitario = $detalleData['precio_unitario'];
                $ivaDetalle = $detalleData['iva']; // Usar el IVA enviado desde el formulario para el detalle

                $subtotalDetalle = $cantidad * $precioUnitario; // Subtotal por detalle

                $factura->detalles()->create([
                    'producto_id' => $detalleData['producto_id'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'iva' => $ivaDetalle, // IVA del detalle
                    'subtotal' => $subtotalDetalle, // Subtotal del detalle
                ]);
            }
        });

        // Redirige a la lista de facturas con un mensaje de éxito
        return redirect()->route('facturas.index')->with('success', 'Factura creada exitosamente.');
    }

    /**
     * Muestra una factura de venta específica.
     */
    public function show(FacturaVenta $factura) // Laravel inyecta automáticamente la factura por ID
    {
        // Carga las relaciones 'detalles' y 'producto' si no están ya cargadas
        $factura->load('detalles.producto');
        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar una factura existente.
     */
    public function edit(FacturaVenta $factura)
    {
        $factura->load('detalles.producto'); // Carga los detalles para el formulario
        $productos = Producto::all(); // También necesitas la lista de productos
        return view('facturas.edit', compact('factura', 'productos'));
    }

    /**
     * Actualiza una factura de venta existente en la base de datos.
     * Maneja la actualización de la factura principal y sus detalles.
     */
    public function update(Request $request, FacturaVenta $factura)
    {
        $request->validate([
            'fecha' => 'required|date',
            'cliente' => 'required|string|max:255',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.iva' => 'required|numeric|min:0', // Validar IVA del detalle
        ]);

        DB::transaction(function () use ($request, $factura) {
            $subtotalFactura = 0;
            $ivaTotalFactura = 0;
            $totalFactura = 0;

            foreach ($request->detalles as $detalleData) {
                $cantidad = $detalleData['cantidad'];
                $precioUnitario = $detalleData['precio_unitario'];
                $ivaDetalle = $detalleData['iva'];

                $subtotalDetalle = $cantidad * $precioUnitario;
                $subtotalFactura += $subtotalDetalle;

                $ivaTotalFactura += $ivaDetalle;
            }

            $totalFactura = $subtotalFactura + $ivaTotalFactura;

            $factura->update([
                'fecha' => $request->fecha,
                'cliente' => $request->cliente,
                'subtotal' => $subtotalFactura, // Actualizado el subtotal de la factura principal
                'iva' => $ivaTotalFactura,
                'total' => $totalFactura,
            ]);

            // Eliminar los detalles existentes y recrearlos (simplificado para este ejemplo)
            // En una aplicación real, podrías querer comparar y actualizar solo los cambios.
            $factura->detalles()->delete();

            foreach ($request->detalles as $detalleData) {
                $cantidad = $detalleData['cantidad'];
                $precioUnitario = $detalleData['precio_unitario'];
                $ivaDetalle = $detalleData['iva'];

                $subtotalDetalle = $cantidad * $precioUnitario;

                $factura->detalles()->create([
                    'producto_id' => $detalleData['producto_id'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'iva' => $ivaDetalle,
                    'subtotal' => $subtotalDetalle,
                ]);
            }
        });

        return redirect()->route('facturas.index')->with('success', 'Factura actualizada exitosamente.');
    }

    /**
     * Elimina una factura de venta específica de la base de datos.
     * Asegúrate de manejar la eliminación en cascada de los detalles.
     */
    public function destroy(FacturaVenta $factura)
    {
        // Laravel maneja la eliminación en cascada si está configurada en la base de datos
        // o puedes eliminar los detalles manualmente primero:
        // $factura->detalles()->delete();
        $factura->delete();

        return redirect()->route('facturas.index')->with('success', 'Factura eliminada exitosamente.');
    }
}
