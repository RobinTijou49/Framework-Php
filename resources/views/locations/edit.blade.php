<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold">Modifier un lieu de tournage</h1>
            <p class="text-gray-600 mt-2">Modifiez les informations du lieu de tournage</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('locations.update', $location) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $location->name) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="Ex: Tour Eiffel"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">Ville *</label>
                    <input
                        type="text"
                        id="city"
                        name="city"
                        value="{{ old('city', $location->city) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('city') border-red-500 @enderror"
                        placeholder="Ex: Paris"
                    >
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">Pays *</label>
                    <input
                        type="text"
                        id="country"
                        name="country"
                        value="{{ old('country', $location->country) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('country') border-red-500 @enderror"
                        placeholder="Ex: France"
                    >
                    @error('country')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="film_id" class="block text-sm font-semibold text-gray-700 mb-2">Film *</label>
                    <select
                        id="film_id"
                        name="film_id"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('film_id') border-red-500 @enderror"
                    >
                        <option value="">Sélectionnez un film</option>
                        @foreach($films as $film)
                            <option value="{{ $film->id }}" {{ old('film_id', $location->film_id) == $film->id ? 'selected' : '' }}>
                                {{ $film->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('film_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                        placeholder="Décrivez ce lieu de tournage..."
                    >{{ old('description', $location->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200"
                    >
                        Mettre à jour le lieu
                    </button>
                    <a
                        href="{{ route('locations.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-200"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
