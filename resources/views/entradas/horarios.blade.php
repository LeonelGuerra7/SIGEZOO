<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Horarios y Entradas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Horarios y Entradas</h1>

        <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
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

        <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
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
</body>
</html>
