<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProviderHasChanged extends Event
{
    use SerializesModels;

    public $providerId,
           $actionId,
           $userId,
           $jsonData,
           $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($providerId, $actionId, $userId, $jsonData, $comment = '')
    {
        $this->providerId = $providerId;
        $this->actionId = $actionId;
        $this->userId = $userId;
        $this->jsonData = $jsonData;
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
