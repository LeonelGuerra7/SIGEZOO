<?php

namespace App\Http\Controllers\ControlClinico;

use App\Http\Controllers\Controller;
use App\Models\Medicamento;
use App\Models\Proveedor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        $medicamentos = Medicamento::query()
            ->when($request->filled('buscar'), fn ($q) =>
                $q->where('nombre_medicamento', 'like', '%' . $request->buscar . '%'))
            ->when($request->filled('tipo'), fn ($q) =>
                $q->where('tipo_medicamento', $request->tipo))
            ->orderBy('nombre_medicamento')
            ->paginate(10)
            ->withQueryString();

        return view('control-clinico.medicamentos.index', [
            'medicamentos' => $medicamentos,
            'tipos' => Medicamento::TIPOS,
            'proveedores' => $this->proveedores(),
        ]);
    }

    public function create()
    {
        return view('control-clinico.medicamentos.create', [
            'tipos' => Medicamento::TIPOS,
            'proveedores' => $this->proveedores(),
        ]);
    }

    public function store(Request $request)
    {
        Medicamento::create($this->validar($request));

        return redirect()
            ->route('control-clinico.medicamentos.index')
            ->with('success', 'Registro creado correctamente.');
    }

    public function edit(Medicamento $medicamento)
    {
        return view('control-clinico.medicamentos.edit', [
            'medicamento' => $medicamento,
            'tipos' => Medicamento::TIPOS,
            'proveedores' => $this->proveedores(),
        ]);
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $medicamento->update($this->validar($request));

        return redirect()
            ->route('control-clinico.medicamentos.index')
            ->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(Medicamento $medicamento)
    {
        // Capa 1: no borrar si tiene procedimientos clínicos asociados
        if ($medicamento->procedimientos()->exists()) {
            return redirect()
                ->route('control-clinico.medicamentos.index')
                ->with('error', 'No se puede eliminar "' . $medicamento->nombre_medicamento
                    . '" porque está en uso en procedimientos clínicos.');
        }

        // Capa 2: si la BD rechaza el borrado por una llave foránea, se avisa igual
        try {
            $medicamento->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('control-clinico.medicamentos.index')
                ->with('error', 'No se pudo eliminar el registro porque está relacionado con otros datos.');
        }

        return redirect()
            ->route('control-clinico.medicamentos.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

    // Reglas espejo de la migración (longitudes, enum, stock no negativo)
    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre_medicamento'        => ['required', 'string', 'max:50'],
            'tipo_medicamento'          => ['required', Rule::in(Medicamento::TIPOS)],
            'stock_medicamento'         => ['required', 'integer', 'min:0'],
            'stock_minimo_medicamento'  => ['required', 'integer', 'min:0'],
            'unidad_medida_medicamento' => ['required', 'string', 'max:18'],
            'id_proveedores'            => ['nullable', 'exists:proveedores,id_proveedores'],
        ]);
    }

    // TODO: quitar el class_exists cuando el modelo Proveedor exista en develop.
    // Ajusta 'nombre_proveedor' si la columna se llama distinto en la migración.
    private function proveedores()
    {
        return class_exists(Proveedor::class)
            ? Proveedor::orderBy('nombre_proveedor')->get()
            : collect();
    }
}
