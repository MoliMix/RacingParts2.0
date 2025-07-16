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

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', '%' . $request->modelo . '%');
        }

        if ($request->filled('anio')) {
            $query->where('anio', $request->anio);
        }

        if ($request->filled('marca')) {
            $query->where('marca', $request->marca);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productosFiltrados = $query->count();
        $totalProductos = Producto::count();

        $productos = $query->orderBy('id', 'desc')->paginate(5);

        return view('productos.index', compact('productos', 'productosFiltrados', 'totalProductos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:20', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{0,19}$/'],
            'descripcion' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ][a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]{0,99}$/'],
            'marca' => ['required', Rule::in(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'])],
            'modelo' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z][a-zA-Z0-9\s\-]{0,49}$/'],
            'anio' => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . date('Y')],
            'categoria' => ['required', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],
        ]);

        $existe = Producto::where('nombre', $validated['nombre'])
            ->where('marca', $validated['marca'])
            ->where('modelo', $validated['modelo'])
            ->where('anio', $validated['anio'])
            ->where('categoria', $validated['categoria'])
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['duplicado' => 'Ya existe un producto con esa combinación de nombre, marca, modelo, año y categoría.'])
                ->withInput();
        }

        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:20', 'regex:/^[^\s\d][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]{0,19}$/'],
            'descripcion' => ['required', 'string', 'max:100', 'regex:/^[^\s\d][a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]*$/'],
            'marca' => ['required', 'string', Rule::in(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Mazda', 'Kia'])],
            'modelo' => ['required', 'string', 'max:50', 'regex:/^[^\s][a-zA-Z0-9\s\-]*$/'],
            'anio' => ['required', 'digits:4', 'integer', 'min:1990', 'max:' . date('Y')],
            'categoria' => ['required', 'string', Rule::in(['Motor', 'Frenos', 'Suspensión', 'Eléctrico', 'Accesorios'])],
        ]);

        $existe = Producto::where('nombre', $validated['nombre'])
            ->where('marca', $validated['marca'])
            ->where('modelo', $validated['modelo'])
            ->where('anio', $validated['anio'])
            ->where('categoria', $validated['categoria'])
            ->where('id', '<>', $producto->id)
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['duplicado' => 'Ya existe un producto con esa combinación de nombre, marca, modelo, año y categoría.'])
                ->withInput();
        }

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
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
