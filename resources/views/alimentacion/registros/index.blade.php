<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alimentación — registro de alimentación aplicada
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="registroModal({
             storeUrl: {{ \Illuminate\Support\Js::from(route('alimentacion.registros.store')) }},
             old: {{ \Illuminate\Support\Js::from(old()) }},
         })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('warning'))
                <div class="mb-4 rounded-md bg-amber-100 p-4 text-sm text-amber-800">⚠ {{ session('warning') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-800">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-end mb-6">
                    <x-primary-button type="button" x-on:click="crear()">Registrar alimentación</x-primary-button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Dieta</th>
                                <th class="px-4 py-3">Alimento</th>
                                <th class="px-4 py-3">Cantidad administrada</th>
                                <th class="px-4 py-3">Observaciones</th>
                                <th class="px-4 py-3">Registrado por</th>
                                <th class="px-4 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($registros as $r)
                                <tr>
                                    <td class="px-4 py-3">{{ $r->fecha_registro->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $r->dieta?->nombre_dieta ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $r->dieta?->alimento?->nombre_alimento ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $r->cantidad_administrada }}</td>
                                    <td class="px-4 py-3">{{ $r->observaciones ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $r->usuario?->name ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST"
                                              action="{{ route('alimentacion.registros.destroy', $r->id_registros) }}"
                                              onsubmit="return confirm('¿Eliminar este registro? Se repondrá el stock descontado.')">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>Eliminar</x-danger-button>
                                        </form>
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

                <div class="mt-4">{{ $registros->links() }}</div>
            </div>
        </div>

        {{-- Modal de registro --}}
        <x-modal name="form-registro" :show="$errors->any()" focusable>
            <form method="POST" action="{{ route('alimentacion.registros.store') }}" class="p-6 space-y-4">
                @csrf

                <h2 class="text-lg font-medium text-gray-900">Registrar alimentación</h2>

                <div>
                    <x-input-label for="id_dietas" value="Dieta" />
                    <select id="id_dietas" name="id_dietas" x-model="form.id_dietas"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($dietas as $d)
                            <option value="{{ $d->id_dietas }}">
                                {{ $d->nombre_dieta }} ({{ $d->alimento?->nombre_alimento ?? 'sin alimento' }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_dietas')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_registro" value="Fecha y hora" />
                    <x-text-input id="fecha_registro" name="fecha_registro" type="datetime-local"
                                  class="mt-1 block w-full" x-model="form.fecha_registro" />
                    <x-input-error :messages="$errors->get('fecha_registro')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cantidad_administrada" value="Cantidad administrada" />
                    <x-text-input id="cantidad_administrada" name="cantidad_administrada" type="number" step="0.01" min="0.01"
                                  class="mt-1 block w-full" x-model="form.cantidad_administrada" />
                    <x-input-error :messages="$errors->get('cantidad_administrada')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="observaciones" value="Observaciones (opcional)" />
                    <x-text-input id="observaciones" name="observaciones" type="text"
                                  class="mt-1 block w-full" maxlength="100" x-model="form.observaciones" />
                    <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-primary-button>Guardar</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>

    <script>
        function registroModal(cfg) {
            const vacio = {
                id_dietas: '', fecha_registro: '', cantidad_administrada: '', observaciones: '',
            };
            return {
                form: cfg.old && Object.keys(cfg.old).length ? { ...vacio, ...cfg.old } : { ...vacio },
                crear() {
                    this.form = { ...vacio };
                    this.$dispatch('open-modal', 'form-registro');
                },
            };
        }
    </script>
</x-app-layout>