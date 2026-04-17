<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Location;
use Illuminate\Http\Request;

class MCPController extends Controller
{
    public function listFilms()
    {
        return response()->json([
            "tool" => "list_films",
            "data" => Film::all()
        ]);
    }

    public function getLocationsForFilm($id)
    {
        return response()->json([
            "tool" => "get_locations_for_film",
            "film_id" => $id,
            "data" => Location::where("film_id", $id)->get()
        ]);
    }
}
