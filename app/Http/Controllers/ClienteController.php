<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        $totalClientes = Cliente::count(); // Total de clientes sin filtrar

        // Aplicar filtro de búsqueda si existe
        if ($search = $request->input('search')) {
            $query->where('nombre_completo', 'like', "%$search%")
                  ->orWhere('numero_id', 'like', "%$search%")
                  ->orWhere('numero_telefono', 'like', "%$search%");
        }

        // Paginación: se mantiene a 4 elementos por página
        // Con ->appends(request()->query()) se asegura que los parámetros de la URL (como 'search')
        // se mantengan en los enlaces de paginación.
        $clientes = $query->paginate(4)->appends($request->query());

        // Total de clientes después de aplicar el filtro (útil para mostrar al usuario)
        $totalClientesFiltrados = $clientes->total();

        return view('clientes.inicio', compact('clientes', 'totalClientes', 'totalClientesFiltrados', 'search'));
    }

    public function create()
    {
        // No es necesario cargar todos los clientes aquí a menos que se usen en el formulario de creación.
        // Si no se usan, puedes quitar la línea siguiente para optimizar.
        $clientes = Cliente::all();
        return view('clientes.agregar', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:50|unique:clientes',
            'numero_id' => [
                'required',
                'string',
                'max:15',
                'unique:clientes,numero_id',
                function ($attribute, $value, $fail) {
                    $dni = str_replace('-', '', $value);
                    if (!preg_match('/^\d{13}$/', $dni)) {
                        return $fail('El número de identidad debe contener exactamente 13 dígitos numéricos.');
                    }
                    $firstEight = substr($dni, 0, 8); // Primeros 8 dígitos para validación
                    $department = (int) substr($dni, 0, 2);
                    $municipality = (int) substr($dni, 2, 2);
                    $yearOfBirth = (int) substr($dni, 4, 4);

                    // Validación de departamento (01 a 18) y municipio (00 a 99)
                    if (!preg_match('/^(0[1-9]|1[0-8])[0-9]{2}$/', substr($firstEight, 0, 4))) {
                        return $fail('Los primeros 4 dígitos del DNI no corresponden a un código de departamento y municipio válido.');
                    }
                    // Validación de año de nacimiento (dígitos 5 al 8)
                    $currentYear = date('Y');
                    if ($yearOfBirth < 1900 || $yearOfBirth > $currentYear) { // Ajusta el rango según sea necesario
                        return $fail('El año de nacimiento (dígitos 5 al 8) no es válido.');
                    }
                },
            ],
            'numero_telefono' => 'required|string|size:8|regex:/^[2389]\d{7}$/', // Agregado inicio con 2,3,8,9
            'correo_electronico' => 'required|email|max:40',
            'direccion_cliente' => 'required|string|max:80',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
        ]);

        Cliente::create([
            'nombre_completo' => $request->input('nombre_completo'),
            'numero_id' => str_replace('-', '', $request->input('numero_id')), // Guardar sin guiones
            'numero_telefono' => $request->input('numero_telefono'),
            'correo_electronico' => $request->input('correo_electronico'),
            'direccion_cliente' => $request->input('direccion_cliente'),
            'sexo' => $request->input('sexo'),
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function checkDniUniqueness(Request $request): \Illuminate\Http\JsonResponse
    {
        $dni = str_replace('-', '', $request->input('numero_id'));
        $clienteId = $request->input('id_cliente_to_ignore');

        // Solo validar si el DNI tiene el formato esperado para la verificación de unicidad
        if (!preg_match('/^\d{13}$/', $dni)) {
            return response()->json(['unique' => false, 'message' => 'Formato de DNI inválido para verificación.']);
        }

        $query = Cliente::where('numero_id', $dni);
        if ($clienteId && $clienteId !== 'null') {
            $query->where('id', '!=', $clienteId);
        }

        return response()->json([
            'unique' => !$query->exists(),
            'message' => !$query->exists() ? 'El DNI está disponible.' : 'El DNI ya está registrado.',
        ]);
    }

    public function checkNameUniqueness(Request $request): \Illuminate\Http\JsonResponse
    {
        $nombreCompleto = $request->input('nombre_completo');
        $clienteId = $request->input('id_cliente_to_ignore');

        if (empty($nombreCompleto)) {
            return response()->json(['unique' => false, 'message' => 'El nombre completo es requerido para la verificación.']);
        }

        $query = Cliente::where('nombre_completo', $nombreCompleto);
        if ($clienteId && $clienteId !== 'null') {
            $query->where('id', '!=', $clienteId);
        }

        return response()->json([
            'unique' => !$query->exists(),
            'message' => !$query->exists() ? 'El nombre completo está disponible.' : 'El nombre completo ya está registrado.',
        ]);
    }


    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.mostrar', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.actualizar', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_completo' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                Rule::unique('clientes', 'nombre_completo')->ignore($id),
            ],
            'numero_id' => [
                'required',
                'string',
                'max:15',
                Rule::unique('clientes', 'numero_id')->ignore($id),
                function ($attribute, $value, $fail) {
                    $dni = str_replace('-', '', $value);
                    if (!preg_match('/^\d{13}$/', $dni)) {
                        return $fail('El número de identidad debe contener exactamente 13 dígitos numéricos.');
                    }
                    $firstEight = substr($dni, 0, 8); // Primeros 8 dígitos para validación
                    $department = (int) substr($dni, 0, 2);
                    $municipality = (int) substr($dni, 2, 2);
                    $yearOfBirth = (int) substr($dni, 4, 4);

                    // Validación de departamento (01 a 18) y municipio (00 a 99)
                    if (!preg_match('/^(0[1-9]|1[0-8])[0-9]{2}$/', substr($firstEight, 0, 4))) {
                        return $fail('Los primeros 4 dígitos del DNI no corresponden a un código de departamento y municipio válido.');
                    }
                    // Validación de año de nacimiento (dígitos 5 al 8)
                    $currentYear = date('Y');
                    if ($yearOfBirth < 1900 || $yearOfBirth > $currentYear) { // Ajusta el rango según sea necesario
                        return $fail('El año de nacimiento (dígitos 5 al 8) no es válido.');
                    }
                },
            ],
            'numero_telefono' => 'required|string|size:8|regex:/^[2389]\d{7}$/',
            'correo_electronico' => 'required|email|max:40',
            'direccion_cliente' => 'required|string|max:80',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
        ]);

        $cliente = Cliente::findOrFail($id);
        $data = $request->except('_token');
        $data['numero_id'] = str_replace('-', '', $data['numero_id']); // Guardar sin guiones
        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $deleted = Cliente::destroy($id);
        return redirect()->route('clientes.index')
            ->with($deleted ? 'success' : 'error', $deleted ? 'Cliente eliminado correctamente.' : 'Error al eliminar el cliente.');
    }

    // Esta función ya no es necesaria si la validación se hace en la regla de validación del DNI
    // private function isValidHonduranIDServerSide(string $dni): bool
    // {
    //     // Asegura que tenga 13 dígitos numéricos
    //     if (!preg_match('/^\d{13}$/', $dni)) {
    //         return false;
    //     }

    //     // Validación de departamento (01 a 18) y municipio (cualquier número entre 01 y 99)
    //     $department = (int) substr($dni, 0, 2);
    //     $municipality = (int) substr($dni, 2, 2);

    //     if ($department < 1 || $department > 18 || $municipality < 1 || $municipality > 99) {
    //         return false;
    //     }

    //     // No se verifica el dígito verificador para permitir nuevas identidades
    //     return true;
    // }
}