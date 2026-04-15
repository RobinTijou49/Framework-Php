<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

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

        Film::create($validated);

        return redirect()->route('films.index')->with('success', 'Film créé avec succès.');
    }
}
