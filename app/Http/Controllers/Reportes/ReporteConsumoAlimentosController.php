<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\RegistroAlimentacion;
use Illuminate\Http\Request;

class ReporteConsumoAlimentosController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->filled('desde') ? $request->desde : now()->subDays(30)->toDateString();
        $hasta = $request->filled('hasta') ? $request->hasta : now()->toDateString();

        $registros = RegistroAlimentacion::query()
            ->with('dieta.alimento')
            ->whereBetween('fecha_registro', [$desde . ' 00:00:00', $hasta . ' 23:59:59'])
            ->get();

        $consumoPorAlimento = $registros
            ->filter(fn ($r) => $r->dieta?->alimento)
            ->groupBy(fn ($r) => $r->dieta->alimento->nombre_alimento)
            ->map(function ($grupo) {
                $alimento = $grupo->first()->dieta->alimento;
                return [
                    'total_consumido' => $grupo->sum('cantidad_administrada'),
                    'unidad' => $alimento->unidad_medida_alimento,
                    'stock_actual' => $alimento->stock_alimento,
                    'veces_registrado' => $grupo->count(),
                ];
            })
            ->sortByDesc('total_consumido');

        return view('reportes.consumo-alimentos', [
            'desde' => $desde,
            'hasta' => $hasta,
            'consumoPorAlimento' => $consumoPorAlimento,
            'totalRegistros' => $registros->count(),
        ]);
    }
}