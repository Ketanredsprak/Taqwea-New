<?php

namespace App\Providers;

use App\Providers\ClassCompletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyClassCompleted
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
     * @param  ClassCompletedEvent  $event
     * @return void
     */
    public function handle(ClassCompletedEvent $event)
    {
        //
    }
}
