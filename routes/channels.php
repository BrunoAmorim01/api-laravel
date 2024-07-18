<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('channel_for_everyone', function ($user, $id) {
    //return (int) $user->id === (int) $id;
    return true;
});
