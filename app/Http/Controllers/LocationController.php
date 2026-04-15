<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Film;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with(['film', 'user'])->get()->sortByDesc('created_at');
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        $films = Film::all();
        return view('locations.create', compact('films'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'film_id' => 'required|exists:films,id',
        ]);

        $validated['user_id'] = auth()->id();
        Location::create($validated);

        return redirect()->route('locations.index')->with('success', 'Lieu créé avec succès.');
    }
}
