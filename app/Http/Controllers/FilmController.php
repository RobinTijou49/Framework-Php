<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::with('locations')->get()->sortByDesc('release_date');

        return view('films.index', compact('films'));
    }

    public function create()
    {
        return view('films.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'synopsis' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        Film::create($validated);

        return redirect()->route('films.index')->with('success', 'Film créé avec succès.');
    }

    public function delete(Film $film)
    {
        if (auth()->id() !== $film->user_id && ! auth()->user()->is_admin) {
            return redirect()->route('films.index')->with('error', 'Non autorisé.');
        }

        $film->delete();

        return redirect()->route('films.index')->with('success', 'Film supprimé avec succès.');
    }

    public function update(Request $request, Film $film)
    {
        if (auth()->id() !== $film->user_id && ! auth()->user()->is_admin) {
            return redirect()->route('films.index')->with('error', 'Non autorisé.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'synopsis' => 'nullable|string',
        ]);

        $film->update($validated);

        return redirect()->route('films.index')->with('success', 'Film mis à jour avec succès.');
    }

    public function updateForm(Film $film)
    {
        if (auth()->id() !== $film->user_id && ! auth()->user()->is_admin) {
            return redirect()->route('films.index')->with('error', 'Non autorisé.');
        }

        return view('films.edit', compact('film'));
    }

    public function show(Film $film)
    {
        return view('films.show', compact('film'));
    }
}
