<?php

namespace App\Http\Controllers\Alimentacion;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Dieta;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DietaController extends Controller
{
    public function index(Request $request)
    {
        $dietas = Dieta::query()
            ->with('alimento')
            ->when($request->filled('buscar'), fn ($q) =>
                $q->where('nombre_dieta', 'like', '%' . $request->buscar . '%'))
            ->orderBy('nombre_dieta')
            ->paginate(10)
            ->withQueryString();

        return view('alimentacion.dietas.index', [
            'dietas' => $dietas,
            'alimentos' => Alimento::orderBy('nombre_alimento')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Dieta::create($this->validar($request));

        return redirect()
            ->route('alimentacion.dietas.index')
            ->with('success', 'Dieta registrada correctamente.');
    }

    public function update(Request $request, Dieta $dieta)
    {
        $dieta->update($this->validar($request));

        return redirect()
            ->route('alimentacion.dietas.index')
            ->with('success', 'Dieta actualizada correctamente.');
    }

    public function destroy(Dieta $dieta)
    {
        if ($dieta->registros()->exists()) {
            return redirect()
                ->route('alimentacion.dietas.index')
                ->with('error', 'No se puede eliminar "' . $dieta->nombre_dieta
                    . '" porque tiene registros de alimentación asociados.');
        }

        try {
            $dieta->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('alimentacion.dietas.index')
                ->with('error', 'No se pudo eliminar el registro porque está relacionado con otros datos.');
        }

        return redirect()
            ->route('alimentacion.dietas.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre_dieta'        => ['required', 'string', 'max:50'],
            'cantidad_dieta'      => ['required', 'integer', 'min:1'],
            'frecuencia'          => ['required', 'string', 'max:50'],
            'fecha_distribucion'  => ['required', 'date'],
            'id_alimentos'        => ['nullable', 'exists:alimentos,id_alimientos'],
        ]);
    }
}