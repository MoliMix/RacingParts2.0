<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    // Mostrar todos los empleados con búsqueda y paginación
    public function index(Request $request)
    {
        $search = $request->input('search');

        $empleados = Empleado::query();

        if ($search) {
            $empleados->where(function ($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                      ->orWhere('apellido', 'like', "%{$search}%")
                      ->orWhere('correo', 'like', "%{$search}%")
                      ->orWhere('telefono', 'like', "%{$search}%")
                      ->orWhere('sexo', 'like', "%{$search}%")
                      ->orWhere('identidad', 'like', "%{$search}%")
                      ->orWhere('puesto', 'like', "%{$search}%");
            });
        }

        $empleados = $empleados->orderBy('id', 'desc')->paginate(10);

        return view('empleados.index', compact('empleados'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('empleados.create');
    }

    // Guardar nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'apellido' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'correo' => 'required|email|unique:empleados,correo',
            'telefono' => 'nullable|string|max:20',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'identidad' => 'required|string|size:13|unique:empleados,identidad',
            'puesto' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0',
            'fecha_contratacion' => 'required|date',
            'direccion' => 'nullable|string|max:255',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.editar', compact('empleado'));
    }

    // Actualizar datos del empleado
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'apellido' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'correo' => 'required|email|max:255|unique:empleados,correo,' . $empleado->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'identidad' => 'required|string|size:13|unique:empleados,identidad,' . $empleado->id,
            'puesto' => 'required|string|max:255',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'salario' => 'required|numeric|min:0',
            'fecha_contratacion' => 'required|date',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    // Mostrar los detalles de un empleado
    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }
}
