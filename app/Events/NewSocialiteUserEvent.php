<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewSocialiteUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array<string> */
    public array $user;

    public string $password;

    /**
     * Create a new event instance.
     * 
     * @param  array<string>  $user, string $password
     */
    public function __construct(array $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
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
