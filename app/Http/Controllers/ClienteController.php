<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
// use App\Rules\HonduranDNI; // Only uncomment if you decide to use a dedicated Rule class
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException; // To catch specific validation errors

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // In your ClienteController.php
public function index(Request $request)
{
    $query = Cliente::query();
    $search = $request->input('search');
    // Define totalClients BEFORE the search filter
    // This gets the total count of ALL clients in your database
    $totalClientes = Cliente::count();

    if ($search = $request->input('search')) {
        $query->where('nombre_completo', 'like', '%' . $search . '%')
              ->orWhere('numero_id', 'like', '%' . $search . '%')
              ->orWhere('numero_telefono', 'like', '%' . $search . '%');
    }

    // You named the paginated variable '$cliente' (singular) but it holds a collection.
    // It's better to keep it plural for clarity, like '$clientes'.
    $clientes = $query->paginate(4);

    // Calculate totalClientesFiltrados AFTER applying the search and pagination
    // This gets the total count of clients AFTER the search filter has been applied
    $totalClientesFiltrados = $search ? $clientes->total() : $totalClientes;


    return view('clientes.inicio', compact('clientes', 'totalClientes', 'totalClientesFiltrados'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.agregar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre_completo' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'numero_id' => [
                    'required',
                    'string',
                    'max:15', // Max 15 characters to allow for hyphens from frontend
                    'regex:/^\d{4}-\d{4}-\d{5}$/', // Enforce the format with hyphens on input
                    'unique:clientes,numero_id', // Check uniqueness in DB (stores without hyphens)
                    function ($attribute, $value, $fail) {
                        // Clean DNI for internal validation logic (remove hyphens)
                        $cleanDni = str_replace('-', '', $value);

                        // Only proceed with advanced DNI validation if it has 13 digits after cleaning
                        if (strlen($cleanDni) !== 13) {
                             // This error should ideally be caught by 'regex' and 'max' rules first,
                             // but it's a good fallback for the clean string.
                             $fail('El número invaliad');
                             return;
                        }

                        if (!$this->isValidHonduranIDServerSide($cleanDni)) {
                            $fail('El número de identidad no es un DNI hondureño válido.');
                        }
                    },
                ],
                'numero_telefono' => 'required|string|size:8|unique:clientes,numero_telefono|regex:/^\d{8}$/',
                'correo_electronico' => 'required|email|min:15|max:40',
                'direccion_cliente' => 'required|string|max:255', // Changed from 80 to 255 based on previous discussion
                'sexo' => 'required|in:Masculino,Femenino,Otro',
                'fecha_ingreso' => 'required|date|before_or_equal:today', // Added validation for fecha_ingreso
            ], [
                // Custom validation messages
                'nombre_completo.required' => 'El nombre completo es obligatorio.',
                'nombre_completo.string' => 'El nombre completo debe ser una cadena de texto.',
                'nombre_completo.max' => 'El nombre completo no debe exceder los :max caracteres.',
                'nombre_completo.regex' => 'El nombre completo solo debe contener letras y espacios.',

                'numero_id.required' => 'El número de identidad es obligatorio.',
                'numero_id.string' => 'El número de identidad debe ser una cadena de texto.',
                'numero_id.max' => 'El número de identidad no debe exceder los :max caracteres (incluyendo guiones).',
                'numero_id.regex' => 'El formato del número de identidad es incorrecto (Ej: 0000-0000-00000).',
                'numero_id.unique' => 'El número de identidad ya está registrado.',

                'numero_telefono.required' => 'El número de teléfono es obligatorio.',
                'numero_telefono.string' => 'El número de teléfono debe ser una cadena de texto.',
                'numero_telefono.size' => 'El número de teléfono invalido.',
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

            // Clean the DNI before saving to the database
            $validatedData['numero_id'] = str_replace('-', '', $validatedData['numero_id']);

            // Create the client
            Cliente::create($validatedData);

            return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');

        } catch (ValidationException $e) {
            // If validation fails, it will automatically redirect back with errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el cliente: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Checks if a given DNI (numero_id) is unique and valid format in the Cliente table.
     * This method is typically used for AJAX requests from the client-side.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkDniUniqueness(Request $request): \Illuminate\Http\JsonResponse
    {
        // Use a try-catch block to handle validation exceptions and return appropriate JSON
        try {
            $request->validate([
                'numero_id' => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/^\d{4}-\d{4}-\d{5}$/', // Validate input format with hyphens
                    // The unique rule should ignore the current client's ID if provided for updates
                    Rule::unique('clientes', 'numero_id')->ignore($request->input('cliente_id_to_ignore')),
                    function ($attribute, $value, $fail) {
                        $cleanDni = str_replace('-', '', $value); // Clean for checksum validation

                        if (!$this->isValidHonduranIDServerSide($cleanDni)) {
                            $fail('El número de identidad no es un DNI hondureño válido.');
                        }
                    },
                ],
            ], [
                'numero_id.required' => 'El número de identidad es obligatorio.',
                'numero_id.string' => 'El número de identidad debe ser una cadena de texto.',
                'numero_id.max' => 'El número de identidad no debe exceder los :max caracteres (incluyendo guiones).',
                'numero_id.regex' => 'El formato del número de identidad es incorrecto (Ej: 0000-0000-00000).',
                'numero_id.unique' => 'El número de identidad ya está registrado.',
            ]);

            // If validation passes, the DNI is unique and valid
            return response()->json([
                'unique' => true,
                'message' => 'El DNI está disponible y es válido.',
            ]);

        } catch (ValidationException $e) {
            // If validation fails, return false and the first error message
            return response()->json([
                'unique' => false,
                'message' => $e->errors()['numero_id'][0] ?? 'Error de validación del DNI.',
            ], 422); // Use HTTP 422 Unprocessable Entity for validation errors

        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return response()->json([
                'unique' => false,
                'message' => 'Ocurrió un error al verificar el DNI.',
            ], 500); // Internal Server Error
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id); // Changed variable name for clarity
        return view('clientes.mostrar', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id); // Changed variable name for clarity
        return view('clientes.actualizar', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente) // Using Route Model Binding
    {
        try {
            $validatedData = $request->validate([
                'nombre_completo' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'numero_id' => [
                    'required',
                    'string',
                    'max:15',
                    'regex:/^\d{4}-\d{4}-\d{5}$/',
                    // Ignore the current client's DNI when checking for uniqueness
                    Rule::unique('clientes', 'numero_id')->ignore($cliente->id),
                    function ($attribute, $value, $fail) use ($cliente) {
                        $cleanDni = str_replace('-', '', $value);

                        if (strlen($cleanDni) !== 13) {
                            $fail('El número de identidad invalido');
                            return;
                        }

                        if (!$this->isValidHonduranIDServerSide($cleanDni)) {
                            $fail('El número de identidad no es un DNI hondureño válido.');
                        }
                    },
                ],
                'numero_telefono' => [
                    'required',
                    'string',
                    'size:8',
                    'regex:/^\d{8}$/',
                    // Ignore the current client's phone number when checking for uniqueness
                    Rule::unique('clientes', 'numero_telefono')->ignore($cliente->id),
                ],
                'correo_electronico' => 'required|email|max:40',
                'direccion_cliente' => 'required|string|max:150', // Changed from 80 to 255 here too
                'sexo' => 'required|in:Masculino,Femenino,Otro',
                'fecha_ingreso' => 'required|date|before_or_equal:today', // Added validation for fecha_ingreso
            ], [
                // Custom validation messages (you can re-use from store method or refine them)
                'nombre_completo.required' => 'El nombre completo es obligatorio.',
                'nombre_completo.string' => 'El nombre completo debe ser una cadena de texto.',
                'nombre_completo.max' => 'El nombre completo no debe exceder los :max caracteres.',
                'nombre_completo.regex' => 'El nombre completo solo debe contener letras y espacios.',

                'numero_id.required' => 'El número de identidad es obligatorio.',
                'numero_id.string' => 'El número de identidad debe ser una cadena de texto.',
                'numero_id.max' => 'El número de identidad no debe exceder los :max caracteres (incluyendo guiones).',
                'numero_id.regex' => 'El formato del número de identidad es incorrecto (Ej: 0000-0000-00000).',
                'numero_id.unique' => 'El número de identidad ya está registrado por otro cliente.',

                'numero_telefono.required' => 'El número de teléfono es obligatorio.',
                'numero_telefono.string' => 'El número de teléfono debe ser una cadena de texto.',
                'numero_telefono.size' => 'El número de teléfono invalido.',
                'numero_telefono.regex' => 'El formato del número de teléfono es incorrecto (solo números).',
                'numero_telefono.unique' => 'El número de teléfono ya está registrado por otro cliente.',

                'correo_electronico.required' => 'El correo electrónico es obligatorio.',
                'correo_electronico.email' => 'El correo electrónico debe ser una dirección válida.',
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

            // Clean the DNI before saving to the database
            $validatedData['numero_id'] = str_replace('-', '', $validatedData['numero_id']);

            // Update the client with the validated data
            $cliente->update($validatedData);

            return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el cliente: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the client first to ensure it exists before attempting to delete
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete(); // Use delete() method on the model instance
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Validate Honduran DNI server-side.
     * This is a private helper method for DNI validation logic.
     *
     * @param string $dni The DNI string, expected to be 13 digits without hyphens.
     * @return bool True if the DNI is valid, false otherwise.
     */
    private function isValidHonduranIDServerSide(string $dni): bool
    {
        // The DNI should already be cleaned of hyphens before being passed to this function.
        // Re-check for exactly 13 digits just in case.
        if (!preg_match('/^\d{13}$/', $dni)) {
            return false;
        }

        $department = (int) substr($dni, 0, 2);
        $municipality = (int) substr($dni, 2, 2);

        // Basic range check for department (01 to 18) and municipality (01 to X, varies per department)
        // This is a simplified check. A full validation would require a list of valid codes.
        // For Honduras, departments go from 01 (Atlántida) to 18 (Yoro).
        // Municipalities within each department have their own ranges (e.g., Francisco Morazán (08) has 29 municipalities).
        // For a more robust validation, you'd need a lookup table for valid department/municipality combinations.
        if ($department < 1 || $department > 18 || $municipality < 1) {
            return false;
        }

        $sum = 0;
        // Weights for the first 12 digits for checksum calculation (Honduran DNI algorithm)
        // These weights are standard for the DNI checksum.
        $weights = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

        for ($i = 0; $i < 12; $i++) {
            $sum += (int) $dni[$i] * $weights[$i];
        }

        $remainder = $sum % 11;
        // The last digit calculation: if remainder is 1, (11-1)%10 = 0. If remainder is 0, (11-0)%10 = 1.
        $expectedLastDigit = (11 - $remainder) % 10;

        return (int) $dni[12] === $expectedLastDigit;
    }
}