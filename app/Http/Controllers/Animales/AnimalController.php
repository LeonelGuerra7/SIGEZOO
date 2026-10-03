<?php

namespace App\Http\Controllers\Animales;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Dieta;
use App\Models\Habitat;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $animales = Animal::query()
            ->with(['habitat', 'dieta'])
            ->when($request->filled('buscar'), fn ($q) =>
                $q->where('nombre_animal', 'like', '%' . $request->buscar . '%'))
            ->when($request->filled('estado'), fn ($q) =>
                $q->where('estado_animal', $request->estado))
            ->orderBy('nombre_animal')
            ->paginate(10)
            ->withQueryString();

        return view('animales.index', [
            'animales' => $animales,
            'sexos' => Animal::SEXOS,
            'estados' => Animal::ESTADOS,
            'habitats' => Habitat::orderBy('nombre_area')->get(),
            'dietas' => Dieta::orderBy('nombre_dieta')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Animal::create($this->validar($request));

        return redirect()
            ->route('animales.index')
            ->with('success', 'Animal registrado correctamente.');
    }

    public function update(Request $request, Animal $animal)
    {
        $animal->update($this->validar($request));

        return redirect()
            ->route('animales.index')
            ->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(Animal $animal)
    {
        if ($animal->procedimientosClinicos()->exists()) {
            return redirect()
                ->route('animales.index')
                ->with('error', 'No se puede eliminar "' . $animal->nombre_animal
                    . '" porque tiene procedimientos clínicos asociados.');
        }

        try {
            $animal->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('animales.index')
                ->with('error', 'No se pudo eliminar el registro porque está relacionado con otros datos.');
        }

        return redirect()
            ->route('animales.index')
            ->with('success', 'Animal eliminado correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre_animal'           => ['required', 'string', 'max:50'],
            'especie_animal'          => ['required', 'string', 'max:30'],
            'fecha_nacimiento_animal' => ['required', 'date', 'before_or_equal:today'],
            'sexo_animal'             => ['required', Rule::in(Animal::SEXOS)],
            'estado_animal'           => ['required', Rule::in(Animal::ESTADOS)],
            'id_areas'                => ['nullable', 'exists:areas,id_areas'],
            'id_dietas'               => ['nullable', 'exists:dietas,id_dietas'],
        ]);
    }
}