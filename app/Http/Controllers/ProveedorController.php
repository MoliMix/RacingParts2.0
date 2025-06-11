<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                  ->orWhere('pais_origen', 'like', "%{$search}%")
                  ->orWhere('persona_contacto', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate(Proveedor::rules(), Proveedor::messages());

        $proveedor = new Proveedor($request->all());
        $proveedor->save();

        return redirect()->route('proveedores.index')
            ->with('success', '¡Proveedor registrado con éxito!');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $request->validate(Proveedor::rules($id), Proveedor::messages());

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', '¡Proveedor actualizado con éxito!');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return redirect()->route('proveedores.index')
            ->with('success', '¡Proveedor eliminado con éxito!');
    }
} 