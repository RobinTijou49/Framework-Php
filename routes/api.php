<?php

use App\Http\Controllers\Api\FilmApiController;
use App\Http\Controllers\MCPController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['web', 'auth', 'subscribed'])->group(function () {
    Route::get('/filmsapi', [FilmApiController::class, 'index'])->name('api.films.index');
});

// Routes MCP
Route::prefix('mcp')->group(function () {
    Route::get('/tools', function () {
        return response()->json([
            "tools" => [
                [
                    "name" => "list_films",
                    "description" => "Retourne la liste des films",
                    "parameters" => []
                ],
                [
                    "name" => "get_locations_for_film",
                    "description" => "Retourne les lieux d'un film",
                    "parameters" => [
                        "id" => "integer"
                    ]
                ]
            ]
        ]);
    });
    Route::post('/run', [MCPController::class, 'run']);
});
