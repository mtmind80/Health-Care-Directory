<?php

namespace App\Listeners;

use App\Events\ProviderHasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use \App\Log;

class LogProviderModification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProviderHasChanged $event
     * @return void
     */
    public function handle(ProviderHasChanged $event)
    {
        $data = [
            'provider_id' => $event->providerId,
            'action_id'   => $event->actionId,
            'user_id'     => $event->userId,
            'json_data'   => $event->jsonData,
            'comment'     => $event->comment,
        ];

        Log::create($data);
    }
}
