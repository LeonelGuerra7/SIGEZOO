<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alimentación — inventario de alimentos
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="alimentoModal({
             storeUrl: {{ \Illuminate\Support\Js::from(route('alimentacion.alimentos.store')) }},
             updateUrl: {{ \Illuminate\Support\Js::from(route('alimentacion.alimentos.update', '__ID__')) }},
             old: {{ \Illuminate\Support\Js::from(old()) }},
         })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-800">{{ session('error') }}</div>
            @endif

            @php $stockBajoCount = $alimentos->filter(fn ($a) => $a->stockBajo())->count(); @endphp
            @if ($stockBajoCount > 0)
                <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-800">
                    ⚠ Tienes <strong>{{ $stockBajoCount }}</strong>
                    {{ $stockBajoCount === 1 ? 'alimento' : 'alimentos' }} con stock por debajo del mínimo.
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Filtros + botón nuevo --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="Buscar por nombre"
                               class="border-gray-300 rounded-md shadow-sm text-sm">
                        <select name="tipo" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Todos los tipos</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t }}" @selected(request('tipo') === $t)>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                        <x-primary-button>Filtrar</x-primary-button>
                    </form>

                    <x-primary-button type="button" x-on:click="crear()">Nuevo alimento</x-primary-button>
                </div>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Tipo</th>
                                <th class="px-4 py-3">Stock</th>
                                <th class="px-4 py-3">Mínimo</th>
                                <th class="px-4 py-3">Unidad</th>
                                <th class="px-4 py-3">Proveedor</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($alimentos as $al)
                                <tr>
                                    <td class="px-4 py-3">{{ $al->nombre_alimento }}</td>
                                    <td class="px-4 py-3">{{ ucfirst($al->tipo_alimento) }}</td>
                                    <td class="px-4 py-3 {{ $al->stockBajo() ? 'text-red-600 font-semibold' : '' }}">
                                        {{ $al->stock_alimento }}
                                        @if ($al->stockBajo())
                                            <span class="ml-1 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Stock bajo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $al->stock_minimo_alimento }}</td>
                                    <td class="px-4 py-3">{{ $al->unidad_medida_alimento }}</td>
                                    <td class="px-4 py-3">{{ $al->proveedor?->nombre_proveedor ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <x-secondary-button type="button"
                                                x-on:click="editar({
                                                    id_alimientos: {{ $al->id_alimientos }},
                                                    nombre_alimento: {{ \Illuminate\Support\Js::from($al->nombre_alimento) }},
                                                    tipo_alimento: {{ \Illuminate\Support\Js::from($al->tipo_alimento) }},
                                                    stock_alimento: {{ $al->stock_alimento }},
                                                    stock_minimo_alimento: {{ $al->stock_minimo_alimento }},
                                                    unidad_medida_alimento: {{ \Illuminate\Support\Js::from($al->unidad_medida_alimento) }},
                                                    id_proveedores: {{ $al->id_proveedores ?? 'null' }},
                                                })">
                                                Editar
                                            </x-secondary-button>

                                            <form method="POST"
                                                  action="{{ route('alimentacion.alimentos.destroy', $al->id_alimientos) }}"
                                                  onsubmit="return confirm('¿Eliminar este alimento?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Eliminar</x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No hay registros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $alimentos->links() }}</div>
            </div>
        </div>

        {{-- Modal compartido para crear y editar --}}
        <x-modal name="form-alimento" :show="$errors->any()" focusable>
            <form method="POST" :action="action" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_modo" :value="modo">
                <input type="hidden" name="_id" :value="id">
                <template x-if="modo === 'editar'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <h2 class="text-lg font-medium text-gray-900"
                    x-text="modo === 'editar' ? 'Editar alimento' : 'Nuevo alimento'"></h2>

                <div>
                    <x-input-label for="nombre_alimento" value="Nombre" />
                    <x-text-input id="nombre_alimento" name="nombre_alimento" type="text"
                                  class="mt-1 block w-full" maxlength="50" x-model="form.nombre_alimento" />
                    <x-input-error :messages="$errors->get('nombre_alimento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tipo_alimento" value="Tipo" />
                    <select id="tipo_alimento" name="tipo_alimento" x-model="form.tipo_alimento"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($tipos as $t)
                            <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipo_alimento')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="stock_alimento" value="Stock" />
                        <x-text-input id="stock_alimento" name="stock_alimento" type="number" min="0"
                                      class="mt-1 block w-full" x-model="form.stock_alimento" />
                        <x-input-error :messages="$errors->get('stock_alimento')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="stock_minimo_alimento" value="Stock mínimo" />
                        <x-text-input id="stock_minimo_alimento" name="stock_minimo_alimento" type="number" min="0"
                                      class="mt-1 block w-full" x-model="form.stock_minimo_alimento" />
                        <x-input-error :messages="$errors->get('stock_minimo_alimento')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="unidad_medida_alimento" value="Unidad de medida" />
                    <x-text-input id="unidad_medida_alimento" name="unidad_medida_alimento" type="text"
                                  class="mt-1 block w-full" maxlength="20" x-model="form.unidad_medida_alimento" />
                    <x-input-error :messages="$errors->get('unidad_medida_alimento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="id_proveedores" value="Proveedor (opcional)" />
                    <select id="id_proveedores" name="id_proveedores" x-model="form.id_proveedores"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Sin proveedor</option>
                        @foreach ($proveedores as $p)
                            <option value="{{ $p->id_proveedores }}">{{ $p->nombre_proveedor }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_proveedores')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-primary-button>Guardar</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        function alimentoModal(cfg) {
            const vacio = {
                nombre_alimento: '', tipo_alimento: '', stock_alimento: '',
                stock_minimo_alimento: '', unidad_medida_alimento: '', id_proveedores: '',
            };
            return {
                modo: cfg.old._modo ?? 'crear',
                id: cfg.old._id ?? null,
                form: cfg.old._modo ? { ...vacio, ...cfg.old } : { ...vacio },

                get action() {
                    return this.modo === 'editar'
                        ? cfg.updateUrl.replace('__ID__', this.id)
                        : cfg.storeUrl;
                },
                crear() {
                    this.modo = 'crear';
                    this.id = null;
                    this.form = { ...vacio };
                    this.$dispatch('open-modal', 'form-alimento');
                },
                editar(a) {
                    this.modo = 'editar';
                    this.id = a.id_alimientos;
                    this.form = { ...vacio, ...a, id_proveedores: a.id_proveedores ?? '' };
                    this.$dispatch('open-modal', 'form-alimento');
                },
            };
        }
    </script>
</x-app-layout>