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
            'telefono' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'identidad' => [
                'required',
                'string',
                'size:15',
                'unique:empleados,identidad',
                'regex:/^\d{4}-\d{4}-\d{5}$/'
            ],
            'puesto' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0',
            'fecha_contratacion' => 'required|date|before_or_equal:today',
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Por favor ingrese un correo electrónico válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',
            'identidad.required' => 'El número de identidad es obligatorio.',
            'identidad.size' => 'El número de identidad debe tener el formato ####-####-#####.',
            'identidad.regex' => 'El número de identidad debe tener el formato ####-####-#####.',
            'identidad.unique' => 'Este número de identidad ya está registrado.',
            'puesto.required' => 'El puesto es obligatorio.',
            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.min' => 'El salario debe ser mayor a 0.',
            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria.',
            'fecha_contratacion.date' => 'La fecha de contratación debe ser una fecha válida.',
            'fecha_contratacion.before_or_equal' => 'La fecha de contratación no puede ser futura.',
            'direccion.required' => 'La dirección es obligatoria.',
        ]);

        try {
            Empleado::create($request->all());
            return redirect()->route('empleados.index')
                ->with('success', '¡Empleado registrado con éxito!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al registrar el empleado. Por favor, intente nuevamente.');
        }
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
            'correo' => 'required|email|unique:empleados,correo,' . $empleado->id,
            'telefono' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'direccion' => 'nullable|string|max:255',
            'identidad' => [
                'required',
                'string',
                'size:15',
                'unique:empleados,identidad,' . $empleado->id,
                'regex:/^\d{4}-\d{4}-\d{5}$/'
            ],
            'puesto' => 'required|string|max:255',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'salario' => 'required|numeric|min:0',
            'fecha_contratacion' => 'required|date|before_or_equal:today',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Por favor ingrese un correo electrónico válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',
            'identidad.required' => 'El número de identidad es obligatorio.',
            'identidad.size' => 'El número de identidad debe tener el formato ####-####-#####.',
            'identidad.regex' => 'El número de identidad debe tener el formato ####-####-#####.',
            'identidad.unique' => 'Este número de identidad ya está registrado.',
            'puesto.required' => 'El puesto es obligatorio.',
            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.min' => 'El salario debe ser mayor a 0.',
            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria.',
            'fecha_contratacion.date' => 'La fecha de contratación debe ser una fecha válida.',
            'fecha_contratacion.before_or_equal' => 'La fecha de contratación no puede ser futura.',
            'direccion.required' => 'La dirección es obligatoria.',
        ]);

        try {
            $empleado->update($request->all());
            return redirect()->route('empleados.index')
                ->with('success', '¡Empleado actualizado con éxito!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el empleado. Por favor, intente nuevamente.');
        }
    }

    // Mostrar los detalles de un empleado
    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }
}
