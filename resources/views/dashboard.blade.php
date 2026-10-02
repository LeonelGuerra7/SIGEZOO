<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <!-- Fondo gris claro de la página -->
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Alerta estilo Wireframe (badge-alert) -->
            <div class="bg-white border border-gray-800 rounded-md p-4 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-gray-800 flex-none"></span>
                <p class="text-sm text-gray-800">Reporte de estado clínico: 0 animales registrados, 0 con alertas de vacunación.</p>
            </div>

            <!-- Grid de Tarjetas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Tarjeta: Reporte Clínico -->
                <div class="bg-white border border-gray-800 rounded-md p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 mb-2">Reporte de estado clínico</h3>
                        <p class="text-xs text-gray-500">0 animales registrados, 0 con alertas de vacunación.</p>
                    </div>
                    <!-- Asegúrate de que esta ruta exista en tu web.php -->
                    <a href="{{ route('control-clinico.reporte') }}" class="text-xs text-indigo-600 hover:underline mt-4 text-right">Ver reporte completo</a>
                </div>

                <!-- Tarjeta: Medicamentos -->
                <div class="bg-white border border-gray-800 rounded-md p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 mb-2">Medicamentos, vacunas y vitaminas</h3>
                        <p class="text-xs text-gray-500">Todo el stock está en niveles normales.</p>
                    </div>
                    <a href="{{ route('control-clinico.medicamentos.index') }}" class="text-xs text-indigo-600 hover:underline mt-4 text-right">Ver todos (0)</a>
                </div>

                <!-- Tarjeta: Entradas y Promociones -->
                <div class="bg-white border border-gray-800 rounded-md p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 mb-2">Entradas y promociones</h3>
                        <p class="text-xs text-gray-500">Gestión de tickets y descuentos.</p>
                    </div>
                    <!-- Redirige a la vista que acabamos de arreglar -->
                    <a href="{{ route('entradas.index') }}" class="text-xs text-indigo-600 hover:underline mt-4 text-right">Ver portal</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
