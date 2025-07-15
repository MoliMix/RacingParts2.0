<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    private function getCountries()
    {
        return [
           
            
        ];
    }

    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                  ->orWhere('pais_origen', 'like', "%{$search}%")
                  ->orWhere('persona_contacto', 'like', "%{$search}%")
                  ->orWhere('telefono_contacto', 'like', "%{$search}%")
                  ->orWhere('correo_electronico', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->paginate(10);
        $countries = $this->getCountries(); // Si usas los países para otra cosa en la vista index

        return view('proveedores.index', compact('proveedores', 'countries'));
    }

    public function create()
    {
        $countries = $this->getCountries();
        return view('proveedores.create', compact('countries'));
    }

    public function store(Request $request)
    {
        // Asegúrate de que Proveedor::rules() y Proveedor::messages() estén definidos en tu modelo Proveedor
        $request->validate(Proveedor::rules(), Proveedor::messages());

        $data = $request->all();

        try {
            $proveedor = new Proveedor($data);
            $proveedor->save();

            return redirect()->route('proveedores.index')
                ->with('success', '¡Proveedor registrado con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al registrar proveedor: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al registrar el proveedor. Por favor, inténtelo de nuevo.');
        }
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $countries = $this->getCountries();
        return view('proveedores.edit', compact('proveedor', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        // Pasa el ID al método rules() para ignorar la unicidad del email en el update
        $request->validate(Proveedor::rules($id), Proveedor::messages());

        $data = $request->all();

        try {
            $proveedor->update($data);

            return redirect()->route('proveedores.index')
                ->with('success', '¡Proveedor actualizado con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al actualizar proveedor: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar el proveedor. Por favor, inténtelo de nuevo.');
        }
    }

    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->delete();
            return redirect()->route('proveedores.index')
                ->with('success', '¡Proveedor eliminado con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al eliminar proveedor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el proveedor. Por favor, inténtelo de nuevo.');
        }
    }

    /**
     * Devuelve sugerencias para el autocompletado de proveedores.
     * Busca en nombre_empresa, pais_origen, persona_contacto, telefono_contacto.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $suggestions = [];

        if ($query) {
            // Buscar proveedores que coincidan con la consulta en cualquiera de los campos relevantes
            $proveedores = Proveedor::where(function($q) use ($query) {
                $q->where('nombre_empresa', 'like', "%{$query}%")
                  ->orWhere('pais_origen', 'like', "%{$query}%")
                  ->orWhere('persona_contacto', 'like', "%{$query}%")
                  ->orWhere('telefono_contacto', 'like', "%{$query}%");
            })
            ->limit(10) // Limita el número de resultados para eficiencia
            ->get();

            // Recopilar sugerencias de todos los campos relevantes que contienen la consulta
            foreach ($proveedores as $proveedor) {
                if (stripos($proveedor->nombre_empresa, $query) !== false) {
                    $suggestions[] = $proveedor->nombre_empresa;
                }
                if (stripos($proveedor->pais_origen, $query) !== false) {
                    $suggestions[] = $proveedor->pais_origen;
                }
                if (stripos($proveedor->persona_contacto, $query) !== false) {
                    $suggestions[] = $proveedor->persona_contacto;
                }
                if (stripos($proveedor->telefono_contacto, $query) !== false) {
                    $suggestions[] = $proveedor->telefono_contacto;
                }
            }

            // Eliminar duplicados y reindexar el array de sugerencias
            $suggestions = array_values(array_unique($suggestions));
        }

        return response()->json($suggestions);
    }
}