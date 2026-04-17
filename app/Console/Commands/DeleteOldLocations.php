<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;

class DeleteOldLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locations:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprimer les locations créées depuis 14+ jours avec < 2 upvotes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = Location::where('created_at', '<', now()->subDays(14))
            ->where('upvotes_count', '<', 2)
            ->delete();
        $this->info("$deleted locations supprimées.");
    }
}
