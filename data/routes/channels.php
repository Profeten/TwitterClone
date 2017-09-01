<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('tweets', function ($user) {
    if (Auth::check())
    {
        return [ 'id' => $user->id, 'name' => $user->name ];
    }
});
