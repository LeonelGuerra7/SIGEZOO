<?php

namespace App\Http\Controllers\Alimentacion;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Proveedor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlimentoController extends Controller
{
    public function index(Request $request)
    {
        $alimentos = Alimento::query()
            ->with('proveedor')
            ->when($request->filled('buscar'), fn ($q) =>
                $q->where('nombre_alimento', 'like', '%' . $request->buscar . '%'))
            ->when($request->filled('tipo'), fn ($q) =>
                $q->where('tipo_alimento', $request->tipo))
            ->orderBy('nombre_alimento')
            ->paginate(10)
            ->withQueryString();

        return view('alimentacion.alimentos.index', [
            'alimentos' => $alimentos,
            'tipos' => Alimento::TIPOS,
            'proveedores' => Proveedor::orderBy('nombre_proveedor')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Alimento::create($this->validar($request));

        return redirect()
            ->route('alimentacion.alimentos.index')
            ->with('success', 'Alimento registrado correctamente.');
    }

    public function update(Request $request, Alimento $alimento)
    {
        $alimento->update($this->validar($request));

        return redirect()
            ->route('alimentacion.alimentos.index')
            ->with('success', 'Alimento actualizado correctamente.');
    }

    public function destroy(Alimento $alimento)
    {
        if ($alimento->dietas()->exists()) {
            return redirect()
                ->route('alimentacion.alimentos.index')
                ->with('error', 'No se puede eliminar "' . $alimento->nombre_alimento
                    . '" porque está en uso en una o más dietas.');
        }

        try {
            $alimento->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('alimentacion.alimentos.index')
                ->with('error', 'No se pudo eliminar el registro porque está relacionado con otros datos.');
        }

        return redirect()
            ->route('alimentacion.alimentos.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre_alimento'        => ['required', 'string', 'max:50'],
            'tipo_alimento'          => ['required', Rule::in(Alimento::TIPOS)],
            'stock_alimento'         => ['required', 'integer', 'min:0'],
            'stock_minimo_alimento'  => ['required', 'integer', 'min:0'],
            'unidad_medida_alimento' => ['required', 'string', 'max:20'],
            'id_proveedores'         => ['nullable', 'exists:proveedores,id_proveedores'],
        ]);
    }
}