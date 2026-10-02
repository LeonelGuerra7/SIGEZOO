<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reporte de consumo de alimentos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Filtro de fechas --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="flex flex-wrap items-end gap-4">
                    <div>
                        <x-input-label for="desde" value="Desde" />
                        <input type="date" id="desde" name="desde" value="{{ $desde }}"
                               class="mt-1 border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <x-input-label for="hasta" value="Hasta" />
                        <input type="date" id="hasta" name="hasta" value="{{ $hasta }}"
                               class="mt-1 border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <x-primary-button>Filtrar</x-primary-button>
                </form>
            </div>

            {{-- Resumen --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center max-w-xs">
                <div class="text-3xl font-bold text-gray-800">{{ $totalRegistros }}</div>
                <div class="text-sm text-gray-500 mt-1">Registros de alimentación en el rango</div>
            </div>

            {{-- Consumo por alimento --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-medium text-gray-800 mb-4">Consumo por alimento</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Alimento</th>
                                <th class="px-4 py-3">Total consumido</th>
                                <th class="px-4 py-3">Veces registrado</th>
                                <th class="px-4 py-3">Stock actual</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($consumoPorAlimento as $nombreAlimento => $datos)
                                <tr>
                                    <td class="px-4 py-3">{{ $nombreAlimento }}</td>
                                    <td class="px-4 py-3">{{ $datos['total_consumido'] }} {{ $datos['unidad'] }}</td>
                                    <td class="px-4 py-3">{{ $datos['veces_registrado'] }}</td>
                                    <td class="px-4 py-3">{{ $datos['stock_actual'] }} {{ $datos['unidad'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                        No hay registros de alimentación en este rango de fechas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>