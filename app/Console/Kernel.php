<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            // event(new \App\Events\TaskIsDue('Charles Dickens', 'josei.vidal@yahoo.com', 'Testing again', 'Ago. 8 2016'));

            $tasks = \App\Task::shouldBeRemainded()->get();

            if ($tasks->count()) {
                foreach ($tasks as $task) {
                    event(new \App\Events\TaskIsDue($task->assignedTo->fullName, $task->assignedTo->email, $task->title, $task->due_at->format('m/d/Y')));

                    $task->reminder_sent = true;
                    $task->save();
                }
            }
        })->daily()->at('8:00')->timezone('America/New_York');
        //})->everyFiveMinutes();
    }
}
