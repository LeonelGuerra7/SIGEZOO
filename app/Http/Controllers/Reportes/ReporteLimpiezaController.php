<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\TareaLimpieza;
use Illuminate\Http\Request;

class ReporteLimpiezaController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->filled('desde') ? $request->desde : now()->subDays(30)->toDateString();
        $hasta = $request->filled('hasta') ? $request->hasta : now()->toDateString();

        $tareas = TareaLimpieza::query()
            ->with('area')
            ->whereBetween('fecha_limpieza', [$desde . ' 00:00:00', $hasta . ' 23:59:59'])
            ->when($request->filled('area'), fn ($q) => $q->where('id_areas', $request->area))
            ->get();

        $totalTareas = $tareas->count();
        $completadas = $tareas->where('estado_limpieza', 'Completo')->count();
        $incompletas = $totalTareas - $completadas;
        $porcentaje = $totalTareas > 0 ? round(($completadas / $totalTareas) * 100, 1) : 0;

        $porArea = $tareas->groupBy(fn ($t) => $t->area?->nombre_area ?? 'Sin área')
            ->map(function ($grupo) {
                $total = $grupo->count();
                $comp = $grupo->where('estado_limpieza', 'Completo')->count();
                return [
                    'total' => $total,
                    'completadas' => $comp,
                    'incompletas' => $total - $comp,
                    'porcentaje' => $total > 0 ? round(($comp / $total) * 100, 1) : 0,
                ];
            });

        return view('reportes.limpieza', [
            'desde' => $desde,
            'hasta' => $hasta,
            'areas' => Area::orderBy('nombre_area')->get(),
            'totalTareas' => $totalTareas,
            'completadas' => $completadas,
            'incompletas' => $incompletas,
            'porcentaje' => $porcentaje,
            'porArea' => $porArea,
        ]);
    }
}