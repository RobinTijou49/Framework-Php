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

    public function delete(Location $location)
    {
        if (auth()->id() !== $location->user_id && !auth()->user()->is_admin) {
            return redirect()->route('locations.index')->with('error', 'Non autorisé.');
        }

        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Lieu supprimé avec succès.');
    }

    public function update(Request $request, Location $location)
    {
        if (auth()->id() !== $location->user_id && !auth()->user()->is_admin) {
            return redirect()->route('locations.index')->with('error', 'Non autorisé.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'film_id' => 'required|exists:films,id',
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')->with('success', 'Lieu mis à jour avec succès.');
    }

    public function updateForm(Location $location)
    {
        if (auth()->id() !== $location->user_id && !auth()->user()->is_admin) {
            return redirect()->route('locations.index')->with('error', 'Non autorisé.');
        }

        $films = Film::all();
        return view('locations.edit', compact('location', 'films'));
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function upvote(Location $location)
    {
        if(auth()->user()->upvotedLocations()->where('location_id', $location->id)->exists()) {
            return redirect()->route('locations.show', $location)->with('error', 'Vous avez déjà upvoté ce lieu.');
        }

        auth()->user()->upvotedLocations()->attach($location->id);
        $location->increment('upvotes_count');

        return redirect()->route('locations.show', $location)->with('success', 'Lieu upvoté avec succès.');
    }
}
