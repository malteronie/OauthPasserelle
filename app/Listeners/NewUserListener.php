<?php

namespace App\Listeners;

use App\Mail\NewUserMail;
use App\Events\NewUserEvent;
use Illuminate\Support\Facades\Mail;

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
        if (env('APP_ONLINE')) {
            /**
             * Pour une version en ligne Intradef utilisé ce paragraphe
             */
            Mail::send(new NewUserMail($event->user, $event->password));
        } else {
            /**
             * Pour une version hors ligne utiliser ce paragraphe
             */
            dd('Réinitialisation du mot de passe par '.$event->password.' envoyé à '.$event->user['email']);
        }
        
        

        
    }
}
