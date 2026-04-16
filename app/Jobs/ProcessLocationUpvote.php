<?php

namespace App\Jobs;

use App\Models\Location;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLocationUpvote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Location $location, private User $user)
    {
    }

    public function handle()
    {
        // Ajouter le vote
        $this->user->upvotedLocations()->attach($this->location->id);
        $this->location->increment('upvotes_count');
    }
}
