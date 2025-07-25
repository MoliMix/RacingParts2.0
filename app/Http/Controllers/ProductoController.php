<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException; // Importar para manejar específicamente errores de validación

class ProductoController extends Controller
{
    /**
     * Muestra una lista filtrada y paginada de productos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Aplicar filtros según los parámetros de la solicitud
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre' ) . '%');
        }

        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', '%' . $request->input('modelo') . '%');
        }

        if ($request->filled('anio')) {
            $query->where('anio', $request->input('anio'));
        }

        if ($request->filled('marca')) {
            $query->where('marca', $request->input('marca') . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->input('categoria'));    
        }

        // Contar productos filtrados y el total de productos sin filtrar
        $productosFiltrados = $query->count();
        $totalProductos = Producto::count();

        // Obtener productos paginados, ordenados por ID descendente
        $productos = $query->orderBy('id', 'desc')->paginate(5);

        return view('productos.index', compact('productos', 'productosFiltrados', 'totalProductos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre_completo' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'numero_id' => [
                    'required',
                    'string',
                    'max:15', 
                    Rule::unique('clientes', 'numero_id')->where(function ($query) use ($request) {
                        return $query->whereRaw('REPLACE(numero_id, "-", "") = ?', [str_replace('-', '', $request->input('numero_id'))]);
                    }),
                    function ($attribute, $value, $fail) {
                        $cleanDni = str_replace('-', '', $value); 
                        if (strlen($cleanDni) !== 13 || !is_numeric($cleanDni)) {
                            $fail('El número de identidad debe contener exactamente 13 dígitos numéricos.');
                            return; 
                        }
                    },
                ],
                'numero_telefono' => 'required|string|size:8|regex:/^\d{8}$/|unique:clientes,numero_telefono',
                'correo_electronico' => 'required|email|min:15|max:40',
                'direccion_cliente' => 'required|string|max:255',
                'sexo' => 'required|in:Masculino,Femenino,Otro',
                'fecha_ingreso' => 'required|date|before_or_equal:today',
            ], [
                'nombre_completo.required' => 'El nombre completo es obligatorio.',
                'nombre_completo.string' => 'El nombre completo debe ser una cadena de texto.',
                'nombre_completo.max' => 'El nombre completo no debe exceder los :max caracteres.',
                'nombre_completo.regex' => 'El nombre completo solo debe contener letras y espacios.',

                'numero_id.required' => 'El número de identidad es obligatorio.',
                'numero_id.string' => 'El número de identidad debe ser una cadena de texto.',
                'numero_id.max' => 'El número de identidad no debe exceder los :max caracteres.', 
                'numero_id.unique' => 'El número de identidad ya está registrado.',

                'numero_telefono.required' => 'El número de teléfono es obligatorio.',
                'numero_telefono.string' => 'El número de teléfono debe ser una cadena de texto.',
                'numero_telefono.size' => 'El número de teléfono inválido.',
                'numero_telefono.regex' => 'El formato del número de teléfono es incorrecto (solo números).',
                'numero_telefono.unique' => 'El número de teléfono ya está registrado por otro cliente.',

                'correo_electronico.required' => 'El correo electrónico es obligatorio.',
                'correo_electronico.email' => 'El correo electrónico debe ser una dirección válida.',
                'correo_electronico.min' => 'El correo electrónico debe tener al menos :min caracteres.',
                'correo_electronico.max' => 'El correo electrónico no debe exceder los :max caracteres.',

                'direccion_cliente.required' => 'La dirección del cliente es obligatoria.',
                'direccion_cliente.string' => 'La dirección del cliente debe ser una cadena de texto.',
                'direccion_cliente.max' => 'La dirección del cliente no debe exceder los :max caracteres.',

                'sexo.required' => 'El sexo es obligatorio.',
                'sexo.in' => 'El valor seleccionado para sexo no es válido.',

                'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
                'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
                'fecha_ingreso.before_or_equal' => 'La fecha de ingreso no puede ser una fecha futura.',
            ]);

            $validatedData['numero_id'] = str_replace('-', '', $validatedData['numero_id']);
            Producto::create($validatedData);

            return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el cliente: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Devuelve los datos del producto especificado en formato JSON.
     *
     * @param int $id El ID del producto a mostrar.
     * @return \Illuminate\Http\JsonResponse
     */
    public function showJson($id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }

