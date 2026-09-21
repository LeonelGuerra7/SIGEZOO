<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Procedimientos clínicos</h2>
    </x-slot>

    <div class="py-12"
         x-data="procedimientoModal({
             storeUrl: @js(route('control-clinico.procedimientos.store')),
             updateUrl: @js(route('control-clinico.procedimientos.update', '__ID__')),
             old: @js(old()),
             hoy: @js(now()->format('Y-m-d')),
         })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-800">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-3">
                        <select name="animal" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Todos los animales</option>
                            @foreach ($animales as $a)
                                <option value="{{ $a->id_animal }}" @selected(request('animal') == $a->id_animal)>
                                    {{ $a->nombre_animal }}
                                </option>
                            @endforeach
                        </select>
                        <select name="tipo" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Todos los tipos</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t }}" @selected(request('tipo') === $t)>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                        <x-primary-button>Filtrar</x-primary-button>
                    </form>

                    <x-primary-button type="button" x-on:click="crear()">Nuevo registro</x-primary-button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Aplicación</th>
                                <th class="px-4 py-3">Animal</th>
                                <th class="px-4 py-3">Medicamento</th>
                                <th class="px-4 py-3">Próxima</th>
                                <th class="px-4 py-3">Observaciones</th>
                                <th class="px-4 py-3">Registró</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($procedimientos as $p)
                                <tr>
                                    <td class="px-4 py-3">{{ $p->fecha_aplicacion->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $p->animal?->nombre_animal }}</td>
                                    <td class="px-4 py-3">
                                        {{ $p->medicamento?->nombre_medicamento }}
                                        <span class="text-gray-500">({{ $p->medicamento?->tipo_medicamento }})</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $p->fecha_proxima?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $p->observaciones_procedimiento }}</td>
                                    <td class="px-4 py-3">{{ $p->usuario?->name }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <button type="button"
                                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"
                                                x-on:click="editar(@js([
                                                    'id_procedimientos_clinicos' => $p->id_procedimientos_clinicos,
                                                    'fecha_aplicacion' => $p->fecha_aplicacion->format('Y-m-d'),
                                                    'fecha_proxima' => $p->fecha_proxima?->format('Y-m-d'),
                                                    'observaciones_procedimiento' => $p->observaciones_procedimiento,
                                                    'id_animal' => $p->id_animal,
                                                    'id_medicamento' => $p->id_medicamento,
                                                ]))">
                                                Editar
                                            </button>

                                            <form method="POST"
                                                  action="{{ route('control-clinico.procedimientos.destroy', $p) }}"
                                                  onsubmit="return confirm('¿Eliminar este procedimiento?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Eliminar</x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay registros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $procedimientos->links() }}</div>
            </div>
        </div>

        <x-modal name="form-procedimiento" :show="$errors->any()" focusable>
            <form method="POST" :action="action" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_modo" :value="modo">
                <input type="hidden" name="_id" :value="id">
                <template x-if="modo === 'editar'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <h2 class="text-lg font-medium text-gray-900"
                    x-text="modo === 'editar' ? 'Editar procedimiento' : 'Nuevo procedimiento'"></h2>

                <div>
                    <x-input-label for="id_animal" value="Animal" />
                    <select id="id_animal" name="id_animal" x-model="form.id_animal"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($animales as $a)
                            <option value="{{ $a->id_animal }}">{{ $a->nombre_animal }} ({{ $a->especie_animal }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_animal')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="id_medicamento" value="Medicamento, vacuna o vitamina" />
                    <select id="id_medicamento" name="id_medicamento" x-model="form.id_medicamento"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($medicamentos as $med)
                            <option value="{{ $med->id_medicamento }}">
                                {{ $med->nombre_medicamento }} ({{ $med->tipo_medicamento }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_medicamento')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="fecha_aplicacion" value="Fecha de aplicación" />
                        <x-text-input id="fecha_aplicacion" name="fecha_aplicacion" type="date"
                                      class="mt-1 block w-full" x-model="form.fecha_aplicacion" />
                        <x-input-error :messages="$errors->get('fecha_aplicacion')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="fecha_proxima" value="Próxima fecha (opcional)" />
                        <x-text-input id="fecha_proxima" name="fecha_proxima" type="date"
                                      class="mt-1 block w-full" x-model="form.fecha_proxima" />
                        <x-input-error :messages="$errors->get('fecha_proxima')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="observaciones_procedimiento" value="Observaciones (opcional)" />
                    <textarea id="observaciones_procedimiento" name="observaciones_procedimiento" rows="3" maxlength="100"
                              x-model="form.observaciones_procedimiento"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm"></textarea>
                    <x-input-error :messages="$errors->get('observaciones_procedimiento')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-primary-button>Guardar</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        function procedimientoModal(cfg) {
            const vacio = {
                fecha_aplicacion: cfg.hoy, fecha_proxima: '',
                observaciones_procedimiento: '', id_animal: '', id_medicamento: '',
            };
            const limpiar = (o) => Object.fromEntries(Object.entries(o).map(([k, v]) => [k, v ?? '']));

            return {
                modo: cfg.old._modo ?? 'crear',
                id: cfg.old._id ?? null,
                form: cfg.old._modo ? limpiar({ ...vacio, ...cfg.old }) : { ...vacio },

                get action() {
                    return this.modo === 'editar'
                        ? cfg.updateUrl.replace('__ID__', this.id)
                        : cfg.storeUrl;
                },
                crear() {
                    this.modo = 'crear';
                    this.id = null;
                    this.form = { ...vacio };
                    this.$dispatch('open-modal', 'form-procedimiento');
                },
                editar(p) {
                    this.modo = 'editar';
                    this.id = p.id_procedimientos_clinicos;
                    this.form = limpiar({ ...vacio, ...p });
                    this.$dispatch('open-modal', 'form-procedimiento');
                },
            };
        }
    </script>
</x-app-layout>
