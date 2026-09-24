<?php

namespace App\Http\Controllers\Limpieza;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\TareaLimpieza;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TareaLimpiezaController extends Controller
{
    public function index(Request $request)
    {
        $tareas = TareaLimpieza::query()
            ->with(['area', 'usuario'])
            ->when($request->filled('area'), fn ($q) =>
                $q->where('id_areas', $request->area))
            ->when($request->filled('estado'), fn ($q) =>
                $q->where('estado_limpieza', $request->estado))
            ->orderByDesc('fecha_limpieza')
            ->paginate(10)
            ->withQueryString();

        return view('limpieza.index', [
            'tareas' => $tareas,
            'estados' => TareaLimpieza::ESTADOS,
            'areas' => Area::orderBy('nombre_area')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validar($request);
        $data['id_usuario'] = $request->user()->id;

        TareaLimpieza::create($data);

        return redirect()
            ->route('limpieza.index')
            ->with('success', 'Tarea de limpieza registrada correctamente.');
    }

    public function update(Request $request, TareaLimpieza $limpieza)
    {
        $limpieza->update($this->validar($request));

        return redirect()
            ->route('limpieza.index')
            ->with('success', 'Tarea de limpieza actualizada correctamente.');
    }

    public function destroy(TareaLimpieza $limpieza)
    {
        try {
            $limpieza->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('limpieza.index')
                ->with('error', 'No se pudo eliminar el registro porque está relacionado con otros datos.');
        }

        return redirect()
            ->route('limpieza.index')
            ->with('success', 'Registro eliminado correctamente.');
    }

    // Reglas espejo de la migración
    private function validar(Request $request): array
    {
        return $request->validate([
            'fecha_limpieza'         => ['required', 'date'],
            'estado_limpieza'        => ['required', Rule::in(TareaLimpieza::ESTADOS)],
            'observaciones_limpieza' => ['nullable', 'string', 'max:100'],
            'id_areas'               => ['required', 'exists:areas,id_areas'],
        ]);
    }
}