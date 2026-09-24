<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reporte de cumplimiento de limpieza
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Filtro de fechas y área --}}
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
                    <div>
                        <x-input-label for="area" value="Área" />
                        <select id="area" name="area" class="mt-1 border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Todas</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id_areas }}" @selected(request('area') == $a->id_areas)>{{ $a->nombre_area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>Filtrar</x-primary-button>
                </form>
            </div>

            {{-- Resumen general --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-gray-800">{{ $totalTareas }}</div>
                    <div class="text-sm text-gray-500 mt-1">Total de tareas</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $completadas }}</div>
                    <div class="text-sm text-gray-500 mt-1">Completadas</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-amber-600">{{ $incompletas }}</div>
                    <div class="text-sm text-gray-500 mt-1">Incompletas</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $porcentaje }}%</div>
                    <div class="text-sm text-gray-500 mt-1">Cumplimiento</div>
                </div>
            </div>

            {{-- Desglose por área --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-medium text-gray-800 mb-4">Cumplimiento por área</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Área</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Completadas</th>
                                <th class="px-4 py-3">Incompletas</th>
                                <th class="px-4 py-3">% Cumplimiento</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($porArea as $nombreArea => $datos)
                                <tr>
                                    <td class="px-4 py-3">{{ $nombreArea }}</td>
                                    <td class="px-4 py-3">{{ $datos['total'] }}</td>
                                    <td class="px-4 py-3 text-green-700">{{ $datos['completadas'] }}</td>
                                    <td class="px-4 py-3 text-amber-700">{{ $datos['incompletas'] }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $datos['porcentaje'] }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        No hay tareas registradas en este rango de fechas.
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