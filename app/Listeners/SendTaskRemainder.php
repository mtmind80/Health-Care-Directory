<?php

namespace App\Listeners;

use App\Events\TaskIsDue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskRemainder implements ShouldQueue
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

    public function handle(TaskIsDue $event)
    {
        $config = (new \App\Config)->fetch();

        $config['userEmail'] = $event->userEmail;

        $tags = [
            'site_url' => rtrim(env('SITE_URL'), '/'),
            'config'   => $config,
            'content'  => "<p>Hello " . $event->userFullName . ",</p><p>You have requested to be notified today that the task <strong>" . $event->taskTitle . "</strong> assigned to you is due by " . $event->dueAt . ".</p><p>Best,</p><p>JIPA Team</p>",
        ];
        \Mail::send('emails.notification', $tags, function ($message) use ($config) {
            $message
                ->from($config['adminEmail'], $config['company'])
                ->to(env('EMAIL_LOCAL', $config['userEmail']))
                ->subject('Task due remainder.');
        });
    }
}
