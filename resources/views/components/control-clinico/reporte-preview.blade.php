@php
    use App\Models\Animal;
    use App\Models\ProcedimientoClinico;

    $totalAnimales = Animal::count();
    $conAlerta = $totalAnimales
        ? Animal::get()->filter(fn ($a) =>
            ProcedimientoClinico::where('id_animal', $a->id_animal)->vacunasPorVencer()->exists()
            || ProcedimientoClinico::where('id_animal', $a->id_animal)->vacunasVencidas()->exists())
        : collect();
@endphp

<div class="bg-white shadow-sm sm:rounded-lg p-5">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-700">Reporte de estado clínico</h3>
        <a href="{{ route('control-clinico.reporte') }}" class="text-xs text-indigo-600 hover:underline">Ver reporte completo</a>
    </div>
    <p class="text-sm text-gray-600">
        {{ $totalAnimales }} animal{{ $totalAnimales === 1 ? '' : 'es' }} registrado{{ $totalAnimales === 1 ? '' : 's' }},
        {{ $conAlerta->count() }} con alertas de vacunación.
    </p>
</div>
