@if ($porVencer > 0 || $vencidas > 0)
<div class="bg-white shadow-sm sm:rounded-lg p-5 mb-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Vacunas — Control clínico</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @if ($porVencer > 0)
            <a href="{{ route('control-clinico.procedimientos.index', ['estado' => 'por_vencer']) }}"
               class="flex items-center gap-3 rounded-md bg-amber-50 border border-amber-200 p-4 hover:bg-amber-100">
                <span class="text-2xl font-bold text-amber-700">{{ $porVencer }}</span>
                <span class="text-sm text-amber-800">próxima{{ $porVencer === 1 ? '' : 's' }} a vencer</span>
            </a>
        @endif
        @if ($vencidas > 0)
            <a href="{{ route('control-clinico.procedimientos.index', ['estado' => 'vencidas']) }}"
               class="flex items-center gap-3 rounded-md bg-red-50 border border-red-200 p-4 hover:bg-red-100">
                <span class="text-2xl font-bold text-red-700">{{ $vencidas }}</span>
                <span class="text-sm text-red-800">vencida{{ $vencidas === 1 ? '' : 's' }}</span>
            </a>
        @endif
    </div>
</div>
@endif
