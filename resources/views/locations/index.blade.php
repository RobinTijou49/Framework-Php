<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">Location</h1>
            <a href="{{ route('locations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                + Ajouter
            </a>
        </div>
        @if($locations->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Aucun lieu de tournage trouvé</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Localisation</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Film</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Créé par</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Votes</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Voir</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Supprimer</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold">{{ $location->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $location->city }}, {{ $location->country }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('films.index', $location->film) }}" class="text-blue-500 hover:underline">
                                        {{ $location->film->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $location->user->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        ⭐ {{ $location->upvotes_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('locations.show', $location) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">
                                            Voir
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        <form action="{{ route('locations.delete', $location) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lieu de tournage ?');">
                                            @csrf
                                            @method('DELETE')
                                            @if(auth()->check() && (auth()->id() === $location->user_id || auth()->user()->is_admin))
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                    Supprimer
                                                </button>
                                            @else
                                                <button type="button" disabled class="bg-gray-300 text-gray-500 text-xs font-bold py-1 px-3 rounded cursor-not-allowed">
                                                    Supprimer
                                                </button>
                                            @endif
                                        </form>
                                    <div>
                                </td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        @if(auth()->check() && (auth()->id() === $location->user_id || auth()->user()->is_admin))
                                            <a href="{{ route('locations.edit', $location) }}" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                Modifier
                                            </a>
                                        @else
                                            <button type="button" disabled class="bg-gray-300 text-gray-500 text-xs font-bold py-1 px-3 rounded cursor-not-allowed">
                                                Modifier
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
