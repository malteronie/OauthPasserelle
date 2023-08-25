<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactMailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array<string> */
    public array $mail;

    /**
     * Create a new event instance.
     *
     * @param  array<string>  $mail
     */
    public function __construct(array $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
