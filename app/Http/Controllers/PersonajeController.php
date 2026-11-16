<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportarPersonajeRequest;
use App\Http\Requests\PersonajeRequest;
use App\Models\Personaje;
use App\Services\PersonajeService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class PersonajeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Personajes/Index', [
            'personajes' => Personaje::latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Personajes/Create');
    }

    public function store(PersonajeRequest $request): RedirectResponse
    {
        Personaje::create($request->validated());

        return redirect('/personajes')->with('success', 'Personaje creado correctamente.');
    }

    public function edit(string $id): Response
    {
        return Inertia::render('Personajes/Edit', [
            'personaje' => Personaje::findOrFail($id),
        ]);
    }

    public function update(PersonajeRequest $request, string $id): RedirectResponse
    {
        $personaje = Personaje::findOrFail($id);
        $personaje->update($request->validated());

        return redirect('/personajes')->with('success', 'Personaje actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $personaje = Personaje::findOrFail($id);
        $personaje->delete();

        return redirect('/personajes')->with('success', 'Personaje eliminado correctamente.');
    }

    public function importar(ImportarPersonajeRequest $request, PersonajeService $personajeService): RedirectResponse
    {
        try {
            $personajeService->importarDesdeSwapi($request->validated()['swapi_id']);
        } catch (RuntimeException $e) {
            return back()->withErrors(['swapi_id' => $e->getMessage()]);
        }

        return redirect('/personajes')->with('success', 'Personaje importado correctamente');
    }
}
