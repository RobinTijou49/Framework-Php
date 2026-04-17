<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;

class FilmApiController extends Controller
{
    public function index()
    {
        $films = Film::with('locations')->get()->sortByDesc('release_date');
        return response()->json($films);
    }
}
