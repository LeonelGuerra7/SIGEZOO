<?php

namespace App\Http\Controllers\ControlClinico;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\ProcedimientoClinico;
use Illuminate\Http\Request;

class ReporteClinicoController extends Controller
{
    public function index(Request $request)
    {
        $animales = Animal::query()
            ->when($request->filled('especie'), fn ($q) => $q->where('especie_animal', $request->especie))
            ->orderBy('nombre_animal')
            ->get();

        $reporte = $animales->map(function ($animal) {
            $ultimo = ProcedimientoClinico::where('id_animal', $animal->id_animal)
                ->with('medicamento')
                ->orderByDesc('fecha_aplicacion')
                ->first();

            return [
                'animal'              => $animal,
                'ultimo_procedimiento' => $ultimo,
                'vacunas_por_vencer'  => ProcedimientoClinico::where('id_animal', $animal->id_animal)->vacunasPorVencer()->count(),
                'vacunas_vencidas'    => ProcedimientoClinico::where('id_animal', $animal->id_animal)->vacunasVencidas()->count(),
            ];
        });

        if ($request->boolean('solo_alertas')) {
            $reporte = $reporte->filter(fn ($r) => $r['vacunas_por_vencer'] > 0 || $r['vacunas_vencidas'] > 0)->values();
        }

        return view('control-clinico.reporte.index', [
            'reporte'  => $reporte,
            'especies' => Animal::select('especie_animal')->distinct()->orderBy('especie_animal')->pluck('especie_animal'),
        ]);
    }
}
