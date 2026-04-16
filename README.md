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
