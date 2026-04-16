<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $film->title }}</h1>
                    <p class="text-gray-600">Film créé le {{ $film->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if(auth()->id() === $film->user_id || auth()->user()->is_admin)
                <div class="flex gap-2">
                    <a href="{{ route('films.edit', $film) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Modifier
                    </a>
                    <form action="{{ route('films.delete', $film) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Supprimer
                        </button>
                    </form>
                </div>
                @endif
                </div>
            </div>
        </div>

        <!-- Film Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">Détails du film</h2>

                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Date de sortie</h3>
                        <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($film->release_date)->format('d F Y') }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Synopsis</h3>
                        <p class="text-gray-700 leading-relaxed">
                            @if($film->synopsis)
                                {{ $film->synopsis }}
                            @else
                                <span class="italic text-gray-500">Aucun synopsis disponible</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900">Statistiques</h2>

                    <div class="bg-white rounded-lg p-4 mb-4">
                        <p class="text-gray-600 text-sm font-semibold mb-1">Lieux de tournage</p>
                        <p class="text-4xl font-bold text-blue-600">{{ $film->locations->count() }}</p>
                    </div>

                    <div class="text-sm text-blue-800">
                        <p>
                            @if($film->locations->count() > 0)
                                {{ $film->locations->count() }}
                                {{ $film->locations->count() === 1 ? 'lieu de tournage' : 'lieux de tournage' }}
                                enregistré{{ $film->locations->count() === 1 ? '' : 's' }}
                            @else
                                Aucun lieu de tournage enregistré
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Locations Section -->
        @if($film->locations->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Lieux de tournage</h2>
                <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                    {{ $film->locations->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Ville</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pays</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($film->locations as $location)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold">{{ $location->name }}</td>
                                <td class="px-6 py-4">{{ $location->city }}</td>
                                <td class="px-6 py-4">{{ $location->country }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('locations.show', $location) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-8 text-center">
            <p class="text-gray-500 text-lg mb-4">Aucun lieu de tournage enregistré pour ce film</p>
            <a href="{{ route('locations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded inline-block">
                + Ajouter un lieu
            </a>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('films.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                ← Retour à la liste des films
            </a>
        </div>
    </div>
</x-app-layout>
