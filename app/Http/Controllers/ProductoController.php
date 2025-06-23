<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();
        $totalProductos = Producto::count();
        $productosFiltrados = $totalProductos; // Valor por defecto

        if ($request->has('search') && $request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('descripcion', 'like', "%$search%")
                    ->orWhere('marca', 'like', "%$search%")
                    ->orWhere('modelo', 'like', "%$search%");
            });

            $productosFiltrados = $query->count(); // Cuántos se encontraron con filtro
        }

        $productos = $query->orderBy('id', 'desc')->paginate(10);

        return view('productos.index', compact('productos', 'productosFiltrados', 'totalProductos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'descripcion' => ['required', 'string', 'max:100'],
            'marca' => ['required', Rule::in(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'])],
            'modelo' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
            'anio' => ['required', 'integer', 'min:1990', 'max:' . date('Y')],
            'precio' => ['required', 'numeric', 'min:0.01', 'max:99999'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria' => ['required', 'string', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],
        ]);

        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'descripcion' => ['required', 'string', 'max:100'],
            'marca' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'modelo' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z0-9]+$/'],
            'anio' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'precio' => ['required', 'numeric', 'min:0.01', 'max:99999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:999'],
            'categoria' => ['required', 'string', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Buscar producto por id
        $producto = Producto::findOrFail($id);

        // Eliminar producto
        $producto->delete();

        // Redireccionar con mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

        public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }


}
