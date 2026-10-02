<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alimentación — horarios y dietas
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="dietaModal({
             storeUrl: {{ \Illuminate\Support\Js::from(route('alimentacion.dietas.store')) }},
             updateUrl: {{ \Illuminate\Support\Js::from(route('alimentacion.dietas.update', '__ID__')) }},
             old: {{ \Illuminate\Support\Js::from(old()) }},
         })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-800">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Filtro + botón nuevo --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-3">
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="Buscar por nombre"
                               class="border-gray-300 rounded-md shadow-sm text-sm">
                        <x-primary-button>Filtrar</x-primary-button>
                    </form>

                    <x-primary-button type="button" x-on:click="crear()">Nueva dieta</x-primary-button>
                </div>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Cantidad</th>
                                <th class="px-4 py-3">Frecuencia</th>
                                <th class="px-4 py-3">Fecha de distribución</th>
                                <th class="px-4 py-3">Alimento</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($dietas as $d)
                                <tr>
                                    <td class="px-4 py-3">{{ $d->nombre_dieta }}</td>
                                    <td class="px-4 py-3">{{ $d->cantidad_dieta }}</td>
                                    <td class="px-4 py-3">{{ $d->frecuencia }}</td>
                                    <td class="px-4 py-3">{{ $d->fecha_distribucion->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $d->alimento?->nombre_alimento ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <x-secondary-button type="button"
                                                x-on:click="editar({
                                                    id_dietas: {{ $d->id_dietas }},
                                                    nombre_dieta: {{ \Illuminate\Support\Js::from($d->nombre_dieta) }},
                                                    cantidad_dieta: {{ $d->cantidad_dieta }},
                                                    frecuencia: {{ \Illuminate\Support\Js::from($d->frecuencia) }},
                                                    fecha_distribucion: {{ \Illuminate\Support\Js::from($d->fecha_distribucion->format('Y-m-d\TH:i')) }},
                                                    id_alimentos: {{ $d->id_alimentos ?? 'null' }},
                                                })">
                                                Editar
                                            </x-secondary-button>

                                            <form method="POST"
                                                  action="{{ route('alimentacion.dietas.destroy', $d->id_dietas) }}"
                                                  onsubmit="return confirm('¿Eliminar esta dieta?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Eliminar</x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        No hay registros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $dietas->links() }}</div>
            </div>
        </div>

        {{-- Modal compartido para crear y editar --}}
        <x-modal name="form-dieta" :show="$errors->any()" focusable>
            <form method="POST" :action="action" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_modo" :value="modo">
                <input type="hidden" name="_id" :value="id">
                <template x-if="modo === 'editar'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <h2 class="text-lg font-medium text-gray-900"
                    x-text="modo === 'editar' ? 'Editar dieta' : 'Nueva dieta'"></h2>

                <div>
                    <x-input-label for="nombre_dieta" value="Nombre" />
                    <x-text-input id="nombre_dieta" name="nombre_dieta" type="text"
                                  class="mt-1 block w-full" maxlength="50" x-model="form.nombre_dieta" />
                    <x-input-error :messages="$errors->get('nombre_dieta')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="cantidad_dieta" value="Cantidad" />
                        <x-text-input id="cantidad_dieta" name="cantidad_dieta" type="number" min="1"
                                      class="mt-1 block w-full" x-model="form.cantidad_dieta" />
                        <x-input-error :messages="$errors->get('cantidad_dieta')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="frecuencia" value="Frecuencia" />
                        <x-text-input id="frecuencia" name="frecuencia" type="text"
                                      class="mt-1 block w-full" maxlength="50" placeholder="ej. Diaria, cada 8 horas"
                                      x-model="form.frecuencia" />
                        <x-input-error :messages="$errors->get('frecuencia')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="fecha_distribucion" value="Fecha y hora de distribución" />
                    <x-text-input id="fecha_distribucion" name="fecha_distribucion" type="datetime-local"
                                  class="mt-1 block w-full" x-model="form.fecha_distribucion" />
                    <x-input-error :messages="$errors->get('fecha_distribucion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="id_alimentos" value="Alimento (opcional)" />
                    <select id="id_alimentos" name="id_alimentos" x-model="form.id_alimentos"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Sin alimento asignado</option>
                        @foreach ($alimentos as $al)
                            <option value="{{ $al->id_alimientos }}">{{ $al->nombre_alimento }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_alimentos')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-primary-button>Guardar</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        function dietaModal(cfg) {
            const vacio = {
                nombre_dieta: '', cantidad_dieta: '', frecuencia: '', fecha_distribucion: '', id_alimentos: '',
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
                    this.$dispatch('open-modal', 'form-dieta');
                },
                editar(d) {
                    this.modo = 'editar';
                    this.id = d.id_dietas;
                    this.form = { ...vacio, ...d, id_alimentos: d.id_alimentos ?? '' };
                    this.$dispatch('open-modal', 'form-dieta');
                },
            };
        }
    </script>
</x-app-layout>