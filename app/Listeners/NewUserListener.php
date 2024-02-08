<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use App\Mail\NewUserMail;
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
        if (env('APP_MAILABLE')) {
            /**
             * Pour une version en ligne Intradef utilisé ce paragraphe
             */
            Mail::send(new NewUserMail($event->user, $event->password));
        }
    }
}
