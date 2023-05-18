<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class FollowNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $followUser =   User::where('id', $event->follow->user_id)->first();
        $notifyUser =   User::where('id', $event->follow->followed_user_id)->first();

        Notification::send($notifyUser, new NewFollowerNotification($followUser, 'follow'));
    }
}
