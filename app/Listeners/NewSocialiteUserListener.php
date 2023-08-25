<?php

namespace App\Listeners;

use App\Events\NewSocialiteUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewSocialiteUserListener
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
    public function handle(NewSocialiteUserEvent $event): void
    {
        if (env('APP_ONLINE')) {
            Mail::send(new NewUserMail(['email' => $user->email, 'name' => $user->name], $password));
            Mail::send(new NewRegistrationMail(['email' => $user->email, 'short_rank' => $user->short_rank, 'name' => $user->name, 'id' => $user->id]));
        } else {
            # code...
        }
        
    }
}
