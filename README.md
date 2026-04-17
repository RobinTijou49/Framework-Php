## Etape 1 Authentification
Installation de Laravel Breeze

```
composer require laravel/breeze --dev
php artisan breeze:install
```

Laravel Breeze contient toute la partie login et register, et gère aussi la base de données pour les utilisateurs.

## Etape 2 CRUD métier

### Films

| Méthode | Route                  | Description                                      |
|--------|------------------------|--------------------------------------------------|
| GET    | /films                 | Affiche la liste des films                      |
| GET    | /films/create          | Affiche le formulaire de création d'un film     |
| POST   | /films                 | Traite le formulaire de création d'un film      |
| GET    | /films/{id}            | Affiche les détails d'un film                   |
| GET    | /films/{id}/edit       | Affiche le formulaire de modification d'un film |
| PUT    | /films/{id}            | Traite le formulaire de modification d'un film  |
| DELETE | /films/{id}            | Supprime un film                                |

---

### Locations

| Méthode | Route                     | Description                                           |
|--------|---------------------------|-------------------------------------------------------|
| GET    | /locations                | Affiche la liste des locations                        |
| GET    | /locations/create         | Affiche le formulaire de création d'une location      |
| POST   | /locations                | Traite le formulaire de création d'une location       |
| GET    | /locations/{id}           | Affiche les détails d'une location                    |
| GET    | /locations/{id}/edit      | Affiche le formulaire de modification d'une location  |
| PUT    | /locations/{id}           | Traite le formulaire de modification d'une location   |
| DELETE | /locations/{id}           | Supprime une location                                 |

 On retrouve toutes les routes dans le fichier `web.php` et les fonctions correspondantes dans les controllers `FilmController` et `LocationController`

## Etape 3 Middleware Administrateur

J'ai créé un middleware `IsAdmin` qui vérifie si l'utilisateur connecté est un administreur.
Pour cela, j'ai ajouté une colonne `is_admin` dans la table `users` qui est un boolean. Si cette colonne est à true, l'utilisateur est un administrateur.
Etre administrateur permet d'accéder à la page admin dashboard qui s'affiche que pour les admins.
Il a aussi accès à la suppression et modification de film et location qui n'ont pas été créer par lui alors que les utilisateurs normaux ne peuvent supprimer ou modifier que les films et locations qu'ils ont créés.


## Etape 4 Queus et Jobs

J'ai créé une job dans le fichier `ProcessLocationUpvote.php` qui gère les upvotes des locations. 
Lorsqu'un utilisateur upvote une location, la job s'active et s'occupe d'incrémenter le nombre d'upvotes de la location dans la base de données.

Ensuite, dans mon LocationController j'ai ma fonction de upvote et il faut que j'apelle mon job pour la mettre dans la queue:

```
ProcessLocationUpvote::dispatch($location, auth()->user());
```
Commande pour lancer le worker de queue
```
php artisan queue:work
```

## Etape 5 Commande artisan + Taches planifiées
J'ai créer une commande artisan `DeleteOldLocations` qui supprime les locations qui ont été créées il y a plus de 14 jours et qui on moins de 2 upvotes
.
Pour tester la tache de suppression des anciennes locations, on peut créer un location de test
`php artisan tinker`et on crée une ligne 
```
DB::table('location')
    ->where('id', 1)
    ->update([
        'created_at' => DB::raw("'2025-04-01 10:30:00'"),
        'updated_at' => DB::raw("'2025-04-01 10:30:00'"),
    ]);

```

Changer l'id en prenant un qui existe dans la table location

## lancer la tache manuellement
```
php artisan location:delete-old
```

## lancer la tache planifiée automatiquement
```
php artison schedule:work
```

## Etape 6 Laravel Pint
Installation de Laravel Pint
```
composer require laravel/pint --dev
```
Lancement de Laravel Pint
```
vendor/bin/pint
```

## Etape 7 Connexion via réseaux sociaux
J'ai installé Laravel Socialite pour permettre la connexion via GitHub
```
composer require laravel/socialite
```
Ensuite, j'ai ajouté les routes pour la redirection vers GitHub et le callback dans le fichier `web.php`.
J'ai configuré les clés d'API GitHub dans le fichier `.env` que j'ai généré en créant une app dans mon github et j'ai pu créer mon `clientId` et `clientSecret`.

Ensuite, j'ai juste ajouter dans mon formulaire de connexion un bouton qui renvoie vers la route de redirection vers GitHub.

## Etape 8 Abonnement Stripe + route API JSON

### Abonnement Stripe
J'ai installé Laravel Cashier pour gérer les abonnements Stripe
```
composer require laravel/cashier
```
Ensuite, j'ai configuré les clés d'API Stripe dans le fichier `.env` que j'ai généré en créant une app dans mon dashboard Stripe et j'ai pu créer mon `STRIPE_KEY` et `STRIPE_SECRET`.

J'ai créé une route pour afficher la page d'abonnement et une route pour gérer le paiement dans le fichier `web.php`. J'ai aussi créé un controller `StripeController` qui gère l'affichage de la page d'abonnement avec le bon produit et le paiement.

J'ai pu tester de faire des vrai paiements en utilisant les cartes de test Stripe.

Ensuite j'ai ajouter un middleware `Subscribed` qui vérifie si l'utilisateur a un abonnement actif pour lui permettre d'accéder à la page Premium Content.

### Route API JSON
J'ai créé une route API (`/api/filmsapi`) qui retourne la liste des films avec leurs location au format JSON. Cette route est accessible que pour les utilisateurs connectés et ayant payer un abonnement.

La route est définie dans le fichier `api.php` pour que l'url d'accès soit api/ma-route.

Pour accéder à la route, l'utilisateur doit avoir un token JWT valide. Pour cela, j'ai utilisé Laravel Sanctum qui gère l'authentification par token.

Donc j'ai ajouter dans ma route API le middleware `auth:sanctum` pour protéger la route et n'autoriser que les utilisateurs authentifiés à y accéder en plus qu'il faut qu'ils ai un abonnement.

```
Route::middleware(['web', 'auth', 'subscribed'])->group(function () {
    Route::get('/filmsapi', [FilmApiController::class, 'index'])->name('api.films.index');
});
```

# Etape 9 MCP

J'ai créé un MCP  qui permet d'exposer des endpoints pour que les modèles puissent être utilisés par une IA. J'ai créé deux endpoints :

# Tools disponibles

## 1. mcp/tools

### Endpoint

GET `/api/mcp/tools`


### Réponse

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

### Endpoint
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

### Réponse

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
