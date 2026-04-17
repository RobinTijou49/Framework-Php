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


# ⚙️ Architecture

Le système repose sur :

- Laravel (API JSON)
- Base de données (films + locations)
- Un contrôleur MCP dédié
- Des routes API exposant des “tools”

---

# 🧩 Tools disponibles

## 1. list_films

### 📌 Description
Retourne la liste de tous les films disponibles dans la base de données.

### 🌐 Endpoint
GET `/mcp/list_films`


### 📤 Réponse

```json
{
  "tool": "list_films",
  "data": [
    {
      "id": 1,
      "title": "Inception",
      "created_at": "...",
      "updated_at": "..."
    }
  ]
}
```
## 1. get_locations_for_film

### 📌 Description
Retourne les lieux de tournage associés à un film spécifique.
### 🌐 Endpoint
GET `/mcp/get_locations_for_film/{id}`


### 📤 Réponse

```json
{
  "tool": "get_locations_for_film",
  "film_id": 1,
  "data": [
    {
      "id": 5,
      "film_id": 1,
      "location": "Paris"
    }
  ]
}```
