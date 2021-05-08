<?php

namespace App\Events;

use App\UserActivity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $type;
    public $description;
    public $reference;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reference, $description, $type, $user = null)
    {
        $this->reference = strtoupper($reference);
        $this->description = strtolower($description);
        $this->type = strtolower($type);
        $this->user = $user ?? auth()->user();
        if (!$this->user->log) {
            $this->storeActivity();
        }
    }
    private function storeActivity()
    {
        return UserActivity::create(
            [
            'reference'   => $this->reference,
            'description' => $this->description,
            'type' => $this->type,
            'user_id'     => $this->user->id,
            ]
        );
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
