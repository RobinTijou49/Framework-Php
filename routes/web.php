<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\MCPController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Models\Location;

Route::get('/', function () {
    return view('welcome');
});

// Routes connexion OAuth
Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->stateless()->user();

    $user = User::updateOrCreate(
        ['github_id' => $githubUser->id],
        [
            'name' => $githubUser->name ?? $githubUser->nickname,
            'email' => $githubUser->email ?? $githubUser->id.'@github.local',
            'password' => bcrypt(Str::random(16)),
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
});

// Routes protégées par auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Films routes
    Route::get('/films', [FilmController::class, 'index'])->name('films.index');
    Route::get('/films/create', [FilmController::class, 'create'])->name('films.create');
    Route::post('/films', [FilmController::class, 'store'])->name('films.store');
    Route::delete('/films/{film}', [FilmController::class, 'delete'])->name('films.delete');
    Route::put('/films/{film}', [FilmController::class, 'update'])->name('films.update');
    Route::get('/films/{film}/edit', [FilmController::class, 'updateForm'])->name('films.edit');
    Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');
    Route::get('/films/{id}/locations', function ($id) {
        return Location::where('film_id', $id)->get();
    });

    // Locations routes
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::delete('/locations/{location}', [LocationController::class, 'delete'])->name('locations.delete');
    Route::get('/locations/{location}/edit', [LocationController::class, 'updateForm'])->name('locations.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');
    Route::post('/locations/{location}/upvote', [LocationController::class, 'upvote'])->name('locations.upvote');

    //MCP routes
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');

    // Stripe routes
    Route::post('/subscribe', [StripeController::class, 'subscribe']);
    Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');

    Route::get('/success', function () {
        return 'Paiement réussi 🎉';
    })->name('success');

    Route::get('/cancel', function () {
        return 'Paiement annulé ❌';
    })->name('cancel');

    // Route Premium
    Route::get('/premium-content', function () {
        return view('premium.index');
    })->middleware('subscribed')->name('premium.content');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

});

require __DIR__.'/auth.php';
