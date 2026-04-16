<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $location->name }}</h1>
                    <p class="text-gray-600">{{ $location->city }}, {{ $location->country }}</p>
                </div>
                @if(auth()->id() === $location->user_id || auth()->user()->is_admin)
                <div class="flex gap-2">
                    <a href="{{ route('locations.edit', $location) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Modifier
                    </a>
                    <form action="{{ route('locations.delete', $location) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" style="display: inline;">
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

        <!-- Location Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">Détails du lieu</h2>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Ville</h3>
                            <p class="text-lg text-gray-800">{{ $location->city }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Pays</h3>
                            <p class="text-lg text-gray-800">{{ $location->country }}</p>
                        </div>
                    </div>

                    @if($location->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $location->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info Box -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Film associé</h3>
                    @if($location->film)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                        <p class="text-sm text-gray-600 mb-2">Tournage pour</p>
                        <p class="font-bold text-gray-800 mb-3">{{ $location->film->title }}</p>
                        <a href="{{ route('films.show', $location->film) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Voir le film →
                        </a>
                    </div>
                    @else
                    <p class="text-gray-500 italic text-sm">Aucun film associé</p>
                    @endif
                </div>

                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Crédits</h3>
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Créé par</p>
                        <p class="font-semibold text-gray-800">{{ $location->user->name ?? 'Utilisateur supprimé' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Date de création</p>
                        <p class="text-sm text-gray-700">{{ $location->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section (optional - you can add a map here later) -->
        <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center mb-8">
            <div class="text-center">
                <p class="text-gray-500 font-semibold mb-2">Localisation</p>
                <p class="text-gray-600 text-sm">{{ $location->city }}, {{ $location->country }}</p>
                <p class="text-gray-500 text-xs mt-2">(Intégration de carte disponible)</p>
            </div>
        </div>

        <!-- Related Locations Section -->
        @php
            $relatedLocations = $location->film->locations->where('id', '!=', $location->id)->take(3);
        @endphp

        @if($relatedLocations->count() > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-6">Autres lieux de tournage pour {{ $location->film->title }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($relatedLocations as $relatedLocation)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                    <p class="font-bold text-gray-800 mb-2">{{ $relatedLocation->name }}</p>
                    <p class="text-sm text-gray-600 mb-3">{{ $relatedLocation->city }}, {{ $relatedLocation->country }}</p>
                    <a href="{{ route('locations.show', $relatedLocation) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Voir ce lieu →
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('locations.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                ← Retour à la liste des lieux
            </a>
        </div>
    </div>
</x-app-layout>
