@php
    use App\Models\Medicamento;

    $bajoStock = Medicamento::whereColumn('stock_medicamento', '<=', 'stock_minimo_medicamento')
        ->orderBy('nombre_medicamento')->take(5)->get();
    $total = Medicamento::count();
@endphp

<div class="bg-white shadow-sm sm:rounded-lg p-5">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-700">Medicamentos, vacunas y vitaminas</h3>
        <a href="{{ route('control-clinico.medicamentos.index') }}" class="text-xs text-indigo-600 hover:underline">Ver todos ({{ $total }})</a>
    </div>
    @if ($bajoStock->isEmpty())
        <p class="text-sm text-gray-500">Todo el stock está en niveles normales.</p>
    @else
        <ul class="divide-y divide-gray-100 text-sm">
            @foreach ($bajoStock as $m)
                <li class="py-2 flex justify-between">
                    <span>{{ $m->nombre_medicamento }}</span>
                    <span class="text-red-600 font-medium">{{ $m->stock_medicamento }} / {{ $m->stock_minimo_medicamento }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
