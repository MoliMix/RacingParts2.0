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
     public function create()
    {
        return view('empleados.create');
    }

    // Guardar un nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:30', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:30', 'regex:/^[\pL\s]+$/u'],
            'correo' => ['required', 'email', 'regex:/^.+@.+\..+$/', 'unique:empleados,correo'],
            'telefono' => ['required', 'regex:/^[2389][0-9]{7}$/', 'unique:empleados,telefono'],
            'sexo' => ['required', 'in:Masculino,Femenino,Otro'],
            'identidad' => ['required', 'string', 'size:15', 'regex:/^\d{4}-\d{4}-\d{5}$/', 'unique:empleados,identidad'],
            'puesto' => ['required', 'string', 'max:255'],
            'salario' => ['required', 'numeric', 'min:0', 'max:99999'],
            'fecha_contratacion' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe tener más de 30 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no debe tener más de 30 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingrese un correo válido.',
            'correo.regex' => 'El correo debe contener al menos un punto.',
            'correo.unique' => 'Este correo ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'Este teléfono ya está registrado.',

            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',

            'identidad.required' => 'El número de identidad es obligatorio.',
            'identidad.size' => 'La identidad debe tener exactamente 15 caracteres.',
            'identidad.regex' => 'Formato inválido: debe ser ####-####-#####.',
            'identidad.unique' => 'Esta identidad ya está registrada.',

            'puesto.required' => 'El puesto es obligatorio.',

            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.max' => 'El salario no puede tener más de 5 cifras.',

            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria.',
            'fecha_contratacion.date' => 'La fecha debe ser válida.',
            'fecha_contratacion.after_or_equal' => 'La fecha no puede ser menor al año 2000.',
            'fecha_contratacion.before_or_equal' => 'La fecha no puede ser futura.',

            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ]);

        try {
            Empleado::create($request->all());

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado registrado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar el empleado: ' . $e->getMessage());
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
            'nombre' => ['required', 'string', 'max:30', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:30', 'regex:/^[\pL\s]+$/u'],
            'correo' => ['required', 'email', "unique:empleados,correo,{$empleado->id}"],
            'telefono' => ['required', 'regex:/^[2389][0-9]{7}$/', "unique:empleados,telefono,{$empleado->id}"],
            'sexo' => ['required', 'in:Masculino,Femenino,Otro'],
            'identidad' => ['required', 'string', 'size:15', 'regex:/^\d{4}-\d{4}-\d{5}$/', "unique:empleados,identidad,{$empleado->id}"],
            'puesto' => ['required', 'string', 'max:255'],
            'salario' => ['required', 'numeric', 'min:0', 'max:99999'],
            'fecha_contratacion' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe tener más de 30 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no debe tener más de 30 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Por favor ingrese un correo válido.',
            'correo.unique' => 'Este correo ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'Este teléfono ya está registrado.',

            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',

            'identidad.required' => 'El número de identidad es obligatorio.',
            'identidad.size' => 'La identidad debe tener exactamente 15 caracteres.',
            'identidad.regex' => 'Formato inválido: debe ser ####-####-#####.',
            'identidad.unique' => 'Esta identidad ya está registrada.',

            'puesto.required' => 'El puesto es obligatorio.',

            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.max' => 'El salario no puede tener más de 5 cifras.',

            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria.',
            'fecha_contratacion.date' => 'La fecha debe ser válida.',
            'fecha_contratacion.after_or_equal' => 'La fecha no puede ser menor al año 2000.',
            'fecha_contratacion.before_or_equal' => 'La fecha no puede ser futura.',

            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ]);

        try {
            $empleado->update($request->all());

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar el empleado: ' . $e->getMessage());
        }
    }

    // Mostrar los detalles de un empleado
    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }
}
