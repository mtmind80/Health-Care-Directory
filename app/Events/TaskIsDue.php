<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskIsDue extends Event
{
    use SerializesModels;

    public $userFullName,
           $userEmail,
           $taskTitle,
           $dueAt;

    public function __construct($userFullName, $userEmail, $taskTitle, $dueAt)
    {
        $this->userFullName = $userFullName;
        $this->userEmail = $userEmail;
        $this->taskTitle = $taskTitle;
        $this->dueAt = $dueAt;
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
