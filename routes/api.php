<?php

use App\Http\Controllers\Api\FilmApiController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['web', 'auth', 'subscribed'])->group(function () {
    Route::get('/filmsapi', [FilmApiController::class, 'index'])->name('api.films.index');
});

// Routes MCP

Route::post('/chat', [ChatController::class, 'chat']);
