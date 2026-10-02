<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Comprar entradas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Enlace de regreso -->
            <div class="mb-6">
                <a href="{{ route('entradas.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    &larr; Volver a horarios
                </a>
            </div>

            <!-- Manejo de Errores -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-md text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario (Estilo Wireframe) -->
            <form method="POST" action="{{ route('entradas.store') }}" class="bg-white border border-gray-800 shadow-sm rounded-md p-6 space-y-4">
                @csrf

                <div>
                    <x-input-label for="fecha_visita" value="Fecha de visita" />
                    <input type="date" id="fecha_visita" name="fecha_visita" value="{{ old('fecha_visita') }}"
                        class="mt-1 block w-full border border-gray-800 rounded-sm shadow-sm text-sm" required>
                </div>

                <div>
                    <x-input-label for="id_tipo_entrada" value="Tipo de entrada" />
                    <select id="id_tipo_entrada" name="id_tipo_entrada" class="mt-1 block w-full border border-gray-800 rounded-sm shadow-sm text-sm" required>
                        <option value="">Selecciona una opción</option>
                        @foreach ($tiposEntrada as $tipo)
                            <option value="{{ $tipo->id_tipo_entrada }}" @selected(old('id_tipo_entrada') == $tipo->id_tipo_entrada)>
                                {{ str_replace('_', ' ', $tipo->nombre_entrada) }} - ${{ number_format($tipo->precio_entrada, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="cantidad_entrada" value="Cantidad" />
                    <input type="number" id="cantidad_entrada" name="cantidad_entrada" min="1" max="20"
                        value="{{ old('cantidad_entrada', 1) }}" class="mt-1 block w-full border border-gray-800 rounded-sm shadow-sm text-sm" required>
                </div>

                @if ($promociones->isNotEmpty())
                    <div>
                        <x-input-label for="id_promociones" value="Promoción (opcional)" />
                        <select id="id_promociones" name="id_promociones" class="mt-1 block w-full border border-gray-800 rounded-sm shadow-sm text-sm">
                            <option value="">Ninguna</option>
                            @foreach ($promociones as $promocion)
                                <option value="{{ $promocion->id_promociones }}" @selected(old('id_promociones') == $promocion->id_promociones)>
                                    {{ $promocion->nombre_promociones }} ({{ $promocion->descuento_porcentaje }}%)
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="pt-4 text-right">
                    <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-sm text-sm hover:bg-gray-900 transition">
                        Confirmar compra
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
