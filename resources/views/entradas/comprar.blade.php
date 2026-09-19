<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Comprar entradas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Comprar entradas</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-md">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('entradas.store') }}" class="bg-white shadow-sm rounded-lg p-6 space-y-4">
            @csrf

            <div>
                <label for="fecha_visita" class="block text-sm font-medium text-gray-700">Fecha de visita</label>
                <input type="date" id="fecha_visita" name="fecha_visita" value="{{ old('fecha_visita') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label for="id_tipo_entrada" class="block text-sm font-medium text-gray-700">Tipo de entrada</label>
                <select id="id_tipo_entrada" name="id_tipo_entrada" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">Selecciona una opción</option>
                    @foreach ($tiposEntrada as $tipo)
                        <option value="{{ $tipo->id_tipo_entrada }}" @selected(old('id_tipo_entrada') == $tipo->id_tipo_entrada)>
                            {{ str_replace('_', ' ', $tipo->nombre_entrada) }} - ${{ number_format($tipo->precio_entrada, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="cantidad_entrada" class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" id="cantidad_entrada" name="cantidad_entrada" min="1" max="20"
                    value="{{ old('cantidad_entrada', 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            @if ($promociones->isNotEmpty())
                <div>
                    <label for="id_promociones" class="block text-sm font-medium text-gray-700">Promoción (opcional)</label>
                    <select id="id_promociones" name="id_promociones" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Ninguna</option>
                        @foreach ($promociones as $promocion)
                            <option value="{{ $promocion->id_promociones }}" @selected(old('id_promociones') == $promocion->id_promociones)>
                                {{ $promocion->nombre_promociones }} ({{ $promocion->descuento_porcentaje }}%)
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-md">
                Confirmar compra
            </button>
        </form>
    </div>
</body>
</html>
