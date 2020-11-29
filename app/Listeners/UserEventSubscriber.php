<?php

namespace App\Listeners;

use App\Events\UserAccountCreated;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;

class UserEventSubscriber
{
    public function handleUserAccountCreated(UserAccountCreated $event)
    {
        $event->user->profile()->create();
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            UserAccountCreated::class,
            [UserEventSubscriber::class, 'handleUserAccountCreated']
        );
    }
}
