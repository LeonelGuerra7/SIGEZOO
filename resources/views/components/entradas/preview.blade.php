@php
    use App\Models\TipoEntrada;
    use App\Models\Promocion;

    $tiposCount = class_exists(TipoEntrada::class) ? TipoEntrada::count() : 0;
    $promoVigentes = class_exists(Promocion::class)
        ? Promocion::whereDate('fecha_inicio', '<=', now())->whereDate('fecha_fin', '>=', now())->count()
        : 0;
@endphp

@if (Route::has('entradas.index'))
<div class="bg-white shadow-sm sm:rounded-lg p-5">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-700">Entradas y promociones</h3>
        <a href="{{ route('entradas.index') }}" class="text-xs text-indigo-600 hover:underline">Ver portal</a>
    </div>
    <p class="text-sm text-gray-600">
        {{ $tiposCount }} tipo{{ $tiposCount === 1 ? '' : 's' }} de entrada · {{ $promoVigentes }} promoción(es) vigente(s)
    </p>
</div>
@endif
