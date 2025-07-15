<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class EmpleadoController extends Controller
{
    // Show all employees with search and pagination
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

    // Save a new employee
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]+$/u'],
            'apellido' => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]+$/u'],
            'correo' => ['required', 'email', 'max:30', 'unique:empleados,correo'],
            'telefono' => ['required', 'string', 'max:8', 'regex:/^[2389][0-9]{7}$/', 'unique:empleados,telefono'],
            'sexo' => ['required', 'in:Masculino,Femenino,Otro'],
            'identidad' => [
                'required',
                'string',
                'size:15',
                'regex:/^\d{4}-\d{4}-\d{5}$/',
                'unique:empleados,identidad',
                function ($attribute, $value, $fail) {
                    $digits = str_replace('-', '', $value);
                    if (strlen($digits) === 13) {
                        $firstTwoDigits = (int) substr($digits, 0, 2);
                        if ($firstTwoDigits > 18) {
                            $fail('Los dos primeros números de la identidad no pueden ser mayores que 18.');
                        }
                    }
                },
            ],
            'puesto' => ['required', 'string', 'max:255'],
            'salario' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'fecha_contratacion' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'direccion' => ['required', 'string', 'max:100'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe tener más de 30 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras, espacios, guiones y tildes.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no debe tener más de 30 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras, espacios, guiones y tildes.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingrese un correo electrónico válido.',
            'correo.max' => 'El correo no debe tener más de 30 caracteres.',
            'correo.unique' => 'Este correo ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'Este teléfono ya está registrado.',
            'telefono.max' => 'El teléfono no debe tener más de 8 dígitos.',

            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',

            'identidad.required' => 'El número de identidad es obligatorio.',
            'identidad.size' => 'El número de identidad debe tener exactamente 15 caracteres (ej. 0801-1990-12345).',
            'identidad.regex' => 'El formato del número de identidad es inválido: debe ser ####-####-#####.',
            'identidad.unique' => 'Este número de identidad ya está registrado.',

            'puesto.required' => 'El puesto es obligatorio.',

            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.min' => 'El salario debe ser un número positivo.',
            'salario.max' => 'El salario no puede ser mayor de L.99,999.99.',

            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria.',
            'fecha_contratacion.date' => 'La fecha de contratación no es una fecha válida.',
            'fecha_contratacion.after_or_equal' => 'La fecha de contratación no puede ser anterior al 1 de enero de 2000.',
            'fecha_contratacion.before_or_equal' => 'La fecha de contratación no puede ser una fecha futura.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede tener más de 100 caracteres.',
        ]);

        try {
            Empleado::create($request->all());

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado registrado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al registrar empleado: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al registrar el empleado. Por favor, inténtelo de nuevo.');
        }
    }

    // Show edit form
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.editar', compact('empleado'));
    }

    // Update employee data
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]+$/u'],
            'apellido' => ['required', 'string', 'max:30', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]+$/u'],
            'correo' => [
                'required',
                'email',
                'max:30',
                Rule::unique('empleados')->ignore($empleado->id),
            ],
            'telefono' => [
                'required',
                'string',
                'max:8',
                'regex:/^[2389][0-9]{7}$/',
                Rule::unique('empleados')->ignore($empleado->id),
            ],
            'sexo' => ['required', 'in:Masculino,Femenino,Otro'],
            'identidad' => [
                'required',
                'string',
                'size:15',
                'regex:/^\d{4}-\d{4}-\d{5}$/',
                Rule::unique('empleados')->ignore($empleado->id),
                function ($attribute, $value, $fail) {
                    $digits = str_replace('-', '', $value);
                    if (strlen($digits) === 13) {
                        $firstTwoDigits = (int) substr($digits, 0, 2);
                        if ($firstTwoDigits > 18) {
                            $fail('Los dos primeros números de la identidad no pueden ser mayores que 18.');
                        }
                    }
                },
            ],
            'puesto' => ['required', 'string', 'max:255'],
            'salario' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'fecha_contratacion' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'direccion' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'in:Activo,Inactivo'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe tener más de 30 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras, espacios, guiones y tildes.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no debe tener más de 30 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras, espacios, guiones y tildes.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingrese un correo electrónico válido.',
            'correo.max' => 'El correo no debe tener más de 30 caracteres.',
            'correo.unique' => 'Este correo ya está registrado.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono debe tener 8 dígitos y comenzar con 2, 3, 8 o 9.',
            'telefono.unique' => 'Este teléfono ya está registrado.',
            'telefono.max' => 'El teléfono no debe tener más de 8 dígitos.',

            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo seleccionado no es válido.',

            'identidad.required' => 'El número de identidad es obligatorio.',
            'identidad.size' => 'El número de identidad debe tener exactamente 15 caracteres (ej. 0801-1990-12345).',
            'identidad.regex' => 'El formato del número de identidad es inválido: debe ser ####-####-#####.',
            'identidad.unique' => 'Este número de identidad ya está registrado.',

            'puesto.required' => 'El puesto es obligatorio.',

            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un número.',
            'salario.min' => 'El salario debe ser un número positivo.',
            'salario.max' => 'El salario no puede ser mayor de L.99,999.99.',

            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria.',
            'fecha_contratacion.date' => 'La fecha de contratación no es una fecha válida.',
            'fecha_contratacion.after_or_equal' => 'La fecha de contratación no puede ser anterior al 1 de enero de 2000.',
            'fecha_contratacion.before_or_equal' => 'La fecha de contratación no puede ser una fecha futura.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede tener más de 100 caracteres.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ]);

        try {
            $empleado->update($request->all());

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar empleado: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el empleado. Por favor, inténtelo de nuevo.');
        }
    }

    // Show employee details
    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $suggestions = [];

        if ($query) {
            $empleados = Empleado::where('nombre', 'like', "%{$query}%")
                                 ->orWhere('apellido', 'like', "%{$query}%")
                                 ->orWhere('identidad', 'like', "%{$query}%")
                                 ->limit(10) // Limitar el número de sugerencias para evitar respuestas muy grandes
                                 ->get();

            foreach ($empleados as $empleado) {
                // Añadir nombre completo
                $suggestions[] = $empleado->nombre . ' ' . $empleado->apellido;
                // Añadir identidad
                $suggestions[] = $empleado->identidad;
                // Si quieres añadir otros campos como correo, asegúrate de que tenga sentido para la búsqueda
                // $suggestions[] = $empleado->correo;
            }

            // Eliminar duplicados y reindexar el array para asegurar un JSON limpio
            $suggestions = array_values(array_unique($suggestions));
        }

        // DEBUG: Muestra lo que Laravel va a devolver en los logs
        Log::info('Autocomplete suggestions:', ['query' => $query, 'suggestions' => $suggestions]);

        return response()->json($suggestions);
    }
}