<?php

namespace App\Http\Controllers;

use App\Models\FacturaVenta;
use App\Models\DetalleFacturaVenta; // Necesario para crear detalles
use App\Models\Producto;           // Necesario para relacionar productos
use Illuminate\Http\Request;       // ¡Importante para manejar las peticiones!
use Illuminate\Support\Facades\DB; // Para transacciones de base de datos
use Illuminate\Support\Str;        // Para generar cadenas aleatorias

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
        $productos = Producto::select('id', 'nombre', 'marca', 'modelo', 'anio', 'categoria', 'precio', 'stock')->get(); // Asegúrate de seleccionar 'stock'

        // Sacas las marcas y categorías únicas de los productos para los filtros
        $marcas = $productos->pluck('marca')->unique()->sort()->values();
        $categorias = $productos->pluck('categoria')->unique()->sort()->values();

        // Retornas la vista con todas las variables necesarias
        return view('facturas.create', compact('productos', 'marcas', 'categorias'));
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
        try {
            DB::transaction(function () use ($request) {
                $subtotalFactura = 0; // Subtotal de la factura antes de IVA
                $ivaTotalFactura = 0; // IVA total de la factura
                $totalFactura = 0;   // Total final de la factura (Subtotal + IVA)

                // Primero validar stock para todos los productos antes de crear factura
                foreach ($request->detalles as $detalleData) {
                    $producto = Producto::find($detalleData['producto_id']);
                    if (!$producto) {
                        throw new \Exception("Producto con ID {$detalleData['producto_id']} no encontrado.");
                    }
                    if ($producto->stock < $detalleData['cantidad']) {
                        throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}. Stock disponible: {$producto->stock}, Cantidad solicitada: {$detalleData['cantidad']}");
                    }
                }

                // Generar un código único para la factura
                // Formato: FAC-YYYYMMDD-XXXXXX (donde XXXXXX es una cadena aleatoria de 6 caracteres)
                $codigoFactura = 'FAC-' . date('Ymd') . '-' . Str::random(6);
                // Asegurar unicidad (aunque con fecha y random es muy improbable una colisión)
                while (FacturaVenta::where('codigo', $codigoFactura)->exists()) {
                    $codigoFactura = 'FAC-' . date('Ymd') . '-' . Str::random(6);
                }


                // Calcular totales
                foreach ($request->detalles as $detalleData) {
                    $subtotalFactura += $detalleData['cantidad'] * $detalleData['precio_unitario'];
                    $ivaTotalFactura += $detalleData['iva'];
                }

                $totalFactura = $subtotalFactura + $ivaTotalFactura; // Calcular el total final

                // Crear la factura principal
                $factura = FacturaVenta::create([
                    'codigo' => $codigoFactura, // Asignar el código generado
                    'fecha' => $request->fecha,
                    'cliente' => $request->cliente,
                    'subtotal' => $subtotalFactura, // ¡Añadido el subtotal de la factura principal!
                    'iva' => $ivaTotalFactura,     // Añadimos el IVA total de la factura
                    'total' => $totalFactura,      // Usamos el campo 'total' según tu modelo
                ]);

                // Guardar los detalles de la factura
                foreach ($request->detalles as $detalleData) {
                    $cantidad = $detalleData['cantidad'];

                    $factura->detalles()->create([
                        'producto_id' => $detalleData['producto_id'],
                        'cantidad' => $cantidad,
                        'precio_unitario' => $detalleData['precio_unitario'],
                        'iva' => $detalleData['iva'], // IVA del detalle
                        'subtotal' => $cantidad * $detalleData['precio_unitario'], // Subtotal del detalle
                    ]);

                    $producto = Producto::find($detalleData['producto_id']);
                    $producto->stock -= $cantidad;
                    $producto->save();
                }
            });

            // Redirige a la lista de facturas con un mensaje de éxito
            return redirect()->route('facturas.index')->with('success', 'Factura creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
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

        // Obtener todos los productos para el modal de selección, incluyendo stock y precio
        $productos = Producto::select('id', 'nombre', 'marca', 'modelo', 'anio', 'categoria', 'precio', 'stock')->get();

        // Sacar las marcas y categorías únicas de todos los productos para los filtros del modal
        $marcas = $productos->pluck('marca')->unique()->sort()->values();
        $categorias = $productos->pluck('categoria')->unique()->sort()->values();

        // Retornar la vista de edición con la factura, todos los productos, marcas y categorías
        return view('facturas.edit', compact('factura', 'productos', 'marcas', 'categorias'));
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

        try { // Añadido try-catch para manejar excepciones de stock
            DB::transaction(function () use ($request, $factura) {
                // Restaurar stock de productos anteriores
                foreach ($factura->detalles as $detalleAnterior) {
                    $producto = Producto::find($detalleAnterior->producto_id);
                    if ($producto) { // Asegurarse de que el producto exista antes de restaurar stock
                        $producto->stock += $detalleAnterior->cantidad;
                        $producto->save();
                    }
                }

                // Validar stock para nuevos detalles
                foreach ($request->detalles as $detalleData) {
                    $producto = Producto::find($detalleData['producto_id']);
                    if (!$producto) {
                        throw new \Exception("Producto con ID {$detalleData['producto_id']} no encontrado para la actualización.");
                    }
                    if ($producto->stock < $detalleData['cantidad']) {
                        throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}. Stock disponible: {$producto->stock}, Cantidad solicitada: {$detalleData['cantidad']}");
                    }
                }

                // Eliminar detalles anteriores
                $factura->detalles()->delete();

                // Calcular totales nuevos
                $subtotalFactura = 0;
                $ivaTotalFactura = 0;

                foreach ($request->detalles as $detalleData) {
                    $subtotalFactura += $detalleData['cantidad'] * $detalleData['precio_unitario'];
                    $ivaTotalFactura += $detalleData['iva'];
                }

                // Actualizar factura
                $factura->update([
                    // El código no se actualiza, ya que es un identificador único generado una vez
                    'fecha' => $request->fecha,
                    'cliente' => $request->cliente,
                    'subtotal' => $subtotalFactura, // Actualizado el subtotal de la factura principal
                    'iva' => $ivaTotalFactura,
                    'total' => $subtotalFactura + $ivaTotalFactura,
                ]);

                // Guardar nuevos detalles y descontar stock
                foreach ($request->detalles as $detalleData) {
                    $cantidad = $detalleData['cantidad'];

                    $factura->detalles()->create([
                        'producto_id' => $detalleData['producto_id'],
                        'cantidad' => $cantidad,
                        'precio_unitario' => $detalleData['precio_unitario'],
                        'iva' => $detalleData['iva'], // Usar $detalleData['iva'] en lugar de $ivaDetalle
                        'subtotal' => $cantidad * $detalleData['precio_unitario'],
                    ]);

                    $producto = Producto::find($detalleData['producto_id']);
                    if ($producto) { // Asegurarse de que el producto exista antes de descontar stock
                        $producto->stock -= $cantidad;
                        $producto->save();
                    }
                }
            });

            return redirect()->route('facturas.index')->with('success', 'Factura actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Elimina una factura de venta específica de la base de datos.
     * Asegúrate de manejar la eliminación en cascada de los detalles.
     */
    public function destroy(FacturaVenta $factura)
    {
        try { // Añadido try-catch para manejar excepciones
            DB::transaction(function () use ($factura) {
                // Restaurar stock antes de eliminar factura
                foreach ($factura->detalles as $detalle) {
                    $producto = Producto::find($detalle->producto_id);
                    if ($producto) { // Asegurarse de que el producto exista antes de restaurar stock
                        $producto->stock += $detalle->cantidad;
                        $producto->save();
                    }
                }

                $factura->delete();
            });

            return redirect()->route('facturas.index')->with('success', 'Factura eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la factura: ' . $e->getMessage());
        }
    }
}
