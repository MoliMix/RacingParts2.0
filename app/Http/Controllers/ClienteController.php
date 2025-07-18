<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        $totalClientes = Cliente::count();

        if ($search = $request->input('search')) {
    $query->where('nombre_completo', 'like', "%$search%")
          ->orWhere('numero_id', 'like', "%$search%")
          ->orWhere('numero_telefono', 'like', "%$search%");
}


        $clientes = $query->paginate(4);
        $totalClientesFiltrados = $search ? $clientes->total() : $totalClientes;

        return view('clientes.inicio', compact('clientes', 'totalClientes', 'totalClientesFiltrados'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('clientes.agregar', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            // dentro de $request->validate()
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
        $firstFour = substr($dni, 0, 4);
        if (!preg_match('/^(0[1-9]|1[0-8])[0-9]{2}$/', $firstFour)) {
            return $fail('Los primeros 4 dígitos del DNI no corresponden a un código de departamento y municipio válido.');
        }
    },
],

            'numero_telefono' => 'required|string|size:8|regex:/^\d{8}$/',
            'correo_electronico' => 'required|email|max:40',
            'direccion_cliente' => 'required|string|max:80',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
        ]);

        Cliente::create([
            'nombre_completo' => $request->nombre_completo,
            'numero_id' => str_replace('-', '', $request->numero_id),
            'numero_telefono' => $request->numero_telefono,
            'correo_electronico' => $request->correo_electronico,
            'direccion_cliente' => $request->direccion_cliente,
            'sexo' => $request->sexo,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function checkDniUniqueness(Request $request): \Illuminate\Http\JsonResponse
    {
        $dni = str_replace('-', '', $request->input('numero_id'));
        $clienteId = $request->input('id_cliente_to_ignore');

        $request->validate([
            'numero_id' => [
                'required',
                'string',
                'max:15',
               Rule::unique('clientes', 'numero_id')->ignore($clienteId),
// ...
function ($attribute, $value, $fail) {
    $dni = str_replace('-', '', $value);
    if (!preg_match('/^\d{13}$/', $dni)) {
        return $fail('El número de identidad debe contener exactamente 13 dígitos numéricos.');
    }
    $firstFour = substr($dni, 0, 4);
    if (!preg_match('/^(0[1-9]|1[0-8])[0-9]{2}$/', $firstFour)) {
        return $fail('Los primeros 4 dígitos del DNI no corresponden a un código de departamento y municipio válido.');
    }
},

            ],
        ]);

        $query = Cliente::where('numero_id', $dni);
        if ($clienteId) {
            $query->where('id', '!=', $clienteId);
        }

        return response()->json([
            'unique' => !$query->exists(),
            'message' => !$query->exists() ? 'El DNI está disponible.' : 'El DNI ya está registrado.',
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
            'nombre_completo' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
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
        $firstFour = substr($dni, 0, 4);
        if (!preg_match('/^(0[1-9]|1[0-8])[0-9]{2}$/', $firstFour)) {
            return $fail('Los primeros 4 dígitos del DNI no corresponden a un código de departamento y municipio válido.');
        }
    },
],

            'numero_telefono' => 'required|string|size:8|regex:/^\d{8}$/',
            'correo_electronico' => 'required|email|max:40',
            'direccion_cliente' => 'required|string|max:80',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
        ]);

        $cliente = Cliente::findOrFail($id);
        $data = $request->except('_token');
        $data['numero_id'] = str_replace('-', '', $data['numero_id']);
        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $deleted = Cliente::destroy($id);
        return redirect()->route('clientes.index')
            ->with($deleted ? 'success' : 'error', $deleted ? 'Cliente eliminado correctamente.' : 'Error al eliminar el cliente.');
    }

    private function isValidHonduranIDServerSide(string $dni): bool
{
    // Asegura que tenga 13 dígitos numéricos
    if (!preg_match('/^\d{13}$/', $dni)) {
        return false;
    }

    // Validación de departamento (01 a 18) y municipio (cualquier número entre 01 y 99)
    $department = (int) substr($dni, 0, 2);
    $municipality = (int) substr($dni, 2, 2);

    if ($department < 1 || $department > 18 || $municipality < 1 || $municipality > 99) {
        return false;
    }

    // No se verifica el dígito verificador para permitir nuevas identidades
    return true;
}

}