<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une location</title>
</head>
<body>
    <h1>Ajouter un nouvelle location</h1>
    <form action="{{ route('locations.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div>
            <label for="country">Pays :</label>
            <input type="text" id="country" name="country" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="film_id">Film :</label>
            <select id="film_id" name="film_id" required>
                @foreach($films as $film)
                    <option value="{{ $film->id }}">{{ $film->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Ajouter la location</button>
</body>
</html>
