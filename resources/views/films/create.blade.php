<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un film</title>
</head>
<body>
    <h1>Ajouter un nouveau film</h1>
    <form action="{{ route('films.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="release_date">Date de sortie :</label>
            <input type="date" id="release_date" name="release_date" required>
        </div>
        <div>
            <label for="synopsis">Synopsis :</label>
            <textarea id="synopsis" name="synopsis" required></textarea>
        </div>
        <button type="submit">Ajouter le film</button>
    </form>
</body>
</html>
