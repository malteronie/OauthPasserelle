<?php

namespace App\Listeners;

use App\Events\NewSocialiteUserEvent;
use App\Mail\NewRegistrationMail;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\Mail;

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
        if (env('APP_MAILABLE')) {
            Mail::send(new NewUserMail($event->user, $event->password));
            Mail::send(new NewRegistrationMail($event->user));
        }

    }
}
