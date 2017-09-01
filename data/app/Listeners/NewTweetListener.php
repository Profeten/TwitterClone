<?php

namespace App\Listeners;

use App\Events\NewTweet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTweetListener
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
     * @param  NewTweet  $event
     * @return void
     */
    public function handle(NewTweet $event)
    {
        //
    }
}
