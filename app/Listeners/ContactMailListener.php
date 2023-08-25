<?php

namespace App\Listeners;

use App\Events\ContactMailEvent;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactMailListener
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
    public function handle(ContactMailEvent $event): void
    {
        Mail::send(new ContactMail($event->mail));
    }
}