    /**
         * Actualiza el producto especificado en la base de datos.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\Producto $producto
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update(Request $request, Producto $producto)
    {
        try {
            // Validar los datos de entrada del formulario para la actualización
            $validated = $request->validate([
                'nombre' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,19}$/'],
                // Corrección: La descripción debe comenzar con una letra y permitir letras, números, espacios y los signos (,.-())
                'descripcion' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-Z0-9\s\(\),\.\-áéíóúÁÉÍÓÚñÑ]{0,99}$/'],
                'marca' => ['required', Rule::in(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'])],
                'modelo' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z][a-zA-Z0-9\s\-]{0,49}$/'], // Estandarizado: debe empezar con letra
                'anio' => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . date('Y')],
                'categoria' => ['required', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],
            ], [
                // Mensajes de validación personalizados
                'nombre.required' => 'El nombre del producto es obligatorio.',
                'nombre.string' => 'El nombre del producto debe ser una cadena de texto.',
                'nombre.max' => 'El nombre del producto no debe exceder los :max caracteres.',
                'nombre.regex' => 'El nombre debe comenzar con una letra y solo contener letras y espacios.',

                'descripcion.required' => 'La descripción es obligatoria.',
                'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                'descripcion.max' => 'La descripción no debe exceder los :max caracteres.',
                'descripcion.regex' => 'La descripción solo puede contener letras, números, espacios y los signos (,.-()).',

                'marca.required' => 'La marca es obligatoria.',
                'marca.in' => 'La marca seleccionada no es válida.',

                'modelo.required' => 'El modelo es obligatorio.',
                'modelo.string' => 'El modelo debe ser una cadena de texto.',
                'modelo.max' => 'El modelo no debe exceder los :max caracteres.',
                'modelo.regex' => 'El modelo debe comenzar con una letra y puede incluir letras, números, guiones y espacios.',

                'anio.required' => 'El año es obligatorio.',
                'anio.digits' => 'El año debe tener 4 dígitos.',
                'anio.integer' => 'El año debe ser un número entero.',
                'anio.min' => 'El año no puede ser anterior a :min.',
                'anio.max' => 'El año no puede ser posterior a :max.',

                'categoria.required' => 'La categoría es obligatoria.',
                'categoria.in' => 'La categoría seleccionada no es válida.',
            ]);

            // Verificar si la combinación de atributos ya existe para otro producto (excluyendo el actual)
            $existe = Producto::where('nombre', $validated['nombre'])
                ->where('marca', $validated['marca'])
                ->where('modelo', $validated['modelo'])
                ->where('anio', $validated['anio'])
                ->where('categoria', $validated['categoria'])
                ->where('id', '<>', $producto->id) // Excluye el producto actual de la comprobación de unicidad
                ->exists();

            if ($existe) {
                // Si existe un duplicado, redirige hacia atrás con un error y los datos ingresados
                return back()
                    ->withErrors(['duplicado' => 'Ya existe un producto con esa combinación de nombre, marca, modelo, año y categoría.'])
                    ->withInput();
            }

            // Actualizar el producto con los datos validados
            $producto->update($validated);

            // Redirigir a la lista de productos con un mensaje de éxito
            return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');

        } catch (ValidationException $e) {
            // Captura errores de validación y redirige hacia atrás con los mensajes de error
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Captura cualquier otro error inesperado durante el proceso de actualización
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el producto: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Elimina el producto especificado de la base de datos.
     *
     * @param int $id El ID del producto a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            // Captura errores durante la eliminación (ej. restricciones de clave foránea)
            return redirect()->route('productos.index')->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Muestra los detalles del producto especificado.
     *
     * @param \App\Models\Producto $producto La instancia del producto a mostrar.
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }
    

    /**
     * Muestra el formulario para editar el producto especificado.
     *
     * @param int $id El ID del producto a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }
}