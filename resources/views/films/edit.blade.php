<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold">Modifier un film</h1>
            <p class="text-gray-600 mt-2">Modifiez les informations du film</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('films.update', $film) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $film->title) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                        placeholder="Ex: Le Seigneur des Anneaux"
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="release_date" class="block text-sm font-semibold text-gray-700 mb-2">Date de sortie *</label>
                    <input
                        type="date"
                        id="release_date"
                        name="release_date"
                        value="{{ old('release_date', $film->release_date) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('release_date') border-red-500 @enderror"
                    >
                    @error('release_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="synopsis" class="block text-sm font-semibold text-gray-700 mb-2">Synopsis</label>
                    <textarea
                        id="synopsis"
                        name="synopsis"
                        rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('synopsis') border-red-500 @enderror"
                        placeholder="Décrivez le contenu du film..."
                    >{{ old('synopsis', $film->synopsis) }}</textarea>
                    @error('synopsis')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200"
                    >
                        Mettre à jour le film
                    </button>
                    <a
                        href="{{ route('films.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
