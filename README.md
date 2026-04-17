## Laraavel Pint

```
vendor/bin/pint
```

## faire fonctionner la tache planifiée
php artisan tinker et on crée une ligne 
DB::table('location')
    ->where('id', 1)
    ->update([
        'created_at' => DB::raw("'2025-04-01 10:30:00'"),
        'updated_at' => DB::raw("'2025-04-01 10:30:00'"),
    ]);

Changer l'id en prenant un qui existe dans la table location

## lancer la tache manuellement
php artisan location:delete-old


## lancer la tache planifiée automatiquement
php artison schedule:work


## Installer Laravel Pint 
```
composer require laravel/pint --dev
```


# 📘 MCP Laravel - Film API

# 🧩 Tools disponibles

## 1. mcp/tools

### 📌 Description
Retourne la liste de tous les tools disponibles dans le MCP.

### 🌐 Endpoint
GET `/api/mcp/tools`


### 📤 Réponse

```json
{
  "tools": [
    {
      "name": "list_films",
      "description": "Retourne la liste des films",
      "parameters": []
    },
    {
      "name": "get_locations_for_film",
      "description": "Retourne les lieux d'un film",
      "parameters": {
        "id": "integer"
      }
    }
  ]
}
```
## 1. mcp/run

### 📌 Description
Retourne les résultats d’un tool donné avec les paramètres fournis. Par exemple, pour le tool `get_locations_for_film` avec `film_id` égal à 1, la requête serait :


### 🌐 Endpoint
POST `/api/mcp/run`
Body:
```json
{
  "tool": "get_locations_for_film",
  "parameters": {
    "film_id": 19
  }
}
```

### 📤 Réponse

```json
{
"tool": "get_locations_for_film",
    "data": [
        {
            "id": 68,
            "film_id": 19,
            "user_id": 2,
            "name": "quidem",
            "city": "Bernieceville",
            "country": "Haiti",
            "description": "Et et nesciunt maxime omnis. Hic molestiae vel molestias quia atque fugiat voluptatem non. Quia repellendus nostrum nulla enim sunt.",
            "upvotes_count": 0,
            "created_at": "2026-04-16T08:25:52.000000Z",
            "updated_at": "2026-04-16T08:25:52.000000Z"
        },
    ]
}
```
