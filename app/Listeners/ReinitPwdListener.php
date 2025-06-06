<?php

namespace App\Listeners;

use App\Events\ReinitPwdEvent;
use App\Mail\ReinitPwdMail;
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
        if (env('APP_MAILABLE')) {
            /**
             * Pour une version en ligne Intradef utilisé ce paragraphe
             */
            Mail::send(new ReinitPwdMail($event->email, $event->password));
        } 
    }
}
