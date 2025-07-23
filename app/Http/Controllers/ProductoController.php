<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Importa la clase Rule para validaciones de tipo 'in'

class ProductoController extends Controller
{
    /**
     * Muestra una lista de productos, con funcionalidad de filtrado y paginación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Inicia una nueva consulta sobre el modelo Producto.
        $query = Producto::query();

        // Aplica filtros si los parámetros de la solicitud están presentes.
        // El método 'filled' verifica si el parámetro existe y no está vacío.
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', '%' . $request->modelo . '%');
        }

        if ($request->filled('anio')) {
            // 'anio' se busca por coincidencia exacta ya que es un número.
            $query->where('anio', $request->anio);
        }

        if ($request->filled('marca')) {
            $query->where('marca', $request->marca);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Cuenta el número de productos después de aplicar los filtros.
        $productosFiltrados = $query->count();
        // Cuenta el número total de productos en la base de datos sin filtros.
        $totalProductos = Producto::count();

        // Obtiene los productos paginados (5 por página) y ordenados por ID de forma descendente.
        $productos = $query->orderBy('id', 'desc')->paginate(5);

        // Retorna la vista 'productos.index' pasando los productos, el conteo de filtrados
        // y el total de productos para su visualización.
        return view('productos.index', compact('productos', 'productosFiltrados', 'totalProductos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Simplemente retorna la vista donde se encuentra el formulario de creación.
        return view('productos.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     * Realiza validación de los datos de entrada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Valida los datos de la solicitud. Si la validación falla, Laravel
        // automáticamente redirige de vuelta con los errores y los inputs.
        $validated = $request->validate([
            // 'nombre': Requerido, string, máximo 20 caracteres.
            // Regex: Debe empezar con una letra (incluyendo acentos y 'ñ'),
            // seguido de 0 a 19 caracteres que pueden ser letras, acentos, 'ñ' o espacios.
            'nombre' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,19}$/'],

            // 'descripcion': Requerido, string, máximo 100 caracteres.
            // Regex: Debe empezar con una letra (incluyendo acentos y 'ñ'),
            // seguido de 0 a 99 caracteres que pueden ser letras, números, acentos, 'ñ' o espacios.
            'descripcion' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]{0,99}$/'],

            // 'marca': Requerido, y debe ser uno de los valores especificados en el array.
            'marca' => ['required', Rule::in(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'])],

            // 'modelo': Requerido, string, máximo 50 caracteres.
            // Regex: Debe empezar con una letra, seguido de 0 a 49 caracteres que pueden ser letras, números, espacios o guiones.
            'modelo' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z][a-zA-Z0-9\s\-]{0,49}$/'],

            // 'anio': Requerido, 4 dígitos, entero, mínimo 1990, máximo el año actual.
            'anio' => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . date('Y')],

            // 'categoria': Requerido, y debe ser uno de los valores especificados en el array.
            'categoria' => ['required', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],

            // 'stock': Requerido, entero, mínimo 0.
            'stock' => 'required|integer|min:0',

            // 'precio': Requerido, numérico, mínimo 0.
            'precio' => 'required|numeric|min:0',
        ]);

        // Verifica si ya existe un producto con la misma combinación de atributos clave.
        $existe = Producto::where('nombre', $validated['nombre'])
            ->where('marca', $validated['marca'])
            ->where('modelo', $validated['modelo'])
            ->where('anio', $validated['anio'])
            ->where('categoria', $validated['categoria'])
            ->exists();

        // Si el producto ya existe, redirige de vuelta con un error y los datos de entrada.
        if ($existe) {
            return back()
                ->withErrors(['duplicado' => 'Ya existe un producto con esa combinación de nombre, marca, modelo, año y categoría.'])
                ->withInput();
        }

        // Si la validación pasa y el producto no es un duplicado, crea el nuevo producto.
        Producto::create($validated);

        // Redirige a la ruta 'productos.index' con un mensaje de éxito.
        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    /**
     * Muestra los detalles de un producto específico.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        // Retorna la vista 'productos.show' pasando el objeto Producto.
        // Laravel automáticamente inyecta el modelo Producto basado en el ID de la ruta.
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Busca el producto por su ID o lanza una excepción 404 si no se encuentra.
        $producto = Producto::findOrFail($id);
        // Retorna la vista 'productos.edit' pasando el objeto Producto encontrado.
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     * Realiza validación de los datos de entrada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        // Valida los datos de la solicitud para la actualización.
        $validated = $request->validate([
            // Las reglas son similares a 'store', pero los regex se ajustan para permitir
            // que el primer carácter no sea un espacio o dígito en algunos casos.
            'nombre' => ['required', 'string', 'max:20', 'regex:/^[^\s\d][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]{0,19}$/'],
            'descripcion' => ['required', 'string', 'max:100', 'regex:/^[^\s\d][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]*$/'],
            'marca' => ['required', 'string', Rule::in(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'])],
            'modelo' => ['required', 'string', 'max:50', 'regex:/^[^\s][a-zA-Z0-9\s\-]*$/'],
            'anio' => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . date('Y')],
            'categoria' => ['required', 'string', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);

        // Verifica si la combinación de atributos clave ya existe para OTRO producto.
        // Se excluye el producto actual de la verificación de duplicados para permitir actualizaciones.
        $existe = Producto::where('nombre', $validated['nombre'])
            ->where('marca', $validated['marca'])
            ->where('modelo', $validated['modelo'])
            ->where('anio', $validated['anio'])
            ->where('categoria', $validated['categoria'])
            ->where('id', '<>', $producto->id) // Excluye el producto actual
            ->exists();

        // Si la combinación ya existe en otro producto, redirige de vuelta con un error.
        if ($existe) {
            return back()
                ->withErrors(['duplicado' => 'Ya existe un producto con esa combinación de nombre, marca, modelo, año y categoría.'])
                ->withInput();
        }

        // Actualiza el producto con los datos validados.
        $producto->update($validated);

        // Redirige a la ruta 'productos.index' con un mensaje de éxito.
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto específico de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busca el producto por su ID o lanza una excepción 404 si no se encuentra.
        $producto = Producto::findOrFail($id);
        // Elimina el producto.
        $producto->delete();
        // Redirige a la ruta 'productos.index' con un mensaje de éxito.
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
