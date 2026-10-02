<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Medicamentos, vacunas y vitaminas
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="medicamentoModal({
             storeUrl: @js(route('control-clinico.medicamentos.store')),
             updateUrl: @js(route('control-clinico.medicamentos.update', '__ID__')),
             old: @js(old()),
         })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Mensajes flash (si tu layout aún no los tiene, se ven solo aquí en esta página) --}}
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

                    <x-primary-button type="button" x-on:click="crear()">Nuevo registro</x-primary-button>
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
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($medicamentos as $m)
                                <tr>
                                    <td class="px-4 py-3">{{ $m->nombre_medicamento }}</td>
                                    <td class="px-4 py-3">{{ ucfirst($m->tipo_medicamento) }}</td>
                                    <td class="px-4 py-3 {{ $m->stock_medicamento <= $m->stock_minimo_medicamento ? 'text-red-600 font-semibold' : '' }}">
                                        {{ $m->stock_medicamento }}
                                    </td>
                                    <td class="px-4 py-3">{{ $m->stock_minimo_medicamento }}</td>
                                    <td class="px-4 py-3">{{ $m->unidad_medida_medicamento }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <x-secondary-button type="button"
                                                x-on:click="editar(@js($m->only([
                                                    'id_medicamento', 'nombre_medicamento', 'tipo_medicamento',
                                                    'stock_medicamento', 'stock_minimo_medicamento',
                                                    'unidad_medida_medicamento', 'id_proveedores',
                                                ])))">
                                                Editar
                                            </x-secondary-button>

                                            <form method="POST"
                                                  action="{{ route('control-clinico.medicamentos.destroy', $m) }}"
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

                <div class="mt-4">{{ $medicamentos->links() }}</div>
            </div>
        </div>

        {{-- Modal compartido para crear y editar --}}
        <x-modal name="form-medicamento" :show="$errors->any()" focusable>
            <form method="POST" :action="action" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_modo" :value="modo">
                <input type="hidden" name="_id" :value="id">
                <template x-if="modo === 'editar'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <h2 class="text-lg font-medium text-gray-900"
                    x-text="modo === 'editar' ? 'Editar registro' : 'Nuevo registro'"></h2>

                <div>
                    <x-input-label for="nombre_medicamento" value="Nombre" />
                    <x-text-input id="nombre_medicamento" name="nombre_medicamento" type="text"
                                  class="mt-1 block w-full" maxlength="50" x-model="form.nombre_medicamento" />
                    <x-input-error :messages="$errors->get('nombre_medicamento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tipo_medicamento" value="Tipo" />
                    <select id="tipo_medicamento" name="tipo_medicamento" x-model="form.tipo_medicamento"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($tipos as $t)
                            <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipo_medicamento')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="stock_medicamento" value="Stock" />
                        <x-text-input id="stock_medicamento" name="stock_medicamento" type="number" min="0"
                                      class="mt-1 block w-full" x-model="form.stock_medicamento" />
                        <x-input-error :messages="$errors->get('stock_medicamento')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="stock_minimo_medicamento" value="Stock mínimo" />
                        <x-text-input id="stock_minimo_medicamento" name="stock_minimo_medicamento" type="number" min="0"
                                      class="mt-1 block w-full" x-model="form.stock_minimo_medicamento" />
                        <x-input-error :messages="$errors->get('stock_minimo_medicamento')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="unidad_medida_medicamento" value="Unidad de medida" />
                    <x-text-input id="unidad_medida_medicamento" name="unidad_medida_medicamento" type="text"
                                  class="mt-1 block w-full" maxlength="18" x-model="form.unidad_medida_medicamento" />
                    <x-input-error :messages="$errors->get('unidad_medida_medicamento')" class="mt-2" />
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
        function medicamentoModal(cfg) {
            const vacio = {
                nombre_medicamento: '', tipo_medicamento: '', stock_medicamento: '',
                stock_minimo_medicamento: '', unidad_medida_medicamento: '', id_proveedores: '',
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
                    this.$dispatch('open-modal', 'form-medicamento');
                },
                editar(m) {
                    this.modo = 'editar';
                    this.id = m.id_medicamento;
                    this.form = { ...vacio, ...m, id_proveedores: m.id_proveedores ?? '' };
                    this.$dispatch('open-modal', 'form-medicamento');
                },
            };
        }
    </script>
</x-app-layout>
