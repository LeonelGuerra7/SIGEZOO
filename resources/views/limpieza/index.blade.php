<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Limpieza — tareas por área
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="limpiezaModal({
             storeUrl: {{ \Illuminate\Support\Js::from(route('limpieza.store')) }},
             updateUrl: {{ \Illuminate\Support\Js::from(route('limpieza.update', '__ID__')) }},
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

                {{-- Filtros + botón nuevo --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-3">
                        <select name="area" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Todas las áreas</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id_areas }}" @selected(request('area') == $a->id_areas)>{{ $a->nombre_area }}</option>
                            @endforeach
                        </select>
                        <select name="estado" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Todos los estados</option>
                            @foreach ($estados as $e)
                                <option value="{{ $e }}" @selected(request('estado') === $e)>{{ $e }}</option>
                            @endforeach
                        </select>
                        <x-primary-button>Filtrar</x-primary-button>
                    </form>

                    <x-primary-button type="button" x-on:click="crear()">Nuevo registro</x-primary-button>
                </div>

                {{-- Tabla --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Área</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Observaciones</th>
                                <th class="px-4 py-3">Registrado por</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($tareas as $t)
                                <tr>
                                    <td class="px-4 py-3">{{ $t->fecha_limpieza->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $t->area?->nombre_area ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $t->estado_limpieza === 'Completo' ? 'text-green-700' : 'text-amber-700' }} font-medium">
                                            {{ $t->estado_limpieza }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $t->observaciones_limpieza ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $t->usuario?->name ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <x-secondary-button type="button"
                                                x-on:click="editar({
                                                    id_limpieza: {{ $t->id_limpieza }},
                                                    fecha_limpieza: {{ \Illuminate\Support\Js::from($t->fecha_limpieza->format('Y-m-d\TH:i')) }},
                                                    estado_limpieza: {{ \Illuminate\Support\Js::from($t->estado_limpieza) }},
                                                    observaciones_limpieza: {{ \Illuminate\Support\Js::from($t->observaciones_limpieza) }},
                                                    id_areas: {{ $t->id_areas ?? 'null' }},
                                                })">
                                                Editar
                                            </x-secondary-button>

                                            <form method="POST"
                                                  action="{{ route('limpieza.destroy', $t->id_limpieza) }}"
                                                  onsubmit="return confirm('¿Eliminar este registro?')">
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

                <div class="mt-4">{{ $tareas->links() }}</div>
            </div>
        </div>

        {{-- Modal compartido para crear y editar --}}
        <x-modal name="form-limpieza" :show="$errors->any()" focusable>
            <form method="POST" :action="action" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_modo" :value="modo">
                <input type="hidden" name="_id" :value="id">
                <template x-if="modo === 'editar'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <h2 class="text-lg font-medium text-gray-900"
                    x-text="modo === 'editar' ? 'Editar tarea de limpieza' : 'Nueva tarea de limpieza'"></h2>

                <div>
                    <x-input-label for="fecha_limpieza" value="Fecha y hora" />
                    <x-text-input id="fecha_limpieza" name="fecha_limpieza" type="datetime-local"
                                  class="mt-1 block w-full" x-model="form.fecha_limpieza" />
                    <x-input-error :messages="$errors->get('fecha_limpieza')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="id_areas" value="Área" />
                    <select id="id_areas" name="id_areas" x-model="form.id_areas"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($areas as $a)
                            <option value="{{ $a->id_areas }}">{{ $a->nombre_area }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_areas')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="estado_limpieza" value="Estado" />
                    <select id="estado_limpieza" name="estado_limpieza" x-model="form.estado_limpieza"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($estados as $e)
                            <option value="{{ $e }}">{{ $e }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('estado_limpieza')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="observaciones_limpieza" value="Observaciones (opcional)" />
                    <x-text-input id="observaciones_limpieza" name="observaciones_limpieza" type="text"
                                  class="mt-1 block w-full" maxlength="100" x-model="form.observaciones_limpieza" />
                    <x-input-error :messages="$errors->get('observaciones_limpieza')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-primary-button>Guardar</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        function limpiezaModal(cfg) {
            const vacio = {
                fecha_limpieza: '', estado_limpieza: '', observaciones_limpieza: '', id_areas: '',
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
                    this.$dispatch('open-modal', 'form-limpieza');
                },
                editar(t) {
                    this.modo = 'editar';
                    this.id = t.id_limpieza;
                    this.form = { ...vacio, ...t, id_areas: t.id_areas ?? '' };
                    this.$dispatch('open-modal', 'form-limpieza');
                },
            };
        }
    </script>
</x-app-layout>