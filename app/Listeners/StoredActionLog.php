<?php

namespace App\Listeners;

use App\Log;
use App\Events\EventUserLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoredActionLog
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
     * @param  object  $event
     * @return void
     */
    public function handle(EventUserLog $event)
    {
        Log::create(['data' => $event->data->toJson()]);
    }
}
