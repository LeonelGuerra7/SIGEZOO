<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Horarios y Entradas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Tarjeta 1: Tipos de entrada -->
            <div class="bg-white border border-gray-800 shadow-sm rounded-md p-6 mb-8">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Tipos de entrada</h2>
                <ul class="divide-y divide-gray-200">
                    @forelse ($tiposEntrada as $tipo)
                        <li class="py-2 flex justify-between">
                            <span class="capitalize">{{ str_replace('_', ' ', $tipo->nombre_entrada) }}</span>
                            <span class="font-semibold">${{ number_format($tipo->precio_entrada, 2) }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">No hay tipos de entrada disponibles.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Tarjeta 2: Promociones vigentes -->
            <div class="bg-white border border-gray-800 shadow-sm rounded-md p-6 mb-8">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Promociones vigentes</h2>
                <ul class="divide-y divide-gray-200">
                    @forelse ($promociones as $promocion)
                        <li class="py-2 flex justify-between">
                            <span>{{ $promocion->nombre_promociones }}</span>
                            <span class="font-semibold">{{ $promocion->descuento_porcentaje }}% dto.</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">No hay promociones vigentes.</li>
                    @endforelse
                </ul>
            </div>

            <a href="{{ route('entradas.comprar') }}" class="inline-block px-4 py-2 bg-gray-800 text-white rounded-md">
                Comprar entradas
            </a>
        </div>
    </div>
</x-app-layout>
