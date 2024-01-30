<?php

namespace App\Listeners;

use App\Events\DeleteUserEvent;
use App\Mail\DestroyUserMail;
use Illuminate\Support\Facades\Mail;

class DeleteUserListener
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
    public function handle(DeleteUserEvent $event): void
    {
        if (env('APP_ONLINE'))
        {
            Mail::send(new DestroyUserMail($event->user, $event->content['content']));
        }
    }
}
