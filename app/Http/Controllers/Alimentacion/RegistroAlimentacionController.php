<?php

namespace App\Http\Controllers\Alimentacion;

use App\Http\Controllers\Controller;
use App\Models\Dieta;
use App\Models\RegistroAlimentacion;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroAlimentacionController extends Controller
{
    public function index(Request $request)
    {
        $registros = RegistroAlimentacion::query()
            ->with(['dieta.alimento', 'usuario'])
            ->orderByDesc('fecha_registro')
            ->paginate(10)
            ->withQueryString();

        return view('alimentacion.registros.index', [
            'registros' => $registros,
            'dietas' => Dieta::with('alimento')->orderBy('nombre_dieta')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validar($request);
        $data['id_usuario'] = $request->user()->id;

        DB::transaction(function () use ($data) {
            $registro = RegistroAlimentacion::create($data);
            $this->descontarInventario($registro);
        });

        return redirect()
            ->route('alimentacion.registros.index')
            ->with('success', 'Registro de alimentación guardado y stock actualizado.');
    }

    public function destroy(RegistroAlimentacion $registro)
    {
        try {
            DB::transaction(function () use ($registro) {
                // Devuelve al inventario lo que se había descontado antes de borrar.
                $this->reponerInventario($registro);
                $registro->delete();
            });
        } catch (QueryException $e) {
            return redirect()
                ->route('alimentacion.registros.index')
                ->with('error', 'No se pudo eliminar el registro porque está relacionado con otros datos.');
        }

        return redirect()
            ->route('alimentacion.registros.index')
            ->with('success', 'Registro eliminado y stock revertido.');
    }

    private function descontarInventario(RegistroAlimentacion $registro): void
    {
        $alimento = $registro->dieta?->alimento;

        if (! $alimento) {
            return;
        }

        $alimento->decrement('stock_alimento', $registro->cantidad_administrada);

        if ($alimento->fresh()->stockBajo()) {
            session()->flash('warning', 'Atención: el stock de "' . $alimento->nombre_alimento
                . '" quedó bajo el mínimo (' . $alimento->fresh()->stock_alimento . ' '
                . $alimento->unidad_medida_alimento . ').');
        }
    }

    private function reponerInventario(RegistroAlimentacion $registro): void
    {
        $alimento = $registro->dieta?->alimento;

        if ($alimento) {
            $alimento->increment('stock_alimento', $registro->cantidad_administrada);
        }
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'fecha_registro'        => ['required', 'date'],
            'cantidad_administrada' => ['required', 'numeric', 'min:0.01'],
            'observaciones'         => ['nullable', 'string', 'max:100'],
            'id_dietas'             => ['required', 'exists:dietas,id_dietas'],
        ]);
    }
}