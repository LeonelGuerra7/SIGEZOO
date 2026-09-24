<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Compra confirmada</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-800 shadow-sm rounded-md p-8 text-center">

                <!-- Icono de éxito -->
                <div class="w-16 h-16 border-2 border-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-3xl font-bold text-gray-800">✓</span>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-6">¡Gracias por tu compra!</h3>

                <!-- Detalle del Ticket -->
                <div class="text-left bg-gray-50 border border-gray-200 rounded-md p-6 space-y-3 mb-8">
                    <p><span class="font-semibold text-gray-700 w-40 inline-block">N.° de entrada:</span> {{ $entrada->id_entradas }}</p>
                    <p><span class="font-semibold text-gray-700 w-40 inline-block">Tipo:</span> {{ str_replace('_', ' ', $entrada->tipoEntrada->nombre_entrada) }}</p>
                    <p><span class="font-semibold text-gray-700 w-40 inline-block">Cantidad:</span> {{ $entrada->cantidad_entrada }}</p>
                    <p><span class="font-semibold text-gray-700 w-40 inline-block">Fecha de visita:</span> {{ $entrada->fecha_visita->format('d/m/Y') }}</p>

                    @if ($entrada->promocion)
                        <p><span class="font-semibold text-gray-700 w-40 inline-block">Promoción aplicada:</span> {{ $entrada->promocion->nombre_promociones }}</p>
                    @endif

                    <div class="pt-4 mt-2 border-t border-gray-200">
                        <p class="flex items-center">
                            <span class="font-bold text-gray-900 text-lg w-40 inline-block">Total pagado:</span>
                            <span class="font-bold text-gray-900 text-lg">${{ number_format($entrada->total, 2) }}</span>
                        </p>
                    </div>
                    <p><span class="font-semibold text-gray-700 w-40 inline-block">Estado:</span> <span class="capitalize">{{ $entrada->estado_pago }}</span></p>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('entradas.index') }}" class="px-6 py-2 bg-white border border-gray-800 text-gray-800 rounded-sm text-sm hover:bg-gray-50 transition">
                        Volver a horarios
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-800 border border-gray-800 text-white rounded-sm text-sm hover:bg-gray-900 transition">
                        Ir al Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
