<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewUserListener
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
    public function handle(NewUserEvent $event): void
    {
        /**
         * Pour une version en ligne Intradef utilisé ce paragraphe
         */
        //Mail::send(new NewUserMail($request->validated(), $password));

        /**
         * Pour une version hors ligne utiliser ce paragraphe
         */
        dd('Réinitialisation du mot de passe par ' . $event->password . ' envoyé à ' . $event->user['email']);
    }
}
