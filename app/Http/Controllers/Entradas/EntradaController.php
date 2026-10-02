<?php

namespace App\Http\Controllers\Entradas;

use App\Http\Controllers\Controller;
use App\Models\Entrada;
use App\Models\Promocion;
use App\Models\TipoEntrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    /**
     * Página pública: horarios y promociones vigentes.
     */
    public function index()
    {
        $tiposEntrada = TipoEntrada::orderBy('precio_entrada')->get();
        $promociones = Promocion::vigentes()->orderBy('fecha_fin')->get();

        return view('entradas.horarios', compact('tiposEntrada', 'promociones'));
    }

    /**
     * Formulario de compra.
     */
    public function create()
    {
        $tiposEntrada = TipoEntrada::orderBy('nombre_entrada')->get();
        $promociones = Promocion::vigentes()->orderBy('fecha_fin')->get();

        return view('entradas.comprar', compact('tiposEntrada', 'promociones'));
    }

    /**
     * Procesa la compra (pago simulado, sin pasarela real).
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'fecha_visita' => ['required', 'date', 'after_or_equal:today'],
            'cantidad_entrada' => ['required', 'integer', 'min:1', 'max:20'],
            'id_tipo_entrada' => ['required', 'exists:tipos_entrada,id_tipo_entrada'],
            'id_promociones' => ['nullable', 'exists:promociones,id_promociones'],
        ]);

        $tipoEntrada = TipoEntrada::findOrFail($datos['id_tipo_entrada']);
        $subtotal = $tipoEntrada->precio_entrada * $datos['cantidad_entrada'];

        $promocion = null;
        $total = $subtotal;

        if (!empty($datos['id_promociones'])) {
            $promocion = Promocion::vigentes()->find($datos['id_promociones']);
            if ($promocion) {
                $total = $subtotal - ($subtotal * ($promocion->descuento_porcentaje / 100));
            }
        }

        $entrada = DB::transaction(function () use ($datos, $total, $promocion) {
            return Entrada::create([
                'fecha_visita' => $datos['fecha_visita'],
                'cantidad_entrada' => $datos['cantidad_entrada'],
                'total' => $total,
                'estado_pago' => 'pagado', // pago simulado
                'fecha_compra' => now(),
                'id_tipo_entrada' => $datos['id_tipo_entrada'],
                'id_promociones' => $promocion?->id_promociones,
                'id_usuario' => Auth::id(), // null si es visitante sin cuenta
            ]);
        });

        // Si la petición viene desde Alpine/Fetch (AJAX)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Compra exitosa',
                'id_entradas' => $entrada->id_entradas,
                'total' => number_format($entrada->total, 2),
                'estado_pago' => $entrada->estado_pago
            ], 201);
        }

        return redirect()
            ->route('entradas.confirmacion', $entrada->id_entradas);
    }

    /**
     * Confirmación de compra.
     */
    public function confirmacion(int $id)
    {
        $entrada = Entrada::with(['tipoEntrada', 'promocion'])->findOrFail($id);

        return view('entradas.confirmacion', compact('entrada'));
    }
}
