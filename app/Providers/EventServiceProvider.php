<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogLoggedInUser',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogLoggedOutUser',
        ],

        'App\Events\ProviderHasChanged' => [
            'App\Listeners\LogProviderModification',
        ],

        'App\Events\TaskIsDue' => [
            'App\Listeners\SendTaskRemainder',
        ],

    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
