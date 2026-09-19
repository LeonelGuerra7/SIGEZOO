<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Confirmación de compra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Compra confirmada</h1>

        <div class="bg-white shadow-sm rounded-lg p-6 space-y-3">
            <p><span class="font-medium">N.° de entrada:</span> {{ $entrada->id_entradas }}</p>
            <p><span class="font-medium">Tipo:</span> {{ str_replace('_', ' ', $entrada->tipoEntrada->nombre_entrada) }}</p>
            <p><span class="font-medium">Cantidad:</span> {{ $entrada->cantidad_entrada }}</p>
            <p><span class="font-medium">Fecha de visita:</span> {{ $entrada->fecha_visita->format('d/m/Y') }}</p>
            @if ($entrada->promocion)
                <p><span class="font-medium">Promoción aplicada:</span> {{ $entrada->promocion->nombre_promociones }}</p>
            @endif
            <p><span class="font-medium">Total pagado:</span> ${{ number_format($entrada->total, 2) }}</p>
            <p><span class="font-medium">Estado:</span> {{ ucfirst($entrada->estado_pago) }}</p>
        </div>

        <a href="{{ route('entradas.index') }}" class="inline-block mt-6 px-4 py-2 bg-gray-800 text-white rounded-md">
            Volver a horarios
        </a>
    </div>
</body>
</html>
