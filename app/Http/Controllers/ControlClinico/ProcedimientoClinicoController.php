<?php

namespace App\Http\Controllers\ControlClinico;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Medicamento;
use App\Models\ProcedimientoClinico;
use Illuminate\Http\Request;

class ProcedimientoClinicoController extends Controller
{
    public function index(Request $request)
{
    $procedimientos = ProcedimientoClinico::with(['animal', 'medicamento', 'usuario'])
        ->when($request->filled('animal'), fn ($q) => $q->where('id_animal', $request->animal))
        ->when($request->filled('tipo'), fn ($q) =>
            $q->whereHas('medicamento', fn ($m) => $m->where('tipo_medicamento', $request->tipo)))
        ->when($request->estado === 'por_vencer', fn ($q) => $q->vacunasPorVencer())
        ->when($request->estado === 'vencidas', fn ($q) => $q->vacunasVencidas())
        ->orderByDesc('fecha_aplicacion')
        ->paginate(10)
        ->withQueryString();

    return view('control-clinico.procedimientos.index', [
        'procedimientos' => $procedimientos,
        'animales'       => Animal::orderBy('nombre_animal')->get(),
        'medicamentos'   => Medicamento::orderBy('nombre_medicamento')->get(),
        'tipos'          => Medicamento::TIPOS,
        'estado'         => $request->estado,
    ]);
}
    public function store(Request $request)
    {
        $datos = $this->validar($request);
        $datos['id_usuario'] = auth()->id(); // quién registra, tomado de la sesión

        ProcedimientoClinico::create($datos);

        return redirect()->route('control-clinico.procedimientos.index')
            ->with('success', 'Procedimiento registrado correctamente.');
    }

    public function update(Request $request, ProcedimientoClinico $procedimiento)
    {
        $procedimiento->update($this->validar($request));

        return redirect()->route('control-clinico.procedimientos.index')
            ->with('success', 'Procedimiento actualizado correctamente.');
    }

    public function destroy(ProcedimientoClinico $procedimiento)
    {
        $procedimiento->delete();

        return redirect()->route('control-clinico.procedimientos.index')
            ->with('success', 'Procedimiento eliminado correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'fecha_aplicacion'            => ['required', 'date'],
            'fecha_proxima'               => ['nullable', 'date', 'after_or_equal:fecha_aplicacion'],
            'observaciones_procedimiento' => ['nullable', 'string', 'max:100'],
            'id_animal'                   => ['required', 'exists:animales,id_animal'],
            'id_medicamento'              => ['required', 'exists:medicamentos,id_medicamento'],
        ]);
    }
}
