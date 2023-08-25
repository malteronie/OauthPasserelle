<?php

namespace App\Listeners;

use App\Events\ActiveUserEvent;
use App\Mail\ActiveUserMail;
use Illuminate\Support\Facades\Mail;

class ActiveUserListener
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
    public function handle(ActiveUserEvent $event): void
    {
        Mail::send(new ActiveUserMail($event->user));
    }
}
