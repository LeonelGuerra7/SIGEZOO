<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reporte de estado clínico</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
                    <select name="especie" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Todas las especies</option>
                        @foreach ($especies as $e)
                            <option value="{{ $e }}" @selected(request('especie') === $e)>{{ $e }}</option>
                        @endforeach
                    </select>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="solo_alertas" value="1" @checked(request('solo_alertas'))>
                        Solo con alertas
                    </label>
                    <x-primary-button>Filtrar</x-primary-button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Animal</th>
                                <th class="px-4 py-3">Especie</th>
                                <th class="px-4 py-3">Último procedimiento</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Vacunas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($reporte as $r)
                                <tr>
                                    <td class="px-4 py-3">{{ $r['animal']->nombre_animal }}</td>
                                    <td class="px-4 py-3">{{ $r['animal']->especie_animal }}</td>
                                    <td class="px-4 py-3">
                                        {{ $r['ultimo_procedimiento']?->medicamento?->nombre_medicamento ?? 'Sin registros' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $r['ultimo_procedimiento']?->fecha_aplicacion?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($r['vacunas_vencidas'] > 0)
                                            <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700">{{ $r['vacunas_vencidas'] }} vencida(s)</span>
                                        @endif
                                        @if ($r['vacunas_por_vencer'] > 0)
                                            <span class="text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-700">{{ $r['vacunas_por_vencer'] }} por vencer</span>
                                        @endif
                                        @if ($r['vacunas_vencidas'] === 0 && $r['vacunas_por_vencer'] === 0)
                                            <span class="text-xs text-gray-500">Al día</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Sin animales que mostrar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
