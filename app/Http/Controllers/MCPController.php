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

    public function run(Request $request)
    {
        $tool = $request->input('tool');
        $args = $request->input('arguments', []);

        switch ($tool) {

            case 'list_films':
                return response()->json([
                    "tool" => $tool,
                    "data" => Film::all()
                ]);

            case 'get_locations_for_film':
                return response()->json([
                    "tool" => $tool,
                    "data" => Location::where('film_id', $args['id'])->get()
                ]);

            default:
                return response()->json([
                    "error" => "Tool not found"
                ], 404);
        }
    }
}
