<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array<string> */
    public array $user;

    /** @var array<string> */
    public array $content;

    /**
     * Create a new event instance.
     *
     * @param  array<string>  $user
     * @param  array<string>  $content
     */
    public function __construct(array $user, array $content)
    {
        $this->user = $user;
        $this->content = $content;
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
