<?php

namespace App\Listeners;

use App\Mail\ReinitPwdMail;
use App\Events\ReinitPwdEvent;
use Illuminate\Support\Facades\Mail;

class ReinitPwdListener
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
    public function handle(ReinitPwdEvent $event): void
    {
        if (env('APP_ONLINE')) {
            /**
             * Pour une version en ligne Intradef utilisé ce paragraphe
             */
            Mail::send(new ReinitPwdMail($event->email, $event->password));
        } else {
            /**
             * Pour une version hors ligne utiliser ce paragraphe
             */
            dd('Réinitialisation du mot de passe par '.$event->password.' envoyé à '.$event->email);
        }
        
        

        
    }
}
