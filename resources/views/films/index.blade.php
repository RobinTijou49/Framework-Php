<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">Films</h1>
            <a href="{{ route('films.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                + Ajouter
            </a>
        </div>

        @if($films->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Aucun film trouvé</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Titre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Sortie</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Synopsis</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Lieux</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Voir</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Supprimer</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold">Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($films as $film)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold">{{ $film->title }}</td>
                                <td class="px-6 py-4 text-sm">{{ $film->release_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $film->synopsis }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $film->locations->count() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('films.show', $film) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">
                                            Voir
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        <form action="{{ route('films.delete', $film) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?');">
                                            @csrf
                                            @method('DELETE')
                                            @if(auth()->check() && (auth()->id() === $film->user_id || auth()->user()->is_admin))
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
                                        @if(auth()->check() && (auth()->id() === $film->user_id || auth()->user()->is_admin))
                                            <a href="{{ route('films.edit', $film) }}" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                Modifier
                                            </a>
                                        @else
                                            <button type="button" disabled class="bg-gray-300 text-gray-500 text-xs font-bold py-1 px-3 rounded cursor-not-allowed">
                                                Modifier
                                            </button>
                                        @endif
                                    </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
